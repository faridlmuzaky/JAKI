<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Rapat;
use App\Models\PesertaRapat;
use Carbon\Carbon;
use PhpOffice\PhpWord\TemplateProcessor;

class RapatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Rapat::where('status', '1')->orderByDesc('tgl_rapat')->get();

        return view('rapat.index', (['data' => $data]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $satker = Auth::user()->satker_id;

        $pimpinan = DB::table('users')
            ->where('satker_id', $satker)
            ->where('acc_cuti', 1)
            ->where('deleted', 0)
            ->orderBy('name')
            ->get();

        $user = user::where('satker_id', $satker)
            ->where('deleted', 0)
            ->orderBy('name')
            ->get();
        return view('rapat.tambah', ([
            'pimpinan' => $pimpinan,
            'notulis' => $user
        ]));
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
            'judul' => 'required',
            'jenis' => 'required',
            'pimpinan' => 'required',
            'tgl_rapat' => 'required',
            'waktu' => 'required',
            'notulis' => 'required',
            'chk' => 'required',
            'tempat' => 'required'
        ]);
        // dd(count($request->chk));
        $jumlah = DB::table('master_rapat')
            ->count();
        $jumlah = $jumlah + 1;

        $id_rapat = $request->jenis . $jumlah;

        Rapat::create([
            'deskripsi' => $request->judul,
            'tgl_rapat' => $request->tgl_rapat,
            'time_in' => $request->waktu,
            'pimpinan' => $request->pimpinan,
            'notulis' => $request->notulis,
            'jenis_rapat' => $request->jenis,
            'id_rapat' => $id_rapat,
            'tempat' => $request->tempat,
            'status' => '1',
            'foto' => $request->foto,
            'isPakaian'   => $request->has('pakaian_check') ? 1 : 0,
            'Pakaian'     => $request->pakaian,
        ]);


        foreach ($request->chk as $isi) {
            PesertaRapat::create([
                'id_rapat' => $id_rapat,
                'user' => $isi
            ]);
            // dd($isi);
        }

        return redirect('/rapat')->with('status', 'Data rapat Berhasil Disimpan..!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showpeserta($id)
    {
        //
        $data = DB::table('peserta_rapat')
            ->join('users', 'peserta_rapat.user', '=', 'users.username')
            ->select('peserta_rapat.user', 'users.name', 'users.jabatan', 'users.telp', 'peserta_rapat.id_rapat')
            ->where('peserta_rapat.id_rapat', $id)
            ->get();

        return view('rapat.peserta', (['data' => $data]), compact('id'));
    }

    public function daftarhadir($id)
    {
        $rapat = DB::table('master_rapat')->where('id_rapat', $id)->select('deskripsi', 'tgl_rapat', 'time_in')->first();

        $data = DB::select("SELECT pr.user, u.name, u.jabatan, u.telp, pr.id_rapat, pr.date_in, pr.time_in, pr.lokasi
                            FROM peserta_rapat pr JOIN users u ON pr.user=u.username WHERE pr.id_rapat=?
                            ORDER BY -pr.time_in desc, pr.id", [$id]);
	foreach ($data as $row) {
            $row->date_in = $row->date_in ? $this->tgl_indo($row->date_in) : null;
        }

        return view('rapat.kehadiran',
            ([
                'data'  => $data,
                'rapat' => $rapat
            ]),
            compact('id')
        );
    }

    public function cetaknotulensi($id)
    {
        $data = DB::select("SELECT r.*, n.username nip_notulis, p.username nip_pimpinan, p.jabatan j_pimpinan
                            FROM master_rapat r JOIN users p ON r.pimpinan=p.name JOIN users n ON r.notulis=n.name
                            WHERE r.id_rapat=?", [$id]);
        $rapat = $data[0];
        $tgl_rapat = $this->tgl_indo($rapat->tgl_rapat);
        $hari = $this->hari_ini(date('D', strtotime($rapat->tgl_rapat)));

        $data_peserta = DB::select("SELECT u.name FROM peserta_rapat r JOIN users u ON r.user=u.username WHERE id_rapat=?
                                    ORDER BY r.id", [$id]);

        $wordTable = new \PhpOffice\PhpWord\Element\Table();
        $wordTable->addRow();
        $cell = $wordTable->addCell();
        $notulensi = $rapat->notulensi ? $this->koreksi($rapat->notulensi) : null;
        if ($notulensi) {
            // dd($notulensi);
            \PhpOffice\PhpWord\Shared\Html::addHtml($cell, $notulensi);
        }

        if (count($data_peserta) <= 5) {
            $templateProcessor = new TemplateProcessor('template/notulensi_rapat.docx');
        } else {
            $templateProcessor = new TemplateProcessor('template/notulensi_rapat_lampiran_peserta.docx');
        }

        $templateProcessor->setValue('hari', $hari);
        $templateProcessor->setValue('tgl_rapat', $tgl_rapat);
        $templateProcessor->setValue('time_in', $rapat->time_in);
        $templateProcessor->setValue('tempat', $rapat->tempat);
        $templateProcessor->setValue('deskripsi', $rapat->deskripsi);
        $templateProcessor->setValue('pimpinan', $rapat->pimpinan);
        $templateProcessor->setValue('j_pimpinan', $rapat->j_pimpinan);
        $templateProcessor->setValue('nip_pimpinan', $rapat->nip_pimpinan);
        $templateProcessor->setValue('notulis', $rapat->notulis);
        $templateProcessor->setValue('nip_notulis', $rapat->nip_notulis);
        $templateProcessor->setComplexBlock('notulensi', $wordTable);
        $templateProcessor->setValue('PAGE_BREAK', '</w:t></w:r>'.'<w:r><w:br w:type="page"/></w:r><w:r><w:t>');

        // ComplexBlock Peserta Rapat
        $peserta = "";
        $peserta = "<ol>";
        foreach ($data_peserta as $row) {
            $peserta .= "<li>";
            $peserta .= $row->name;
            $peserta .= "</li>";
        }
        $peserta .= "</ol>";

        $pesertaTable = new \PhpOffice\PhpWord\Element\Table();
        $pesertaTable->addRow();
        $pesertaCell = $pesertaTable->addCell();
        \PhpOffice\PhpWord\Shared\Html::addHtml($pesertaCell, $peserta);
        $templateProcessor->setComplexBlock('peserta', $pesertaTable);
        // End ComplexBlock Peserta Rapat

        $filename = 'Notulensi_' . $rapat->deskripsi;
        $templateProcessor->saveAs($filename . '.docx');
        return response()->download($filename . '.docx')->deleteFileAfterSend(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function undangan(Request $request)
    {
        //
        $rapat = DB::table('master_rapat')
            ->select('*')
            ->where('id_rapat', $request->id_rapat)
            ->first();
        $tanggal = date('j F Y', strtotime($rapat->tgl_rapat));
        $waktu = $rapat->time_in;
        $title = $rapat->deskripsi;
        $tempat = $rapat->tempat;
        $isPakaian = $rapat->isPakaian;
        $pakaian = $rapat->pakaian;

        $tanggalbr = $rapat->tgl_rapat;
        $day = date('D', strtotime($tanggalbr));
        $dayList = array(
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jumat',
            'Sat' => 'Sabtu'
        );
        $hari = $dayList[$day];
        // dd($data);

        foreach ($request->chk as $item) {
            // $data = explode('-', $item);
            // echo $item . $tanggal . $waktu . $title;
            // echo "<br>";
            app('App\Http\Controllers\RapatController')->kirimundangan($item, $title, $tanggal, $waktu, $tempat, $hari, $isPakaian, $pakaian);
        }
        // dd($tanggal);
        return redirect('/rapat')->with('status', 'Pesan Whatsapp Undangan Telah Dikirim..!');
    }

    public function kirimundangan($id, $judul, $tgl, $waktu, $tempat, $hari, $isPakaian, $pakaian)
    {


        $pesan = '*Undangan Rapat :* 
Assalamualaikum Wr. Wb. 
Sehubungan akan dilaksanakannya ' . $judul . ', maka dengan ini kami mengundang Saudara untuk hadir pada acara tersebut yang akan dilaksanakan pada :

Hari : ' . $hari . '
Tanggal : ' . $tgl . '
Pukul : ' . $waktu . ' WIB s.d Selesai
Tempat : ' . $tempat;

if ($isPakaian) {
    $pesan .= '
Pakaian : '.$pakaian;
}

    $pesan .= '

Terima Kasih. Pesan ini otomatis dikirim melalui aplikasi JAKI yang dapat diakses pada link berikut https://jaki.pta-bandung.go.id';

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

    public function showrapat()
    {
        //
        $user = Auth::user()->username;

        $query = DB::table('master_rapat')
            ->join('peserta_rapat', 'peserta_rapat.id_rapat', '=', 'master_rapat.id_rapat')
            ->select('peserta_rapat.user', 'master_rapat.foto', 'master_rapat.deskripsi', 'master_rapat.tempat', 'master_rapat.tgl_rapat', 'master_rapat.time_in', 'master_rapat.jenis_rapat', 'master_rapat.notulis', 'master_rapat.pimpinan', 'master_rapat.id_rapat', 'peserta_rapat.time_in as waktu_absen')
            ->where('peserta_rapat.user', $user)
            ->where('master_rapat.status', '1');


        if (request('cari')) {
            $query->where('master_rapat.deskripsi', 'like', '%' . request('cari') . '%');
        }

        $query->orderBy('master_rapat.tgl_rapat', 'desc');

        // dd($query);
        $data = $query->paginate(6)->withQueryString();

        $agenda = DB::table('master_rapat')
            ->join('peserta_rapat', 'peserta_rapat.id_rapat', '=', 'master_rapat.id_rapat')
            ->select('peserta_rapat.user', 'master_rapat.foto', 'master_rapat.deskripsi', 'master_rapat.tempat', 'master_rapat.tgl_rapat', 'master_rapat.time_in', 'master_rapat.jenis_rapat', 'master_rapat.notulis', 'master_rapat.pimpinan', 'master_rapat.id_rapat', 'peserta_rapat.time_in as waktu_absen')
            ->where('peserta_rapat.user', $user)
            ->where('master_rapat.status', '1')
            ->where('tgl_rapat', '>=', date("Y-m-d"))
            ->paginate(5);

        return view('rapat.daftarrapat', (['data' => $data, 'agenda' => $agenda]));
    }

    public function isiabsen($id_rapat)
    {
        //

        $user = Auth::user()->username;
        $query = DB::table('master_rapat')
            ->join('peserta_rapat', 'peserta_rapat.id_rapat', '=', 'master_rapat.id_rapat')
            ->select('peserta_rapat.user', 'master_rapat.deskripsi', 'master_rapat.foto', 'master_rapat.tempat', 'master_rapat.tgl_rapat', 'master_rapat.time_in', 'master_rapat.jenis_rapat', 'master_rapat.notulis', 'master_rapat.pimpinan', 'master_rapat.id_rapat', 'peserta_rapat.time_in as waktu_absen', 'master_rapat.notulensi')
            ->where('peserta_rapat.user', $user)
            ->where('peserta_rapat.id_rapat', $id_rapat)
            ->get();

        return view('rapat.isiabsen', (['data' => $query]));
    }
    public function updateabsen(request $request)
    {
        //
        // dd($request->id_rapat,$request->user);

        $request->validate([
            'lokasinya' => 'required'
        ]);

        $date = date("Y-m-d");


        $time = date("H:i:s");
        $lokasi = $request->lokasinya;

        DB::table('peserta_rapat')
            ->where('id_rapat', '=', $request->id_rapat)
            ->where('user', '=', Auth::user()->username)
            ->update([
                'date_in' => $date,
                'time_in' => $time,
                'lokasi' => $lokasi
            ]);
        return redirect('/isiabsenrapat' . '/' . $request->id_rapat)->with('status', 'Presensi Berhasil Disimpan..!');
    }

    public function isinotula($id_rapat)
    {
        //

        $user = Auth::user()->username;
        $query = DB::table('master_rapat')
            ->join('peserta_rapat', 'peserta_rapat.id_rapat', '=', 'master_rapat.id_rapat')
            ->select('peserta_rapat.user', 'master_rapat.deskripsi', 'master_rapat.foto', 'master_rapat.tempat', 'master_rapat.tgl_rapat', 'master_rapat.time_in', 'master_rapat.jenis_rapat', 'master_rapat.notulis', 'master_rapat.pimpinan', 'master_rapat.id_rapat', 'peserta_rapat.time_in as waktu_absen', 'master_rapat.notulensi')
            ->where('peserta_rapat.user', $user)
            ->where('peserta_rapat.id_rapat', $id_rapat)
            ->get();

        return view('rapat.isinotula', (['data' => $query]));
    }

    public function savenotula(Request $request)
    {
        //
        // dd($request);
        $update =  DB::table('master_rapat')
            ->where('id_rapat', '=', $request->id_rapat)
            ->update([
                'notulensi' => $request->notula,
            ]);
        return redirect('/isiabsenrapat' . '/' . $request->id_rapat)->with('status', 'Notula Berhasil Disimpan..!');
    }

    public function hapus($id)
    {
        //
        $update = db::table('master_rapat')
            ->where('id_rapat', $id)
            ->update(['status' => '0']);
        return redirect('/rapat')->with('status', 'Data telah dihapus..!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $satker = Auth::user()->satker_id;
        $data = Rapat::where('status', '1')
            ->where('id_rapat', $id)
            ->get();

        $pimpinan = DB::table('users')
            ->where('satker_id', $satker)
            ->where('acc_cuti', 1)
            ->where('deleted', 0)
            ->get();

        $user = user::where('satker_id', $satker)
            ->where('deleted', 0)
            ->get();

        return view('rapat.edit', (['data' => $data, 'pimpinan' => $pimpinan, 'notulis' => $user]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //

        $request->validate([
            'judul' => 'required',
            'jenis' => 'required',
            'pimpinan' => 'required',
            'tgl_rapat' => 'required',
            'waktu' => 'required',
            'notulis' => 'required',
            'tempat' => 'required'
        ]);

        $update = db::table('master_rapat')
            ->where('id_rapat', $request->id_rapat)
            ->update([
                'deskripsi' => $request->judul,
                'jenis_rapat' => $request->jenis,
                'tgl_rapat' => $request->tgl_rapat,
                'time_in' => $request->waktu,
                'tempat' => $request->tempat,
                'notulis' => $request->notulis,
                'pimpinan' => $request->pimpinan,
                'foto' => $request->foto,
                'isPakaian'   => $request->has('pakaian_check') ? 1 : 0,
                'pakaian'     => $request->pakaian,
            ]);
        return redirect('/rapat')->with('status', 'Data ' . $request->judul . ' telah diubah..!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function tambahpeserta(Request $request)
    {
        //
        // dd($request->all());

        $request->validate([
            'namabaru' => 'required',
        ]);

        foreach ($request->namabaru as $isi) {
            PesertaRapat::create([
                'id_rapat' => $request->id_rapat1,
                'user' => $isi
            ]);
        }
        return redirect('/pesertarapat/' . $request->id_rapat1)->with('status', 'Peserta rapat telah diperbaharui..!');
    }

    public function hapuspeserta(request $request, $user)
    {
        //
        db::table('peserta_rapat')
            ->where('id_rapat', $request->id_rapat2)
            ->where('user', $user)
            ->delete();

        return redirect('/pesertarapat/' . $request->id_rapat2)->with('status', 'Peserta rapat telah diperbaharui..!');
    }

    function tgl_indo($tanggal){
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
        return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    }
    function hari_ini($hari) {
        switch($hari) {
            case 'Sun':
                $hari_ini = "Minggu";
            break;
            case 'Mon':
                $hari_ini = "Senin";
            break;
            case 'Tue':
                $hari_ini = "Selasa";
            break;
            case 'Wed':
                $hari_ini = "Rabu";
            break;
            case 'Thu':
                $hari_ini = "Kamis";
            break;
            case 'Fri':
                $hari_ini = "Jumat";
            break;
            case 'Sat':
                $hari_ini = "Sabtu";
            break;
            default:
                $hari_ini = "Tidak di ketahui";
            break;
        }
        return $hari_ini;
    }
    function koreksi($notulensi) {
        $notulensi = str_replace('<br>', '<br/>', $notulensi);
        $notulensi = str_replace('<p', '<br', $notulensi);
        $notulensi = str_replace('</p>', '</br>', $notulensi);
        $notulensi = str_replace("&quot;", "'", $notulensi);
        $notulensi = str_replace("<o:p>", "<p>", $notulensi);
        $notulensi = str_replace("</o:p>", "</p>", $notulensi);
        return $notulensi;
    }
}
