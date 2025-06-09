<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skp;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class SkpController extends Controller
{
    public function index(Request $request)
    {
        $role = Auth::User()->role;
        $username = Auth::User()->username;
        $tahun = $request->input('tahun');
        $periode = $request->input('periode');
        if (!$tahun) {
            $tahun = date('Y');
        }
        if (!$periode) {
            $periode = 'Pilih Periode';
        }
        
        $query = DB::table('skp')
                    ->join('users', 'skp.username', '=', 'users.username')
                    ->join('satkers', 'satkers.id', '=', 'users.satker_id')
                    ->leftJoin('satkers as b', 'b.id', '=', 'users.satker_perbantuan')
                    ->where('skp.tahun', '=', $tahun)
                    ->where('users.deleted', '=', '0')
                    ->where('users.name', '<>', 'Administrator')
                    ->whereNotIn('users.jabatan', ['PPNPN']);
        if ($periode != 'Pilih Periode') {
            $query->where('skp.periode_skp', $periode);
        }
        $query->orderBy('id', 'desc');
        $query->select('users.name', 'users.username', 'satkers.nama_satker', 'skp.*', 'b.nama_satker as bantu');
        if ($role != 1) {
            $query->where('skp.username', '=', $username);
        }
        $skp = $query->get();

        return view('skp.index', ([
            'skp'            => $skp,
            'list_tahun'     => $this->list_tahun(),
            'tahun'          => $tahun,
            'periode_select' => $periode
        ]));
    }

    public function create()
    {
        $role = Auth::User()->role;
        $username = Auth::User()->username;
        if ($role == 1) {
            $user = User::all()->where('deleted', 0)->whereNotIn('jabatan', ['PPNPN'])->sortBy('name');
        } else {
            $user = User::all()->where('deleted', 0)->where('username', $username);
        }

        return view('skp.add', ([
            'user'       => $user,
            'username'   => $username,
            'tahun'      => date('Y'),
            'list_tahun' => $this->list_tahun()
        ]));
    }

    public function list_tahun() {
        $tahunSekarang = date('Y');
        $tahun = [];

        for ($i = 0; $i <= 5; $i++) {
            $tahun[] = $tahunSekarang - $i;
        }

        return $tahun;
    }

    public function store(Request $request)
    {
        $request->validate([
            'predikat_kinerja' => 'required|in:Sangat Baik,Baik,Butuh Perbaikan,Kurang,Sangat Kurang',
            'periode_skp' => 'required|in:Rencana Awal Tahun,Triwulan I,Triwulan II,Triwulan III,Triwulan IV,Tahunan',
            'tahun' => 'required|integer|min:2000|max:' . date('Y'),
            'file' => 'required|file|mimes:pdf|max:2048',
        ]);

        $filePath = $request->file('file')->store('skp_files', 'private');
        Skp::create([
            'username'         => $request->username,
            'predikat_kinerja' => $request->predikat_kinerja,
            'periode_skp'      => $request->periode_skp,
            'tahun'            => $request->tahun,
            'file'             => $filePath,
            'created_by'       => Auth::User()->username, 
        ]);

        return redirect()->route('skp')->with('status', 'Data SKP berhasil disimpan');
    }

    public function edit($id)
    {
        $id = decrypt($id);
        $data = Skp::find($id);
        $role = Auth::User()->role;
        $username = Auth::User()->username;

        if ($role == 1) {
            $user = User::all()->where('deleted', 0)->whereNotIn('jabatan', ['PPNPN'])->sortBy('name');
        } else {
            $user = User::all()->where('deleted', 0)->where('username', $username);
        }

        return view('skp.edit', ([
            'skp'        => $data,
            'list_tahun' => $this->list_tahun(),
            'user'       => $user
        ]));
    }

    public function update(Request $request)
    {
        $request->validate([
            'predikat_kinerja' => 'required|in:Sangat Baik,Baik,Butuh Perbaikan,Kurang,Sangat Kurang',
            'periode_skp' => 'required|in:Rencana Awal Tahun,Triwulan I,Triwulan II,Triwulan III,Triwulan IV,Tahunan',
            'tahun' => 'required|digits:4',
            'file' => 'nullable|mimes:pdf|max:2048', // Maks 2MB
            'file_ttd_kpta' => 'nullable|mimes:pdf|max:2048'
        ]);

        $skp = Skp::findOrFail($request->id);

        // Hapus file lama jika ada file baru
        if ($request->hasFile('file')) {
            if ($skp->file && Storage::disk('private')->exists($skp->file)) {
                Storage::disk('private')->delete($skp->file);
            }
            $skp->file = $request->file('file')->store('skp_files', 'private');
        }

        if ($request->hasFile('file_ttd_kpta')) {
            if ($skp->file_ttd_kpta && Storage::disk('private')->exists($skp->file_ttd_kpta)) {
                Storage::disk('private')->delete($skp->file_ttd_kpta);
            }
            $skp->file_ttd_kpta = $request->file('file_ttd_kpta')->store('skp_files', 'private');
        }

        // Update data lainnya
        $skp->username = $request->username;
        $skp->predikat_kinerja = $request->predikat_kinerja;
        $skp->periode_skp = $request->periode_skp;
        $skp->tahun = $request->tahun;
        $skp->updated_at = date("Y-m-d H:i:s");
        $skp->updated_by = Auth::User()->username;
        $skp->save();

        return redirect()->route('skp')->with('status', 'Data berhasil diperbarui!');
    }


    public function download($id)
    {
        // $skp = Skp::findOrFail($id);
        // $filePath = storage_path('app/private/' . $skp->file);
        // if (!file_exists($filePath)) {
        //     abort(404, 'File tidak ditemukan');
        // }
        // return response()->download($filePath);

        $id = decrypt($id);
        $skp = Skp::findOrFail($id);
        $filePath = storage_path('app/private/' . $skp->file);
        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan');
        }
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.basename($filePath).'"'
        ]);
    }

    public function signed($id)
    {
        $id = decrypt($id);
        $skp = Skp::findOrFail($id);
        $filePath = storage_path('app/private/' . $skp->file_ttd_kpta);
        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan');
        }
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.basename($filePath).'"'
        ]);
    }

    public function hapus_skp(Request $request)
    {
        // $skp = Skp::find($request->id_skp);
        // $skp->delete($skp);
        // return redirect('/kinerja')->with('status', 'Data Berhasil Dihapus..!');

        $skp = Skp::findOrFail($request->id_skp);
        // Hapus file utama jika ada
        if ($skp->file && Storage::disk('private')->exists($skp->file)) {
            Storage::disk('private')->delete($skp->file);
        }
        // Hapus file tanda tangan KPTA jika ada
        if ($skp->file_ttd_kpta && Storage::disk('private')->exists($skp->file_ttd_kpta)) {
            Storage::disk('private')->delete($skp->file_ttd_kpta);
        }
        // Hapus data dari database
        $skp->delete();

        return redirect()->route('skp')->with('status', 'Data dan file berhasil dihapus!');
    }
}
