<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IzbelController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\GelarController;
use App\Http\Controllers\KartuController;
use App\Http\Controllers\AbsenController;
use App\Http\Controllers\DasboardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuratTugasController;
use App\Http\Controllers\ApelController;
use App\Http\Controllers\RapatController;
use App\Http\Controllers\GajiController;
use App\Http\Controllers\IkaController;
use App\Http\Controllers\PckController;
use App\Http\Controllers\MutasiController;
use App\Http\Controllers\SkpController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\DisiplinController;
use App\Http\Controllers\KPController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login.login');
});
Route::get('/login', function () {
    return view('login.login');
})->name('login');


// Route::get('home', function () {
//     return view('layout.home');
// });

// Route::get('/', [LoginController::class, 'index'])->name('login');
// Route::post('proseslogin', [LoginController::class, 'authenticate']);

// Route::group(['middleware' => ['auth:sanctum', 'verified', 'CekAdmin:1']])->group(function () {
// });
// Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1,0,2'])->get('/dashboard', function () {
//     return view('layout.home');
// })->name('dashboard');

Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1,0,2'])->get('/dashboard', [DasboardController::class, 'index'])->name('dashboard');

// Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:0'])->get('/userdashboard', function () {
//     return view('layout.userhome');
// })->name('userdashboard');

Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->get('/user', [UserController::class, 'index']);
Route::middleware(['auth:sanctum', 'verified'])->post('/user', [UserController::class, 'store']);
Route::middleware(['auth:sanctum', 'verified'])->get('/adduser', [UserController::class, 'create']);
Route::middleware(['auth:sanctum', 'verified'])->get('/user/{id}/profile', [UserController::class, 'profile']);
Route::middleware(['auth:sanctum', 'verified'])->get('/user/{id}/profileuser', [UserController::class, 'profileuser']);
Route::middleware(['auth:sanctum', 'verified','CekAdmin:1'])->get('/user/{id}/edit', [UserController::class, 'edit']);
Route::middleware(['auth:sanctum', 'verified'])->get('/user/{id}/enrollface', [UserController::class, 'enroll_face']);
Route::middleware(['auth:sanctum', 'verified','CekAdmin:1'])->get('/user/{id}/edituser', [UserController::class, 'edituser']);
Route::middleware(['auth:sanctum', 'verified','CekAdmin:1'])->post('/user/{id}/update', [UserController::class, 'update']);
Route::middleware(['auth:sanctum', 'verified','CekAdmin:1'])->post('/user/{id}/updateuser', [UserController::class, 'updateuser']);
Route::middleware(['auth:sanctum', 'verified','CekAdmin:1'])->get('/user/{id}/delete', [UserController::class, 'destroy']);

Route::middleware(['auth:sanctum', 'verified'])->get('/izbel', [IzbelController::class, 'index'])->name('izbel');
Route::middleware(['auth:sanctum', 'verified'])->post('/izbel', [IzbelController::class, 'store'])->name('izbel.store');
Route::middleware(['auth:sanctum', 'verified'])->get('/addizbel', [IzbelController::class, 'create'])->name('izbel.add');
Route::middleware(['auth:sanctum', 'verified'])->get('/izbel/{id}/detail', [IzbelController::class, 'cari'])->name('izbel.detail');
Route::middleware(['auth:sanctum', 'verified'])->get('/izbel/{id}/delete', [IzbelController::class, 'destroy']);
Route::middleware(['auth:sanctum', 'verified'])->get('/izbel/{id}/edit', [IzbelController::class, 'edit'])->name('izbel.edit');
Route::middleware(['auth:sanctum', 'verified'])->get('/izbel', [IzbelController::class, 'index'])->name('izbel');
Route::middleware(['auth:sanctum', 'verified'])->post('/izbel/{id}/update', [IzbelController::class, 'update'])->name('izbel.update');

Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->get('/prosesizbel', [IzbelController::class, 'adminindex'])->name('prosesizbel');
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->get('/izbel/{id}/proses', [IzbelController::class, 'proses'])->name('olahizbel');
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->post('/izbel/{id}/saveproses', [IzbelController::class, 'saveproses'])->name('saveproses');
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->get('/izbel/{id}/kunciizbel', [IzbelController::class, 'kunci'])->name('kunciizbel');
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->post('/izbel/{id}/proseskunci', [IzbelController::class, 'proseskunci'])->name('proseskunci');
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->post('/izbel/{id}/cetak', [IzbelController::class, 'cetakizbel'])->name('cetakizbel');
Route::middleware(['auth:sanctum', 'verified'])->get('/izbel/{id}/history', [IzbelController::class, 'history'])->name('historyizbel');
Route::middleware(['auth:sanctum', 'verified'])->get('/izbel/{id}/historyuser', [IzbelController::class, 'historyuser'])->name('historyizbeluser');
Route::middleware(['auth:sanctum', 'verified'])->get('/izbel/{id}/waizbel', [IzbelController::class, 'waizbel'])->name('waizbel');
Route::middleware(['auth:sanctum', 'verified'])->get('/izbel/{id}/kirimwaizbel', [IzbelController::class, 'kirimwa'])->name('kirimwaizbel');
Route::middleware(['auth:sanctum', 'verified'])->get('/izbel/{id}/produk', [IzbelController::class, 'izbelproduk'])->name('izbelproduk');
Route::middleware(['auth:sanctum', 'verified'])->post('/izbel/{id}/produkupdate', [IzbelController::class, 'produkupdate'])->name('produkupdate');
// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
Route::middleware(['auth:sanctum', 'verified'])->get('/addusulctuser', [CutiController::class, 'addusulctuser'])->name('addusulctuser');
Route::middleware(['auth:sanctum', 'verified'])->get('/gantipemohoncuti', [CutiController::class, 'ganti_pemohon_cuti'])->name('gantipemohoncuti');
Route::middleware(['auth:sanctum', 'verified'])->post('/savecutiuser', [CutiController::class, 'savedetailcutiuser'])->name('savecutiuser');

Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->get('/editcuti/{id}', [CutiController::class, 'editcuti'])->name('editcuti');
Route::middleware(['auth:sanctum', 'verified'])->post('/updatecuti', [CutiController::class, 'updatecuti'])->name('updatecuti');

Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->get('/mastercuti', [CutiController::class, 'index'])->name('mastercuti');
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->get('/cuti', [CutiController::class, 'usulcuti'])->name('usulcuti');
Route::middleware(['auth:sanctum', 'verified'])->get('/cutiuser', [CutiController::class, 'usulcutiuser'])->name('usulcutiuser');
// Route::middleware(['auth:sanctum', 'verified'])->get('/cutiuser', [CutiController::class, 'usulcuti'])->name('cutiuser');
Route::middleware(['auth:sanctum', 'verified'])->get('/mastercuti/{id}/delete', [CutiController::class, 'destroy']);
Route::middleware(['auth:sanctum', 'verified'])->get('/mastercuti/{id}/edit', [CutiController::class, 'edit']);
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->post('/mastercuti/{id}/update', [CutiController::class, 'updatemastercuti']);
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->get('/addusulct', [CutiController::class, 'addusulcti'])->name('addusulct');
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->get('/addmastercuti', [CutiController::class, 'addmastercuti'])->name('addmastercuti');
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->post('/savemastercuti', [CutiController::class, 'savemastercuti'])->name('savemastercuti');
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->get('/caripegawai', [CutiController::class, 'caripegawai'])->name('caripegawai');
Route::middleware(['auth:sanctum', 'verified'])->post('/savecuti', [CutiController::class, 'savedetailcuti'])->name('savedetailcuti');
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->get('/cuti/{id}/proses', [CutiController::class, 'prosescuti'])->name('prosescuti');
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->get('/approvalcuti', [CutiController::class, 'approvalcuti'])->name('approvalcuti');
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->get('/approvalcutikepeg/{id}/proses', [CutiController::class, 'approvalcutikepeg'])->name('approvalcutikepeg');
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->post('/approvalcutikepeg/{id}/proses', [CutiController::class, 'saveapprovalcutikepeg'])->name('saveapprovalcutikepeg');
Route::middleware(['auth:sanctum', 'verified'])->get('/approvalcutiatasan', [CutiController::class, 'approvalcutiatasan'])->name('approvalcutiatasan');
Route::middleware(['auth:sanctum', 'verified'])->get('/approvalcutiatasandetail/{id}/proses', [CutiController::class, 'approvalcutiatasandetail'])->name('approvalcutiatasandetail');
Route::middleware(['auth:sanctum', 'verified'])->post('/approvalcutiatasandetail/{id}/proses', [CutiController::class, 'saveapprovalcutiatasan'])->name('saveapprovalcutiatasan');
Route::middleware(['auth:sanctum', 'verified'])->get('/approvalcutippk', [CutiController::class, 'approvalcutippk'])->name('approvalcutippk');
Route::middleware(['auth:sanctum', 'verified'])->get('/approvalcutippkdetail/{id}/proses', [CutiController::class, 'approvalcutippkdetail'])->name('approvalcutippkdetail');
Route::middleware(['auth:sanctum', 'verified'])->post('/approvalcutippkdetail/{id}/proses', [CutiController::class, 'saveapprovalcutippk'])->name('saveapprovalcutippk');
Route::middleware(['auth:sanctum', 'verified'])->get('/saldocuti', [CutiController::class, 'saldocuti'])->name('saldocuti');
//     return view('dashboard');
Route::middleware(['auth:sanctum', 'verified'])->get('/cetakcuti/{id}', [CutiController::class, 'cetakcuti'])->name('cetakcuti');
Route::middleware(['auth:sanctum', 'verified'])->post('/hapus_cuti', [CutiController::class, 'hapus_cuti'])->name('hapus_cuti');
Route::middleware(['auth:sanctum', 'verified'])->get('/gelar', [GelarController::class, 'index'])->name('usulgelar');
Route::middleware(['auth:sanctum', 'verified'])->get('/kartu', [KartuController::class, 'index'])->name('usulkartu');
// })->name('dashboard');

Route::middleware(['auth:sanctum', 'verified', 'CekPPNPN:PPNPN'])->get('/absen', [AbsenController::class, 'index'])->name('absen');
// Route::middleware(['auth:sanctum', 'verified'])->get('/absenku', [AbsenController::class, 'index'])->name('absen');
Route::middleware(['auth:sanctum', 'verified', 'CekPPNPN:PPNPN'])->post('/absen', [AbsenController::class, 'addabsen'])->name('isiabsen');
Route::middleware(['auth:sanctum', 'verified'])->get('/laporanabsen', [AbsenController::class, 'laporan']);
Route::middleware(['auth:sanctum', 'verified'])->post('/carilaporanabsensi', [AbsenController::class, 'cari']);

// route ST
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->get('/surattugas', [SuratTugasController::class, 'index'])->name('surattugas');
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->get('/addst', [SuratTugasController::class, 'create']);
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->post('/savest', [SuratTugasController::class, 'store']);
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->get('/addst/menimbang', [SuratTugasController::class, 'menimbang'])->name('menimbang');
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->get('/addst/maksud', [SuratTugasController::class, 'maksud'])->name('maksud');
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->get('/addst/instansi', [SuratTugasController::class, 'instansi'])->name('instansi');
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->get('/addst/instansi_alamat', [SuratTugasController::class, 'instansi_alamat'])->name('instansi_alamat');
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->get('/addst/nomor_st', [SuratTugasController::class, 'nomor_st'])->name('nomor_st');
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->get('/addst/ajax', [SuratTugasController::class, 'ajax'])->name('st_pegawai.ajax');
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->get('/addst/ajaxppnpn', [SuratTugasController::class, 'ajaxppnpn'])->name('st_ppnpn.ajax');
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->get('/surattugas/pegawai/{id}', [SuratTugasController::class, 'getPegawaiST'])->name('getPegawaiST');
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->post('/surattugas/downloadST', [SuratTugasController::class, 'downloadST'])->name('downloadST');
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->get('/surattugas/{id}/edit', [SuratTugasController::class, 'editST'])->name('editST');
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->post('/surattugas/saveeditst', [SuratTugasController::class, 'saveeditst'])->name('saveeditst');
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->delete('/surattugas/hapusst/{id}', [SuratTugasController::class, 'hapusst'])->name('hapusst');

Route::middleware(['auth:sanctum', 'verified'])->get('/apel', [ApelController::class, 'index'])->name('apel');
Route::middleware(['auth:sanctum', 'verified'])->post('/apel', [ApelController::class, 'store'])->name('isiapel');
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->get('/laporanapel', [ApelController::class, 'laporan']);
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->post('/carilaporanapel', [ApelController::class, 'cari']);

Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->get('/rapat', [RapatController::class, 'index']);
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->get('/addmasterrapat', [RapatController::class, 'create']);
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->post('/saverapat', [RapatController::class, 'store']);
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->get('/pesertarapat/{id}', [RapatController::class, 'showpeserta']);
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->post('/undanganrapat', [RapatController::class, 'undangan']);
Route::middleware(['auth:sanctum', 'verified'])->get('/daftarrapat', [RapatController::class, 'showrapat']);
Route::middleware(['auth:sanctum', 'verified'])->get('/isiabsenrapat/{id_rapat}', [RapatController::class, 'isiabsen']);
Route::middleware(['auth:sanctum', 'verified'])->get('/isinotula/{id_rapat}', [RapatController::class, 'isinotula']);
Route::middleware(['auth:sanctum', 'verified'])->post('/updateabsenrapat', [RapatController::class, 'updateabsen']);
Route::middleware(['auth:sanctum', 'verified'])->post('/savenotula', [RapatController::class, 'savenotula']);
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->get('/rapat/{id_rapat}/delete', [RapatController::class, 'hapus']);
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->get('/rapat/{id_rapat}/edit', [RapatController::class, 'edit']);
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->post('/rapat/edit', [RapatController::class, 'update']);
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->post('/simpanpesertabaru', [RapatController::class, 'tambahpeserta']);
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->post('/hapuspeserta/{user}', [RapatController::class, 'hapuspeserta']);
// Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->get('/addpesertarapat', [RapatController::class, 'showpeserta']);

// ardi
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->get('/hadirrapat/{id}', [RapatController::class, 'daftarhadir']);
Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->get('/cetaknotulensi/{id}', [RapatController::class, 'cetaknotulensi']);
Route::middleware(['auth:sanctum', 'verified'])->get('/upload_persetujuan/{id}', [CutiController::class, 'upload_persetujuan']);
Route::middleware(['auth:sanctum', 'verified'])->post('/upload_persetujuan/{id}', [CutiController::class, 'saveupload_persetujuan']);

Route::middleware(['auth:sanctum', 'verified'])->get('/gaji', [GajiController::class, 'index'])->name('gaji');
Route::middleware(['auth:sanctum', 'verified'])->get('/cetakgaji/{id}', [GajiController::class, 'cetakgaji'])->name('cetakgaji');
Route::middleware(['auth:sanctum', 'verified'])->get('/cetaktukin/{id}', [GajiController::class, 'cetaktukin'])->name('cetaktukin');
Route::middleware(['auth:sanctum', 'verified'])->get('/cetakum/{id}', [GajiController::class, 'cetakum'])->name('cetakum');

Route::middleware(['auth:sanctum', 'verified', 'CekAdmin:1'])->get('/ika', [IkaController::class, 'index'])->name('ika');
Route::middleware(['auth:sanctum', 'verified'])->get('/add_ika', [IkaController::class, 'add'])->name('add_ika');
Route::middleware(['auth:sanctum', 'verified'])->post('/save_ika', [IkaController::class, 'store'])->name('save_ika');
Route::middleware(['auth:sanctum', 'verified'])->get('/cetak_ika/{id}', [IkaController::class, 'cetak'])->name('cetak_ika');

Route::middleware(['auth:sanctum', 'verified'])->get('/kinerja', [PckController::class, 'index'])->name('kinerja');
Route::middleware(['auth:sanctum', 'verified'])->get('/kinerja/add_pck', [PckController::class, 'add'])->name('add_pck');
Route::middleware(['auth:sanctum', 'verified'])->post('/save_pck', [PckController::class, 'store']);
Route::middleware(['auth:sanctum', 'verified'])->get('/kinerja/{id_pck}/edit', [PckController::class, 'edit']);
Route::middleware(['auth:sanctum', 'verified'])->post('/kinerja/update', [PckController::class, 'update']);
Route::middleware(['auth:sanctum', 'verified'])->post('/hapus_pck', [PckController::class, 'hapus_pck'])->name('hapus_pck');
Route::middleware(['auth:sanctum', 'verified'])->get('/kinerja/{username}/wa', [PckController::class, 'kirim_wa']);
Route::middleware(['auth:sanctum', 'verified'])->get('/kinerja/blast_wa', [PckController::class, 'blast_wa']);
Route::middleware(['auth:sanctum', 'verified'])->get('/kinerja/download/{id}', [PckController::class, 'download'])->name('download_pck');

Route::middleware(['auth:sanctum', 'verified'])->get('/mutasi/{jenis}/list', [MutasiController::class, 'index'])->name('mutasi');
Route::middleware(['auth:sanctum', 'verified'])->get('/mutasi/{jenis}/{id}/detail', [MutasiController::class, 'detail_mutasi']);
Route::middleware(['auth:sanctum', 'verified'])->get('/mutasi/{jenis}/{id}/pegawai', [MutasiController::class, 'detail_mutasi_pegawai']);
Route::middleware(['auth:sanctum', 'verified'])->get('/addmutasi/{jenis}', [MutasiController::class, 'addmutasi']);
Route::middleware(['auth:sanctum', 'verified'])->post('/savemutasi', [MutasiController::class, 'save_mutasi']);
Route::middleware(['auth:sanctum', 'verified'])->get('/addmutasidetail/{jenis}/{id}', [MutasiController::class, 'addmutasidetail']);
Route::middleware(['auth:sanctum', 'verified'])->post('/savemutasidetail', [MutasiController::class, 'save_mutasi_detail']);
Route::middleware(['auth:sanctum', 'verified'])->get('/addmutasipegawai/{jenis}/{id}', [MutasiController::class, 'addmutasipegawai']);
Route::middleware(['auth:sanctum', 'verified'])->post('/savemutasipegawai', [MutasiController::class, 'save_detail_pegawai']);
Route::middleware(['auth:sanctum', 'verified'])->get('/mutasi/{jenis}/{id_mutasi}/allpegawai', [MutasiController::class, 'detail_all_pegawai']);
Route::middleware(['auth:sanctum', 'verified'])->get('/mutasi/{jenis}/{id_mutasi}/edit', [MutasiController::class, 'edit_mutasi']);
Route::middleware(['auth:sanctum', 'verified'])->post('/updatemutasi', [MutasiController::class, 'update_mutasi']);
Route::middleware(['auth:sanctum', 'verified'])->post('/mutasi/hapus', [MutasiController::class, 'destroy_mutasi']);
Route::middleware(['auth:sanctum', 'verified'])->post('/mutasi/detail/hapus', [MutasiController::class, 'destroy_mutasi_detail']);
Route::middleware(['auth:sanctum', 'verified'])->get('/mutasi/{jenis}/{id_mutasi}/editpegawai', [MutasiController::class, 'edit_mutasi_pegawai']);
Route::middleware(['auth:sanctum', 'verified'])->post('/updatemutasipegawai', [MutasiController::class, 'update_mutasi_pegawai']);
Route::middleware(['auth:sanctum', 'verified'])->post('/mutasi/pegawai/hapus', [MutasiController::class, 'destroy_mutasi_pegawai']);
Route::middleware(['auth:sanctum', 'verified'])->post('/mutasi/allpegawai/hapus', [MutasiController::class, 'destroy_mutasi_allpegawai']);
Route::middleware(['auth:sanctum', 'verified'])->get('/mutasi/{jenis}/{id_mutasi}/baperjakat/{origin}', [MutasiController::class, 'baperjakat']);
Route::middleware(['auth:sanctum', 'verified'])->post('/savebaperjakat', [MutasiController::class, 'update_baperjakat']);
Route::middleware(['auth:sanctum', 'verified'])->get('/jadwalodoj', [MutasiController::class, 'odoj']);

Route::middleware(['auth:sanctum', 'verified'])->get('/skp', [SkpController::class, 'index'])->name('skp');
Route::middleware(['auth:sanctum', 'verified'])->get('/skpkpa', [SkpController::class, 'index_kpa'])->name('skpkpa');
Route::middleware(['auth:sanctum', 'verified'])->get('/skp/add_skp/{jenis}', [SkpController::class, 'create'])->name('add_skp');
Route::middleware(['auth:sanctum', 'verified'])->post('/save_skp', [SkpController::class, 'store']);
Route::middleware(['auth:sanctum', 'verified'])->get('/skp/{id}/edit', [SkpController::class, 'edit']);
Route::middleware(['auth:sanctum', 'verified'])->post('/update_skp', [SkpController::class, 'update']);
Route::middleware(['auth:sanctum', 'verified'])->get('/skp/download/{id}', [SkpController::class, 'download'])->name('download_skp');
Route::middleware(['auth:sanctum', 'verified'])->get('/skp/signed/{id}', [SkpController::class, 'signed'])->name('download_signed');
Route::middleware(['auth:sanctum', 'verified'])->post('/hapus_skp', [SkpController::class, 'hapus_skp'])->name('hapus_skp');

Route::middleware(['auth:sanctum', 'verified'])->get('/pegawai', [PegawaiController::class, 'index']);
Route::middleware(['auth:sanctum', 'verified'])->get('/pegawai/{nip}/detail', [PegawaiController::class, 'detail'])->name('pegawai.detail');
Route::middleware(['auth:sanctum', 'verified'])->get('/pegawai/{id}/sync_jabatan', [PegawaiController::class, 'syncJabatan'])->name('pegawai.syncjabatan');
Route::middleware(['auth:sanctum', 'verified'])->post('/carinip', [PegawaiController::class, 'cariPegawaiNip'])->name('cari.nip');
Route::middleware(['auth:sanctum', 'verified'])->post('/pegawai/satker', [PegawaiController::class, 'filter_satker']);

Route::middleware(['auth:sanctum', 'verified'])->get('/disiplin', [DisiplinController::class, 'index'])->name('disiplin.index');
Route::middleware(['auth:sanctum', 'verified'])->post('/disiplin/isi-semua', [DisiplinController::class, 'isisemua'])->name('disiplin.isiSemua');
Route::middleware(['auth:sanctum', 'verified'])->get('/disiplin/download-laporan', [DisiplinController::class, 'downloadLaporan'])->name('disiplin.downloadLaporan');
Route::middleware(['auth:sanctum', 'verified'])->put('/disiplin/{id}', [DisiplinController::class, 'update'])->name('disiplin-hakim.update');
Route::middleware(['auth:sanctum', 'verified'])->get('/disiplin/{id}/edit', [DisiplinController::class, 'edit'])->name('disiplin-hakim.edit');
Route::middleware(['auth:sanctum', 'verified'])->get('/disiplin-rekap', [DisiplinController::class, 'rekapitulasi'])->name('disiplin.rekap');
Route::middleware(['auth:sanctum', 'verified'])->post('/disiplin-store', [DisiplinController::class, 'store'])->name('disiplin.store');
Route::middleware(['auth:sanctum', 'verified'])->get('/disiplin/rekap-laporan', [DisiplinController::class, 'downloadRekapLaporan'])->name('disiplin.downloadRekapLaporan');

Route::middleware(['auth:sanctum', 'verified'])->get('/renamefile', [PckController::class, 'rename_file'])->name('rename_file');
Route::middleware(['auth:sanctum', 'verified'])->get('/kinerja/download/{bulan}/{tahun}', [PckController::class, 'downloadZip'])->name('kinerja.download');
Route::middleware(['auth:sanctum', 'verified'])->get('/kinerja/merge/{bulan}/{tahun}', [PckController::class, 'mergePdf'])->name('kinerja.merge');

//controller usulan kp dari sini
Route::middleware(['auth:sanctum', 'verified'])->get('/usulkp', [KPController::class, 'index'])->name('kp.index');

Route::middleware(['auth:sanctum', 'verified'])->post('/usulkp-step1', [KPController::class, 'postStep1'])->name('usulkp.step1.post');
Route::middleware(['auth:sanctum', 'verified'])->get('/usulkp-step2', [KPController::class, 'step2'])->name('usulkp.step2');
Route::middleware(['auth:sanctum', 'verified'])->post('/usulkp-step2', [KPController::class, 'postStep2'])->name('usulkp.step2.post');

Route::middleware(['auth:sanctum', 'verified'])->get('/usulkp-step3', [KPController::class, 'step3'])->name('usulkp.step3');
Route::middleware(['auth:sanctum', 'verified'])->post('/usulkp-step3', [KPController::class, 'postStep3'])->name('usulkp.step3.post');


Route::middleware(['auth:sanctum', 'verified'])->post('/usulkp-submit', [KPController::class, 'submit'])->name('usulkp.submit');
Route::middleware(['auth:sanctum', 'verified'])->post('/usulkp-cariPegawai', [KPController::class, 'cariPegawai'])->name('usulkp.caripegawai');
Route::middleware(['auth:sanctum', 'verified'])->get('/usulkp-inbox', [KPController::class, 'inbox'])->name('usulkp.inbox');
Route::middleware(['auth:sanctum', 'verified'])->get('/preview-pdf-direct', [KPController::class, 'tampilkanPdfDariUrl'])->name('usulkp.pdf');
Route::middleware(['auth:sanctum', 'verified'])->get('/usulkp/{id}/edit', [KPController::class, 'edit'])->name('usulkp.edit');
Route::middleware(['auth:sanctum', 'verified'])->put('/usulkp/{id}', [KPController::class, 'update'])->name('usulkp.update');
Route::middleware(['auth:sanctum', 'verified'])->put('/usulkp-validasi/{id}', [KPController::class, 'validasi'])->name('usulkp.validasi');

//controller kp sampai sini
