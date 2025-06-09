<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostSyncController extends Controller
{
    public function fetchAndInsert()
    {
        // Ambil data dari API eksternal
        $response = Http::get('https://api.example.com/posts');

        if ($response->successful()) {
            $posts = $response->json();

            foreach ($posts as $postData) {
                // Simpan ke database jika belum ada
                Post::updateOrCreate(
                    ['title' => $postData['title']], // kondisi unik
                    ['body' => $postData['body']]
                );
            }

            return response()->json(['message' => 'Data berhasil disinkronkan']);
        }

        return response()->json(['message' => 'Gagal mengambil data'], 500);
    }
}

// id
// username
// nip
// nip_lama
// gelar_depan
// gelar_belakang
// nama_lengkap
// usia
// jenis_kelamin
// tempat_lahir
// tanggal_lahir
// nik
// karpeg
// agama
// nomor_handphone
// email
// email_pribadi
// tmt_pns
// tanggal_pensiun
// pangkat
// golongan
// is_hakim
// is_struktural
// kelompok_jabatan
// jabatan
// unit_kerja
// id_satker
// satker
// kode_satker
// kelas_pengadilan
// lingkungan_peradilan
// alamat_satker
// alamat_rumah
// telp_rumah
// pendidikan
// foto_pegawai
// foto_korpri
// foto_formal
