<div class='table-responsive'>
  <table class='table table-striped table-bordered table-hover table-condensed'>
    <thead>
      <tr>
        <th>Nama Pasien</th>
        <th>No. RM</th>
        <th>Alamat</th>
        <th>Status Reg</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>{{ $pasien->nama }}</td>
        <td>{{ $pasien->no_rm }}</td>
        <td>{{ $pasien->alamat }}</td>
        <td>
          @if (substr($registrasi->status_reg,0,1) == 'J')
            Rawat Jalan
          @elseif (substr($registrasi->status_reg,0,1) == 'G')
            Rawat Darurat
          @endif
        </td>
      </tr>
    </tbody>
  </table>
</div>

@if ($folio->count() > 0)
  <div class='table-responsive'>
    <table class='table table-striped table-bordered table-hover table-condensed'>
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Tindakan</th>
          <th>Total</th>
          <th>Klinik</th>
          <th>Pelaksana</th>
          <th>Verif</th>
          <th>Hapus</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($folio as $key => $d)
          @php
            $pelaksana = DB::table('foliopelaksanas')->where('folio_id', $d->id)->first();
          @endphp
          <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $d->namatarif }}</td>
            <td>{{ number_format($d->total) }}</td>
            <td>{{ baca_poli($d->poli_id) }}</td>
            <td>{{ !empty($pelaksana) ? baca_dokter($pelaksana->dokter_pelaksana) : NULL }}</td>
            <td> 
              @if ($d->verif_kasa == 'N')
                <input type="checkbox" name="verif_kasa{{ $baris++ }}" value="{{ $d->id }}">
              @else
                <i class="fa fa-check text-success"></i>
              @endif
               
            </td>
            <td> 
              @if ($d->verif_kasa == 'N')
                <input type="checkbox" name="hapus{{ $baris++ }}" value="{{ $d->id }}">
              @endif
            </td>
          </tr>
        @endforeach
        <input type="hidden" name="jmlbaris" value="{{ $baris }}">
        <input type="hidden" name="registrasi_id" value="{{ $registrasi->id }}">
      </tbody>
      <tfoot>
        <tr>
          <td colspan="5" class="text-right">pilih semua</td>
          <td><input type="checkbox" id="selectAll"/></td>
          <td></td>
        </tr>
      </tfoot>
    </table>
  </div>
@else
  @if (Modules\Registrasi\Entities\Folio::where('registrasi_id', $registrasi->id)->where('verif_rj', 'Y')->count() > 0)
    <h4 class="text-success text-center">Sudah di verifikasi</h4>
  @else
    <h4 class="text-danger text-center">Belum diinput tindakan!!!</h4>
  @endif
@endif

@if ( Modules\Registrasi\Entities\Folio::where('registrasi_id', $registrasi->id)->where('verif_kasa', 'Y')->sum('total') > 0)
  <a href="{{ url('kasir/cetak-verifikasi/'.$registrasi->id) }}" target="_blank" class="btn btn-danger btn-sm btn-flat pull-right"><i class="fa fa-print"></i> CETAK</a>
@endif

<script>
  $('#selectAll').change(function(){
    if(this.checked){
      console.log('checked');
      for(var i = 0; i <= {{ $baris }}; i++) {
        var ksa = 'verif_kasa'+i;
        $('input[name="'+ksa+'"').prop('checked', true);
      }
    }else{
      console.log('unchecked');
      for(var i = 0; i <= {{ $baris }}; i++) {
        var ksa = 'verif_kasa'+i;
        $('input[name="'+ksa+'"').prop('checked', false);
      }
    }
  })
</script>
