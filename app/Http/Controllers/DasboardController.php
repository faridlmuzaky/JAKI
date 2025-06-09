<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\User;
use App\Models\CutiDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class DasboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $response = Http::get('https://api.myquran.com/v1/sholat/kota/cari/kota bandung');
        // $id = '1219';
        // $tahun = date('Y');
        // $bulan = date('m');
        // $tanggal = date('d');

        // $response = Http::get('https://api.myquran.com/v1/sholat/jadwal/' . $id . '/' . $tahun . '/' . $bulan . '/' . $tanggal);

        // $result = json_decode($response->body(), true);
        // dd($result);
        // echo $result['data']['jadwal']['subuh'];

        $username = Auth::user()->username;
        $cuti = DB::table('master_cutis')
            ->join('master_cutis_detail', 'master_cutis.id', '=', 'master_cutis_detail.master_cutis_id')
            ->join('satkers', 'satkers.id', '=', 'master_cutis.id_satker')
            ->select('master_cutis_detail.*', 'master_cutis.*', 'satkers.nama_satker', 'master_cutis_detail.id as id_detail')
            // ->where('master_cutis.tahun_anggaran', $tahun, 'and')
            ->where('master_cutis.aktif', '1', 'and')
            ->where('master_cutis.nip', $username)
            ->orderBy('master_cutis_detail.tgl_mulai', 'DESC')
            ->get();

        $ctbulan = DB::table('master_cutis')
            ->join('master_cutis_detail', 'master_cutis.id', '=', 'master_cutis_detail.master_cutis_id')
            ->join('satkers', 'satkers.id', '=', 'master_cutis.id_satker')
            ->select('master_cutis_detail.*',  'master_cutis.*', 'satkers.nama_satker', 'master_cutis_detail.id as id_detail')
            // ->where('master_cutis.tahun_anggaran', $tahun, 'and')
            ->where('master_cutis.aktif', '1', 'and')
            ->where('master_cutis.nip', $username)
            ->whereMonth('master_cutis_detail.tgl_mulai', Carbon::today()->month)
            ->get()->count();

        $cttahun = DB::table('master_cutis')
            ->join('master_cutis_detail', 'master_cutis.id', '=', 'master_cutis_detail.master_cutis_id')
            ->join('satkers', 'satkers.id', '=', 'master_cutis.id_satker')
            ->select('master_cutis_detail.*', 'master_cutis.*', 'satkers.nama_satker', 'master_cutis_detail.id as id_detail')
            // ->where('master_cutis.tahun_anggaran', $tahun, 'and')
            ->where('master_cutis.aktif', '1', 'and')
            ->where('master_cutis.nip', $username)
            ->whereYear('master_cutis_detail.tgl_mulai', Carbon::today()->year)
            ->get()->count();

        // dd($cuti);
        return view('layout.home', ([
            'cuti' => $cuti,
            'ctbln' => $ctbulan,
            'ctthn' => $cttahun
        ]));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
