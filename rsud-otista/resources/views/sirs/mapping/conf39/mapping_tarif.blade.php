@extends('master')

@section('header')
  <h1>Master Mapping CONF.RL39</h1>
@endsection

@section('content')
@php
    session( ['mastermapping_id' => Request::segment(2)])
@endphp
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
           <a href="{{ route('mastermapping_confrl39.index') }}" class="btn btn-default btn-sm btn-flat"> <i class="fa fa-fast-backward"></i> Mapping Config RL.39</a>
      </h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <form class="form-horizontal"  method="post">
                    <div class="form-group">
                        <label for="tahuntarif" class="col-md-4 control-label">Nama Mapping</label>
                        <div class="col-md-8">
                            <select class="form-control" name="mastermappingid" readonly="true">
                                @foreach ($data_mapping as $key => $d)                                   
                                        <option value="{{ $d->id_conf_rl39 }}" selected>{{ $d->kegiatan }}</option>
                                @endforeach
                            </select>
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
                    <div class="form-group hidden" id="katTarif">
                      <label for="kategoritarif" class="col-md-4 control-label">Kategori Tarif</label>
                      <div class="col-md-8">
                        <select class="form-control" name="kategoritarif_id">
                          <option value=""></option>
                          @foreach (Modules\Kategoritarif\Entities\Kategoritarif::whereNotIn('id', ['1','2'])->get() as $d)
                            <option value="{{ $d->id }}">{{ $d->namatarif }}</option>
                          @endforeach
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

    $('select[name="jenis"]').on('change', function(e) {
        e.preventDefault();
        var tahuntarif_id = $('select[name="tahuntarif_id"]').val();
        if( $('select[name="jenis"]').val() == 'TI') {
          $('#katTarif').removeClass('hidden')
          $('#mapping').empty();
          $('select[name="kategoritarif_id"]').on('change', function(e) {
            e.preventDefault();
            // alert( $('select[name="kategoritarif_id"]').val() )
            $('#mapping').load('/data-tarif-mastermapping_confrl39/'+tahuntarif_id+'/'+ $('select[name="jenis"]').val() +'/'+ $('select[name="kategoritarif_id"]').val())
          })
        } else {
          $('#katTarif').addClass('hidden')
          $('#mapping').load('/data-tarif-mastermapping_confrl39/'+tahuntarif_id+'/'+$(this).val())
        }

    });

    function saveMapping() {
        $.ajax({
            url: '{{ route("simpan-conf_rl39") }}',
            type: 'POST',
            dataType: 'json',
            data: $('#formMapping').serialize(),
            success: function (data) {
                console.log(data);
                if(data.sukses == true) {
                    location.reload()
                }
            }
        });

    }

</script>
@endsection
