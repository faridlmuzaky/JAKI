{{-- @extends('layout.main') --}}
@extends('kp.wizard')
@section('title', 'Input Usul Kenaikan Pangkat')

@section('isiStep')
<style>
.spinner-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
.spinner {
    text-align: center;
}
</style>


<div id="spinner" class="spinner-overlay" style="display: none;">
    <div class="spinner">
        <i class="fas fa-spinner fa-spin fa-3x"></i>
        <p>Memuat data...</p>
    </div>
</div>

{{-- <div class="spinner"><i role="status" class="spinner-border spinner-border-sm"></i>Sedang menyimpan</div> --}}
<!-- Step 1 Content -->
<form method="POST" action="{{ route('usulkp.step2.post') }}" id="myform" class="needs-validation">
    @csrf
    <div class="form-row">
      <div class="form-group col-md-3">
        {{-- <label for="periode">NIP</label>
        <input type="text" class="form-control" id="periode" name="nip"> --}}

        <div class="search-form">
          <input type="search" class="form-control" placeholder="Cari NIP Pegawai" id="nip">
          <button class="btn" type="button" id="btnCariPegawai"><i data-feather="search"></i></button>
        </div>
      </div>
    </div>

     <!-- Hasil Pencarian -->
    <div id="pegawaiResult" style="display: none;">
      <div class="form-row">
        <div class="form-group col-md-4">
                <label>Nama</label>
                <input type="text" class="form-control" id="result_nama" name="result_nama" readonly>
                <input type="hidden" id="result_nip" name="result_nip">
                <input type="hidden" id="result_id_satker" name="result_id_satker">
        </div>
        <div class="form-group col-md-4">
                <label>Tempat Lahir</label>
                <input type="text" class="form-control" id="result_tempat_lahir" name="result_tempat_lahir" readonly>
        </div>
        <div class="form-group col-md-4">
                <label>Tanggal Lahir</label>
                <input type="text" class="form-control" id="result_tanggal_lahir" name="result_tanggal_lahir" readonly>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
            <label>Jabatan</label>
            <input type="text" class="form-control" id="result_jabatan" name="result_jabatan" readonly>
        </div>
        <div class="form-group col-md-2">
            <label>Golongan</label>
            <input type="text" class="form-control" id="result_golongan" name="result_golongan" readonly>
        </div>
        <div class="form-group col-md-4">
            <label>Satuan Kerja</label>
            <input type="text" class="form-control" id="result_satuan_kerja" name="result_satuan_kerja" readonly>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-4">
            <label>Gelar Depan</label>
            <input type="text" class="form-control" id="result_gelar_depan" name="result_gelar_depan" readonly>
        </div>
        <div class="form-group col-md-4">
            <label>Gelar Belakang</label>
            <input type="text" class="form-control" id="result_gelar_belakang" name="result_gelar_belakang" readonly>
        </div>
      </div>
    </div>

    <a href="{{ route('kp.index') }}" class="btn btn-secondary">Kembali</a>
    <button type="submit" class="btn btn-primary" id="btnLanjutkan" disabled>Lanjutkan</button>
  </form>


  <div id="form-wrapper">


  </div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {

  // aktifasi tombol lanjutkan
  

    $('#btnCariPegawai').click(function() {
        let nip = $('#nip').val();
        
        if (nip === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Silakan masukkan NIP pegawai terlebih dahulu'
            });
            return;
        }

        $.ajax({
            url: "{{ route('usulkp.caripegawai') }}",
            type: "POST",
            data: {
                '_token': "{{ csrf_token() }}",
                'nip': nip
            },
            dataType: "json",
            success: function(response) {
              // Kosongkan semua field terlebih dahulu
                $('#result_nama').val('');
                $('#result_tempat_lahir').val('');
                $('#result_tanggal_lahir').val('');
                $('#result_jabatan').val('');
                $('#result_golongan').val('');
                $('#result_satuan_kerja').val('');
                $('#result_gelar_belakang').val('');
                $('#result_gelar_depan').val('');
                $('#result_nip').val('');
                $('#result_id_satker').val('');

                if (response.success) {
                    $('#pegawaiResult').show();
                    $('#result_nama').val(response.data.nama);
                    $('#result_tempat_lahir').val(response.data.tempat_lahir);
                    $('#result_tanggal_lahir').val(response.data.tanggal_lahir);
                    $('#result_jabatan').val(response.data.jabatan);
                    $('#result_golongan').val(response.data.golongan);
                    $('#result_satuan_kerja').val(response.data.satuan_kerja);
                    $('#result_gelar_belakang').val(response.data.gelar_belakang);
                    $('#result_gelar_depan').val(response.data.gelar_depan);
                    $('#result_nip').val(response.data.nip);
                    $('#result_id_satker').val(response.data.id_satker);

                    $('#btnLanjutkan').prop('disabled',false);
                } else {
                    $('#pegawaiResult').hide();
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.message
                    });

                    $('#btnLanjutkan').prop('disabled',true);
                }
            },
            error: function(xhr, status, error) {
              $('#result_nama').val('');
                $('#result_tempat_lahir').val('');
                $('#result_tanggal_lahir').val('');
                $('#result_jabatan').val('');
                $('#result_golongan').val('');
                $('#result_satuan_kerja').val('');
                $('#result_gelar_belakang').val('');
                $('#result_gelar_depan').val('');
                $('#result_id_satker').val('');
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat melakukan pencarian'
                });
                console.error(error);
                $('#btnLanjutkan').prop('disabled',true);
            }
        });
    });


    
        $('.needs-validation').on('submit', function () {
            $('#spinner').show();
        });
    





});


</script>
@endsection