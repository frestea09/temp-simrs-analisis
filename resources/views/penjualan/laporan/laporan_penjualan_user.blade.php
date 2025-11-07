@extends('master')

@section('header')
    <h1>Laporan Penjualan Obat Berdasarkan User</h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Tanggal&nbsp;&nbsp; </button>
                        </span>
                        {!! Form::text('tga', $tga, ['class' => 'form-control datepicker']) !!}
                        <small class="text-danger">{{ $errors->first('tga') }}</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">S/D&nbsp;&nbsp; </button>
                        </span>
                        {!! Form::text('tgb', $tgb, ['class' => 'form-control datepicker']) !!}
                        <small class="text-danger">{{ $errors->first('tgb') }}</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">USER&nbsp;&nbsp; </button>
                        </span>
                        <select name="user_id" class="form-control select2" id="" style="width: 100%">
                            <option value="" >-- SEMUA --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <input type="submit" name="submit" class="btn btn-primary btn-flat" value="TAMPILKAN" onclick="loadDataTable()">
                    <input type="submit" name="submit" class="btn btn-success btn-flat " value="EXCEL" onclick="excel()">
                </div>
            </div>
           
            <hr/>
            <div class="row" style="margin-top: 40px">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table class="table-hover table-bordered table-condensed table" id="lapPenjualanUser">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama User</th>
                                    <th>Nama Obat</th>
                                    <th>Jumlah</th>
                                    <th>Total Harga (Rp.)</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <script src="/vendor/datatables/buttons.server-side.js"></script>
    <script type="text/javascript">
        $('.select2').select2()
        function loadDataTable(){
            let tga = $('input[name="tga"]').val();
            let tgb = $('input[name="tgb"]').val();
            let user_id = $('select[name="user_id"]').val();
            $("#lapPenjualanUser").DataTable().destroy()
            $('#lapPenjualanUser').DataTable({
                "language": {
                    "url": "/json/pasien.datatable-language.json",
                },
                pageLength: 25,
                autoWidth: false,
                processing: true,
                serverSide: true,
                ordering: false,
                ajax: '/penjualan/laporan-penjualan-user-data?tga=' + tga + '&tgb=' + tgb + '&user_id=' + user_id,
                columns: [
                    {data: 'no'},
                    {data: 'nama_user', name: 'users.name', "searchable": true},
                    {data: 'nama_obat', name: 'masterobats.nama', "searchable": true},
                    {data: 'jumlah'},
                    {data: 'hargajual'},
                ],
            });
        }
        function excel(){
            let tga = $('input[name="tga"]').val();
            let tgb = $('input[name="tgb"]').val();
            let user_id = $('select[name="user_id"]').val();
            window.location.href = '/penjualan/laporan-penjualan-user-data?tga=' + tga + '&tgb=' + tgb + '&user_id=' + user_id + '&submit=' + 'EXCEL';
        }
        loadDataTable();
    </script>
@endsection
