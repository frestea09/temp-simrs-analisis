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
            <form method="POST" action="{{ url('emr-soap/asuhan-gizi-terintegrasi/' . $unit . '/' . $reg->id) }}"
                class="form-horizontal">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            @include('emr.modules.addons.tabs')
                            {{ csrf_field() }}
                            {!! Form::hidden('registrasi_id', $reg->id) !!}
                            {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                            {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                            {!! Form::hidden('unit', $unit) !!}
                        </div>
                        <br>
                        {{-- Anamnesis --}}
                        <div class="col-md-6">
                            <h5 style="text-align: center; font-size: 1.5em"><b>Asuhan Gizi Terintegrasi</b></h5>

                            <h5 style="text-align: center;"><b>Assesmen Gizi (A)</b></h5>
                            <table style="width: 100%"
                                class="table-striped table-bordered table-hover table-condensed form-box table"
                                style="font-size:12px;">
                               
                                <tr>
                                    <td style="width:50%; font-weight:bold;">BB</td>
                                    <td>
                                        <input type="number" class="form-control" placeholder="Kg" name="data[assesment][BB]" style="width: 100%">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:50%; font-weight:bold;">TB</td>
                                    <td>
                                        <input type="number" class="form-control" placeholder="cm" name="data[assesment][TB]" style="width: 100%">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:50%; font-weight:bold;">IMT</td>
                                    <td>
                                        <input type="text" class="form-control" name="data[assesment][IMT]" style="width: 100%" placeholder="kg/cm2">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:50%; font-weight:bold;">LLA</td>
                                    <td>
                                        <input type="text" class="form-control" name="data[assesment][LLA]" style="width: 100%" placeholder="cm">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:50%; font-weight:bold;">Tinggi Lutut</td>
                                    <td>
                                        <input type="text" class="form-control" name="data[assesment][tinggiLutut]" style="width: 100%" placeholder="cm">
                                    </td>
                                </tr>
                            </table>

                            <h5 style="text-align: center;"><b>Biokimia</b></h5>
                            <table style="width: 100%"
                                class="table-striped table-bordered table-hover table-condensed form-box table"
                                style="font-size:12px;">
                                <tr>
                                    <td style="width:30%; font-weight:bold;">Kesimpulan</td>
                                    <td>
                                        <textarea class="form-control" name="data[biokimia][kesimpulan]" style="width: 100%" rows="4"></textarea>
                                    </td>
                                </tr>
                            </table>

                            <h5 style="text-align: center;"><b>Klinik / Fisik</b></h5>
                            <table style="width: 100%"
                                class="table-striped table-bordered table-hover table-condensed form-box table"
                                style="font-size:12px;">
                                <tr>
                                    <td style="width:30%; font-weight:bold;">TD</td>
                                    <td>
                                        <input type="text" class="form-control" name="data[fisik][TD]" style="width: 100%">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:30%; font-weight:bold;">N</td>
                                    <td>
                                        <input type="text" class="form-control" name="data[fisik][N]" style="width: 100%">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:30%; font-weight:bold;">RR</td>
                                    <td>
                                        <input type="text" class="form-control" name="data[fisik][RR]" style="width: 100%">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:30%; font-weight:bold;">S</td>
                                    <td>
                                        <input type="text" class="form-control" name="data[fisik][S]" style="width: 100%">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:30%; font-weight:bold;">Keadaan Umum</td>
                                    <td>
                                        <textarea class="form-control" name="data[fisik][keadaanUmum]" style="width: 100%" rows="4"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:30%; font-weight:bold;">Gangguan Gastrointestinal</td>
                                    <td>
                                        <textarea class="form-control" name="data[fisik][gastro]" style="width: 100%" rows="4"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:30%; font-weight:bold;">Kesimpulan</td>
                                    <td>
                                        <textarea class="form-control" name="data[fisik][kesimpulan]" style="width: 100%" rows="4"></textarea>
                                    </td>
                                </tr>
                            </table>

                            <h5 style="text-align: center;"><b>Riwayat Gizi</b></h5>
                            <table style="width: 100%"
                                class="table-striped table-bordered table-hover table-condensed form-box table"
                                style="font-size:12px;">
                                <tr>
                                    <td style="width:30%; font-weight:bold;">Alergi Makan</td>
                                    <td>
                                        <textarea class="form-control" name="data[riwayatGizi][alergiMakan]" style="width: 100%" rows="4"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:30%; font-weight:bold;">Pantangan Makan</td>
                                    <td>
                                        <textarea class="form-control" name="data[riwayatGizi][pantanganMakan]" style="width: 100%" rows="4"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:30%; font-weight:bold;">Pola Makan</td>
                                    <td>
                                        <textarea class="form-control" name="data[riwayatGizi][polaMakan]" style="width: 100%" rows="4"></textarea>
                                    </td>
                                </tr>
                            </table>

                            <h5 style="text-align: center;"><b>Riwayat Personel</b></h5>
                            <table style="width: 100%"
                                class="table-striped table-bordered table-hover table-condensed form-box table"
                                style="font-size:12px;">
                                <tr>
                                    <td style="width:30%; font-weight:bold;">Kesimpulan</td>
                                    <td>
                                        <textarea class="form-control" name="data[riwayatPersonel][kesimpulan]" style="width: 100%" rows="4"></textarea>
                                    </td>
                                </tr>
                            </table>

                            <h5 style="text-align: center;"><b>Diagnosa Gizi (D)</b></h5>
                            <table style="width: 100%"
                                class="table-striped table-bordered table-hover table-condensed form-box table"
                                style="font-size:12px;">
                                <tr>
                                    <td style="width:30%; font-weight:bold;">Diagnosa</td>
                                    <td>
                                        <textarea class="form-control" name="data[diagnosaGizi][diagnosa]" style="width: 100%" rows="4"></textarea>
                                    </td>
                                </tr>
                            </table>

                            <h5 style="text-align: center;"><b>Intervensi (I)</b></h5>
                            <table style="width: 100%"
                                class="table-striped table-bordered table-hover table-condensed form-box table"
                                style="font-size:12px;">
                                <tr>
                                    <td style="width:30%; font-weight:bold;">Tujuan Diet</td>
                                    <td>
                                        <textarea class="form-control" name="data[intervensi][tujuanDiet]" style="width: 100%" rows="4"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:30%; font-weight:bold;">Bentuk Makan</td>
                                    <td>
                                        <textarea class="form-control" name="data[intervensi][bentukMakan]" style="width: 100%" rows="4"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:30%; font-weight:bold;">Cara Pemberian</td>
                                    <td>
                                        <textarea class="form-control" name="data[intervensi][caraPemberian]" style="width: 100%" rows="4"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:30%; font-weight:bold;">Syarat Diet</td>
                                    <td>
                                        <textarea class="form-control" name="data[intervensi][syaratDiet]" style="width: 100%" rows="4"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:30%; font-weight:bold;">Kebutuhan Gizi (Energi)</td>
                                    <td>
                                        <textarea class="form-control" name="data[intervensi][kebutuhanGizi][energi]" style="width: 100%" rows="4"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:30%; font-weight:bold;">Kebutuhan Gizi (Protein)</td>
                                    <td>
                                        <textarea class="form-control" name="data[intervensi][kebutuhanGizi][protein]" style="width: 100%" rows="4"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:30%; font-weight:bold;">Kebutuhan Gizi (Lemak)</td>
                                    <td>
                                        <textarea class="form-control" name="data[intervensi][kebutuhanGizi][lemak]" style="width: 100%" rows="4"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:30%; font-weight:bold;">Kebutuhan Gizi (karbohidrat)</td>
                                    <td>
                                        <textarea class="form-control" name="data[intervensi][kebutuhanGizi][karbohidrat]" style="width: 100%" rows="4"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:30%; font-weight:bold;">Kebutuhan Gizi (Zat Gizi Lain)</td>
                                    <td>
                                        <textarea class="form-control" name="data[intervensi][kebutuhanGizi][dll]" style="width: 100%" rows="4"></textarea>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td style="width:30%; font-weight:bold;">Implementasi ( Jenis Diest)</td>
                                    <td>
                                        <textarea class="form-control" name="data[intervensi][implementasi][jenisDiet]" style="width: 100%" rows="4"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:30%; font-weight:bold;">Implementasi (Extra)</td>
                                    <td>
                                        <textarea class="form-control" name="data[intervensi][implementasi][extra]" style="width: 100%" rows="4"></textarea>
                                    </td>
                                </tr>
                            </table>

                            <h5 style="text-align: center;"><b>Monitoring dan Evaluasi (ME)</b></h5>
                            <table style="width: 100%"
                                class="table-striped table-bordered table-hover table-condensed form-box table"
                                style="font-size:12px;">
                                <tr>
                                    <td style="width:30%; font-weight:bold;">Rencana</td>
                                    <td>
                                        <textarea class="form-control" name="data[monitoring][rencana]" style="width: 100%" rows="4"></textarea>
                                    </td>
                                </tr>
                            </table>
                            
                        </div>
                        {{-- Alergi --}}
                        <div class="col-md-6">
                            <div class="box box-solid box-warning">
                                <div class="box-header">
                                    <h5><b>Riwayat Asuhan Gizi</b></h5>
                                </div>
                                <div class="box-body table-responsive" style="max-height:2500px">
                                    <table style="width: 100%"
                                        class="table-striped table-bordered table-hover table-condensed form-box bordered table"
                                        style="font-size:12px;">
                                        @if (count($riwayat) == 0)
                                            <tr>
                                                <td><i>Belum ada catatan</i></td>
                                            </tr>
                                        @endif
                                        @foreach ($riwayat as $item)
                                            @php
                                                $data = json_decode($item->fisik, true);
                                            @endphp
                                            <tr>
                                                <td>
                                                    <b>BB :</b>{{@$data['assesment']['BB']}} KG<br />
                                                    <b>TB :</b>{{@$data['assesment']['TB']}} CM<br />
                                                    <b>IMT :</b>{{@$data['assesment']['IMT']}} KG/CM <sub>2</sub><br />
                                                    <b>LLA :</b>{{@$data['assesment']['LLA']}} CM <br />
                                                    <b>Tinggi Lutut :</b>{{@$data['assesment']['tinggiLutut']}} CM <br />
                                                   
                                                    <b>Biokimia Kesimpulan :</b>{{@$data['biokimia']['kesimpulan']}}  <br />

                                                    <b>TD :</b>{{@$data['fisik']['TD']}}  <br />
                                                    <b>N :</b>{{@$data['fisik']['N']}}  <br />
                                                    <b>RR :</b>{{@$data['fisik']['RR']}}  <br />
                                                    <b>S :</b>{{@$data['fisik']['S']}}  <br />
                                                    <b>Keadaan Umum:</b>{{@$data['fisik']['keadaanUmum']}}  <br />
                                                    <b>Gangguan Gastrointestinal:</b>{{@$data['fisik']['gastro']}}  <br />
                                                    <b>Kesimpulan Fisik:</b>{{@$data['fisik']['kesimpulan']}}  <br />
                                                
                                                    <b>Alergi Makan:</b>{{@$data['riwayatGizi']['alergiMakan']}}  <br />
                                                    <b>Pantangan Makan:</b>{{@$data['riwayatGizi']['pantanganMakan']}}  <br />
                                                    <b>Pola Makan:</b>{{@$data['riwayatGizi']['polaMakan']}}  <br />

                                                    <b>Riwayat Personel:</b>{{@$data['riwayatPersonel']['kesimpulan']}}  <br />

                                                    <b>Diagnosa Gizi (D):</b>{{@$data['diagnosaGizi']['diagnosa']}}  <br />

                                                    <b>Tujuan Diet:</b>{{@$data['intervensi']['tujuanDiet']}}  <br />
                                                    <b>Bentuk Makan:</b>{{@$data['intervensi']['bentukMakan']}}  <br />
                                                    <b>Cara Pemberian:</b>{{@$data['intervensi']['caraPemberian']}}  <br />
                                                    <b>Syarat Diet:</b>{{@$data['intervensi']['syaratDiet']}}  <br />
                                                    <b>Kebutuhan Gizi (Protein):</b>{{@$data['intervensi']['kebutuhanGizi']['protein']}}  <br />
                                                    <b>Kebutuhan Gizi (Lemak):</b>{{@$data['intervensi']['kebutuhanGizi']['lemak']}}  <br />
                                                    <b>Kebutuhan Gizi (Karbohidrat):</b>{{@$data['intervensi']['kebutuhanGizi']['karbohidrat']}}  <br />
                                                    <b>Kebutuhan Gizi (Zat Gizi Lain):</b>{{@$data['intervensi']['kebutuhanGizi']['dll']}}  <br />
                                                    <b>Jenis Diet:</b>{{@$data['intervensi']['implementasi']['jenisDiet']}}  <br />
                                                    <b>Extra:</b>{{@$data['intervensi']['implementasi']['extra']}}  <br />

                                                    <b>Monitoring dan Evaluasi (ME):</b>{{@$data['monitoring']['rencana']}}  <br />
                                                    

                                                    <b>Dibuat oleh:</b> {{ @App\User::find(@$item->user_id)->name }}<br />
                                                    {{ date('d-m-Y, H:i:s', strtotime($item->created_at)) }}
                                                    <span class="pull-right">
                                                        {{-- <a onclick="return confirm('Yakin akan menghapus data?')" href="{{url('emr-soap-rawatinap/perencanaan/surat/'.$reg->id.'/'.$item->id.'/delete')}}" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash text-danger"></i></a>&nbsp;&nbsp; --}}
                                                        {{-- <a target="_blank"
                                                            href="{{ url('emr-soap-cetak-permintaan-konseling-gizi/' . $reg->id . '/' . $item->id) }}"
                                                            data-toggle="tooltip" title="Cetak Surat"><i
                                                                class="fa fa-print text-warning"></i></a>&nbsp;&nbsp; --}}
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

                <div class="col-md-12 text-right">
                    <button class="btn btn-success">Simpan</button>
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
