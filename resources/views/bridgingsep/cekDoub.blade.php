@extends('master')
@section('header')
  <h1>Cek Double<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-sm-6">
        </div>
      </div>
      {{-- VIEW DATA --}}
      <div class="row dataKunjungan">
        <div class="col-sm-12">
          <div class="table-responsive">
            <table class="table table-hover table-bordered">
              <thead class="bg-primary">
                <tr>
                  <th class="text-center" style="vertical-align: middle;">ID</th>
                  <th class="text-center" style="vertical-align: middle;">RM</th>
                  {{-- <th class="text-center" style="vertical-align: middle;">Perbarui</th> --}}
                </tr>
              </thead>
              <tbody>
                @if (count($results) > 0)
                    @foreach ($results as $item)
                        <tr>
                          <td>{{$item->id}}</td>
                          <td>{{$item->no_rm}}</td>
                        </tr>
                    @endforeach
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
      {{-- Loading State --}}
      <div class="overlay hidden">
        <i class="fa fa-refresh fa-spin"></i>
      </div>
    <div class="box-footer">

    </div>
  </div>

@endsection

@section('script')
  <script src="{{ asset('js/lz-string/libs/lz-string.js') }}"></script>
  <script type="text/javascript">
    $('.select2').select2();


  </script>
@endsection
