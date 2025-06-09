<?php

namespace App\Http\Controllers;

use App\Models\SuratTugas;
use App\Models\SuratTugasPegawai;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\TemplateProcessor;
use Carbon\Carbon;
use ZipArchive;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SuratTugasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
    {
        
        $tanggal = $request->input('tanggal');

        $query = DB::table('surat_tugas');
        if ($tanggal) {
            $query->where('tgl_awal', '<=', $tanggal)
                  ->where('tgl_akhir', '>=', $tanggal);
        }
        $data = $query->orderBy('id','desc')->get();

         foreach ($data as $item) {
            $pegawai = DB::table('surat_tugas_pegawai')
                ->join('pegawai', 'pegawai.nip', '=', 'surat_tugas_pegawai.pegawai_id')
                ->where('surat_tugas_id', $item->id)
                ->pluck('kelompok_jabatan');

            $jabatan_plh = ['Ketua Pengadilan', 'Wakil Ketua Pengadilan', 'Panitera', 'Sekretaris'];

            $item->plh = $pegawai->contains(function ($jabatan) use ($jabatan_plh) {
                return in_array($jabatan, $jabatan_plh);
            });
        }
     
        return view('st.index', ([
            'data' => $data,
            'tanggal' => $tanggal
        ]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        // $user = User::where('jabatan', 'Ketua')
        //     ->orwhere('jabatan', 'Wakil Ketua')
        //     ->orwhere('jabatan', 'Hakim Tinggi')
        //     ->orwhere('jabatan', 'Sekretaris')
        //     ->orwhere('jabatan', 'Panitera')
        //     ->get();
        $pegawaiList = DB::table('pegawai')->get();

        $user = DB::table('pegawai')
        ->where('id_satker', '520')
        ->whereIn('kelompok_jabatan', ['Ketua Pengadilan', 'Wakil Ketua Pengadilan', 'Hakim', 'Panitera', 'Sekretaris','Kepala Bagian'])
        ->get();
        return view('st.tambah', (['user' => $user, 'pegawaiList' => $pegawaiList]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'nomor_st' => 'Required',
            'tgl_st' => 'required|date',
            'menimbang' => 'required|string|max:350',
            'maksud' => 'required|string|max:250',
            'instansi' => 'required|string|max:150',
            'kota' => 'required|string|max:150',
            'alamat' => 'required|string|max:350',
            'tgl_awal' => 'Required|date|after_or_equal:tgl_st',
            'tgl_akhir' => 'Required|date|after_or_equal:tgl_awal',
            'waktu_mulai' => 'Required',
            'pejabat' => 'Required',
            'pegawai_id' => 'required|array|min:1',

        ]);

        // dd($request->all());
        if ($request->dipa == "on") {
            $dipa = "1";
        } else {
            $dipa = "0";
        }

        DB::beginTransaction();

        try {

            $instansi = Str::title($request->instansi);
                $st = SuratTugas::create([
                'no_surat_tugas' => $request->nomor_st,
                'tgl_surat_tugas' => $request->tgl_st,
                'menimbang' => $request->menimbang,
                'maksud' => $request->maksud,
                'instansi_tujuan' => $instansi,
                'kota_tujuan' => $request->kota,
                'alamat_tujuan' => $request->alamat,
                'tgl_awal' => $request->tgl_awal,
                'tgl_akhir' => $request->tgl_akhir,
                'pejabat' => $request->pejabat,
                'dipa' => $dipa,
            ]);

            // dd($request->pegawai_id);
            // Simpan pegawai yang ditugaskan
                foreach ($request->pegawai_id as $pegawaiId) {
                   
                    SuratTugasPegawai::create([
                        'surat_tugas_id' => $st->id,
                        'pegawai_id' => $pegawaiId
                    ]);
                }
            
            DB::commit();
            return redirect('/surattugas')->with('success', 'Surat Tugas Berhasil Disimpan..!');

        }catch(\Exception $e){
            DB::rollback();
            // return back()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()]);
            return back()->with('error', 'Error, Data Gagal Disimpan ..! ' . $e->getMessage());
        }
        
    }

    public function menimbang(Request $request){
        $search = $request->get('term');
    
         $results = DB::table('surat_tugas_auto')->where('menimbang', 'LIKE', '%'. $search. '%')
        ->take(10)
        ->pluck('menimbang');

        return response()->json($results);
    }
    public function maksud(Request $request){
        $search = $request->get('term');
    
         $results = DB::table('surat_tugas_auto')->where('maksud', 'LIKE', '%'. $search. '%')
        ->take(10)
        ->pluck('maksud');

        return response()->json($results);
    }
    public function instansi(Request $request){
        $search = $request->get('term');
    
         $results = DB::table('satkers')->where('nama_satker', 'LIKE', '%'. $search. '%')
        ->take(10)
        ->pluck('nama_satker');

        return response()->json($results);
    }
    public function instansi_alamat(Request $request){
        $search = $request->get('term');
    
         $results = DB::table('satkers')->where('alamat_satker', 'LIKE', '%'. $search. '%')
        ->take(10)
        ->pluck('alamat_satker');

        return response()->json($results);
    }
    public function nomor_st(Request $request){
        $search = $request->get('term');
    
         $results = DB::table('surat_tugas_auto')->where('nomor_st', 'LIKE', '%'. $search. '%')
        ->take(10)
        ->pluck('nomor_st');

        return response()->json($results);
    }

    public function ajax(Request $request)
    {
       $query = DB::table('pegawai')
        ->select([
            'id',
            'nama_lengkap',
            'nip',
            'jabatan',
            'satker',
        ])
        ->orderBy('id');

    return DataTables::of($query)
        ->addIndexColumn() // 
        ->addColumn('aksi', function ($row) {
            return '<button type="button" class="btn btn-success btn-sm" onclick="tambahPegawaiAjax('
               . '\''  . e($row->nip) . '\', \''  . e($row->nama_lengkap) . '\', \'' . e($row->nip) . '\', \'' . e($row->jabatan) . '\', \'' . e($row->satker) . '\')">Pilih</button>';
        })
        ->rawColumns(['aksi'])
        ->make(true);
    }

    public function ajaxppnpn(Request $request)
{
    $query = DB::table('users')
        ->join('satkers', 'users.satker_id', '=', 'satkers.id')
        ->select(
            'users.id',
            'users.name',
            'users.username',
            'users.jabatan',
            'satkers.nama_satker as satker'
        )
        ->where('users.jabatan', 'PPNPN');

    // Handle server-side DataTables processing
    return DataTables::of($query)
        ->addIndexColumn()
        ->filter(function ($query) use ($request) {
            // Add search functionality
            if ($request->has('search') && !empty($request->search['value'])) {
                $search = $request->search['value'];
                $query->where(function($q) use ($search) {
                    $q->where('users.name', 'LIKE', "%{$search}%")
                      ->orWhere('users.username', 'LIKE', "%{$search}%")
                      ->orWhere('users.jabatan', 'LIKE', "%{$search}%")
                      ->orWhere('satkers.nama_satker', 'LIKE', "%{$search}%");
                });
            }
        })
        ->addColumn('aksi', function ($row) {
            return '<button type="button" class="btn btn-success btn-sm" onclick="tambahPPNPNAjax('
                . '\'' 
                . e($row->username) . '\', \'' 
                . e($row->name) . '\', \'' 
                // . e($row->name) . '\', \'' 
                . e($row->jabatan) . '\', \'' 
                . e($row->satker) . '\')">Pilih</button>';
        })
        ->rawColumns(['aksi'])
        ->make(true);
    }

    public function getPegawaiST($id){
        try{
            // Ambil NIP pegawai yang terkait dengan surat tugas ini
            $nipList = SuratTugasPegawai::where('surat_tugas_id', $id)
                ->pluck('pegawai_id')
                ->toArray();

            if (empty($nipList)) {
                return response()->json([
                    'success' => true,
                    'pegawai' => [],
                    'total' => 0,
                    'message' => 'Tidak ada pegawai yang ditunjuk'
                ]);
            }

             // Cari data pegawai dari tabel pegawai atau user
            $pegawaiData = DB::table('pegawai')->whereIn('nip', $nipList)
                ->get()
                ->map(function ($item) {
                    return [
                        'nip' => $item->nip,
                        'nama_lengkap' => $item->nama_lengkap ?? '-',
                        'jabatan' => $item->jabatan ?? '-',
                        'satker' => $item->satker ?? '-',
                        'source' => 'pegawai' // Untuk identifikasi sumber data
                    ];
                });
                // ->keyBy('nip'); // Gunakan NIP sebagai key

            

            // Cari data yang belum ditemukan di tabel pegawai
            $missingNips = array_diff($nipList, $pegawaiData->keys()->toArray());

            // dd($missingNips);
            

            if (!empty($missingNips)){
                $ppnpn = DB::table('users')->wherein('username',$missingNips)
                ->leftjoin('satkers','satkers.id','=','users.satker_id')
                ->where('users.jabatan','=','PPNPN')
                ->select(
                    'users.username',
                    'users.name',
                    'users.jabatan',
                    'satkers.nama_satker'
                )
                ->get()
                ->map(function($item){
                    return [
                        // 'username' => $item->username,
                        'nip' => '-' ?? '-',
                        'nama_lengkap' => $item->name,
                        'jabatan' => $item->jabatan,
                        'satker'=> Str::title($item->nama_satker),
                        'source' => 'ppnpn',
                    ];
                });
            //     // ->keyBy('username'); // Gunakan Username sebagai key

                 $pegawaiData = $pegawaiData->merge($ppnpn);
            }

          
                // dd($listpegawai, $listppnpn);
                // dd($listpegawai);

                return response()->json([
                'success' => true,
                'pegawai' => $pegawaiData,
                // 'ppnpn' => $listppnpn,
                'total' => count($pegawaiData)
            ]);
            // foreach ($list)
           

        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesahalan server : '. $e->getMessage()
            ], 500);

        }
        
    }

    public function downloadST(request $request){
        try{
            $data = SuratTugas::where('id', $request->id_st)
                    ->first();

            $datapejabat= DB::table('pegawai')->where('nip',$data->pejabat)
                ->first();


            $jmlhari = Carbon::parse($data->tgl_awal)->diffInDays($data->tgl_akhir) + 1;
            
            // dd($data->no_surat_tugas);
             $nipList = SuratTugasPegawai::where('surat_tugas_id', $request->id_st)
                ->pluck('pegawai_id')
                ->toArray();

            $pegawaiData = DB::table('pegawai')->whereIn('nip', $nipList)
                ->get()
                ->map(function ($item) {
                    return [
                        'nip' => $item->nip,
                        'nama_lengkap' => $item->gelar_depan.' '.$item->nama_lengkap.', '.$item->gelar_belakang ?? '-',
                        'jabatan' => $item->jabatan ?? '-',
                        'satker' => $item->satker ?? '-',
                        'pangkat' => $item->pangkat ?? '-',
                        'golongan' => $item->golongan ?? '-',
                        'source' => 'pegawai' // Untuk identifikasi sumber data
                    ];
                });
            
            // Cari data yang belum ditemukan di tabel pegawai
            $missingNips = array_diff($nipList, $pegawaiData->keys()->toArray());

            if (!empty($missingNips)){
                $ppnpn = DB::table('users')->wherein('username',$missingNips)
                ->leftjoin('satkers','satkers.id','=','users.satker_id')
                ->where('users.jabatan','=','PPNPN')
                ->select(
                    'users.username',
                    'users.name',
                    'users.jabatan',
                    'satkers.nama_satker'
                )
                ->get()
                ->map(function($item){
                    return [
                        // 'username' => $item->username,
                        'nip' => '-' ?? '-',
                        'nama_lengkap' => $item->name,
                        'jabatan' => $item->jabatan,
                        'satker'=> Str::title($item->nama_satker),
                        'pangkat' => $item->pangkat ?? '-',
                        'golongan' => $item->golongan ?? '-',
                        'source' => 'ppnpn',
                    ];
                });
          
            
            $pegawaiData = $pegawaiData->merge($ppnpn);

            $tanggalSekarang = now()->translatedFormat('d F Y');

            if ($request->jenis_st=='1')
            {
                $templateLaporanPath = public_path('template/st_tanpa_lampiran.docx');
            }elseif ($request->jenis_st=='2')
            {
                $templateLaporanPath = public_path('template/st_dengan_lampiran.docx');
            }elseif ($request->jenis_st=='3' && $data->dipa=='1'){
                $templateLaporanPath = public_path('template/st_dalam_kota.docx');
            }else
            {
                $templateLaporanPath = public_path('template/st_tanpa_lampiran.docx');
            }
            // Generate Surat Tugas
            $st_doc = new TemplateProcessor($templateLaporanPath);


            $st_doc->cloneRow('no', count($pegawaiData));
            $st_doc->setValues([
                    'nomor_st' => $data->no_surat_tugas,
                    'menimbang' => $data->menimbang,
                    'maksud' => $data->maksud,
                    'instansi' => $data->instansi_tujuan,
                    'alamat' => $data->alamat_tujuan,
                    'tgl_ttd' => Carbon::parse($data->tgl_surat_tugas)->format('d-m-Y') ?? '-',
                    'nama_ttd' => $datapejabat->nama_lengkap,
                    'satker' => $datapejabat->satker,
                    'tgl_lampiran' => Carbon::parse($data->tgl_awal)->format('d-m-Y') .' S.D ' . Carbon::parse($data->tgl_akhir)->format('d-m-Y'), 
                    'jabatan' => Str_replace('Pengadilan','',$datapejabat->jabatan)
                ]);
            
            if ($request->jenis_st=='3' && $data->dipa=='1'){
                $st_doc->cloneRow('no_l', count($pegawaiData));
            }
          
            
            // cek DIPA
            if ($data->dipa=='1'){
            $st_doc->setValues([
                    'dipa' => 'Biaya yang timbul pada perjalanan dinas tersebut dibebankan kepada DIPA Pengadilan Tinggi Agama Bandung Tahun Anggaran '. date('Y') . '.',
                ]);
            }else
            {
            $st_doc->setValues([
                'dipa' => ' ',
                ]);
            }

            // Cek jumlah hari
            if ($jmlhari==1){
                $st_doc->setValues([
                    'hari' => $this->getHariIndonesia($data->tgl_awal),
                    'tgl' => Carbon::parse($data->tgl_awal)->format('d-m-Y'),
                    'tgl_awal'=> Carbon::parse($data->tgl_awal)->format('d-m-Y'),

                ]);
            }else
            {
                $st_doc->setValues([
                    'hari' => $this->getHariIndonesia($data->tgl_awal) .' s.d '. $this->getHariIndonesia($data->tgl_akhir),
                    'tgl' => Carbon::parse($data->tgl_awal)->format('d-m-Y') .' s.d '. Carbon::parse($data->tgl_akhir)->format('d-m-Y'),
                    'tgl_awal'=> Carbon::parse($data->tgl_awal)->format('d-m-Y'),
                ]);
            }

            // folder temp buat sementara
            $tempFolder = storage_path('app/temp_surat_tugas_' . time());
            if (!file_exists($tempFolder)) {
                mkdir($tempFolder, 0755, true);
            }

            $filename = "surat_tugas_{$data->id}.docx";
            
             foreach ($pegawaiData as $index => $item) {
                // $nama_pegawai=$item->gelar_depan.' '. $item->nama_lengkap .' '. $item->gelar_belakang;
                //  dd($item);
                $st_doc->setValue("no#".($index+1), $index + 1);
                $st_doc->setValue("nama#".($index+1), $item['nama_lengkap']);
                $st_doc->setValue("nip#".($index+1), $item['nip']);
                $st_doc->setValue("golongan#".($index+1), $item['golongan']);
                $st_doc->setValue("pangkat#".($index+1), $item['pangkat']);
                $st_doc->setValue("jabatan#".($index+1), $item['jabatan']);
                $st_doc->setValue("satker#".($index+1), $item['satker']);
                
                // untuk mengisi lampiran ST Dalam Kota
                if ($request->jenis_st=='3' && $data->dipa=='1'){
                    $st_doc->setValue("no_l#".($index+1), $index + 1);
                    $st_doc->setValue("nama_l#".($index+1), $item['nama_lengkap']);
                    $st_doc->setValue("nip_l#".($index+1), $item['nip']);
                    $st_doc->setValue("golongan_l#".($index+1), $item['golongan']);
                    $st_doc->setValue("pangkat_l#".($index+1), $item['pangkat']);
                    $st_doc->setValue("hari_l#".($index+1), $this->getHariIndonesia($data->tgl_awal));
                    $st_doc->setValue("tgl_awal#".($index+1), Carbon::parse($data->tgl_awal)->format('d-m-Y'),);
                }

                 if ($data->dipa=='1' && $request->jenis_st<>'3'){

                    $jabatanTingkatB = [
                        'Ketua Pengadilan',
                        'Wakil Ketua Pengadilan',
                        'Hakim Tinggi',
                        'Sekretaris',
                        'Panitera'
                    ];

                    $tingkat = in_array($item['jabatan'], $jabatanTingkatB) ? 'B' : 'C';

                    $templateSPDPath = public_path('template/spd.docx');
                    // Generate SPD
                    $spd_doc = new TemplateProcessor($templateSPDPath);
                    $spd_doc->setValues([
                            'nama_pegawai' => $item['nama_lengkap'],
                            'nip' => $item['nip'],
                            'golongan' => $item['golongan'],
                            'pangkat' => $item['pangkat'],
                            'jabatan' => $item['jabatan'],
                            'satker' => $item['satker'],
                            'tingkat' => $tingkat,
                            'maksud' => $data->maksud,
                            'alat' => 'Kendaran Umum',
                            'kota_tujuan' => $data->kota_tujuan,
                            'lama' => $jmlhari. ' hari',
                            'tgl_awal' => Carbon::parse($data->tgl_awal)->format('d-m-Y'), 
                            'tgl_akhir' => Carbon::parse($data->tgl_akhir)->format('d-m-Y'),
                            'nomor_st' => $data->no_surat_tugas,
                            'tgl_st' => Carbon::parse($data->tgl_surat_tugas)->format('d-m-Y'),
                            'jabatan_ttd' => Str_replace('Pengadilan','',$datapejabat->jabatan),
                            'pejabat' => $datapejabat->gelar_depan.' '.$datapejabat->nama_lengkap.', '.$datapejabat->gelar_belakang,
                            'nip_pejabat' => $datapejabat->nip,
                            'tahun' => date('Y'),
                        ]);

                    $fileSPD = "SPD".$item['nama_lengkap'].".docx";
                    $spd_doc->saveAs($tempFolder . '/' . $fileSPD);

                 }

             }

             $st_doc->saveAs($tempFolder. '/' . $filename);
             /** ZIP */
            $zipFileName = 'Surat_tugas_' . $data->instansi_tujuan .'_'. now()->format('Ymd_His') . '.zip';
            $zipPath = storage_path('app/public/' . $zipFileName);

            // $pathST = storage_path('app/public/surat_tugas.docx');

            $zip = new ZipArchive();
            if ($zip->open($zipPath, ZipArchive::CREATE)) {
                $files = glob($tempFolder . '/*.docx');
                foreach ($files as $file) {
                    $zip->addFile($file, basename($file));
                }
                $zip->close();
            }
            
            // Hapus folder temporary
            foreach (glob($tempFolder . '/*') as $file) {
                unlink($file);
            }
            rmdir($tempFolder);

            // dd($pegawaiData);
            return response()->download($zipPath)->deleteFileAfterSend(true);
            // File::delete([$pathST]);
        }

        }catch(\Exception $e){
            // return route('')->with('error', 'Error, Data Gagal Disimpan ..! ' . $e->getMessage());
            return back()->with('error', 'Data Gagal Download ..!'. $e->getMessage());
        }
        
    }

    public function getHariIndonesia($tanggal) {
        $namaHari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $carbonDate = Carbon::parse($tanggal);
        return $namaHari[$carbonDate->dayOfWeek];
    }

    public function editST($id){
        try{
            $datast = SuratTugas::where('id', $id)
                    ->first();

            $user = DB::table('pegawai')
            ->where('id_satker', '520')
            ->whereIn('kelompok_jabatan', ['Ketua Pengadilan', 'Wakil Ketua Pengadilan', 'Hakim', 'Panitera', 'Sekretaris','Kepala Bagian'])
            ->get();

            // Ambil NIP pegawai yang terkait dengan surat tugas ini
            $nipList = SuratTugasPegawai::where('surat_tugas_id', $id)
                ->pluck('pegawai_id')
                ->toArray();



             // Cari data pegawai dari tabel pegawai atau user
            $pegawaiData = DB::table('pegawai')->whereIn('nip', $nipList)
                ->get()
                ->map(function ($item) {
                    return [
                        'nip' => $item->nip,
                        'nip_asli' => $item->nip,
                        'nama_lengkap' => $item->nama_lengkap ?? '-',
                        'jabatan' => $item->jabatan ?? '-',
                        'satker' => $item->satker ?? '-',
                        'source' => 'pegawai' // Untuk identifikasi sumber data
                    ];
                });
                // ->keyBy('nip'); // Gunakan NIP sebagai key

            

            // Cari data yang belum ditemukan di tabel pegawai
            $missingNips = array_diff($nipList, $pegawaiData->keys()->toArray());

            // dd($missingNips);
            

            if (!empty($missingNips)){
                $ppnpn = DB::table('users')->wherein('username',$missingNips)
                ->leftjoin('satkers','satkers.id','=','users.satker_id')
                ->where('users.jabatan','=','PPNPN')
                ->select(
                    'users.username',
                    'users.name',
                    'users.jabatan',
                    'satkers.nama_satker'
                )
                ->get()
                ->map(function($item){
                    return [
                        // 'username' => $item->username,
                        'nip' => '-' ?? '-',
                        'nip_asli' => $item->username,
                        'nama_lengkap' => $item->name,
                        'jabatan' => $item->jabatan,
                        'satker'=> Str::title($item->nama_satker),
                        'source' => 'ppnpn',
                    ];
                });
            //     // ->keyBy('username'); // Gunakan Username sebagai key

                 $pegawaiData = $pegawaiData->merge($ppnpn);
                //  $pegawaiDataNIP = $pegawaiData->merge($ppnpnNIP);
            }



        return response()->json([
            // 'nama' => $data->gelar_depan . ' ' . $data->nama_lengkap . ' ' . $data->gelar_belakang,
            'datast' => $datast,
            'pegawaiData' => $pegawaiData,
            'user' => $user,
           
        ]);
        }catch(\Exception $e){

        }
        


    }

    public function saveeditst(Request $request){
        
       $validator = Validator::make($request->all(), [
            'nomor_st' => [
                'required',
                'string',
                'max:64',
                // Rule::unique('surat_tugas', 'no_surat_tugas')->ignore($request->id_surat_tugas)
            ],
            'tgl_st' => 'required|date',
            'menimbang' => 'required|string|max:350',
            'maksud' => 'required|string|max:250',
            'instansi' => 'required|string|max:150',
            'kota' => 'required|string|max:150',
            'alamat' => 'required|string|max:350',
            'tgl_awal' => 'required|date|after_or_equal:tgl_st',
            'tgl_akhir' => 'required|date|after_or_equal:tgl_awal',
            'pejabat' => 'required|string',
            'pegawai_id' => 'required|array|min:1',
            // 'pegawai_id.*' => 'exists:pegawai,nip_asli',
            'id_surat_tugas' => 'required|exists:surat_tugas,id'
            ], [
                'pegawai_id.required' => 'Pilih minimal satu pegawai',
                'tgl_akhir.after_or_equal' => 'Tanggal akhir harus setelah atau sama dengan tanggal awal'
            ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        try{

            if ($request->dipa == "on") {
                $dipa = "1";
            } else {
                $dipa = "0";
            }
            

            $updateData = [
                'no_surat_tugas' => $request->nomor_st,
                'tgl_surat_tugas' => $request->tgl_st,
                'menimbang' => $request->menimbang,
                'maksud' => $request->maksud,
                'instansi_tujuan' => $request->instansi,
                'kota_tujuan' => $request->kota,
                'alamat_tujuan' => $request->alamat,
                'tgl_awal' => $request->tgl_awal,
                'tgl_akhir' => $request->tgl_akhir,
                'pejabat' => $request->pejabat,
                'dipa' => $dipa,
                // 'dipa' => $request->kelompokJabatan,
                'updated_at' => now(),
            ];

            // hapus dulu pegawai dengan surat tugas id yg sama
            $deleted = SuratTugasPegawai::where('surat_tugas_id', $request->id_surat_tugas)->delete();
            // insert data baru
            foreach ($request->pegawai_id as $pegawaiId) {
                    SuratTugasPegawai::create([
                        'surat_tugas_id' => $request->id_surat_tugas,
                        'pegawai_id' => $pegawaiId
                    ]);
                }

            // Update data di database
            DB::table('surat_tugas')->where('id', $request->id_surat_tugas)->update($updateData);
           

            return redirect()->route('surattugas')->with('success', 'Data surat tugas berhasil diperbarui..');

        }catch(\Exception $e){
            return redirect()
            ->back()
            ->withErrors($e->errors())
            ->withInput()
            ->with('keep_modal_open', true);

        }
    }

    public function hapusst($id)
    {
        try {
            DB::beginTransaction();

            // Hapus relasi dari surat_tugas_pegawai
            DB::table('surat_tugas_pegawai')->where('surat_tugas_id', $id)->delete();

            // Hapus data utama dari surat_tugas
            DB::table('surat_tugas')->where('id', $id)->delete();

            DB::commit();

            return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Gagal menghapus data: ' . $e->getMessage()]);
        }
    }
}
