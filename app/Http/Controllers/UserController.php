<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Satker;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Storage;
use File;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Auth::user()->where('deleted', 0)->get();
        return view('user.index', (['data' => $data]));
    }

    public function salin_images_ke_faces() // salin_images_ke_faces
    {
        $data = Auth::user()->where('deleted', 0)
        ->where('satker_id','28')->get();

        try {
            foreach ($data as $row) {
                $from = public_path('images/' . $row->profile_photo_path);
                $to = public_path('faces/' . $row->profile_photo_path);
                File::copy($path, $target);
            }
        } catch (\Exception $ex) {
            dd('error cuk : ' . $ex->getMessage());
        }

        return view('user.test', (['data' => $data]));
    }

    public function kirim_faces_ke_neo_faces_recognition() // kirim_faces_ke_neo_faces_recognition
    {
        $data = Auth::user()->where('deleted', 0)->where('satker_id','28')->where('face_registered', 0)->get();

        try {
            foreach ($data as $row) {
                $path = public_path('faces/' . $row->profile_photo_path);
                $image = base64_encode(file_get_contents($path));
                $response = $this->kirim_foto_api($row->username, $image);

                if ($response->status == '200') {
                    // update face_registered=1
                    $userku = User::find($row->id);
                    $userku->face_registered = 1;
                    $userku->face_message = $response->status_message;
                    $userku->save();
                } else {
                    // update face_message=status_message
                    $userku = User::find($row->id);
                    $userku->face_registered = 0;
                    $userku->face_message = $response->status_message;
                    $userku->save();

                    break;
                }
            }
        } catch (\Exception $ex) {
            dd('error cuk : ' . $ex->getMessage());
        }

        return view('user.test', (['data' => $data]));
    }

    public function kirim_foto_api($user_id, $base64)
    {
        $curl = curl_init();
        $data = [
            "user_id"        => $user_id,
            "user_name"      => $user_id,
            "facegallery_id" => env('GALLERY_ID', ''),
            "image"          => $base64,
            "trx_id"         => "ptabandungtrx1234"
        ];
        $payload = json_encode($data);

        $ch = curl_init("https://fr.neoapi.id/risetai/face-api/facegallery/enroll-face");

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
        //dd($response->status);
        return $response;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $satker = Satker::all();
        return view('user.tambah', (['satker' => $satker]));
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
        $request->validate([
            'name' => 'Required',
            'username' => 'Required|unique:users',
            'telp' => 'Required',
            'jabatan' => 'Required',
            'golongan' => 'Required',
            'password' => 'Required|min:6',
            'password_confirmation' => 'Required_with:password|same:password|min:6',
            'file' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'role' => 'required',
            'satker_id' => 'required',
            // 'file' => 'Required|file|max:2048'
        ]);


        $file = $request->file('file');
        $nama_file = time() . "_" . $file->getClientOriginalName();

        // dd($nama_file);
        // // folder tujuan upload ada di public
        $tujuan_upload = 'images';
        // $file->move($tujuan_upload, $file->getClientOriginalName());
        $file->move($tujuan_upload, $nama_file);
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'jabatan' => $request->jabatan,
            'golongan' => $request->golongan,
            'telp' => $request->telp,
            'password' => bcrypt($request->password),
            'profile_photo_path' => $nama_file,
            'role' => $request->role,
            'satker_id' => $request->satker_id,
            'created_by' => Auth::User()->username
        ]);
        // dd($request->all());
        return redirect('/user')->with('status', 'User has been created..!');
    }
    public function profile($id)
    {
        $user = User::find($id);
        return view('user.profile', ['userku' => $user]);
    }

    public function profileuser($id)
    {
        $user = User::find(decrypt($id));
        // $user=DB::table('users')->where('id',$id)->get();
        // dd($user);
        return view('user.profileuser', ['userku' => $user]);
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
        $user = User::find($id);
        // $satker = Satker::all();
        $satker = Satker::orderBy('nama_satker', 'asc')->get();
        return view('user.edit', ['userku' => $user, 'satker' => $satker]);
    }
    public function edituser($id)
    {
        //
        $user = User::find($id);
        $satker = Satker::all();
        return view('user.edituser', ['userku' => $user, 'satker' => $satker]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_lama_ori(Request $request, $id)
    {
        $request->validate([
            'name'      => 'Required',
            'username'  => 'Required',
            'telp'      => 'Required',
            'jabatan'   => 'Required',
            // 'password'  => 'min:6',
            'password_confirmation' => 'same:password',
            'file'      => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'role'      => 'Required',
            'satker_id' => 'Required'
        ]);

        $userku = User::find($id);
        $acc_cuti = $request->has('acc_cuti') ? 1 : 0;

        $userku->name = $request->name;
        $userku->username = $request->username;
        $userku->telp = $request->telp;
        $userku->jabatan = $request->jabatan;
        $userku->role = $request->role;
        $userku->satker_id = $request->satker_id;
        $userku->acc_cuti = $acc_cuti;

        if ($request->satker_perbantuan) {
            $userku->satker_perbantuan = $request->satker_perbantuan;
        }

        if ($request->password) {
            $userku->password = bcrypt($request->password);
        }

        $userku->updated_by = Auth::User()->username;
        $userku->save();

        if ($request->hasfile('file')) {
            $file = $request->file('file');
            $nama_file = time() . "_" . $file->getClientOriginalName();
            // folder tujuan upload ada di public
            $tujuan_upload = 'images';
            // $file->move($tujuan_upload, $file->getClientOriginalName());
            $file->move($tujuan_upload, $nama_file);
            $userku->profile_photo_path = $nama_file;
            $userku->save();
        }

        return redirect('/user')->with('status', 'User has been updated..!');
    }

    public function update(Request $request, $id){
        $request->validate([
            'name'      => 'Required',
            'username'  => 'Required',
            'telp'      => 'Required',
            'jabatan'   => 'Required',
            // 'password'  => 'min:6',
            'password_confirmation' => 'same:password',
            'file'      => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'role'      => 'Required',
            'satker_id' => 'Required'
        ]);

        $updateData =[
            'name' => $request->name,
            'username' => $request->username,
            'telp' => $request->telp,
            'jabatan' => $request->jabatan,
            'role' => $request->role,
            'satker_id'=>$request->satker_id,
            'password' => bcrypt($request->password),
        ];

         if ($request->hasfile('file')) {
            $file = $request->file('file');
            $nama_file = time() . "_" . $file->getClientOriginalName();
            // folder tujuan upload ada di public
            $tujuan_upload = 'images';
            // $file->move($tujuan_upload, $file->getClientOriginalName());
            $file->move($tujuan_upload, $nama_file);
            $updateData['profile_photo_path'] = $nama_file;
        }
        DB::table('users')->where('id', $id)->update($updateData);
        return redirect('/user')->with('status', 'User has been updated..!');

    }

    public function update_ori(Request $request, $id)
    {
        //
        // dd($request->all());
        $request->validate([
            'name' => 'Required',
            'username' => 'Required',
            'telp' => 'Required',
            'jabatan' => 'Required',
            'password' => 'Required|min:6',
            'password_confirmation' => 'Required_with:password|same:password|min:6',
            'file' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'role' => 'Required',
            'satker_id' => 'Required'
            // 'file' => 'Required|file|max:2048'
        ]);

        $userku = User::find($id);
        $userku->update($request->all());
        $userku->update(['password' => bcrypt($request->password)]);

        if ($request->hasfile('file')) {
            $file = $request->file('file');
            $nama_file = time() . "_" . $file->getClientOriginalName();
            // dd($nama_file);
            // // folder tujuan upload ada di public
            $tujuan_upload = 'images';
            // $file->move($tujuan_upload, $file->getClientOriginalName());
            $file->move($tujuan_upload, $nama_file);
            $userku->profile_photo_path = $nama_file;
            $userku->save();
        }

        return redirect('/user')->with('status', 'User has been updated..!');
    }

    public function updateuser(Request $request, $id)
    {
        //
        // dd($request->all());
        $request->validate([
            'name' => 'Required',
            // 'username' => 'Required',
            'telp' => 'Required',
            'password' => 'Required|min:6',
            'password_confirmation' => 'Required_with:password|same:password|min:6',
            'file' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            // 'role' => 'Required',
            // 'satker_id' => 'Required'
            // 'file' => 'Required|file|max:2048'
        ]);

        $userku = User::find($id);
        $userku->update($request->all());
        $userku->update(['password' => bcrypt($request->password)]);

        if ($request->hasfile('file')) {
            $file = $request->file('file');
            $nama_file = time() . "_" . $file->getClientOriginalName();
            // dd($nama_file);
            // // folder tujuan upload ada di public
            $tujuan_upload = 'images';
            // $file->move($tujuan_upload, $file->getClientOriginalName());
            $file->move($tujuan_upload, $nama_file);
            $userku->profile_photo_path = $nama_file;
            $userku->save();
        }
        // $user = Auth::user()->username;

        return redirect('/user/' . Auth::user()->id . "/profileuser")->with('status', 'Permohonan Cuti Berhasil Disimpan..!');
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
        $user = User::find($id);
	$user->password = '';
        $user->deleted = true;
        $user->deleted_at = date("Y-m-d H:i:s");
        $user->deleted_by = Auth::User()->username;
        $user->save();
        // $user->delete($user);
        return redirect('/user')->with('status', 'User has been deleted..!');
    }
}
