@extends('master')
@section('header')
    <h1>Penjualan Rawat Inap </h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
            </h3>
        </div>
        <div class="box-body">

            {!! Form::open(['method' => 'POST', 'url' => 'penjualan/irna-baru', 'class' => 'form-horizontal']) !!}
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}"
                                type="button">Registrasi Tanggal</button>
                        </span>
                        {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => true]) !!}
                        <small class="text-danger">{{ $errors->first('tga') }}</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group{{ $errors->has('tgb') ? ' has-error' : '' }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default{{ $errors->has('tgb') ? ' has-error' : '' }}" type="button">s/d
                                Tanggal</button>
                        </span>
                        {!! Form::text('tgb', null, [
                            'class' => 'form-control datepicker',
                            'required' => true,
                            'onchange' => 'this.form.submit()',
                        ]) !!}
                        <small class="text-danger">{{ $errors->first('tgb') }}</small>
                    </div>
                </div>
                {{-- <div class="col-md-6">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">No RM</button>
              </span>
                <select name="no_rm" id="masterNorm" class="form-control" onchange="this.form.submit()"></select>
            </div>
          </div> --}}
            </div>
            {!! Form::close() !!}

            @if (isset($data))
                <div class='table-responsive'>
                    <table class='table-striped table-bordered table-hover table-condensed table' id='data'>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Nomor RM</th>
                                <th>Alamat</th>
                                <th>Tgl Registrasi</th>
                                {{-- <th>Di Bayar</th> --}}
                                <th>Cara Bayar</th>
                                @role('administrator')
                                    <th>Insert Tagihan</th>
                                @endrole
                                {{-- <th>E-Resep</th> --}}
                                <th>Proses</th>
                                <th>Tanggal Entry</th>
                                <th>Faktur</th>
                                <th>F. Kronis</th>
                                <th>F. Non Kronis</th>
                                <th>Etiket</th>
                                @if (Auth::user()->hasRole(['administrator', 'apotik']))
                                    <th>Edit</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data->groupBy('registrasi_id') as $key => $penjualans)
                                @php
                                    $data = $penjualans->first();
                                    $penjualan_exists = $penjualans->where('penjualan_id', '!=', null)->count() != 0
                                @endphp
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $data->nama }}</td>
                                    <td>{{ $data->no_rm }}</td>
                                    <td>{{ $data->alamat }} RT. {{ $data->rt }} RW. {{ $data->rw }}</td>
                                    <td>{{ $data->created_at }}</td>
                                    <td>{{ baca_carabayar($data->bayar) }}</td>
                                    @role('administrator')
                                        <td>
                                            <a onclick="insertTagihan({{ $data->registrasi_id }}, '{{ $data->no_rm }}')"
                                                class="btn btn-danger btn-sm btn-flat"><i class="fa fa-plus"></i></a>
                                        </td>
                                    @endrole
                                    {{-- <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-primary">Resep</button>
                                            <button type="button" class="btn btn-sm btn-primary dropdown-toggle"
                                                data-toggle="dropdown">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                                                @forelse ($r->e_resep->whereIn('status',['dikirim','diproses']) as $v)
                                                    <li>
                                                        @if ($v->status == 'diproses')
                                                            <a href="javascript:void(0)"
                                                                class="btn btn-flat btn-sm text-success">{{ $v->uuid }}
                                                                <i class="fa fa-check-square" aria-hidden="true"></i>
                                                            </a>
                                                        @else
                                                            <a href="{{ url('penjualan/form-penjualan-baru/' . $r->pasien_id . '/' . $r->registrasi_id . '?resep=' . $v->uuid) }}"
                                                                class="btn btn-flat btn-sm"
                                                                target="_blank">{{ $v->uuid }}</a>
                                                        @endif
                                                    </li>
                                                @empty
                                                    <li>
                                                        <a href="javascript:void(0)" class="btn btn-flat btn-sm">Belum
                                                            Ada</a>
                                                    </li>
                                                @endforelse
                                            </ul>
                                        </div>
                                    </td> --}}
                                    <td>
                                        <a href="{{ url('penjualan/form-penjualan-baru/' . $data->pasien_id) . '/' . $data->registrasi_id }}"
                                            class="btn btn-success btn-sm btn-flat"><i class="fa fa-check"></i></a>
                                    </td>
                                    <td>
                                        {{ @$data->created_at }}
                                    </td>
                                    <td>
                                        @if ($penjualan_exists)
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-danger">Cetak</button>
                                                <button type="button" class="btn btn-sm btn-danger dropdown-toggle"
                                                    data-toggle="dropdown">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                                                    @foreach ($penjualans as $p)
                                                        <li>
                                                            {{--  @if ($p->created_at <= '2020-04-01 00:00:00')
                                    <a href="{{ url('farmasi/cetak-detail/'.$p->penjualan_id) }}" class="btn btn-flat btn-sm" target="_blank">{{ $p->no_resep }}</a>
                                  @elseif($p->created_at >= '2020-04-01 00:00:00' && $p->created_at < '2020-04-02 15:51:16')
                                    <a href="{{ url('farmasi/cetak-detail-baru/'.$p->penjualan_id) }}" class="btn btn-flat btn-sm" target="_blank">{{ $p->no_resep }}</a>
                                  @else  --}}
                                                            <a href="{{ url('farmasi/cetak-detail/' . $p->penjualan_id) }}"
                                                                class="btn btn-flat btn-sm"
                                                                target="_blank">{{ $p->no_resep }}</a>
                                                            {{--  @endif  --}}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($penjualan_exists )
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-danger">Cetak</button>
                                                <button type="button" class="btn btn-sm btn-danger dropdown-toggle"
                                                    data-toggle="dropdown">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                                                    @foreach ($penjualans as $p)
                                                        <li>
                                                            <a href="{{ url('farmasi/cetak-fakturkronis/' . $p->penjualan_id) }}"
                                                                class="btn btn-danger btn-flat btn-sm" target="_blank"> {{ $p->no_resep }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($penjualan_exists )
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-warning">Cetak</button>
                                                <button type="button" class="btn btn-sm btn-warning dropdown-toggle"
                                                    data-toggle="dropdown">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                                                    @foreach ($penjualans as $p)
                                                        <li>
                                                            <a href="{{ url('farmasi/cetak-detail/' . $p->penjualan_id) . '?faktur=true' }}"
                                                                class="btn btn-flat btn-sm" target="_blank"> {{ $p->no_resep }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($penjualan_exists)
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-primary">Cetak</button>
                                                <button type="button" class="btn btn-sm btn-primary dropdown-toggle"
                                                    data-toggle="dropdown">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                                                    @foreach ($penjualans as $p)
                                                        <li><a href="{{ url('farmasi/laporan/etiket/' . $p->penjualan_id) }}"
                                                                class="btn btn-flat btn-sm"
                                                                target="_blank">{{ $p->no_resep }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </td>

                                    {{--  <td>
                     @if (count($penjualan) > 0)
                        <div class="btn-group">
                           <button type="button" class="btn btn-sm btn-warning">Edit</button>
                           <button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown">
                              <span class="caret"></span>
                              <span class="sr-only">Toggle Dropdown</span>
                           </button>
                           <ul class="dropdown-menu dropdown-menu-right" role="menu">  --}}
                                    {{--  @foreach ($penjualan as $p)  --}}
                                    {{-- @if (resepLunas($p->no_resep) == 'Y') --}}
                                    {{--  <li><a href="#" type="button" onclick="updatePenjualan({{ $p->penjualan_id }})" class="btn btn-sm btn-block">{{ $p->no_resep }}</a></li>  --}}
                                    {{-- @else
                                 <li class="btn btn-sm btn-block"><strike>{{ $p->no_resep }}</strike></li>
                              @endif --}}
                                    {{--  @endforeach  --}}
                                    {{--  </ul>
                        </div>
                     @endif
                     </td>  --}}

                                    {{-- <td>
                        @if ($penjualan->first())
                        <div class="btn-group">
                          <button type="button" class="btn btn-sm btn-warning">Edit</button>
                          <button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown">
                              <span class="caret"></span>
                              <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                            @foreach ($penjualan as $p)
                                    <li>
                                      <button type="button" onclick="updatePenjualan({{ $d->id }})" class="btn btn-sm btn-flat"> {{ $p->no_resep }}</button>
                                    </li>
                            @endforeach

                          </ul>
                        </div>
                        @endif
                      @foreach ($penjualan as $d)
                        <button type="button" onclick="updatePenjualan({{ $d->id }})" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-database"></i></button>
                      @endforeach
                      </td> --}}
                                    {{-- @role(['administrator']) --}}
                                    @if (Auth::user()->hasRole(['administrator', 'apotik']) || Auth::user()->name == 'MURNI MURSYID, S.Farm,Apt.,M.Si.')
                                        {{-- <th>
                          @if ($penjualan->first())
                          <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-danger">Hapus</button>
                            <button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                              @foreach ($penjualan as $p)
                              <li>
                                <button type="button" onclick="hapusPenjualan({{ $p->penjualan_id }})" class="btn btn-sm btn-flat"><i class="fa fa-remove"></i> {{ $p->no_resep }}</button>
                              </li>
                            @endforeach
                            </ul>
                          </div>
                          @endif
                        </th> --}}
                                    @endif
                                    @if (Auth::user()->hasRole(['administrator', 'apotik']) || Auth::user()->name == 'MURNI MURSYID, S.Farm,Apt.,M.Si.')
                                        <th>
                                            @if ($penjualan_exists)
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-warning">Edit</button>
                                                    <button type="button" class="btn btn-sm btn-warning dropdown-toggle"
                                                        data-toggle="dropdown">
                                                        <span class="caret"></span>
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-right" role="menu"
                                                        style="">
                                                        @foreach ($penjualans as $p)
                                                            <li>
                                                                {{-- <button type="button" onclick="hapusPenjualan({{ $p->penjualan_id }})" class="btn btn-sm btn-flat"><i class="fa fa-remove"></i> {{ $p->no_resep }}</button> --}}
                                                                {{-- <button type="button" onclick="updatePenjualan({{ $p->penjualan_id }})" class="btn btn-sm btn-flat"><i class="fa fa-pencil"></i> {{ $p->no_resep }}</button> --}}
                                                            <li><a target="_blank"
                                                                    href="{{ url('penjualan/editformpenjualan/Inap/' . $data->registrasi_id . '/' . $p->penjualan_id) }}"
                                                                    class="btn btn-sm btn-block">{{ $p->no_resep }}</a>
                                                            </li>
                                                            {{-- <a href="{{ url('penjualan/hapus-faktur-baru/'.$p->penjualan_id) }}" class="btn btn-flat btn-sm" target="_blank">{{ $p->no_resep }}</a> --}}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </th>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    {{-- MODAL EDIT PENJUALAN --}}
    <div class="modal fade" id="penjualanDetail">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div id="loadPenjualanDetail"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary btn-flat addPenjualan">Tambah Obat</button>
                </div>
            </div>
        </div>
    </div>
    {{-- MODAL HAPUS PENJUALAN --}}
    <div class="modal fade" id="penjualanHapusDetail">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div id="loadPenjualanDetailHapus"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    {{-- TAMBAH OBAT --}}
    <div class="modal fade" id="tambahObat">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div id="loadTambahPenjualan"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat closeAddObat">Tutup</button>
                    <button type="button" class="btn btn-primary btn-flat" onclick="saveObat()">SIMPAN</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script type="text/javascript">
        $('.select2').select2();
        $('#masterNorm').select2({
            placeholder: "Pilih No Rm...",
            ajax: {
                url: '/pasien/master-pasien/',
                dataType: 'json',
                data: function(params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        })

        function updatePenjualan(penjualan_id) {
            $('#penjualanDetail').modal('show');
            $('#tambahObat').modal('hide')
            $('.modal-title').text('Update Penjualan Obat');
            $('#loadPenjualanDetail').load('/detail-penjualan/' + penjualan_id);
            $('.addPenjualan').attr('onclick', 'tambahObat(' + penjualan_id + ')');
        }

        function hapusPenjualan(penjualan_id) {
            $('#penjualanHapusDetail').modal('show');
            $('#tambahObat').modal('hide')
            $('.modal-title').text('Hapus Penjualan Obat');
            $('#loadPenjualanDetailHapus').load('/detail-penjualan-baru/' + penjualan_id);
        }

        function hapusObat(id) {
            $.ajax({
                url: '/hapus-detail-penjualan/' + id,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.sukses == true) {
                        $('#penjualanDetail').modal('show');
                        $('.modal-title').text('Update Penjualan Obat');
                        $('#loadPenjualanDetail').load('/detail-penjualan/' + data.penjualan_id);
                    }
                }
            });
        }

        function updateDetail() {
            var data = $('#formUpdateFaktur').serialize();
            $.ajax({
                url: '/penjualan/updateFaktur',
                type: 'POST',
                dataType: 'json',
                data: data,
                success: function(data) {
                    if (data.sukses == true) {
                        alert('Berhasil Update !')
                        updatePenjualan(data.penjualan_id)
                    } else {
                        alert('Gagal Update !')
                        updatePenjualan(data.penjualan_id)
                    }
                }
            });
        }

        function tambahObat(penjualan_id) {
            $('#penjualanDetail').modal('hide');
            $('#tambahObat').modal('show')
            $('.modal-title').text('Tambah Obat')
            $('#loadTambahPenjualan').load('/tambah-detail-penjualan/' + penjualan_id);
            $('.closeAddObat').attr('onclick', 'updatePenjualan(' + penjualan_id + ')');
        }

        function saveObat() {
            var data = $('#formTambahPenjualan').serialize();
            $.ajax({
                url: '/simpan-detail-penjualan',
                type: 'POST',
                dataType: 'json',
                data: data,
                success: function(data) {
                    if (data.sukses == true) {
                        updatePenjualan(data.penjualan_id)
                    } else {
                        updatePenjualan(data.penjualan_id)
                    }
                }
            });
        }

        function insertTagihan(registrasi_id, no_rm) {
            if (confirm('Yakin tagihan RM ' + no_rm + ' akan di tambahkan ke Tagihan?') == true) {
                $.ajax({
                        url: '/penjualan/insert-tagihan-penjualan/' + registrasi_id,
                        type: 'GET',
                        dataType: 'json',
                    })
                    .done(function(data) {
                        if (data.sukses == true) {
                            alert(data.notif)
                        }
                    });
            }
        }
    </script>
@endsection
