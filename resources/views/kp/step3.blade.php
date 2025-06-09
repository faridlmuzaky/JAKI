{{-- @extends('layout.main') --}}
@extends('kp.wizard')
@section('title', 'Input Usul Kenaikan Pangkat')

@section('isiStep')
<!-- Step 1 Content -->
<style>
    .col-md-5 {
        margin: 1rem; /* Margin default Bootstrap atau margin lain yang Anda inginkan */
    }
.custom-loader {
    position: absolute;
    top: 50%;
    left: 50%;
    display: flex;
    gap: 0.5rem;
    transform: translate(-50%, -50%);
    z-index: 10;
}

.custom-loader span {
    width: 12px;
    height: 12px;
    background: #007bff;
    border-radius: 50%;
    animation: bounce 0.6s infinite alternate;
}

.custom-loader span:nth-child(2) {
    animation-delay: 0.2s;
}

.custom-loader span:nth-child(3) {
    animation-delay: 0.4s;
}

@keyframes bounce {
    from {
        transform: translateY(0);
        opacity: 1;
    }
    to {
        transform: translateY(-15px);
        opacity: 0.6;
    }
}
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

<div id="spinner" class="spinner-overlay">
    <div class="spinner">
        <i class="fas fa-spinner fa-spin fa-3x"></i>
        <p>Memuat data...</p>
    </div>
</div>


<form method="POST" action="{{ route('usulkp.step3.post') }}" id="formUsulan" enctype="multipart/form-data">
    @csrf
    
     <!-- Hasil Pencarian -->
    <div id="pegawaiResult" style="">

        <fieldset class="form-fieldset mb-3">
        <legend>File Sikron dari SIKEP Mahkamah Agung</legend>
            <div class="alert alert-warning" role="alert">
            {{-- <h4 class="alert-heading">Perhatian !</h4> --}}
            <strong>Perhatian!</strong> Pastikan data file ini sudah sesuai, apabila belum sesuai mohon agar melakukan update data pada aplikasi SIKEP
            {{-- <hr>
            <p class="mb-0">Whenever you need to, be sure to use margin utilities to keep things nice and tidy.</p> --}}
          </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="customFile" >SK Pangkat Terakhir</label>
                    <div class="custom-file">
                         {{-- <input type="file" name="fileKPTerakhir" class="custom-file-input" id="fileKPTerakhir" accept=".pdf" accept=".pdf" required> --}}
                        <input type="hidden" name="fileKPTerakhir" id="fileKPTerakhir" value="{{ $file_pangkat }}">
                        {{-- <label class="custom-file-label" for="fileKPTerakhir">File SK  Pangkat Terkahir (PDF)</label> --}}
                        <button  class="btn btn-sm btn-primary preview-btn" data-url="{{ $file_pangkat }}">Lihat File</button>
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label for="customFile" >SK CPNS</label>
                    <div class="custom-file">
                        {{-- <input type="file" name="fileCPNS" class="custom-file-input" id="fileCPNS" accept=".pdf" accept=".pdf" required>
                        <label class="custom-file-label" for="fileCPNS">File SK  CPNS (PDF) </label> --}}
                        <input type="hidden" name="fileCPNS" id="fileCPNS" value="{{$file_cpns}}">
                        <button class="btn btn-sm btn-primary preview-btn" data-url="{{$file_cpns}}">Lihat File</button>
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label for="customFile" >SK Jabatan Terakhir</label>
                    <div class="custom-file">
                        {{-- <input type="file" name="fileJabatan" class="custom-file-input" id="fileJabatan" accept=".pdf" accept=".pdf" required>
                        <label class="custom-file-label" for="fileJabatan">File SK Jabatan Terakhir (PDF)</label> --}}
                        <input type="hidden" name="fileJabatan" id="fileJabatan" value="{{$file_sk_jabatan}}">
                        <button class="btn btn-sm btn-primary preview-btn" data-url="{{$file_sk_jabatan}}">Lihat File</button>
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label for="customFile" >File SPP (Pelantikan)</label>
                    <div class="custom-file">
                        {{-- <input type="file" name="fileSPP" class="custom-file-input" id="fileSPP" accept=".pdf" accept=".pdf" required>
                        <label class="custom-file-label" for="fileSPP">File Pelantikan-SPP (PDF)</label> --}}
                        <input type="hidden" name="fileSPP" id="fileSPP" value="{{$file_spp_jabatan}}">
                        <button class="btn btn-sm btn-primary preview-btn" data-url="{{$file_spp_jabatan}}">Lihat File</button>
                    </div>
                </div>
            </div>
            <div class="form-row">
                
            </div>
        </fieldset>



        <div class="form-row">
            <div class="form-group col-md-5">
                <label for="customFile" >SKP Tahun {{date('Y')-1}}</label>
                <div class="custom-file">
                    <input type="file" name="fileSKPTahun1" class="custom-file-input form-control" id="fileSKPTahun1" accept=".pdf" accept=".pdf" required>
                    <label class="custom-file-label" for="fileSKPTahun1">File SKP Tahun {{ date('Y')-1 }} (PDF)</label>
                </div>
            </div>
            <div class="form-group col-md-5">
                <label for="customFile" >SKP Tahun {{date('Y')-2}}</label>
                <div class="custom-file">
                    <input type="file" name="fileSKPTahun2" class="custom-file-input" id="fileSKPTahun2" accept=".pdf" accept=".pdf" required>
                    <label class="custom-file-label" for="fileSKPTahun2">File SKP Tahun {{ date('Y')-2 }}  (PDF)</label>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-5">
                <label for="customFile" >Ijazah Terakhir</label>
                <div class="custom-file">
                    <input type="file" name="fileIjazah" class="custom-file-input" id="fileIjazah" accept=".pdf" accept=".pdf" >
                    <label class="custom-file-label" for="fileIjazah">File SK Ijazah (PDF)</label>
                    <small class="text-muted">*wajib untuk usulan Penyesuaian Ijazah/Struktural</small>
                </div> 
            </div>
            <div class="form-group col-md-5">
                <label for="customFile" >Transkrip Nilai</label>
                <div class="custom-file">
                    <input type="file" name="fileTranskrip" class="custom-file-input" id="fileTranskrip" accept=".pdf" accept=".pdf" >
                    <label class="custom-file-label" for="fileTranskrip">File Transkrip Nilai (PDF)</label>
                    <small class="text-muted">*wajib untuk usulan Penyesuaian Ijazah/Struktural</small>
                </div>
            </div>
        </div>
       
        <div class="form-row">
            <div class="form-group col-md-5">
                <label for="customFile" >Sertifikat Tanda Lulus Ujian Dinas (STLUD)</label>
                <div class="custom-file">
                    <input type="file" name="fileSTLUD" class="custom-file-input" id="fileSTLUD" accept=".pdf" accept=".pdf">
                    <label class="custom-file-label" for="fileSTLUD">File Sertifikat Ujian Dinas (PDF)</label>
                    <small class="text-muted">*wajib untuk usulan Penyesuaian Ijazah/Struktural</small>
                </div>
            </div>
            <div class="form-group col-md-5">
                <label for="customFile" >Ijin/Tugas Belajar</label>
                <div class="custom-file">
                    <input type="file" name="fileIjinBelajar" class="custom-file-input" id="fileIjinBelajar" accept=".pdf" accept=".pdf">
                    <label class="custom-file-label" for="fileIjinBelajar">File Ijin/Tugas Belajar (PDF)</label>
                    <small class="text-muted">*wajib untuk usulan Penyesuaian Ijazah</small>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-5">
                <label for="customFile" >Uraian Tugas Lama dan Baru</label>
                <div class="custom-file">
                    <input type="file" name="fileUraianTugas" class="custom-file-input" id="fileUraianTugas" accept=".pdf" accept=".pdf">
                    <label class="custom-file-label" for="fileUraianTugas">File Uraian Tugas (PDF)</label>
                    <small class="text-muted">*wajib untuk usulan Penyesuaian Ijazah</small>
                </div>
            </div>
            <div class="form-group col-md-5">
                <label for="customFile" >Penetapan Angka Kredit (PAK)</label>
                <div class="custom-file">
                    <input type="file" name="filePAK" class="custom-file-input" id="filePAK" accept=".pdf" accept=".pdf">
                    <label class="custom-file-label" for="filePAK">File PAK (PDF)</label>
                    <small class="text-muted">*wajib untuk usulan Jabatan Fungsional</small>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-5">
                <label for="customFile" >Akreditasi</label>
                <div class="custom-file">
                    <input type="file" name="fileAkreditasi" class="custom-file-input" id="fileAkreditasi" accept=".pdf" accept=".pdf">
                    <label class="custom-file-label" for="fileUraianTugas">File Akreditasi (PDF)</label>
                    <small class="text-muted">*wajib untuk usulan Penyesuaian Ijazah</small>
                </div>
            </div>
            <div class="form-group col-md-5">
                <label for="customFile" >Forlap Dikti</label>
                <div class="custom-file">
                    <input type="file" name="fileForlapDikti" class="custom-file-input" id="fileForlapDikti" accept=".pdf" accept=".pdf">
                    <label class="custom-file-label" for="filePAK">File Forlap DIKTI (PDF)</label>
                    <small class="text-muted">*wajib untuk usulan Penyesuaian Ijazah</small>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('usulkp.step2') }}" class="btn btn-secondary">Kembali</a>
    <button type="button" class="btn btn-primary" id="btnSubmit">Kirim Usulan</button>
  </form>


{{-- Modal PDF --}}
<div class="modal fade" id="pdfModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Preview PDF</h5>
            <a id="downloadLink" href="#" class="btn btn-success btn-sm ml-auto" target="_blank">
                Download PDF
            </a>
          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body" style="height:80vh;">
            {{-- <div id="loadingSpinner" style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); z-index:10;">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div> --}}

            <div id="loadingSpinner" class="custom-loader">
                <span></span><span></span><span></span>
            </div>
          <iframe id="pdfFrame" width="100%" height="100%" style="border:none;"></iframe>
        </div>
      </div>
    </div>
</div>



  <!-- Modal Konfirmasi -->
  <div class="modal fade" id="confirmationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Usulan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <strong>NIP :</strong> <span id="modalNip">{{ Session('usulkp.nip') }}</span>
                </div>
                <div class="mb-3">
                    <strong>Nama :</strong> <span id="modalNama">{{ Session('usulkp.nama') }}</span>
                </div>
                <div class="mb-3">
                    <strong>Jabatan :</strong> <span id="modalJabatan">{{ session('usulkp.jabatan') }}</span>
                </div>
                <div class="mb-3">
                    <strong>Satuan Kerja :</strong> <span id="modalSatker">{{ session('usulkp.satker') }}</span>
                </div>
                <div class="mb-3">
                    <strong>Jenis KP :</strong> <span id="modalSatker">{{ session('usulkp.jenisKP') }}</span>
                </div>
                <div class="alert alert-warning">
                    Pastikan semua data dan dokumen sudah benar sebelum mengirim usulan.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                
                <button type="button" id="confirmSubmit" class="btn btn-primary">Konfirmasi & Kirim</button>
            </div>
        </div>
    </div>
</div>




<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {


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


    $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });

    // Validasi form sebelum tampilkan modal
    $('#btnSubmit').click(function(e) {
        e.preventDefault();
        
        // Validasi file wajib diisi
        let isValid = true;
        $('input[required]').each(function() {
            if (!$(this).val()) {
                $(this).addClass('is-invalid');
                isValid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        
        if (isValid) {
            $('#confirmationModal').modal('show');
        } else {
            // alert('Harap lengkapi semua file wajib!');
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Harap lengkapi semua file wajib',
                confirmButtonText: 'Mengerti'
            });
        }
    });
    
    // Submit form setelah konfirmasi
    $('#confirmSubmit').click(function() {
        $('#confirmSubmit').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
        $('#formUsulan').submit();
        $('#btnSimpanValidasi').prop('disabled', false).html('Konfirmasi & Kirim');
    });

});

// Untuk preview PDF
$(document).ready(function() {
        $('.preview-btn').on('click', function() {
            var fileUrl = $(this).data('url');
            var encodedUrl = encodeURIComponent(fileUrl);
            var proxyUrl = '/preview-pdf-direct?url=' + encodedUrl;

            // Tampilkan spinner, sembunyikan iframe
            $('#loadingSpinner').show();
            $('#pdfFrame').hide().attr('src', proxyUrl);
            $('#downloadLink').attr('href', proxyUrl);
            $('#pdfModal').modal('show');
        });

         // Saat iframe selesai load, sembunyikan spinner
         $('#pdfFrame').on('load', function() {
            $('#loadingSpinner').fadeOut();
            $(this).fadeIn();
        });

        // Opsional: reset iframe & link saat modal ditutup
        $('#pdfModal').on('hidden.bs.modal', function () {
            $('#pdfFrame').attr('src', '');
            $('#downloadLink').attr('href', '#');
        });
    });

    // Menampilkan spinner load halaman
    document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('spinner').style.display = 'flex';
        });

    // Sembunyikan saat semua resource selesai load
    window.addEventListener('load', function() {
        document.getElementById('spinner').style.display = 'none';
    });
</script>
@endsection