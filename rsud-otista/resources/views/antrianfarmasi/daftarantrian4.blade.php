@extends('master')

@section('header')
    <h1>Farmasi - Daftar Antrian Racikan </h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
                Data Antrian Hari Ini &nbsp;
            </h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    <div id="daftarantrian"></div>
                </div>
                {{-- ============================ --}}
                <div class="col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Sudah di panggil</h3>
                        </div>
                        <div class="panel-body">
                            <div class='table-responsive'>
                                <table class='table-striped table-bordered table-hover table-condensed table'
                                    id="dataAntrian">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Antrian</th>
                                            <th>Cetak Tiket</th>
                                            <th>RM | Nama Pasien</th>
                                            <th>Proses</th>
                                            <th>Selesai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($terpanggil as $key => $d)
                                        <tr>
                                            <td class="text-center">
                                                @if ($d->status <= 2 || $d->finished_at == null)
                                                    <a href="{{ route('antrianfarmasi.panggilkembali4', $d->id) }}"
                                                        class="btn btn-info btn-sm btn-flat"><i
                                                            class="fa fa-microphone"></i>
                                                    </a>
                                                @else
                                                    <a disabled class="btn btn-info btn-sm btn-flat"><i
                                                            class="fa fa-microphone"></i>
                                                    </a>
                                                @endif
                                                {{ $d->kelompok }}{{ $d->nomor }}
                                            </td>
                                            <td>{{ date('H:i', strtotime($d->created_at)) }}</td>
                                            @if($d->registrasi_id != null)
                                                <td style="text-overflow: ellipsis">
                                                        <strong>{{$d->registrasi->pasien->no_rm}} | </strong>
                                                        <span>{{$d->registrasi->pasien->nama}}</span>
                                                </td>
                                                <td >
                                                    @if($d->finished_at == null)
                                                        <a target="_blank" href="{{ url('penjualan/form-penjualan-baru/' . $d->registrasi->pasien->id . '/' . $d->registrasi->id) }}" class="btn btn-success btn-flat btn-sm">
                                                            <i class="fa fa-registered"></i> Proses
                                                        </a>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($d->finished_at == null)
                                                        <a href="{{ route('antrianfarmasi.panggilselesai', $d->id) }}"
                                                            class="btn btn-info btn-sm btn-flat"><i
                                                                class="fa fa-microphone"></i>
                                                        </a>
                                                    @else
                                                        <a target="_blank" class="btn btn-success btn-flat btn-sm">
                                                            <i class="fa fa-check"></i> SELESAI
                                                        </a>
                                                    @endif
                                                </td>
                                            @else
                                                <td style="text-overflow: ellipsis">
                                                    <button class="btn btn-warning btn-flat btn-sm" onclick="openModal({{$d->id}})">Input Pasien</button>
                                                </td>
                                                <td >-</td>
                                                <td>-</td>
                                                
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="panel-footer">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalInputPasien">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Cari Pasien</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="formPulang" method="POST">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="hidden" name="antrian_id">
                                <select name="reg_id" class="form-control" id="pasienSelect" style="width: 100%">
                                    <option value="" disabled selected>Cari berdasarkan NO RM atau Nama Pasien
                                    </option>
                                </select>
                                <small class="text-muted">
                                    <i>
                                        Pencarian hanya menampilkan pasien yang terdaftar hari ini
                                    </i>
                                </small>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary btn-flat" onclick="saveAntrianPasien()">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery 3 -->
    <script src="{{ asset('style') }}/bower_components/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#dataAntrian').DataTable({
                "language": {
                    "url": "/json/pasien.datatable-language.json",
                },
                "order": [[0, 'desc']],
                pageLength: 10,
                autoWidth: false,
                processing: true,
            });
            $('#daftarantrian').load("{{ route('antrianfarmasi.daftarpanggil4') }}");
            setInterval(function() {
                $('#daftarantrian').load("{{ route('antrianfarmasi.daftarpanggil4') }}");
            }, 2000);

            $('#pasienSelect').select2({
                ajax: {
                    url: '/antrian-farmasi/ajaxPasien',
                    dataType: 'json',
                    delay: 100, 
                    // data: (params) => q: params.term,
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (pasien) {
                                return {
                                    id: pasien.registrasi_id,
                                    text: 'RM: ' +  pasien.no_rm + ' | ' + pasien.nama
                                };
                            })
                        };
                    },
                    cache: true 
                },
            });

        });
        function openModal(id){
            $('#modalInputPasien').modal('show');
            $('input[name="antrian_id"]').val(id);
        }
        function saveAntrianPasien(){
            let antrian_id = $('input[name="antrian_id"]').val();
            let reg_id = $('select[name="reg_id"]').val();
            $.ajax({
                url: '/antrian-farmasi/insert-reg/' + reg_id + '/' + antrian_id, 
                method: 'GET',
                success: function (data) {
                    location.reload();
                },
                error: function (xhr, status, error) {
                    console.error('Error:', status, error);
                }
            });
        }
    </script>

@stop
