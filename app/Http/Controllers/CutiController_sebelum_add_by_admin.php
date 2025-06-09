<?php

namespace App\Http\Controllers;

// use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Cuti;
use App\Models\User;
use App\Models\CutiDetail;
use App\Http\Controllers\CutiController\kirimwa;
use BaconQrCode\Encoder\QrCode as EncoderQrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Block\Renderer\ThematicBreakRenderer;
use PhpOffice\PhpWord\TemplateProcessor;
use Carbon\Carbon;

use function PHPUnit\Framework\isNull;

class CutiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $role = Auth::User()->role;
        if ($role == '1') {
            $cuti = Cuti::where('aktif', 1)->get();
        } else {
            $cuti = Cuti::where('aktif', 1, 'and')->where('id_satker', Auth::User()->satker_id)->get();
        }
        // dd($cuti);
        // $tahun = date('Y');
        // $role = Auth::User()->role;
        // if ($role=='1'){
        //     $cuti = DB::table('master_cutis')
        //         ->join('master_cutis_detail', 'master_cutis.id', '=', 'master_cutis_detail.master_cutis_id')
        //         ->join('satkers', 'satkers.id', '=', 'master_cutis.id_satker')
        //         ->select('master_cutis_detail.*', 'master_cutis.*', 'satkers.nama_satker')
        //         ->where('master_cutis.aktif', '1', 'and')
        //         ->get();
        // }else
        // {
        //     $username = Auth::user()->username;
        //     $cuti = DB::table('master_cutis')
        //         ->join('master_cutis_detail', 'master_cutis.id', '=', 'master_cutis_detail.master_cutis_id')
        //         ->join('satkers', 'satkers.id', '=', 'master_cutis.id_satker')
        //         ->select('master_cutis_detail.*', 'master_cutis.*', 'satkers.nama_satker')
        //         // ->where('master_cutis.tahun_anggaran', $tahun, 'and')
        //         ->where('master_cutis.aktif', '1', 'and')
        //         ->where('nip', $username)
        //         ->get();

        // }

        return view('cuti.index', (['cuti' => $cuti]));
    }

    public function usulcuti()
    {


        $role = Auth::User()->role;
        if ($role == '1') {
            $cuti = DB::table('master_cutis')
                ->join('master_cutis_detail', 'master_cutis.id', '=', 'master_cutis_detail.master_cutis_id')
                ->join('satkers', 'satkers.id', '=', 'master_cutis.id_satker')
                ->select('master_cutis_detail.*', 'master_cutis.*', 'satkers.nama_satker')
                ->where('master_cutis.aktif', '1', 'and')
                ->get();
        } else {
            $username = Auth::user()->username;
            $cuti = DB::table('master_cutis')
                ->join('master_cutis_detail', 'master_cutis.id', '=', 'master_cutis_detail.master_cutis_id')
                ->join('satkers', 'satkers.id', '=', 'master_cutis.id_satker')
                ->select('master_cutis_detail.*', 'master_cutis.*', 'satkers.nama_satker')
                // ->where('master_cutis.tahun_anggaran', $tahun, 'and')
                ->where('master_cutis.aktif', '1', 'and')
                ->where('nip', $username)
                ->get();
        }

        return view('cuti.usulcuti', (['cuti' => $cuti]));
    }

    public function usulcutiuser()
    {


        $role = Auth::User()->role;
        // if ($role == '1') {
        //     $cuti = DB::table('master_cutis')
        //         ->join('master_cutis_detail', 'master_cutis.id', '=', 'master_cutis_detail.master_cutis_id')
        //         ->join('satkers', 'satkers.id', '=', 'master_cutis.id_satker')
        //         ->select('master_cutis_detail.*', 'master_cutis.*', 'satkers.nama_satker')
        //         ->where('master_cutis.aktif', '1', 'and')
        //         ->get();
        // } else {
        $username = Auth::user()->username;
        $cuti = DB::table('master_cutis')
            ->join('master_cutis_detail', 'master_cutis.id', '=', 'master_cutis_detail.master_cutis_id')
            ->join('satkers', 'satkers.id', '=', 'master_cutis.id_satker')
            ->select('master_cutis_detail.*', 'master_cutis.*', 'satkers.nama_satker', 'master_cutis_detail.id as id_detail')
            // ->where('master_cutis.tahun_anggaran', $tahun, 'and')
            ->orderByDesc('master_cutis_detail.tgl_mulai')
            ->where('master_cutis.aktif', '1', 'and')
            ->where('master_cutis.nip', $username)
            ->get();
        // }

        // dd($cuti);
        return view('cuti.usulcutiuser', (['cuti' => $cuti]));
    }

    public function addusulcti()
    {
        // $jenis = $request->jenis;
        $user = User::all();
        $user2 = User::all();
        // dd($jenis);
        $tahun = date('Y');

        $mastercuti = DB::table('master_cutis')
            ->join('satkers', 'satkers.id', '=', 'master_cutis.id_satker')
            ->select('master_cutis.*', 'satkers.nama_satker')
            ->where('master_cutis.aktif', '1', 'and')
            ->where('master_cutis.nip', Auth::User()->username, 'and')
            ->where('master_cutis.id_satker', Auth::User()->satker_id, 'and')
            ->where('master_cutis.tahun_anggaran', $tahun)
            ->get();

        $jumlah = $mastercuti->count();

        if ($jumlah == "0") {
            return redirect('/cuti')->with('error', 'Mohon isi saldo awal cuti terlebih dahulu..!');
        }

        return view('cuti.tambah', ([
            'cuti' => $mastercuti,
            //'jenis' => $jenis,
            'user' => $user,
            'user2' => $user2

        ]));
    }

    public function addusulctuser()
    {
        // $jenis = $request->jenis;
        $user = User::all();
        $user2 = User::all();
        // dd($jenis);
        $tahun = date('Y');

        $mastercuti = DB::table('master_cutis')
            ->join('satkers', 'satkers.id', '=', 'master_cutis.id_satker')
            ->select('master_cutis.*', 'satkers.nama_satker')
            ->where('master_cutis.aktif', '1', 'and')
            ->where('master_cutis.nip', Auth::User()->username, 'and')
            ->where('master_cutis.id_satker', Auth::User()->satker_id, 'and')
            ->where('master_cutis.tahun_anggaran', $tahun)
            ->get();

        $jumlah = $mastercuti->count();
        // dd($jumlah);
        if ($jumlah == "0") {
            return redirect('/cutiuser')->with('error', 'Mohon isi saldo awal cuti terlebih dahulu..!');
        }

        return view('cuti.tambahuser', ([
            'cuti' => $mastercuti,
            //'jenis' => $jenis,
            'user' => $user,
            'user2' => $user2

        ]));
    }

    public function prosescuti($id)
    {
        //
        $cuti = CutiDetail::find($id);
        // if ($izbel->status_kunci == '1') {
        //     return redirect('/usulcuti')->with('error', 'Silahkan buka kunci terlebih dahulu..!');
        // }
        return view('cuti.prosescuti', ['cuti' => $cuti]);
    }

    public function cetakcuti($id)
    {
        //
        $cuti = CutiDetail::find($id);
	    $alamat = $this->replace_char($cuti->alamat_cuti);
        // $saldo = Cuti::find($cuti->master_cutis_id);
        $saldo = Cuti::where('id', $cuti->master_cutis_id)->get()->first();


        // $qrcode = QrCode::size(100)->generate('faridl', '../public/qrcodes/' . Auth::User()->name . '.svg');
        // QrCode::generate('Make me into a QrCode!', '../public/qrcodes/qrcode.svg')
        // return view('cuti.qrcode', compact('qrcode'));
        // dd($saldo);
        $templateProcessor = new TemplateProcessor('template/permohonan_cuti.docx');
        $templateProcessor->setValue('nama', $saldo->nama);
        $templateProcessor->setValue('jabatan', $saldo->jabatan);
        // $templateProcessor->setValue('unit_kerja', $cuti->tgl_surat_balasan);
        $templateProcessor->setValue('nip', $saldo->nip);
        $templateProcessor->setValue('alasan', $cuti->alasan_cuti);
        $templateProcessor->setValue('alamat', $alamat);
        $templateProcessor->setValue('lama', $cuti->lama_cuti);
        $templateProcessor->setValue('tgl_mulai', $cuti->tgl_mulai);
        $templateProcessor->setValue('tgl_akhir', $cuti->tgl_akhir);
        $templateProcessor->setValue('telp', $cuti->telp);
        $templateProcessor->setValue('atasan', $cuti->nama_atasan_langsung);
        $templateProcessor->setValue('nipatasan', $cuti->atasan_langsung);
        $templateProcessor->setValue('pejabat', $cuti->nama_pejabat_berwenang);
        $templateProcessor->setValue('nippejabat', $cuti->pejabat_berwenang);
        $templateProcessor->setValue('unit_kerja', $cuti->satker);
        $templateProcessor->setValue('n2', $saldo->sisa_tahun_t2);
        $templateProcessor->setValue('n1', $saldo->sisa_tahun_t1);
        $templateProcessor->setValue('n', $saldo->sisa_tahun_t0);
        $created_date = date("Y-m-d", strtotime($cuti->created_at));
        $templateProcessor->setValue('created_at', $this->tgl_indo($created_date));
        // asset('images').
        // asset('images').'/'.Auth::User()->profile_photo_path
        // $templateProcessor->setImageValue('ppk', asset('images') . '/1625646983_sandi.jpg');
        // $templateProcessor->setValue('unit_kerja', $cuti->satker);

        if ($cuti->jenis_cuti === "CT") {
            $templateProcessor->setValue('ct', "v");
            $templateProcessor->setValue('cs', "-");
            $templateProcessor->setValue('cap', "-");
            $templateProcessor->setValue('cb', "-");
            $templateProcessor->setValue('cm', "-");
            $templateProcessor->setValue('ctln', "-");
        } elseif ($cuti->jenis_cuti === "CAP") {
            $templateProcessor->setValue('ct', "-");
            $templateProcessor->setValue('cs', "-");
            $templateProcessor->setValue('cap', "v");
            $templateProcessor->setValue('cb', "-");
            $templateProcessor->setValue('cm', "-");
            $templateProcessor->setValue('ctln', "-");
        } elseif ($cuti->jenis_cuti === "CS") {
            $templateProcessor->setValue('ct', "-");
            $templateProcessor->setValue('cs', "v");
            $templateProcessor->setValue('cap', "-");
            $templateProcessor->setValue('cb', "-");
            $templateProcessor->setValue('cm', "-");
            $templateProcessor->setValue('ctln', "-");
        } elseif ($cuti->jenis_cuti === "CB") {
            $templateProcessor->setValue('ct', "-");
            $templateProcessor->setValue('cs', "-");
            $templateProcessor->setValue('cap', "-");
            $templateProcessor->setValue('cb', "v");
            $templateProcessor->setValue('cm', "-");
            $templateProcessor->setValue('ctln', "-");
        } elseif ($cuti->jenis_cuti === "CM") {
            $templateProcessor->setValue('ct', "-");
            $templateProcessor->setValue('cs', "-");
            $templateProcessor->setValue('cap', "-");
            $templateProcessor->setValue('cb', "-");
            $templateProcessor->setValue('cm', "v");
            $templateProcessor->setValue('ctln', "-");
        } elseif ($cuti->jenis_cuti === "CTLN") {
            $templateProcessor->setValue('ct', "-");
            $templateProcessor->setValue('cs', "-");
            $templateProcessor->setValue('cap', "-");
            $templateProcessor->setValue('cb', "-");
            $templateProcessor->setValue('cm', "-");
            $templateProcessor->setValue('ctln', "v");
        }
        // $templateProcessor->setValue('universitas', $cuti->nama_universitas);
        // $templateProcessor->setValue('programstudi', $cuti->program_studi);
        // $templateProcessor->setValue('tahun', $cuti->tahun_akademik);
        // $templateProcessor->setValue('alamat', $cuti->alamat_universitas);
        // $templateProcessor->setValue('jenjang', $cuti->izin_pendidikan);
        $filename = $saldo->nama;
        $templateProcessor->saveAs($filename . '.docx');
        return response()->download($filename . '.docx')->deleteFileAfterSend(true);


        //return view('izbel.kunci', ['izbel' => $izbel]);
        // return view('cuti.prosescuti', ['cuti' => $cuti]);
    }

    function replace_char($word)
    {
        $word = str_replace("&", "dan", $word);
        return $word;
    }

    function tgl_indo($tanggal)
    {
        $bulan = array (
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $tanggal);

        // variabel pecahkan 0 = tanggal
        // variabel pecahkan 1 = bulan
        // variabel pecahkan 2 = tahun

        return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatemastercuti(Request $request, $id)
    {

        $caricuti = Cuti::where('tahun_anggaran', $request->tahun_anggaran, 'and')
            ->where('nip', $request->nip)
            ->get();
        // dd($caricuti);
        if ($caricuti->count() > 0) {
            return redirect('/mastercuti')->with('error', 'Cuti pada tahun tersebut sudah ada, silahkan cek kembali..!');
        }

        $request->validate([
            // 'tahun_anggaran' => 'Required|numeric',

            'cuti_2tahun_lalu' => 'Required',
            'cuti_tahun_lalu' => 'Required',
            'cuti_sakit' => 'Required',
            'cuti_tahun_ini' => 'Required',
            'cap' => 'Required',
            // 'passwcuti_tahun_laluord' => 'Required',

        ]);

        // $cuti = Cuti::find($id);
        $cuti = DB::Table('master_cutis')
            ->where('id', $id)
            ->update([
                'sisa_tahun_t2' => $request->cuti_2tahun_lalu,
                'sisa_tahun_t1' => $request->cuti_tahun_lalu,
                'sisa_tahun_t0' => $request->cuti_tahun_ini,
                'sisa_cs' => $request->cuti_sakit,
                'sisa_cap' => $request->cap
            ]);


        // dd($request->all());
        // $cuti->update($request->all());

        // $user = Auth::user()->username;
        return redirect('/mastercuti')->with('status', 'Master Cuti Berhasil Disimpan..!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cuti  $cuti
     * @return \Illuminate\Http\Response
     */
    public function show(Cuti $cuti)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cuti  $cuti
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cuti = Cuti::find($id);
        // $satker = Satker::all();
        return view('cuti.edit', ['cuti' => $cuti]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cuti  $cuti
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cuti  $cuti
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $cuti = Cuti::find($id);
        // dd($cuti);
        $cuti->delete($cuti);
        return redirect('/mastercuti')->with('status', 'Data Saldo Cuti Telah Dihapus..!');
    }

    public function hapus_cuti(Request $request)
    {
        $cuti_detail = CutiDetail::find($request->id_detail);

        if ($cuti_detail->status == 'Disetujui') {
            $master_cuti = Cuti::find($cuti_detail->master_cutis_id);

            if ($master_cuti->sisa_tahun_t0 < 12) {
                // update sisa_tahun_t0
                $master_cuti->sisa_tahun_t0 = $master_cuti->sisa_tahun_t0 + $cuti_detail->lama_cuti;
            } else {
                // update sisa_tahun_t1
                $master_cuti->sisa_tahun_t1 = $master_cuti->sisa_tahun_t1 + $cuti_detail->lama_cuti;
            }
            $master_cuti->save();
        }

        $cuti_detail->delete($cuti_detail);

        return redirect('/approvalcuti')->with('status', 'Data Cuti Berhasil Dihapus..!');
    }

    public function addmastercuti()
    {
        return view('cuti.tambahmaster');
    }

    public function savemastercuti(Request $request)
    {
        // dd($request)->all();
        // return view('cuti.tambahmaster');
        // dd($request->all());
        $cari = Cuti::where('nip', $request->nip)
            ->where('tahun_anggaran', $request->tahun_anggaran)->count();

        // dd($cari);

        if ($cari > 0) {
            return redirect('/mastercuti')->with('error', 'Data Sudah Pernah Diinput..!');
        } else {

            $request->validate([
                'hnip' => 'Required',
                'nama' => 'Required',
                'tahun_anggaran' => 'Required|numeric',
                'jabatan' => 'Required',
                'tahun_anggaran' => 'Required',
                'cuti_tahun_lalu' => 'required|numeric',
                'cuti_2tahun_lalu' => 'required|numeric',
                'cuti_sakit' => 'required|numeric',
                'cuti_tahun_ini' => 'required|numeric'
            ]);

            Cuti::create([
                'nip' => $request->hnip,
                'nama' => $request->nama,
                'jabatan' => $request->jabatan,
                'tmt_cpns' => $request->tmt_cpns,
                'id_satker' => $request->id_satker,
                'sisa_tahun_t1' => $request->cuti_tahun_lalu,
                'sisa_tahun_t2' => $request->cuti_2tahun_lalu,
                'sisa_tahun_t0' => $request->cuti_tahun_ini,
                'tahun_anggaran' => $request->tahun_anggaran,
                'aktif' => '1'
                // 'description' => 'Menghapus Permohonan Izin Belajar',
            ]);

            // $izbel->delete($izbel);
            return redirect('/mastercuti')->with('status', 'Master Cuti Berhasil Disimpan..!');
        }
    }

    public function savedetailcuti(Request $request)
    {
        //  dd($request)->all();
        // return view('cuti.tambahmaster');
        // dd($request->all());
        // $request->validate([
        //     'alasan' => 'Required',
        //     'jenis' => 'Required',
        //     'tgl_awal' => 'Required',
        //     'lama' => 'Required',
        //     'tgl_akhir' => 'Required',
        //     'alamatcuti' => 'Required',
        //     'nohp' => 'Required'
        //     // 'ppk' => 'Required',
        //     // 'atasan_langsung' => 'Required'

        // ]);


        // if ($request->hasfile('file')) {

        //     $file = $request->file('file');
        //     $nama_file = "DokCuti" . time() . "_" . $file->getClientOriginalName();
        //     $tujuan_upload = 'images';
        //     $file->move($tujuan_upload, $nama_file);
        // }

        // CutiDetail::create([
        //     'master_cutis_id' => $request->id_cuti,
        //     'jenis_cuti' => $request->jenis,
        //     'alasan_cuti' => $request->alasan,
        //     'lama_cuti' => $request->lama,
        //     'tgl_mulai' => $request->tgl_awal,
        //     'tgl_akhir' => $request->tgl_akhir,
        //     'alamat_cuti' => $request->alamatcuti,
        //     'telp' => $request->nohp,
        //     // 'atasan_langsung' => $request->atasan_langsung,
        //     // 'pejabat_berwenang' => $request->ppk,
        //     'status' => 'Draft'
        // ]);
        // return redirect('/cuti')->with('status', 'Permohonan Cuti Berhasil Disimpan..!');
    }

    public function savedetailcutiuser(Request $request)
    {
        //  dd($request)->all();
        // return view('cuti.tambahmaster');
        // dd($request->all());
        $request->validate([
            'alasan' => 'Required',
            'jenis' => 'Required',
            'tgl_awal' => 'Required',
            'lama' => 'Required',
            'tgl_akhir' => 'Required',
            'alamatcuti' => 'Required',
            'nohp' => 'Required'
            // 'ppk' => 'Required',
            // 'atasan_langsung' => 'Required'

        ]);


        if ($request->hasfile('file')) {

            $file = $request->file('file');
            $nama_file = "DokCuti" . time() . "_" . $file->getClientOriginalName();
            $tujuan_upload = 'images';
            $file->move($tujuan_upload, $nama_file);
        }

        //dd($request->atasan_langsung);
        $satker = DB::table('users')
            ->join('satkers', 'satkers.id', '=', 'users.satker_id')
            ->select('satkers.nama_satker')
            ->where('users.username', Auth::User()->username)
            ->get();

        foreach ($satker as $satker) {
            $nama_satker = $satker->nama_satker;
        }

        // $atasan = explode('-', $request->atasan_langsung, 2);
        // $pejabat = explode('-', $request->ppk, 2);
        //dd($atasan[0]);
        if ($request->hasfile('file')) {
            CutiDetail::create([
                'master_cutis_id' => $request->id_cuti,
                'jenis_cuti' => $request->jenis,
                'alasan_cuti' => $request->alasan,
                'lama_cuti' => $request->lama,
                'tgl_mulai' => $request->tgl_awal,
                'tgl_akhir' => $request->tgl_akhir,
                'alamat_cuti' => $request->alamatcuti,
                'telp' => $request->nohp,
                // 'atasan_langsung' => $atasan[0],
                // 'nama_atasan_langsung' => $atasan[1],
                // 'pejabat_berwenang' => $pejabat[0],
                // 'nama_pejabat_berwenang' => $pejabat[1],
                'status' => 'Usulan Baru',
                'posisi' => '1',
                'satker' => $nama_satker,
                'dok_cuti' => $nama_file
            ]);
        } else {
            CutiDetail::create([
                'master_cutis_id' => $request->id_cuti,
                'jenis_cuti' => $request->jenis,
                'alasan_cuti' => $request->alasan,
                'lama_cuti' => $request->lama,
                'tgl_mulai' => $request->tgl_awal,
                'tgl_akhir' => $request->tgl_akhir,
                'alamat_cuti' => $request->alamatcuti,
                'telp' => $request->nohp,
                // 'atasan_langsung' => $atasan[0],
                // 'nama_atasan_langsung' => $atasan[1],
                // 'pejabat_berwenang' => $pejabat[0],
                // 'nama_pejabat_berwenang' => $pejabat[1],
                'status' => 'Usulan Baru',
                'posisi' => '1',
                'satker' => $nama_satker
            ]);
        }
        app('App\Http\Controllers\CutiController')->kirimwa(Auth::user()->username);
        // $kirim = kirimwa();
        return redirect('/cutiuser')->with('status', 'Permohonan Cuti Berhasil Disimpan..!');
    }

    public function caripegawai(Request $request)
    {
        $NIP = $request->get('nip');
        // $NIP = '198512282011011009';
        // dd($NIP);
        $pegawai = DB::table('users')
            ->join('satkers', 'satkers.id', '=', 'users.satker_id')
            ->select('users.*', 'satkers.nama_satker')
            // ->where('master_cutis.aktif', '1', 'and')
            // ->where('master_cutis.id_satker', Auth::User()->satker_id, 'and')
            ->where('users.username', $NIP)
            ->get();

        // dd($pegawai);
        foreach ($pegawai as $isi) {
            $data = array(
                'nip' => $isi->username,
                'nama' => $isi->name,
                'jabatan' => $isi->jabatan,
                'satker' => $isi->nama_satker,
                'id_satker' => $isi->satker_id,
            );
        }
        //dd($data);
        echo json_encode($data);
    }

    public function approvalcuti()
    {

        $role = Auth::User()->role;
        $username = Auth::User()->username;

        $cuti = DB::table('master_cutis')
            ->join('master_cutis_detail', 'master_cutis.id', '=', 'master_cutis_detail.master_cutis_id')
            ->join('satkers', 'satkers.id', '=', 'master_cutis.id_satker')
            ->select('master_cutis_detail.*', 'master_cutis.*', 'satkers.nama_satker', 'master_cutis_detail.id as id_detail')
            // ->where('master_cutis.tahun_anggaran', $tahun, 'and')
            ->where('master_cutis.aktif', '1', 'and')
            ->orderBy('master_cutis_detail.created_at', 'desc')
            // ->where('master_cutis.nip', $username)
            ->get();




        // dd($cuti);
        return view('cuti.approvalcuti', ([
            'cuti' => $cuti
            // 'role' => $role
        ]));
    }

    public function approvalcutikepeg($id)
    {
        // $role = Auth::User()->role;
        // $username = Auth::User()->username;
        $user = User::all()->where('acc_cuti', 1)->where('deleted', 0);
        $user2 = User::all()->where('acc_cuti', 1)->where('deleted', 0);

        $cuti = DB::table('master_cutis')
            ->join('master_cutis_detail', 'master_cutis.id', '=', 'master_cutis_detail.master_cutis_id')
            ->join('satkers', 'satkers.id', '=', 'master_cutis.id_satker')
            ->select('master_cutis_detail.*', 'master_cutis.*', 'master_cutis.nama as nama',  'satkers.nama_satker', 'master_cutis_detail.id as id_detail')
            ->where('master_cutis.aktif', '1', 'and')
            ->where('master_cutis_detail.id', $id)
            ->get()->first();

	    // tambahan ardi - 6 september 2023
        $tgl_mulai = $cuti->tgl_mulai;
        $tgl_akhir = $cuti->tgl_akhir;
        $num_days = floor((strtotime($tgl_akhir)-strtotime($tgl_mulai))/(60*60*24));
        $persen = array();
        for ($i=0; $i<=$num_days; $i++) {
            if (date('N', strtotime($tgl_mulai . "+ $i days")) <= 7) {
                $dt = date('Y-m-d', strtotime($tgl_mulai . "+ $i days"));

                // $jml = DB::table('master_cutis_detail')
                //         ->where('master_cutis_detail.tgl_mulai', $dt)
                //         ->count();

                $jml = DB::select("SELECT COUNT(*) AS jumlah_pegawai_cuti FROM master_cutis_detail
                                    WHERE ? BETWEEN tgl_mulai AND tgl_akhir", [$dt]);
                $persen[$dt] = $jml[0]->jumlah_pegawai_cuti;
            }
        }
        $jml_pegawai = DB::table('users')
                       ->where('satker_id', 28)
                       ->where('deleted', 0)
                       ->count();
        // end tambahan ardi - 6 september 2023

        return view('cuti.approvalcutikepeg', ([
            'cuti' => $cuti,
            'user' => $user,
            'user2' => $user2,
            'persen'      => $persen,
            'jml_pegawai' => $jml_pegawai
            // 'role' => $role
        ]));
    }

    public function saveapprovalcutikepeg(Request $request, $id)
    {
        $atasan = explode('-', $request->atasan_langsung, 2);
        $pejabat = explode('-', $request->ppk, 2);

        if ($request->hasil == 'Diterima') {

            $request->validate([
                'atasan_langsung' => 'Required',
                'ppk' => 'Required'
            ]);

            $update = DB::table('master_cutis_detail')
                ->where('id', $id)
                ->update([
                    'atasan_langsung' => $atasan[0],
                    'nama_atasan_langsung' => $atasan[1],
                    'pejabat_berwenang' => $pejabat[0],
                    'nama_pejabat_berwenang' => $pejabat[1],
                    'status' => 'Persetujuan Atasan',
                    'posisi' => '2',
                    'keterangan' => $request->keterangan
                ]);

            $telp = DB::table('users')
                ->where('username', $atasan[0])
                ->get()->first();
            // dd($telp);
            app('App\Http\Controllers\CutiController')->kirimwa_atasan($telp->telp, $request->nama);
        } else {

            $request->validate([
                // 'atasan_langsung' => 'Required',
                'keterangan' => 'Required'
            ]);

            $update = DB::table('master_cutis_detail')
                ->where('id', $id)
                ->update([
                    'status' => 'Ditolak',
                    'keterangan' => $request->keterangan,
                    'posisi' => '1'
                ]);
            $telp = DB::table('users')
                ->where('username', $request->nip)
                ->get()->first();
            app('App\Http\Controllers\CutiController')->kirimwa_pegawai($telp->telp, $request->nama, $request->hasil);
        }
        return redirect('/approvalcuti')->with('status', 'Permohonan Cuti Berhasil Disimpan..!');
    }

    public function upload_persetujuan($id)
    {
        $user = User::all()->where('acc_cuti', 1);
        $user2 = User::all()->where('acc_cuti', 1);

        $cuti = DB::table('master_cutis')
            ->join('master_cutis_detail', 'master_cutis.id', '=', 'master_cutis_detail.master_cutis_id')
            ->join('satkers', 'satkers.id', '=', 'master_cutis.id_satker')
            ->select('master_cutis_detail.*', 'master_cutis.*', 'master_cutis.nama as nama',  'satkers.nama_satker', 'master_cutis_detail.id as id_detail')
            ->where('master_cutis.aktif', '1', 'and')
            ->where('master_cutis_detail.id', $id)
            ->get()->first();

        return view('cuti.uploadpersetujuan', ([
            'cuti'        => $cuti,
        ]));
    }

    public function saveupload_persetujuan(Request $request, $id)
    {
        if ($request->hasfile('file')) {
            $file = $request->file('file');

            $extension = $file->getClientOriginalExtension();
            $allow = ['pdf','jpg','png','jpeg','doc','docx','.xls','.xlsx'];

            if (in_array($extension, $allow)) {
                $nama_file = "DokPersetujuan" . time() . "_" . $file->getClientOriginalName();
                $tujuan_upload = 'images';
                $file->move($tujuan_upload, $nama_file);
            }
        }

        $update = DB::table('master_cutis_detail')
                  ->where('id', $id)
                  ->update([
                      'dok_persetujuan' => $request->hasfile('file') ? $nama_file : null
                  ]);

        return redirect('/approvalcuti')->with('status', 'Persetujuan Cuti Berhasil Diupload..!');
    }

    public function approvalcutiatasan()
    {

        $username = Auth::User()->username;



        $cuti = DB::table('master_cutis')
            ->join('master_cutis_detail', 'master_cutis.id', '=', 'master_cutis_detail.master_cutis_id')
            ->join('satkers', 'satkers.id', '=', 'master_cutis.id_satker')
            ->select('master_cutis_detail.*', 'master_cutis.*', 'satkers.nama_satker', 'master_cutis_detail.id as id_detail')
            // ->where('master_cutis.tahun_anggaran', $tahun, 'and')
            ->where('master_cutis.aktif', '1', 'and')
            ->where('master_cutis_detail.atasan_langsung', $username, 'and')
            ->where('posisi', '2')
            ->orderBy('master_cutis_detail.created_at', 'desc')
            // ->where('master_cutis.nip', $username)
            ->get();


        // dd($cuti);
        return view('cuti.approvalcutiatasan', ([
            'cuti' => $cuti
            // 'role' => $role
        ]));
    }

    public function approvalcutiatasandetail($id)
    {



        $cuti = DB::table('master_cutis')
            ->join('master_cutis_detail', 'master_cutis.id', '=', 'master_cutis_detail.master_cutis_id')
            ->join('satkers', 'satkers.id', '=', 'master_cutis.id_satker')
            ->select('master_cutis_detail.*', 'master_cutis.*', 'master_cutis.nama as nama',  'satkers.nama_satker', 'master_cutis_detail.id as id_detail')
            ->where('master_cutis.aktif', '1', 'and')
            ->where('master_cutis_detail.id', $id)
            ->get()->first();


        // dd($cuti);
        return view('cuti.approvalcutiatasandetail', ([
            'cuti' => $cuti

        ]));
    }

    public function saveapprovalcutiatasan(Request $request, $id)
    {

        $request->validate([
            'hasil' => 'Required'
        ]);

        if ($request->hasil == 'Disetujui') {

            $update = DB::table('master_cutis_detail')
                ->where('id', $id)
                ->update([
                    'status' => 'Persetujuan Ketua',
                    'posisi' => '3',
                    'keterangan' => $request->keterangan
                ]);

            // $ppk = DB::table('master_cutis_detail')
            //     ->where('id', $id)
            //     ->get()->first();
            // dd($request->all(), $request->pejabat_berwenang, $request->ppk);
            $telp = DB::table('users')
                ->select('telp')
                ->where('username', $request->pejabat_berwenang)
                ->get()->first();
            // dd($telp);
            app('App\Http\Controllers\CutiController')->kirimwa_atasan($telp->telp, $request->nama);
        } else {
            $update = DB::table('master_cutis_detail')
                ->where('id', $id)
                ->update([
                    'status' => $request->hasil,
                    'keterangan' => $request->keterangan,
                    'posisi' => '1'
                ]);
            $telp = DB::table('users')
                ->where('username', $request->nip)
                ->get()->first();
            app('App\Http\Controllers\CutiController')->kirimwa_pegawai($telp->telp, $request->nama, $request->hasil);
        }
        return redirect('/approvalcutiatasan')->with('status', 'Permohonan Cuti Berhasil Disimpan..!');
    }

    public function approvalcutippk()
    {

        $username = Auth::User()->username;



        $cuti = DB::table('master_cutis')
            ->join('master_cutis_detail', 'master_cutis.id', '=', 'master_cutis_detail.master_cutis_id')
            ->join('satkers', 'satkers.id', '=', 'master_cutis.id_satker')
            ->select('master_cutis_detail.*', 'master_cutis.*', 'satkers.nama_satker', 'master_cutis_detail.id as id_detail')
            // ->where('master_cutis.tahun_anggaran', $tahun, 'and')
            ->where('master_cutis.aktif', '1', 'and')
            ->where('master_cutis_detail.pejabat_berwenang', $username, 'and')
            ->where('posisi', '3')
            ->orderBy('master_cutis_detail.created_at', 'desc')
            // ->where('master_cutis.nip', $username)
            ->get();


        // dd($cuti);
        return view('cuti.approvalcutippk', ([
            'cuti' => $cuti
            // 'role' => $role
        ]));
    }

    public function approvalcutippkdetail($id)
    {


        $cuti = DB::table('master_cutis')
            ->join('master_cutis_detail', 'master_cutis.id', '=', 'master_cutis_detail.master_cutis_id')
            ->join('satkers', 'satkers.id', '=', 'master_cutis.id_satker')
            ->select('master_cutis_detail.*', 'master_cutis.*', 'master_cutis.nama as nama',  'satkers.nama_satker', 'master_cutis_detail.id as id_detail')
            ->where('master_cutis.aktif', '1', 'and')
            ->where('master_cutis_detail.id', $id)
            ->get()->first();


        // dd($cuti);
        return view('cuti.approvalcutippkdetail', ([
            'cuti' => $cuti

        ]));
    }

    public function saveapprovalcutippk(Request $request, $id)
    {

        $request->validate([
            'hasil' => 'Required'
        ]);

        $saldocuti = DB::table('master_cutis')
            ->where('id', $request->id_master)
            ->get()->first();

        $lama_cuti = $request->lama_cuti;
        $saldoawalt2 = $saldocuti->sisa_tahun_t2;
        $saldoawalt1 = $saldocuti->sisa_tahun_t1;
        $saldoawalt0 = $saldocuti->sisa_tahun_t0;
        $sisacs = $saldocuti->sisa_cs;
        $sisacap = $saldocuti->sisa_cap;

        if ($request->hasil == 'Disetujui') {
            if ($request->jenis_cuti == 'CT') {
                if ($saldoawalt2 > 0) {
                    $saldoakhir2 = $saldoawalt2 - $lama_cuti;
                    if ($saldoakhir2 < 0) {
                        $saldoakhir1 = $saldoawalt1 + $saldoakhir2;
                        if ($saldoakhir1 < 0) {
                            $saldoakhir0 = $saldoawalt0 + $saldoakhir1;
                            DB::table('master_cutis')
                                ->where('id', $request->id_master)
                                ->update([
                                    'sisa_tahun_t0' => $saldoakhir0,
                                    'sisa_tahun_t1' => 0,
                                    'sisa_tahun_t2' => 0
                                ]);
                        } else {
                            DB::table('master_cutis')
                                ->where('id', $request->id_master)
                                ->update([
                                    'sisa_tahun_t1' => $saldoakhir1,
                                    'sisa_tahun_t2' => 0
                                ]);
                        }
                    } else {
                        DB::table('master_cutis')
                            ->where('id', $request->id_master)
                            ->update([
                                'sisa_tahun_t2' => $saldoakhir2,
                            ]);
                    }
                } elseif ($saldoawalt1 > 0) {
                    $saldoakhir1 = $saldoawalt1 - $lama_cuti;
                    if ($saldoakhir1 < 0) {
                        $saldoakhir0 = $saldoawalt0 + $saldoakhir1;
                        DB::table('master_cutis')
                            ->where('id', $request->id_master)
                            ->update([
                                'sisa_tahun_t0' => $saldoakhir0,
                                'sisa_tahun_t1' => 0
                            ]);
                    } else {
                        DB::table('master_cutis')
                            ->where('id', $request->id_master)
                            ->update([
                                'sisa_tahun_t1' => $saldoakhir1
                            ]);
                    }
                } elseif ($saldoawalt0 > 0) {
                    $saldoakhir0 = $saldoawalt0 - $lama_cuti;
                    DB::table('master_cutis')
                        ->where('id', $request->id_master)
                        ->update([
                            'sisa_tahun_t0' => $saldoakhir0
                        ]);
                }
            } elseif ($request->jenis_cuti == 'CS') {
                $saldoakhir0 = $sisacs - $lama_cuti;
                DB::table('master_cutis')
                        ->where('id', $request->id_master)
                        ->update([
                            'sisa_cs' => $saldoakhir0
                        ]);
            } elseif ($request->jenis_cuti == 'CAP') {
                $saldoakhir0 = $sisacap - $lama_cuti;
                DB::table('master_cutis')
                        ->where('id', $request->id_master)
                        ->update([
                            'sisa_cap' => $saldoakhir0
                        ]);
            }

            $update = DB::table('master_cutis_detail')
                ->where('id', $id)
                ->update([
                    'status' => 'Disetujui',
                    'posisi' => '1',
                    'keterangan' => $request->keterangan
                ]);
        } else {
            $update = DB::table('master_cutis_detail')
                ->where('id', $id)
                ->update([
                    'status' => $request->hasil,
                    'keterangan' => $request->keterangan,
                    'posisi' => '1'
                ]);
        }

        // kirim wa ke ybs
        $telp = DB::table('users')
            ->where('username', $request->nip)
            ->get()->first();
        app('App\Http\Controllers\CutiController')->kirimwa_pegawai($telp->telp, $request->nama, $request->hasil);

        return redirect('/approvalcutippk')->with('status', 'Permohonan Cuti Berhasil Disimpan..!');
    }

    public function saldocuti()
    {
        $user = Auth::user()->username;
        $tahun = date('Y');
        $saldo = DB::table('master_cutis')
            ->where('nip', $user, 'and')
            ->where('tahun_anggaran', $tahun)
            ->get()->first();

        // dd($saldo);
        if (!$saldo) {
            return redirect('/dashboard')->with('error', 'Mohon isi saldo awal cuti terlebih dahulu..!');
        }

        return view('cuti.saldocuti', ([
            'cuti' => $saldo
        ]));
    }

    public function kirimwa($id)
    {


        $cuti = cuti::where('nip', $id)
            ->get()->first();
        $pesan = '*Cuti Notifikasi :* Permohonan Cuti atas nama  ' . $cuti->nama . ' mohon agar segera diproses. Terima Kasih. Aplikasi Cuti dapat diakses pada link berikut http://cuti.pta-bandung.go.id';


        $curl = curl_init();
        $data = [
            "message" => $pesan,
            "jid" => "6285759002978",
            "apikey" => "LRAJCoktkM3t"
        ];
        $payload = json_encode($data);

        $ch = curl_init("https://whatsva.com/api/sendMessageText");
        # Setup request to send json via POST.

        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        # Return response instead of printing.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        # Send request.
        $result = curl_exec($ch);
        curl_close($ch);
        # Print response.
        // dd($result);
    }

    public function kirimwa_atasan($id, $nama)
    {

        $pesan = '*Cuti Notifikasi :* Permohonan Cuti atas nama  ' . $nama . ' mohon agar segera diproses. Terima Kasih
                Aplikasi Cuti dapat diakses pada http://cuti.pta-bandung.go.id';

        $curl = curl_init();
        $data = [
            "message" => $pesan,
            "jid" => $id,
            "apikey" => "LRAJCoktkM3t"
        ];
        $payload = json_encode($data);

        $ch = curl_init("https://whatsva.com/api/sendMessageText");
        # Setup request to send json via POST.

        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        # Return response instead of printing.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        # Send request.
        $result = curl_exec($ch);
        curl_close($ch);
        # Print response.
        // dd($result);
    }

    public function kirimwa_pegawai($id, $nama, $status)
    {

        $pesan = '*Cuti Notifikasi :* Permohonan Cuti atas nama  ' . $nama . ' ' . $status . ' Terima Kasih
        Aplikasi Cuti dapat diakses pada http://cuti.pta-bandung.go.id';

        $curl = curl_init();
        $data = [
            "message" => $pesan,
            "jid" => $id,
            "apikey" => "LRAJCoktkM3t"
        ];
        $payload = json_encode($data);

        $ch = curl_init("https://whatsva.com/api/sendMessageText");
        # Setup request to send json via POST.

        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        # Return response instead of printing.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        # Send request.
        $result = curl_exec($ch);
        curl_close($ch);
        # Print response.
        // dd($result);
    }

    // tambahan ardi - 18 april 2024
    public function editcuti($id)
    {
        $cuti = DB::table('master_cutis')
                ->join('master_cutis_detail', 'master_cutis.id', '=', 'master_cutis_detail.master_cutis_id')
                ->join('satkers', 'satkers.id', '=', 'master_cutis.id_satker')
                ->select('master_cutis_detail.*', 'master_cutis.*', 'master_cutis.nama as nama',  'satkers.nama_satker', 'master_cutis_detail.id as id_detail')
                ->where('master_cutis.aktif', '1', 'and')
                ->where('master_cutis_detail.id', $id)
                ->get()->first();

        // dd($cuti);

        return view('cuti.editcuti', ([
            'cuti' => $cuti,
            'id' => $id,
        ]));
    }

    public function updatecuti(Request $request)
    {
        try {
            $update = DB::table('master_cutis_detail')
                ->where('id', $request->id)
                ->update([
                    'jenis_cuti'  => $request->jenis,
                    'alasan_cuti' => $request->alasan,
                    'alamat_cuti' => $request->alamatcuti,
                    'lama_cuti'   => $request->lama,
                    'tgl_mulai'   => $request->tgl_mulai,
                    'tgl_akhir'   => $request->tgl_akhir,
                ]);
            return redirect('/approvalcuti')->with('status', 'Permohonan Cuti Berhasil Diubah');
        } catch (\Exception $e) {
            // $e->getMessage()
            return redirect('/approvalcuti')->with('error', 'Permohonan Cuti Gagal Diubah');
        }
    }
}
