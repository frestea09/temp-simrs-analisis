<div class='table-responsive'>
    <table class='table-striped table-bordered table-hover table-condensed table' >
        <thead>
            <tr>
                <th rowspan="2" class="text-center">No</th>
                <th rowspan="2" class="text-center">No. Antrian</th>
                <th rowspan="2" class="text-center">Pasien</th>
                <th rowspan="2" class="text-center">RM</th>
                <th rowspan="2" class="text-center">Usia</th>
                <th rowspan="2" class="text-center">Tgl.Lahir</th>
                <th rowspan="2" class="text-center">Dokter</th>
                <th rowspan="2" class="text-center">Bayar</th>
                <th rowspan="2" class="text-center">Masuk</th>
                <th rowspan="2" class="text-center">Klinik Asal</th>
                
                <th rowspan="2" class="text-center">Proses</th>
                <th rowspan="2" class="text-center">Expertise</th>
                <th rowspan="2" class="text-center">Billing</th>
                <th colspan="2" class="text-center" class="text-center" >Cetak</th>
                <th rowspan="2" class="text-center" class="text-center" style="vertical-align: middle;">Note</th>
            </tr>
            <tr>
                <th>Bill.</th>
                <th>Eksp.</th>
              </tr>
        </thead>
        <tbody>
            @forelse ($datas as  $d)
            @php
                $unit = 'igd';
                $ekspertise = App\RadiologiEkspertise::where('registrasi_id', $d->registrasi_id)->get();
                $antrianRad = @$d->registrasi->antrianRad ? @$d->registrasi->antrianRad->where('tanggal', date('Y-m-d'))->first() : null;
            @endphp
                <tr>
                    <td class="text-center">{{$no++}}</td>
                    <td>
                        @if(@$antrianRad)
                        <button class="btn btn-md btn-success" onclick="panggilAntrian({{ @$antrianRad->nomor }}, {{ @$antrianRad->id }}, {{ @$d->id }})">
                          <i class="fa fa-microphone"></i>
                        </button>
                        {{ @$antrianRad->nomor }}
                        @else
                        @endif
                      </td>
                    <td> {{ @$d->nama }} ({{ @$d->kelamin }})</td>
                    <td>{{ @$d->no_rm }}</td>
                    <td>{{ hitung_umur(@$d->tgllahir) }}</td>
                    <td>{{ date('d-m-Y', strtotime(@$d->tgllahir)) }}</td>
                    <td>{{ Modules\Pegawai\Entities\Pegawai::where('id', @$d->dokter_id)->first()->nama }}</td>
                    <td>{{ baca_carabayar($d->bayar) }}
                        @if (!empty($d->tipe_jkn))
                            - {{ $d->tipe_jkn }}
                        @endif
                    </td>
                    <td>{{ date('d/m/Y H:i', strtotime($d->created_at)) }}</td>
                    <td>{{ @$d->poli }}</td>
                   
                    <td class="text-center">
                        <button type="button" class="btn btn-primary btn-sm btn-flat" onclick="new_ekspertise({{ $d->registrasi_id }})"><i class="fa fa-plus"></i></button>
                    </td>
                    <td class="text-center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-danger">Edit</button>
                            <button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                                @forelse($ekspertise as $val)
                                    <li>
                                        <a href="javascript:void(0)" onclick="ekspertise({{ $d->registrasi_id }},{{ $val->id }})"class="btn btn-flat btn-sm">{{ $val->uuid }} ({{ $val->no_dokument }})</a>
                                    </li>
                                @empty
                                    <li>
                                        <a href="javascript:void(0)">Belum Ada.</a>
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </td>
                    <td class="text-center">
                        <a href="{{ url('radiologi/entry-tindakan-irj/'. $d->registrasi_id.'/'.$d->pasien_id) }}" target="_blank" class="btn btn-danger btn-sm btn-info btn-flat"><i class="fa fa-edit"></i></a>
                    </td>
                     
                    <td class="text-center">
                        @if (Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->registrasi_id)->where('poli_tipe', 'R')->count() > 0)
                            <a href="{{ url('radiologi/cetakRincianRad/irj/'.$d->registrasi_id) }}" target="_blank" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-print"></i></a>
                        @endif
                    </td>
                      {{-- cetak ekspertise --}}
                    <td class="text-center">
                        @if (Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->registrasi_id)->where('poli_tipe', 'R')->count() > 0)
                            <div class="btn-group" style="min-width:0px !important">
                                {{-- <button type="button" class="btn btn-sm btn-success"><i class="fa fa-print"></i></button> --}}
                                <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-print"></i>&nbsp;
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                                    @php
                                        $fol = Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->registrasi_id)->where('poli_tipe', 'R')->first();
                                    @endphp
                                    @forelse($ekspertise as $val)
                                        <li>
                                            <a target="_blank" href="{{ url("radiologi/cetak-ekpertise/".$val->id."/".$d->registrasi_id."/".$fol->id) }}" class="btn btn-flat btn-sm">{{ $val->uuid }}</a>
                                        </li>
                                    @empty
                                        <li>
                                            <a href="javascript:void(0)">Belum Ada..</a>
                                        </li>
                                    @endforelse
                                </ul>
                            </div>
                        @endif
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-info btn-flat" data-id="{{ @$d->registrasi_id }}" onclick="showNote({{ @$d->registrasi_id }})"><i class="fa fa-book"></i></button>
                    </td>
                   
                </tr>
            @empty
                <tr>
                    <td colspan="17" class="text-center">Tidak Ada Pasien Yang Belum Diperiksa</td>
                </tr>
            @endforelse
           
        </tbody>
    </table>
    <script>
            function panggilAntrian(nomor, idAntrian, regId){
                $.ajax({
                    url: '/radiologi/panggil-antrian/'+nomor+'/'+idAntrian+'/'+regId,
                    type: 'GET',
                })
                .done(function(res) {
                    if(res.code == 200){
                    alert(res.message);
                    return window.location.reload();
                    }else{
                    return alert('Gagal Melakukan Panggil');
                    }
                })
                .fail(function(res) {
                    return alert(res.statusText);
                });
            }
    </script>
</div>
