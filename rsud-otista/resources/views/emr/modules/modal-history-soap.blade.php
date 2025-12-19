<div class="input-group">
  <span class="input-group-btn">
      <button class="btn btn-default" type="button">Poli&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
  </span>
  <input type="hidden" name="unit" value="{{ $unit }}">
  <select class="form-control select2" id="registrasi_select">
      <option value="">-- Pilih Poli</option>
      @foreach ($registrasis as $registrasi)
          <option value="{{ $registrasi->id }}" {{ @$reg->id == $registrasi->id ? 'selected' : '' }}>
              {{ baca_poli($registrasi->poli_id) }}
          </option>
      @endforeach
  </select>
</div>
@if (count($historyEmr) == 0)
  <span>Tidak Ada Record</span>
@else
  <div id="data-list-history-soap">
    <table class="table table-bordered">
      @foreach( $historyEmr as $key_a => $val_a)
        @if (@$val_a->user->pegawai->kategori_pegawai == 1)
          <tr style="background-color:#9ad0ef">
            <th>{{@$val_a->registrasi->reg_id}}</th>
            <th>
              @if ($val_a->unit == 'inap')
                Rawat Inap
                {{ @$val_a->registrasi->rawat_inap->kamar->nama }}
              @else
                POLI 
                {{ @$val_a->poli_id ? @strtoupper(baca_poli($val_a->poli_id)) : @strtoupper($val_a->registrasi->poli->nama)}}
              @endif
            </th>
          </tr>
          <tr style="background-color:#9ad0ef">
            <th>{{@date('d-m-Y, H:i A',strtotime($val_a->created_at))}}</th>
            <th>
              {{ baca_user($val_a->user_id)}}
            </th>
          </tr>
          <tr>
              <td colspan="2"><b>S:</b> {!! $val_a->subject !!}</td>
          </tr>
          <tr>
              <td colspan="2"><b>O:</b> {!! $val_a->object !!}</td>
          </tr>
          <tr>
              <td colspan="2"><b>A:</b> {!! $val_a->assesment !!}</td>
          </tr>
          <tr>
              <td colspan="2"><b>P:</b> {!! $val_a->planning !!}</td>
          </tr>
          <tr>
            <td colspan="2" data-idss="{{@$id_ss->edukasi}}">
              <b>Edukasi:</b> 
              {{@App\Edukasi::where('code', $val_a->edukasi)->first()->keterangan}}
            </td>
          </tr>
          <tr>
            <td colspan="2" data-idss="{{@$id_ss->diet}}">
                <b>Diet:</b> 
                {!! @$val_a->diet !!}
            </td>
          </tr>
          <tr>
            <td colspan="2" data-idss="{{@$id_ss->prognosis}}">
                <b>Prognosis:</b> 
                {{@App\Prognosis::where('code', $val_a->prognosis)->first()->keterangan}}
            </td>
          </tr>
          <tr>
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
                @else
                  {{@$assesment['dischargePlanning']['dirujuk']['dipilih']}} - {{@$assesment['dischargePlanning']['dirujuk']['waktu']}}
                @endif
              @endif
            </td>
          </tr>
        @else
          <tr style="background-color:#9ad0ef">
            <th>{{@$val_a->registrasi->reg_id}}</th>
            <th>POLI 
              {{ @$val_a->poli_id ? @strtoupper(baca_poli($val_a->poli_id)) : @strtoupper($val_a->registrasi->poli->nama)}}
              {{-- {{@strtoupper($val_a->registrasi->poli->nama)}} --}}
            </th>
          </tr>
          <tr style="background-color:#9ad0ef">
            <th>{{@date('d-m-Y, H:i A',strtotime($val_a->created_at))}}</th>
            <th>
              {{ baca_user($val_a->user_id)}}

            </th>
          </tr>
          <tr>
              <td colspan="2"><b>S:</b> {!! $val_a->subject !!}</td>
          </tr>
          <tr>
              <td colspan="2"><b>O:</b> {!! $val_a->object !!}</td>
          </tr>
          <tr>
            <td colspan="2" data-idss="{{@$id_ss->nadi}}">
                <b>Nadi:</b> {!! @$val_a->nadi !!} 
            </td>
          </tr>
          <tr>
            <td colspan="2" data-idss_sistol="{{@$id_ss->sistol}}" data-idss_distol="{{@$id_ss->distol}}" >
                <b>Tekanan Darah:</b> {!! @$val_a->tekanan_darah !!} 
            </td>
          </tr>
          <tr>
            <td colspan="2" data-idss="{{@$id_ss->pernafasan}}">
                <b>Frekuensi Nafas:</b> {!! @$val_a->frekuensi_nafas !!}
            </td>
          </tr>
          <tr>
            <td colspan="2" data-idss="{{@$id_ss->suhu}}">
                <b>Suhu:</b> {!! @$val_a->suhu !!}
            </td>
          </tr>
          <tr>
            <td colspan="2"><b>Berat Badan:</b> {!! @$val_a->berat_badan !!}</td>
          </tr>
          <tr>
              <td colspan="2"><b>A:</b> {!! $val_a->assesment !!}</td>
          </tr>
          <tr>
              <td colspan="2"><b>P:</b> {!! $val_a->planning !!}</td>
          </tr>
          <tr>
            <td colspan="2"><b>Implementasi:</b> {!! @$val_a->implementasi !!}</td>
          </tr>
 
          <tr>
            <td colspan="2" ata-idss="{{@$id_ss->kesadaran}}">
              <b>Kesadaran:</b>
              {{@App\Kesadaran::where('code',  @$val_a->kesadaran)->first()->display}}
            </td>
          </tr>
 
          <tr>
            <td colspan="2"><b>Nyeri:</b> {!! @$val_a->skala_nyeri !!}</td>
          </tr>
          <tr>
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
                @else
                  {{@$assesment['dischargePlanning']['dirujuk']['dipilih']}} - {{@$assesment['dischargePlanning']['dirujuk']['waktu']}}
                @endif
              @endif
            </td>
          </tr>
        @endif
      @if (Auth::user()->id == $val_a->user_id)
      <tr>
        <td colspan="2" class="" style="font-size:15px;">
          <p>
            <span class="pull-right">
            <a href="{{url('/emr/duplicate-soap/'.$val_a->id.'/'.$val_a->dokter_id.'/'.$val_a->registrasi->poli_id.'/'.@$val_a->registrasi_id)}}" onclick="return confirm('Yakin akan menduplikat data?')" data-toggle="tooltip" title="Duplikat"><i class="fa fa-copy"></i></a>&nbsp;&nbsp;
            <a href="{{url('/emr/soap/'.$unit.'/'.@$val_a->registrasi_id.'/'.$val_a->id.'/edit?poli='.$val_a->registrasi->poli_id.'&dpjp='.$val_a->dokter_id)}}" data-toggle="tooltip" title="Edit"><i class="fa fa-edit text-warning"></i></a>&nbsp;&nbsp;
            <a href="{{url('/emr/soap-delete/'.$unit.'/'.@$val_a->registrasi_id.'/'.$val_a->id)}}" data-toggle="tooltip" title="Delete" onclick="return confirm('Yakin akan menghapus data ini, data yang sudah dihapus tidak bisa dikembalikan');">
              <i class="fa fa-trash text-danger"></i>
            </a>&nbsp;&nbsp;
            </span>
          </p>
        </td>
      </tr>
      @endif
      @endforeach
    </table>
  </div>
@endif