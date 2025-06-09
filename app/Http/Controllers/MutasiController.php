<?php

namespace App\Http\Controllers;

use App\Models\Mutasi;
use App\Models\MutasiDetail;
use App\Models\MutasiDetailPegawai;
use App\Models\User;
use App\Http\Controllers\CutiController\kirimwa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\TemplateProcessor;
use App\Helpers\FormatTanggal;

class MutasiController extends Controller
{
    public function odoj($jenis = null) {
        $names = [
            "Muhammad Taufiqurrahman", "Rustandi", "Syarif Bastaman", "Widiawaty", "Reza M Sajidin",
            "Putty Wulandari Apriani", "Sri Harjanti", "Inline Karwati", "Luthfi Yuda Pratama", "Ardi Pratama Riyadi",
            "Wulan Yuliani", "Haiva Fadhillah Nur Aziz", "Dede Epul Syaepuloh Rasyid", "Nida Durrotun Nashihah",
            "Alan Mastri Husnun Azim", "Moch Ridwan Habibulloh", "Dian Permata Putri", "Novita Wulan Sari",
            "Nur Hidayah Duha Yanti", "Elvina Arraffi Widyanti", "Kusmara", "Nanang Prasetyo", "Takbiran Syamsina",
            "Eka Chandra", "Sandy Friyadi", "Ariadi Syukur", "Azat Sudrajat", "Abdul Rohman", "Imam Syahronie",
            "Sherly Vebriana"
        ];

        $totalJuz = 30;
        $totalHari = 30;
        $schedule = [];

        for ($hari = 1; $hari <= $totalHari; $hari++) {
            $schedule[$hari] = [];
            foreach ($names as $index => $name) {
                $juzNumber = (($index + $hari - 1) % $totalJuz) + 1;
                $schedule[$hari][] = "$name = JUZ $juzNumber";
            }
        }

        return view('mutasi.juz_schedule', compact('schedule'));
    }

    public function index($jenis = null) {
        $role = Auth::User()->role;
        if ($jenis) {
            $mutasi = DB::select("SELECT * FROM mutasi WHERE deleted=0 AND jenis=?", [$jenis]);
        } else {
            $mutasi = DB::select("SELECT * FROM mutasi WHERE deleted=0");
        }
        foreach ($mutasi as $row) {
            $row->tgl_mulai = FormatTanggal::indo($row->tgl_mulai);
            $row->tgl_akhir = FormatTanggal::indo($row->tgl_akhir);
        }
        return view('mutasi.index', ([
            'mutasi' => $mutasi,
            'jenis'  => $jenis,
        ]));
    }

    public function detail_mutasi($jenis, $id) {
        // data mutasi
        $mutasi = DB::select("SELECT * FROM mutasi WHERE deleted=0 AND jenis=?", [$jenis]);
        $tgl_mulai = $mutasi[0]->tgl_mulai;
        $tgl_akhir = $mutasi[0]->tgl_akhir;
        $periode = "Periode Pengajuan " . FormatTanggal::indo($tgl_mulai) . ' - ' . FormatTanggal::indo($tgl_akhir);
        $aktif = false;
        if (date('Y-m-d') >= $tgl_mulai && date('Y-m-d') <= $tgl_akhir) {
            $aktif = true;
        }

        // data detail mutasi
        $query = "SELECT d.id, m.periode, m.tgl_mulai, m.tgl_akhir, m.doc_pengumuman, d.sk_baperjakat, d.lampiran_sk, s.nama_satker
                  FROM mutasi m JOIN mutasi_detail d ON m.id=d.id_mutasi JOIN satkers s ON d.satker_id=s.id
                  WHERE m.deleted=0 AND d.deleted=0 AND d.id_mutasi=?";

        $role = Auth::User()->role;
        if ($role != 1) {
            $satker_id = Auth::User()->satker_id;
            // and d.satker_id=
            $query .= " AND d.satker_id=" . $satker_id;
        }

        $data = DB::select($query, [$id]);
        foreach ($data as $row) {
            $row->tgl_mulai = FormatTanggal::indo($row->tgl_mulai);
            $row->tgl_akhir = FormatTanggal::indo($row->tgl_akhir);
        }

        return view('mutasi.detail', ([
            'data'      => $data,
            'id_mutasi' => $id,
            'aktif'     => $aktif,
            'periode'   => $periode,
            'jenis'     => $jenis,
        ]));
    }

    public function detail_mutasi_pegawai($jenis, $id) {
        // data mutasi
        $mutasi = DB::select("SELECT * FROM mutasi WHERE deleted=0 AND jenis=?", [$jenis]);
        $tgl_mulai = $mutasi[0]->tgl_mulai;
        $tgl_akhir = $mutasi[0]->tgl_akhir;
        $periode = "Periode Pengajuan " . FormatTanggal::indo($tgl_mulai) . ' - ' . FormatTanggal::indo($tgl_akhir);
        $aktif = false;
        if (date('Y-m-d') >= $tgl_mulai && date('Y-m-d') <= $tgl_akhir) {
            $aktif = true;
        }

        // data detail pegawai
        $detail = MutasiDetail::where('id', $id)->first();
        $query = "SELECT p.*, m.tgl_mulai, m.tgl_akhir FROM mutasi_detail_pegawai p JOIN mutasi_detail d ON d.id=p.id_mutasi_detail
                  JOIN mutasi m ON m.id=d.id_mutasi WHERE p.id_mutasi_detail=? AND p.deleted=0";
        $data = DB::select($query, [$id]);
        foreach ($data as $row) {
            $row->tgl_usulan = FormatTanggal::indo($row->tgl_usulan);
            $row->tmt_jabatan_lama = FormatTanggal::indo($row->tmt_jabatan_lama);
            $row->tmt_golongan = FormatTanggal::indo($row->tmt_golongan);
            $row->tgl_lahir = FormatTanggal::indo_short($row->tgl_lahir);
            $row->tanggal_pensiun = $row->tanggal_pensiun ? FormatTanggal::indo_short($row->tanggal_pensiun) : '';

            if ($row->status_usulan=='baperjakat') {
                $row->status_usulan = 'Telaah Baperjakat';
            } else if ($row->status_usulan=='rejected') {
                $row->status_usulan = 'Tidak Disetujui';
            } else {
                $row->status_usulan = ucwords(strtolower($row->status_usulan));
            }
        }

        return view('mutasi.pegawai', ([
            'data'      => $data,
            'id'        => $id,
            'id_mutasi' => $detail->id_mutasi,
            'aktif'     => $aktif,
            'periode'   => $periode,
            'jenis'     => $jenis,
        ]));
    }

    public function detail_all_pegawai($jenis, $id_mutasi) {
        $query = "SELECT p.* FROM mutasi_detail_pegawai p JOIN mutasi_detail d ON p.id_mutasi_detail=d.id
                  JOIN mutasi m ON d.id_mutasi=m.id WHERE m.id=? AND p.deleted=0";
        $data = DB::select($query, [$id_mutasi]);
        foreach ($data as $row) {
            $row->tgl_usulan = FormatTanggal::indo($row->tgl_usulan);
            $row->tmt_jabatan_lama = FormatTanggal::indo($row->tmt_jabatan_lama);
            $row->tmt_golongan = FormatTanggal::indo($row->tmt_golongan);
        }
        return view('mutasi.allpegawai', ([
            'data'  => $data,
            'jenis' => $jenis,
        ]));
    }

    public function addmutasi($jenis) {
        return view('mutasi.add', ([
            'jenis' => $jenis,
        ]));
    }

    public function addmutasidetail($jenis, $id) {
        $mutasi = Mutasi::where('id', $id)->where('deleted', '0')->first();
        return view('mutasi.adddetail', ([
            'data'  => $mutasi,
            'jenis' => $jenis,
        ]));
    }

    public function addmutasipegawai($jenis, $id) {
        return view('mutasi.addpegawai', ([
            'id_detail' => $id,
            'jenis'     => $jenis,
        ]));
    }

    public function baperjakat($jenis, $id, $origin) {
        $pegawai = MutasiDetailPegawai::where('id', $id)->first();
        return view('mutasi.baperjakat', ([
            'pegawai'   => $pegawai,
            'id_detail' => $pegawai->id_mutasi_detail,
            'jenis'     => $jenis,
            'origin'    => $origin
        ]));
    }

    public function save_mutasi(Request $request) {
        $messages = [
            'required' => ':attribute harus diisi',
            'min' => ':attribute harus diisi minimal :min karakter',
            'max' => ':attribute harus diisi maksimal :max karakter',
        ];
        $request->validate([
            'periode'   => 'Required',
            'jenis'     => 'Required',
            'tgl_mulai' => 'Required',
            'tgl_akhir' => 'Required',
        ], $messages);

        try {
            $nama_file = null;
            if ($request->hasfile('file')) {
                $file = $request->file('file');
                $original_name = str_replace(' ', '_', $file->getClientOriginalName());
                $nama_file = "Mutasi_" . time() . "_" . $original_name;
                $tujuan_upload = 'mutasi';
                $file->move($tujuan_upload, $nama_file);
            }

            $satker_id = Auth::User()->satker_id;
            $username = Auth::User()->username;

            if ($request->hasfile('file')) {
                Mutasi::create([
                    'periode'        => $request->periode,
                    'jenis'          => $request->jenis,
                    'tgl_mulai'      => $request->tgl_mulai,
                    'tgl_akhir'      => $request->tgl_akhir,
                    'doc_pengumuman' => $nama_file,
                    'created_by'     => $username,
                    'created_at'     => date("Y-m-d H:i:s"),
                ]);
            } else {
                Mutasi::create([
                    'periode'        => $request->periode,
                    'jenis'          => $request->jenis,
                    'tgl_mulai'      => $request->tgl_mulai,
                    'tgl_akhir'      => $request->tgl_akhir,
                    'created_by'     => $username,
                    'created_at'     => date("Y-m-d H:i:s"),
                ]);
            }

            return redirect('/mutasi/'.$request->jenis.'/list')->with('status', 'Data Mutasi Berhasil Disimpan.');
        } catch (\Exception $ex) {
            // $ex->getMessage()
            return redirect('/mutasi/'.$request->jenis.'/list')->with('error', 'Gagal menyimpan data mutasi.');
        }
    }

    public function save_mutasi_detail(Request $request) {
        $messages = [
            'required' => ':attribute harus diisi',
        ];
        $request->validate([
            'sk_baperjakat' => 'Required',
            'lampiran_sk'   => 'Required',
        ], $messages);

        try {
            $file_sk = null;
            $file_lampiran = null;
            if ($request->hasfile('sk_baperjakat')) {
                $file = $request->file('sk_baperjakat');
                $original_name = str_replace(' ', '_', $file->getClientOriginalName());
                $file_sk = "sk_" . time() . "_" . $original_name;
                $tujuan_upload = 'mutasi';
                $file->move($tujuan_upload, $file_sk);
            }
            if ($request->hasfile('lampiran_sk')) {
                $file = $request->file('lampiran_sk');
                $original_name = str_replace(' ', '_', $file->getClientOriginalName());
                $file_lampiran = "lampiran_" . time() . "_" . $original_name;
                $tujuan_upload = 'mutasi';
                $file->move($tujuan_upload, $file_lampiran);
            }

            $satker_id = Auth::User()->satker_id;
            $username = Auth::User()->username;

            MutasiDetail::create([
                'id_mutasi'     => $request->id_mutasi,
                'sk_baperjakat' => $file_sk,
                'lampiran_sk'   => $file_lampiran,
                'satker_id'     => $satker_id,
                'created_by'    => $username,
                'created_at'    => date("Y-m-d H:i:s"),
            ]);

            return redirect('/mutasi/'.$request->jenis.'/'.$request->id_mutasi.'/detail')->with('status', 'Data Mutasi Berhasil Disimpan.');
        } catch (\Exception $ex) {
            // $ex->getMessage()
            return redirect('/mutasi/'.$request->jenis.'/'.$request->id_mutasi.'/detail')->with('error', 'Gagal menyimpan data mutasi.');
        }
    }

    public function save_detail_pegawai(Request $request) {
        $messages = [
            'required' => ':attribute harus diisi',
        ];
        $request->validate([
            'id_mutasi_detail'   => 'Required',
            'nip'                => 'Required',
            'nama'               => 'Required',
            'tempat_lahir'       => 'Required',
            'tgl_lahir'          => 'Required',
            'golongan'           => 'Required',
            'tmt_golongan'       => 'Required',
            'jabatan_lama'       => 'Required',
            'tmt_jabatan_lama'   => 'Required',
            'satker_asal'        => 'Required',
            'jabatan_baru'       => 'Required',
            'satker_tujuan'      => 'Required',
        ], $messages);

        try {
            $file_pendukung = null;
            if ($request->hasfile('file')) {
                $file = $request->file('file');
                $original_name = str_replace(' ', '_', $file->getClientOriginalName());
                $file_pendukung = "pendukung_" . time() . "_" . $original_name;
                $tujuan_upload = 'mutasi';
                $file->move($tujuan_upload, $file_pendukung);
            }

            $satker_id = Auth::User()->satker_id;
            $username = Auth::User()->username;

            MutasiDetailPegawai::create([
                'id_mutasi_detail'   => $request->id_mutasi_detail,
                'nip'                => $request->nip,
                'nama'               => $request->nama,
                'tempat_lahir'       => $request->tempat_lahir,
                'tgl_lahir'          => $request->tgl_lahir,
                'golongan'           => $request->golongan,
                'tmt_golongan'       => $request->tmt_golongan,
                'jabatan_lama'       => $request->jabatan_lama,
                'tmt_jabatan_lama'   => $request->tmt_jabatan_lama,
                'satker_asal'        => $request->satker_asal,
                'jabatan_baru'       => $request->jabatan_baru,
                'satker_tujuan'      => $request->satker_tujuan,
                'catatan'            => $request->catatan,
                'file_pendukung'     => $file_pendukung,
                'tanggal_pensiun'    => $request->tanggal_pensiun,
                'tgl_usulan'         => date("Y-m-d"),
                'status_usulan'      => 'diterima',
                'created_by'         => $username,
                'created_at'         => date("Y-m-d H:i:s"),
            ]);

            return redirect('/mutasi/'.$request->jenis.'/'.$request->id_mutasi_detail.'/pegawai')->with('status', 'Data Pegawai Berhasil Disimpan.');
        } catch (\Exception $ex) {
            // $ex->getMessage()
            return redirect('/mutasi/'.$request->jenis.'/'.$request->id_mutasi_detail.'/pegawai')->with('error', 'Gagal menyimpan data.');
        }
    }

    public function edit_mutasi($jenis, $id) {
        $role = Auth::User()->role;
        $mutasi = DB::select("SELECT * FROM mutasi WHERE deleted=0 AND id=?", [$id]);
        return view('mutasi.edit', ([
            'mutasi' => $mutasi[0]
        ]));
    }

    public function edit_mutasi_pegawai($jenis, $id_mutasi) {
        $role = Auth::User()->role;
        $mutasi = DB::select("SELECT * FROM mutasi_detail_pegawai WHERE deleted=0 AND id=?", [$id_mutasi]);
        return view('mutasi.editpegawai', ([
            'data'      => $mutasi[0],
            'id_detail' => $mutasi[0]->id_mutasi_detail,
            'jenis'     => $jenis
        ]));
    }

    public function update_mutasi(Request $request) {
        $messages = [
            'required' => ':attribute harus diisi',
            'min'      => ':attribute harus diisi minimal :min karakter',
            'max'      => ':attribute harus diisi maksimal :max karakter',
        ];
        $request->validate([
            'periode'   => 'Required',
            'tgl_mulai' => 'Required',
            'tgl_akhir' => 'Required',
        ], $messages);

        try {
            $mutasi = Mutasi::findOrFail($request->id);
            $nama_file = null;
            if ($request->hasfile('file')) {
                $file = $request->file('file');
                $original_name = str_replace(' ', '_', $file->getClientOriginalName());
                $nama_file = "Mutasi_" . time() . "_" . $original_name;
                $tujuan_upload = 'mutasi';
                $file->move($tujuan_upload, $nama_file);
                if ($mutasi->doc_pengumuman) {
                    $this->deleteFile($mutasi->doc_pengumuman);
                }
            }

            $satker_id = Auth::User()->satker_id;
            $username = Auth::User()->username;

            if ($request->hasfile('file')) {
                $mutasi->update([
                    'periode'        => $request->periode,
                    'tgl_mulai'      => $request->tgl_mulai,
                    'tgl_akhir'      => $request->tgl_akhir,
                    'doc_pengumuman' => $nama_file,
                    'jenis'          => $request->jenis,
                    'updated_by'     => $username,
                    'updated_at'     => date("Y-m-d H:i:s"),
                ]);
            } else {
                $mutasi->update([
                    'periode'        => $request->periode,
                    'tgl_mulai'      => $request->tgl_mulai,
                    'tgl_akhir'      => $request->tgl_akhir,
                    'jenis'          => $request->jenis,
                    'updated_by'     => $username,
                    'updated_at'     => date("Y-m-d H:i:s"),
                ]);
            }

            return redirect('/mutasi/'.$request->jenis.'/list')->with('status', 'Data Mutasi Berhasil Diperbarui.');
        } catch (\Exception $ex) {
            // $ex->getMessage()
            return redirect('/mutasi/'.$request->jenis.'/list')->with('error', 'Gagal memperbarui data mutasi.');
        }
    }

    public function update_baperjakat(Request $request) {
        try {
            $pegawai = MutasiDetailPegawai::findOrFail($request->id);
            $username = Auth::User()->username;

            $pegawai->update([
                'status_usulan'      => $request->status,
                'catatan_baperjakat' => $request->catatan,
                'syarat_jabatan'     => $request->syarat,
                'updated_by'         => $username,
                'updated_at'         => date("Y-m-d H:i:s"),
            ]);

            return redirect('/mutasi/'.$request->jenis.'/'.$request->id_mutasi_detail.'/'.$request->origin)->with('status', 'Data Baperjakat Berhasil Diperbarui.');
        } catch (\Exception $ex) {
            // $ex->getMessage()
            return redirect('/mutasi/'.$request->jenis.'/'.$request->id_mutasi_detail.'/'.$request->origin)->with('error', 'Gagal memperbarui data baperjakat.');
        }
    }

    public function update_mutasi_pegawai(Request $request) {
        $messages = [
            'required' => ':attribute harus diisi',
        ];
        $request->validate([
            'nip'                => 'Required',
            'nama'               => 'Required',
            'tempat_lahir'       => 'Required',
            'tgl_lahir'          => 'Required',
            'golongan'           => 'Required',
            'tmt_golongan'       => 'Required',
            'jabatan_lama'       => 'Required',
            'tmt_jabatan_lama'   => 'Required',
            'satker_asal'        => 'Required',
            'jabatan_baru'       => 'Required',
            'satker_tujuan'      => 'Required',
        ], $messages);

        $mutasi = MutasiDetailPegawai::findOrFail($request->id);
        try {
            $file_pendukung = null;
            if ($request->hasfile('file')) {
                $file = $request->file('file');
                $original_name = str_replace(' ', '_', $file->getClientOriginalName());
                $file_pendukung = "pendukung_" . time() . "_" . $original_name;
                $tujuan_upload = 'mutasi';
                $file->move($tujuan_upload, $file_pendukung);
                if ($mutasi->file_pendukung) {
                    $this->deleteFile($mutasi->file_pendukung);
                }
            }

            $username = Auth::User()->username;
            if ($request->hasfile('file')) {
                $mutasi->update([
                    'nip'              => $request->nip,
                    'nama'             => $request->nama,
                    'tempat_lahir'     => $request->tempat_lahir,
                    'tgl_lahir'        => $request->tgl_lahir,
                    'golongan'         => $request->golongan,
                    'tmt_golongan'     => $request->tmt_golongan,
                    'jabatan_lama'     => $request->jabatan_lama,
                    'tmt_jabatan_lama' => $request->tmt_jabatan_lama,
                    'satker_asal'      => $request->satker_asal,
                    'jabatan_baru'     => $request->jabatan_baru,
                    'satker_tujuan'    => $request->satker_tujuan,
                    'catatan'          => $request->catatan,
                    'file_pendukung'   => $file_pendukung,
                    'updated_by'       => $username,
                    'updated_at'       => date("Y-m-d H:i:s"),
                ]);
            } else {
                $mutasi->update([
                    'nip'              => $request->nip,
                    'nama'             => $request->nama,
                    'tempat_lahir'     => $request->tempat_lahir,
                    'tgl_lahir'        => $request->tgl_lahir,
                    'golongan'         => $request->golongan,
                    'tmt_golongan'     => $request->tmt_golongan,
                    'jabatan_lama'     => $request->jabatan_lama,
                    'tmt_jabatan_lama' => $request->tmt_jabatan_lama,
                    'satker_asal'      => $request->satker_asal,
                    'jabatan_baru'     => $request->jabatan_baru,
                    'satker_tujuan'    => $request->satker_tujuan,
                    'catatan'          => $request->catatan,
                    'updated_by'       => $username,
                    'updated_at'       => date("Y-m-d H:i:s"),
                ]);

            }

            return redirect('/mutasi/'.$request->jenis.'/'.$request->id_mutasi_detail.'/pegawai')->with('status', 'Data Pegawai Berhasil Diubah.');
        } catch (\Exception $ex) {
            // dd($ex->getMessage());
            return redirect('/mutasi/'.$request->jenis.'/'.$request->id_mutasi_detail.'/pegawai')->with('error', 'Gagal mengubah data.');
        }
    }

    public function destroy_mutasi(Request $request) {
        try {
            $username = Auth::User()->username;
            $mutasi = Mutasi::findOrFail($request->id);
            $mutasi->update([
                'updated_by' => $username,
                'updated_at' => date("Y-m-d H:i:s"),
                'deleted'    => 1
            ]);
            return redirect('/mutasi/'.$request->jenis.'/list')->with('status', 'Data Mutasi Berhasil Dihapus.');
        } catch (\Exception $ex) {
            return redirect('/mutasi/'.$request->jenis.'/list')->with('error', 'Gagal menghapus data mutasi.');
        }
    }

    public function destroy_mutasi_detail(Request $request) {
        try {
            $username = Auth::User()->username;
            $mutasi = MutasiDetail::findOrFail($request->id);
            $mutasi->update([
                'updated_by' => $username,
                'updated_at' => date("Y-m-d H:i:s"),
                'deleted'    => 1
            ]);
            if ($mutasi->sk_baperjakat) {
                $this->deleteFile($mutasi->sk_baperjakat);
            }
            if ($mutasi->lampiran_sk) {
                $this->deleteFile($mutasi->lampiran_sk);
            }

            return redirect('/mutasi/'.$request->jenis.'/'. $mutasi->id_mutasi .'/detail')->with('status', 'Data Detail Mutasi Berhasil Dihapus.');
        } catch (\Exception $ex) {
            return redirect('/mutasi/'.$request->jenis.'/'. $mutasi->id_mutasi .'/detail')->with('error', 'Gagal menghapus data detail mutasi.');
        }
    }

    public function destroy_mutasi_pegawai(Request $request) {
        try {
            $username = Auth::User()->username;
            $mutasi = MutasiDetailPegawai::findOrFail($request->id);
            $mutasi->update([
                'updated_by' => $username,
                'updated_at' => date("Y-m-d H:i:s"),
                'deleted'    => 1
            ]);
            if ($mutasi->file_pendukung) {
                $this->deleteFile($mutasi->file_pendukung);
            }

            return redirect('/mutasi/'.$request->jenis.'/'. $mutasi->id_mutasi_detail .'/pegawai')->with('status', 'Data Mutasi Pegawai Berhasil Dihapus.');
        } catch (\Exception $ex) {
            return redirect('/mutasi/'.$request->jenis.'/'. $mutasi->id_mutasi_detail .'/pegawai')->with('error', 'Gagal menghapus data mutasi pegawai.');
        }
    }

    public function destroy_mutasi_allpegawai(Request $request) {
        try {
            $username = Auth::User()->username;
            $mutasi = MutasiDetailPegawai::findOrFail($request->id);
            $mutasi->update([
                'updated_by' => $username,
                'updated_at' => date("Y-m-d H:i:s"),
                'deleted'    => 1
            ]);
            if ($mutasi->file_pendukung) {
                $this->deleteFile($mutasi->file_pendukung);
            }

            return redirect('/mutasi/'.$request->jenis.'/'. $mutasi->id_mutasi_detail .'/allpegawai')->with('status', 'Data Mutasi Pegawai Berhasil Dihapus.');
        } catch (\Exception $ex) {
            dd($ex->getMessage());
            return redirect('/mutasi/'.$request->jenis.'/'. $mutasi->id_mutasi_detail .'/allpegawai')->with('error', 'Gagal menghapus data mutasi pegawai.');
        }
    }

    public function deleteFile($filename) {
        $filePath = public_path('mutasi/' . $filename);

        if (file_exists($filePath)) {
            unlink($filePath);
            return 'File berhasil dihapus';
        } else {
            return 'File tidak ditemukan';
        }
    }
}
