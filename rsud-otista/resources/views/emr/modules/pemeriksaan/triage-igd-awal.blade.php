@extends('master')
@section('header')
@endsection
@section('content')
  <div class="box box-primary">
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          <form method="POST" action="{{ url('emr-soap/pemeriksaan/triage-igd-awal') }}"
              class="form-horizontal">
              {{ csrf_field() }}
              <h4 style="text-align: center; padding: 10px"><b>TRIAGE</b></h4>
          
              <div class="col-md-6">
                  <table style="width: 100%"
                      class="table-striped table-bordered table-hover table-condensed form-box table"
                      style="font-size:12px;">
    
                      <tr>
                          <td  style="width:40%; font-weight:bold;">
                              Nama Pasien
                          </td>
                          <td>
                              <input type="text" name="asessment[namaPasien]" style="width: 100%" value="{{@$asessment['namaPasien']}}" class="form-control" required>
                          </td>
                      </tr>
                      <tr>
                          <td  style="width:40%; font-weight:bold;">
                              Kontak awal dengan pasien
                          </td>
                          <td>
                              <input type="datetime-local" name="asessment[kontakAwal]" step="any" style="width: 100%" value="{{@$asessment['kontakAwal'] ?? date('Y-m-d\TH:i:s')}}" class="form-control">
                          </td>
                      </tr>
                      <tr>
                          <td  style="width:40%; font-weight:bold;">
                              Cara Masuk
                          </td>
                          <td style="padding: 5px;">
                              <div>
                                  <input class="form-check-input"
                                      name="asessment[caraMasuk]"
                                      {{ @$asessment['caraMasuk'] == 'Jalan' ? 'checked' : '' }}
                                      type="radio" value="Jalan" id="crMasuk.1" required>
                                  <label class="form-check-label" for="crMasuk.1">Jalan</label>
                              </div>
                              <div>
                                  <input class="form-check-input"
                                      name="asessment[caraMasuk]"
                                      {{ @$asessment['caraMasuk'] == 'Brankar' ? 'checked' : '' }}
                                      type="radio" value="Brankar" id="crMasuk.2">
                                  <label class="form-check-label" for="crMasuk.2">Brankar</label>
                              </div>
                              <div>
                                  <input class="form-check-input"
                                      name="asessment[caraMasuk]"
                                      {{ @$asessment['caraMasuk'] == 'Kursi Roda' ? 'checked' : '' }}
                                      type="radio" value="Kursi Roda" id="crMasuk.3">
                                  <label class="form-check-label" for="crMasuk.3">Kursi Roda</label>
                              </div>
                              <div>
                                  <input class="form-check-input"
                                      name="asessment[caraMasuk]"
                                      {{ @$asessment['caraMasuk'] == 'Di Gendong' ? 'checked' : '' }}
                                      type="radio" value="Di Gendong" id="crMasuk.4">
                                  <label class="form-check-label" for="crMasuk.4">Di Gendong</label>
                              </div>
                          </td>
                      </tr>
                      <tr>
                          <td  style="width:40%; font-weight:bold;">
                              Sudah Terpasang
                          </td>
                          <td>
                              <input type="text" style="width: 100%" name="asessment[sudahTerpasang]" value="{{@$asessment['sudahTerpasang']}}" class="form-control" class="form-control">
                          </td>
                      </tr>
                      <tr>
                          <td  style="width:40%; font-weight:bold;">
                              Alasan Kedatangan
                          </td>
                          <td style="padding: 5px;">
                              <div>
                                  <input class="form-check-input"
                                      name="asessment[sebabDatang][sebab]"
                                      {{ @$asessment['sebabDatang']['sebab'] == 'Datang Sendiri' ? 'checked' : '' }}
                                      type="radio" value="Datang Sendiri"  required>
                                  <label class="form-check-label">Datang Sendiri</label>
                              </div>
                              <div>
                                  <input class="form-check-input"
                                      name="asessment[sebabDatang][sebab]"
                                      {{ @$asessment['sebabDatang']['sebab'] == 'Polisi' ? 'checked' : '' }}
                                      type="radio" value="Polisi" >
                                  <label class="form-check-label" >Polisi</label>
                              </div>
                              <div>
                                  <input class="form-check-input"
                                      name="asessment[sebabDatang][sebab]"
                                      {{ @$asessment['sebabDatang']['sebab'] == 'Rujukan Dari' ? 'checked' : '' }}
                                      type="radio" value="Rujukan Dari">
                                  <label class="form-check-label" >Rujukan Dari</label>
                              </div>
                              <div>
                                  <input class="form-check-input"
                                      name="asessment[sebabDatang][sebab]"
                                      {{ @$asessment['sebabDatang']['sebab'] == 'Di Jemput Oleh' ? 'checked' : '' }}
                                      type="radio" value="Di Jemput Oleh" >
                                  <label class="form-check-label" >Di Jemput Oleh</label>
                              </div>
                              <div>
                                  <input type="text" style="width: 100%" name="asessment[sebabDatang][ket]" value="{{@$asessment['sebabDatang']['ket']}}" placeholder="keterangan tambahan" class="form-control">
                              </div>
                          </td>
                      </tr>
                      <tr>
                          <td  style="width:40%; font-weight:bold;">
                              Kendaraan
                          </td>
                          <td>
                              {{-- <input type="text" style="width: 100%" name="asessment[kendaraan]" value="{{@$asessment['kendaraan']}}" placeholder="cth: ambulance, mobil pribadi, motor, dll" class="form-control" class="form-control"> --}}
                              <select name="asessment[kendaraan]" class="form-control">
                                @foreach (App\Transportasi::all() as $transportasi)
                                    <option value="{{$transportasi->keterangan}}">{{$transportasi->keterangan}}</option>
                                @endforeach
                              </select>
                          </td>
                      </tr>
                      <tr>
                          <td  style="width:40%; font-weight:bold;">
                              Identitas Pengantar
                          </td>
                          <td>
                              <input type="text" style="width: 100%" name="asessment[namaPengantar]" value="{{@$asessment['namaPengantar']}}" placeholder="Nama Pengantar" class="form-control">
                              <input type="text" style="width: 100%" name="asessment[telpPengantar]" value="{{@$asessment['telpPengantar']}}" placeholder="No Telepon Pengantar" class="form-control">
                          </td>
                      </tr>
                      <tr>
                          <td  style="width:40%; font-weight:bold;">
                              Kasus
                          </td>
                          <td style="padding: 5px;">
                              <select name="asessment[kasus]" id="" class="form-control" required>
                                  <option value="Non Trauma" {{ @$asessment['kasus'] == 'Non Trauma' ? 'selected' : '' }}>Non Trauma</option>
                                  <option value="Trauma" {{ @$asessment['kasus'] == 'Trauma' ? 'selected' : '' }}>Trauma</option>
                              </select>
                              {{-- <div>
                                  <input class="form-check-input"
                                      name="asessment[kasus]"
                                      {{ @$asessment['kasus'] == 'Trauma' ? 'checked' : '' }}
                                      type="radio" value="Trauma" >
                                  <label class="form-check-label">Trauma</label>
                              </div>
                              <div>
                                  <input class="form-check-input"
                                      name="asessment[kasus]"
                                      {{ @$asessment['kasus'] == 'Non Trauma' ? 'checked' : '' }}
                                      type="radio" value="Non Trauma" >
                                  <label class="form-check-label">Non Trauma</label>
                              </div> --}}
                          </td>
                      </tr>
                  </table>
    
    
                  <table id="mekanismeTrauma" style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table hidden" style="font-size:12px;">
                      <tr>
                          <td colspan="3" style="font-weight: 900; text-align:center; padding-top:10px;">
                              MEKANISME TRAUMA
                          </td>
                      </tr>
                      <tr>
                          <td  style="width:40%; font-weight:bold;">
                              <input class="form-check-input"
                                  name="asessment[trauma][kllTunggal][ada]"
                                  {{ @$asessment['trauma']['kllTunggal']['ada'] == 'true' ? 'checked' : '' }}
                                  type="checkbox" value="true" >
                              <label class="form-check-label">KLL Tunggal</label>
                          </td>
                          <td>
                              <input type="text" style="width: 100%" name="asessment[trauma][kllTunggal][subject]" value="{{@$asessment['trauma']['kllTunggal']['subject']}}" placeholder="Subject" class="form-control">
                              <input type="text" style="width: 100%" name="asessment[trauma][kllTunggal][lokasi]" value="{{@$asessment['trauma']['kllTunggal']['lokasi']}}" placeholder="Lokasi Kejadian" class="form-control">
                              <input type="datetime-local" style="width: 100%" name="asessment[trauma][kllTunggal][waktu]" value="{{@$asessment['trauma']['kllTunggal']['waktu']}}" placeholder="Waktu Kejadian" class="form-control">
                          </td>
                      </tr>
                      <tr>
                          <td  style="width:40%; font-weight:bold;">
                              <input class="form-check-input"
                                  name="asessment[trauma][kll][ada]"
                                  {{ @$asessment['trauma']['kll']['ada'] == 'true' ? 'checked' : '' }}
                                  type="checkbox" value="true" >
                              <label class="form-check-label">KLL</label>
                          </td>
                          <td>
                              <input type="text" style="width: 100%" name="asessment[trauma][kll][subject1]" value="{{@$asessment['trauma']['kll']['subject1']}}" placeholder="Subject 1" class="form-control">
                              <input type="text" style="width: 100%" name="asessment[trauma][kll][subject2]" value="{{@$asessment['trauma']['kll']['subject2']}}" placeholder="Subject 2" class="form-control">
                              <input type="text" style="width: 100%" name="asessment[trauma][kll][lokasi]" value="{{@$asessment['trauma']['kll']['lokasi']}}" placeholder="Lokasi Kejadian" class="form-control">
                              <input type="datetime-local" style="width: 100%" name="asessment[trauma][kll][waktu]" value="{{@$asessment['trauma']['kll']['waktu']}}" placeholder="Waktu Kejadian" class="form-control">
                          </td>
                      </tr>
                      <tr>
                          <td  style="width:40%; font-weight:bold;">
                              <input class="form-check-input"
                                  name="asessment[trauma][jatuh][ada]"
                                  {{ @$asessment['trauma']['jatuh']['ada'] == 'true' ? 'checked' : '' }}
                                  type="checkbox" value="true" >
                              <label class="form-check-label">Jatuh Dari Ketinggian</label>
                          </td>
                          <td>
                              <input type="text" style="width: 100%" name="asessment[trauma][jatuh][ket]" value="{{@$asessment['trauma']['jatuh']['ket']}}" placeholder="Jelaskan" class="form-control">
                          </td>
                      </tr>
                      <tr>
                          <td  style="width:40%; font-weight:bold;">
                              <input class="form-check-input"
                                  name="asessment[trauma][lukaBakar][ada]"
                                  {{ @$asessment['trauma']['lukaBakar']['ada'] == 'true' ? 'checked' : '' }}
                                  type="checkbox" value="true" >
                              <label class="form-check-label">Luka Bakar</label>
                          </td>
                          <td>
                              <input type="text" style="width: 100%" name="asessment[trauma][lukaBakar][ket]" value="{{@$asessment['trauma']['lukaBakar']['ket']}}" placeholder="Jelaskan" class="form-control">
                          </td>
                      </tr>
                      <tr>
                          <td  style="width:40%; font-weight:bold;">
                              <input class="form-check-input"
                                  name="asessment[trauma][listrik][ada]"
                                  {{ @$asessment['trauma']['listrik']['ada'] == 'true' ? 'checked' : '' }}
                                  type="checkbox" value="true" >
                              <label class="form-check-label">Trauma Listrik</label>
                          </td>
                          <td>
                              <input type="text" style="width: 100%" name="asessment[trauma][listrik][ket]" value="{{@$asessment['trauma']['listrik']['ket']}}" placeholder="Jelaskan" class="form-control">
                          </td>
                      </tr>
                      <tr>
                          <td  style="width:40%; font-weight:bold;">
                              <input class="form-check-input"
                                  name="asessment[trauma][kimia][ada]"
                                  {{ @$asessment['trauma']['kimia']['ada'] == 'true' ? 'checked' : '' }}
                                  type="checkbox" value="true" >
                              <label class="form-check-label">Trauma Zat Kimia</label>
                          </td>
                          <td>
                              <input type="text" style="width: 100%" name="asessment[trauma][kimia][ket]" value="{{@$asessment['trauma']['kimia']['ket']}}" placeholder="Jelaskan" class="form-control">
                          </td>
                      </tr>
                      <tr>
                          <td  style="width:40%; font-weight:bold;">
                              <input class="form-check-input"
                                  name="asessment[trauma][dll][ada]"
                                  {{ @$asessment['trauma']['dll']['ada'] == 'true' ? 'checked' : '' }}
                                  type="checkbox" value="true" >
                              <label class="form-check-label">Trauma Lainnya</label>
                          </td>
                          <td>
                              <input type="text" style="width: 100%" name="asessment[trauma][dll][ket]" value="{{@$asessment['trauma']['dll']['ket']}}" placeholder="Jelaskan" class="form-control">
                          </td>
                      </tr>
                  </table>

                  <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table" style="font-size:12px;">
                      <tr>
                        <td style="width:40%; font-weight:bold;">
                            TTV
                        </td>
                        <td style="padding: 5px;">
                            <span><b>GCS:</b></span>
                            <input type="text" style="width: 100%" name="asessment[ttv][gcs]" value="{{@$asessment['ttv'][gcs]}}" placeholder="" class="form-control">
                            <span><b>Tekanan Darah:</b></span>
                            <input type="text" style="width: 100%" name="asessment[ttv][tekanan_darah]" value="{{@$asessment['ttv'][tekanan_darah]}}" placeholder="mmHg" class="form-control">
                            <span><b>Nadi:</b></span>
                            <input type="text" style="width: 100%" name="asessment[ttv][nadi]" value="{{@$asessment['ttv'][nadi]}}" placeholder="x/Menit" class="form-control">
                            <span><b>Suhu:</b></span>
                            <input type="text" style="width: 100%" name="asessment[ttv][suhu]" value="{{@$asessment['ttv'][suhu]}}" placeholder="°C" class="form-control">
                            <span><b>Respirasi:</b></span>
                            <input type="text" style="width: 100%" name="asessment[ttv][RR]" value="{{@$asessment['ttv'][RR]}}" placeholder="x/Menit" class="form-control">
                            <span><b>Saturasi:</b></span>
                            <input type="text" style="width: 100%" name="asessment[ttv][saturasi]" value="{{@$asessment['ttv'][saturasi]}}" placeholder="x/Menit" class="form-control">
                            <span><b>BB:</b></span>
                            <input type="text" style="width: 100%" name="asessment[ttv][BB]" value="{{@$asessment['ttv'][BB]}}" placeholder="Kg" class="form-control">
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2"  style="width:40%; font-weight:bold;">
                            Skala Nyeri
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2">
                            <img src="{{asset('Skala-nyeri-wajah.png')}}" style="width: 100%">
                            <input name="asessment[skala][skalaNyeri]" type="range" min="0" max="10" value="{{ @$asessment['skala']['skalaNyeri'] }}" oninput="this.nextElementSibling.value = this.value">
                            <output style="text-align: center; font-weight: bold">{{ @$asessment['skala']['skalaNyeri'] }}</output>
                        </td>
                      </tr>
                  </table>
                  
              </div>
              <div class="col-md-6">
                  <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table" style="font-size:12px;">
                      <tr>
                          <td colspan="2" style="font-weight: 900; text-align:center; padding-top:10px;">
                              KELUHAN UTAMA
                          </td>
                      </tr>
                      <tr>
                          <td colspan="2" >
                              <input type="text" name="asessment[keluhanUtama][ket]" style="width: 100%; height: 50px" value="{{@$asessment['keluhanUtama']['ket']}}" placeholder="Jelaksan" class="form-control" required>
                          </td>
                      </tr>
                      <tr>
                          <td  style="width:40%; font-weight:bold;">
                              Alergi
                          </td>
                          <td style="padding: 5px;">
                              <div>
                                  <input class="form-check-input"
                                      name="asessment[alergi][ada]"
                                      {{ @$asessment['alergi']['ada'] == 'Ada' ? 'checked' : '' }}
                                      type="radio" value="Ada" required>
                                  <label class="form-check-label">Ada</label>
                                  <input type="text" name="asessment[alergi][ket]" value="{{@$asessment['alergi']['ket']}}" placeholder="Jelaskan" class="form-control">
                                    <select name="asessment[alergi][pilihan]" class="select2" style="width: 100%">
                                        <option value="">-- Pilih Salah Satu --</option>
                                        @if (@$allergy)
                                            @foreach ($allergy as $item)
                                                <option value="{{$item->code}}" {{@$asessment['alergi']['pilihan'] == $item->code ? 'selected' : ''}}>{{$item->display}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                              </div>
                              <div>
                                  <input class="form-check-input"
                                      name="asessment[alergi][ada]"
                                      {{ @$asessment['alergi']['ada'] == 'Tidak Ada' ? 'checked' : '' }}
                                      type="radio" value="Tidak Ada" >
                                  <label class="form-check-label">Tidak Ada</label>
                              </div>
                          </td>
                      </tr>
                      
                  </table>
    
                  <style>
                      .red{
                          background-color: rgb(255, 106, 106);
                      }
                      .yellow{
                          background-color: rgb(255, 238, 110);
                      }
                      .green{
                          background-color: rgb(166, 255, 110);
                      }
                  </style>
                  <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table" style="font-size:12px;">
                      <tr>
                          <td colspan="6" style="font-weight: 900; text-align:center; padding-top:10px;">
                              TRIAGE
                          </td>
                      </tr>
                      <tr style="font-weight: bold">
                          <td></td>
                          <td class="red">ATS I SEGERA</td>
                          <td class="yellow">ATS II 10 MENIT</td>
                          <td class="yellow">ATS III 30 MENIT</td>
                          <td class="green">ATS IV 60 MENIT</td>
                          <td class="green">ATS V 120 MENIT</td>
                      </tr>
                      <tr id="jalan-nafas-group">
                          <td>Jalan Nafas</td>
                          <td class="red">
                              <div>
                                  <input class="form-check-input"
                                      name="asessment[triage][jalanNafas][obstruksi]"
                                      {{ @$asessment['triage']['jalanNafas']['obstruksi'] == 'true' ? 'checked' : '' }}
                                      type="checkbox" value="true" id="red-checkbox-triger">
                                  <label class="form-check-label">Obstruksi / Parsial Obstruksi</label>
                              </div>
                          </td>
                          <td class="yellow">
                              <div>
                                  <input class="form-check-input"
                                      name="asessment[triage][jalanNafas][paten][yellow1]"
                                      {{ @$asessment['triage']['jalanNafas']['paten']['yellow1'] == 'true' ? 'checked' : '' }}
                                      type="checkbox" value="true" id="yellow1-checkbox-triger">
                                  <label class="form-check-label">Paten</label>
                              </div>
                          </td>
                          <td class="yellow">
                              <div>
                                  <input class="form-check-input"
                                      name="asessment[triage][jalanNafas][paten][yellow2]"
                                      {{ @$asessment['triage']['jalanNafas']['paten']['yellow2'] == 'true' ? 'checked' : '' }}
                                      type="checkbox" value="true" id="yellow2-checkbox-triger">
                                  <label class="form-check-label">Paten</label>
                              </div>
                          </td>
                          <td class="green">
                              <div>
                                  <input class="form-check-input"
                                      name="asessment[triage][jalanNafas][paten][green1]"
                                      {{ @$asessment['triage']['jalanNafas']['paten']['green1'] == 'true' ? 'checked' : '' }}
                                      type="checkbox" value="true" id="green1-checkbox-triger">
                                  <label class="form-check-label">Paten</label>
                              </div>
                          </td>
                          <td class="green">
                              <div>
                                  <input class="form-check-input"
                                      name="asessment[triage][jalanNafas][paten][green2]"
                                      {{ @$asessment['triage']['jalanNafas']['paten']['green2'] == 'true' ? 'checked' : '' }}
                                      type="checkbox" value="true" id="green2-checkbox-triger">
                                  <label class="form-check-label">Paten</label>
                              </div>
                          </td>
                      </tr>
                      <tr id="pernafasan-group">
                          <td>Pernafasan</td>
                          <td class="red">
                              <div>
                                  <input class="form-check-input red"
                                      name="asessment[triage][pernafasan][nafasBerat]"
                                      {{ @$asessment['triage']['pernafasan']['nafasBerat'] == 'true' ? 'checked' : '' }}
                                      type="checkbox" value="true" >
                                  <label class="form-check-label">Distress nafas berat</label>
                              </div>
                              <div>
                                  <input class="form-check-input red"
                                      name="asessment[triage][pernafasan][hentiNafas]"
                                      {{ @$asessment['triage']['pernafasan']['hentiNafas'] == 'true' ? 'checked' : '' }}
                                      type="checkbox" value="true" >
                                  <label class="form-check-label">Henti Nafas</label>
                              </div>
                              <div>
                                  <input class="form-check-input red"
                                      name="asessment[triage][pernafasan][hivoventilasi]"
                                      {{ @$asessment['triage']['pernafasan']['hivoventilasi'] == 'true' ? 'checked' : '' }}
                                      type="checkbox" value="true" >
                                  <label class="form-check-label">Hivoventilasi</label>
                              </div>
                          </td>
                          <td class="yellow">
                              <div>
                                  <input class="form-check-input yellow1"
                                      name="asessment[triage][pernafasan][nafasSedang]"
                                      {{ @$asessment['triage']['pernafasan']['nafasSedang'] == 'true' ? 'checked' : '' }}
                                      type="checkbox" value="true" id="yellow1-checkbox-triger2">
                                  <label class="form-check-label">Distress nafas sedang</label>
                              </div>
                          </td>
                          <td class="yellow">
                              <div>
                                  <input class="form-check-input yellow2"
                                      name="asessment[triage][pernafasan][nafasRingan]"
                                      {{ @$asessment['triage']['pernafasan']['nafasRingan'] == 'true' ? 'checked' : '' }}
                                      type="checkbox" value="true" id="yellow2-checkbox-triger2">
                                  <label class="form-check-label">Distress nafas ringan</label>
                              </div>
                          </td>
                          <td class="green">
                              <div>
                                  <input class="form-check-input green1"
                                      name="asessment[triage][pernafasan][noDistress][green1]"
                                      {{ @$asessment['triage']['pernafasan']['noDistress']['green1'] == 'true' ? 'checked' : '' }}
                                      type="checkbox" value="true" id="green1-checkbox-triger2">
                                  <label class="form-check-label">Tidak ada distress nafas</label>
                              </div>
                          </td>
                          <td class="green">
                              <div>
                                  <input class="form-check-input green2"
                                      name="asessment[triage][pernafasan][noDistress][green2]"
                                      {{ @$asessment['triage']['pernafasan']['noDistress']['green2'] == 'true' ? 'checked' : '' }}
                                      type="checkbox" value="true" id="green2-checkbox-triger2">
                                  <label class="form-check-label">Tidak ada distress nafas</label>
                              </div>
                          </td>
                      </tr>
                      <tr id="sirkulasi-group">

                          <td>Sirkulasi</td>
                          <td class="red">
                              <div>
                                  <input class="form-check-input red"
                                      name="asessment[triage][sirkulasi][hemodinamikBerat]"
                                      {{ @$asessment['triage']['sirkulasi']['hemodinamikBerat'] == 'true' ? 'checked' : '' }}
                                      type="checkbox" value="true" >
                                  <label class="form-check-label">Gangguan hemodinamik berat</label>
                              </div>
                              <div>
                                  <input class="form-check-input red"
                                      name="asessment[triage][sirkulasi][hentiJantung]"
                                      {{ @$asessment['triage']['sirkulasi']['hentiJantung'] == 'true' ? 'checked' : '' }}
                                      type="checkbox" value="true" >
                                  <label class="form-check-label">Henti Jantung</label>
                              </div>
                              <div>
                                  <input class="form-check-input red"
                                      name="asessment[triage][sirkulasi][pendarahTakTerkontrol]"
                                      {{ @$asessment['triage']['sirkulasi']['pendarahTakTerkontrol'] == 'true' ? 'checked' : '' }}
                                      type="checkbox" value="true" >
                                  <label class="form-check-label">Pendarah tak terkontrol</label>
                              </div>
                          </td>
                          <td class="yellow">
                              <div>
                                  <input class="form-check-input yellow1"
                                      name="asessment[triage][sirkulasi][hemodinamikSedang]"
                                      {{ @$asessment['triage']['sirkulasi']['hemodinamikSedang'] == 'true' ? 'checked' : '' }}
                                      type="checkbox" value="true" id="yellow1-checkbox-triger3">
                                  <label class="form-check-label">Gangguan hemodinamik sedang</label>
                              </div>
                          </td>
                          <td class="yellow">
                              <div>
                                  <input class="form-check-input yellow2"
                                      name="asessment[triage][sirkulasi][hemodinamikRingan]"
                                      {{ @$asessment['triage']['sirkulasi']['hemodinamikRingan'] == 'true' ? 'checked' : '' }}
                                      type="checkbox" value="true" id="yellow2-checkbox-triger3">
                                  <label class="form-check-label">Gangguan hemodinamik ringan</label>
                              </div>
                          </td>
                          <td class="green">
                              <div>
                                  <input class="form-check-input green1"
                                      name="asessment[triage][sirkulasi][noGangguan][green1]"
                                      {{ @$asessment['triage']['sirkulasi']['noGangguan']['green1'] == 'true' ? 'checked' : '' }}
                                      type="checkbox" value="true" id="green1-checkbox-triger3">
                                  <label class="form-check-label">Tidak ada gangguan sirkulasi</label>
                              </div>
                          </td>
                          <td class="green">
                              <div>
                                  <input class="form-check-input green2"
                                      name="asessment[triage][sirkulasi][noGangguan][green2]"
                                      {{ @$asessment['triage']['sirkulasi']['noGangguan']['green2'] == 'true' ? 'checked' : '' }}
                                      type="checkbox" value="true" id="green2-checkbox-triger3">
                                  <label class="form-check-label">Tidak ada gangguan sirkulasi</label>
                              </div>
                          </td>
                      </tr>
                      <tr id="gcs-group">
                          <td>GCS</td>
                          <td class="red">
                              <div>
                                  <input class="form-check-input red"
                                      name="asessment[triage][GCS][<9]"
                                      {{ @$asessment['triage']['GCS']['<9'] == 'true' ? 'checked' : '' }}
                                      type="checkbox" value="true" >
                                  <label class="form-check-label">GCS < 9</label>
                              </div>
                          </td>
                          <td class="yellow">
                              <div>
                                  <input class="form-check-input yellow1"
                                      name="asessment[triage][GCS][9-12]"
                                      {{ @$asessment['triage']['GCS']['9-12'] == 'true' ? 'checked' : '' }}
                                      type="checkbox" value="true" id="yellow1-checkbox-triger4">
                                  <label class="form-check-label">GCS 9-12</label>
                              </div>
                          </td>
                          <td class="yellow">
                              <div>
                                  <input class="form-check-input yellow2"
                                      name="asessment[triage][GCS][>12]"
                                      {{ @$asessment['triage']['GCS']['>12'] == 'true' ? 'checked' : '' }}
                                      type="checkbox" value="true" id="yellow2-checkbox-triger4">
                                  <label class="form-check-label">GCS >12</label>
                              </div>
                          </td>
                          <td class="green">
                              <div>
                                  <input class="form-check-input green1"
                                      name="asessment[triage][GCS][normalGCS][green1]"
                                      {{ @$asessment['triage']['GCS']['normalGCS']['green1'] == 'true' ? 'checked' : '' }}
                                      type="checkbox" value="true" id="green1-checkbox-triger4">
                                  <label class="form-check-label">Normal GCS</label>
                              </div>
                          </td>
                          <td class="green">
                              <div>
                                  <input class="form-check-input green2"
                                      name="asessment[triage][GCS][normalGCS][green2]"
                                      {{ @$asessment['triage']['GCS']['normalGCS']['green2'] == 'true' ? 'checked' : '' }}
                                      type="checkbox" value="true" id="green2-checkbox-triger4">
                                  <label class="form-check-label">Normal GCS</label>
                              </div>
                          </td>
                      </tr>
                      <tr>
                          <td colspan="1" >
                              Kesimpulan
                          </td>
                          <td colspan="5" >
                              <div class="red" style="display: inline-block; padding: 10px">
                                  <input class="form-check-input kesimpulanRed"
                                      name="asessment[triage][kesimpulan]"
                                      {{ @$asessment['triage']['kesimpulan'] == 'Emergency ATS I' ? 'checked' : '' }}
                                      type="radio" value="Emergency ATS I" required>
                                  <label class="form-check-label">Emergency ATS I</label>
                              </div>
                              <div class="yellow"  style="display: inline-block; padding: 10px">
                                  <input class="form-check-input kesimpulanYellow"
                                      name="asessment[triage][kesimpulan]"
                                      {{ @$asessment['triage']['kesimpulan'] == 'Urgent ATS II & III' ? 'checked' : '' }}
                                      type="radio" value="Urgent ATS II & III" >
                                  <label class="form-check-label">Urgent ATS II & III</label>
                              </div>
                              <div class="green"  style="display: inline-block; padding: 10px">
                                  <input class="form-check-input kesimpulanGreen"
                                      name="asessment[triage][kesimpulan]"
                                      {{ @$asessment['triage']['kesimpulan'] == 'Non Urgent ATS IV & V' ? 'checked' : '' }}
                                      type="radio" value="Non Urgent ATS IV & V" >
                                  <label class="form-check-label">Non Urgent ATS IV & V</label>
                              </div>
                              <div  style="display: inline-block; padding: 10px; background-color:rgb(169, 169, 169)">
                                  <input class="form-check-input kesimpulanMeninggal"
                                      name="asessment[triage][kesimpulan]"
                                      {{ @$asessment['triage']['kesimpulan'] == 'Meninggal' ? 'checked' : '' }}
                                      type="radio" value="Meninggal" >
                                  <label class="form-check-label">Meninggal</label>
                              </div>
                          </td>
                      </tr>
                      <tr>
                        <td colspan="1">
                            Kondisi Pasien Tiba
                        </td>
                        <td colspan="5">
                            @foreach (App\KondisiPasienTiba::all() as $kondisi)
                                @if($kondisi->keterangan == 'Resusitasi')
                                    <div style="display: none;">
                                @elseif($kondisi->keterangan == 'Less Urgent')
                                    <div style="display: none;">
                                @else
                                    <div style="display: inline-block; padding: 10px">
                                @endif
                                    <input class="form-check-input" required
                                        name="asessment[triage][kondisi_pasien_tiba]"
                                        {{ @$asessment['triage']['kondisi_pasien_tiba'] == $kondisi->keterangan ? 'checked' : '' }}
                                        type="radio" value="{{ $kondisi->keterangan }}" 
                                        @if($kondisi->keterangan == 'Urgent') 
                                            id="urgent" 
                                        @elseif($kondisi->keterangan == 'Emergensi')
                                            id="emergensi"
                                        @elseif($kondisi->keterangan == 'Non Urgent')
                                            id="non-urgent"
                                        @elseif($kondisi->keterangan == 'Death on Arrival')
                                            id="death-on-arrival"
                                        @endif>
                                    <label class="form-check-label">{{ $kondisi->keterangan }}</label>
                                </div>
                            @endforeach
                        </td>
                      </tr>                                                           
                      <tr>
                          <td>Catatan Khusus</td>
                          <td colspan="5">
                              <textarea class="form-control" name="asessment[triage][catatan]"  style="width: 100%; resize:vertical;" rows="3">{{@$asessment['triage']['catatan']}}</textarea>
                          </td>
                      </tr>
                      <tr>
                          <td>Keputusan</td>
                          <td colspan="5">
                              <textarea class="form-control" name="asessment[triage][keputusan]"  style="width: 100%; resize:vertical;" rows="3">{{@$asessment['triage']['keputusan']}}</textarea>
                          </td>
                      </tr>
                      <tr>
                          <td colspan="1">Ruang</td>
                          <td colspan="5" >
                              <div class="red" style="display: inline-block; padding: 10px">
                                  <input class="form-check-input resusitasi" required
                                      name="asessment[triage][keputusanRuang]"
                                      {{ @$asessment['triage']['keputusanRuang'] == 'Ruang Resusitasi' ? 'checked' : '' }}
                                      type="radio" value="Ruang Resusitasi" >
                                  <label class="form-check-label">Ruang Resusitasi</label>
                              </div>
                              <div class="yellow"  style="display: inline-block; padding: 10px">
                                  <input class="form-check-input non-resusitasi"
                                      name="asessment[triage][keputusanRuang]"
                                      {{ @$asessment['triage']['keputusanRuang'] == 'Ruang Non Resusitasi' ? 'checked' : '' }}
                                      type="radio" value="Ruang Non Resusitasi" >
                                  <label class="form-check-label">Ruang Non Resusitasi</label>
                              </div>
                              <div class="green"  style="display: inline-block; padding: 10px">
                                  <input class="form-check-input klinik-umum"
                                      name="asessment[triage][keputusanRuang]"
                                      {{ @$asessment['triage']['keputusanRuang'] == 'Klinik Umum 24 Jam' ? 'checked' : '' }}
                                      type="radio" value="Klinik Umum 24 Jam" >
                                  <label class="form-check-label">Klinik Umum 24 Jam</label>
                              </div>
                              <div  style="display: inline-block; padding: 10px; background-color:rgb(169, 169, 169)">
                                  <input class="form-check-input deat-on-arival"
                                      name="asessment[triage][keputusanRuang]"
                                      {{ @$asessment['triage']['keputusanRuang'] == 'Deat on Arival (DoA)' ? 'checked' : '' }}
                                      type="radio" value="Deat on Arival (DoA)" >
                                  <label class="form-check-label">Deat on Arival (DoA)</label>
                              </div>
                          </td>
                      </tr>
                  </table>
                  
                  @if (@$asessment == null)
                  <div class="text-right" style="margin-top: 10px; ">
                      <button class="btn btn-success">Simpan</button>
                  </div>
                  @endif
              </div>
              <div class="col-md-12">
                <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table" style="font-size:12px;" id="igd-triage">
                    <thead>
                        <tr>
                            <th colspan="4" class="text-center">Riwayat Triage 24 Jam</th>
                        </tr>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Triage</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($riwayatTriage as $t)
                            @php
                                $namaPasien = '';
                                $status = '';
                                $data = json_decode($t->fisik, true);
                                if($t->registrasi_id == '0' || $t->registrasi_id == NULL){
                                    $namaPasien = $data['namaPasien'];
                                    $status = 'Belum Didaftarkan';
                                }else{
                                    $namaPasien = $t->registrasi->pasien->nama;
                                    $status = 'Sudah Didaftarkan';
                                }
                            @endphp
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $namaPasien }}</td>
                                @if (@$data['triage']['kesimpulan'] == 'Emergency ATS I')
                                <td style="background-color: rgb(255, 106, 106);">{{ @$data['triage']['kesimpulan'] }}</td>
                                @elseif(@$data['triage']['kesimpulan'] == 'Urgent ATS II & III')
                                <td style="background-color: rgb(255, 238, 110);">{{ @$data['triage']['kesimpulan'] }}</td>
                                @elseif(@$data['triage']['kesimpulan'] == 'Non Urgent ATS IV & V')
                                <td style="background-color: rgb(166, 255, 110);">{{ @$data['triage']['kesimpulan'] }}</td>
                                @else
                                <td style="background-color: rgb(169, 169, 169);">{{ @$data['triage']['kesimpulan'] }}</td>
                                @endif
                                <td class="{{ $status == 'Sudah Didaftarkan' ? 'text-success' : 'text-danger' }}">{{ $status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
              </div>
    
    
    
              <br /><br />
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('css')
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.2/css/dataTables.bootstrap.min.css">
@endsection

@section('script')
  {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
  <script src="{{ asset('style') }}/bower_components/jquery/dist/jquery.min.js"></script>
  <script src="https://cdn.datatables.net/2.1.2/js/dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/2.1.2/js/dataTables.bootstrap.min.js"></script>
  <script src="{{ asset('style') }}/bower_components/select2/dist/js/select2.full.min.js"></script>
  <link rel="stylesheet" href="{{ asset('style') }}/bower_components/select2/dist/css/select2.css">
  <script>
    $('.select2').select2();
    $(document).ready(function(){
        $('#igd-triage').DataTable();
    $('select[name="asessment[kasus]"]').on('change', function(e) {
        e.preventDefault();
        if ($(this).val() == 'Trauma') {
            // $('select[name="jkn"]').val('').trigger('change')
            $('#mekanismeTrauma').removeClass('hidden')
        } else {
            $('#mekanismeTrauma').addClass('hidden')
        }
    });

    $(document).ready(function () {
    $("form").submit(function (event) {
            let isValid = true;
            const sections = ["jalan-nafas-group", "pernafasan-group", "sirkulasi-group", "gcs-group"];

            sections.forEach(function (section) {
                const checkboxes = $("#" + section + " input[type='checkbox']");
                const isChecked = checkboxes.is(":checked");

                if (!isChecked) {
                    isValid = false;
                    $("#" + section).css("border", "2px solid red"); // Highlight jika tidak dicentang
                } else {
                    $("#" + section).css("border", "none"); // Hapus highlight jika sudah dicentang
                }
            });

            if (!isValid) {
                event.preventDefault(); // Cegah form terkirim jika ada yang kosong
                alert("Harap isi minimal satu checklist di setiap kategori (Jalan Nafas, Pernafasan, Sirkulasi, GCS).");
            }
        });
    });
    // $('#red-checkbox-triger').change(function () {
    //     if ($(this).is(':checked')) {
    //         $('input.red').attr("checked", true);
    //         $('input.kesimpulanRed').attr("checked", true);
    //         $('input.resusitasi').prop("checked", true);
    //         $('#emergensi').prop("checked", true);
    //     } else {
    //         $('input.red').attr("checked", false);
    //         $('input.kesimpulanRed').attr("checked", true);
    //     }
    // })
    // $('#yellow1-checkbox-triger').change(function () {
    //     if ($(this).is(':checked')) {
    //         $('input.yellow1').attr("checked", true);
    //         $('input.kesimpulanYellow').attr("checked", true);
    //         $('input.non-resusitasi').prop("checked", true);
    //         $('#urgent').prop("checked", true);
    //     } else {
    //         $('input.yellow1').attr("checked", false);
    //         $('input.kesimpulanYellow').attr("checked", false);
    //     }
    // })
    // $('#yellow1-checkbox-triger2').change(function () {
    //     if ($(this).is(':checked')) {
    //         $('input.kesimpulanYellow').prop("checked", true);
    //         $('input.non-resusitasi').prop("checked", true);
    //         $('#urgent').prop("checked", true);
    //     }
    // })
    // $('#yellow1-checkbox-triger3').change(function () {
    //     if ($(this).is(':checked')) {
    //         $('input.kesimpulanYellow').prop("checked", true);
    //         $('input.non-resusitasi').prop("checked", true);
    //         $('#urgent').prop("checked", true);
    //     }
    // })
    // $('#yellow1-checkbox-triger4').change(function () {
    //     if ($(this).is(':checked')) {
    //         $('input.kesimpulanYellow').prop("checked", true);
    //         $('input.non-resusitasi').prop("checked", true);
    //         $('#urgent').prop("checked", true);
    //     }
    // })

    // $('#yellow2-checkbox-triger').change(function () {
    //     if ($(this).is(':checked')) {
    //         $('input.yellow2').attr("checked", true);
    //         $('input.kesimpulanYellow').attr("checked", true);
    //         $('input.non-resusitasi').prop("checked", true);
    //         $('#urgent').prop("checked", true);
    //     } else {
    //         $('input.yellow2').attr("checked", false);
    //         $('input.kesimpulanYellow').attr("checked", false);
    //     }
    // })
    // $('#yellow2-checkbox-triger2').change(function () {
    //     if ($(this).is(':checked')) {
    //         $('input.kesimpulanYellow').attr("checked", true);
    //         $('input.non-resusitasi').prop("checked", true);
    //         $('#urgent').prop("checked", true);
    //     }
    // })
    // $('#yellow2-checkbox-triger3').change(function () {
    //     if ($(this).is(':checked')) {
    //         $('input.kesimpulanYellow').attr("checked", true);
    //         $('input.non-resusitasi').prop("checked", true);
    //         $('#urgent').prop("checked", true);
    //     }
    // })
    // $('#yellow2-checkbox-triger4').change(function () {
    //     if ($(this).is(':checked')) {
    //         $('input.kesimpulanYellow').attr("checked", true);
    //         $('input.non-resusitasi').prop("checked", true);
    //         $('#urgent').prop("checked", true);
    //     }
    // })

    // $('#green1-checkbox-triger').change(function () {
    //     if ($(this).is(':checked')) {
    //         $('input.green1').attr("checked", true);
    //         $('input.kesimpulanGreen').attr("checked", true);
    //         $('input.klinik-umum ').prop("checked", true);
    //         $('#non-urgent').prop("checked", true);
    //     } else {
    //         $('input.green1').attr("checked", false);
    //         $('input.kesimpulanGreen').attr("checked", false);
    //     }
    // })
    // $('#green1-checkbox-triger2').change(function () {
    //     if ($(this).is(':checked')) {
    //         $('input.kesimpulanGreen').attr("checked", true);
    //         $('input.klinik-umum ').prop("checked", true);
    //         $('#non-urgent').prop("checked", true);
    //     }
    // })
    // $('#green1-checkbox-triger3').change(function () {
    //     if ($(this).is(':checked')) {
    //         $('input.kesimpulanGreen').attr("checked", true);
    //         $('input.klinik-umum ').prop("checked", true);
    //         $('#non-urgent').prop("checked", true);
    //     }
    // })
    // $('#green1-checkbox-triger4').change(function () {
    //     if ($(this).is(':checked')) {
    //         $('input.kesimpulanGreen').attr("checked", true);
    //         $('input.klinik-umum ').prop("checked", true);
    //         $('#non-urgent').prop("checked", true);
    //     }
    // })

    // $('#green2-checkbox-triger').change(function () {
    //     if ($(this).is(':checked')) {
    //         $('input.green2').attr("checked", true);
    //         $('input.kesimpulanGreen').attr("checked", true);
    //         $('input.klinik-umum ').prop("checked", true);
    //         $('#non-urgent').prop("checked", true);
    //     } else {
    //         $('input.green2').attr("checked", false);
    //         $('input.kesimpulanGreen').attr("checked", false);
    //     }
    // })
    // $('#green2-checkbox-triger2').change(function () {
    //     if ($(this).is(':checked')) {
    //         $('input.kesimpulanGreen').attr("checked", true);
    //         $('input.klinik-umum ').prop("checked", true);
    //         $('#non-urgent').prop("checked", true);
    //     }
    // })
    // $('#green2-checkbox-triger3').change(function () {
    //     if ($(this).is(':checked')) {
    //         $('input.kesimpulanGreen').attr("checked", true);
    //         $('input.klinik-umum ').prop("checked", true);
    //         $('#non-urgent').prop("checked", true);
    //     }
    // })
    // $('#green2-checkbox-triger4').change(function () {
    //     if ($(this).is(':checked')) {
    //         $('input.kesimpulanGreen').attr("checked", true);
    //         $('input.klinik-umum ').prop("checked", true);
    //         $('#non-urgent').prop("checked", true);
    //     }
    // })

    // $('#death-on-arrival').change(function () {
    //     if ($(this).is(':checked')) {
    //         $('input.kesimpulanMeninggal').attr("checked", true);
    //         $('input.deat-on-arival').attr("checked", true);
    //     }
    // })

  });
  </script>
@endsection