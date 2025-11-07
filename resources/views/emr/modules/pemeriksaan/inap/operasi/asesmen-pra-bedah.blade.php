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

    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }

    input[type="date"]::-webkit-calendar-picker-indicator {
        background: transparent;
        bottom: 0;
        color: transparent;
        cursor: pointer;
        height: auto;
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
        width: auto;
    }
</style>
@section('header')
    <h1>Operasi</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">
        </h3>
    </div>
    <div class="box-body">
      <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">
      <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
      <script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>

      @include('emr.modules.addons.profile')
      <form method="POST" action="{{ url('emr-soap/pemeriksaan/asesmen-pra-bedah/' . $unit . '/' . $reg->id) }}" class="form-horizontal">
        <div class="row">
          @include('emr.modules.addons.tab-operasi')
          <div class="col-md-12">
            {{ csrf_field() }}
            {!! Form::hidden('registrasi_id', $reg->id) !!}
            {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
            {!! Form::hidden('cara_bayar', $reg->bayar) !!}
            {!! Form::hidden('unit', $unit) !!}
            <br>

            <div class="col-md-12">
                <table class='table-striped table-bordered table-hover table-condensed table'>
                    <thead>
                        <tr>
                            <th class="text-center" style="vertical-align: middle;">Tanggal Asessment</th>
                            <th class="text-center" style="vertical-align: middle;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($riwayats) == 0)
                            <tr>
                                <td colspan="2" class="text-center">Tidak Ada Riwayat Asessment</td>
                            </tr>
                        @endif
                        @foreach ($riwayats as $riwayat)
                            <tr>
                                <td
                                    style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                    {{ Carbon\Carbon::parse($riwayat->created_at)->format('d-m-Y H:i') }}
                                </td>
                                <td
                                    style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                    <a href="{{ URL::current() . '?asessment_id=' . $riwayat->id }}"
                                        class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <div class="col-md-12">
              <h4 style="text-align: center;"><b>ASESMEN PRA BEDAH</b></h4>
            </div>

            <div class="col-md-6">
              <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"style="font-size:12px;">
                <tbody>
                  <tr>
                    <td colspan="2" style="text-align: center;"><label for="">SUBJEKTIF</label></td>
                  </tr>
                  <tr>
                    <td colspan="2" style="width: 50%;"><label for="">Anamnesis</label></td>
                  </tr>
                  <tr>
                    <td colspan="2">
                      <textarea name="fisik[subjektif][anamnesis]" class="form-control" style="resize: vertical;" rows="5" placeholder="Anamnesis">{{ @$asessment['subjektif']['anamnesis'] }}</textarea>
                    </td>
                  </tr>

                  <tr>
                    <td colspan="2" style="text-align: center;"><label for="">OBJEKTIF</label></td>
                  </tr>
                  <tr>
                    <td style="font-weight: bold;">Kesadaran</td>
                    <td>
                      <input type="radio" id="kesadaran_1" name="fisik[objektif][kesadaran][pilihan]" value="Composmentis" {{ @$asessment['objektif']['kesadaran']['pilihan'] == 'Composmentis' ? 'checked' : '' }}>
                      <label for="kesadaran_1" style="font-weight: normal; margin-right: 10px;">Composmentis</label>
                      <input type="radio" id="kesadaran_2" name="fisik[objektif][kesadaran][pilihan]" value="Somnolent" {{ @$asessment['objektif']['kesadaran']['pilihan'] == 'Somnolent' ? 'checked' : '' }}>
                      <label for="kesadaran_2" style="font-weight: normal; margin-right: 10px;">Somnolent</label>
                      <input type="radio" id="kesadaran_3" name="fisik[objektif][kesadaran][pilihan]" value="Coma" {{ @$asessment['objektif']['kesadaran']['pilihan'] == 'Coma' ? 'checked' : '' }}>
                      <label for="kesadaran_3" style="font-weight: normal; margin-right: 10px;">Coma</label>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2" style="width: 50%;"><label for="">GCS</label></td>
                  </tr>
                  <tr>
                    <td><label for="">E</label></td>
                    <td>
                      <input type="text" class="form-control" name="fisik[objektif][gcs][E]" value="{{ @$asessment['objektif']['gcs']['E'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td><label for="">M</label></td>
                    <td>
                      <input type="text" class="form-control" name="fisik[objektif][gcs][M]" value="{{ @$asessment['objektif']['gcs']['M'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td><label for="">V</label></td>
                    <td>
                      <input type="text" class="form-control" name="fisik[objektif][gcs][V]" value="{{ @$asessment['objektif']['gcs']['V'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2" style="width: 50%;"><label for="">Pemeriksaan Fisik</label></td>
                  </tr>
                  <tr>
                    <td colspan="2">
                      <textarea name="fisik[objektif][pemeriksaanFisik]" class="form-control" style="resize: vertical;" rows="5" placeholder="Pemeriksaan Fisik">{{ @$asessment['objektif']['pemeriksaanFisik'] }}</textarea>
                    </td>
                  </tr>
                </tbody>
              </table>
              
            </div>
            
            <div class="col-md-6">
              <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"style="font-size:12px;">
                <tbody>
                  <tr>
                    <td colspan="2" style="width: 50%; text-align: center;"><label for="">ASESMEN</label></td>
                  </tr>
                  <tr>
                    <td colspan="2" style="width: 50%;"><label for="">Diagnosis</label></td>
                  </tr>
                  <tr>
                    <td colspan="2">
                      <textarea name="fisik[asesmen][diagnosis]" class="form-control" style="resize: vertical;" rows="5" placeholder="Diagnosis">{{ @$asessment['asesmen']['diagnosis'] }}</textarea>
                    </td>
                  </tr>

                  <tr>
                    <td colspan="2" style="width: 50%; text-align: center;"><label for="">PERENCANAAN</label></td>
                  </tr>
                  <tr>
                    <td colspan="2" style="width: 50%;"><label for="">Rencana Tindakan</label></td>
                  </tr>
                  <tr>
                    <td colspan="2">
                      <textarea name="fisik[perencanaan][rencanaTindakan]" class="form-control" style="resize: vertical;" rows="5" placeholder="Rencana Tindakan">{{ @$asessment['perencanaan']['rencanaTindakan'] }}</textarea>
                    </td>
                  </tr>
                  <tr>
                    <td><label for="">Sifat Tindakan</label></td>
                    <td>
                      <input type="radio" id="sifatTindakan_1" name="fisik[sifatTindakan][pilihan]" value="Cito" {{ @$asessment['sifatTindakan']['pilihan'] == 'Cito' ? 'checked' : '' }}>
                      <label for="sifatTindakan_1" style="font-weight: normal; margin-right: 10px;">Cito</label>
                      <input type="radio" id="sifatTindakan_2" name="fisik[sifatTindakan][pilihan]" value="Elektif" {{ @$asessment['sifatTindakan']['pilihan'] == 'Elektif' ? 'checked' : '' }}>
                      <label for="sifatTindakan_2" style="font-weight: normal; margin-right: 10px;">Elektif</label>
                    </td>
                  </tr>
                  <tr>
                    <td><label for="">Obat Pre Operatif</label></td>
                    <td>
                      <input type="radio" id="obatPreOperatif_1" name="fisik[obatPreOperatif][pilihan]" value="Tidak" {{ @$asessment['obatPreOperatif']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                      <label for="obatPreOperatif_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                      <input type="radio" id="obatPreOperatif_2" name="fisik[obatPreOperatif][pilihan]" value="Ya" {{ @$asessment['obatPreOperatif']['pilihan'] == 'Ya' ? 'checked' : '' }}>
                      <label for="obatPreOperatif_2" style="font-weight: normal; margin-right: 10px;">Ya</label>
                      <input type="radio" id="obatPreOperatif_1" name="fisik[obatPreOperatif][pilihan]" value="Antibiotik Profilaksis" {{ @$asessment['obatPreOperatif']['pilihan'] == 'Antibiotik Profilaksis' ? 'checked' : '' }}>
                      <label for="obatPreOperatif_1" style="font-weight: normal; margin-right: 10px;">Antibiotik Profilaksis</label>
                      <input type="radio" id="obatPreOperatif_2" name="fisik[obatPreOperatif][pilihan]" value="Lainnya" {{ @$asessment['obatPreOperatif']['pilihan'] == 'Lainnya' ? 'checked' : '' }}>
                      <label for="obatPreOperatif_2" style="font-weight: normal; margin-right: 10px;">Lainnya</label>

                      <input type="text" class="form-control" name="fisik[obatPreOperatif][lainnya]" value="{{ @$asessment['obatPreOperatif']['lainnya'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td><label for="">Persiapan Alat Khusus</label></td>
                    <td>
                      <textarea name="fisik[perencanaan][persiapanAlatKhusus]" class="form-control" style="resize: vertical;" rows="4">{{ @$asessment['perencanaan']['persiapanAlatKhusus'] }}</textarea>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="col-md-12 text-right">
              <button class="btn btn-success">Simpan</button>
            </div>
            
          </div>

        </div>

      </form>
    </div>

  </div>
@endsection

@section('script')
    <script type="text/javascript">
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
        $("#date_dengan_tanggal").attr('', true);
    </script>
@endsection
