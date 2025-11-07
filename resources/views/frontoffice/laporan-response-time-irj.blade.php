@extends('master')
@section('header')
    <h1>Farmasi - Response Time Rawat Jalan</h1>
@endsection


@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
        </div>
        <div class="box-body">
            {!! Form::open(['method' => 'POST', 'url' => '/frontoffice/laporan/response-time-irj', 'class'=>'form-hosizontal']) !!}
            <div class="row">
                <div clas="col-md-12">
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
                                <button class="btn btn-default" type="button">POLI&nbsp;&nbsp; </button>
                            </span>
                            <select name="poli_id" class="form-control select2" style="width: 100%">
                                <option value="" selected>[Semua Poli]</option>
                                @foreach ($poli as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="button" name="tampil" class="btn btn-primary btn-flat fa-file-pdf"
                                    value="TAMPILKAN" onclick="loadDataTable()">
                                <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o"
                                    value="EXCEL">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
            <hr />

            @if (isset($respon) && !empty($respon))
                <b>Periode : Tgl {{ $tga }} s/d {{ $tgb }}</b>
            @endif
            <br /><br />
            <div class='table-responsive'>
                <table class='table-striped table-bordered table-hover table-condensed table' id='responseTimeIRJ'>
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">No.RM</th>
                            <th class="text-center">Nama Pasien</th>
                            <th class="text-center">Jenis</th>
                            <th class="text-center">Poli</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Chek In</th>
                            <th class="text-center">Registrasi</th>
                            <th class="text-center">Cetak SEP</th>
                            <th class="text-center">Masuk Poli</th>
                            <th class="text-center">Proses Poli</th>
                            <th class="text-center">E Resep</th>
                            <th class="text-center">Tunggu Pendaftaran</th>
                            <th class="text-center">Tunggu Poli</th>
                            <th class="text-center">Lama Pelayanan</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div>
                <ul>
                    <li><strong>Check In</strong> : Ketike tiket antrian pendaftaran di cetak</li>
                    <li><strong>Registrasi</strong> : Ketika tombol panggil antrian pendaftaran ditekan</li>
                    <li><strong>Masuk Poli</strong> : Ketika tombol panggil antrian poli di tekan</li>
                    <li><strong>Proses Poli</strong> : Ketika CPPT atau Asesmen di isi</li>
                    <li><strong>E Resep</strong> : Ketika E Resep diisi</li>
                    <li><strong>Tunggu Pendaftaran</strong> : Checkin s/d Registrasi</li>
                    <li><strong>Tunggu Poli</strong>: Registrasi s/d Masuk Poli</li>
                    <li><strong>Lama Pelayanan</strong>: Checkin s/d E Resep atau jika E Resep tidak diisi maka s/d Proses Poli</li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('.select2').select2()
        function loadDataTable(){
            let tga = $('input[name="tga"]').val();
            let tgb = $('input[name="tgb"]').val();
            let poli_id = $('select[name="poli_id"]').val();
            $("#responseTimeIRJ").DataTable().destroy()
            $('#responseTimeIRJ').DataTable({
                "language": {
                    "url": "/json/pasien.datatable-language.json",
                },
                pageLength: 10,
                autoWidth: false,
                processing: true,
                serverSide: true,
                ordering: false,
                ajax: '/frontoffice/laporan/response-time-irj-data?tga=' + tga + '&tgb=' + tgb + '&poli_id=' + poli_id,
                columns: [
                    {data: 'no'},
                    {data: 'no_rm', name: 'pasiens.no_rm', "searchable": true},
                    {data: 'nama', name: 'pasiens.nama', "searchable": true},
                    {data: 'cara_regis'},
                    {data: 'poli', name: 'polis.nama', "searchable": true},
                    {data: 'tanggal',  name: 'registrasis.created_at'},
                    {data: 'checkin',  name: 'antrians.created_at'},
                    {data: 'start_regis',  name: 'antrians.updated_at'},
                    {data: 'cetak_sep'},
                    // {data: 'regis',  name: 'registarasis.created_at'},
                    {data: 'enter_poli',  name: 'antrian_poli.updated_at'},
                    {data: 'proses_poli'},
                    {data: 'eresep',  name: 'antrian_poli.updated_at'},
                    {data: 'tunggu_pendaftaran'},
                    {data: 'tunggu_poli'},
                    {data: 'lama_pelayanan'},
                ]
            });
        }
        loadDataTable();

    </script>
@endsection
