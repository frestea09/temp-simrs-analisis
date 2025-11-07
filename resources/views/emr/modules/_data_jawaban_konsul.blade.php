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
        {{-- <tr>
          <td><b>Tanggal dan Jam Jawab</b></td>
          <td style="padding: 5px;">
            <div class="row">
              <div class="col-md-7"><input type="date" name="tanggal" class="form-control"
                  value="{{@$emr->tanggal ? @$emr->tanggal : date('Y-m-d') }}" readonly></div>
              <div class="col-md-5"><input type="time" name="waktu" class="form-control"
                  value="{{@$emr->waktu ? @$emr->waktu : date('H:i')}}" readonly></div>
            </div>


          </td>
        </tr> --}}
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
      </table>
      <span><i>Untuk memperbarui jawaban konsul</i></span>
        <ol>
          <li>Klik tombol <i>Edit</i> terlebih dahulu</li>
          <li>Kemudian rubah jawaban / anjuran</li>
          <li>Jika sudah selesai, klik tombol selesai</li>
        </ol>
      <table style="width:100%; font-size:12px; border:1px solid black; border-collapse:collapse;" cellspacing="0" cellpadding="3">
          <tr>
              <th style="border:1px solid black; text-align:center;">No</th>
              <th style="border:1px solid black; text-align:center;">Jawaban Konsul</th>
              <th style="border:1px solid black; text-align:center;">Anjuran</th>
              <th style="border:1px solid black; text-align:center;">Waktu</th>
              <th style="border:1px solid black; text-align:center;">Aksi</th>
          </tr>
          @foreach ($data_jawaban as $key=>$item)
              <tr>
                  <td style="border:1px solid black; text-align:center;">{{$key+1}}</td>
                  <td style="border:1px solid black; text-align:center;">
                      <textarea style="width: 100%;" name="jawaban_{{$item->id}}" class="jawaban_{{$item->id}}" rows="10" readonly>{!!$item->jawab_konsul!!}</textarea>
                  </td>
                  <td style="border:1px solid black; text-align:center;">
                      <textarea style="width: 100%;" name="anjuran_{{$item->id}}" class="jawaban_{{$item->id}}" rows="10" readonly>{!!$item->anjuran!!}</textarea>
                  </td>
                  <td style="border:1px solid black; text-align:center;">
                      {{date('d-m-Y',strtotime($item->tanggal))}}, {{$item->waktu}}
                  </td>
                  <td style="border:1px solid black; text-align:center;">
                      @if (Auth::user()->id == $item->user_id)
                          <button type="button" class="btn btn-flat btn-sm btn-danger" onclick="hapusJawaban({{$item->id}})">Hapus</button>
                          <button type="button" class="btn btn-flat btn-sm btn-warning" onclick="toggleReadonly(this, {{$item->id}})">Edit</button>
                      @endif
                  </td>
              </tr>
          @endforeach
      </table>
      
    </div>
  </form>
  </div>
</div>