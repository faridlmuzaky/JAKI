<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Cuti;

class AbsenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //
        $absen = Absen::where('user_id', Auth::User()->username)->orderBy('created_at', 'desc')->get();
        // dd($izbel);
        
        return view('absen.index', ([
            'Absen' => $absen,
        ]));
        // return view('absen.index', (['Absen' => $absen]));
    }

    // menambahkan record absen

    public function addabsen(Request $request)
    {
        $user_id = Auth::user()->username;
        $date = date("Y-m-d");
        $time = date("H:i:s");
        $lokasi = $request->lokasinya;

        // dd($request->all());


        if ($request->submit == "btnIn") {

            $cek_double = Absen::where([
                'date' => $date,
                'user_id' => $user_id
            ])
                ->count();
            if ($cek_double > 0) {
                return redirect()->back()->with('error', 'Presensi masuk sudah ada ..!');
            }

            Absen::create([
                'user_id' => $user_id,
                'date' => $date,
                'time_in' => $time,
                'lok_in' => $lokasi,
            ]);
            return redirect()->back()->with('status', 'Presensi telah disimpan..!');
        } elseif ($request->submit == "btnBreak") {
            $cek_double = Absen::where([
                'date' => $date,
                'user_id' => $user_id
            ])
                ->count();

            if ($cek_double > 0) {
                Absen::where([
                    'date' => $date,
                    'user_id' => $user_id

                ])
                    ->update([
                        'time_break' => $time,
                        'lok_break' => $lokasi
                    ]);
            } else {
                Absen::create([
                    'user_id' => $user_id,
                    'date' => $date,
                    'time_break' => $time,
                    'lok_break' => $lokasi,
                ]);
            }

            return redirect()->back()->with('status', 'Presensi telah disimpan..!');
        } elseif ($request->submit == "btnOut") {
            $cek_double = Absen::where([
                'date' => $date,
                'user_id' => $user_id
            ])
                ->count();

            if ($cek_double > 0) {
                Absen::where([
                    'date' => $date,
                    'user_id' => $user_id

                ])
                    ->update([
                        'time_out' => $time,
                        'lok_out' => $lokasi
                    ]);
            } else {
                Absen::create([
                    'user_id' => $user_id,
                    'date' => $date,
                    'time_out' => $time,
                    'lok_out' => $lokasi,
                ]);
            }

            return redirect()->back()->with('status', 'Presensi telah disimpan..!');
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function laporan()
    {
        // $absen = Absen::all();
        // dd($izbel);
        $satker = Auth::user()->satker_id;

        if (auth::user()->role == 1) {
            $idsatker = DB::table('satkers')
                ->select('*')
                ->get();
        } elseif (auth::user()->role == 0) {
            $idsatker = DB::table('satkers')
                ->select('*')
                ->where('id', auth::user()->satker_id)
                ->get();
        }

        $absen = DB::table('absens')
            ->join('users', 'absens.user_id', '=', 'users.username')
            ->select('absens.*', 'users.name', 'users.satker_id')
            ->where('satker_id', $satker)
            ->where('absens.created_at', '=', Carbon::today())
            ->get();
        return view('absen.laporan', (['Absen' => $absen, 'idsatker' => $idsatker]));
    }

    public function cari(Request $request)
    {
        //

        // $satker = Auth::user()->satker_id;
        // $satker = $request->satker_id;
        //  dd($request->satker_id);
        // dd($request->tanggal);

        if (auth::user()->role == 1) {
            $idsatker = DB::table('satkers')
                ->select('*')
                ->get();
        } elseif (auth::user()->role == 0) {
            $idsatker = DB::table('satkers')
                ->select('*')
                ->where('id', auth::user()->satker_id)
                ->get();
        }

        $absen = DB::table('absens')
            ->join('users', 'absens.user_id', '=', 'users.username')
            ->select('absens.*', 'users.name', 'users.satker_id')
            ->where('users.satker_id', '=', $request->satker_id)
            ->where('absens.date', '=', $request->tanggal)
            ->get();
        // dd($absen);
        return view('absen.laporan', (['Absen' => $absen, 'idsatker' => $idsatker]));
    }
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
