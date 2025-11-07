
<div class="table-responsive">
  <table class="table table-condensed table-bordered">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Obat</th>
        <th class="text-center">Batch</th>
        <th class="text-center">Penjualan</th>
        {{-- <th class="text-center">Penjualan KRONIS</th> --}}
        <th class="text-center">Retur</th>
        {{-- <th class="text-center">Retur KRONIS</th> --}}
        <th class="text-center">Total</th>
        {{-- <th class="text-center">Total KRONIS</th> --}}
        <th class="text-center" style="width: 15%">Retur</th>
        {{-- <th class="text-center" style="width: 15%">Retur KRONIS</th> --}}
      </tr>
    </thead>
    <tbody>
      @foreach ($detail as $d)
        @php
          $r_detail = $row_detail++;
          $r_kronis = $retur_kronis++;
        @endphp
        <tr>
          <td>{{ $no++ }}</td>
          <td>{{ !empty($d->logistik_batch_id) ? baca_batches($d->logistik_batch_id) :baca_obat($d->masterobat_id) }}</td>
          <td>{{ !empty($d->logistik_batch_id) ? batch($d->logistik_batch_id) : '' }}</td>
          <td class="text-center">{{ $d->jumlah }}</td>
          {{-- <td class="text-center">{{ $d->jml_kronis }}</td> --}}
          <td class="text-center">{{ $d->retur_inacbg }}</td>
          {{-- <td class="text-center">{{ $d->retur_kronis }}</td> --}}
          <td class="text-right">{{ number_format($d->hargajual+$d->uang_racik) }}</td>
          {{-- <td class="text-right">{{ number_format($d->hargajual_kronis) }}</td> --}}
          <td>
            <input type="hidden" name="masterobat_id{{ $row_id++ }}" value="{{ $d->logistik_batch_id }}">
            <input type="hidden" name="detail_id{{ $detail_id++ }}" value="{{ $d->id }}">
            <input type="number" min="0" name="retur{{ $r_detail }}" max="{{ $d->jumlah }}" class="form-control" value="0">
          </td>
          {{-- <td>
            <input type="number" min="0" name="returkronis{{ $r_kronis }}" max="{{ $d->jml_kronis }}" class="form-control" value="0">
          </td> --}}
        </tr>

        <script>
          // validate jumlah
          $(document).on('keyup change',"input[name='retur{{ $r_detail }}']", function(){
            $('#btn-save').prop('disabled', false);
            let maxd{{ $r_detail }} = '{{ $d->jumlah }}';
            if( parseInt(maxd{{ $r_detail }}) < parseInt(this.value) ){
              alert('Retur INCABG Tidak Boleh Lebih Dari '+maxd{{ $r_detail }}+' !!');
              $("input[name='retur{{ $r_detail }}']").val(maxd{{ $r_detail }})
            }else if( parseInt(this.value) < 1 ){
              $('#btn-save').prop('disabled', true);
              alert('Input Tidak Boleh Nol Atau Minus !!');
              return false;
            }
          })
          $(document).on('keyup change',"input[name='returkronis{{ $r_kronis }}']", function(){
            $('#btn-save').prop('disabled', false);
            let maxk{{ $r_kronis }} = '{{ $d->jml_kronis }}';
            if( parseInt(maxk{{ $r_kronis }}) < parseInt(this.value) ){
              alert('Retur KRONIS Tidak Boleh Lebih Dari '+maxk{{ $r_kronis }}+' !!');
              $("input[name='returkronis{{ $r_kronis }}']").val(maxk{{ $r_kronis }})
            }else if( parseInt(this.value) < 1 ){
              $('#btn-save').prop('disabled', true);
              alert('Input Tidak Boleh Nol Atau Minus !!');
              return false;
            }
          })
        </script>

      @endforeach
      <input type="hidden" name="jml" value="{{ $row_id }}">
      <input type="hidden" name="jmlDetail" value="{{ $row_detail }}">
    </tbody>
    <tfoot>
      <tr>
        <th style="text-align: right" colspan="5">Sub Harga</th>
        <th style="text-align: right">{{ number_format($total+$total_uang_racik) }}</th>
      </tr>
      <tr>
        <th style="text-align: right" colspan="5">Jasa</th>
        <th style="text-align: right">{{ !empty($folio->jasa_racik) ? number_format($folio->jasa_racik) : 0 }}</th>
      </tr>
      <tr>
          <th style="text-align: right" colspan="5">Harga Total Retur</th>
          <th style="text-align: right">{{ number_format($total_retur_inacbg) }}</th>
      </tr>
      <tr>
        <th style="text-align: right" colspan="5">Harga Total</th>
        <th style="text-align: right">{{ number_format($total+ (!empty($folio->jasa_racik) ? $folio->jasa_racik : 0)+$total_uang_racik)}}</th>
      </tr>
    </tfoot>
  </table>
</div>