<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Pegawai;
use App\Models\Jabatan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Style\Language;
use ZipArchive;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\TemplateProcessor;


class DisiplinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        // return view('disiplin.index');
        $id_satker_sikep= $request->input('filter_satker');
        $bulan = $request->input('filter_bulan');
        $tahun = $request->input('filter_tahun');

        if (!$bulan) {
            $kurangi = $this->kurangi_bulan(date('m'), date('Y'));
            $bulan = $kurangi['bulan'];
            $tahun = $kurangi['tahun'];
        }

        if (!$id_satker_sikep){
            $id_satker_sikep = DB::table('satkers')
            ->where('id', Auth::user()->satker_id)
            ->value('id_satker_sikep');
        }

        $id_list = DB::table('satkers')
        ->where('id', Auth::user()->satker_id)
        ->value('id_satker_sikep');
        
        if ($id_list=='520')
        {
            $list_satker = DB::table('satkers')
            ->get();
        }else{
            $list_satker = DB::table('satkers')
            ->where('id',Auth::user()->satker_id)
            ->get();
        }



        // $data = Pegawai::where('deleted', 0)
        // ->where('id_satker',$id_satker_sikep)
        // ->where('is_hakim','1')->get();
        
        // dd ($bulan);
        $list_bulan = $this->list_bulan();

        $data = DB::table('pegawai')
            ->leftJoin('disiplin_hakim', function($join) use ($bulan, $tahun) {
                $join->on('pegawai.nip', '=', 'disiplin_hakim.nip')
                    ->where('disiplin_hakim.bulan', '=', $bulan)
                    ->where('disiplin_hakim.tahun', '=', $tahun);
            })
            ->select(
                'pegawai.nip',
                'pegawai.gelar_depan',
                'pegawai.nama_lengkap',
                'pegawai.gelar_belakang',
                'pegawai.jabatan',
                'pegawai.satker',
                'pegawai.id_satker',
                'disiplin_hakim.id',
                'disiplin_hakim.t',
                'disiplin_hakim.tam',
                'disiplin_hakim.pa',
                'disiplin_hakim.tap',
                'disiplin_hakim.kti',
                'disiplin_hakim.tk',
                'disiplin_hakim.tms',
                'disiplin_hakim.pembinaan',
                'disiplin_hakim.keterangan',
                'disiplin_hakim.bulan',
                'disiplin_hakim.tahun'
            )
            ->where('pegawai.id_satker', $id_satker_sikep)
            ->where('pegawai.is_hakim', '1')
            ->get();

    
        return view('disiplin.index', ([
            'data' => $data,
            'list_bulan' => $list_bulan,
            'list_tahun' => $this->list_tahun(),
            'bulan'      => $bulan,
            'tahun'      => $tahun,
            'list_satker'      => $list_satker,
            'id_satker' =>$id_satker_sikep
        ]));
    }


    public function list_bulan() {
        $bulan = [
            1 => "Januari",
            2 => "Februari",
            3 => "Maret",
            4 => "April",
            5 => "Mei",
            6 => "Juni",
            7 => "Juli",
            8 => "Agustus",
            9 => "September",
            10 => "Oktober",
            11 => "November",
            12 => "Desember"
        ];
        return $bulan;
    }

    public function list_tahun() {
        $tahunSekarang = date('Y');
        $tahun = [];

        for ($i = 0; $i <= 5; $i++) {
            $tahun[] = $tahunSekarang - $i;
        }

        return $tahun;
    }

    public function kurangi_bulan($bulan, $tahun) {
        if ($bulan == 1) { // Jika bulan Januari
            $bulan = 12; // Kembali ke Desember
            $tahun--; // Kurangi tahun
        } else {
            $bulan--; // Kurangi bulan
        }
        return [
            'bulan' => $bulan,
            'tahun' => $tahun,
        ];
    }

 
    
    public function isiSemua(Request $request)
    {
        
        $id_satker = $request->input('id_satker');
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        if (!$bulan) {
            $kurangi = $this->kurangi_bulan(date('m'), date('Y'));
            $bulan = $kurangi['bulan'];
            $tahun = $kurangi['tahun'];
            $id_satker = DB::table('satkers')
            ->where('id', Auth::user()->satker_id)
            ->value('id_satker_sikep');
        }

        // dd($id_satker);
        // Cari semua pegawai hakim di satker tsb
        $pegawai = DB::table('pegawai')
            ->where('id_satker', $id_satker)
            ->where('is_hakim', '1')
            ->get();
    
        foreach ($pegawai as $peg) {
            // Cek apakah sudah ada data disiplin_hakim untuk bulan dan tahun tersebut
            $disiplin = DB::table('disiplin_hakim')
                ->where('nip', $peg->nip)
                ->where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->first();
    
            if (!$disiplin) {
                // Kalau belum ada → insert baru
                DB::table('disiplin_hakim')->insert([
                    'nip' => $peg->nip,
                    'nama' => $peg->gelar_depan .' '. $peg->nama_lengkap. ' '. $peg->gelar_belakang,
                    'jabatan' => $peg->jabatan,
                    'jabatan' => $peg->jabatan,
                    'id_satker' => $peg->id_satker,
                    'satker' => $peg->satker,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    't' => 0,
                    'tam' => 0,
                    'pa' => 0,
                    'tap' => 0,
                    'kti' => 0,
                    'tk' => 0,
                    'tms' => 0,
                    'pembinaan' => '-', // isi default, bisa diubah
                    'keterangan' => '-',
                    'is_locked' =>'0',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                // Kalau sudah ada → update data jadi nol
                DB::table('disiplin_hakim')
                    ->where('id', $disiplin->id)
                    ->update([
                        't' => 0,
                        'tam' => 0,
                        'pa' => 0,
                        'tap' => 0,
                        'kti' => 0,
                        'tk' => 0,
                        'tms' => 0,
                        'pembinaan' => '-',
                        'keterangan' => '-',
                        'updated_at' => now(),
                    ]);
            }
        }
    
        return redirect()->back()->with('status', 'Data berhasil diisi semua.');
    }
    

    public function downloadLaporan(Request $request)
    {

        $id_satker= $request->input('filter_satker');
        $bulan = $request->input('filter_bulan');
        $tahun = $request->input('filter_tahun');
        if (!$bulan) {
            $kurangi = $this->kurangi_bulan(date('m'), date('Y'));
            $bulan = $kurangi['bulan'];
            $tahun = $kurangi['tahun'];
        }

        

        if (!$id_satker){
            $id_satker = DB::table('satkers')
            ->where('id', Auth::user()->satker_id)
            ->value('id_satker_sikep');
        }

        $satkerNama = DB::table('satkers')->where('id_satker_sikep', $id_satker)->value('nama_satker'); // ambil nama satker
        if (!$satkerNama) {
            $satkerNama = 'Satker Tidak Diketahui';
        }
        
        $satkerNama=Str::title($satkerNama);
        
        $data = DB::table('pegawai')
            ->leftJoin('disiplin_hakim', function($join) use ($bulan, $tahun) {
                $join->on('pegawai.nip', '=', 'disiplin_hakim.nip')
                     ->where('disiplin_hakim.bulan', '=', $bulan)
                     ->where('disiplin_hakim.tahun', '=', $tahun);
            })
            ->select(
                'pegawai.nip',
                'pegawai.gelar_depan',
                'pegawai.nama_lengkap',
                'pegawai.gelar_belakang',
                'pegawai.jabatan',
                'pegawai.satker',
                'pegawai.id_satker',
                'disiplin_hakim.t',
                'disiplin_hakim.tam',
                'disiplin_hakim.pa',
                'disiplin_hakim.tap',
                'disiplin_hakim.kti',
                'disiplin_hakim.tk',
                'disiplin_hakim.tms',
                'disiplin_hakim.pembinaan',
                'disiplin_hakim.keterangan'
            )
            ->where('pegawai.id_satker', $id_satker)
            ->where('pegawai.is_hakim', '1')
            ->get();
        
        // dd($data);
        // $ketua = (collect($data)->contains('Ketua Pengadilan'));

        $tanggalSekarang = now()->translatedFormat('d F Y');

        // ambil data nama ketua
        $dataKetua = DB::table('pegawai')
        ->select('nama_lengkap')
        ->where('jabatan','Ketua Pengadilan')
        ->where('id_satker',$id_satker)
        ->first(); 
        
        $namaKetua = mb_convert_encoding($dataKetua->nama_lengkap, 'UTF-8', 'auto');
        // Path template jika satker pta
        if ($id_satker=='520'){
            $templatePengantarPath = public_path('template/pengantar_laporan_disiplin_hakim.docx');
        }else{
            $templatePengantarPath = public_path('template/pengantar_laporan_disiplin_hakim_satker.docx');
        }
        $templateLaporanPath = public_path('template/laporan_disiplin_hakim.docx');

        // Konversi bulan
        $bulan = $this->bulanIndonesia($bulan);

        // Generate Surat Pengantar
        $pengantar = new TemplateProcessor($templatePengantarPath);
        $pengantar->setValues([
            'satker' => $satkerNama,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'tanggal' => $tanggalSekarang,
            'ketua' => $namaKetua,
        ]);
        $pathPengantar = storage_path('app/public/surat_pengantar.docx');
        $pengantar->saveAs($pathPengantar);

        // Generate Laporan Disiplin
        $laporan = new TemplateProcessor($templateLaporanPath);
        $laporan->cloneRow('no', count($data));
        // $laporan->setValue('satker',$satkerNama);

        foreach ($data as $index => $item) {
            $nama_pegawai=$item->gelar_depan.' '. $item->nama_lengkap .' '. $item->gelar_belakang;
            
            $laporan->setValue("no#".($index+1), $index + 1);
            $laporan->setValue("nama#".($index+1), $nama_pegawai);
            $laporan->setValue("nip#".($index+1), $item->nip);
            $laporan->setValue("jabatan#".($index+1), $item->jabatan);
            $laporan->setValue("satuan_kerja#".($index+1), $item->satker);
            $laporan->setValue("t#".($index+1), ($item->t === null ? "null" : ($item->t == 0 ? "-" : $item->t)));
            $laporan->setValue("tam#".($index+1), ($item->tam === null ? 'null' :($item->tam==0 ? "-": $item->tam)));
            $laporan->setValue("pa#".($index+1), ($item->pa === null ? 'null' :($item->pa==0 ? "-": $item->pa)));
            $laporan->setValue("tap#".($index+1), ($item->tap === null ? 'null' :($item->tap==0 ? "-": $item->tap)));
            $laporan->setValue("kti#".($index+1), ($item->kti === null ? 'null' :($item->kti==0 ? "-": $item->kti)));
            $laporan->setValue("tk#".($index+1), ($item->tk === null ? 'null' :($item->tk==0 ? "-": $item->tk)));
            $laporan->setValue("tms#".($index+1), ($item->tms === null ? 'null' :($item->tms==0 ? "-": $item->tms)));

            $laporan->setValue("pembinaan#".($index+1), $item->pembinaan);
            $laporan->setValue("keterangan#".($index+1), $item->keterangan);
        }
        // $laporan->setValue('ketua',$namaKetua);
        $laporan->setValues([
            'satker' => $satkerNama,
            // 'bulan' => Str::upper($bulan),
            'bulan' => $bulan,
            'tahun' => $tahun,
            'ketua' => $namaKetua,
        ]);

        $pathLaporan = storage_path('app/public/laporan_disiplin.docx');
        $laporan->saveAs($pathLaporan);
    
       
    
        /** ZIP */
        $zipFileName = 'laporan_disiplin_' . now()->format('Ymd_His') . '.zip';
        $zipPath = storage_path('app/public/' . $zipFileName);
    
        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            $zip->addFile($pathPengantar, 'Surat Pengantar.docx');
            $zip->addFile($pathLaporan, 'Laporan Disiplin Hakim.docx');
            $zip->close();
        }
    
        // Bersihkan file Word setelah zip selesai (opsional)
        File::delete([$pathPengantar, $pathLaporan]);
        // File::delete([$pathPengantar]);
    
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
    

    public function edit($id)
    {
        // $disiplin = DisiplinHakim::with('pegawai')->findOrFail($id);

        $data = DB::table('disiplin_hakim')
        ->where('id',$id)
        ->first();
        


        return response()->json([
            // 'nama' => $data->gelar_depan . ' ' . $data->nama_lengkap . ' ' . $data->gelar_belakang,
            'nama' => $data->nama,
            'jabatan' => $data->jabatan,
            't' => $data->t,
            'tam' => $data->tam,
            'pa' => $data->pa,
            'tap' => $data->tap,
            'kti' => $data->kti,
            'tk' => $data->tk,
            'tms' => $data->tms,
            'pembinaan' => $data->pembinaan,
            'keterangan' => $data->keterangan
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            't' => 'nullable|integer',
            'tam' => 'nullable|integer',
            'pa' => 'nullable|integer',
            'tap' => 'nullable|integer',
            'kti' => 'nullable|integer',
            'tk' => 'nullable|integer',
            'tms' => 'nullable|integer',
            'bentuk_pembinaan' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);
        $disiplin= DB::table('disiplin_hakim')
        ->where('id', $id)
        ->update([
            't' => $request->t,
            'tam' => $request->tam,
            'pa' => $request->pa,
            'tap' => $request->tap,
            'kti' => $request->kti,
            'tk' => $request->tk,
            'tms' => $request->tms,
            'pembinaan' => $request->bentuk_pembinaan,
            'keterangan' => $request->keterangan,
            'updated_at' => now(),
        ]);
        
        return response()->json(['success' => 'Data disiplin berhasil diperbarui']);
    }

    public function bulanIndonesia($angka) {
        try {
            return Carbon::create()->month($angka)->locale('id')->monthName;
        } catch (\Exception $e) {
            return 'Bulan tidak valid';
        }
    }

    public function rekapitulasi(Request $request){
        // return view('disiplin.index');
        // $id_satker_sikep= $request->input('filter_satker');
        $bulan = $request->input('filter_bulan');
        $tahun = $request->input('filter_tahun');
        if (!$bulan) {
            $kurangi = $this->kurangi_bulan(date('m'), date('Y'));
            $bulan = $kurangi['bulan'];
            $tahun = $kurangi['tahun'];
        }

        $id_list = DB::table('satkers')
        ->where('id', Auth::user()->satker_id)
        ->value('id_satker_sikep');
        
        if ($id_list=='520')
        {
            $list_satker = DB::table('satkers')
            ->get();
        }else{
            $list_satker = DB::table('satkers')
            ->where('id',Auth::user()->satker_id)
            ->get();
        }


        // dd ($bulan);
        $list_bulan = $this->list_bulan();

        $data = DB::table('pegawai')
            ->leftJoin('disiplin_hakim', function($join) use ($bulan, $tahun) {
                $join->on('pegawai.nip', '=', 'disiplin_hakim.nip')
                    ->where('disiplin_hakim.bulan', '=', $bulan)
                    ->where('disiplin_hakim.tahun', '=', $tahun);
            })
            ->select(
                'pegawai.nip',
                'pegawai.gelar_depan',
                'pegawai.nama_lengkap',
                'pegawai.gelar_belakang',
                'pegawai.jabatan',
                'pegawai.satker',
                'pegawai.id_satker',
                'disiplin_hakim.id',
                'disiplin_hakim.t',
                'disiplin_hakim.tam',
                'disiplin_hakim.pa',
                'disiplin_hakim.tap',
                'disiplin_hakim.kti',
                'disiplin_hakim.tk',
                'disiplin_hakim.tms',
                'disiplin_hakim.pembinaan',
                'disiplin_hakim.keterangan',
                'disiplin_hakim.bulan',
                'disiplin_hakim.tahun'
            )
            // ->where('pegawai.id_satker', $id_satker_sikep)
            ->where('pegawai.is_hakim', '1')
            ->where('pegawai.jabatan', 'Ketua Pengadilan')
            // ->where('pegawai.id_satker','<>','520')
            ->get();

    
        return view('disiplin.rekapitulasi', ([
            'data' => $data,
            'list_bulan' => $list_bulan,
            'list_tahun' => $this->list_tahun(),
            'bulan'      => $bulan,
            'tahun'      => $tahun,
            'list_satker'      => $list_satker,
            // 'id_satker' =>$id_satker_sikep
        ]));
    }

    public function store(Request $request){

        $id_satker= $request->input('id_satker_kirim');
        $bulan = $request->input('kirim_bln');
        $tahun = $request->input('kirim_thn');
        if (!$bulan) {
            $kurangi = $this->kurangi_bulan(date('m'), date('Y'));
            $bulan = $kurangi['bulan'];
            $tahun = $kurangi['tahun'];
        }

        

        if (!$id_satker){
            $id_satker = DB::table('satkers')
            ->where('id', Auth::user()->satker_id)
            ->value('id_satker_sikep');
        }
                    
            
            $file = $request->file('file');

            // Nama file berdasarkan id_satker dan timestamp
            $filename = $request->id_satker . '_' . now()->format('Ymd_His') . '.' . $file->getClientOriginalExtension();
        
            // Simpan file ke folder public/laporan
            $file->move(public_path('laporan'), $filename);


            //cari apakah sudah ada laporan pada bulan dan tahun
            $data = DB::table('rekapitulasi_disiplin_hakim')
                ->where('id_satker', $id_satker)
                ->where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->first();
                // dd($data);
            if (!$data)
            {
                DB::table('rekapitulasi_disiplin_hakim')->insert([
                    'id_satker' => $id_satker,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'file' => $filename,
                    'updated_at' => now(),
                    // 'created_by' => auth()->id(),
                ]);
            
            }else{
                DB::table('rekapitulasi_disiplin_hakim')
                ->where('id', $data->id)
                ->update([
                    'id_satker' => $id_satker,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'file' => $filename,
                    'updated_at' => now(),
                    // 'created_by' => auth()->id(),
                ]);
            }
            
            return redirect()->back()->with('success', 'Laporan berhasil dikirim.');
            // return redirect()->back()->with('status', 'Data berhasil diisi semua.');
        
    
        
    }

    public function downloadRekapLaporan(Request $request)
    {

        // $id_satker= $request->input('filter_satker');
        $bulan = $request->input('filter_bulan');
        $tahun = $request->input('filter_tahun');
        if (!$bulan) {
            $kurangi = $this->kurangi_bulan(date('m'), date('Y'));
            $bulan = $kurangi['bulan'];
            $tahun = $kurangi['tahun'];
        }

        

       
            $id_satker = DB::table('satkers')
            ->where('id', Auth::user()->satker_id)
            ->value('id_satker_sikep');
        

        $satkerNama = DB::table('satkers')->where('id_satker_sikep', $id_satker)->value('nama_satker'); // ambil nama satker
        if (!$satkerNama) {
            $satkerNama = 'Satker Tidak Diketahui';
        }
        $satkerNama = Str::title($satkerNama);
        $data = DB::table('pegawai')
            ->leftJoin('disiplin_hakim', function($join) use ($bulan, $tahun) {
                $join->on('pegawai.nip', '=', 'disiplin_hakim.nip')
                     ->where('disiplin_hakim.bulan', '=', $bulan)
                     ->where('disiplin_hakim.tahun', '=', $tahun);
                     
            })
            ->select(
                'pegawai.nip',
                'pegawai.gelar_depan',
                'pegawai.nama_lengkap',
                'pegawai.gelar_belakang',
                'pegawai.jabatan',
                'pegawai.satker',
                'pegawai.id_satker',
                'disiplin_hakim.t',
                'disiplin_hakim.tam',
                'disiplin_hakim.pa',
                'disiplin_hakim.tap',
                'disiplin_hakim.kti',
                'disiplin_hakim.tk',
                'disiplin_hakim.tms',
                'disiplin_hakim.pembinaan',
                'disiplin_hakim.keterangan'
            )
            ->where('pegawai.jabatan', 'Ketua Pengadilan')
            ->where('pegawai.is_hakim', '1')
            ->where('pegawai.id_satker','<>','520')
            ->get();
        
        // dd($data);
        // $ketua = (collect($data)->contains('Ketua Pengadilan'));

        $tanggalSekarang = now()->translatedFormat('d F Y');

        // ambil data nama ketua
        $dataKetua = DB::table('pegawai')
        ->select('nama_lengkap')
        ->where('jabatan','Ketua Pengadilan')
        ->where('id_satker','520')
        ->first(); 
        
        $namaKetua = mb_convert_encoding($dataKetua->nama_lengkap, 'UTF-8', 'auto');
        // Path template jika satker pta
        if ($id_satker=='520'){
            $templatePengantarPath = public_path('template/pengantar_laporan_disiplin_hakim.docx');
        }else{
            $templatePengantarPath = public_path('template/pengantar_laporan_disiplin_hakim_satker.docx');
        }
        $templateLaporanPath = public_path('template/laporan_disiplin_hakim_rekap.docx');

        // Konversi bulan
        $bulan = $this->bulanIndonesia($bulan);

        // Generate Surat Pengantar
        $pengantar = new TemplateProcessor($templatePengantarPath);
        $pengantar->setValues([
            'satker' => $satkerNama,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'tanggal' => $tanggalSekarang,
            'ketua' => $namaKetua,
        ]);
        $pathPengantar = storage_path('app/public/surat_pengantar.docx');
        $pengantar->saveAs($pathPengantar);

        // Generate Laporan Disiplin
        $laporan = new TemplateProcessor($templateLaporanPath);
        $laporan->cloneRow('no', count($data));
        // $laporan->setValue('satker',$satkerNama);

        foreach ($data as $index => $item) {
            $nama_pegawai=$item->gelar_depan.' '. $item->nama_lengkap .' '. $item->gelar_belakang;
            
            $laporan->setValue("no#".($index+1), $index + 1);
            $laporan->setValue("nama#".($index+1), $nama_pegawai);
            $laporan->setValue("nip#".($index+1), $item->nip);
            $laporan->setValue("jabatan#".($index+1), $item->jabatan);
            $laporan->setValue("satuan_kerja#".($index+1), $item->satker);
            $laporan->setValue("t#".($index+1), ($item->t === null ? "null" : ($item->t == 0 ? "-" : $item->t)));
            $laporan->setValue("tam#".($index+1), ($item->tam === null ? 'null' :($item->tam==0 ? "-": $item->tam)));
            $laporan->setValue("pa#".($index+1), ($item->pa === null ? 'null' :($item->pa==0 ? "-": $item->pa)));
            $laporan->setValue("tap#".($index+1), ($item->tap === null ? 'null' :($item->tap==0 ? "-": $item->tap)));
            $laporan->setValue("kti#".($index+1), ($item->kti === null ? 'null' :($item->kti==0 ? "-": $item->kti)));
            $laporan->setValue("tk#".($index+1), ($item->tk === null ? 'null' :($item->tk==0 ? "-": $item->tk)));
            $laporan->setValue("tms#".($index+1), ($item->tms === null ? 'null' :($item->tms==0 ? "-": $item->tms)));

            $laporan->setValue("pembinaan#".($index+1), $item->pembinaan);
            $laporan->setValue("keterangan#".($index+1), $item->keterangan);
        }
        // $laporan->setValue('ketua',$namaKetua);
        $laporan->setValues([
            'satker' => $satkerNama,
            // 'bulan' => Str::upper($bulan),
            'bulan' => $bulan,
            'tahun' => $tahun,
            'ketua' => $namaKetua,
        ]);

        $pathLaporan = storage_path('app/public/laporan_disiplin.docx');
        $laporan->saveAs($pathLaporan);
    
       
    
        /** ZIP */
        $zipFileName = 'laporan_disiplin_' . now()->format('Ymd_His') . '.zip';
        $zipPath = storage_path('app/public/' . $zipFileName);
    
        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            $zip->addFile($pathPengantar, 'Surat Pengantar.docx');
            $zip->addFile($pathLaporan, 'Laporan Disiplin Hakim.docx');
            $zip->close();
        }
    
        // Bersihkan file Word setelah zip selesai (opsional)
        File::delete([$pathPengantar, $pathLaporan]);
        // File::delete([$pathPengantar]);
    
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

}
