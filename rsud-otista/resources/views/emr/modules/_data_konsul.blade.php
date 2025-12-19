<style>
  .new {
    background-color: #e4ffe4;
  }
</style>
<form method="POST" action="{{ url('emr-jawabkonsul') }}" class="form-horizontal">
  {{ csrf_field() }}
  {!! Form::hidden('registrasi_id', $reg->id) !!}
  {!! Form::hidden('pasien_id', @$reg->pasien->id) !!}
  {!! Form::hidden('cara_bayar', $reg->bayar) !!}
  {!! Form::hidden('konsul_dokter_id', $emr->id) !!}
  {!! Form::hidden('dokter_pengirim', $emr->dokter_pengirim) !!}
  {!! Form::hidden('dokter_penjawab', $emr->dokter_penjawab) !!}
  {!! Form::hidden('unit', $unit) !!}
<div class="box box-primary">
  <div class="box-body">
    {{-- Soap Input --}}
    <div class="col-md-12">
      <table style="width: 100%" style="font-size:12px;">
        <tr>
          <td><b>Tanggal dan Jam Jawab</b></td>
          <td style="padding: 5px;">
            <div class="row">
              <div class="col-md-7"><input type="date" name="tanggal" class="form-control"
                  value="{{@$emr->tanggal ? @$emr->tanggal : date('Y-m-d') }}" readonly></div>
              <div class="col-md-5"><input type="time" name="waktu" class="form-control"
                  value="{{@$emr->waktu ? @$emr->waktu : date('H:i')}}" readonly></div>
            </div>


          </td>
        </tr>
        <tr>
          <td style="width:200px;"><b>Dokter Pengirim Konsul</b></td>
          <td style="padding: 5px;">
            {{@baca_dokter(@$emr->dokter_pengirim)}}
          </td>
        </tr>
        <tr>
          <td style="width:200px;"><b>Dokter yang Menjawab</b></td>
          <td style="padding: 5px;">
            {{@baca_dokter(@$emr->dokter_penjawab)}}
          </td>
        </tr>
        <tr>
          <td><b style="color:blue">Alasan Konsul</b></td>
          <td style="padding: 5px;">
            {!!$emr->alasan_konsul!!}
          </td>
        </tr>
        <tr>
          <td><b>Jawab Konsul</b></td>
          <td style="padding: 5px;">
            <textarea rows="5" class="form-control ckeditor" name="jawab_konsul"
              required>Yth. TS. {{$emr ? $emr->jawab_konsul : ''}}</textarea>
          </td>
        </tr>
        <tr>
          <td><b>Anjuran</b></td>
          <td style="padding: 5px;">
            <textarea rows="5" class="form-control ckeditor" name="anjuran"
              required>Yth. TS. {{$emr ? $emr->anjuran : ''}}</textarea>
          </td>
        </tr>
        <tr>
          <td>
            <button type="submit" class="btn btn-primary btn-flat">SIMPAN</button>
          </td>
        </tr>
      </table>
    </div>
  </form>
  </div>
</div>