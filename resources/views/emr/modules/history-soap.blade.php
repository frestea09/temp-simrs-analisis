{{-- @extends('master')

@section('header')
  <h1>SOAP</h1>
@endsection --}}

<style>
  body {font-family: Arial, Helvetica, sans-serif;}
  
  #myImg {
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
  }

  .summ:focus {
      background-color: green !important;
    }
  
  #myImg:hover {opacity: 0.7;}
  
  /* The Modal (background) */
  .modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
  }
  
  /* Modal Content (image) */
  .modal-content {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
  }
  
  /* Caption of Modal Image */
  #caption {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    text-align: center;
    color: #ccc;
    padding: 10px 0;
    height: 150px;
  }
  
  /* Add Animation */
  .modal-content, #caption {  
    -webkit-animation-name: zoom;
    -webkit-animation-duration: 0.6s;
    animation-name: zoom;
    animation-duration: 0.6s;
  }
  
  @-webkit-keyframes zoom {
    from {-webkit-transform:scale(0)} 
    to {-webkit-transform:scale(1)}
  }
  
  @keyframes zoom {
    from {transform:scale(0)} 
    to {transform:scale(1)}
  }
  
  /* The Close Button */
  .close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
  }
  
  .close:hover,
  .close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
  }
  
  /* 100% Image Width on Smaller Screens */
  @media only screen and (max-width: 700px){
    .modal-content {
      width: 100%;
    }
  }
  </style>








<style>
  .new{
    background-color:#e4ffe4;
  }
</style>
{{-- @section('content') --}}
 {{-- List soap --}}
 <div class="col-md-6">  
  <div class="table-responsive" style="max-height: 550px !important;border:1px solid blue">
    <table class="table table-bordered" id="data" style="font-size: 12px;">
         
        <tbody>
          @if (count($all_resume) == 0)
              <tr>
                <td>Tidak ada record</td>
              </tr>
          @endif
          <tr>
            <th>
              <button type="button" id="historiSoap" data-pasienID="{{ $reg->pasien_id }}"
                class="btn btn-info btn-sm btn-flat">
                <i class="fa fa-th-list"></i> HISTORY BARU
              </button>
              <button type="button" id="historiAsesmen" data-regID="{{ $reg->id }}"
                class="btn btn-warning btn-sm btn-flat">
                <i class="fa fa-th-list"></i> HISTORY ASESMEN
              </button>
              
            </th>
          </tr>
            @foreach( $all_resume as $key_a => $val_a )
                @php
                  $id_ss = @json_decode(@$val_a->id_observation_ss);
                  @$dpjp = $reg->dokter_id;
                  @$poli = $reg->poli_id;

                  $background = "transparent";

                  if (@$val_a->unit == 'farmasi') {
                    $background = "#e4dd7b";
                  } elseif (@$val_a->unit == 'gizi') {
                    $background = "#D8BFD8";
                  } else {
                    if (@$val_a->user->Pegawai->kategori_pegawai == 1) {
                      $background = "#ABF7B1";
                    } else {
                      $background = "#F8C9C9";
                    }
                  }
                @endphp
            <tr style="background-color:#9ad0ef">
              <th>{{@$val_a->registrasi->reg_id}} - {{ date('d-m-Y H:i', strtotime(@$val_a->registrasi->created_at)) }}</th>
              <th>
                @if ($val_a->unit == 'inap')
                  Rawat Inap
                  {{ @$val_a->histori_ranap_id ? @baca_histori_ranap_kamar($val_a->histori_ranap_id) : @$val_a->registrasi->rawat_inap->kamar->nama }}
                @elseif ($val_a->unit == 'farmasi')
                  Apotik / Farmasi
                @elseif (@$val_a->unit == 'gizi')
                  Gizi
                @else
                  POLI 
                  {{ @$val_a->poli_id ? @strtoupper(baca_poli($val_a->poli_id)) : @strtoupper($val_a->registrasi->poli->nama)}}
                @endif
                {{-- {{@strtoupper($val_a->registrasi->poli->nama)}} --}}
              </th>
            </tr>
            <tr style="background-color:#9ad0ef">
              <th>{{@date('d-m-Y, H:i A',strtotime($val_a->created_at))}}</th>
              <th>
                {{-- {{ $val_a->dokter_id ? baca_dokter($val_a->dokter_id) : @$val_a->registrasi->dokter_umum->nama}} --}}
                @php
                   $dokterid = Modules\Registrasi\Entities\Registrasi::where('id', $val_a->registrasi_id)->first();

                   if (@$reg->poli_id == '3' || @$reg->poli_id == '34' || @$reg->poli_id == '4'){
                   $gambar = App\EmrInapPenilaian::where('cppt_id', @$val_a->id)->where('type', 'gigi')->first();
                   }elseif (@$reg->poli_id == '15') {
                    $gambar = App\EmrInapPenilaian::where('cppt_id', @$val_a->id)->where('type', 'obgyn')->first();
                   } else {
                    $gambar = App\EmrInapPenilaian::where('cppt_id', @$val_a->id)->where('type', 'fisik')->first();
                   }

                @endphp
                {{-- {{ @$val_a->user->Pegawai->kelompok_pegawai ? @baca_kelompokpegawai(@$val_a->user->Pegawai->kelompok_pegawai) :'' }} --}}
                {{ baca_user($val_a->user_id)}} 

              </th>
            </tr>
            @if (@$val_a->unit == 'gizi')
              <tr style="background-color: {{$background}}">
                  <td colspan="2"><b>A:</b><br>
                    {!! nl2br($val_a->assesment) !!}
                  </td>
              </tr>
              <tr style="background-color: {{$background}}">
                  <td colspan="2"><b>D:</b><br>
                    {!! nl2br($val_a->diagnosis) !!}
                  </td>
              </tr>
              <tr style="background-color: {{$background}}">
                  <td colspan="2"><b>I:</b><br>
                    {!! nl2br($val_a->intervensi) !!}
                  </td>
              </tr>
              <tr style="background-color: {{$background}}">
                  <td colspan="2"><b>M:</b><br>
                    {!! nl2br($val_a->monitoring) !!}
                  </td>
              </tr>
              <tr style="background-color: {{$background}}">
                  <td colspan="2"><b>E:</b><br>
                    {!! nl2br($val_a->evaluasi) !!}
                  </td>
              </tr>
            @elseif (@$val_a->unit == 'farmasi')
              <tr style="background-color: {{$background}}">
                <td colspan="2"><b>S:</b><br>
                  {!! nl2br($val_a->subjective) !!}
                </td>
              </tr>
              <tr style="background-color: {{$background}}">
                <td colspan="2"><b>O:</b><br>
                  {!! nl2br($val_a->objective) !!}
                </td>
              </tr>
              <tr style="background-color: {{$background}}">
                <td colspan="2"><b>A:</b><br>
                  {!! nl2br($val_a->asesmen) !!}
                </td>
              </tr>
              <tr style="background-color: {{$background}}">
                <td colspan="2"><b>P:</b><br>
                  {!! nl2br($val_a->planning) !!}
                </td>
              </tr>
              <tr style="background-color: {{$background}}">
                <td colspan="2"><b>E:</b><br>
                  {!! nl2br($val_a->edukasi) !!}
                </td>
              </tr>
            @elseif (@$val_a->user->Pegawai->kategori_pegawai == 1)
              <tr style="background-color: {{$background}}">
                <td colspan="2"><b>S:</b><br>
                  {!! nl2br($val_a->subject) !!}
                </td>
              </tr>
              <tr style="background-color: {{$background}}">
                <td colspan="2"><b>O:</b><br>
                  {!! nl2br($val_a->object) !!}
                </td>
              </tr>
              <tr style="background-color: {{$background}}">
                <td colspan="2"><b>Hasil Penunjang:</b><br>
                    @php
                        $hasil_penunjang = [];

                        if (!empty($val_a->hasil_usg)) {
                            $hasil_penunjang[] = "<b>Hasil USG:</b><br> " . nl2br($val_a->hasil_usg);
                        }
                        if (!empty($val_a->hasil_echo)) {
                            $hasil_penunjang[] = "<b>Hasil Echo:</b><br> " . nl2br($val_a->hasil_echo);
                        }
                        if (!empty($val_a->hasil_ekg)) {
                            $hasil_penunjang[] = "<b>Hasil EKG:</b><br> " . nl2br($val_a->hasil_ekg);
                        }
                        if (!empty($val_a->hasil_eeg)) {
                            $hasil_penunjang[] = "<b>Hasil EEG:</b><br> " . nl2br($val_a->hasil_eeg);
                        }
                        if (!empty($val_a->hasil_ctg)) {
                            $hasil_penunjang[] = "<b>Hasil CTG:</b><br> " . nl2br($val_a->hasil_ctg);
                        }
                        if (!empty($val_a->hasil_spirometri)) {
                            $hasil_penunjang[] = "<b>Hasil Spirometri:</b><br> " . nl2br($val_a->hasil_spirometri);
                        }
                        if (!empty($hasil_lainnya)) {
                            $hasil_penunjang[] = "<b>Hasil Lainnya:</b><br> " . nl2br($hasil_lainnya);
                        }
                    @endphp
                    
                    {!! implode('<br>', $hasil_penunjang) !!}
                </td>
              </tr>            
              <tr style="background-color: {{$background}}">
                <td colspan="2"><b>A - Diagnosa Utama:</b><br>
                  {!! nl2br($val_a->assesment) !!}
                </td>
              </tr>
              <tr style="background-color: {{$background}}">
                <td colspan="2"><b>A - Diagnosa Tambahan:</b><br>
                  {!! nl2br($val_a->diagnosistambahan) !!}
                </td>
              </tr>
              <tr style="background-color: {{$background}}">
                <td colspan="2"><b>P:</b><br>
                  {!! nl2br($val_a->planning) !!}
                </td>
              </tr>
              <tr style="background-color: {{$background}}">
                  <td colspan="2" data-idss="{{@$id_ss->edukasi}}">
                      <b>Edukasi:</b> 
                      {{@App\Edukasi::where('code', $val_a->edukasi)->first()->keterangan}}
                  </td>
              </tr>
              <tr style="background-color: {{$background}}">
                  <td colspan="2" data-idss="{{@$id_ss->diet}}">
                      <b>Diet:</b> 
                      {!! @$val_a->diet !!}
                  </td>
              </tr>
              <tr style="background-color: {{$background}}">
                  <td colspan="2" data-idss="{{@$id_ss->prognosis}}">
                      <b>Prognosis:</b> 
                      {{@App\Prognosis::where('code', $val_a->prognosis)->first()->keterangan}}
                  </td>
              </tr>
              <tr style="background-color: {{$background}}">
                <td colspan="2"><b>Status Lokalis :</b>
                  @if (@$val_a->emrPenilaian && @$val_a->emrPenilaian->image != null)
                    <a id="myImg"><i class="fa fa-eye text-primary"></i></a>
                      <input type="hidden" src="/images/{{ @$val_a->emrPenilaian->image }}" id="dataImage">
                    
                    <div id="myModal" class="modal">
                      <span class="close" style="color: red; transform:scale(2); opacity:1">&times;</span>
                      <img class="modal-content" id="img01" style="margin-top: -40px">
                      <div id="caption">twat</div>
                    </div>
                  @else
                    -
                  @endif
                </td>
              </tr>
              <tr style="background-color: {{$background}}">
                <td colspan="2"><b>Discharge Planning :</b>
                  @if (@$val_a->discharge)
                    @php
                        @$assesment  = @json_decode(@$val_a->discharge, true);
                    @endphp
                    {{-- JIKA PULANG --}}
                    @if (@$assesment['dischargePlanning']['kontrol']['dipilih'])
                      {{@$assesment['dischargePlanning']['kontrol']['dipilih']}} - {{@$assesment['dischargePlanning']['kontrol']['waktu']}}
                    @elseif(@$assesment['dischargePlanning']['dirawat']['dipilih'])
                      {{@$assesment['dischargePlanning']['dirawat']['dipilih']}} - {{@$assesment['dischargePlanning']['dirawat']['waktu']}}
                    @elseif(@$assesment['dischargePlanning']['kontrolPRB']['dipilih'])
                      {{@$assesment['dischargePlanning']['kontrolPRB']['dipilih']}} - {{@$assesment['dischargePlanning']['kontrolPRB']['waktu']}}
                    @elseif(@$assesment['dischargePlanning']['Konsultasi']['dipilih'])
                      {{@$assesment['dischargePlanning']['Konsultasi']['dipilih']}} - {{@$assesment['dischargePlanning']['Konsultasi']['waktu']}}
                    @elseif(@$assesment['dischargePlanning']['pulpak']['dipilih'])
                      {{@$assesment['dischargePlanning']['pulpak']['dipilih']}} - {{@$assesment['dischargePlanning']['pulpak']['waktu']}}
                    @elseif(@$assesment['dischargePlanning']['observasi']['dipilih'])
                      {{@$assesment['dischargePlanning']['observasi']['dipilih']}} - {{@$assesment['dischargePlanning']['observasi']['waktu']}}
                    @elseif(@$assesment['dischargePlanning']['aps']['dipilih'])
                      {{@$assesment['dischargePlanning']['aps']['dipilih']}} - {{@$assesment['dischargePlanning']['aps']['waktu']}}
                    @elseif(@$assesment['dischargePlanning']['meninggal']['dipilih'])
                      {{@$assesment['dischargePlanning']['meninggal']['dipilih']}} - {{@$assesment['dischargePlanning']['meninggal']['waktu']}}
                    @else
                      {{@$assesment['dischargePlanning']['dirujuk']['dipilih']}} - {{@$assesment['dischargePlanning']['dirujuk']['waktu']}}
                    @endif
                  @endif
                </td>
              </tr>
            @else
              <tr style="background-color: {{$background}}">
                <td colspan="2"><b>S:</b><br>
                  {!! nl2br($val_a->subject) !!}
                </td>
              </tr>
              <tr style="background-color: {{$background}}">
                <td colspan="2"><b>O:</b><br>
                  {!! nl2br($val_a->object) !!}
                </td>
              </tr>
              <tr style="background-color: {{$background}}">
                <td colspan="2" data-idss="{{@$id_ss->nadi}}">
                    <b>Nadi:</b> {!! @$val_a->nadi !!} 
                </td>
              </tr>
              <tr style="background-color: {{$background}}">
                <td colspan="2" data-idss_sistol="{{@$id_ss->sistol}}" data-idss_distol="{{@$id_ss->distol}}" >
                    <b>Tekanan Darah:</b> {!! @$val_a->tekanan_darah !!} 
                </td>
              </tr>
              <tr style="background-color: {{$background}}">
                <td colspan="2" data-idss="{{@$id_ss->pernafasan}}">
                    <b>Frekuensi Nafas:</b> {!! @$val_a->frekuensi_nafas !!}
                </td>
              </tr>
              <tr style="background-color: {{$background}}">
                <td colspan="2" data-idss="{{@$id_ss->suhu}}">
                    <b>Suhu:</b> {!! @$val_a->suhu !!}
                </td>
              </tr>
              <tr style="background-color: {{$background}}">
                <td colspan="2"><b>Saturasi:</b> {!! @$val_a->saturasi !!}</td>
              </tr>
              <tr style="background-color: {{$background}}">
                <td colspan="2"><b>Berat Badan:</b> {!! @$val_a->berat_badan !!}</td>
              </tr>
              <tr style="background-color: {{$background}}">
                  <td colspan="2"><b>A:</b><br> 
                    {!! nl2br($val_a->assesment) !!}
                  </td>
              </tr>
              <tr style="background-color: {{$background}}">
                  <td colspan="2"><b>P:</b><br> 
                    {!! nl2br($val_a->planning) !!}
                  </td>
              </tr>
              <tr style="background-color: {{$background}}">
                <td colspan="2"><b>Implementasi:</b> {!! @$val_a->implementasi !!}</td>
              </tr>
              <tr style="background-color: {{$background}}">
                  <td colspan="2"><b>Keterangan:</b><br> 
                    {!! nl2br($val_a->keterangan) !!}
                  </td>
              </tr>
              <tr style="background-color: {{$background}}">
                <td colspan="2" ata-idss="{{@$id_ss->kesadaran}}">
                  <b>Kesadaran:</b>
                  {{@App\Kesadaran::where('code',  @$val_a->kesadaran)->first()->display}}
                </td>
              </tr>
            
              <tr style="background-color: {{$background}}">
                <td colspan="2"><b>Nyeri:</b> {!! @$val_a->skala_nyeri !!}</td>
              </tr>
              <tr style="background-color: {{$background}}">
                <td colspan="2"><b>Discharge Planning :</b>
                  @if (@$val_a->discharge)
                    @php
                        @$assesment  = @json_decode(@$val_a->discharge, true);
                    @endphp
                    {{-- JIKA PULANG --}}
                    @if (@$assesment['dischargePlanning']['kontrol']['dipilih'])
                      {{@$assesment['dischargePlanning']['kontrol']['dipilih']}} - {{@$assesment['dischargePlanning']['kontrol']['waktu']}}
                    @elseif(@$assesment['dischargePlanning']['dirawat']['dipilih'])
                      {{@$assesment['dischargePlanning']['dirawat']['dipilih']}} - {{@$assesment['dischargePlanning']['dirawat']['waktu']}}
                    @elseif(@$assesment['dischargePlanning']['kontrolPRB']['dipilih'])
                      {{@$assesment['dischargePlanning']['kontrolPRB']['dipilih']}} - {{@$assesment['dischargePlanning']['kontrolPRB']['waktu']}}
                    @elseif(@$assesment['dischargePlanning']['Konsultasi']['dipilih'])
                      {{@$assesment['dischargePlanning']['Konsultasi']['dipilih']}} - {{@$assesment['dischargePlanning']['Konsultasi']['waktu']}}
                    @elseif(@$assesment['dischargePlanning']['pulpak']['dipilih'])
                      {{@$assesment['dischargePlanning']['pulpak']['dipilih']}} - {{@$assesment['dischargePlanning']['pulpak']['waktu']}}
                    @elseif(@$assesment['dischargePlanning']['observasi']['dipilih'])
                      {{@$assesment['dischargePlanning']['observasi']['dipilih']}} - {{@$assesment['dischargePlanning']['observasi']['waktu']}}
                    @elseif(@$assesment['dischargePlanning']['meninggal']['dipilih'])
                      {{@$assesment['dischargePlanning']['meninggal']['dipilih']}} - {{@$assesment['dischargePlanning']['meninggal']['waktu']}}
                    @elseif(@$assesment['dischargePlanning']['alihigd']['dipilih'])
                      {{@$assesment['dischargePlanning']['alihigd']['dipilih']}} - {{@$assesment['dischargePlanning']['alihigd']['waktu']}}
                    @elseif(@$assesment['dischargePlanning']['alihponek']['dipilih'])
                      {{@$assesment['dischargePlanning']['alihponek']['dipilih']}} - {{@$assesment['dischargePlanning']['alihponek']['waktu']}}
                    @else
                      {{@$assesment['dischargePlanning']['dirujuk']['dipilih']}} - {{@$assesment['dischargePlanning']['dirujuk']['waktu']}}
                    @endif
                  @endif
                </td>
              </tr>
            @endif
            <tr style="background-color: {{$background}}">
              <td colspan="2" class="" style="font-size:15px;">
                {{-- <a href="" data-toggle="tooltip" title="Cetak"><i class="fa fa-print text-danger"></i></a>&nbsp;&nbsp; --}}
                <p>
                  {{-- @if (Auth::user()->pegawai->kategori_pegawai == 1)
                      @if (empty($val_a->verifikasi_dpjp))
                        <a href="{{url("/emr-soap-verif-dpjp/".$val_a->id)}}" class="btn btn-xs btn-flat btn-success">Verifikasi DPJP</a>
                      @else
                        <button type="button" class="btn btn-xs btn-flat btn-info">Sudah diverifikasi pada {{date('d-m-Y H:i:s', strtotime($val_a->verifikasi_dpjp))}}</button>
                      @endif
                  @endif --}}
                  @if (Auth::user()->id == $val_a->user_id || Auth::user()->id == 807)
                  <span class="pull-right">
                  @if (@$val_a->registrasi->poli_id == 3 || @$val_a->registrasi->poli_id == 4 || @$val_a->registrasi->poli_id == 34)
                    <a href="{{url('/emr-soap/penilaian/gigi/'.$unit.'/'.@$reg->id.'/'.@$val_a->id.'?poli='.$poli.'&dpjp='.$dpjp)}}" target="_blank" title="Status Lokalis"><i class="fa fa-pencil text-primary"></i></a>&nbsp;&nbsp;
                  @elseif(@$val_a->registrasi->poli_id == 6)
                    <a href="{{url('/emr-soap/penilaian/mata1/'.$unit.'/'.@$reg->id.'/'.@$val_a->id.'?poli='.$poli.'&dpjp='.$dpjp)}}" target="_blank" title="Status Lokalis"><i class="fa fa-pencil text-primary"></i></a>&nbsp;&nbsp;
                  @elseif(@$val_a->registrasi->poli_id == 15)
                    <a href="{{url('/emr-soap/penilaian/obgyn/'.$unit.'/'.@$reg->id.'/'.@$val_a->id.'?poli='.$poli.'&dpjp='.$dpjp)}}" target="_blank" title="Status Lokalis"><i class="fa fa-pencil text-primary"></i></a>&nbsp;&nbsp;
                  @elseif(@$val_a->registrasi->poli_id == 27)
                    <a href="{{url('/emr-soap/penilaian/hemodalisis/'.$unit.'/'.@$reg->id.'/'.@$val_a->id.'?poli='.$poli.'&dpjp='.$dpjp)}}" target="_blank" title="Status Lokalis"><i class="fa fa-pencil text-primary"></i></a>&nbsp;&nbsp;
                  @elseif(@$val_a->registrasi->poli_id == 41)
                    <a href="{{url('/emr-soap/penilaian/paru/'.$unit.'/'.@$reg->id.'/'.@$val_a->id.'?poli='.$poli.'&dpjp='.$dpjp)}}" target="_blank" title="Status Lokalis"><i class="fa fa-pencil text-primary"></i></a>&nbsp;&nbsp;
                  @else
                    <a href="{{url('/emr-soap/penilaian/fisik/'.$unit.'/'.@$reg->id.'/'.@$val_a->id.'?poli='.$poli.'&dpjp='.$dpjp)}}" target="_blank" title="Status Lokalis"><i class="fa fa-pencil text-primary"></i></a>&nbsp;&nbsp;
                  @endif

                  <a href="{{url('/emr/move-cppt/'.$val_a->id.'/'. @$reg->id)}}" onclick="return confirm('Yakin akan memindahkan CPPT ini ke pendaftaran tanggal {{date('d-m-Y H:i', strtotime($reg->created_at))}}?')" data-toggle="tooltip" title="Pindah Ke Registrasi Ini"><i class="fa fa-arrow-right"></i></a>&nbsp;&nbsp;
                  <a href="{{url('/emr/duplicate-soap/'.$val_a->id.'/'.$dpjp.'/'.$poli.'/'.@$reg->id)}}" onclick="return confirm('Yakin akan menduplikat data?')" data-toggle="tooltip" title="Duplikat"><i class="fa fa-copy"></i></a>&nbsp;&nbsp;
                  <a href="{{url('/emr/soap/'.$unit.'/'.@$reg->id.'/'.$val_a->id.'/edit?poli='.$poli.'&dpjp='.$dpjp)}}" data-toggle="tooltip" title="Edit"><i class="fa fa-edit text-warning"></i></a>&nbsp;&nbsp;
                  <a href="{{url('/emr/soap-delete/'.$unit.'/'.@$reg->id.'/'.$val_a->id)}}" data-toggle="tooltip" title="Delete" onclick="return confirm('Yakin akan menghapus data ini, data yang sudah dihapus tidak bisa dikembalikan');">
                    <i class="fa fa-trash text-danger"></i>
                  </a>&nbsp;&nbsp;
                  </span>
                  @endif
                  
                </p>
              </td>
            </tr>
            
            @endforeach
          </tbody>
      </table>
  </div>
</div>
{{-- @endsection --}}
 