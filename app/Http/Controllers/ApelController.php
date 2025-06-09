<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ApelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $absen = Apel::where('user_id', Auth::User()->username)->orderBy('created_at', 'desc')->get();
        $use_ai = env('USE_FACE_AI', '');
        $page = $use_ai=='true' ? 'apel.face_ai_index' : 'apel.index';

        // $page = 'apel.face_ai_index'; // harus pake view ini supaya ada kamera nya
        return view($page, (
            ['Absen' => $absen]
        ));
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
        $user_id = Auth::user()->username;
        $date = date("Y-m-d");
        $time = date("H:i:s");
        $lokasi = $request->lokasinya;

        $cek_double = Apel::where([
            'date' => $date,
            'user_id' => $user_id
        ])->count();
        if ($cek_double >= 3) {
            return redirect()->back()->with('error', 'Presensi sudah ada..!');
        }

        $validator = Validator::make($request->all(), [
            'lokasinya' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Error.. Lokasi anda tidak diaktifkan ..!');
        }

        $use_ai = env('USE_FACE_AI', '');
        $base64 = $request->base64;
        $pesan_error = NULL;
        if ($use_ai == true) {
            $validasi_ai = $this->validasi_foto($user_id, $base64);
            if ($validasi_ai->status != '200') {
                $pesan_error = $this->get_face_recognition_error($validasi_ai->status);
                // return redirect()->back()->with('error', $pesan_error);
            }
        }

        if (date('D') == 'Mon') {
            $type = "1";
        } else {
            $type = "2";
        }

        apel::create([
            'user_id'      => $user_id,
            'date'         => $date,
            'time_in'      => $time,
            'type'         => $type,
            'location'     => $lokasi,
            'foto'         => $base64,
            'face_message' => $pesan_error
        ]);

        if ($pesan_error != NULL) {
            return redirect()->back()->with('error', 'Presensi disimpan dengan error: ' . $pesan_error);
        }
        return redirect()->back()->with('status', 'Wajah Terverifikasi. Presensi telah disimpan..!');
    }

    public function validasi_foto($user_id, $base64)
    {
        $curl = curl_init();
        $data = [
            "user_id"        => $user_id,
            "facegallery_id" => env('GALLERY_ID', ''),
            "image"          => $base64,
            "trx_id"         => "ptabandungtrx1234"
        ];
        $payload = json_encode($data);

	// https://documenter.getpostman.com/view/16178629/UVsEVpHD#intro // dok api
        $ch = curl_init("https://fr.neoapi.id/risetai/face-api/facegallery/verify-face");

        # Setup request to send json via POST.
        $token = 'Accesstoken: ' . env('TOKEN_KEY_FACE', '');
        curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type:application/json',
            $token
        ]);

        # Return response instead of printing.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        # Send request.
        $result = curl_exec($ch);
        curl_close($ch);

        # Return response.
        $return = json_decode($result);
        $response = $return->risetai;
        return $response;
    }

    public function get_face_recognition_error($code) {
        switch ($code) {
            case '411':
                return "Wajah Tidak Sesuai Atau Tidak Terdaftar";
                break;
            case '412':
                return "Wajah Tidak Terdeteksi";
                break;
            case '413':
                return "Foto Wajah Terlalu Kecil";
                break;
            case '415':
                return "User Tidak Terdaftar";
                break;
            case '200':
                return "Wajah Terverifikasi";
                break;
            default:
                return "";
        }
    }

    public function laporan()
    {
        // $absen = Absen::all();
        // dd($izbel);
        $satker = Auth::user()->satker_id;

        // if (auth::user()->role == 1) {
        //     $idsatker = DB::table('satkers')
        //         ->select('*')
        //         ->get();
        // } elseif (auth::user()->role == 0) {
        //     $idsatker = DB::table('satkers')
        //         ->select('*')
        //         ->where('id', auth::user()->satker_id)
        //         ->get();
        // }

        // $absen = DB::table('absensi_apel')
        //     ->leftJoin('users', 'absensi_apel.user_id', '=', 'users.username')
        //     ->select('absensi_apel.date', 'absensi_apel.time_in', 'absensi_apel.type', 'absensi_apel.location', 'users.name', 'users.satker_id')
        //     ->where('satker_id', $satker)
        //     ->where('absensi_apel.created_at', '=', Carbon::today())
        //     ->get();

        $absen = DB::table('absensi_apel')
            ->join('users', 'absensi_apel.user_id', '=', 'users.username')
            ->select('absensi_apel.*', 'users.name', 'users.satker_id')
            ->where('users.satker_id', $satker)
            ->where('absensi_apel.created_at', '=', Carbon::today())
            ->get();


        return view('apel.laporan', (['Absen' => $absen, 'idsatker' => $satker]));
    }

    public function cari(Request $request)
    {
        //

        // $satker = Auth::user()->satker_id;
        // $satker = $request->satker_id;
        // dd($request->satker_id);
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

        // $absen = DB::table('absensi_apel')
        //     ->join('users', 'absensi_apel.user_id', '=', 'users.username')
        //     ->select('absensi_apel.*', 'users.name', 'users.satker_id')
        //     ->where('users.satker_id', '=', Auth::user()->satker_id)
        //     ->where('absensi_apel.date', '=', $request->tanggal)
        //     ->get();

        $absen = DB::table('users')
            ->join('absensi_apel', 'users.username', '=', 'absensi_apel.user_id')
            ->select('users.name', 'users.satker_id', 'absensi_apel.date', 'absensi_apel.time_in', 'absensi_apel.location', 'absensi_apel.foto', 'absensi_apel.face_message')
            ->where('users.satker_id', '=', Auth::user()->satker_id)
            ->where('absensi_apel.date', '=', $request->tanggal)
            ->get();
        // dd($absen);
        return view('apel.laporan', (['Absen' => $absen, 'idsatker' => $idsatker]));
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
