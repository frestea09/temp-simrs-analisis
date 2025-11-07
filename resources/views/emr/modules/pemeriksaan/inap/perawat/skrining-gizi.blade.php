@extends('master')

<style>
    .form-box td,
    select,
    input,
    textarea {
        font-size: 12px !important;
    }

    .history-family input[type=text] {
        height: 20px !important;
        padding: 0px !important;
    }

    .history-family-2 td {
        padding: 1px !important;
    }
</style>
@section('header')
    <h1>Assesment</h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
            </h3>
        </div>
        <div class="box-body">
            <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">


            @include('emr.modules.addons.profile')
            <form method="POST" action="{{ url('emr-soap/pemeriksaan-gizi/' . $unit . '/' . $reg->id) }}"
                class="form-horizontal">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            @include('emr.modules.addons.tab-gizi')
                            {{ csrf_field() }}
                            {!! Form::hidden('registrasi_id', $reg->id) !!}
                            {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                            {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                            {!! Form::hidden('unit', $unit) !!}
                            {!! Form::hidden('asessment_id', @$riwayat->id) !!}
                        </div>
                        <br>
                        <div class="col-md-6">
                            <h5 class="text-center"><b>SKRINING NUTRISI DEWASA</b></h5>
                            <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table" style="font-size:12px;">
                
                              <tr>
                                <td style="width: 50%; font-weight:bold">BB</td>
                                <td>
                                  <input type="text" class="form-control" name="nutrisi[bb][detail]" style="width: 100%" placeholder="BB" value="{{ @$nutrisi['bb']['detail'] }}">
                                </td>
                              </tr>
                
                              <tr>
                                <td style="width:50%; font-weight:bold;">
                                    1. Apakah pasien mengalami penurunan berat badan yang tidak direncanakan ?
                                    <ul>
                                      <li>Tidak (Tidak terjadi penurunan dalam 6 bulan terakhir) => 0</li>
                                      <li>Tidak yakin (Tanyakan apakah baju/celana terasa longgar) => 2</li>
                                      <li>
                                        Ya, berapa penurunan berat badan tersebut ?
                                        <ul>
                                          <li>1 - 5 kg => 1</li>
                                          <li>6 - 10 kg => 2</li>
                                          <li>11 - 15 kg => 3</li>
                                          <li>> 15 kg => 4</li>
                                          <li>Tidak Yakin => 2</li>
                                        </ul>
                                      </li>
                                    </ul>
                                </td>
                                <td style="vertical-align: middle;">
                                    <input type="text" class="form-control skorSkrining" name="nutrisi[skor][1]" style="width: 100%" placeholder="1" value="{{ @$nutrisi['skor']['1'] }}" onblur="totalSkor()">
                                </td>
                              </tr>
                
                              <tr>
                                <td style="width:50%; font-weight:bold;">
                                    2. Apakah asupan makanan pasien buruk akibat nafsu makan yang menurun **? (Misalnya asupan makan hanya 1/4 dari biasanya)
                                    <ul>
                                        <li>Tidak => 0</li>
                                        <li>Ya => 1</li>
                                    </ul>
                                </td>
                                <td style="vertical-align: middle;">
                                    <input type="text" class="form-control skorSkrining" name="nutrisi[skor][2]" style="width: 100%" placeholder="0" value="{{ @$nutrisi['skor']['2'] }}" onblur="totalSkor()">
                                </td>
                              </tr>
                
                              <tr>
                                <td style="width:50%; font-weight:bold;">
                                    3. Sakit Berat ***)
                                    <ul>
                                      <li>Tidak => 0</li>
                                      <li>Ya => 2</li>
                                    </ul>
                                </td>
                                <td style="vertical-align: middle;">
                                    <input type="text" class="form-control skorSkrining" name="nutrisi[skor][3]" style="width: 100%" placeholder="1" value="{{ @$nutrisi['skor']['3'] }}" onblur="totalSkor()">
                                </td>
                              </tr>
                
                              <tr>
                                <td style="width:50%; font-weight:bold;">Total Skor</td>
                                <td>
                                  <input type="text" class="form-control" name="nutrisi[skor][total]" id="totalSkorId" value="{{ @$nutrisi['skor']['total'] }}" style="width: 100%">
                                </td>
                              </tr>
                              <tr>
                                <td style="width:50%; font-weight:bold;">Kesimpulan dan tindak lanjut</td>
                                <td>
                                  <input type="text" class="form-control" name="nutrisi[skor][kesimpulan]" id="kesimpulanSkorId" value="{{ @$nutrisi['skor']['kesimpulan'] }}" style="width: 100%">
                                </td>
                              </tr>
                              <tr>
                                <td colspan="2">Keterangan</td>
                              </tr>
                              <tr>
                                <td style="width:50%; font-weight:bold;" colspan="2">
                                  <ul style="font-weight: normal">
                                      <li>
                                        Total skor >= 2 : Risiko malnutrisi.
                                      </li>
                                      <li>
                                        *Malnutrisi yang dimaksud dalam hal ini adalah kurang gizi.
                                      </li>
                                      <li>
                                        ** Asupan makan yang buruk dapat juga terjadi karena gangguan mengunyah atau menelan
                                      </li>
                                      <li>
                                        Penurunan berat badan yang tidak direncanakan pada pasien dengan kelebihan berat atau obes berisiko terjadinya malnutrisi.
                                      </li>
                                      <li>
                                        *** Penyakit yang berisiko terjadi gangguan gizi diantaranya: dirawat di HCU/ICU, penurunan kesadaran, 
                                        kegawatan abdomen (pendarahan, ileus, perotonitis, asites massif, tumor intrabdomen besar, post operasi), 
                                        gangguan pernapasan berat, keganasan komplikasi, gagal jantung, gagal ginjal kronik, gagal hati, diabetes melitus, 
                                        atau kondisi sakit berat lain.
                                      </li>
                                  </ul>
                                </td>
                              </tr>
                              <tr>
                                <td style="width:50%; font-weight:bold;">
                                  Diverifikasi oleh       
                                </td>
                                <td>
                                  <input type="text" name="nutrisi[verifikasi][nama]" class="form-control" value="{{ @Auth::user()->name }}" readonly>
                                </td>
                              </tr>

                              @if (@$cppt)
                                @if ($cppt->user->Pegawai->kategori_pegawai == 1)
                                {{-- @if ($cppt->assesment) --}}
                                  <tr>
                                    <td style="width:50%; font-weight:bold;">
                                      Diagnosa
                                    </td>
                                    <td>
                                      {!! @$cppt->assesment !!}
                                    </td>
                                  </tr>
                                @endif

                                @if (@$cppt->diagnosistambahan)
                                <tr>
                                  <td style="width:50%; font-weight:bold;">
                                    Diagnosa Tambahan
                                  </td>
                                  <td>
                                    {!! @$cppt->diagnosistambahan !!}
                                  </td>
                                </tr>
                                    
                                @endif
                              @endif
                              <tr>
                                <td style="width:50%; font-weight:bold;">
                                  Diverifikasi oleh       
                                </td>
                                <td>
                                  <input type="text" name="nutrisi[verifikasi][nama]" class="form-control" value="{{ @Auth::user()->name }}" readonly>
                                </td>
                              </tr>
                              <tr>
                                <td style="width:50%; font-weight:bold;">
                                  Dibuat oleh       
                                </td>
                                <td>
                                  <select name="user_id" class="select2" style="width: 100%;">
                                    @if (@$assesment && !in_array(@$assesment->user_id, [898, 905, 900, 907, 902, 904, 918, 903, 919]))
                                      <option value="{{@$assesment->user_id}}" selected>{{@$assesment->user->name}}</option>
                                    @endif
                                    <option value="898" {{@$assesment->user_id == 898}}>{{baca_user(898)}}</option>
                                    <option value="905" {{@$assesment->user_id == 905}}>{{baca_user(905)}}</option>
                                    <option value="900" {{@$assesment->user_id == 900}}>{{baca_user(900)}}</option>
                                    <option value="907" {{@$assesment->user_id == 907}}>{{baca_user(907)}}</option>
                                    <option value="902" {{@$assesment->user_id == 902}}>{{baca_user(902)}}</option>
                                    <option value="904" {{@$assesment->user_id == 904}}>{{baca_user(904)}}</option>
                                    <option value="918" {{@$assesment->user_id == 918}}>{{baca_user(918)}}</option>
                                    <option value="903" {{@$assesment->user_id == 903}}>{{baca_user(903)}}</option>
                                    <option value="919" {{@$assesment->user_id == 919}}>{{baca_user(919)}}</option>
                                  </select>
                                </td>
                              </tr>
                            </table>
                            @if (@$nutrisiId != 'Y')
                            <div class="col-md-12 text-right">
                                <button class="btn btn-success" type="button" onclick="alert('Mohon pilih data skrining yang akan diverifikasi terlebuh dahulu!')">Verifikasi</button>
                            </div>
                            @else
                            <div class="col-md-12 text-right">
                                <button class="btn btn-success">Verifikasi</button>
                            </div>
                            @endif
                          </div>
                        {{-- Alergi --}}
                        <div class="col-md-6">
                            <div class="box box-solid box-warning">
                                <div class="box-header">
                                    <h5><b>Riwayat Skrining Gizi</b></h5>
                                </div>
                                <div class="box-body table-responsive" style="max-height: 400px">
                                    <table style="width: 100%"
                                        class="table-striped table-bordered table-hover table-condensed form-box bordered table"
                                        style="font-size:12px;">
                                        @if (count($riwayats) == 0)
                                            <tr>
                                                <td><i>Belum ada catatan</i></td>
                                            </tr>
                                        @endif
                                        @foreach ($riwayats as $item)
                                            @php
                                                $data = json_decode($item->nutrisi, true);
                                            @endphp
                                            <tr>
                                                <td>
                                                    <b>BB :</b> {{@$data['bb']['detail']}} Kg<br />
                                                    <b>Total Skor :</b> {{@$data['skor']['total']}}<br />
                                                    <b>Kesimpulan :</b> {{@$data['skor']['kesimpulan']}}<br />
                                                    <b>Dibuat oleh:</b> {{ @$item->user->name }}<br />
                                                    @if (@$data['verifikasi']['nama'])
                                                    <b>Diverifikasi oleh:</b> {{ @$data['verifikasi']['nama'] }}<br />
                                                    @endif
                                                    <span class="pull-right">
                                                        @if (@$data['verifikasi']['nama'])
                                                            <small class="text-success">Telah Diverifikasi</small>
                                                        @else
                                                            <a href="{{ URL::current() . '?asessment_id='. $item->id }}" class="label label-success">Verifikasi</a>
                                                        @endif
                                                        <small>{{ date('d-m-Y, H:i:s', strtotime($item->created_at)) }}</small>
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>

                        <br /><br />
                    </div>


                </div>

                
            </form>
            <br />
            <br />
            {{-- <div class="col-md-12 text-right">
      <table class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
        <thead>
          <tr>
            <th>No</th>
            <th>Kode(ICD 9)</th>
            <th>Deskripsi</th>
            <th>Diagnosa</th>
            <th>Tanggal</th>
          </tr>
        </thead>
         <tbody>
          @foreach ($riwayat as $key => $item)
              <tr>
                <td>{{$key+1}}</td>
                <td>{{$item->icd9}}</td>
                <td>{{baca_icd9($item->icd9)}}</td>
                <td>{{$item->diagnosis}}</td>
                <td>{{date('d-m-Y, H:i:s',strtotime($item->created_at))}}</td>
              </tr>
          @endforeach
         </tbody>
      </table>
    </div> --}}

        </div>
    @endsection

    @section('script')
        <script>
          function totalSkor(){
            var arr = document.getElementsByClassName('skorSkrining');
            var tot=0;
            for(var i=0;i<arr.length;i++){
                if(parseInt(arr[i].value))
                    tot += parseInt(arr[i].value);
            }
            document.getElementById('totalSkorId').value = tot;
            
            if (tot > 3) {
              document.getElementById('kesimpulanSkorId').value = 'Rujuk ke dokter Spesialis Gizi Klinik';
            } else if (tot < 2) {
              document.getElementById('kesimpulanSkorId').value = 'Skrining ulang 7 hari';
            } else if (tot <= 3) {
              document.getElementById('kesimpulanSkorId').value = 'Rujuk ke dietisien';
            }
          }
        </script>
        <script type="text/javascript">
            //ICD 10
            $('.select2').select2();
            $("input[name='diagnosa_awal']").on('focus', function() {
                $("#dataICD10").DataTable().destroy()
                $("#ICD10").modal('show');
                $('#dataICD10').DataTable({
                    "language": {
                        "url": "/json/pasien.datatable-language.json",
                    },

                    pageLength: 10,
                    autoWidth: false,
                    processing: true,
                    serverSide: true,
                    ordering: false,
                    ajax: '/sep/geticd9',
                    columns: [
                        // {data: 'rownum', orderable: false, searchable: false},
                        {
                            data: 'id'
                        },
                        {
                            data: 'nomor'
                        },
                        {
                            data: 'nama'
                        },
                        {
                            data: 'add',
                            searchable: false
                        }
                    ]
                });
            });

            $(document).on('click', '.addICD', function(e) {
                document.getElementById("diagnosa_awal").value = $(this).attr('data-nomor');
                $('#ICD10').modal('hide');
            });
            $(".skin-red").addClass("sidebar-collapse");
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var target = $(e.target).attr("href") // activated tab
                // alert(target);
            });
            $("#date_tanpa_tanggal").datepicker({
                format: "mm-yyyy",
                viewMode: "months",
                minViewMode: "months"
            });
            $("#date_dengan_tanggal").attr('required', true);
        </script>
    @endsection
