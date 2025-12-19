@extends('master')
@section('header')
  <h1>Copy Resep - Rujukan</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'copy-resep/rujukan', 'class'=>'form-horizontal']) !!}
        <div class="row">
           <div class="col-md-6">
            <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Registrasi Tanggal</button>
                </span>
                {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => true]) !!}
                <small class="text-danger">{{ $errors->first('tga') }}</small>
            </div>
            <br>
          </div> 
           <div class="col-md-6">
            <div class="input-group{{ $errors->has('tgb') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('tgb') ? ' has-error' : '' }}" type="button">s/d Tanggal</button>
                </span>
                {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => true, 'onchange'=>'this.form.submit()']) !!}
                <small class="text-danger">{{ $errors->first('tgb') }}</small>
            </div>
            <br>
          </div>
        </div>
      {!! Form::close() !!}

     @if (isset($data))
       <div class='table-responsive'>
         <table class='table table-striped table-bordered table-hover table-condensed' id='data-pasien'>
           <thead>
             <tr>
               <th>No</th>
               <th>Nama</th>
               <th>RM Baru</th>
               <th>Poli</th>
               <th>Jenis</th>
               <th>Tgl Registrasi</th>
               <th>Resistensi Asetosal</th>
               <th>Ace Inhibitor</th>
             </tr>
           </thead>
           
           <tbody>
               @foreach ($data as $key => $d)
                    @php
                      $obat_rujukan = App\RujukanObat::where('registrasi_id', $d->registrasi_id)->first();
                      $obat_rujukan_old = App\RujukanObat::where('pasien_id', $d->pasien_id)->whereNotNull('riwayat')->first();
                    @endphp
                   <tr>
                     <td>{{ $no++ }}</td>
                     <td>{{ strtoupper($d->nama) }}</td>
                     <td>{{ $d->no_rm }}</td>
                     <td>{{ strtoupper(baca_poli($d->poli_id)) }}</td>
                     <td>{{ baca_carabayar($d->bayar) }}</td>
                     {{-- <td>{{ strtoupper($d->alamat) }}</td> --}}
                     <td>{{ tanggal_eklaim($d->tgl_regisrasi) }}</td>
                     <td>
                        <button class="btn btn-sm btn-success" onclick="showModalRujukanResistensi({{$d->registrasi_id}})">Buat</button>
                        @if (@$obat_rujukan->nama_obat)
                          <a href="{{url('copy-resep/cetak-obat-rujukan/' . $obat_rujukan->id . '?surat=resistensi')}}" target="_blank" class="btn btn-sm btn-info">Cetak</a>
                        @endif
                     </td>
                     <td>
                        <button class="btn btn-sm btn-success" onclick="showModalRujukanInhibitor({{$d->registrasi_id}})">Buat</button>
                        @if (@$obat_rujukan->riwayat)
                          <a href="{{url('copy-resep/cetak-obat-rujukan/' . $obat_rujukan->id . '?surat=inhibitor')}}" target="_blank" class="btn btn-sm btn-info">Cetak</a>
                          <button class="btn btn-sm btn-danger" onclick="hapusRujukanObat({{$obat_rujukan->id}})">Hapus Cetak</button>
                        @elseif (@$obat_rujukan_old->riwayat)
                          <a href="{{url('copy-resep/cetak-obat-rujukan/' . $obat_rujukan_old->id . '?surat=inhibitor')}}" target="_blank" class="btn btn-sm btn-info">Cetak</a>
                          <button class="btn btn-sm btn-danger" onclick="hapusRujukanObat({{$obat_rujukan_old->id}})">Hapus Cetak</button>
                        @endif
                     </td>
                   </tr>
                 @endforeach
             </tbody>
         </table>
       </div>
     @endif
    </div>
  </div>

    {{-- MODAL BUAT SURAT RUJUKAN RESISTENSI --}}
    <div class="modal fade" id="modalSuratRujukanResistensi">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"> Buat Surat Rujukan Resistensi Asetosal</h4>
          </div>
          <div class="modal-body">
            <form action="" method="POST" id="form_surat_rujukan_resistensi">
              {{csrf_field()}}
              <input type="hidden" name="registrasi_id" id="reg_id_hidden_resistensi">
              <input type="hidden" name="surat" value="resistensi">
              <div class="row">
                <div class="col-md-12">
                  <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:9pt;">
                      <tr>
                        <td style="width: 50%; font-weight: bold;">Diagnosa</td>
                        <td style="padding: 5px; font-size:9pt;">
                          <textarea rows="3" name="diagnosa" style="display:inline-block; resize: vertical;font-size:9pt;" placeholder="[Masukkan Diagnosa]" class="form-control" ></textarea>
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%; font-weight: bold;">Nama Obat</td>
                        <td style="padding: 5px;font-size:9pt;">
                          <input type="text" class="form-control" name="nama_obat" placeholder="Nama Obat" style="font-size:9pt;">
                        </td>
                      </tr>
                    </table>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary btn-flat" id="simpanSuratResistensi" >Buat</button>
          </div>
        </div>
      </div>
    </div>

    {{-- MODAL BUAT SURAT RUJUKAN ACE INHIBITOR --}}
    <div class="modal fade" id="modalSuratRujukanInhibitor">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"> Buat Surat Rujukan Ace Inhibitor</h4>
          </div>
          <div class="modal-body">
            <form action="" method="POST" id="form_surat_rujukan_inhibitor">
              {{csrf_field()}}
              <input type="hidden" name="registrasi_id" id="reg_id_hidden_inhibitor">
              <input type="hidden" name="surat" value="inhibitor">
              <div class="row">
                <div class="col-md-12">
                  <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:9pt;">
                      <tr>
                        <td style="width: 50%; font-weight: bold;">Rumah Sakit</td>
                        <td style="padding: 5px;font-size:9pt;">
                          <input type="text" class="form-control" name="rumah_sakit" placeholder="Rumah Sakit" style="font-size:9pt;">
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%; font-weight: bold;">Riwayat penggunaan obat ACEI</td>
                      </tr>
                      <tr>
                        <td>
                          <input type="radio" value="Tidak ada" name="riwayat[riwayat_penggunaan_obat_acei][status]">
                          <label style="font-weight: normal; margin-right: 10px;">Tidak ada</label>
                        </td>
                        <td>
                          <input type="radio" value="Ada" name="riwayat[riwayat_penggunaan_obat_acei][status]">
                          <label style="font-weight: normal; margin-right: 10px;">Ada</label>
                          <ul style="padding: 0; padding-left: 2rem;">
                            <li><b>(Captopril)</b> <br> Sejak 
                              <input type="date" class="form-control" name="riwayat[riwayat_penggunaan_obat_acei][captopril]" style="font-size:9pt;">
                            </li>
                            <li><b>(Lisinopril)</b> <br> Sejak 
                              <input type="date" class="form-control" name="riwayat[riwayat_penggunaan_obat_acei][lisinopril]" style="font-size:9pt;">
                            </li>
                            <li><b>(Ramipril)</b> <br> Sejak 
                              <input type="date" class="form-control" name="riwayat[riwayat_penggunaan_obat_acei][ramipril]" style="font-size:9pt;">
                            </li>
                          </ul>
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%; font-weight: bold;">Riwayat penggunaan obat STATIN</td>
                      </tr>
                      <tr>
                        <td>
                          <input type="radio" value="Tidak ada" name="riwayat[riwayat_penggunaan_obat_statin][status]">
                          <label style="font-weight: normal; margin-right: 10px;">Tidak ada</label>
                        </td>
                        <td>
                          <input type="radio" value="Ada" name="riwayat[riwayat_penggunaan_obat_statin][status]">
                          <label style="font-weight: normal; margin-right: 10px;">Ada</label>
                          <ul style="padding: 0; padding-left: 2rem;">
                            <li><b>(Simvastatin)</b> <br> Sejak 
                              <input type="date" class="form-control" style="font-size:9pt;" name="riwayat[riwayat_penggunaan_obat_statin][simvastatin]">
                            </li>
                          </ul>
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%; font-weight: bold;">Riwayat penggunaan obat ARB</td>
                      </tr>
                      <tr>
                        <td>
                          <input type="radio" value="Tidak ada" name="riwayat[riwayat_penggunaan_obat_arb][status]">
                          <label style="font-weight: normal; margin-right: 10px;">Tidak ada</label>
                        </td>
                        <td>
                          <input type="radio" value="Ada" name="riwayat[riwayat_penggunaan_obat_arb][status]">
                          <label style="font-weight: normal; margin-right: 10px;">Ada</label>
                          <ul style="padding: 0; padding-left: 2rem;">
                            <li><b>(Candesartan)</b> <br> Sejak 
                              <input type="date" class="form-control" style="font-size:9pt;" name="riwayat[riwayat_penggunaan_obat_arb][candesartan]">
                            </li>
                            <li><b>(Irbesarta)</b> <br> Sejak 
                              <input type="date" class="form-control" style="font-size:9pt;" name="riwayat[riwayat_penggunaan_obat_arb][irbesarta]">
                            </li>
                            <li><b>(Telmisartan)</b> <br> Sejak 
                              <input type="date" class="form-control" style="font-size:9pt;" name="riwayat[riwayat_penggunaan_obat_arb][telmisartan]">
                            </li>
                          </ul>
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 50%; font-weight: bold;">Riwayat penggunaan obat Insulin</td>
                      </tr>
                      <tr>
                        <td>
                          <input type="radio" value="Tidak ada" name="riwayat[riwayat_penggunaan_obat_insulin][status]">
                          <label style="font-weight: normal; margin-right: 10px;">Tidak ada</label>
                        </td>
                        <td>
                          <input type="radio" value="Ada" name="riwayat[riwayat_penggunaan_obat_insulin][status]">
                          <label style="font-weight: normal; margin-right: 10px;">Ada</label>
                          <ul style="padding: 0; padding-left: 2rem;">
                            <li><b>(Human Insulin : short acting/intermediate acting/mix insulin)</b> <br> Sejak 
                              <input type="date" class="form-control" style="font-size:9pt;" name="riwayat[riwayat_penggunaan_obat_insulin][human_insulin]">
                            </li>
                            <li><b>(Analog Insulin : rapid acting/mix insulin/long acting)</b> <br> Sejak 
                              <input type="date" class="form-control" style="font-size:9pt;" name="riwayat[riwayat_penggunaan_obat_insulin][analog_insulin]">
                            </li>
                          </ul>
                        </td>
                      </tr>
                    </table>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary btn-flat" id="simpanSuratInhibitor" >Buat</button>
          </div>
        </div>
      </div>
    </div>

@endsection

@section('script')
  <script type="text/javascript">
    $('.select2').select2();


    $("#data-pasien").dataTable()

    function showModalRujukanResistensi(registrasi_id) {
      $('#reg_id_hidden_resistensi').val(registrasi_id);
      $('#modalSuratRujukanResistensi').modal('show');
    }

    $('#simpanSuratResistensi').click(function () {
      let data = $('#form_surat_rujukan_resistensi').serialize();
      $.ajax({
            type: 'POST',
            url: '/copy-resep/simpan-surat-rujukan',
            data: data,
            success: function (data) {
              alert(data);
              if (data == "Berhasil membuat rujukan") {
                $('#modalSuratRujukan').modal('hide');
                window.location.reload();
              }
            }
        });
    })

    function showModalRujukanInhibitor(registrasi_id) {
      $('#reg_id_hidden_inhibitor').val(registrasi_id);
      $('#modalSuratRujukanInhibitor').modal('show');
    }

    $('#simpanSuratInhibitor').click(function () {
      let data = $('#form_surat_rujukan_inhibitor').serialize();
      $.ajax({
            type: 'POST',
            url: '/copy-resep/simpan-surat-rujukan',
            data: data,
            success: function (data) {
              alert(data);
              if (data == "Berhasil membuat rujukan") {
                $('#modalSuratRujukan').modal('hide');
                window.location.reload();
              }
            }
        });
    })

  </script>
  <script>
    function hapusRujukanObat(id) {
        if (confirm('Apakah Anda yakin ingin menghapus data rujukan ini?')) {
            $.ajax({
                url: '/copy-resep/hapus-obat-rujukan/' + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    alert(response.message);
                    location.reload();
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan saat menghapus data.');
                }
            });
        }
    }
  </script>    
@endsection
