{{-- @if (isset($antrian->nomor))
  {{ !empty($antrian->nomor) ? 'A'.$antrian->nomor : NULL }}
@endif

 --}}
 <style>
    table, th, td {
        border: 1px solid black !important;
    }


 </style>

<!-- DataTables -->
<script src="{{ asset('style') }}/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('style') }}/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
{{-- <link rel="stylesheet" href="{{ asset('style') }}/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css"> --}}


 <p class="text-right">* klik di mana saja, jika suara tidak muncul<br/>
* Jika tgl registrasi berwarna merah, maka penginputan obat dilakukan backdate di EMR Eresep, dan jika diproses, maka kasir harus sesuai tgl registrasi pasien</p>
 <div class="row">
  <div class="col-md-6">
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">No Antrian</th>
          <th scope="col">Lantai</th>
          <th scope="col">No.RM</th>
          <th scope="col">Pasien</th>
          <th scope="col">Informasi</th>
          <th scope="col">Bayar</th>
          @if ($unit !== 'inap')
            <th class="text-center" scope="col">Poli</th>
          @endif
          @if ($unit == 'inap')
            <th class="text-center">Kamar</th>
          @endif
          {{-- <th class="text-center" scope="col">Tgl. Reg</th> --}}
          <th class="text-center" scope="col">Waktu</th>
          <th class="text-center" scope="col">Proses</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($data_belum_diproses as $key=> $item)
          <tr>
            <th scope="row">{{$key+1}}</th>
            <th scope="row" >
                <a class="btn btn-info btn-xs" href="{{url('/farmasi/panggil-antrian/'.$item->id)}}" onclick="return confirm('Yakin akan memanggil nomor antrian {{$item->nomor}}?')"><i class="fa fa-microphone"></i></a>
                {{ @$item->kelompok }}{{$item->nomor}}
            </th>
            <td class="text-left">
              @php
                $loket = @$item->registrasi->poli->kode_loket ?? null;
              @endphp
                @if ($loket === 'B')
                  lt G
                @elseif ($loket === 'C')
                  lt 1
                @else
                  -
                @endif
            </td>
            <td class="text-left">{{@$item->registrasi->pasien->no_rm}}</td>
            <td class="text-left">{{@$item->registrasi->pasien->nama}}
              {{-- @if (@$item->jenis_resep == 'racikan')
                  <span style="color:green">(Ada Racikan)</span>
              @endif --}}
            </td>
            <td class="text-left">
              @if (@$item->jenis_resep == 'tunggal')
                  <span style="color:black">Non Racik</span>
              @elseif (@$item->jenis_resep == 'kronis')
                  <span style="color:red">Kronis</span>
              @else
                  <span style="color:green">{{ucfirst(@$item->jenis_resep)}}</span>
              @endif
            </td>
            <td class="text-left">{{@baca_carabayar($item->registrasi->bayar)}}</td>
            @if ($unit !== 'inap')
            <td>
              @php
                $histori = \App\HistorikunjunganIRJ::where('registrasi_id',@$item->registrasi->id)->orderBy('id','DESC')->first();
              @endphp
              
              @if ($histori)
                {{baca_poli(@$histori->poli_id)}}  
              @else
                {{@$item->registrasi->poli->nama}}
              @endif
            </td>
            @endif
            @if ($unit =='inap')
            @php
              $irna = \App\Rawatinap::where('registrasi_id',@$item->registrasi->id)->first();
            @endphp
            <td>
              @if ($irna)
                {{@baca_kamar(@$irna->kamar_id)}}
              @endif
            </td>
            @endif
            <td style="font-size:12px;">
              {{-- @if (@date('Y-m-d',strtotime($item->registrasi->created_at)) != date('Y-m-d'))
                <span style="color:red">{{@date('d-m-Y',strtotime($item->registrasi->created_at))}}</span>
              @else --}}
                {{@date('d-m-Y',strtotime($item->created_at))}}
              {{-- @endif --}}
            </td>
            <td>
              @if ($item->proses =='belum_diproses')
                <a class="btn btn-warning btn-xs" target="_blank" href="{{url('/penjualan/view-eresep/'.$item->id)}}">Lihat</a>
                
                {{-- <a class="btn btn-success btn-xs" target="_blank" href="{{url('/penjualan/form-penjualan-baru-eresep/'.@$item->registrasi->pasien->id.'/'.$item->registrasi_id.'/'.$item->id)}}" onclick="return confirm('Yakin akan proses pasien ini?')">Proses</a> --}}
                <a class="btn btn-success btn-xs" target="_blank" href="{{url('/penjualannew/form-penjualan-baru-eresep/'.@$item->registrasi->pasien->id.'/'.$item->registrasi_id.'/'.$item->id)}}" onclick="return confirm('Yakin akan proses pasien ini?')">Proses Baru</a>
                {{-- <a class="btn btn-success btn-xs" target="_blank" href="{{url('/penjualan/form-penjualan-baru-eresep/'.$item->pasien_id.'/'.$item->registrasi_id.'/'.$item->id)}}" onclick="return confirm('Yakin akan proses pasien ini?')">Proses</a> --}}
                <a class="btn btn-danger btn-xs" href="{{url('/penjualan/batal-eresep/'.$unit.'/'.$item->id)}}" onclick="return confirm('Yakin akan membatalkan eresep?')">Batalkan</a>
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
    <div class="d-flex justify-content-end mb-2">
      <div class="form-group" style="text-align: left;">
        <label for="filter-lantai" class="d-block"></label>
        <select id="filter-lantai" class="form-control" style="width: 150px; display: inline-block;">
          <option value="">Semua</option>
          <option value="lt G">Lantai G</option>
          <option value="lt 1">Lantai 1</option>
        </select>
      </div>
    </div>
    <table class="table-bordered table-striped" id="eresep-sudah-dipanggil" style="width: 100%;">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">No Antrian</th>
          <th scope="col">Lantai</th>
          <th scope="col">No.RM</th>
          <th scope="col">Pasien</th>
          <th scope="col">Bayar</th>
          @if ($unit == 'inap')
            <th class="text-center" scope="col">Kamar</th>
          @else
            <th class="text-center" scope="col">Poli</th>
          @endif
          {{-- <th class="text-center" scope="col">Tgl. Reg</th> --}}
          <th class="text-center" scope="col">Waktu</th>
          <th class="text-center" scope="col">Proses</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($data_sudah_diproses as $key=> $item)
          <tr>
            <th scope="row" style="padding: .3rem;">{{$key+1}}</th>
            <th scope="row" style="padding: .3rem;" >
                <a class="btn btn-info btn-xs" href="{{url('/farmasi/panggil-antrian/'.$item->id)}}" onclick="return confirm('Yakin akan memanggil nomor antrian {{$item->nomor}}?')"><i class="fa fa-microphone"></i></a>
                {{ @$item->kelompok }}{{$item->nomor}}
            </th>
            <td style="text-align: center;">
              @php
                $loket = @$item->registrasi->poli->kode_loket ?? null;
              @endphp
                @if ($loket === 'B')
                  lt G
                @elseif ($loket === 'C')
                  lt 1
                @else
                  -
                @endif
            </td>
            <td class="text-left" style="padding: .3rem;"><a style="color:black" target="_blank" href="{{url('/penjualannew/form-penjualan-baru-eresep/'.@$item->registrasi->pasien->id.'/'.$item->registrasi_id.'/'.$item->id)}}" onclick="return confirm('Yakin akan proses ulang pasien ini?')">{{@$item->registrasi->pasien->no_rm}}</a></td>
            <td class="text-left" style="padding: .3rem;">{{@$item->registrasi->pasien->nama}}</td>
            <td class="text-left" style="padding: .3rem;">{{@baca_carabayar($item->registrasi->bayar)}}</td>
            <td style="padding: .3rem;">
              @if ($unit == 'inap')
                @php
                  $irna = \App\Rawatinap::where('registrasi_id',@$item->registrasi->id)->first();
                @endphp
                @if ($irna)
                  {{@baca_kamar(@$irna->kamar_id)}}
                @endif
              @else
                @php
                  $histori = \App\HistorikunjunganIRJ::where('registrasi_id',@$item->registrasi->id)->orderBy('id','DESC')->first();
                @endphp
                @if ($histori)
                  {{baca_poli(@$histori->poli_id)}}  
                @else
                  {{@$item->registrasi->poli->nama}}
                @endif
              @endif
            </td>
            <td style="font-size:12px; padding: .3rem;">
              {{-- @if (@date('Y-m-d',strtotime($item->registrasi->created_at)) != date('Y-m-d'))
                <span style="color:red">{{@date('d-m-Y',strtotime($item->registrasi->created_at))}}</span>
              @else --}}
                {{@date('d-m-Y',strtotime($item->created_at))}}
              {{-- @endif --}}
            </td>
            <td style="padding: .3rem;">
              @if ($item->proses =='belum_diproses')
                <a class="btn btn-warning btn-xs" target="_blank" href="{{url('/penjualan/view-eresep/'.$item->id)}}">Lihat</a>
                <a class="btn btn-success btn-xs" target="_blank" href="{{url('/penjualan/form-penjualan-baru-eresep/'.$item->pasien_id.'/'.$item->registrasi_id.'/'.$item->id)}}" onclick="return confirm('Yakin akan proses pasien ini?')">Proses</a>
                <a class="btn btn-danger btn-xs" href="{{url('/penjualan/batal-eresep/'.$item->id)}}" onclick="return confirm('Yakin akan membatalkan eresep?')">Batalkan</a>
                  {{-- <a class="btn btn-success btn-xs" href="{{url('/farmasi/proses-eresep/'.$item->id)}}" onclick="return confirm('Yakin akan proses pasien ini?')">Proses</a> --}}
              @elseif($item->proses == 'dibatalkan')
              <label for="" class="text-danger">Dibatalkan</label>
              @else
                  <b><a class="text-success" target="_blank" href="{{url('/penjualan/view-eresep/'.$item->id)}}">Diproses</a></b>
                  {{-- <label for="" class="text-success">Diproses</label> --}}
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
        // DB::table('resep_note')->where('id', $item->id)->update(['notif_play' => '1']);
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

    // var table = $('#eresep-sudah-dipanggil').DataTable({
    //   'language'    : {
    //     "url": "/json/pasien.datatable-language.json",
    //   },
    //   'paging'      : true,
    //   'lengthChange': false,
    //   'searching'   : true,
    //   'ordering'    : true,
    //   'info'        : true,
    //   'autoWidth'   : false
    // });

    

    // Filter Lantai
    // $('#filter-lantai').on('change', function () {
    //   var selected = $(this).val();
    //   localStorage.setItem('filterLantai', selected);
    //   if (selected) {
    //     table.column(2).search('^' + selected + '$', true, false).draw();
    //   } else {
    //     table.column(2).search('').draw();
    //   }
    // });

  </script> 
  <script type="text/javascript">
$(document).ready(function() {
    var savedPage = localStorage.getItem('eresep_current_page');

    var table = $('#eresep-sudah-dipanggil').DataTable({
        'language'    : {
            "url": "/json/pasien.datatable-language.json",
        },
        'paging'      : true,
        'lengthChange': false,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false
    });

    // restore halaman terakhir SETELAH render
    if (savedPage !== null) {
        setTimeout(function() {
            table.page(parseInt(savedPage)).draw('page');
        }, 100); // delay 100ms agar table selesai init dulu
    }

    // simpan halaman setiap pindah
    table.on('page.dt', function() {
        var info = table.page.info();
        localStorage.setItem('eresep_current_page', info.page);
    });

    // filter lantai (optional)
    $('#filter-lantai').on('change', function () {
        var selected = $(this).val();
        localStorage.setItem('filterLantai', selected);
        if (selected) {
            table.column(2).search('^' + selected + '$', true, false).draw();
        } else {
            table.column(2).search('').draw();
        }
    });

    var savedFilter = localStorage.getItem('filterLantai');
    if (savedFilter) {
        $('#filter-lantai').val(savedFilter).trigger('change');
    }
});
</script>

  