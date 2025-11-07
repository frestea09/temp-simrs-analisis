<h4>
<div class='table-responsive'>
  <table class='table table-bordered table-condensed'>
    <thead>
      <tr class="bg-primary">
        <th class="text-center">No</th>
        <th>Kelas</th>
        <th>Total Kamar</th>
        <th>Kamar</th>
        <th class="text-center">Kapasitas</th>
        <th class="text-center">Terisi</th>
        <th class="text-center">Kosong</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($kelas as $kl)
        @php
          $kamar = Modules\Bed\Entities\Bed::select('kamar_id')->where('virtual','N')->where('kelas_id', $kl->id)->distinct()->get();
          $jumlah_kamar = Modules\Bed\Entities\Bed::select('kamar_id')->where('virtual','N')->where('kelas_id', $kl->id)->where('kamar_id', '!=', null)->where('kelas_id', '!=', null)->get();
        @endphp
        <tr>
          @if ($jumlah_kamar->count() != 0)
          <td rowspan="{{ $kamar->count() + 1 }}" class="text-center">{{ $no++ }}</td>
          <td rowspan="{{ $kamar->count() + 1 }}">{{ $kl->nama }}</td>
          <td rowspan="{{ $kamar->count() + 1 }}">{{ $jumlah_kamar->count() }}</td>
          @endif
          @foreach ($kamar as $km)
            @php
              $total = Modules\Bed\Entities\Bed::where('kelas_id', $kl->id)->where('kamar_id', $km->kamar_id)->count();
              $isi = Modules\Bed\Entities\Bed::where('kelas_id', $kl->id)->where('kamar_id', $km->kamar_id)->where('reserved', 'Y')->count();
              $kosong = Modules\Bed\Entities\Bed::where('kelas_id', $kl->id)->where('kamar_id', $km->kamar_id)->where('reserved', 'N')->count();
              if($kosong === 0){
                  $class = 'danger';
              } elseif ($kosong <= 2) {
                  $class = 'warning';
              } elseif ($kosong == $total || $kosong > 2) {
                  $class = 'success';
              }
            @endphp
            <tr class="{{ $class }}">
              <td>{{ baca_kamar($km->kamar_id) }}</td>
              <td class="text-center">{{ $total }}</td>
              <td class="text-center">{{ $isi }}</td>
              <td class="text-center">{{ $kosong }}</td>
            </tr>
          @endforeach
        </tr>
      @endforeach
    </tbody>
  </table>
  {{-- <table class='table table-bordered table-condensed'>
    <thead>
      <tr class="bg-primary">
        <th class="text-center">No</th>
        <th>Kamar</th>
        <th>Jumlah</th>
      </tr>
    </thead>
    <tbody>
        <tr>
          <td class="text-center">1</td>
          <td class="">Kelas VVIP</td>
          <td class="">{{ $vvip }}</td>
        </tr>
        <tr>
          <td class="text-center">2</td>
          <td class="">Kelas VIP</td>
          <td class="">{{ $vip }}</td>
        </tr>
        <tr>
          <td class="text-center">3</td>
          <td class="">Kelas 1</td>
          <td class="">{{ $kelas1 }}</td>
        </tr>
        <tr>
          <td class="text-center">4</td>
          <td class="">Kelas 2</td>
          <td class="">{{ $kelas2 }}</td>
        </tr>
        <tr>
          <td class="text-center">5</td>
          <td class="">Kelas 3</td>
          <td class="">{{ $kelas3 }}</td>
        </tr>
        <tr>
          <td class="text-center">6</td>
          <td class="">Kelas ISOLASI</td>
          <td class="">{{ $iso }}</td>
        </tr>
        <tr>
          <td class="text-center">7</td>
          <td class="">Kelas HCU</td>
          <td class="">{{ $hcu }}</td>
        </tr>
        <tr>
          <td class="text-center">8</td>
          <td class="">Perinatologi</td>
          <td class="">{{ $perina }}</td>
        </tr>
        <tr>
          <td colspan="2" class="text-right"> <b> Total Kamar </b></td>
          <td class=""> <b> {{ $totalbed }} </b></td>
        </tr>
    </tbody>
  </table> --}}
  
</div>
</h4>
