<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;
    protected $table = 'pegawai';
    protected $fillable = [
        'username', 'nip', 'nip_lama', 'gelar_depan', 'gelar_belakang',
        'nama_lengkap', 'usia', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir',
        'nik', 'karpeg', 'agama', 'nomor_handphone', 'email', 'email_pribadi',
        'tmt_pns', 'tanggal_pensiun', 'pangkat', 'golongan', 'is_hakim',
        'is_struktural', 'kelompok_jabatan', 'jabatan', 'unit_kerja',
        'id_satker', 'satker', 'kode_satker', 'kelas_pengadilan',
        'lingkungan_peradilan', 'alamat_satker', 'alamat_rumah', 'telp_rumah',
        'pendidikan', 'foto_pegawai', 'foto_korpri', 'foto_formal'
    ];
}
