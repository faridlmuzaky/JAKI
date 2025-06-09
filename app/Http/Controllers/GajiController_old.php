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
use PhpOffice\PhpWord\IOFactory;
use \PhpOffice\PhpWord\Settings;
use Carbon\Carbon;

use function PHPUnit\Framework\isNull;

class GajiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $username = Auth::user()->username;

	$user = DB::table('users')->where('username', $username)->first();
        if ($user->jabatan=='PPNPN') {
            $username = $user->email;
        }

        $gaji = DB::connection('gaji')->table('gaji')
            ->where('gaji.nip', $username)
            ->orderByDesc('gaji.tahun')
            ->orderByDesc('gaji.bulan')
            ->get();

        foreach ($gaji as $row) {
            $row->bulan = $this->nama_bulan($row->bulan);
            $potongan = DB::connection('gaji')->table('potongan_gaji')->where('id_gaji', $row->id)->get();
            $jml_potongan = 0;
            foreach ($potongan as $pot) {
                $jml_potongan = $jml_potongan + $pot->jumlah;
            }
            $row->jumlah = $row->jumlah - $jml_potongan;
        }

        $tukin = DB::connection('gaji')->table('tukin')
            ->where('tukin.nip', $username)
            ->get();

        foreach ($tukin as $row) {
            $row->bulan = $this->nama_bulan($row->bulan);
            $potongan = DB::connection('gaji')->table('potongan_tukin')->where('id_tukin', $row->id)->get();
            $jml_potongan = 0;
            foreach ($potongan as $pot) {
                $jml_potongan = $jml_potongan + $pot->jumlah;
            }

            $row->netto = $row->netto - $jml_potongan;
        }

        $nip_um = substr($username, 0, 14);
        $um = DB::connection('gaji')->table('uang_makan')
            ->where('uang_makan.nip', $nip_um)
            ->get();

        foreach ($um as $row) {
            $row->bulan = $this->nama_bulan($row->bulan);
        }

        return view('gaji.index', ([
            'gaji'  => $gaji,
            'tukin' => $tukin,
            'um'    => $um,
        ]));
    }

    function nama_bulan($i) {
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
        return $bulan[$i];
    }

    public function cetakgaji($id)
    {
        $gaji = DB::connection('gaji')->table('gaji')
                ->where('gaji.id', $id)
                ->first();

        $bulan = $this->nama_bulan($gaji->bulan) .' '. $gaji->tahun;
        $potongan = DB::connection('gaji')->table('potongan_gaji')
                ->where('id_gaji', $gaji->id)->where('jenis_potongan', 1)
                ->get();
        $potongan_internal = DB::connection('gaji')->table('potongan_gaji')
                ->where('id_gaji', $gaji->id)->where('jenis_potongan', 2)
                ->get();

        // dd($potongan_internal);

        $templateProcessor = new TemplateProcessor('template/slip_gaji.docx');
        $templateProcessor->setValue('bulan', $bulan);
        $templateProcessor->setValue('nama', $gaji->nama);
        $templateProcessor->setValue('nip', $gaji->nip);

        $templateProcessor->setValue('pokok', number_format($gaji->pokok));
        $templateProcessor->setValue('istri', number_format($gaji->istri));
        $templateProcessor->setValue('anak', number_format($gaji->anak));
        $templateProcessor->setValue('umum', number_format($gaji->umum));
        $templateProcessor->setValue('struktural', number_format($gaji->struktural));
        $templateProcessor->setValue('fungsional', number_format($gaji->fungsional));
        $templateProcessor->setValue('beras', number_format($gaji->beras));
        $templateProcessor->setValue('pembulat', number_format($gaji->pembulat));
        $jml_gaji = $gaji->pokok + $gaji->istri + $gaji->anak + $gaji->umum + $gaji->struktural + $gaji->fungsional + $gaji->beras + $gaji->pembulat;

        $templateProcessor->setValue('jumlah_gaji', number_format($jml_gaji));

        $templateProcessor->cloneRow('potongan', count($potongan));
        $jml_potongan = 0;
        for ($i=0; $i < count($potongan); $i++) {
            $templateProcessor->setValue('potongan#'.($i+1), $potongan[$i]->nama);
            $templateProcessor->setValue('nominal_potongan#'.($i+1), number_format($potongan[$i]->jumlah));
            $jml_potongan = $jml_potongan + $potongan[$i]->jumlah;
        }
        $templateProcessor->setValue('jumlah_potongan', number_format($jml_potongan));

        $templateProcessor->cloneRow('potongan_internal', count($potongan_internal));
        $jml_potongan_internal = 0;
        for ($i=0; $i < count($potongan_internal); $i++) {
            $templateProcessor->setValue('potongan_internal#'.($i+1), $potongan_internal[$i]->nama);
            $templateProcessor->setValue('nominal_potongan_internal#'.($i+1), number_format($potongan_internal[$i]->jumlah));
            $jml_potongan_internal = $jml_potongan_internal + $potongan_internal[$i]->jumlah;
        }
        $templateProcessor->setValue('jumlah_potongan_internal', number_format($jml_potongan_internal));

        $templateProcessor->setValue('sp2d', number_format($jml_gaji - $jml_potongan));
        $templateProcessor->setValue('jumlah_netto', number_format($jml_gaji - $jml_potongan - $jml_potongan_internal));

        $filename = 'slip_gaji_'.$gaji->bulan.'_'. $gaji->tahun."_".$gaji->nama;
        // $templateProcessor->saveAs($filename . '.docx');
        // return response()->download($filename . '.docx')->deleteFileAfterSend(true);

        $wordfile = storage_path()."/slip/slip_gaji_".$gaji->nip.".docx";
        $templateProcessor->saveAs($wordfile);
        $tmpFile = storage_path()."/slip/".$filename.".pdf";
        $rendererName = 'DomPDF';
        $domPdfPath = base_path( 'vendor/dompdf');
        Settings::setPdfRenderer($rendererName, $domPdfPath);
        $phpWord = IOFactory::load($wordfile);
        $phpWord->save($tmpFile,'PDF');
        $headers = array(
            'Content-Type: application/pdf',
        );
        unlink($wordfile);
        return response()->download($tmpFile, $filename.'.pdf', $headers)->deleteFileAfterSend(true);
    }

    public function cetaktukin($id)
    {
        $tukin = DB::connection('gaji')->table('tukin')
                ->where('tukin.id', $id)
                ->first();

        $bulan = $this->nama_bulan($tukin->bulan) .' '. $tukin->tahun;
        $potongan = DB::connection('gaji')->table('potongan_tukin')
                ->where('id_tukin', $tukin->id)
                ->get();

        $templateProcessor = new TemplateProcessor('template/slip_tukin.docx');
        $templateProcessor->setValue('bulan', $bulan);
        $templateProcessor->setValue('nama', $tukin->nama);
        $templateProcessor->setValue('nip', $tukin->nip);

        $templateProcessor->setValue('tunjangan', number_format($tukin->tunjangan));
        $templateProcessor->setValue('potongan_tukin', number_format($tukin->potongan));
        $templateProcessor->setValue('jumlah_tukin', number_format($tukin->netto));

        $templateProcessor->cloneRow('potongan', count($potongan));
        $jml_potongan = 0;
        for ($i=0; $i < count($potongan); $i++) {
            $templateProcessor->setValue('potongan#'.$i+1, $potongan[$i]->nama);
            $templateProcessor->setValue('nominal_potongan#'.$i+1, number_format($potongan[$i]->jumlah));
            $jml_potongan = $jml_potongan + $potongan[$i]->jumlah;
        }
        $templateProcessor->setValue('jumlah_potongan', number_format($jml_potongan));

        $jumlah_bersih = $tukin->netto - $jml_potongan;
        $templateProcessor->setValue('jumlah_bersih', number_format($jumlah_bersih));

        $filename = 'slip_tukin_'.$tukin->bulan.'_'.$tukin->tahun."_".$tukin->nama;
        // $templateProcessor->saveAs($filename . '.docx');
        // return response()->download($filename . '.docx')->deleteFileAfterSend(true);

        $wordfile = storage_path()."/slip/slip_tukin_".$tukin->nip.".docx";
        $templateProcessor->saveAs($wordfile);
        $tmpFile = storage_path()."/slip/".$filename.".pdf";
        $rendererName = 'DomPDF';
        $domPdfPath = base_path( 'vendor/dompdf');
        Settings::setPdfRenderer($rendererName, $domPdfPath);
        $phpWord = IOFactory::load($wordfile);
        $phpWord->save($tmpFile,'PDF');
        $headers = array(
            'Content-Type: application/pdf',
        );
        unlink($wordfile);
        return response()->download($tmpFile, $filename.'.pdf', $headers)->deleteFileAfterSend(true);
    }

    public function cetakum($id)
    {
        // $username = Auth::user()->username;
        $makan = DB::connection('gaji')->table('uang_makan')
                ->where('id', $id)
                ->first();

        $bulan = $this->nama_bulan($makan->bulan) .' '. $makan->tahun;

        $templateProcessor = new TemplateProcessor('template/slip_makan.docx');
        $templateProcessor->setValue('bulan', $bulan);
        $templateProcessor->setValue('nama', $makan->nama);
        $templateProcessor->setValue('nip', $makan->nip);

        $templateProcessor->setValue('hari', number_format($makan->jml_hari));
        $templateProcessor->setValue('tarif', number_format($makan->tarif));
        $templateProcessor->setValue('pph', number_format($makan->pph));
        $templateProcessor->setValue('kotor', number_format($makan->kotor));
        $templateProcessor->setValue('potongan', number_format($makan->potongan));
        $templateProcessor->setValue('jumlah', number_format($makan->jumlah));

        $filename = 'Slip_uang_makan_'.$makan->nama;
        $templateProcessor->saveAs($filename . '.docx');
        return response()->download($filename . '.docx')->deleteFileAfterSend(true);
    }
}
