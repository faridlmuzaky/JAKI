<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Pegawai;
use App\Models\Jabatan;
use App\Models\SatkerMa;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use File;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        $satker_id = Auth::User()->satker_ma;
        $role = Auth::User()->role;
        $data = Pegawai::where('id_satker', $satker_id)->where('deleted', 0)->get();
        $satker = SatkerMa::where('id_banding', 520)->where('deleted', 0)->orderBy('nama_satker')->get();

        return view('pegawai.index', ([
            'data'            => $data,
            'satker'          => $satker,
            'role'            => $role,
            'satker_selected' => $satker_id,
        ]));
    }

    public function filter_satker(Request $request)
    {
        $satker_id = $request->satker_id;
        $role = Auth::User()->role;
        $data = Pegawai::where('id_satker', $satker_id)->where('deleted', 0)->get();
        $satker = SatkerMa::where('id_banding', 520)->where('deleted', 0)->get();

        return view('pegawai.index', ([
            'data'            => $data,
            'satker'          => $satker,
            'role'            => $role,
            'satker_selected' => $satker_id,
        ]));

        $absen = DB::table('absens')
            ->join('users', 'absens.user_id', '=', 'users.username')
            ->select('absens.*', 'users.name', 'users.satker_id')
            ->where('users.satker_id', '=', $request->satker_id)
            ->where('absens.date', '=', $request->tanggal)
            ->get();
        return view('absen.laporan', (['Absen' => $absen, 'idsatker' => $idsatker]));
    }

    public function detail($nip)
    {
        Carbon::setLocale('id');
        $pegawai = Pegawai::where('nip', $nip)->first();
        if (!$pegawai) {
            $pegawai = $this->getPegawaiMa($nip);
            if (!$pegawai) {
                abort(404, 'Pegawai tidak ditemukan.');
            }
        }

        // tentukan tombol back muncul atau engga
        $req = request()->headers->get('referer'); // ini url yang request nya
        if (str_contains($req, 'mutasi')) {
            $back = false;
        } else {
            $back = true;
        }

        $pegawai->list_jabatan = Jabatan::where('nip', $pegawai->nip)->orderByDesc('tmt')->get();
        $pegawai->tanggal_lahir = Carbon::parse($pegawai->tanggal_lahir)->translatedFormat('j F Y');
        $pegawai->tmt_pns = Carbon::parse($pegawai->tmt_pns)->translatedFormat('j F Y');
        $pegawai->tanggal_pensiun = Carbon::parse($pegawai->tanggal_pensiun)->translatedFormat('j F Y');
        $pegawai->jabatan = $pegawai->jabatan == 'Panitera Muda' ? $pegawai->unit_kerja : $pegawai->jabatan;

        parse_str(parse_url($pegawai->foto_formal, PHP_URL_QUERY), $params);
        $filename = $params['filename'] ?? null;
        $pegawai->foto = "https://sikep.mahkamahagung.go.id/uploads/foto_formal/" . $filename;

        return view('pegawai.detail', ([
            'pegawai' => $pegawai,
            'back'    => $back,
        ]));
    }

    public function syncJabatan($id)
    {
        set_time_limit(0);
        try {
            $pegawai = Pegawai::find($id);
            $token = env('SIKEP_MA_TOKEN');
            $response = Http::withToken($token)->get('https://sikep.mahkamahagung.go.id/api-pro/v1/jabatan/' . $pegawai->nip);

            if (!$response->successful()) {
                $responseData = $response->json();
                $message = $responseData['message'] ?? 'Terjadi kesalahan';
                return redirect('/pegawai')->with('error', 'Gagal sinkron jabatan ' .$message);
            }

            $responseData = $response->json();
            $items = $responseData['data']['items'] ?? [];

            foreach ($items as $jabatan) {
                $tmt = $this->convertDateToEnglishFormat($jabatan['tmt']);
                $tmt_spmt = $this->convertDateToEnglishFormat($jabatan['tmt_spmt']);
                $tanggal_spmt = $this->convertDateToEnglishFormat($jabatan['tanggal_spmt']);
                $tanggal_pelantikan = $this->convertDateToEnglishFormat($jabatan['tanggal_pelantikan']);
                $tanggal_spp = $this->convertDateToEnglishFormat($jabatan['tanggal_spp']);
                $tanggal_spmj = $this->convertDateToEnglishFormat($jabatan['tanggal_spmj']);

                Jabatan::updateOrCreate(
                    [
                        'nomor_sk' => $jabatan['nomor_sk'] ?? null,
                        'jabatan'  => $jabatan['jabatan'] ?? null
                    ],
                    [
                        'nip' => $pegawai->nip,
                        'tmt' => $tmt ?? null,
                        'status' => $jabatan['status'] ?? null,
                        'unit_kerja' => $jabatan['unit_kerja'] ?? null,
                        'satker' => $jabatan['satker'] ?? null,
                        'tanggal_pelantikan' => $tanggal_pelantikan ?? null,
                        'nomor_spp' => $jabatan['nomor_spp'] ?? null,
                        'tanggal_spp' => $tanggal_spp ?? null,
                        'file_spp' => $jabatan['file_spp'] ?? null,
                        'nomor_spmt' => $jabatan['nomor_spmt'] ?? null,
                        'pejabat_spmt' => $jabatan['pejabat_spmt'] ?? null,
                        'tmt_spmt' => $tmt_spmt ?? null,
                        'tanggal_spmt' => $tanggal_spmt ?? null,
                        'file_spmt' => $jabatan['file_spmt'] ?? null,
                        'nomor_spmj' => $jabatan['nomor_spmj'] ?? null,
                        'pejabat_spmj' => $jabatan['pejabat_spmj'] ?? null,
                        'tanggal_spmj' => $tanggal_spmj ?? null,
                        'file_spmj' => $jabatan['file_spmj'] ?? null,
                        'pejabat_sk' => $jabatan['pejabat_sk'] ?? null,
                        'file_sk' => $jabatan['file_sk'] ?? null,
                    ]
                );
            }

            return redirect('/pegawai')->with('status', 'Berhasil sinkron jabatan');
        } catch (\Exception $e) {
            return redirect('/pegawai')->with('error', 'Gagal sinkron jabatan ' .$e->getMessage());
        }
    }

    public function getPegawaiMa($nip) {
        set_time_limit(0);
        try {
            $token = env('SIKEP_MA_TOKEN');
            $page = 1;
            $perPage = 20;

            $urlProd = "https://sikep.mahkamahagung.go.id/api-pro/v1/pegawai/".$nip;
            $response = Http::withToken($token)->get($urlProd);

            if (!$response->successful()) {
                $responseData = $response->json();
                $message = $responseData['message'] ?? 'Terjadi kesalahan';
                return null; //$message;
            }

            $responseData = $response->json();
            $pegawai = $responseData['data'] ?? [];

            $tanggalLahir = $this->convertDateToEnglishFormat($pegawai['tanggal_lahir']);
            $tmtPns = $this->convertDateToEnglishFormat($pegawai['tmt_pns']);

            $data = Pegawai::updateOrCreate(
                ['nip' => $pegawai['nip']], // unik
                [
                    'username' => $pegawai['username'] ?? null,
                    'nip_lama' => $pegawai['nip_lama'] ?? null,
                    'gelar_depan' => $pegawai['gelar_depan'] ?? null,
                    'gelar_belakang' => $pegawai['gelar_belakang'] ?? null,
                    'nama_lengkap' => $pegawai['nama_lengkap'] ?? null,
                    'jenis_kelamin' => $pegawai['jenis_kelamin'] ?? null,
                    'tempat_lahir' => $pegawai['tempat_lahir'] ?? null,
                    'tanggal_lahir' => $tanggalLahir ?? null,
                    'nik' => $pegawai['nik'] ?? null,
                    'karpeg' => $pegawai['karpeg'] ?? null,
                    'agama' => $pegawai['agama'] ?? null,
                    'nomor_handphone' => $pegawai['nomor_handphone'] ?? null,
                    'email' => $pegawai['email'] ?? null,
                    'email_pribadi' => $pegawai['email_pribadi'] ?? null,
                    'tmt_pns' => $tmtPns ?? null,
                    'tanggal_pensiun' => $pegawai['tanggal_pensiun'] ?? null,
                    'pangkat' => $pegawai['pangkat'] ?? null,
                    'golongan' => $pegawai['golongan'] ?? null,
                    'is_hakim' => $pegawai['is_hakim'] ?? null,
                    'is_struktural' => $pegawai['is_struktural'] ?? null,
                    'kelompok_jabatan' => $pegawai['kelompok_jabatan'] ?? null,
                    'jabatan' => $pegawai['jabatan'] ?? null,
                    'unit_kerja' => $pegawai['unit_kerja'] ?? null,
                    'id_satker' => $pegawai['id_satker'] ?? null,
                    'satker' => $pegawai['satker'] ?? null,
                    'kode_satker' => $pegawai['kode_satker'] ?? null,
                    'kelas_pengadilan' => $pegawai['kelas_pengadilan'] ?? null,
                    'lingkungan_peradilan' => $pegawai['lingkungan_peradilan'] ?? null,
                    'alamat_satker' => $pegawai['alamat_satker'] ?? null,
                    'alamat_rumah' => $pegawai['alamat_rumah'] ?? null,
                    'telp_rumah' => $pegawai['telp_rumah'] ?? null,
                    'pendidikan' => $pegawai['pendidikan'] ?? null,
                    'foto_pegawai' => $pegawai['foto_pegawai'] ?? null,
                    'foto_korpri' => $pegawai['foto_korpri'] ?? null,
                    'foto_formal' => $pegawai['foto_formal'] ?? null,
                ]
            );

            $this->syncJabatan($data->id);
            return $data;
        } catch (\Exception $e) {
            return null; //$e->getMessage();
        }
    }

    private function convertDateToEnglishFormat($date)
    {
        if (!$date) {
            return null;
        }
        // Carbon::setLocale('id');
        // Daftar bulan dalam bahasa Indonesia ke bahasa Inggris
        $bulanIndo = [
            'Januari' => 'January',
            'Februari' => 'February',
            'Maret' => 'March',
            'April' => 'April',
            'Mei' => 'May',
            'Juni' => 'June',
            'Juli' => 'July',
            'Agustus' => 'August',
            'September' => 'September',
            'Oktober' => 'October',
            'November' => 'November',
            'Desember' => 'December',
        ];

        // Loop untuk mengganti bulan dalam format tanggal
        foreach ($bulanIndo as $indo => $english) {
            $date = str_replace($indo, $english, $date);
        }

        // Mengonversi tanggal_lahir menjadi "Y-m-d"
        return Carbon::createFromFormat('d F Y', $date)->format('Y-m-d');
    }

    public function cariPegawaiNip(Request $request)
    {
        try {
            $nip = $request->input('nip');

            $pegawai = Pegawai::where('nip', $nip)->first();

            if (!$pegawai) {
                $pegawai = $this->getPegawaiMa($nip);
                if (!$pegawai) {
                    abort(404, 'Pegawai tidak ditemukan.');
                }
            }

            $jabatan = Jabatan::where('nip', $nip)->orderByDesc('tmt')->first();
            $pegawai->tmt_jabatan = null;
            if ($jabatan) {
                $pegawai->tmt_jabatan = $jabatan->tmt;
            }

            // Dapatkan KP dari API MA RI
            $token = env('SIKEP_API_TOKEN');
            $response = Http::withToken($token)->get('https://sikep.mahkamahagung.go.id/api-pro/v1/pangkat/' . $nip);
            $pegawai->tmt_golongan = null;
            if ($response->successful()) {
                $responseData = $response->json();
                $items = $responseData['data']['items'] ?? [];
                foreach ($items as $row) {
                    if ($row['kode_golongan_ruang'] == $pegawai->golongan) {
                        $pegawai->tmt_golongan = $this->convertDateToEnglishFormat($row['tmt_golongan']);
                    }
                }
            }
            // END - Dapatkan KP dari API MA RI

            if ($pegawai) {
                return response()->json([
                    'status' => 'success',
                    'data' => $pegawai,
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Pegawai tidak ditemukan.'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'data' => $e->getMessage(),
            ]);
        }
    }
}
