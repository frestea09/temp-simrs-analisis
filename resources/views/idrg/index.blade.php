@extends('master')

@section('header')
  <h1>Idrg Tarif INACBG</h1>
@endsection

@section('content')
@php
    session( ['masteridrg_id' => Request::segment(2)])
@endphp
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
           <a href="{{ url('masteridrg') }}" class="btn btn-default btn-sm btn-flat"> <i class="fa fa-fast-backward"></i> Master Idrg</a>
      </h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <form class="form-horizontal"  method="post">
                    <div class="form-group">
                        <label for="tahuntarif" class="col-md-4 control-label">Nama Idrg</label>
                        <div class="col-md-8">
                            <select class="form-control" name="masteridrgid" readonly="true">
                                @foreach (App\Masteridrg::select('id', 'idrg')->get() as $key => $d)
                                    @if ($d->id == Request::segment(2))
                                        <option value="{{ $d->id }}" selected>{{ $d->idrg }}</option>
                                    @endif
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
                                <option value="TA">Semua</option>
                                {{-- <option value="TG">Rawat Darurat</option> --}}
                                {{-- <option value="TI">Rawat Inap</option> --}}
                            </select>
                        </div>
                    </div>
                    {{-- <div class="form-group hidden" id="katTarif">
                      <label for="kategoritarif" class="col-md-4 control-label">Kategori Tarif</label>
                      <div class="col-md-8">
                        <select class="form-control" name="kategoritarif_id">
                          <option value=""></option>
                          @foreach (Modules\Kategoritarif\Entities\Kategoritarif::all() as $d)
                            <option value="{{ $d->id }}">{{ $d->namatarif }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div> --}}
                </form>
            </div>
        </div>
        <br>
        <div id="idrg"></div>

    </div>
  </div>


@endsection

@section('script')
<script type="text/javascript">

    $('select[name="jenis"]').on('change', function(e) {
        e.preventDefault();
        var tahuntarif_id = $('select[name="tahuntarif_id"]').val();
        // if( $('select[name="jenis"]').val() == 'TI') {
        //   $('#katTarif').removeClass('hidden')
        //   $('#idrg').empty();
        //   $('select[name="kategoritarif_id"]').on('change', function(e) {
        //     e.preventDefault();
        //     // alert( $('select[name="kategoritarif_id"]').val() )
        //     $('#idrg').load('/data-tarif-idrg/'+tahuntarif_id+'/'+ $('select[name="jenis"]').val() +'/'+ $('select[name="kategoritarif_id"]').val())
        //   })
        // } else {
          $('#katTarif').addClass('hidden')
          $('#idrg').load('/data-tarif-idrg/'+tahuntarif_id+'/'+$(this).val())
        // }

    });

    function saveIdrg() {
        $.ajax({
            url: '{{ route('simpan-idrg') }}',
            type: 'POST',
            dataType: 'json',
            data: $('#formIdrg').serialize(),
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
