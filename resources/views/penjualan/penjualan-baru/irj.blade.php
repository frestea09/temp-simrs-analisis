@extends('master')
@section('header')
    <h1>Penjualan Rawat Jalan</h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
        </div>
        <div class="box-body">
            {!! Form::open(['method' => 'POST', 'url' => 'penjualan/jalan-baru', 'class' => 'form-horizontal']) !!}
            <div class="row">
                {!! Form::hidden('unit', $unit) !!}
                <div class="col-md-4">
                    <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}"
                                type="button">Registrasi Tanggal</button>
                        </span>
                        {!! Form::text('tga', null, ['autocomplete' => 'off', 'class' => 'form-control datepicker', 'required' => true]) !!}
                        <small class="text-danger">{{ $errors->first('tga') }}</small>
                    </div>
                    <br>
                </div>
                <div class="col-md-4">
                    <div class="input-group{{ $errors->has('tgb') ? ' has-error' : '' }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default{{ $errors->has('tgb') ? ' has-error' : '' }}" type="button">s/d
                                Tanggal</button>
                        </span>
                        {!! Form::text('tgb', null, [
                            'autocomplete' => 'off',
                            'class' => 'form-control datepicker',
                            'required' => true,
                            'onchange' => 'this.form.submit()',
                        ]) !!}
                        <small class="text-danger">{{ $errors->first('tgb') }}</small>
                    </div>
                    <br>
                </div>
                <div class="col-md-4">
                    <div class="input-group{{ $errors->has('poli') ? ' has-error' : '' }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default{{ $errors->has('poli') ? ' has-error' : '' }}"
                                type="button">Poli</button>
                        </span>
                        {{-- {!! Form::text('poli', null, ['autocomplete'=>'off','class' => 'form-control', 'required' => true, 'onchange'=>'this.form.submit()']) !!}
                <small class="text-danger">{{ $errors->first('poli') }}</small> --}}
                        @php
                            $poli = Modules\Poli\Entities\Poli::all();
                        @endphp
                        <select name="poli" id="" onchange="this.form.submit()" class="select2">
                            <option value="">-- SEMUA --</option>
                            @foreach ($poli as $item)
                                <option value="{{ $item->id }}" {{ $polis == $item->id ? 'selected' : '' }}>
                                    {{ baca_poli($item->id) }}</option>
                            @endforeach

                        </select>
                    </div>
                    <br>
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
                                {{-- <th>Histori</th> --}}
                                <th>RM</th>
                                {{-- <th>RM Lama</th> --}}
                                <th>Poli</th>
                                <th>Jenis</th>
                                <th>Di Bayar</th>
                                <th>Tgl Registrasi</th>
                                <th>Proses</th>
                                <th>Tanggal Entry</th>
                                <th>Resep</th>
                                <th>Copy Resep</th>
                                <th>Faktur</th>
                                <th>F. Kronis K</th>
                                <th>F. Non Kronis</th>
                                <th>Etiket Biru</th>
                                {{-- @if (Auth::user()->hasRole('administrator') || Auth::user()->name == 'MURNI MURSYID, S.Farm,Apt.,M.Si.') --}}
                                <th>Edit</th>
                                {{-- @endif --}}
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
                                    <td>{{ strtoupper($data->nama) }}</td>
                                    <td>{{ $data->no_rm }}</td>
                                    <td>{{ $data->nama_poli }}</td>
                                    <td>{{ $data->carabayar }}</td>
                                    <td>
                                        @if ($data->lunas == 'Y')
                                            {{ 'Lunas' }}
                                        @else
                                            {{ 'Belum Lunas' }}
                                        @endif
                                    </td>
                                    <td>{{ tanggal_eklaim($data->tgl_regisrasi) }}</td>
                                    <td>
                                        <a href="{{ url('penjualan/form-penjualan-baru/' . $data->pasien_id) . '/' . $data->registrasi_id }}"
                                            class="btn btn-success btn-flat btn-sm"><i class="fa fa-check"></i></a>
                                    </td>
                                    <td>
                                        {{ @$penjualans->sortBy('pj_created_at', 'desc')->first()->pj_created_at }}
                                    </td>
                                    <td>
                                        @if ($penjualan_exists  )
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-danger">Cetak</button>
                                                <button type="button" class="btn btn-sm btn-danger dropdown-toggle"
                                                    data-toggle="dropdown">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                                                    @foreach ($penjualans as $p)
                                                        <li><a href="{{ url('copy-resep/cetak-detail-resep-farmasi/' . $p->penjualan_id) }}{{$p->eresep && count($p->eresep) > 0 ? "?tte=true" : ""}}"
                                                                class="btn btn-flat btn-sm"
                                                                target="_blank">{{ $p->no_resep }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($penjualan_exists )
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-success">Cetak</button>
                                                <button type="button" class="btn btn-sm btn-success dropdown-toggle"
                                                    data-toggle="dropdown">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                                                    @foreach ($penjualans as $p)
                                                        <li><a href="{{ url('copy-resep/cetak-detail-copy-resep-farmasi/' . $p->penjualan_id) }}"
                                                                class="btn btn-flat btn-sm"
                                                                target="_blank">{{ $p->no_resep }}</a></li>
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
                                    {{-- @if (Auth::user()->hasRole('administrator') || Auth::user()->name == 'MURNI MURSYID, S.Farm,Apt.,M.Si.')
                        <th>
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
                                <button type="button" onclick="updatePenjualan({{ $p->penjualan_id }})" class="btn btn-sm btn-flat"><i class="fa fa-pencil"></i> {{ $p->no_resep }}</button>
                              </li>
                            @endforeach
                            </ul>
                          </div>
                          @endif
                        </th> 
                      @endif --}}





                                    <td>
                                        @if ($penjualan_exists)
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-warning">Edit</button>
                                                <button type="button" class="btn btn-sm btn-warning dropdown-toggle"
                                                    data-toggle="dropdown">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                    @foreach ($penjualans as $p)
                                                        {{-- @if (resepLunas($p->no_resep) == 'N') --}}
                                                        {{-- <li><a href="#" type="button" onclick="updatePenjualan({{ $p->penjualan_id }})" class="btn btn-sm btn-block">{{ $p->no_resep }}</a></li> --}}
                                                        <li><a target="_blank"
                                                                href="{{ url('penjualan/editformpenjualan/Jalan/' . $p->registrasi_id . '/' . $p->penjualan_id) }}"
                                                                class="btn btn-sm btn-block">{{ $p->no_resep }}</a></li>
                                                        {{-- @else
                                    <li class="btn btn-sm btn-block"><strike>{{ $p->no_resep }}</strike></li>
                                 @endif --}}
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </td>
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
    </script>
@endsection
