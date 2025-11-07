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
    <h1>Fisik</h1>
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
      <form method="POST" action="{{ url('emr-soap/pemeriksaan/pra-anestesi/' . $unit . '/' . $reg->id) }}" class="form-horizontal">
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
                                <th class="text-center" style="vertical-align: middle;">Tanggal Input</th>
                                <th class="text-center" style="vertical-align: middle;">User</th>
                                <th class="text-center" style="vertical-align: middle;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($riwayats) == 0)
                                <tr>
                                    <td colspan="3" class="text-center">Tidak Ada Riwayat Asessment</td>
                                </tr>
                            @endif
                            @foreach ($riwayats as $riwayat)
                                <tr>
                                    <td
                                        style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                        {{ Carbon\Carbon::parse($riwayat->created_at)->format('d-m-Y H:i') }}
                                    </td>
                                    <td class="text-center">
                                        {{ baca_user(@$riwayat->user_id) }}
                                    </td>
                                    <td
                                        style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                        <a href="{{ URL::current() . '?asessment_id=' . $riwayat->id }}"
                                            class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a>
                                        {{-- <a href="{{ url("emr-soap-hapus-pemeriksaan/".$unit."/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin Akan Menghapus Data Ini ?')">
                                            <i class="fa fa-trash"></i>
                                        </a> --}}
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>


                </div>
                <h4 style="text-align: center;"><b>FORMULIR PEMERIKASAAN PRA ANESTASI/SEDASI</b></h4>

                <div class="col-md-12">
                    <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"style="font-size:12px;">
                        <tr>
                            <td style="width:30%; font-weight:bold;">Diagnosa</td>
                            <td>
                                <textarea class="form-control" id="" rows="3" style="width: 100%; resize: vertical;"
                                    name="fisik[praAnestesi][anamnesa][diagnosa]">{{ @$asessment['praAnestesi']['anamnesa']['diagnosa']}}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:30%; font-weight:bold;">Rencana Tindakan</td>
                            <td>
                                <textarea class="form-control" name="fisik[praAnestesi][anamnesa][rencanaTindakan]" id="" rows="3" style="width: 100%; resize: vertical;">{{ @$asessment['praAnestesi']['anamnesa']['rencanaTindakan']}}</textarea>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-6">
                    {{-- Subjective --}}
                    <table style="width: 100%"
                        class="table-striped table-bordered table-hover table-condensed form-box table"style="font-size:12px;">
                        <tr>
                            <td colspan="2" style="font-weight: 900; text-align:center; padding-top:10px;">
                                Subjective</td>
                        </tr>
                        <tr>
                            <td style="width:50%; font-weight:bold;">Riwayat Operasi</td>
                            <td>
                                <div style="display: flex; flex-flow: column">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][subjective][riwayatOperasi][ada]"
                                            type="radio" value="false" id="flexCheckDefault" {{ @$asessment['praAnestesi']['subjective']['riwayatOperasi']['ada'] == 'false' ? 'checked' : '' }}>
                                        <label for="">Tidak</label>
                                    </div>
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][subjective][riwayatOperasi][ada]"
                                            type="radio" value="true"  {{ @$asessment['praAnestesi']['subjective']['riwayatOperasi']['ada'] == 'true' ? 'checked' : '' }} >
                                        <label for="">YA</label>
                                        <input type="text" class="form-control" placeholder="Penyakit yang pernah diderita"
                                            style=""
                                            name="fisik[praAnestesi][subjective][riwayatOperasi][penyakit]"
                                            value="{{ @$asessment['praAnestesi']['subjective']['riwayatOperasi']['penyakit']  }}">
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:50%; font-weight:bold;">Asma</td>
                            <td>
                                <div style="display: flex; flex-flow: column">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][subjective][asma][ada]" type="radio"
                                            value="false" id="flexCheckDefault" {{ @$asessment['praAnestesi']['subjective']['asma']['ada'] == 'false' ? 'checked' : '' }}>
                                        <label for="">Tidak</label>
                                    </div>
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][subjective][asma][ada]" type="radio"
                                            value="true" id="flexCheckDefault" {{ @$asessment['praAnestesi']['subjective']['asma']['ada'] == 'true' ? 'checked' : '' }}>
                                        <label for="">YA</label>
                                        <input type="text" class="form-control" placeholder="Pengobatan"
                                            style=""
                                            name="fisik[praAnestesi][subjective][asma][pengobatan]" value="{{ @$asessment['praAnestesi']['subjective']['asma']['pengobatan']}}">
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>
                
                        <tr>
                            <td style="width:50%; font-weight:bold;">Alergi</td>
                            <td>
                                <div style="display: flex; flex-flow: column">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][subjective][alergi][ada]" type="radio"
                                            value="false" {{ @$asessment['praAnestesi']['subjective']['alergi']['ada'] == 'false' ? 'checked' : '' }}>
                                        <label for="">Tidak</label>
                                    </div>
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][subjective][alergi][ada]" type="radio"
                                            value="true" {{ @$asessment['praAnestesi']['subjective']['alergi']['ada'] == 'true' ? 'checked' : '' }} >
                                        <label for="">YA</label>
                                        <input type="text" class="form-control" placeholder="Alergi terhadap"
                                            style=""
                                            name="fisik[praAnestesi][subjective][alergi][keterangan]"
                                            value="{{ @$asessment['praAnestesi']['subjective']['asma']['keterangan'] }}">
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:50%; font-weight:bold;">Hipertensi</td>
                            <td>
                                <div style="display: flex; flex-flow: column">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][subjective][hipertensi][ada]"
                                            type="radio" value="false" {{ @$asessment['praAnestesi']['subjective']['hipertensi']['ada'] == 'false' ? 'checked' : '' }}>
                                        <label for="">Tidak</label>
                                    </div>
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][subjective][hipertensi][ada]"
                                            type="radio" value="true" {{ @$asessment['praAnestesi']['subjective']['hipertensi']['ada'] == 'true' ? 'checked' : '' }}>
                                        <label for="">YA</label>
                                        <input type="text" class="form-control" placeholder="Pengobatan"
                                            style=""
                                            name="fisik[praAnestesi][subjective][hipertensi][pengobatan]"
                                            value="{{ @$asessment['praAnestesi']['subjective']['hipertensi']['pengobatan'] }}">
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:50%; font-weight:bold;">Merokok</td>
                            <td>
                                <div style="display: flex; flex-flow: column">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][subjective][merokok][ada]" type="radio"
                                            value="false"  {{ @$asessment['praAnestesi']['subjective']['merokok']['ada'] == 'false' ? 'checked' : '' }}>
                                        <label for="">Tidak</label>
                                    </div>
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][subjective][merokok][ada]" type="radio"
                                            value="true"  {{ @$asessment['praAnestesi']['subjective']['merokok']['ada'] == 'true' ? 'checked' : '' }}>
                                        <label for="">YA</label>
                                        <input type="text" class="form-control" placeholder="Terakhir kali merokok"
                                            style=""
                                            name="fisik[praAnestesi][subjective][merokok][terakhirMerokok]"
                                            value="{{ @$asessment['praAnestesi']['subjective']['merokok']['terakhirMerokok']}}">
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:50%; font-weight:bold;">Gastritis</td>
                            <td>
                                <div style="display: flex; flex-flow: column">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][subjective][gastritis][ada]" type="radio"
                                            value="false" {{ @$asessment['praAnestesi']['subjective']['gastritis']['ada'] == 'false' ? 'checked' : '' }}>
                                        <label for="">Tidak</label>
                                    </div>
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][subjective][gastritis][ada]" type="radio"
                                            value="true" {{ @$asessment['praAnestesi']['subjective']['gastritis']['ada'] == 'true' ? 'checked' : '' }}>
                                        <label for="">YA</label>
                                        <input type="text" class="form-control" placeholder="Pengobatan"
                                            style=""
                                            name="fisik[praAnestesi][subjective][gastritis][pengobatan]"
                                            value="{{ @$asessment['praAnestesi']['subjective']['gastritis']['pengobatan']}}">
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>
                
                        <tr>
                            <td style="width:50%; font-weight:bold;">Diabetes</td>
                            <td>
                                <div style="display: flex; flex-flow: column">
                                <div>
                                    <input class="form-check-input"
                                        name="fisik[praAnestesi][subjective][diabetes][ada]" type="radio"
                                        value="false" {{ @$asessment['praAnestesi']['subjective']['diabetes']['ada'] == 'false' ? 'checked' : '' }}>
                                    <label for="">Tidak</label>
                                </div>
                                <div style="width:100%;">
                                    <input class="form-check-input"
                                        name="fisik[praAnestesi][subjective][diabetes][ada]" type="radio"
                                        value="true" {{ @$asessment['praAnestesi']['subjective']['diabetes']['ada'] == 'true' ? 'checked' : '' }}>
                                    <label for="">YA</label>
                                    <input type="text" class="form-control" placeholder="Pengobatan"
                                            style=""
                                            name="fisik[praAnestesi][subjective][diabetes][pengobatan]"
                                            value="{{ @$asessment['praAnestesi']['subjective']['diabetes']['pengobatan'] }}">
                                </div>
                                    
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:50%; font-weight:bold;">Obat yang sedang didapat</td>
                            <td>
                                <textarea class="form-control" name="fisik[praAnestesi][subjective][obatOnGoing]" id="" rows="3" style="width: 100%; resize: vertical;">{{ @$asessment['praAnestesi']['subjective']['obatOnGoing']}}</textarea>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:50%; font-weight:bold;">Angina</td>
                            <td>
                                <div style="display: flex; flex-flow: column">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][subjective][angina][ada]" type="radio"
                                            value="false" {{ @$asessment['praAnestesi']['subjective']['angina']['ada'] == 'false' ? 'checked' : '' }}>
                                        <label for="">Tidak</label>
                                    </div>
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][subjective][angina][ada]" type="radio"
                                            value="true" {{ @$asessment['praAnestesi']['subjective']['angina']['ada'] == 'true' ? 'checked' : '' }}>
                                        <label for="">YA</label>
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>
                
                        <tr>
                            <td style="width:50%; font-weight:bold;">Kejang</td>
                            <td>
                                <div style="display: flex; flex-flow: column">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][subjective][kejang][ada]" type="radio"
                                            value="false" {{ @$asessment['praAnestesi']['subjective']['kejang']['ada'] == 'false' ? 'checked' : '' }}>
                                        <label for="">Tidak</label>
                                    </div>
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][subjective][kejang][ada]" type="radio"
                                            value="true" {{ @$asessment['praAnestesi']['subjective']['kejang']['ada'] == 'true' ? 'checked' : '' }}>
                                        <label for="">YA</label>
                                        
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>
                
                        
                
                        
                
                        
                
                        
                
                        <tr>
                            <td style="width:50%; font-weight:bold;">Lain-lain</td>
                            <td>
                                <textarea class="form-control" name="fisik[praAnestesi][subjective][lain-lain]" id="" rows="3" style="width: 100%; resize: vertical;">{{ @$asessment['praAnestesi']['anamnesa']['lain-lain']}}</textarea>
                            </td>
                        </tr>
                
                
                    </table>
                    {{-- End Subjective --}}
              
                    {{-- Objective --}}
                    <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table" style="font-size:12px;">
                        <tr>
                            <td colspan="3" style="font-weight: 900; text-align:center; padding-top:10px;">
                                Objective</td>
                        </tr>

                        <tr>
                            <td style="width:50%; font-weight:bold;"> Kesadaran</td>
                            <td colspan="2"> 
                                <div style="width:100%;">
                                    <input class="form-check-input"
                                        name="fisik[praAnestesi][objective][kesadaran]" type="radio"
                                        value="CM" {{ @$asessment['praAnestesi']['objective']['kesadaran'] == 'CM' ? 'checked' : '' }}>
                                    <label for="">CM</label>
                                </div>
                                <div>
                                    <input class="form-check-input"
                                        name="fisik[praAnestesi][objective][kesadaran]" type="radio"
                                        value="Apatis" id="flexCheckDefault" {{ @$asessment['praAnestesi']['objective']['kesadaran'] == 'Apatis' ? 'checked' : '' }}>
                                    <label for="">Apatis</label>
                                </div>
                                <div>
                                    <input class="form-check-input"
                                        name="fisik[praAnestesi][objective][kesadaran]" type="radio"
                                        value="Somnolen" id="flexCheckDefault" {{ @$asessment['praAnestesi']['objective']['kesadaran'] == 'Somnolen' ? 'checked' : '' }}>
                                    <label for="">Somnolen</label>
                                </div>
                                <div>
                                    <input class="form-check-input"
                                        name="fisik[praAnestesi][objective][kesadaran]" type="radio"
                                        value="Soporous" {{ @$asessment['praAnestesi']['objective']['kesadaran'] == 'Soporous' ? 'checked' : '' }}>
                                    <label for="">Soporous</label>
                                </div>
                                <div>
                                    <input class="form-check-input"
                                        name="fisik[praAnestesi][objective][kesadaran]" type="radio"
                                        value="Coma" {{ @$asessment['praAnestesi']['objective']['kesadaran'] == 'Coma' ? 'checked' : '' }}>
                                    <label for="">Coma</label>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="3" style="">
                              <label style="margin-right: 10px;">GCS</label> 
                              <label class="form-check-label" style="">E</label>
                              <input type="text" name="fisik[praAnestesi][objective][GCS][E]" style="display:inline-block; width: 100px; margin-right: 10px;" placeholder="E" class="form-control" id="" value="{{ @$assesment['praAnestesi']['objective']['GCS']['E'] }}">
                              <label class="form-check-label" style="">M</label>
                              <input type="text" name="fisik[praAnestesi][objective][GCS][M]" style="display:inline-block; width: 100px; margin-right: 10px;" placeholder="M" class="form-control" id="" value="{{ @$assesment['praAnestesi']['objective']['GCS']['M'] }}">
                              <label class="form-check-label" style="">V</label>
                              <input type="text" name="fisik[praAnestesi][objective][GCS][V]" style="display:inline-block; width: 100px; margin-right: 10px;" placeholder="V" class="form-control" id="" value="{{ @$assesment['praAnestesi']['objective']['GCS']['V'] }}">
                            </td>
                        </tr>
                        <tr>
                            <td style="width:50%; font-weight:bold;">Tinggi Badan</td>
                            <td>
                                <input style="width: 100%" type="number"
                                    name="fisik[praAnestesi][objective][tinggiBadan]"
                                    value="{{ @$asessment['praAnestesi']['objective']['tinggiBadan'] }}">
                            </td>
                            <td> cm </td>
                        </tr>
                        <tr>
                            <td style="width:50%; font-weight:bold;">Berat Badan</td>
                            <td>
                                <input style="width: 100%" type="number"
                                    name="fisik[praAnestesi][objective][beratBadan]"
                                    value="{{ @$asessment['praAnestesi']['objective']['beratBadan'] }}">
                            </td>
                            <td>Kg</td>
                        </tr>
        

                        <tr>
                            <td colspan="3" style="width:50%; font-weight:bold;"> 
                                Tanda Vital
                            </td>
                        </tr>
                        <tr>
                            <td style="width:50%; font-weight:bold;"> Tekanan Darah </td>
                            <td>
                                <div class="btn-group" role="group" style="display: flex;">
                                    <input style="width: 100%" type="text"
                                        name="fisik[praAnestesi][objective][tandaVital][tekananDarah][sistolik]"
                                        value="{{ @$asessment['praAnestesi']['objective']['tandaVital']['tekananDarah']['sistolik'] }}" placeholder="sistolik">
                                    <button type="button" class="">/</button>
                                    <input style="width: 100%" type="text"
                                        name="fisik[praAnestesi][objective][tandaVital][tekananDarah][diastolik]"
                                        value="{{ @$asessment['praAnestesi']['objective']['tandaVital']['tekananDarah']['diastolik'] }}" placeholder="diastolik">
                                  </div>
                            </td>
                            <td> mmHg </td>
                        </tr>
                        <tr>
                            <td style="width:50%; font-weight:bold;">Nadi</td>
                            <td> <input style="width: 100%" type="number"
                                    name="fisik[praAnestesi][objective][tandaVital][nadi]"
                                    value="{{ @$asessment['praAnestesi']['objective']['tandaVital']['nadi'] }}">
                            </td>
                            <td> x/menit </td>
                        </tr>
                        <tr>
                            <td style="width:50%; font-weight:bold;">Respirasi</td>
                            <td> <input style="width: 100%" type="number"
                                    name="fisik[praAnestesi][objective][tandaVital][respirasi]"
                                    value="{{ @$asessment['praAnestesi']['objective']['tandaVital']['respirasi'] }}">
                            </td>
                            <td> x/menit </td>
                        </tr>
                        <tr>
                            <td style="width:50%; font-weight:bold;"> Suhu </td>
                            <td> <input style="width: 100%" type="number"
                                    name="fisik[praAnestesi][objective][tandaVital][suhu]"
                                    value="{{ @$asessment['praAnestesi']['objective']['tandaVital']['suhu'] }}">
                            </td>
                            <td> oC </td>
                        </tr>
                        <tr>
                            <td style="width:50%; font-weight:bold;"> Skor Nyeri </td>
                            <td colspan="2"> <input style="width: 100%" type="number"
                                    name="fisik[praAnestesi][objective][tandaVital][skorNyeri]"
                                    value="{{ @$asessment['praAnestesi']['objective']['tandaVital']['skorNyeri'] }}">
                            </td>
                        </tr>

                        <tr>
                            <td style="width:50%; font-weight:bold;">Jalan Nafas: mallampati skor</td>
                            <td colspan="2">
                                <div style="display: flex; flex-flow: row">
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][objective][jalanNafas]"
                                            type="radio" value="1"  {{ @$asessment['praAnestesi']['objective']['jalanNafas'] == '1' ? 'checked' : '' }} >
                                        <label for="">1</label>
                                    </div>
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][objective][jalanNafas]"
                                            type="radio" value="2"  {{ @$asessment['praAnestesi']['objective']['jalanNafas'] == '2' ? 'checked' : '' }} >
                                        <label for="">2</label>
                                    </div>
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][objective][jalanNafas]"
                                            type="radio" value="3"  {{ @$asessment['praAnestesi']['objective']['jalanNafas'] == '3' ? 'checked' : '' }} >
                                        <label for="">3</label>
                                    </div>
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][objective][jalanNafas]"
                                            type="radio" value="4"  {{ @$asessment['praAnestesi']['objective']['jalanNafas'] == '4' ? 'checked' : '' }} >
                                        <label for="">4</label>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:50%; font-weight:bold;">Gigi</td>
                            <td colspan="2">
                                <div style="display: flex; flex-flow: column">
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][objective][gigi][0]"
                                            type="checkbox" value="komplit"  {{ @$asessment['praAnestesi']['objective']['gigi'][0] == 'komplit' ? 'checked' : '' }} >
                                        <label for="">Komplit</label>
                                    </div>
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][objective][gigi][1]"
                                            type="checkbox" value="tidak komplit"  {{ @$asessment['praAnestesi']['objective']['gigi'][1] == 'tidak komplit' ? 'checked' : '' }} >
                                        <label for="">Tidak Komplit</label>
                                    </div>
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][objective][gigi][2]"
                                            type="checkbox" value="goyang"  {{ @$asessment['praAnestesi']['objective']['gigi'][2] == 'goyang' ? 'checked' : '' }} >
                                        <label for="">Goyang</label>
                                    </div>
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][objective][gigi][3]"
                                            type="checkbox" value="palsu"  {{ @$asessment['praAnestesi']['objective']['gigi'][3] == 'palsu' ? 'checked' : '' }} >
                                        <label for="">Palsu</label>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:50%; font-weight:bold;">Leher</td>
                            <td colspan="2">
                                <div style="display: flex; flex-flow: column">
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][objective][leher]"
                                            type="radio" value="Mobile"  {{ @$asessment['praAnestesi']['objective']['leher'] == 'Mobile' ? 'checked' : '' }} >
                                        <label for="">Mobile</label>
                                    </div>
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][objective][leher]"
                                            type="radio" value="Terbatas"  {{ @$asessment['praAnestesi']['objective']['leher'] == 'Terbatas' ? 'checked' : '' }} >
                                        <label for="">Terbatas</label>
                                    </div>
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][objective][leher]"
                                            type="radio" value="Trauma"  {{ @$asessment['praAnestesi']['objective']['leher'] == 'Trauma' ? 'checked' : '' }} >
                                        <label for="">Trauma</label>
                                    </div>
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][objective][leher]"
                                            type="radio" value="TMD"  {{ @$asessment['praAnestesi']['objective']['leher'] == 'TMD' ? 'checked' : '' }} >
                                        <label for="">TMD (Thyromental Distance)</label>
                                        <div style="margin-left: 1.5rem;">
                                            <input class="form-check-input"
                                                name="fisik[praAnestesi][objective][leher_tmd]"
                                                type="radio" value="> 6 cm"  {{ @$asessment['praAnestesi']['objective']['leher_tmd'] == '> 6 cm' ? 'checked' : '' }} >
                                                <label for="" style="font-weight: normal">> 6 cm</label>
                                            <input class="form-check-input"
                                                name="fisik[praAnestesi][objective][leher_tmd]"
                                                type="radio" value="< 6 cm"  {{ @$asessment['praAnestesi']['objective']['leher_tmd'] == '< 6 cm' ? 'checked' : '' }} >
                                                <label for="" style="font-weight: normal">< 6 cm</label>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:50%; font-weight:bold;">Paru</td>
                            <td colspan="2">
                                <div>
                                    <input class="form-check-input"
                                                name="fisik[praAnestesi][objective][paru]"
                                                type="radio" value="Dalam Batas Normal"  {{ @$asessment['praAnestesi']['objective']['paru'] == 'Dalam Batas Normal' ? 'checked' : '' }} >
                                            <label for="">Dalam Batas Normal</label>
                                </div>
                                <div>
                                    <input class="form-check-input"
                                                name="fisik[praAnestesi][objective][paru]"
                                                type="radio" value="Lainnya"  {{ @$asessment['praAnestesi']['objective']['paru'] == 'Lainnya' ? 'checked' : '' }} >
                                            <label for="">Lainnya</label>
                                </div>
                                <textarea class="form-control" name="fisik[praAnestesi][objective][paru_lainnya]" placeholder="Isi jika Lainnya" id="" rows="2" style="width: 100%; resize: vertical;">{{ @$asessment['praAnestesi']['objective']['paru_lainnya']}}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:50%; font-weight:bold;">Jantung</td>
                            <td colspan="2">
                                <div>
                                    <input class="form-check-input"
                                                name="fisik[praAnestesi][objective][jantung]"
                                                type="radio" value="Dalam Batas Normal"  {{ @$asessment['praAnestesi']['objective']['jantung'] == 'Dalam Batas Normal' ? 'checked' : '' }} >
                                            <label for="">Dalam Batas Normal</label>
                                </div>
                                <div>
                                    <input class="form-check-input"
                                                name="fisik[praAnestesi][objective][jantung]"
                                                type="radio" value="Lainnya"  {{ @$asessment['praAnestesi']['objective']['jantung'] == 'Lainnya' ? 'checked' : '' }} >
                                            <label for="">Lainnya</label>
                                </div>
                                <textarea class="form-control" name="fisik[praAnestesi][objective][jantung_lainnya]" placeholder="Isi jika Lainnya" id="" rows="2" style="width: 100%; resize: vertical;">{{ @$asessment['praAnestesi']['objective']['jantung_lainnya']}}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:50%; font-weight:bold;">Abdomen</td>
                            <td colspan="2">
                                <div>
                                    <input class="form-check-input"
                                                name="fisik[praAnestesi][objective][abdomen]"
                                                type="radio" value="Dalam Batas Normal"  {{ @$asessment['praAnestesi']['objective']['abdomen'] == 'Dalam Batas Normal' ? 'checked' : '' }} >
                                            <label for="">Dalam Batas Normal</label>
                                </div>
                                <div>
                                    <input class="form-check-input"
                                                name="fisik[praAnestesi][objective][abdomen]"
                                                type="radio" value="Lainnya"  {{ @$asessment['praAnestesi']['objective']['abdomen'] == 'Lainnya' ? 'checked' : '' }} >
                                            <label for="">Lainnya</label>
                                </div>
                                <textarea class="form-control" name="fisik[praAnestesi][objective][abdomen_lainnya]" placeholder="Isi jika Lainnya" id="" rows="2" style="width: 100%; resize: vertical;">{{ @$asessment['praAnestesi']['objective']['abdomen_lainnya']}}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:50%; font-weight:bold;">Ekstremitas</td>
                            <td colspan="2">
                                <div>
                                    <input class="form-check-input"
                                                name="fisik[praAnestesi][objective][ekstremitas]"
                                                type="radio" value="Dalam Batas Normal"  {{ @$asessment['praAnestesi']['objective']['ekstremitas'] == 'Dalam Batas Normal' ? 'checked' : '' }} >
                                            <label for="">Dalam Batas Normal</label>
                                </div>
                                <div>
                                    <input class="form-check-input"
                                                name="fisik[praAnestesi][objective][ekstremitas]"
                                                type="radio" value="Lainnya"  {{ @$asessment['praAnestesi']['objective']['ekstremitas'] == 'Lainnya' ? 'checked' : '' }} >
                                            <label for="">Lainnya</label>
                                </div>
                                <textarea class="form-control" name="fisik[praAnestesi][objective][ekstremitas_lainnya]" placeholder="Isi jika Lainnya" id="" rows="2" style="width: 100%; resize: vertical;">{{ @$asessment['praAnestesi']['objective']['ekstremitas_lainnya']}}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:50%; font-weight:bold;">Lain-lain</td>
                            <td colspan="2">
                                <textarea class="form-control" name="fisik[praAnestesi][objective][dll]" id="" rows="2" style="width: 100%; resize: vertical;">{{ @$asessment['praAnestesi']['objective']['dll']}}</textarea>
                            </td>
                        </tr>
                        
                    </table>

                    <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"style="font-size:12px;">
                        <tr>
                            <td colspan="2" style="font-weight: bold;">
                                Pemeriksaan Penunjang
                            </td>
                        </tr>
                        <tr>
                            <td style="width:50%; font-weight:bold;">Laboratorium</td>
                            <td>
                                <textarea class="form-control" style="width: 100%" name="fisik[praAnestesi][objective][penunjang][laboratorium]" rows="15">@if (!empty(@$asessment['praAnestesi']['objective']['penunjang']['laboratorium'])){{@$asessment['praAnestesi']['objective']['penunjang']['laboratorium']}}@else @foreach ($laboratorium as $lab)- {{$lab->namatarif}}&#13;@endforeach @endif </textarea>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:50%; font-weight:bold;">EKG</td>
                            <td>
                                <input type="text" class="form-control" style="width: 100%" name="fisik[praAnestesi][objective][penunjang][ekg]"  value="{{ @$asessment['praAnestesi']['objective']['penunjang']['ekg']}}">
                            </td>
                        </tr>
                        <tr>
                            <td style="width:50%; font-weight:bold;">Rontgen</td>
                            <td>
                                <input type="text" class="form-control" style="width: 100%" name="fisik[praAnestesi][objective][penunjang][rontgen]"  value="{{ @$asessment['praAnestesi']['objective']['penunjang']['rontgen']}}">
                            </td>
                        </tr>
                        <tr>
                            <td style="width:50%; font-weight:bold;">Lain-Lain</td>
                            <td>
                                <input type="text" class="form-control" style="width: 100%" name="fisik[praAnestesi][objective][penunjang][dll]"  value="{{ @$asessment['praAnestesi']['objective']['penunjang']['dll']}}">
                            </td>
                        </tr>
                        <tr>
                            <td style="width:50%; font-weight:bold;">Hasil Konsultasi Bagian Lain</td>
                            <td>
                                <textarea class="form-control" name="fisik[praAnestesi][objective][penunjang][konsul]" id="" rows="2" style="width: 100%; resize: vertical;">{{ @$asessment['praAnestesi']['objective']['penunjang']['konsul']}}</textarea>
                            </td>
                        </tr>
                    </table>
                    {{-- End Objective --}}
              
                  
                  
              
                  
              
                  
              
                </div>

                <div class="col-md-6">
                    {{-- Asesmen --}}
                    <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"style="font-size:12px;">
                        <tr>
                            <td colspan="2" style="font-weight: 900; text-align:center; padding-top:10px;">
                                Asesmen
                            </td>
                        </tr>
                        <tr>
                            <td style="width:50%; font-weight:bold;">Skala Nyeri Vas Scale</td>
                            <td>
                                <div style="display: flex; flex-flow: row">
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][asesmen][vas_scale]"
                                            type="radio" value="1"  {{ @$asessment['praAnestesi']['asesmen']['vas_scale'] == '1' ? 'checked' : '' }} >
                                        <label for="">1</label>
                                    </div>
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][asesmen][vas_scale]"
                                            type="radio" value="2"  {{ @$asessment['praAnestesi']['asesmen']['vas_scale'] == '2' ? 'checked' : '' }} >
                                        <label for="">2</label>
                                    </div>
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][asesmen][vas_scale]"
                                            type="radio" value="3"  {{ @$asessment['praAnestesi']['asesmen']['vas_scale'] == '3' ? 'checked' : '' }} >
                                        <label for="">3</label>
                                    </div>
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][asesmen][vas_scale]"
                                            type="radio" value="4"  {{ @$asessment['praAnestesi']['asesmen']['vas_scale'] == '4' ? 'checked' : '' }} >
                                        <label for="">4</label>
                                    </div>
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][asesmen][vas_scale]"
                                            type="radio" value="5"  {{ @$asessment['praAnestesi']['asesmen']['vas_scale'] == '5' ? 'checked' : '' }} >
                                        <label for="">5</label>
                                    </div>
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][asesmen][vas_scale]"
                                            type="radio" value="E"  {{ @$asessment['praAnestesi']['asesmen']['vas_scale'] == 'E' ? 'checked' : '' }} >
                                        <label for="">E</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                
                    </table>
                    {{-- End Asesmen --}}

                    {{-- Planning --}}
                    <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"style="font-size:12px;">
                        <tr>
                            <td colspan="2" style="font-weight: 900; text-align:center; padding-top:10px;">
                                Planning
                            </td>
                        </tr>
                        <tr>
                            <td style="width:50%; font-weight:bold;"> Persetujuan Tindakan Anestesi / Sedasi</td>
                            <td>
                                <div style="display: flex; flex-flow: row">
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][planning][persetujuan]"
                                            type="radio" value="Setuju"  {{ @$asessment['praAnestesi']['planning']['persetujuan'] == 'Setuju' ? 'checked' : '' }} >
                                        <label for="">Setuju</label>
                                    </div>
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][planning][persetujuan]"
                                            type="radio" value="Tidak Setuju"  {{ @$asessment['praAnestesi']['planning']['persetujuan'] == 'Tidak Setuju' ? 'checked' : '' }} >
                                        <label for="">Tidak Setuju</label>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" style="font-weight: bold;">
                                Preoperatif
                            </td>
                        </tr>
                        <tr>
                            <td style="width:50%; font-weight:bold;">Puasa Mulai Jam</td>
                            <td>
                                <input class="form-control" type="text" name="fisik[praAnestesi][planning][preOperatif][puasa]" style="width: 100%" value="{{ @$asessment['praAnestesi']['planning']['preOperatif']['puasa']}}"/>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:50%; font-weight:bold;">Premedikasi</td>
                            <td>
                                <input class="form-control" type="text" name="fisik[praAnestesi][planning][preOperatif][preMedikasi]" style="width: 100%" value="{{ @$asessment['praAnestesi']['planning']['preOperatif']['preMedikasi']}}"/>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:50%; font-weight:bold;">Lain-Lain</td>
                            <td>
                                <textarea class="form-control" rows="3" name="fisik[praAnestesi][planning][lainLain]" style="width: 100%; resize: vertical;">{{ @$asessment['praAnestesi']['planning']['lainLain'] }}</textarea>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" style="font-weight: bold;">
                                Intraoperatif
                            </td>
                        </tr>
                        <tr>
                            <td style="width:50%; font-weight:bold;">Jenis Anestesi</td>
                            <td>
                                <div style="display: flex; flex-flow: column">
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][planning][intraOperatif][jenisAnestesi]"
                                            type="radio" value="Umum"  {{ @$asessment['praAnestesi']['planning']['intraOperatif']['jenisAnestesi'] == 'Umum' ? 'checked' : '' }} >
                                        <label for="">Umum</label>
                                    </div>
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][planning][intraOperatif][jenisAnestesi]"
                                            type="radio" value="Regional"  {{ @$asessment['praAnestesi']['planning']['intraOperatif']['jenisAnestesi'] == 'Regional' ? 'checked' : '' }} >
                                        <label for="">Regional</label>
                                    </div>
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][planning][intraOperatif][jenisAnestesi]"
                                            type="radio" value="Kombinasi"  {{ @$asessment['praAnestesi']['planning']['intraOperatif']['jenisAnestesi'] == 'Kombinasi' ? 'checked' : '' }} >
                                        <label for="">Kombinasi</label>
                                    </div>
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][planning][intraOperatif][jenisAnestesi]"
                                            type="radio" value="Sedasi"  {{ @$asessment['praAnestesi']['planning']['intraOperatif']['jenisAnestesi'] == 'Sedasi' ? 'checked' : '' }} >
                                        <label for="">Sedasi</label>
                                    </div>
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][planning][intraOperatif][jenisAnestesi]"
                                            type="radio" value="MAC"  {{ @$asessment['praAnestesi']['planning']['intraOperatif']['jenisAnestesi'] == 'MAC' ? 'checked' : '' }} >
                                        <label for="">MAC</label>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" style="font-weight: bold;">
                                Postoperatif
                            </td>
                        </tr>
                        <tr>
                            <td style="width:50%; font-weight:bold;">Rencana penanganan nyeri</td>
                            <td>
                                <textarea class="form-control" name="fisik[praAnestesi][planning][postOperatif][penangananNyeri]" rows="2" style="width: 100%">{{ @$asessment['praAnestesi']['planning']['postOperatif']['penangananNyeri']}}</textarea>
                            </td>
                        </tr>
                        
                        <tr>
                            <td style="width:50%; font-weight:bold;">Perawatan pasca operatif</td>
                            <td>
                                <textarea class="form-control" name="fisik[praAnestesi][planning][postOperatif][perawatan]" rows="2" style="width: 100%">{{ @$asessment['praAnestesi']['planning']['postOperatif']['perawatan']}}</textarea>
                            </td>
                        </tr>
                  
                        <tr>
                            <td style="width:50%; font-weight:bold;">Surat Ijin Anestesi</td>
                            <td>
                                <div style="display: flex; flex-flow: column">
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][planning][suratIzinAnestesi]"
                                            type="radio" value="Tidak"  {{ @$asessment['praAnestesi']['planning']['suratIzinAnestesi'] == 'Tidak' ? 'checked' : '' }} >
                                        <label for="">Tidak</label>
                                    </div>
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][planning][suratIzinAnestesi]"
                                            type="radio" value="Ya"  {{ @$asessment['praAnestesi']['planning']['suratIzinAnestesi'] == 'Ya' ? 'checked' : '' }} >
                                        <label for="">Ya</label>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:50%; font-weight:bold;">Edukasi</td>
                            <td>
                                <div style="display: flex; flex-flow: column">
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][planning][edukasi]"
                                            type="radio" value="Tidak"  {{ @$asessment['praAnestesi']['planning']['edukasi'] == 'Tidak' ? 'checked' : '' }} >
                                        <label for="">Tidak</label>
                                    </div>
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][planning][edukasi]"
                                            type="radio" value="Ya"  {{ @$asessment['praAnestesi']['planning']['edukasi'] == 'Ya' ? 'checked' : '' }} >
                                        <label for="">Ya</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:50%; font-weight:bold;">Produk Darah bila diperlukan</td>
                            <td>
                                <div style="display: flex; flex-flow: column">
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][planning][produkDarah][pilihan]"
                                            type="radio" value="Tidak"  {{ @$asessment['praAnestesi']['planning']['produkDarah']['pilihan'] == 'Tidak' ? 'checked' : '' }} >
                                        <label for="">Tidak</label>
                                    </div>
                                    <div style="width:100%;">
                                        <input class="form-check-input"
                                            name="fisik[praAnestesi][planning][produkDarah][pilihan]"
                                            type="radio" value="Ya"  {{ @$asessment['praAnestesi']['planning']['produkDarah']['pilihan'] == 'Ya' ? 'checked' : '' }} >
                                        <label for="">Ya</label>
                                        <input type="text" class="form-control" name="fisik[praAnestesi][planning][produkDarah][penjelasan]" value="{{ @$asessment['praAnestesi']['planning']['produkDarah']['penjelasan'] }}" id="">
                                    </div>
                                </div>
                            </td>
                        </tr>
                  
                      </table>
                    {{-- End Planning --}}


                </div>
                <div class="col-md-6 text-right">
                    <button class="btn btn-success">Simpan</button>
                </div>

                <br /><br />
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
