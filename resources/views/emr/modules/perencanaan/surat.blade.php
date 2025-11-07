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
    <h1>Perencanaan - Surat Sakit</h1>
@endsection

@section('content')
    @php
        
        $poli = request()->get('poli');
        $dpjp = request()->get('dpjp');
    @endphp
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
            </h3>
        </div>
        <div class="box-body">
            <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">

            @include('emr.modules.addons.profile')
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12">
                        @include('emr.modules.addons.tabs')
                    </div>
                    <div class="col-md-8">
                        <form method="POST" action="{{ url('emr-soap/perencanaan/surat/' . $unit . '/' . $reg->id) }}"
                            class="form-horizontal" style="width: 100%">
                            {{ csrf_field() }}
                            {!! Form::hidden('registrasi_id', $reg->id) !!}
                            {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                            {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                            {!! Form::hidden('unit', $unit) !!}
                            {!! Form::hidden('poli', $poli) !!}
                            {!! Form::hidden('dpjp', $dpjp) !!}
                            <br>
                            {{-- Anamnesis --}}
                            <div>
                                <h5><b>Surat Sakit</b></h5>
                                <table style="width: 100%"
                                    class="table-striped table-bordered table-hover table-condensed form-box table"
                                    style="font-size:12px;">
                                    <tr>
                                        <td style="width:20%;">Mulai Tanggal</td>
                                        <td style="padding: 5px;">
                                            <input type="date" value="{{ date('Y-m-d') }}" name="tgl_kontrol" id="tgl_kontrol" class="form-control" />
                                            <small class="pull-right">Klik icon <b>kalender</b> untuk memunculkan tanggal</small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:20%;">Sampai Tanggal</td>
                                        <td style="padding: 5px;">
                                            <input type="date" value="{{ date('Y-m-d', strtotime('+1 day')) }}" name="tgl_selesai" id="tgl_selesai" class="form-control" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:20%;">Lama Istirahat / Hari</td>
                                        <td style="padding: 5px;">
                                            <input type="text" value="0 hari" name="lama_istirahat_text" id="lama_istirahat_text" class="form-control" />
                                            <input type="hidden" value="0" name="lama_istirahat" id="lama_istirahat" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 5px;" colspan="2">
                                            <textarea rows="5" name="keterangan" style="display:inline-block; resize:vertical;" placeholder="[Keterangan]" class="form-control">{{ @$cppt_dokter->assesment ?? @$asesmen['diagnosa'] }}</textarea>
                                        </td>
                                        </td>
                                    </tr>

                                </table>
                            </div>
                            <div class="text-right">
                                <button class="btn btn-success">Simpan</button>
                            </div>
                        </form>
                    </div>


                    {{-- Alergi --}}
                    <div class="col-md-4" style="margin-top: 50px">
                        <div class="box box-solid box-warning">
                            <div class="box-header">
                                <h5><b>Catatan Medis</b></h5>
                            </div>
                            <div class="box-body table-responsive" style="max-height: 400px">
                                <table style="width: 100%"
                                    class="table-striped table-bordered table-hover table-condensed form-box bordered table"
                                    style="font-size:12px;">
                                    @if (count($riwayat) == 0)
                                        <tr>
                                            <td><i>Belum ada catatan</i></td>
                                        </tr>
                                    @endif
                                    @foreach ($riwayat as $item)
                                        <tr>
                                            <td>
                                                <b>Mulai Tanggal :</b>
                                                {{ date('d-m-Y', strtotime($item->tgl_kontrol)) }}<br />
                                                <b>Sampai Tanggal :</b>
                                                {{ date('d-m-Y', strtotime($item->tgl_selesai)) }}<br />
                                                <b>Lama Istirahat/Hari :</b> {{ $item->lama_istirahat }} hari<br />
                                                <b>Keterangan :</b> {{ $item->keterangan }}<br />
                                                {{ date('d-m-Y, H:i:s', strtotime($item->created_at)) }}
                                                <span class="pull-right">
                                                    <a onclick="return confirm('Yakin akan menghapus data?')" href="{{url('emr-soap/perencanaan/surat/inap/'.$reg->id.'/'.$item->id.'/delete')}}" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash text-danger"></i></a>&nbsp;&nbsp;
                                                    <a target="_blank"
                                                        href="{{ url('emr-soap-print-surat/' . $reg->id . '/' . $item->id) }}"
                                                        data-toggle="tooltip" title="Cetak Surat"><i
                                                            class="fa fa-print text-warning"></i></a>&nbsp;&nbsp;
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

            $(".skin-red").addClass("sidebar-collapse");
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var target = $(e.target).attr("href") // activated tab
                // alert(target);
            });
            $('.select2').select2();
            $("#date_tanpa_tanggal").datepicker({
                format: "mm-yyyy",
                viewMode: "months",
                minViewMode: "months"
            });
            $("#date_dengan_tanggal").attr('required', true);
        </script>
        <script>
            const tglKontrol = document.getElementById('tgl_kontrol');
            const tglSelesai = document.getElementById('tgl_selesai');
            const lamaIstirahatText = document.getElementById('lama_istirahat_text');
            const lamaIstirahatHidden = document.getElementById('lama_istirahat');
            function hitungLamaIstirahat() {
                const tgl1 = new Date(tglKontrol.value);
                const tgl2 = new Date(tglSelesai.value);
                if (!isNaN(tgl1) && !isNaN(tgl2)) {
                    const selisih = Math.ceil((tgl2 - tgl1) / (1000 * 60 * 60 * 24)) + 1;
                    const jumlahHari = selisih > 0 ? selisih : 0;
                    lamaIstirahatText.value = jumlahHari + " hari";
                    lamaIstirahatHidden.value = jumlahHari;
                } else {
                    lamaIstirahatText.value = "0 hari";
                    lamaIstirahatHidden.value = 0;
                }
            }
            tglKontrol.addEventListener('change', hitungLamaIstirahat);
            tglSelesai.addEventListener('change', hitungLamaIstirahat);

            window.addEventListener('DOMContentLoaded', hitungLamaIstirahat);
        </script>
    @endsection
