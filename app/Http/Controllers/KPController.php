<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class KPController extends Controller
{
    public function index(){
        $step =1;
        $periode = $this->tentukanPeriode();
        $tahunSekarang = date('Y');
        return view('kp.index',([
            'step'=>$step,
            'periode'=>$periode,
            'tahun'=>$tahunSekarang]));
    }
    
    public function tentukanPeriode()
    {
        $today = Carbon::now();
        $month = $today->month;
        $day = $today->day;
    
        if (($month == 12 && $day >= 15) || ($month == 1 && $day <= 15)) {
            return 'FEBRUARI';
        } elseif ($month == 2 && $day >= 1 && $day <= 28) {
            return 'APRIL';
        } elseif ($month == 4 && $day >= 1 && $day <= 30) {
            return 'JUNI';
        } elseif ($month == 6 && $day >= 1 && $day <= 30) {
            return 'AGUSTUS';
        } elseif ($month == 8 && $day >= 1 && $day <= 31) {
            return 'OKTOBER';
        } elseif ($month == 10 && $day >= 1 && $day <= 31) {
            return 'DESEMBER';
        } else {
            return 'PERIODE_TIDAK_DIKETAHUI';
	   // return 'JUNI';
        }
    }
    
    public function cariPegawai(Request $request)
    {
        $nip = $request->input('nip');
        // $pegawai = Pegawai::where('nip', $nip)->first();
        $pegawai = DB::table('pegawai')->where('nip', $nip)->first();

        if ($pegawai) {
            $pegawai_usul = DB::table('usulankp')->where('nip', $nip)
                            ->where('periode',session('usulkp.periode'))->first();
            if($pegawai_usul){
                    return response()->json([
                    'success' => false,
                    'message' => 'Pegawai dengan NIP tersebut sudah diusulkan pada periode '.session('usulkp.periode')
                ]);
            }else
            {
                    return response()->json([
                    'success' => true,
                    'data' => [
                        'nip' => $pegawai->nip,
                        'nama' => $pegawai->nama_lengkap,
                        'tempat_lahir' => $pegawai->tempat_lahir,
                        'tanggal_lahir' => $pegawai->tanggal_lahir,
                        'jabatan' => $pegawai->jabatan,
                        'golongan' => $pegawai->golongan,
                        'satuan_kerja' => $pegawai->satker,
                        'gelar_belakang' => $pegawai->gelar_belakang,
                        'gelar_depan' => $pegawai->gelar_depan,
                        'id_satker' => $pegawai->id_satker
                    ]
                ]);
            }
            
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Pegawai dengan NIP tersebut tidak ditemukan.'
            ]);
        }
    }

    public function postStep1(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'periode' => 'required|in:FEBRUARI,APRIL,JUNI,AGUSTUS,OKTOBER,DESEMBER',
            'tahun' => 'required|numeric',
            'jenisKP' => 'required',
            'kelompokJabatan' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Silakan periksa kembali isian Anda.');
        }else{

            Session::put('usulkp.periode', $request->periode);
            Session::put('usulkp.tahun', $request->tahun);
            Session::put('usulkp.jenisKP', $request->jenisKP);
            Session::put('usulkp.kelompokJabatan', $request->kelompokJabatan);

            return redirect()->route('usulkp.step2');
        }
    }

    public function step2()
    {
        // if (empty($request->periode) || empty($request->tahun) || empty($request->jenisKP) || empty($request->kelompokJabatan)) {
        //         return redirect()->back()->with('error', 'Semua field harus diisi');
        //     }

            if (Session::get('usulkp.periode') === null || Session::get('usulkp.periode') === '') {
            // Session kosong atau null
            return back()->with('error', 'Usulkan secara bertahap');
        }

        return view('kp.step2',['step' => 2]);
    }

    public function postStep2(Request $request)
    {

        

            Session::put('usulkp.nip', $request->result_nip);
            Session::put('usulkp.nama', $request->result_nama);
            Session::put('usulkp.jabatan', $request->result_jabatan);
            Session::put('usulkp.satker', $request->result_satuan_kerja);
            Session::put('usulkp.gol_lama', $request->result_golongan);
            Session::put('usulkp.id_satker', $request->result_id_satker);

            return redirect()->route('usulkp.step3');
    }

    public function step3()
    {
        if (Session::get('usulkp.nip') === null || Session::get('usulkp.nip') === '') {
            // Session kosong atau null
            return redirect()->route('kp.index')->with('error', 'Usulkan secara bertahap');
        }

        

        try{
            
            // cari data usulan 
            // $data_usul = DB::table('usulankp')->where('nip',)
            $token = env('SIKEP_API_TOKEN');

            // ambil dokumen pdf pangkat dari SIKEP
            $pangkat = Http::withToken($token)->get('https://sikep.mahkamahagung.go.id/api-pro/v1/pangkat/' . session('usulkp.nip'));
            $response = $pangkat->json();
            $items = $response['data']['items'][0] ?? [];
            $file_pangkat = $items['file_doc_pangkat'];

            // ambil dokumen CPNS
            $result = $this->getCpnsSk();
            $cpns = $result['cpnsItem'];
            $jabatan_terakhir = $result['items'];
            // dd($jabatan_terakhir);

                
            return view('kp.step3',([
                'step' => 3,
                'file_pangkat' =>$file_pangkat,
                'file_cpns' =>$cpns['file_sk'],
                'file_sk_jabatan'=>$jabatan_terakhir['file_sk'],
                'file_spp_jabatan'=>$jabatan_terakhir['file_spp'],
                ])); 
        }
        catch (\Exception $e){
            return back()->withInput()
                ->with('error', 'Gagal mengambil data SIKEP: ' . $e->getMessage());

        }

    }

    public function postStep3(Request $request)
    {

        
        try {
            
           
	    
	    // Simpan file-file PDF
            $filePaths = [];
            foreach ($request->allFiles() as $key => $file) {
                if ($file) {
                    $path = $file->store('usulan_kp', 'public');
                    $filePaths[$key] = $path;
                }
            }
            // dd($filePaths);
            
            // Simpan data usulan ke database
            $usulan = DB::table('usulankp')->insert([
                'periode' => session('usulkp.periode'),
                'tahun' => session('usulkp.tahun'),
                'nip' => session('usulkp.nip'),
                'nama' => session('usulkp.nama'),
                'jabatan' => session('usulkp.jabatan'),
                'golongan_lama' => session('usulkp.gol_lama'),
                'id_satker' => session('usulkp.id_satker'),
                'satker' => session('usulkp.satker'),
                'kategori_jabatan' => session('usulkp.kelompokJabatan'),
                'jenis_kp' => session('usulkp.jenisKP'),
                'file_skp1' => $filePaths['fileSKPTahun1'] ?? null,
                'file_skp2' => $filePaths['fileSKPTahun2'] ?? null,
                // 'file_kp_terakhir' => $filePaths['fileKPTerakhir'] ?? null,
                'file_kp_terakhir' => $request->fileKPTerakhir ?? null,
                // 'file_cpns' => $filePaths['fileCPNS'] ?? null,
                'file_cpns' => $request->fileCPNS ?? null,
                'file_ijazah' => $filePaths['fileIjazah'] ?? null,
                'file_transkrip' => $filePaths['fileTranskrip'] ?? null,
                'file_jabatan_terakhir' => $request->fileJabatan ?? null,
                // 'file_jabatan_terakhir' => $filePaths['fileJabatan'] ?? null,
                // 'file_spp' => $filePaths['fileSPP'] ?? null,
                'file_spp' => $request->fileSPP ?? null,
                'file_stlud' => $filePaths['fileSTLUD'] ?? null,
                'file_ijin_belajar' => $filePaths['fileIjinBelajar'] ?? null,
                'file_uraian_tugas' => $filePaths['fileUraianTugas'] ?? null,
                'file_pak' => $filePaths['filePAK'] ?? null,
                'file_akreditasi' => $filePaths['fileAkreditasi'] ?? null,
                'file_forlap_dikti' => $filePaths['fileForlapDikti'] ?? null,
                'created_at' => now(),
               
            ]);
            
            // kirim notif ke wa admin
            $this->kirimwa(session('usulkp.nama'));
            
            Session::forget('usulkp');
            return redirect()->route('kp.index')
                ->with('success', 'Usulan berhasil dikirim!');
                
        } catch (\Exception $e) {
            Session::forget('usulkp');
            return redirect()->route('kp.index')
                ->with('error', 'Gagal mengirim usulan: ' . $e->getMessage());
        }

        // return redirect()->route('usulkp.step4');
    }

    public function list_tahun() {
        $tahunSekarang = date('Y');
        $tahun = [];

        for ($i = 0; $i <= 5; $i++) {
            $tahun[] = $tahunSekarang - $i;
        }

        return $tahun;
    }

    public function jenis_kp($id) {
        if ($id==1){
            $jenis_kp='REGULER';
        }elseif ($id==2){
            $jenis_kp='STRUKTURAL';
        }elseif ($id==3){
            $jenis_kp='PENYESUAIAN IJAZAH';
        }elseif ($id==4){
            $jenis_kp='JABATAN FUNGSIONAL';
        }
        return $jenis_kp;
    }

    public function inbox(Request $request){
        $periode=$request->filter_periode;
        $tahun=$request->filter_tahun;
        $kategori_jabatan=$request->filter_kategori_jabatan;

        if(!$periode)
        {
            $periode = $this->tentukanPeriode();
            $tahun = date('Y');
            $kategori_jabatan='0';
        }
        $list_periode = [
            'SEMUA'=>'SEMUA',
            'FEBRUARI'=>'FEBRUARI',
            'APRIL'=>'APRIL',
            'JUNI'=>'JUNI',
            'AGUSTUS'=>'AGUSTUS',
            'OKTOBER'=>'OKTOBER',
            'DESEMBER'=>'DESEMBER',
            'PERIODE_TIDAK_DIKETAHUI'=>'PERIODE_TIDAK_DIKETAHUI',];

        
        $list_kategori = [
            0=>'SEMUA',
            1=>'HAKIM',
            2=>'KEPANITERAAN',
            3=>'KESEKRETARIATAN',
        ];

        $list_tahun = $this->list_tahun();

        $query=DB::table('usulankp');

        if ($periode<>'SEMUA'){
           $query->where('periode',$periode);
        }

        if ($kategori_jabatan<>0){
            $query->where('kategori_jabatan',$kategori_jabatan);
         }

         $satker_sikep = DB::table('satkers')->where('id', Auth::user()->satker_id)->first();

        if ($satker_sikep && $satker_sikep->id_satker_sikep != '520') {
            $query->where('id_satker', $satker_sikep->id_satker_sikep);
        }
        //  dd($satker_sikep->id_satker_sikep);

         $data=$query->where('tahun',$tahun)->get();

        return view('kp.inbox',([
            'data'=>$data,
            'list_periode'=>$list_periode,
            'periode'=>$periode,
            'list_kategori'=>$list_kategori,
            'list_tahun'=>$list_tahun,
            'tahun'=>$tahun,
            'kategori_jabatan'=>$kategori_jabatan,
        ]));
        
    }

public function tampilkanPdfDariUrl(Request $request)
{
    $url = $request->query('url');

    if (!$url) {
        abort(400, 'URL PDF tidak ditemukan');
    }

    $token = env('SIKEP_API_TOKEN');
    $response = Http::withToken($token)->get($url);

    if ($response->ok()) {
        return response($response->body(), 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'inline; filename="preview.pdf"');
    }

    abort(404, 'Gagal mengambil PDF');
}

public function getCpnsSk()
{

    // 1. Ambil data dari API
    $token = env('SIKEP_API_TOKEN');
    $response = Http::withToken($token)->get('https://sikep.mahkamahagung.go.id/api-pro/v1/jabatan/'.session('usulkp.nip'));

    //  Decode JSON response
    $data = $response->json();
    
//  dd($data);
    //Cari item dengan status CPNS
    $cpnsItem = collect($data['data']['items'])
        ->firstWhere('status', 'CPNS');
    
    // ambil item pertama
    $items = collect($data['data']['items'])->first();

    return [
        'cpnsItem' => $cpnsItem,
        'items' => $items
    ];
     
}

public function edit($id)
{
    $data = DB::table('usulankp')
        ->where('id',$id)
        ->first();

        return response()->json([
            // 'nama' => $data->gelar_depan . ' ' . $data->nama_lengkap . ' ' . $data->gelar_belakang,
            'nip' =>$data->nip,
            'nama' => $data->nama,
            'jabatan' => $data->jabatan,
            'golongan' => $data->golongan_lama,
            'satker' => $data->satker,
            'jenis_kp' => $data->jenis_kp,
            'kategori_jabatan' => $data->kategori_jabatan,
            'file_skp2' => $data->file_skp2,
            'file_skp1' => $data->file_skp1,
            'file_kp_terakhir' => $data->file_kp_terakhir,
            'file_jabatan_terakhir' => $data->file_jabatan_terakhir,
            'file_spp' => $data->file_spp,
            'file_cpns' => $data->file_cpns,
            'file_pak' => $data->file_pak,
            'file_akreditasi' => $data->file_akreditasi,
            'file_forlap_dikti' => $data->file_forlap_dikti,
            'file_ijazah' => $data->file_ijazah,
            'file_transkrip' => $data->file_transkrip,
            'file_stlud' => $data->file_stlud,
            'file_ijin_belajar' => $data->file_ijin_belajar,
            'file_uraian_tugas' => $data->file_uraian_tugas,
            'file_pak' => $data->file_pak,
            'file_sk_siasn' => $data->file_sk_siasn,
            'file_pertek' => $data->file_pertek,
            'id' => $id
        ]);
}

public function update(request $request, $id){

   // Validasi data
        $validator = Validator::make($request->all(), [
            'jenisKP' => 'required|integer',
            'kelompokJabatan' => 'required|integer',
            'fileSKPTahun1' => 'nullable|file|mimes:pdf|max:2048',
            'fileSKPTahun2' => 'nullable|file|mimes:pdf|max:2048',
            'fileIjazah' => 'nullable|file|mimes:pdf|max:2048',
            'fileTranskrip' => 'nullable|file|mimes:pdf|max:2048',
            'fileSTLUD' => 'nullable|file|mimes:pdf|max:2048',
            'fileUraianTugas' => 'nullable|file|mimes:pdf|max:2048',
            'fileIjinBelajar' => 'nullable|file|mimes:pdf|max:2048',
            'filePAK' => 'nullable|file|mimes:pdf|max:2048',
            'fileAkreditasi' => 'nullable|file|mimes:pdf|max:2048',
            'fileForlapDikti' => 'nullable|file|mimes:pdf|max:2048',
            // Tambahkan validasi untuk file lainnya...
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Cek data usulan
            $usulan = DB::table('usulankp')->where('id', $id)->first();
            
            if (!$usulan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data usulan tidak ditemukan'
                ], 404);
            }

            // Data untuk diupdate
            $updateData = [
                'jenis_kp' => $request->jenisKP,
                'kategori_jabatan' => $request->kelompokJabatan,
                'updated_at' => now(),
            ];

            // Daftar field file yang perlu dihandle
            $fileFields = [
                'fileSKPTahun1' => 'file_skp1',
                'fileSKPTahun2' => 'file_skp2',
                'fileIjazah' => 'file_ijazah',
                'fileTranskrip' => 'file_transkrip',
                'fileSTLUD' => 'file_stlud',
                'fileUraianTugas' => 'file_uraian_tugas',
                'fileIjinBelajar' => 'file_ijin_belajar',
                'filePAK' => 'file_pak',
                'fileAkreditasi' => 'file_akreditasi',
                'fileForlapDikti' => 'file_forlap_dikti',
                
            ];

            foreach ($fileFields as $requestField => $dbField) {
                if ($request->hasFile($requestField)) {
                    // Hapus file lama jika ada
                    if ($usulan->$dbField && Storage::disk('public')->exists($usulan->$dbField)) {
                        Storage::disk('public')->delete($usulan->$dbField);
                    }

                    // Simpan file baru
                    $path = $request->file($requestField)->store('usulan_kp', 'public');
                    $updateData[$dbField] = $path;
                }
                // Jika tidak ada file yang diupload, nilai tidak diubah
            }

            // Update data di database
            DB::table('usulankp')->where('id', $id)->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Data usulan berhasil diperbarui',
                'data' => DB::table('usulankp')->find($id)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
        

}

public function validasi(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
            'statusValidasi' => 'required|integer',
            'filePertek' => 'nullable|file|mimes:pdf|max:2048',
            'fileSK' => 'nullable|file|mimes:pdf|max:2048',
            // Tambahkan validasi untuk file lainnya...
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Cek data usulan
            $usulan = DB::table('usulankp')->where('id', $id)->first();
            
            if (!$usulan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data usulan tidak ditemukan'
                ], 404);
            }

            // Data untuk diupdate
            $updateData = [
                'status_siasn' => $request->statusValidasi,
                'keterangan' => $request->keteranganValidasi,
                'updated_at' => now(),
            ];

            // Daftar field file yang perlu dihandle
            $fileFields = [
                'fileSK' => 'file_sk_siasn',
                'filePertek' => 'file_pertek',
                
            ];

            foreach ($fileFields as $requestField => $dbField) {
                if ($request->hasFile($requestField)) {
                    // Hapus file lama jika ada
                    if ($usulan->$dbField && Storage::disk('public')->exists($usulan->$dbField)) {
                        Storage::disk('public')->delete($usulan->$dbField);
                    }

                    // Simpan file baru
                    $path = $request->file($requestField)->store('usulan_kp', 'public');
                    $updateData[$dbField] = $path;
                }
                // Jika tidak ada file yang diupload, nilai tidak diubah
            }

            // Update data di database
            DB::table('usulankp')->where('id', $id)->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Data usulan berhasil diperbarui',
                'data' => DB::table('usulankp')->find($id)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }

}

public function kirimwa($id)
    {
        // $cuti = cuti::where('nip', $id)->get()->first();
        $pesan = '*KP Notifikasi :* Permohonan Kenaikan Pangkat atas nama  ' . $id . ' mohon agar segera diproses. Terima Kasih';
        //  $pesan="Uji Coba Aja";
        // Ambil semua nomor admin cuti
        $adminCutis = User::where('is_admin_kp', 1)->get();
       
            foreach ($adminCutis as $admin) {
                // Pastikan nomor HP admin valid dan memiliki format 62
                $nomorHP = $admin->telp; // Ganti dengan field yang sesuai di tabel user
                $nomorHP = ltrim($nomorHP, '0'); // Hilangkan leading zero jika ada
                if (substr($nomorHP, 0, 2) !== '62') {
                    $nomorHP = '62' . $nomorHP;
                }
                
                $data = [
                    "message" => $pesan,
                    "jid" => $nomorHP . '@s.whatsapp.net', // Format JID WhatsApp
                    "apikey" => "LRAJCoktkM3t"
                ];
                
                $payload = json_encode($data);
                $ch = curl_init("https://whatsva.com/api/sendMessageText");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $result = curl_exec($ch);
                curl_close($ch);
                
                // Optional: Log hasil pengiriman jika diperlukan
                // Log::info("Notifikasi cuti dikirim ke {$admin->nama}: " . $result);
            }
           
    }

}
