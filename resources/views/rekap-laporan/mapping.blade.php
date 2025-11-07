@extends('master')

@section('header')
  <h1>Mapping Tarif</h1>
@endsection

@section('content')
{{-- @php
    session( ['mastermapping_id' => Request::segment(2)])
@endphp --}}
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
           <a href="{{ url('rekap-laporan/'.Request::segment(2)) }}" class="btn btn-default btn-sm btn-flat"> <i class="fa fa-fast-backward"></i> Master Mapping</a>
      </h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <form class="form-horizontal"  method="post">
                    <div class="form-group">
                        <label for="tahuntarif" class="col-md-4 control-label">Nama Mapping</label>
                        <div class="col-md-8">
                            <input type="hidden" name="rl33_id" value="{{ $data['mapping']->id }}">
                            <input type="text" name="nama" class="form-control" value="{{ $data['mapping']->nama }}" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tahuntarif" class="col-md-4 control-label">Tahun Tarif</label>
                        <div class="col-md-8">
                            <select class="form-control" name="tahuntarif_id">
                                @foreach (Modules\Config\Entities\Tahuntarif::select('id', 'tahun')->get() as $key => $d)
                                    @if ($d->id == configrs()->tahuntarif)
                                        <option value="{{ $d->id }}" selected>{{ $d->tahun }}</option>
                                    @else
                                        <option value="{{ $d->id }}">{{ $d->tahun }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="jenis" class="col-md-4 control-label">Jenis Perawatan</label>
                        <div class="col-md-8">
                            <select class="form-control" name="jenis">
                                <option value="">[Pilih jenis perawatan]</option>
                                <option value="TA">Rawat Jalan</option>
                                <option value="TG">Rawat Darurat</option>
                                <option value="TI">Rawat Inap</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <br>
        <div id="mapping"></div>

    </div>
  </div>


@endsection

@section('script')
<script type="text/javascript">
    let type = "{{ Request::segment(2) }}";
    $('select[name="jenis"]').on('change', function(e) {
        e.preventDefault();
        var tahuntarif_id = $('select[name="tahuntarif_id"]').val();
        var rl33_id = $('input[name="rl33_id"]').val();
        // if( $('select[name="jenis"]').val() == 'TI') {
        //   $('#katTarif').removeClass('hidden')
        //   $('#mapping').empty();
        //   $('select[name="kategoritarif_id"]').on('change', function(e) {
        //     e.preventDefault();
        //     // alert( $('select[name="kategoritarif_id"]').val() )
        //     $('#mapping').load('/data-tarif-mapping/'+tahuntarif_id+'/'+ $('select[name="jenis"]').val() +'/'+ $('select[name="kategoritarif_id"]').val())
        //   })
        // } else {
        //   $('#katTarif').addClass('hidden')
          $('#mapping').load('/rekap-laporan/data-tarif/'+type+'/'+rl33_id+'/'+tahuntarif_id+'/'+$(this).val())
        // }

    });

    function saveMapping() {
        $.ajax({
            url: '{{ url("rekap-laporan/save-mapping") }}',
            type: 'POST',
            dataType: 'json',
            data: $('#formMapping').serialize(),
            success: function (data) {
                if(data.sukses == true) {
                    location.reload()
                }
            }
        });

    }

</script>
@endsection
