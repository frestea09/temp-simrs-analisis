@extends('master')
@section('header')
  <h1>Master Obat </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Ubah Master Obat &nbsp;
          <a href="{{ route('masterobat.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
        {!! Form::model($masterobat, ['route' => ['masterobat.update', $masterobat->id], 'method' => 'PUT', 'class'=>'form-horizontal']) !!}

          @include('masterobat._form')

        {!! Form::close() !!}

      </div>
    </div>
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data Obat Batch &nbsp;
        </h3>
      </div>
      <div class="box-body">
        <table class="table table-striped table-bordered" id="data" style="font-size:12px;">
          <thead>
            <tr>
              <th rowspan="2">No</th>
              <th rowspan="2">No Batch</th>
              <th rowspan="2">Expired</th>
              <th colspan="4" class="text-center">Harga</th>
              <th rowspan="2">Tgl. Penerimaan</th>
              <th rowspan="2">Gudang</th>
              <th rowspan="2">Supplier</th>
              <th rowspan="2">Edit</th>
            </tr>
            <tr>
              <th>Beli</th>
              <th>Jual Umum</th>
              <th>Jual JKN</th>
              <th>Jual Kesda</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($batch as $key=>$item)
              <tr>
                <td>{{$key+1}}</td>
                <td>{{$item->nomorbatch}}
                  @if ($item->bapb_id)
                    <br/>
                      (<span style="color:green">Faktur</span> : {{$item->bapb->no_faktur}})
                  @endif
                </td>
                <td>{{date('d-m-Y',strtotime($item->expireddate))}}</td>
                <td>{{number_format($item->hargabeli)}}</td>
                <td>{{number_format($item->hargajual_umum)}}</td>
                <td>{{number_format($item->hargajual_jkn)}}</td>
                <td>{{number_format($item->hargajual_dinas)}}</td>
                <td>{{date('d-m-Y',strtotime($item->created_at))}}</td>
                <td>{{@baca_gudang_logistik($item->gudang_id)}}</td>
                <td>{{@$item->supplier->nama}}</td>
                <td><a href="{{ url('masterobat/'.$item->id.'/editbatch') }}" class="btn btn-success btn-md"><i class="fa fa-edit"></i></a></td>
              </tr>
                
            @endforeach
          </tbody>
        </table>

      </div>
      

    </div>
@stop


@section('script')

<script type="text/javascript">
  $('.select2').select2();
  $(".satuans").select2({
    tags: true
  });
</script>


@endsection