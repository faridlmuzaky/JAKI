<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Pegawai;
use App\Models\Jabatan;
use App\Models\SatkerMa;
use Carbon\Carbon;

class SikepSyncController extends Controller
{
    public function syncPegawaiApi()
    {
        set_time_limit(0);
        try {
            $token = env('SIKEP_API_TOKEN');
            $page = 1;
            $perPage = 20;

            $urlTraining = "https://sikep.mahkamahagung.go.id/api-pro/v1/training/pegawai";
            $urlProd = "https://sikep.mahkamahagung.go.id/api-pro/v1/pegawai";

            do {
                $response = Http::withToken($token)
                    ->get($urlProd, [
                        'page' => $page,
                        'per-page' => $perPage,
                    ]);

                // Cek kalau API kasih error karena rate limit
                if ($response->status() === 429) {
                    sleep(2); // Tunggu 2 detik dulu, lalu coba lagi
                    continue;
                }

                if (!$response->successful()) {
                    $responseData = $response->json();
                    $message = $responseData['message'] ?? 'Terjadi kesalahan';
                    return response()->json(['message' => $message . ' page: '.$page], 500);
                }

                $responseData = $response->json();
                $items = $responseData['data']['items'] ?? [];

                if (empty($items)) {
                    break;
                }

                $items = $responseData['data']['items']; // Ambil array items

                foreach ($items as $pegawai) {
                    $tanggalLahir = $this->convertDateToEnglishFormat($pegawai['tanggal_lahir']);
                    $tmtPns = $this->convertDateToEnglishFormat($pegawai['tmt_pns']);

                    Pegawai::updateOrCreate(
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
                }

                $page++;
                sleep(2); // ⏱️ kasih jeda 2 detik antar request

            }  while (!empty($items));
            // }  while ($page < 4);

            return response()->json(['message' => 'Berhasil']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
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

    public function syncJabatanApi(Request $request)
    {
        $count = 0;
        set_time_limit(0);
        try {
            $pegawai = Pegawai::where('deleted', 0)->get();
            foreach ($pegawai as $index => $row) {
                // if ($index >= 0 && $index < 6) { // && $row->id_satker='520'
                    $token = env('SIKEP_API_TOKEN');
                    $response = Http::withToken($token)->get('https://sikep.mahkamahagung.go.id/api-pro/v1/jabatan/' . $row->nip);

                    if (!$response->successful()) {
                        $responseData = $response->json();
                        $message = $responseData['message'] ?? 'Terjadi kesalahan';
                        return response()->json(['message' => $message . ' index: '.$index], 500);
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
                                'nip' => $row->nip,
                                'nomor_sk' => $jabatan['nomor_sk'] ?? null
                            ],
                            [
                                'jabatan'  => $jabatan['jabatan'] ?? null,
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
                    sleep(2); // kasih jeda 2 detik antar request
                // }

                if ($index % 100 == 0 && $index > 0) {
                    sleep(5); // kasih jeda 10 detik setiap 100 request
                }
                $count = $index;
            }

            return response()->json([
                'message' => "Berhasil sync jabatan : " . $count . " pegawai",
                'data' => $items
            ]);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Error Row ' . $count . ' : ' . $e->getMessage()], 500);
        }
    }

    public function syncSatkerApi()
    {
        set_time_limit(0);
        try {
            $token = env('SIKEP_API_TOKEN');
            $page = 1;
            $perPage = 20;

            $urlProd = "https://sikep.mahkamahagung.go.id/api-pro/v1/satker";

            do {
                $response = Http::withToken($token)
                    ->get($urlProd, [
                        'page' => $page,
                    ]);

                // Cek kalau API kasih error karena rate limit
                if ($response->status() === 429) {
                    sleep(2); // Tunggu 2 detik dulu, lalu coba lagi
                    continue;
                }

                if (!$response->successful()) {
                    $responseData = $response->json();
                    $message = $responseData['message'] ?? 'Terjadi kesalahan';
                    return response()->json(['message' => $message . ' page: '.$page], 500);
                }

                $responseData = $response->json();
                $items = $responseData['data']['items'] ?? [];

                if (empty($items)) {
                    break;
                }

                $items = $responseData['data']['items']; // Ambil array items

                foreach ($items as $satker) {
                    SatkerMa::updateOrCreate(
                        ['id' => $satker['id']], // unik
                        [
                            'kode_satker' => $satker['kode'] ?? null,
                            'nama_satker' => $satker['nama'] ?? null,
                            'level' => $satker['level'] ?? null,
                            'alamat_satker' => $satker['alamat'] ?? null,
                            'no_telp' => $satker['telepon'] ?? null,
                            'email' => $satker['email'] ?? null,
                            'logo' => $satker['logo'] ?? null,
                            'id_banding' => $satker['id_banding'] ?? null,
                            'nama_banding' => $satker['nama_banding'] ?? null,
                            'latitude' => $satker['latitude'] ?? null,
                            'longitude' => $satker['longitude'] ?? null,
                            'website' => $satker['website'] ?? null,
                            'id_lingkungan' => $satker['id_lingkungan'] ?? null,
                            'lingkungan' => $satker['lingkungan'] ?? null,
                            'created_at' => date("Y-m-d H:i:s")
                        ]
                    );
                }

                $page++;
                sleep(2); // ⏱️ kasih jeda 2 detik antar request

            }  while (!empty($items));

            return response()->json(['message' => 'Berhasil Sync Satker']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
