@extends('master')
@section('header')
<h1>Master Mapping CONF.RL35</h1>
@endsection

@section('content')

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">
            Data CONF.RL35
        </h3>
        <!-- <a href="{{route('table_conf_rl35')}}" class="btn btn-default btn-flat">
            <i class="fa fa-plus"></i> Rekap Laporan Mapping CONF.RL35 
        </a> -->
    </div>
    <div class="box-body">
        <div >
            <div class='table-responsive'>
                <table id="viewMapping" class='table table-striped table-bordered table-hover table-condensed'>
                    <thead>
                        <tr>
                            {{-- <th>No</th> --}}
                            <th>Nomor</th>
                            <th>Nama Parent</th>
                            <th>Nama</th>
                            {{-- <th>Aksi</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['conf'] as $key => $item)
                            @if($item->parent_id == null)
                                <tr>
                                    {{-- <td>{{ $key+1 }}</td> --}}
                                    <td>{{ $item->nomor }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>
                                        <table>
                                            @foreach( $data['conf']->where('parent_id',$item->id_conf_rl35) as $val)
                                                <tr>
                                                    <td>{{ $val->nama }}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </td>
                                    {{-- <td>-</td> --}}
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>


        </div>

    </div>
</div>

@endsection

@section('script')

@endsection