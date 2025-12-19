{{-- @if (isset($antrian->nomor))
  {{ !empty($antrian->nomor) ? 'A'.$antrian->nomor : NULL }}
@endif

 --}}
 <style>
    table, th, td {
        border: 1px solid black !important;
    }
 </style>
 <p class="text-right">* klik di mana saja, jika suara tidak muncul</p>
 <div class="row">
  <div class="col-md-6">
    <table class="table table-bordered table-striped" id="data">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">No.RM</th>
          <th scope="col">Pasien</th>
          <th scope="col">Bayar</th>
          <th class="text-center" scope="col">Poli</th>
          <th class="text-center" scope="col">Waktu</th>
          <th class="text-center" scope="col">Proses</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($data_belum_diproses as $key=> $item)
          <tr>
            <th scope="row">{{$key+1}}</th>
            <td class="text-left">{{@$item->registrasi->pasien->no_rm}}</td>
            <td class="text-left">{{@$item->registrasi->pasien->nama}}</td>
            <td class="text-left">{{@baca_carabayar($item->registrasi->bayar)}}</td>
            <td>{{@$item->registrasi->poli->nama}}</td>
            <td style="font-size:10px;">{{@date('d-m-Y H:i',strtotime($item->created_at))}}</td>
            <td>
              @if ($item->proses =='diproses' && $item->is_validate == '1')
                {{-- <a class="btn btn-warning btn-xs" target="_blank" href="{{url('/penjualan/view-eresep/'.$item->id)}}">Lihat</a> --}}
                <a class="btn btn-primary btn-xs" target="_blank" href="{{url('/penjualan/form-penjualan-baru-eresep/'.$item->pasien_id.'/'.$item->registrasi_id.'/'.$item->id.'/'.$item->penjualan_id)}}">Finalisasi</a>
                {{-- <a class="btn btn-danger btn-xs" href="{{url('/penjualan/batal-eresep/'.$item->id)}}" onclick="return confirm('Yakin akan membatalkan eresep?')">Batalkan</a> --}}
                  {{-- <a class="btn btn-success btn-xs" href="{{url('/farmasi/proses-eresep/'.$item->id)}}" onclick="return confirm('Yakin akan proses pasien ini?')">Proses</a> --}}
              @elseif($item->proses == 'dibatalkan')
              <label for="" class="text-danger">Dibatalkan</label>
              @else
                  <label for="" class="text-success">{{ucfirst($item->proses)}}</label>
              @endif
            </td>
          </tr> 
          @endforeach
      </tbody>
    </table>
  
  </div>

  <div class="col-md-6">
    <table class="table table-bordered table-striped" id="data">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">No.RM</th>
          <th scope="col">Pasien</th>
          <th scope="col">Bayar</th>
          <th class="text-center" scope="col">Poli</th>
          <th class="text-center" scope="col">Waktu</th>
          <th class="text-center" scope="col">Proses</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($data_sudah_diproses as $key=> $item)
          <tr>
            <th scope="row">{{$key+1}}</th>
            <td class="text-left">{{@$item->registrasi->pasien->no_rm}}</td>
            <td class="text-left">{{@$item->registrasi->pasien->nama}}</td>
            <td class="text-left">{{@baca_carabayar($item->registrasi->bayar)}}</td>
            <td>{{@$item->registrasi->poli->nama}}</td>
            <td>{{@date('d-m-Y H:i',strtotime($item->created_at))}}</td>
            <td>
              @if ($item->proses =='belum_diproses')
                <a class="btn btn-warning btn-xs" target="_blank" href="{{url('/penjualan/view-eresep/'.$item->id)}}">Lihat</a>
                <a class="btn btn-success btn-xs" target="_blank" href="{{url('/penjualan/form-penjualan-baru-eresep/'.$item->pasien_id.'/'.$item->registrasi_id.'/'.$item->id)}}" onclick="return confirm('Yakin akan proses pasien ini?')">Proses</a>
                <a class="btn btn-danger btn-xs" href="{{url('/penjualan/batal-eresep/'.$item->id)}}" onclick="return confirm('Yakin akan membatalkan eresep?')">Batalkan</a>
                  {{-- <a class="btn btn-success btn-xs" href="{{url('/farmasi/proses-eresep/'.$item->id)}}" onclick="return confirm('Yakin akan proses pasien ini?')">Proses</a> --}}
              @elseif($item->proses == 'dibatalkan')
              <label for="" class="text-danger">Dibatalkan</label>
              @else
                  <label for="" class="text-success">{{ucfirst($item->proses)}}</label>
              @endif
            </td>
          </tr> 
          @endforeach
      </tbody>
    </table>
  
  </div>
 </div>
 
  @foreach ($belum_diproses as $item)

    @php
        DB::table('resep_note')->where('id', $item->id)->update(['notif_play' => '1']);
    @endphp
    <audio id="notif" preload class="notif">
        <source src="/audio/notif.mp3" type="audio/mpeg" />
    </audio>
  @endforeach
  {{-- @if (count($belum_diproses) > 0)
  @endif --}}

  <script type="text/javascript">
    $(document).ready(function() { 
       

        var audioArray = document.getElementsByClassName('notif');
        var i = 0;
        if(audioArray.length !== 0){
            audioArray[i].play();
            for (i = 0; i < audioArray.length - 1; ++i) {
                audioArray[i].addEventListener('ended', function(e){
                  var currentSong = e.target;
                  var next = $(currentSong).nextAll('audio');
                  if (next.length) $(next[0]).trigger('play');
                });
            } 
        }
 
    });

  </script> 

  