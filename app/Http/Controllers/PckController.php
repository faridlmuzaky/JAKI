<?php

namespace App\Http\Controllers;

// use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\User;
use App\Models\Pck;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;

use function PHPUnit\Framework\isNull;
use ZipArchive;
use Illuminate\Support\Str;

use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;

class PckController extends Controller
{
    public function index(Request $request)
    {
        $role = Auth::User()->role;
        $username = Auth::User()->username;

        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        if (!$bulan) {
            $kurangi = $this->kurangi_bulan(date('m'), date('Y'));
            $bulan = $kurangi['bulan'];
            $tahun = $kurangi['tahun'];
        }

        $query = DB::table('users')
                 ->leftJoin('kinerja', function ($join) use ($bulan, $tahun) {
                    $join->on('kinerja.username', '=', 'users.username')
                         ->where('kinerja.bulan', '=', $bulan)
                         ->where('kinerja.tahun', '=', $tahun);
                  })
                 ->join('satkers', 'satkers.id', '=', 'users.satker_id')
                 ->leftJoin('satkers as b', 'b.id', '=', 'users.satker_perbantuan')
                 ->where('users.satker_id', '=', '28')
                 ->where('users.deleted', '=', '0')
                 ->where('users.name', '<>', 'Administrator')
                 ->whereNotIn('users.jabatan', ['Ketua','Wakil Ketua','Hakim Tinggi', 'PPNPN']);

        if ($role != 1) {
            $query->where('kinerja.username', '=', $username);
        }

        $query->orderBy('kinerja.nilai', 'desc')->orderBy('users.name', 'asc');
        $query->select('users.name', 'users.username', 'satkers.nama_satker', 'kinerja.id', 'kinerja.bulan', 'kinerja.tahun', 'kinerja.nilai', 'kinerja.file', 'b.nama_satker as bantu');
        $pck = $query->get();
        $list_bulan = $this->list_bulan();
        foreach ($pck as $row) {
            $row->bulan = $list_bulan[$row->bulan] ?? " ";
        }
        // dd($pck);
        return view('pck.index', ([
            'pck'        => $pck,
            'list_bulan' => $list_bulan,
            'list_tahun' => $this->list_tahun(),
            'bulan'      => $bulan,
            'tahun'      => $tahun,
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

    public function add()
    {
        $role = Auth::User()->role;
        $username = Auth::User()->username;

        $list_bulan = $this->list_bulan();
        $list_tahun = $this->list_tahun();

        $kurangi = $this->kurangi_bulan(date('m'), date('Y'));
        $bulan = $kurangi['bulan'];
        $tahun = $kurangi['tahun'];

        if ($role == 1) {
            $user = User::all()->where('deleted', 0)->where('satker_id', '28')->sortBy('name');
        } else {
            $user = User::all()->where('deleted', 0)->where('username', $username);
        }

        return view('pck.add', ([
            'list_bulan' => $list_bulan,
            'list_tahun' => $list_tahun,
            'user'       => $user,
            'bulan'      => $bulan,
            'tahun'      => $tahun,
        ]));
    }

    public function store(Request $request) {
        $messages = [
            'username.required' => 'Pegawai Harus Dipilih.',
            'nilai.required' => 'Nilai Harus Diisi.',
            'file.required' => 'File PDF harus diunggah.',
            'file.mimes' => 'File harus dalam format PDF.',
            'file.max' => 'Ukuran file tidak boleh lebih dari 2 MB.',
        ];
        $validated = $request->validate([
            'username' => 'Required',
            'nilai'    => 'Required',
            'file'     => 'required|file|mimes:pdf|max:2048',
        ], $messages);

        $nama_file = null;
        if ($request->hasfile('file')) {
            // $file = $request->file('file');
            // $replace = str_replace(" ", "_", $file->getClientOriginalName());
            // $nama_file = "PCK_" . time() . "_" . $replace;
            // $tujuan_upload = 'pck';
            // $file->move($tujuan_upload, $nama_file);
            $namaFile = 'pkp_' . $request->username . '_' . $request->bulan . '_' . $request->tahun . '_' . time() . '.' . $request->file('file')->getClientOriginalExtension();
            $nama_file = $request->file('file')->storeAs('pck_files', $namaFile, 'private');
        }

        $ketemu = Pck::where('username', $request->username)->where('bulan', $request->bulan)->where('tahun', $request->tahun)->first();
        if ($ketemu) {
            $this->store_update($ketemu, $request);
        }

        Pck::create([
            'username'   => $request->username,
            'satker_id'  => '28',
            'bulan'      => $request->bulan,
            'tahun'      => $request->tahun,
            'nilai'      => $request->nilai,
            'file'       => $nama_file,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        return redirect('/kinerja')->with('status', 'Panilaian Capaian Kinerja Berhasil Disimpan..!');
    }

    public function edit($id)
    {
        $data = Pck::find($id);
        $role = Auth::User()->role;
        $username = Auth::User()->username;
        $list_bulan = $this->list_bulan();
        $list_tahun = $this->list_tahun();

        if ($role == 1) {
            $user = User::all()->where('deleted', 0)->where('satker_id', '28')->sortBy('name');
        } else {
            $user = User::all()->where('deleted', 0)->where('username', $username);
        }

        return view('pck.edit', ([
            'data'       => $data,
            'list_bulan' => $list_bulan,
            'list_tahun' => $this->list_tahun(),
            'user'       => $user
        ]));
    }

    public function update(Request $request)
    {
	$nama_file = $request->file_existing;
        if ($request->hasfile('file')) {
            // if (file_exists('pck/'.$nama_file)) {
            //     unlink('pck/'.$nama_file);
            // }
            // $file = $request->file('file');
            // $nama_file = "PCK_" . time() . "_" . $file->getClientOriginalName();
            // $tujuan_upload = 'pck';
            // $file->move($tujuan_upload, $nama_file);

            if ($nama_file && Storage::disk('private')->exists($nama_file)) {
                Storage::disk('private')->delete($nama_file);
            }
            $namaFile = 'pkp_' . $request->username . '_' . $request->bulan . '_' . $request->tahun . '_' . time() . '.' . $request->file('file')->getClientOriginalExtension();
            $nama_file = $request->file('file')->storeAs('pck_files', $namaFile, 'private');
        }

        $update = DB::table('kinerja')
            ->where('id', $request->id)
            ->update([
                'bulan'      => $request->bulan,
                'tahun'      => $request->tahun,
                'nilai'      => $request->nilai,
                'file'       => $nama_file,
                'updated_at' => date("Y-m-d H:i:s"),
        ]);

        return redirect('/kinerja')->with('status', 'Data PCK telah diubah..!');
    }

    public function store_update($ketemu, Request $request)
    {
        $nama_file = $ketemu->file;

        $update = DB::table('kinerja')
            ->where('id', $ketemu->id)
            ->update([
                'bulan'      => $request->bulan,
                'tahun'      => $request->tahun,
                'nilai'      => $request->nilai,
                'file'       => $nama_file,
                'updated_at' => date("Y-m-d H:i:s"),
        ]);

        return redirect('/kinerja')->with('status', 'Data PCK telah diubah..!');
    }

    public function hapus_pck(Request $request)
    {
        $pck = Pck::find($request->id_pck);
        // if ($pck->file && Storage::disk('private')->exists($pck->file)) {
        //     Storage::disk('private')->delete($pck->file);
        // }
        if ($pck->file && Storage::disk('private')->exists($pck->file)) {
            Storage::disk('private')->delete($pck->file);
        } else if ($pck->file && Storage::disk('private')->exists('pck_files/'.$pck->file)) {
            Storage::disk('private')->delete('pck_files/'.$pck->file);
        }
        $pck->delete($pck);

        return redirect('/kinerja')->with('status', 'Data Berhasil Dihapus..!');
    }

    public function blast_wa()
    {
        $kurangi = $this->kurangi_bulan(date('m'), date('Y'));
        $bulan = $kurangi['bulan'];
        $tahun = $kurangi['tahun'];

        $query = DB::table('users')
                 ->leftJoin('kinerja', function ($join) use ($bulan, $tahun) {
                    $join->on('kinerja.username', '=', 'users.username')
                         ->where('kinerja.bulan', '=', $bulan)
                         ->where('kinerja.tahun', '=', $tahun);
                  })
                 ->join('satkers', 'satkers.id', '=', 'users.satker_id')
                 ->leftJoin('satkers as b', 'b.id', '=', 'users.satker_perbantuan')
                 ->where('users.satker_id', '=', '28')
                 ->where('users.deleted', '=', '0')
                 ->where('users.name', '<>', 'Administrator')
                 ->whereNotIn('users.jabatan', ['Ketua','Wakil Ketua','Hakim Tinggi', 'PPNPN']);

        $query->orderBy('kinerja.nilai', 'desc')->orderBy('users.name', 'asc');
        $query->select('users.name', 'users.username', 'satkers.nama_satker', 'kinerja.id', 'kinerja.bulan', 'kinerja.tahun', 'kinerja.nilai', 'kinerja.file', 'b.nama_satker as bantu');
        $pck = $query->get();

        $count = 0;
        foreach ($pck as $row) {
            if (!$row->nilai) {
                $user = User::where('username', $row->username)->first();
                $this->kirim($user->telp);
                $count = $count +1;
            }
        }

        return redirect('/kinerja')->with('status', 'Pesan Whatsapp Undangan Telah Dikirim ke '.$count.' Pegawai.');
    }

    public function kirim_wa($username)
    {
        $user = User::where('username', $username)->first();
        $this->kirim($user->telp);
        // dd($user);
        return redirect('/kinerja')->with('status', 'Pesan Whatsapp Undangan Telah Dikirim..!');
    }

    public function kirim($nohp)
    {
        $pesan = '*Reminder PKP :*
Assalamualaikum Wr. Wb.
Bapak/Ibu mohon untuk segera input PKP / PCK bulanan melalui aplikasi jaki > menu *Kinerja*.

Agar pengajuan tunjangan kinerja tidak terhambat, kami mohon kerjasama nya. Terima Kasih.

Pesan ini otomatis dikirim melalui aplikasi JAKI yang dapat diakses pada link berikut https://jaki.pta-bandung.go.id';

//         $pesan = '*Reminder PKP dan SKP :*
// Assalamualaikum Wr. Wb.

// Bapak/Ibu, dikarenakan WFH dan libur lebaran, mohon untuk mempersiapkan PKP / PCK bulanan,
// dan Realisasi SKP Triwulan I Tahun 2025.

// Agar pengajuan tunjangan kinerja tidak terhambat, kami mohon kerjasama nya. Terima Kasih.

// Pesan ini otomatis dikirim melalui aplikasi JAKI yang dapat diakses pada link berikut http://jaki.pta-bandung.go.id';

        $curl = curl_init();
        $data = [
            "message" => $pesan,
            "jid" => $nohp,
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

    public function download($id)
    {
        $id = decrypt($id);
        $pck = Pck::findOrFail($id);
        $filePath = storage_path('app/private/pck_files/' . $pck->file);
        if (!file_exists($filePath)) {
	    $filePath = storage_path('app/private/' . $pck->file);
	    if (!file_exists($filePath)) {
		    abort(404, 'File tidak ditemukan');
	    }
        }
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"'
        ]);
    }

    public function rename_file() {
        $bulan = 5;
        $tahun = 2025;

        $pkp = DB::table('kinerja')
                ->join('users', 'kinerja.username', '=', 'users.username')
                ->where('kinerja.bulan', $bulan)
                ->where('kinerja.tahun', $tahun)
                ->select('kinerja.id', 'kinerja.username', 'kinerja.file', 'users.name')
                ->get();

        $prefixes = ['Dr. ', 'Drs.', 'H.', 'Hj.', 'Dra.'];

        foreach ($pkp as $item) {
            $nama = $item->name;
            $nama = str_replace($prefixes, '', $nama);
	    $nama = str_replace(' ', '_', trim($nama));
            $oldFileName = $item->file;
            $newFileName = $nama .'_'. $bulan .'_'. $tahun . '_' . time() . '.pdf';

            // Cek file ada
            //if (!Storage::disk('private')->exists('pck_files/' . $oldFileName)) {
            if (!Storage::disk('private')->exists($oldFileName)) {
                return "File lama tidak ditemukan di storage private." . $oldFileName;
            }
            // Rename (move)
            Storage::disk('private')->move($oldFileName, 'pck_files/' . $newFileName);
            //Storage::disk('private')->move('pck_files/' . $oldFileName, 'pck_files/' . $newFileName);

            // Update nama file di database
            DB::table('kinerja')
                ->where('id', $item->id)
                ->update(['file' => 'pck_files/'.$newFileName]);
        }
    }

    public function downloadZip($bulan, $tahun)
    {
        if (!Storage::exists('temp')) {
            Storage::makeDirectory('temp');
        }

        // Ambil semua file yang sesuai bulan & tahun
        $files = DB::table('kinerja')
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->pluck('file'); // hanya ambil nama file

        if ($files->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada file untuk bulan dan tahun tersebut.');
        }

        // Nama zip
        $zipFileName = 'PCK_'.$bulan.'_'.$tahun.'_'.Str::random(5).'.zip';
        $zipPath = storage_path('app/temp/' . $zipFileName);

        // Pastikan folder temp ada
        if (!Storage::exists('temp')) {
            Storage::makeDirectory('temp');
        }

        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            \Log::error("Gagal membuka file ZIP: $zipPath");
            return back()->with('error', 'Gagal membuka file ZIP.');
        }

        foreach ($files as $file) {
            $filePath = storage_path('app/private/' . $file);

            if (!file_exists($filePath)) {
                \Log::warning("File tidak ditemukan saat mau dimasukkan ke ZIP: $filePath");
                continue; // skip file yg gak ada
            }

            if (!$zip->addFile($filePath, $file)) {
                \Log::warning("Gagal menambah file ke ZIP: $filePath");
            }
        }

        if (!$zip->close()) {
            \Log::error("Gagal menutup (save) file ZIP: $zipPath");
            return back()->with('error', 'Gagal menyimpan file ZIP.');
        }

        if (!file_exists($zipPath)) {
            \Log::error("File ZIP tidak ditemukan setelah close: $zipPath");
            return back()->with('error', 'File ZIP tidak ditemukan setelah dibuat.');
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);

        return redirect('/kinerja')->with('error', 'Gagal membuat file ZIP.');
    }

    public function mergePdf($bulan, $tahun)
    {	
        $pdf = new Fpdi();

        // Ambil semua file yang sesuai bulan & tahun
        $files = DB::table('kinerja')
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->pluck('file'); // hanya ambil nama file

        if ($files->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada file untuk bulan dan tahun tersebut.');
        }

        foreach ($files as $file) {
            $fullPath = storage_path('app/private/' . $file);

            if (!file_exists($fullPath)) {
                \Log::warning("File tidak ditemukan: $fullPath");
                continue;
            }

            $pageCount = $pdf->setSourceFile($fullPath);

            for ($page = 1; $page <= $pageCount; $page++) {
                $tplIdx = $pdf->importPage($page);
                $size = $pdf->getTemplateSize($tplIdx);
                $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                $pdf->useTemplate($tplIdx);
            }
        }

        $outputPath = storage_path('app/temp/merged_' . time() . '.pdf');
        $pdf->Output($outputPath, 'F');

        return response()->download($outputPath)->deleteFileAfterSend(true);
    }
}
