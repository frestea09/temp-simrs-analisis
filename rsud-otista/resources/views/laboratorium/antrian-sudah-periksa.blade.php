<div class='table-responsive'>
    <table class='table-striped table-bordered table-hover table-condensed table' id="data">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">No. Antrian</th>
                <th class="text-center">Pasien</th>
                <th class="text-center">RM</th>
                <th class="text-center">Usia</th>
                <th class="text-center">Tgl.Lahir</th>
                <th class="text-center">Dokter</th>
                <th class="text-center">Bayar</th>
                <th class="text-center">Masuk</th>
                <th class="text-center">Klinik Asal</th>
                
                {{-- <th class="text-center">Proses</th>
                <th class="text-center">Input Hasil</th>
                <th class="text-center">Cetak RB</th>
                <th class="text-center">Cetak Hasil</th> --}}
            </tr>
        </thead>
        <tbody>
            @forelse ($datas as  $d)
            @php
                // $unit = 'igd';
                $antrianLab = @$d->registrasi->antrianLab ? @$d->registrasi->antrianLab->where('tanggal', date('Y-m-d'))->first() : null;
            @endphp
                <tr>
                    <td>{{$no++}}</td>
                    <td>
                        @if(@$antrianLab)
                        <button class="btn btn-md btn-success" onclick="panggilAntrian({{ @$antrianLab->nomor }}, {{ @$antrianLab->id }}, {{ @$d->id }})">
                          <i class="fa fa-microphone"></i>
                        </button>
                        {{ @$antrianLab->nomor }}
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
                    <td>{{ @$d->kamar_id ? @$d->kamar->nama : @$d->poli->nama }}</td>
                   
                    {{-- <td class="text-center">
                        <a href="{{ url('/laboratorium/entry-tindakan-irj/'. $d->registrasi_id.'/'.$d->pasien_id) }}"  class="btn btn-sm btn-info btn-flat"><i class="fa fa-edit"></i></a>
                    </td>
                    <td class="text-center">
                        <a href="{{ url('pemeriksaanlab/create/'.$d->registrasi_id) }}" target="_blank" class="btn btn-sm btn-info btn-flat"><i class="fa fa-credit-card"></i></a>
                    </td>
                    <td class="text-center">
                        @if (Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->registrasi_id)->where('poli_tipe', 'L')->count() > 0)
                          <a href="{{ url('laboratorium/cetakRincianLab/irj/'.$d->registrasi_id) }}" target="_blank" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-print"></i></a>
                        @endif

                        @if (Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->registrasi_id)->where('poli_tipe', 'L')->count() > 0)
                        <div class="btn-group">
                        <button type="button" class="btn btn-success btn-sm"><i class="fa fa-print"></i></button>
                        <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                            @foreach (Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->registrasi_id)->where('poli_tipe', 'L')->select('created_at')->groupBy(DB::raw('hour(created_at),day(created_at)'))->orderBy('id','DESC')->get() as $p)
                                @php
                                    $datetime = str_replace(" ","_",date('Y-m-d H:i',strtotime($p->created_at)))
                                @endphp
                                <li>
                                    <a href="{{ url("laboratorium/cetakRincianLab-pertgl/irj/".$d->registrasi_id."/".$datetime) }}" target="_blank" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> {{ date('d-m-Y H:i',strtotime($p->created_at)) }} </a>
                                </li>
                            @endforeach
                        </ul>
                        </div>
                    @endif
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-danger">
                            <a href="{{ url('pemeriksaanlab/cetakAll/'. $d->registrasi_id) }}" style="color: white">CETAK</a>
                        </button>
                        @if (cek_hasil_lab($d->registrasi_id) >= 1)
                            @php
                            $hasil = App\Hasillab::where('registrasi_id', $d->registrasi_id)->get();
                            @endphp
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-success">Cetak</button>
                                <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                                @foreach ($hasil as $p)
                                    <li><a href="{{ url('pemeriksaanlab/cetakOne/'. $d->registrasi_id .'/' . $p->id ) }}" class="btn btn-flat btn-sm" target="_blank"> {{ $p->created_at }}</a></li>
                                @endforeach
                                </ul>
                            </div>
                        @endif
                    </td> --}}
                </tr>
            @empty
                <tr>
                    <td colspan="13" class="text-center">Tidak Ada Pasien Yang Sudah Diperiksa</td>
                </tr>
            @endforelse
           
        </tbody>
    </table>
</div>
