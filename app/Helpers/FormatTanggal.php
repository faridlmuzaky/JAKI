<?php

namespace App\Helpers;

use Carbon\Carbon;

class FormatTanggal
{
    public static function indo($tanggal)
    {
        $bulanIndo = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];

        $tanggalObj = strtotime($tanggal);
        $hari = date("d", $tanggalObj);
        $bulan = $bulanIndo[date("m", $tanggalObj) - 1];
        $tahun = date("Y", $tanggalObj);

        return "$hari $bulan $tahun";
    }

    public static function indo_short($tanggal)
    {
        $bulanIndo = [
            "Jan", "Feb", "Mar", "Apr", "Mei", "Jun",
            "Jul", "Agu", "Sep", "Okt", "Nov", "Des"
        ];

        $tanggalObj = strtotime($tanggal);
        $hari = date("d", $tanggalObj);
        $bulan = $bulanIndo[date("m", $tanggalObj) - 1];
        $tahun = date("Y", $tanggalObj);

        return "$hari $bulan $tahun";
    }

    public static function carbon($tanggal)
    {
        return Carbon::parse($tanggal)->translatedFormat('d F Y');
    }
}
