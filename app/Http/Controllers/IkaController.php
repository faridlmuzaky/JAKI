<?php

namespace App\Http\Controllers;

// use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\User;
use App\Models\Ika;
use App\Http\Controllers\CutiController\kirimwa;
use BaconQrCode\Encoder\QrCode as EncoderQrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Block\Renderer\ThematicBreakRenderer;
use PhpOffice\PhpWord\TemplateProcessor;
use Carbon\Carbon;
use function PHPUnit\Framework\isNull;
use App\Helpers\FormatTanggal;

class IkaController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $role = Auth::User()->role;
        $username = Auth::User()->username;

        $query = DB::table('izin_keluar');
        if ($tanggal) {
            $query->where('izin_keluar.awal', '>=', $tanggal . ' 00:00:00')
                  ->where('izin_keluar.akhir', '<=', $tanggal . ' 23:59:00');
        }
        $ika = $query->orderBy('izin_keluar.created_at', 'desc')->get();

        return view('ika.index', ([
            'ika'     => $ika,
            'tanggal' => $tanggal
        ]));
    }

    public function add()
    {
        $ttd = User::all()->where('deleted', 0)->where('acc_cuti', 1)->sortBy('name');
        $user = User::all()->where('deleted', 0)->where('satker_id', '28')->sortBy('name');

        return view('ika.add', ([
            'ttd'  => $ttd,
            'user' => $user
        ]));
    }

    public function store(Request $request) {
        $ttd = explode("|", $request->ttd);
        $ika = explode("|", $request->pegawai);
        // dd($request->tgl_awal ." ". $request->jam_awal);
        Ika::create([
            'nama_ttd'    => $ttd[0],
            'jabatan_ttd' => $ttd[1],
            'nip_ika'     => $ika[0],
            'nama_ika'    => $ika[1],
            'awal'        => $request->tgl_awal ." ". $request->jam_awal,
            'akhir'       => $request->tgl_awal ." ". $request->jam_akhir,
            'keperluan'   => $request->keperluan,
        ]);

        return redirect('/ika')->with('status', 'IKA berhasil dibuat.!');
    }

    public function cetak($id)
    {
        $ika = Ika::find($id);

        $templateProcessor = new TemplateProcessor('template/izin_keluar.docx');
        $templateProcessor->setValue('nama_ttd', $ika->nama_ttd);
        $templateProcessor->setValue('jabatan_ttd', $ika->jabatan_ttd);
        $templateProcessor->setValue('nama', $ika->nama_ika);
        $templateProcessor->setValue('nip', $ika->nip_ika);
        $templateProcessor->setValue('tanggal', FormatTanggal::indo($ika->awal));
        $templateProcessor->setValue('jam', date("h:i", strtotime($ika->awal)));
        $templateProcessor->setValue('sampai', date("h:i", strtotime($ika->akhir)));
        $templateProcessor->setValue('keperluan', $ika->keperluan);
        $created_date = date("Y-m-d", strtotime($ika->created_at));
        $templateProcessor->setValue('created_at', $ika->created_date);

        $filename = 'IKA_' . $ika->nama_ika;
        $templateProcessor->saveAs($filename . '.docx');
        return response()->download($filename . '.docx')->deleteFileAfterSend(true);
    }
}
