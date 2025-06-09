<?php

namespace App\Http\Controllers;

use App\Models\Izbel;
use App\Models\IzbelAudit;
use App\Models\AuditIzbel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\TemplateProcessor;


class IzbelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $izbel = Izbel::all();
        $izbel = Izbel::where('user_id', Auth::User()->id)->get();
        // dd($izbel);
        return view('Izbel.index', (['Izbel' => $izbel]));
    }
    public function adminindex()
    {
        //
        $izbel = Izbel::all();

        return view('izbel.indexadmin', (['Izbel' => $izbel]));
        // dd($izbel);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('izbel.tambah');
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
            'nip' => 'Required',
            'nama' => 'Required',
            'jabatan' => 'Required',
            'gol' => 'Required',
            'izin_pendidikan' => 'Required',
            'universitas' => 'Required',
            'alamat' => 'Required',
            'surat' => 'Required',
            'tgl_surat' => 'Required',
            'program_studi' => 'Required',
            'tahun' => 'Required',
            'file' => 'Required',
            'file2' => 'Required',
            // 'file3' => 'Required',
            'file4' => 'Required',
            'file5' => 'Required',
            'file6' => 'Required',
            'file7' => 'Required'
        ]);
        // dd($request->all());
        $request->request->add(['status' => 'Pengajuan Awal']);

        $file = $request->file('file');
        $file2 = $request->file('file2');
        //$file3 = $request->file('file3');
        $file4 = $request->file('file4');
        $file5 = $request->file('file5');
        $file6 = $request->file('file6');
        $file7 = $request->file('file7');
        $nama_file = "SuratPengantar" . time() . "_" . $file->getClientOriginalName();
        $nama_file2 = "SKPns" . time() . "_" . $file2->getClientOriginalName();
        //$nama_file3 = "Pangkat" . time() . "_" . $file3->getClientOriginalName();
        $nama_file4 = "SuketMhs" . time() . "_" . $file4->getClientOriginalName();
        $nama_file5 = "Akreditasi" . time() . "_" . $file5->getClientOriginalName();
        $nama_file6 = "Pernyataan" . time() . "_" . $file6->getClientOriginalName();
        $nama_file7 = "Persetujuan" . time() . "_" . $file7->getClientOriginalName();

        $tujuan_upload = 'images';
        // $file->move($tujuan_upload, $file->getClientOriginalName());
        $file->move($tujuan_upload, $nama_file);
        $file2->move($tujuan_upload, $nama_file2);
        // $file3->move($tujuan_upload, $nama_file3);
        $file4->move($tujuan_upload, $nama_file4);
        $file5->move($tujuan_upload, $nama_file5);
        $file6->move($tujuan_upload, $nama_file6);
        $file7->move($tujuan_upload, $nama_file7);
        // dd($request->all());
        $izbel = Izbel::create([
            'nip' => $request->nip,
            'nama_pegawai' => $request->nama,
            'jabatan' => $request->jabatan,
            'golongan' => $request->gol,
            'izin_pendidikan' => $request->izin_pendidikan,
            'nama_universitas' => $request->universitas,
            'alamat_universitas' => $request->alamat,
            'nomor_s_keterangan' => $request->surat,
            'tgl_s_keterangan' => $request->tgl_surat,
            'program_studi' => $request->program_studi,
            'tahun_akademik' => $request->tahun,
            'file_surat_pengantar' => $nama_file,
            'file_sk_pns' => $nama_file2,
            // 'file_sk_kp' => $nama_file3,
            // 'file_ijazah' => $nama_file4,
            'file_s_universitas' => $nama_file4,
            'file_akreditasi' => $nama_file5,
            'file_pernyataan' => $nama_file6,
            'file_rekomendasi' => $nama_file7,
            'status' => $request->status,
            'user_id' => Auth::User()->id
        ]);
        // $email = Auth::user()->email;
        // $nama = $request->nama;
        //     \Mail::raw('Permohonan izin belajar atas nama ' . $nama, function ($message) use ($email) {
        //         $message->from($email, 'Admin Jaki');
        //         $message->to('surat.ptajawabarat@gmail.com', 'Bag. Kepegawaian');
        //         $message->subject('Permohonan Izin Belajar');
        //     });

        IzbelAudit::create([
            'izbels_id' => $izbel->id,
            'users_id' => Auth::User()->id,
            'description' => 'Membuat Permohonan Izin Belajar',
        ]);
        return redirect('/izbel')->with('status', 'Permohonan izin belajar telah disimpan..!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Izbel  $izbel
     * @return \Illuminate\Http\Response
     */
    public function show(Izbel $izbel)
    {
        //
        // $izbel = Izbel::find($izbel);
        // dd($izbel);
        // return view('izbel.detail', ['izbel' => $izbel]);
    }

    public function cari($id)
    {
        //
        $izbel = Izbel::find($id);
        // dd($izbel);
        return view('izbel.detail', ['izbel' => $izbel]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Izbel  $izbel
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $izbel = Izbel::find($id);

        if ($izbel->status_kunci == '1') {
            return redirect('/izbel')->with('error', 'Permohonan telah dikunci, silahkan buka kunci terlebih dahulu..!');
        }

        return view('izbel.edit', ['izbel' => $izbel]);
    }

    public function proses($id)
    {
        //
        $izbel = Izbel::find($id);
        if ($izbel->status_kunci == '1') {
            return redirect('/prosesizbel')->with('error', 'Silahkan buka kunci terlebih dahulu..!');
        }
        return view('izbel.proses', ['izbel' => $izbel]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Izbel  $izbel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        // dd($request->all());
        $request->validate([
            'nip' => 'Required',
            'nama_pegawai' => 'Required',
            'jabatan' => 'Required',
            'golongan' => 'Required',
            'izin_pendidikan' => 'Required',
            'nama_universitas' => 'Required',
            'alamat_universitas' => 'Required',
            'nomor_s_keterangan' => 'Required',
            'tgl_s_keterangan' => 'Required',
            'program_studi' => 'Required',
            'tahun_akademik' => 'Required'

        ]);
        $request->request->add(['status' => 'Perbaikan']);
        // dd($request->all());
        $izbel = Izbel::find($id);
        // dd($id);
        // dd($izbel->all());
        $izbel->update($request->all());

        if ($request->hasfile('file')) {
            $file = $request->file('file');
            $nama_file = "SuratPengantar" . time() . "_" . $file->getClientOriginalName();
            // dd($nama_file);
            // // folder tujuan upload ada di public
            $tujuan_upload = 'images';
            // $file->move($tujuan_upload, $file->getClientOriginalName());
            $file->move($tujuan_upload, $nama_file);
            $izbel->file_surat_pengantar = $nama_file;
            $izbel->save();
        }
        if ($request->hasfile('file2')) {
            $file2 = $request->file('file2');
            $nama_file2 = "SKPns" . time() . "_" . $file2->getClientOriginalName();
            // dd($nama_file);
            // // folder tujuan upload ada di public
            $tujuan_upload = 'images';
            // $file->move($tujuan_upload, $file->getClientOriginalName());
            $file2->move($tujuan_upload, $nama_file2);
            $izbel->file_sk_pns = $nama_file2;
            $izbel->save();
        }
        if ($request->hasfile('file4')) {
            $file4 = $request->file('file4');
            $nama_file4 = "SuketMhs" . time() . "_" . $file4->getClientOriginalName();
            // dd($nama_file);
            // // folder tujuan upload ada di public
            $tujuan_upload = 'images';
            // $file->move($tujuan_upload, $file->getClientOriginalName());
            $file4->move($tujuan_upload, $nama_file4);
            $izbel->file_sk_pns = $nama_file4;
            $izbel->save();
        }
        if ($request->hasfile('file5')) {
            $file5 = $request->file('file5');
            $nama_file5 = "Akreditasi" . time() . "_" . $file5->getClientOriginalName();
            // dd($nama_file);
            // // folder tujuan upload ada di public
            $tujuan_upload = 'images';
            // $file->move($tujuan_upload, $file->getClientOriginalName());
            $file5->move($tujuan_upload, $nama_file5);
            $izbel->file_sk_pns = $nama_file5;
            $izbel->save();
        }
        if ($request->hasfile('file6')) {
            $file6 = $request->file('file6');
            $nama_file6 = "Pernyataan" . time() . "_" . $file6->getClientOriginalName();
            // dd($nama_file);
            // // folder tujuan upload ada di public
            $tujuan_upload = 'images';
            // $file->move($tujuan_upload, $file->getClientOriginalName());
            $file6->move($tujuan_upload, $nama_file6);
            $izbel->file_sk_pns = $nama_file6;
            $izbel->save();
        }
        if ($request->hasfile('file7')) {
            $file7 = $request->file('file7');
            $nama_file7 = "Persetujuan" . time() . "_" . $file7->getClientOriginalName();
            // dd($nama_file);
            // // folder tujuan upload ada di public
            $tujuan_upload = 'images';
            // $file->move($tujuan_upload, $file->getClientOriginalName());
            $file7->move($tujuan_upload, $nama_file7);
            $izbel->file_sk_pns = $nama_file7;
            $izbel->save();
        }

        IzbelAudit::create([
            'izbels_id' => $izbel->id,
            'users_id' => Auth::User()->id,
            'description' => 'Perbaikan Permohonan',
        ]);
        return redirect('/izbel')->with('status', 'Perubahan izin belajar telah disimpan..!');
    }
    public function saveproses(Request $request, $id)
    {
        $hasil = $request->hasil;

        if ($hasil == "Diterima") {
            $request->validate([
                'SuratPengantar' => 'Required',
                'SKPns' => 'Required',
                'SuratKeterangan' => 'Required',
                'SertfikatAkreditasi' => 'Required',
                'Pernyataan' => 'Required',
                'Rekomendasi' => 'Required'
            ]);
            $izbel = Izbel::find($id);
            $izbel->update([
                'status' => $request->hasil,
                'keterangan' => 'Dokumen lengkap'
            ]);
            // menambahakan catatan di table audit
            IzbelAudit::create([
                'izbels_id' => $id,
                'users_id' => Auth::User()->id,
                'description' => 'Proses Permohonan, Diterima',
            ]);
        } else {
            $request->validate([
                'alasan' => 'Required',
            ]);
            $izbel = Izbel::find($id);

            $izbel->update([
                'status' => $request->hasil,
                'keterangan' => $request->alasan
            ]);
            IzbelAudit::create([
                'izbels_id' => $id,
                'users_id' => Auth::User()->id,
                'description' => 'Proses Permohonan, Ditolak : ' . $request->alasan,
            ]);
        }

        // dd($request->all());

        return redirect('/prosesizbel')->with('status', 'Permohonan izin belajar telah ' . $request->hasil . ' ..!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Izbel  $izbel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $izbel = Izbel::find($id);
        if ($izbel->status_kunci == '1') {
            return redirect('/izbel')->with('error', 'Permohonan telah dikunci, silahkan buka kunci terlebih dahulu..!');
        }
        IzbelAudit::create([
            'izbels_id' => $id,
            'users_id' => Auth::User()->id,
            'description' => 'Menghapus Permohonan Izin Belajar',
        ]);

        $izbel->delete($izbel);
        return redirect('/izbel')->with('status', 'Izin Belajar telah berhasil dihapus..!');
    }

    public function kunci($id)
    {
        //
        $izbel = Izbel::find($id);
        if ($izbel->status == 'Diterima' || $izbel->status == 'Dikunci') {
            return view('izbel.kunci', ['izbel' => $izbel]);
        }
        return redirect('/prosesizbel')->with('error', 'Silahkan proses permohonan terlebih dahulu..!');
    }

    public function proseskunci(Request $request, $id)
    {
        $izbel = Izbel::find($id);
        if ($request->isi == '0') {
            $izbel->update([
                'status_kunci' => '1',
                'tgl_kunci' => now(),
                'status' => 'Dikunci'
            ]);
            IzbelAudit::create([
                'izbels_id' => $id,
                'users_id' => Auth::User()->id,
                'description' => 'Dikunci ',
            ]);
        } else {
            $izbel->update([
                'status_kunci' => '0',
                'tgl_kunci' => null,
                'status' => 'Diterima'
            ]);

            IzbelAudit::create([
                'izbels_id' => $id,
                'users_id' => Auth::User()->id,
                'description' => 'Buka Kunci '
            ]);
        }
        return view('izbel.kunci', ['izbel' => $izbel]);
    }

    public function cetakizbel(Request $request, $id)
    {
        $izbel = Izbel::find($id);
        $request->validate([
            'nosurat' => 'Required',
            'tglsurat' => 'Required',
            'tujuan' => 'Required'
        ]);


        if ($request->tujuan == '1')
            $tujuan = 'Kepala Biro Kepegawaian MARI';
        elseif ($request->tujuan == '2')
            $tujuan = 'Direktur Jenderal Badan Peradilan Agama';
        else
            $tujuan = 'Ketua Pengadilan Agama ';

        // dd($request->all());
        $izbel->update([
            'no_surat_balasan' => $request->nosurat,
            'tgl_surat_balasan' => $request->tglsurat,
            'tujuan_surat' => $tujuan
        ]);

        $templateProcessor = new TemplateProcessor('template/izbel.docx');
        $templateProcessor->setValue('nomor', $izbel->no_surat_balasan);
        $templateProcessor->setValue('tujuan', $izbel->tujuan_surat);
        $templateProcessor->setValue('tgl_surat', $izbel->tgl_surat_balasan);
        $templateProcessor->setValue('nama', $izbel->nama_pegawai);
        $templateProcessor->setValue('nip', $izbel->nip);
        $templateProcessor->setValue('golongan', $izbel->golongan);
        $templateProcessor->setValue('jabatan', $izbel->jabatan);
        $templateProcessor->setValue('universitas', $izbel->nama_universitas);
        $templateProcessor->setValue('programstudi', $izbel->program_studi);
        $templateProcessor->setValue('tahun', $izbel->tahun_akademik);
        $templateProcessor->setValue('alamat', $izbel->alamat_universitas);
        $templateProcessor->setValue('jenjang', $izbel->izin_pendidikan);
        $filename = $izbel->nama_pegawai;
        $templateProcessor->saveAs($filename . '.docx');
        return response()->download($filename . '.docx')->deleteFileAfterSend(true);

        return view('izbel.kunci', ['izbel' => $izbel]);
    }

    public function history($id)
    {
        // $audit = AuditIzbel::where('izbels_id', $id)->get();

        $audit = DB::table('izbels_audit')
            ->join('users', 'izbels_audit.users_id', '=', 'users.id')
            // ->join('orders', 'users.id', '=', 'orders.user_id')
            ->select('izbels_audit.*', 'users.name', 'users.email')
            ->where('izbels_id', '=', $id)
            ->get();
        // dd($audit);
        return view('izbel.history', ['audit' => $audit]);
    }
    public function historyuser($id)
    {
        // $audit = AuditIzbel::where('izbels_id', $id)->get();

        $audit = DB::table('izbels_audit')
            ->join('users', 'izbels_audit.users_id', '=', 'users.id')
            // ->join('orders', 'users.id', '=', 'orders.user_id')
            ->select('izbels_audit.*', 'users.name', 'users.email')
            ->where('izbels_id', '=', $id)
            ->get();
        // dd($audit);
        return view('izbel.historyuser', ['audit' => $audit]);
    }

    public function waizbel($id)
    {
        $izbel = Izbel::find($id);
        return view('izbel.izbelwa', ['izbel' => $izbel]);
    }

    public function kirimwa($id)
    {
        $izbel = Izbel::find($id);
        $pesan = '*Jaki Notifikasi :* Permohonan Izin Belajar atas nama  ' . $izbel->nama_pegawai . ' mohon agar segera diproses. Terima Kasih';

        $curl = curl_init();
        $data = ["id_device" => "109", "message" => $pesan, "tujuan" => "6285759002978@s.whatsapp.net"];
        $payload = json_encode($data);

        $ch = curl_init("https://whatsva.com/api/sendText");
        // # Setup request to send json via POST.

        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', "apikey: 3lavwHdV"));
        # Return response instead of printing.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        # Send request.
        $result = curl_exec($ch);
        curl_close($ch);

        // dd($result);

        # Print response.
        // return redirect('/izbel')->with('status', 'Pesan Whatspp telah dikirim kepada kasubbag Kepeg & TI PTA Jabar..!');
        // echo "<pre>$result</pre>";
    }

    public function izbelproduk($id)
    {
        //
        $izbel = Izbel::find($id);
        if ($izbel->status == 'Diterima' || $izbel->status == 'Dikunci') {
            return view('izbel.produk', ['izbel' => $izbel]);
        }
        return redirect('/prosesizbel')->with('error', 'Silahkan proses permohonan terlebih dahulu..!');
    }

    public function produkupdate(Request $request, $id)
    {
        //
        // dd($request->all());
        $request->validate([
            'file' => 'Required'
        ]);
        // $request->request->add(['status' => 'Perbaikan']);
        // dd($request->all());
        $izbel = Izbel::find($id);
        // dd($id);
        // dd($izbel->all());
        $izbel->update($request->all());

        if ($request->hasfile('file')) {
            $file = $request->file('file');
            $nama_file = "izinbelajar" . time() . "_" . $file->getClientOriginalName();
            // dd($nama_file);
            // // folder tujuan upload ada di public
            $tujuan_upload = 'images';
            // $file->move($tujuan_upload, $file->getClientOriginalName());
            $file->move($tujuan_upload, $nama_file);
            $izbel->produk = $nama_file;
            $izbel->keterangan = 'SK Sudah Selesai';
            $izbel->save();
        }

        IzbelAudit::create([
            'izbels_id' => $izbel->id,
            'users_id' => Auth::User()->id,
            'description' => 'Kirim Hasil Akhir',
        ]);
        return redirect('/prosesizbel')->with('status', 'SK atau Izin Belajar telah disimpan..!');
    }
}
