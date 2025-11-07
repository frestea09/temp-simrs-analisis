@extends('master')
@section('header')
    <h1>{{ baca_unit($unit) }} - Data Resume <small></small></h1>
@endsection

@section('content')
    @include('emr.modules.addons.profile')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Daftar Data Resume</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    @include('emr.modules.addons.tabs')
                </div>
            </div>
            
            <div class='table-responsive'>
                <h4>Histori Asesmen dan CPPT</h4>
                <table class='table-striped table-bordered table-hover table-condensed table' id="data">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tgl. Dibuat</th>
                            <th>Poli / Ruangan</th>
                            <th>Sumber Data</th>
                            <th>Pratinjau</th>
                            <th>TTE Histori Asesmen dan CPPT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $nomor = 1;
                        @endphp
                        @foreach ($resume as $key => $p)
                            @php
                                $pegawai = Modules\Pegawai\Entities\Pegawai::where('user_id', $p->user_id)->first();
                            @endphp
                                @if ($p->source == 'cppt')
                                    <tr>
                                        <td>{{ $nomor++  }}</td>
                                        <td>{{ date('d-m-Y', strtotime($p->created_at)) }}</td>
                                        <td>
                                            @if (@$p->unit == 'inap')
                                            {{ @$p->registrasi->rawat_inap->kamar->nama }}
                                            @elseif (@$p->unit == 'farmasi')
                                            Apotik / Farmasi
                                            @else
                                                @php
                                                    $poli = @$p->poli_id ? baca_poli($p->poli_id) : @$p->registrasi->poli->nama;
                                                @endphp
                                                {{ strpos($poli, 'IGD') !== false ? " " : "Poli " }} {{ $poli }}
                                            @endif
                                        </td>
                                        <td class="text-center" style="vertical-align: middle;">
                                            @if (@$p->unit == 'farmasi')
                                            <span class="label label-warning">{{strtoupper($p->source)}} - Farmasi</span>
                                            @else
                                            <span class="label {{ @$pegawai->kategori_pegawai == 1 ? 'label-primary' : 'label-warning' }}">{{strtoupper($p->source)}} - {{ @$pegawai->kategori_pegawai == 1 ? 'Dokter' : 'Perawat' }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ url('cetak-eresume-medis/pdf/' . @$p->registrasi_id . '/' . @$p->id) . "?source=cppt" }}"
                                                target="_blank" class="btn btn-info btn-sm btn-flat"> <i
                                                    class="fa fa-print"></i> </a>
                                        </td>
                                        <td>
                                            <button data-url="{{ url('tte-pdf-eresume-medis') . "?source=cppt&tte=true" }}"
                                                data-source="cppt"
                                                data-resume-id="{{@$p->id}}"
                                                target="_blank" data-registrasi-id="{{$p->registrasi_id}}" class="btn btn-danger btn-sm btn-flat proses-tte-resume-medis"> <i
                                                    class="fa fa-pencil"></i> </button>
                                            @if (!empty(json_decode(@$p->tte)->base64_signed_file))
                                                <a href="{{ url('/cetak-tte-eresume-medis/pdf/'. @$p->id) . "?source=cppt" }}"
                                                    target="_blank" class="btn btn-warning btn-sm btn-flat"> <i
                                                        class="fa fa-download"></i> </a>
                                            @elseif (!empty($p->tte))
                                                <a href="{{ url('/dokumen_tte/'. @$p->tte) . "?source=cppt" }}"
                                                    target="_blank" class="btn btn-warning btn-sm btn-flat"> <i
                                                        class="fa fa-download"></i> </a>
                                            @endif
                                        </td>
                                    </tr>
                                @elseif ($p->source == 'asesmen')
                                        @php
                                            $reg = $p->registrasi;
                                            $poliBpjs = baca_poli_bpjs($reg->poli_id);
                                        @endphp
                                        @if ($poliBpjs == "HDL" || $poliBpjs == "GIG" || $poliBpjs == "GND")
                                            <tr>
                                                <td>{{ $nomor++ }}</td>
                                                <td>{{ date('d-m-Y', strtotime($p->created_at)) }}</td>
                                                <td>
                                                    @if (@$p->unit == 'inap')
                                                    {{ @$p->registrasi->rawat_inap->kamar->nama }}
                                                    @else
                                                        @php
                                                            $poli = @$p->poli_id ? baca_poli($p->poli_id) : @$p->registrasi->poli->nama;
                                                        @endphp
                                                        {{ strpos($poli, 'IGD') !== false ? " " : "Poli " }} {{ $poli }}
                                                    @endif
                                                </td>
                                                @if (@$p->type == 'assesment-awal-medis-igd' || @$p->type == 'assesment-awal-medis-igd-ponek' || @$p->type == 'assesment-awal-perawat-igd')
                                                <td class="text-center" style="vertical-align: middle;"><span class="label label-success">{{ strtoupper(str_replace('-', ' ', @$p->type)) }}</span></td>
                                                @else
                                                <td class="text-center" style="vertical-align: middle;"><span class="label label-success">{{strtoupper($p->source)}} - {{ @$pegawai->kategori_pegawai == 1 ? 'Dokter' : 'Perawat' }}</span></td>
                                                @endif
                                                <td>
                                                    @if (substr(@$p->registrasi->status_reg, 0, 1) == 'J')
                                                        @if (in_array(@$p->registrasi->poli_id, ['3', '34', '4']))
                                                            <a href="{{ url("cetak-resume-medis-rencana-kontrol-gigi/pdf/".@$p->registrasi_id."/".@$p->id) }}" target="_blank" class="btn btn-info btn-sm">
                                                            <i class="fa fa-print"></i>
                                                            </a>
                                                        @elseif (@$p->registrasi->poli_id == '27')
                                                            <a href="{{ url("cetak-resume-medis-rencana-kontrol-hemodialisis/pdf/".@$p->registrasi_id."/".@$p->id) }}" target="_blank" class="btn btn-info btn-sm">
                                                            <i class="fa fa-print"></i>
                                                            </a>
                                                        @else
                                                            <a href="{{ url('cetak-eresume-medis/pdf/' . @$p->registrasi_id . '/' . @$p->id) . "?source=asesmen" }}"
                                                                target="_blank" class="btn btn-info btn-sm btn-flat"> <i
                                                                    class="fa fa-print"></i> </a>
                                                        @endif
                                                    @else
                                                    <a href="{{ url('cetak-eresume-medis/pdf/' . @$p->registrasi_id . '/' . @$p->id) . "?source=asesmen" }}"
                                                        target="_blank" class="btn btn-info btn-sm btn-flat"> <i
                                                            class="fa fa-print"></i> </a>
                                                    @endif
                                                    @if ($p->file_planning)
                                                    <a target="_blank" href="{{ asset('/emr_file/'.@$p->file_planning) }}" class="btn btn-success btn-sm btn-flat">File Planning</a>
                                                    @endif
                                                    @if ($p->file_diagnosis)
                                                    <a target="_blank" href="{{ asset('/emr_file/'.@$p->file_diagnosis) }}" class="btn btn-warning btn-sm btn-flat">File Planning</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (substr(@$p->registrasi->status_reg, 0, 1) == 'J')
                                                        @if (in_array(@$p->registrasi->poli_id, ['3', '34', '4']))
                                                            <button data-url="{{ url("cetak-resume-medis-rencana-kontrol-gigi/pdf/".@$p->registrasi_id."/".@$p->id) }}"
                                                                data-source="asesmen"
                                                                data-resume-id="{{@$p->id}}"
                                                                target="_blank" data-registrasi-id="{{$p->registrasi_id}}" class="btn btn-danger btn-sm btn-flat proses-tte-resume-medis"> <i
                                                                    class="fa fa-pencil"></i> </button>
                                                        @elseif (@$p->registrasi->poli_id == '27')
                                                            <button data-url="{{ url("cetak-resume-medis-rencana-kontrol-hemodialisis/pdf/".@$p->registrasi_id."/".@$p->id) }}"
                                                                data-source="asesmen"
                                                                data-resume-id="{{@$p->id}}"
                                                                target="_blank" data-registrasi-id="{{$p->registrasi_id}}" class="btn btn-danger btn-sm btn-flat proses-tte-resume-medis"> <i
                                                                    class="fa fa-pencil"></i> </button>
                                                        @else
                                                            <button data-url="{{ url('tte-pdf-eresume-medis') . "?source=asesmen&tte=true" }}"
                                                                data-source="asesmen"
                                                                data-resume-id="{{@$p->id}}"
                                                                target="_blank" data-registrasi-id="{{$p->registrasi_id}}" class="btn btn-danger btn-sm btn-flat proses-tte-resume-medis"> <i
                                                                    class="fa fa-pencil"></i> </button>
                                                        @endif
                                                    @else
                                                        <button data-url="{{ url('tte-pdf-eresume-medis') . "?source=asesmen&tte=true" }}"
                                                            data-source="asesmen"
                                                            data-resume-id="{{@$p->id}}"
                                                            target="_blank" data-registrasi-id="{{$p->registrasi_id}}" class="btn btn-danger btn-sm btn-flat proses-tte-resume-medis"> <i
                                                                class="fa fa-pencil"></i> </button>
                                                    @endif
                                                    @if (!empty(json_decode(@$p->tte)->base64_signed_file))
                                                        <a href="{{ url('/cetak-tte-eresume-medis/pdf/'. @$p->id) . "?source=asesmen" }}"
                                                            target="_blank" class="btn btn-warning btn-sm btn-flat"> <i
                                                                class="fa fa-download"></i> </a>
                                                    @elseif (!empty($p->tte))
                                                        <a href="{{ url('/dokumen_tte/'. @$p->tte) . "?source=cppt" }}"
                                                            target="_blank" class="btn btn-warning btn-sm btn-flat"> <i
                                                                class="fa fa-download"></i> </a>
                                                            @endif
                                                </td>
                                            </tr>
                                        @else
                                            @if (in_array($p->type, asesmen_ranap_dokter()) || in_array($p->type, asesmen_ranap_perawat()))
                                                <tr>
                                                    <td>{{ $nomor++  }}</td>
                                                    <td>{{ date('d-m-Y', strtotime($p->created_at)) }}</td>
                                                    <td>
                                                        {{ @$p->registrasi->rawat_inap->kamar->nama }}
                                                    </td>
                                                    @if (in_array($p->type, asesmen_ranap_dokter()))
                                                        <td class="text-center" style="vertical-align: middle;"><span class="label label-success">{{strtoupper($p->source)}} AWAL MEDIS {{strtoupper(substr($p->type, strrpos($p->type, '-') + 1))}} - Dokter</span></td>
                                                    @elseif (in_array($p->type, asesmen_ranap_perawat()))
                                                        <td class="text-center" style="vertical-align: middle;"><span class="label label-success">{{strtoupper($p->source)}} {{strtoupper(substr($p->type, strrpos($p->type, '-') + 1))}} - Perawat</span></td>
                                                    @endif
                                                    <td>
                                                        <a href="{{ url('cetak-eresume-medis/pdf/' . @$p->registrasi_id . '/' . @$p->id) . "?source=asesmen&tipe=dokter" }}"
                                                            target="_blank" class="btn btn-info btn-sm btn-flat"> <i
                                                                class="fa fa-print"></i> </a>
                                                        @if ($p->file_planning)
                                                        <a target="_blank" href="{{ asset('/emr_file/'.@$p->file_planning) }}" class="btn btn-success btn-sm btn-flat">File Planning</a>
                                                        @endif
                                                        @if ($p->file_diagnosis)
                                                        <a target="_blank" href="{{ asset('/emr_file/'.@$p->file_diagnosis) }}" class="btn btn-warning btn-sm btn-flat">File Planning</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <button data-url="{{ url('tte-pdf-eresume-medis') . "?source=asesmen&tte=true" }}"
                                                            data-source="asesmen"
                                                            data-resume-id="{{@$p->id}}"
                                                            target="_blank" data-registrasi-id="{{$p->registrasi_id}}" class="btn btn-danger btn-sm btn-flat proses-tte-resume-medis"> <i
                                                                class="fa fa-pencil"></i> </button>
                                                        @if (!empty(json_decode(@$p->tte)->base64_signed_file))
                                                            <a href="{{ url('/cetak-tte-eresume-medis/pdf/'. @$p->id) . "?source=asesmen" }}"
                                                                target="_blank" class="btn btn-warning btn-sm btn-flat"> <i
                                                                    class="fa fa-download"></i> </a>
                                                        @elseif (!empty($p->tte))
                                                            <a href="{{ url('/dokumen_tte/'. @$p->tte) . "?source=cppt" }}"
                                                                target="_blank" class="btn btn-warning btn-sm btn-flat"> <i
                                                                    class="fa fa-download"></i> </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @else
                                                @if (!empty($p->user_id))
                                                    <tr>
                                                        <td>{{ $nomor++ }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($p->created_at)) }}</td>
                                                        <td>
                                                            @if (@$p->unit == 'inap')
                                                            {{ @$p->registrasi->rawat_inap->kamar->nama }}
                                                            @else
                                                                @php
                                                                    $poli = @$p->poli_id ? baca_poli($p->poli_id) : @$p->registrasi->poli->nama;
                                                                @endphp
                                                                {{ strpos($poli, 'IGD') !== false ? " " : "Poli " }} {{ $poli }}
                                                            @endif
                                                        </td>
                                                        @if (@$p->type == 'assesment-awal-medis-igd' || @$p->type == 'assesment-awal-perawat-igd')
                                                            <td class="text-center" style="vertical-align: middle;"><span class="label label-success">{{ strtoupper(str_replace('-', ' ', @$p->type)) }}</span></td>
                                                        @elseif (@$p->type == 'assesment-awal-medis-igd-ponek')
                                                            @php
                                                                $tipe_asessmen = str_replace('medis', 'kebidanan', @$p->type);
                                                            @endphp
                                                            <td class="text-center" style="vertical-align: middle;"><span class="label label-success">{{ strtoupper(str_replace('-', ' ', @$tipe_asessmen)) }}</span></td>
                                                        @elseif (in_array(@$p->type, asesmen_ranap_dokter()))
                                                            <td class="text-center" style="vertical-align: middle;"><span class="label label-success">{{strtoupper($p->source)}} - Dokter</span></td>
                                                        @elseif (in_array(@$p->type, asesmen_ranap_perawat()))
                                                            <td class="text-center" style="vertical-align: middle;"><span class="label label-success">{{strtoupper($p->source)}} - Perawat</span></td>
                                                        @else
                                                            <td class="text-center" style="vertical-align: middle;"><span class="label label-success">{{strtoupper($p->source)}} - Perawat</span></td>
                                                        @endif
                                                        <td>
                                                            <a href="{{ url('cetak-eresume-medis/pdf/' . @$p->registrasi_id . '/' . @$p->id) . "?source=asesmen&tipe=perawat" }}"
                                                                target="_blank" class="btn btn-info btn-sm btn-flat"> <i
                                                                    class="fa fa-print"></i> </a>
                                                            @if ($p->file_planning)
                                                            <a target="_blank" href="{{ asset('/emr_file/'.@$p->file_planning) }}" class="btn btn-success btn-sm btn-flat">File Planning</a>
                                                            @endif
                                                            @if ($p->file_diagnosis)
                                                            <a target="_blank" href="{{ asset('/emr_file/'.@$p->file_diagnosis) }}" class="btn btn-warning btn-sm btn-flat">File Planning</a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <button data-url="{{ url('tte-pdf-eresume-medis') . "?source=asesmen&tte=true&tipe=perawat" }}"
                                                                data-source="asesmen"
                                                                data-resume-id="{{@$p->id}}"
                                                                target="_blank" data-registrasi-id="{{$p->registrasi_id}}" class="btn btn-danger btn-sm btn-flat proses-tte-resume-medis"> <i
                                                                    class="fa fa-pencil"></i> </button>
                                                            @if (!empty(json_decode(@$p->tte)->base64_signed_file))
                                                                <a href="{{ url('/cetak-tte-eresume-medis/pdf/'. @$p->id) . "?source=asesmen" }}"
                                                                    target="_blank" class="btn btn-warning btn-sm btn-flat"> <i
                                                                        class="fa fa-download"></i> </a>
                                                            @elseif (!empty($p->tte))
                                                                <a href="{{ url('/dokumen_tte/'. @$p->tte) . "?source=cppt" }}"
                                                                    target="_blank" class="btn btn-warning btn-sm btn-flat"> <i
                                                                        class="fa fa-download"></i> </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if (!empty($p->userdokter_id))
                                                    <tr>
                                                        <td>{{ $nomor++  }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($p->created_at)) }}</td>
                                                        <td>
                                                            @if (@$p->unit == 'inap')
                                                            {{ @$p->registrasi->rawat_inap->kamar->nama }}
                                                            @else
                                                                @php
                                                                    $poli = @$p->poli_id ? baca_poli($p->poli_id) : @$p->registrasi->poli->nama;
                                                                @endphp
                                                                {{ strpos($poli, 'IGD') !== false ? " " : "Poli " }} {{ $poli }}
                                                            @endif
                                                        </td>
                                                        @if (@$p->type == 'assesment-awal-medis-igd' || @$p->type == 'assesment-awal-perawat-igd')
                                                            <td class="text-center" style="vertical-align: middle;"><span class="label label-success">{{ strtoupper(str_replace('-', ' ', @$p->type)) }}</span></td>
                                                        @elseif (@$p->type == 'assesment-awal-medis-igd-ponek')
                                                            @php
                                                                $tipe_asessmen = str_replace('medis', 'kebidanan', @$p->type);
                                                            @endphp
                                                            <td class="text-center" style="vertical-align: middle;"><span class="label label-success">{{ strtoupper(str_replace('-', ' ', @$tipe_asessmen)) }}</span></td>
                                                        @else
                                                            <td class="text-center" style="vertical-align: middle;"><span class="label label-success">{{strtoupper($p->source)}} - Dokter</span></td>
                                                        @endif
                                                        <td>
                                                            <a href="{{ url('cetak-eresume-medis/pdf/' . @$p->registrasi_id . '/' . @$p->id) . "?source=asesmen&tipe=dokter" }}"
                                                                target="_blank" class="btn btn-info btn-sm btn-flat"> <i
                                                                    class="fa fa-print"></i> </a>
                                                            @if ($p->file_planning)
                                                            <a target="_blank" href="{{ asset('/emr_file/'.@$p->file_planning) }}" class="btn btn-success btn-sm btn-flat">File Planning</a>
                                                            @endif
                                                            @if ($p->file_diagnosis)
                                                            <a target="_blank" href="{{ asset('/emr_file/'.@$p->file_diagnosis) }}" class="btn btn-warning btn-sm btn-flat">File Planning</a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <button data-url="{{ url('tte-pdf-eresume-medis') . "?source=asesmen&tte=true&tipe=dokter" }}"
                                                                data-source="asesmen"
                                                                data-resume-id="{{@$p->id}}"
                                                                target="_blank" data-registrasi-id="{{$p->registrasi_id}}" class="btn btn-danger btn-sm btn-flat proses-tte-resume-medis"> <i
                                                                    class="fa fa-pencil"></i> </button>
                                                            @if (!empty(json_decode(@$p->tte)->base64_signed_file))
                                                                <a href="{{ url('/cetak-tte-eresume-medis/pdf/'. @$p->id) . "?source=asesmen" }}"
                                                                    target="_blank" class="btn btn-warning btn-sm btn-flat"> <i
                                                                        class="fa fa-download"></i> </a>
                                                            @elseif (!empty($p->tte))
                                                                <a href="{{ url('/dokumen_tte/'. @$p->tte) . "?source=cppt" }}"
                                                                    target="_blank" class="btn btn-warning btn-sm btn-flat"> <i
                                                                        class="fa fa-download"></i> </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endif
                                        @endif
                                @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class='table-responsive'>
                <h4>Hasil layanan Rehab Medik</h4>
                <table class='table-striped table-bordered table-hover table-condensed table' id="tabelHasilRehabMedik">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tgl. Registrasi</th>
                            <th>Poli</th>
                            <th>Nama Asesmen</th>
                            <th>Tgl. Dibuat</th>
                            <th>Pratinjau</th>
                            <th>Dokumen TTE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($layanan_rehab as $key => $layanan)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ date('d-m-Y H:i', strtotime(@$layanan->registrasi->created_at)) }}</td>
                                <td>{{ @$layanan->registrasi->poli->nama }}</td>
                                <td>
                                    @if(@$layanan->type == 'uji_fungsi_rehab')
                                        Hasil Tindakan Uji Fungsi
                                    @elseif(@$layanan->type == 'program_terapi_rehab')
                                        Program Terapi
                                    @else
                                        Layanan Kedokteran dan Rehabilitasi
                                    @endif
                                </td>
                                <td>{{ date('d-m-Y H:i', strtotime($layanan->created_at)) }}</td>
                                <td>
                                    @if(@$layanan->type == 'uji_fungsi_rehab')    
                                        <a href="{{ url('cetak-uji-fungsi/pdf/'. @$layanan->registrasi->id .'/' . @$layanan->id) }}" target="_blank" class="btn btn-info btn-sm btn-flat">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    @elseif(@$layanan->type == 'program_terapi_rehab')
                                        <a href="{{ url('cetak-program-terapi/pdf/'. @$layanan->registrasi->id .'/' . @$layanan->id) }}" target="_blank" class="btn btn-info btn-sm btn-flat">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    @else
                                        <a href="{{ url('cetak-layanan-rehab/pdf/'. @$layanan->registrasi->id .'/' . @$layanan->id) }}" target="_blank" class="btn btn-info btn-sm btn-flat">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    @if(@$layanan->type == 'uji_fungsi_rehab')
                                        @if (!empty(json_decode(@$layanan->tte)->base64_signed_file))
                                            <a href="{{ url('/cetak-tte-uji-fungsi/pdf/'. $layanan->registrasi->id . '/' . @$layanan->id) }}"
                                                target="_blank" class="btn btn-warning btn-sm btn-flat"> <i
                                                    class="fa fa-download"></i> </a>
                                        @elseif (!empty($layanan->tte))
                                            <a href="{{ url('/dokumen_tte/'. @$layanan->tte) . "?source=cppt" }}"
                                                target="_blank" class="btn btn-warning btn-sm btn-flat"> <i
                                                    class="fa fa-download"></i> </a>
                                        @else
                                            <span><i>Dokumen belum di tte</i></span>
                                        @endif
                                    @elseif(@$layanan->type == 'program_terapi_rehab')
                                        @if (!empty(json_decode(@$layanan->tte)->base64_signed_file))
                                            <a href="{{ url('/cetak-tte-program-terapi/pdf/'. $layanan->registrasi->id . '/' . @$layanan->id) }}"
                                                target="_blank" class="btn btn-warning btn-sm btn-flat"> <i
                                                    class="fa fa-download"></i> </a>
                                        @elseif (!empty($layanan->tte))``
                                            <a href="{{ url('/dokumen_tte/'. @$layanan->tte) . "?source=cppt" }}"
                                                target="_blank" class="btn btn-warning btn-sm btn-flat"> <i
                                                    class="fa fa-download"></i> </a>
                                        @else
                                            <span><i>Dokumen belum di tte</i></span>
                                        @endif
                                    @else
                                        @if (!empty(json_decode(@$layanan->tte)->base64_signed_file))
                                            <a href="{{ url('cetak-tte-layanan-rehab/pdf/'. @$layanan->registrasi->id .'/' . @$layanan->id) }}"
                                                target="_blank" class="btn btn-success btn-sm btn-flat"> <i
                                                    class="fa fa-print"></i> </a>
                                        @elseif (!empty($layanan->tte))
                                            <a href="{{ url('/dokumen_tte/'. @$layanan->tte) . "?source=cppt" }}"
                                                target="_blank" class="btn btn-warning btn-sm btn-flat"> <i
                                                    class="fa fa-download"></i> </a>
                                        @else
                                            <span><i>Dokumen belum di tte</i></span>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class='table-responsive'>
                <h4>Triage IGD</h4>
                <table class='table-striped table-bordered table-hover table-condensed table' id="tabelTriage">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tgl. Registrasi</th>
                            <th>Poli</th>
                            <th>Tgl. Dibuat</th>
                            <th>Pratinjau</th>
                            <th>Dokumen TTE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($triage_igd as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ date('d-m-Y H:i', strtotime(@$item->registrasi->created_at)) }}</td>
                                <td>{{ @$item->registrasi->poli->nama }}</td>
                                <td>{{ date('d-m-Y H:i', strtotime($item->created_at)) }}</td>
                                <td>
                                    <a href="/cetak-triage-igd/pdf/{{ $registrasi_id }}/{{ $item->id }}"
                                        target="_blank" class="btn btn-warning btn-sm">
                                        <i class="fa fa-print"></i>
                                    </a>
                                </td>
                                <td>
                                    <button class="btn btn-success btn-sm btn-flat" onclick="showTTEModalTriage({{$item->id}})"><i class="fa fa-pencil"></i></button>

                                    @if (!empty(json_decode(@$item->tte)->base64_signed_file))
                                        <a href="/emr-soap-file-tte/{{ $item->id }}/Triage"
                                            target="_blank" class="btn btn-success btn-sm">
                                            <i class="fa fa-print"></i>
                                        </a>
                                    @elseif (!empty($item->tte))
                                        <a href="{{ url('/dokumen_tte/'. @$item->tte) . "?source=cppt" }}"
                                            target="_blank" class="btn btn-warning btn-sm btn-flat"> <i
                                                class="fa fa-download"></i> </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class='table-responsive'>
                <h4>E-Resume</h4>
                <table class='table-striped table-bordered table-hover table-condensed table' id="tabelResumePasien">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tgl. Registrasi</th>
                            <th>Poli / Kamar</th>
                            <th>Unit</th>
                            <th>TTD Pasien</th>
                            <th>Pratinjau</th>
                            <th>TTE Resume</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($registrasi as $key => $p)
                            @php
                                $status_reg = cek_status_reg($p->status_reg);
                            @endphp
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ date('d-m-Y', strtotime($p->created_at)) }}</td>
                                <td>{{ @$p->rawat_inap ? baca_kamar($p->rawat_inap->kamar_id) : baca_poli($p->poli_id) }}</td>
                                <td>
                                    @if ($status_reg == "J")
                                        Rawat Jalan
                                    @elseif ($status_reg == "I")
                                        Rawat Inap
                                    @elseif ($status_reg == "G")
                                        IGD
                                    @endif
                                </td>
                                <td>
                                    <a target="_blank" href="{{ url('/signaturepad/e-resume/'.@$p->id) }}"
                                        class="btn btn-primary btn-sm btn-flat" data-toggle="tooltip" title="ttd pasien">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                                <td>
                                    {{-- @if (@$p->status == 'baru')
                                        @php
                                            @$emrPemeriksaan   = @\App\EmrInapPemeriksaan::where('registrasi_id',$p->id)->where('type','like','fisik_'.'%')->first();
                                        @endphp
                                        @if (!$emrPemeriksaan)
                                            <i class="text-warning">Belum Input Asesmen Baru</i>
                                        @else
                                            @if (in_array($p->poli_id, ['3', '34', '4']))
                                            <a href="{{ url("cetak-resume-medis-rencana-kontrol-gigi/pdf/".@$p->id."/".@$emrPemeriksaan->id) }}" target="_blank" class="btn btn-warning btn-sm">
                                                <i class="fa fa-print"></i>
                                            </a>
                                            @elseif ($p->poli_id == '15')
                                            <a href="{{ url("cetak-resume-medis-rencana-kontrol-obgyn/pdf/".@$p->id."/".@$emrPemeriksaan->id) }}" target="_blank" class="btn btn-warning btn-sm">
                                                <i class="fa fa-print"></i>
                                            </a>
                                            @elseif ( $p->poli_id == "6")
                                            <a href="{{ url("cetak-resume-medis-rencana-kontrol-mata/pdf/".@$p->id."/".@$emrPemeriksaan->id) }}" target="_blank" class="btn btn-warning btn-sm btn-flat">
                                                <i class="fa fa-print"></i>
                                            </a>
                                            @elseif ($p->poli_id == '27')
                                            <a href="{{ url("cetak-resume-medis-rencana-kontrol-hemodialisis/pdf/".@$p->id."/".@$emrPemeriksaan->id) }}" target="_blank" class="btn btn-warning btn-sm">
                                                <i class="fa fa-print"></i>
                                            </a>
                                            @elseif ($p->poli_id == '41')
                                            <a href="{{ url("cetak-resume-medis-rencana-kontrol-paru/pdf/".@$p->id."/".@$emrPemeriksaan->id) }}" target="_blank" class="btn btn-warning btn-sm">
                                                <i class="fa fa-print"></i>
                                            </a>
                                            @else
                                            <a href="{{ url("cetak-resume-medis-rencana-kontrol/pdf/".@$p->id."/".@$emrPemeriksaan->id) }}" target="_blank" class="btn btn-warning btn-sm">
                                                <i class="fa fa-print"></i>
                                            </a>
                                            @endif
                                        @endif
                                    @else --}}
                                        
                                    {{-- @endif --}}
                                    @if ($status_reg == "I")
                                        @php
                                            $resume_ranap = App\EmrInapPerencanaan::where('registrasi_id', @$p->id)->where('type', 'resume')->first();
                                        @endphp
                                        @if ($resume_ranap)
                                            <a href="{{ url('cetak-eresume-pasien-inap/pdf/' . @$resume_ranap->id) }}"
                                                target="_blank" class="btn btn-info btn-sm btn-flat"> <i
                                                    class="fa fa-eye"></i> </a>
                                        @else
                                                <i style="color: red;">Belum ada resume</i>
                                        @endif
                                    @elseif ($status_reg == "G")
                                        @php
                                            $resume_igd = @$p->resume_igd;
                                        @endphp
                                        @if ($resume_igd)
                                            <a href="{{ url('cetak-eresume-pasien-igd/pdf/' . @$resume_igd->id) }}"
                                                target="_blank" class="btn btn-info btn-sm btn-flat"> <i
                                                    class="fa fa-eye"></i> </a>
                                        @else
                                                <i style="color: red;">Belum ada resume</i>
                                        @endif
                                    @else
                                        <a href="{{ url('cetak-eresume-pasien/pdf/' . @$p->id) }}"
                                            target="_blank" class="btn btn-info btn-sm btn-flat"> <i
                                                class="fa fa-eye"></i> </a>
                                    @endif
                                </td>
                                <td>
                                    @if ($status_reg == "I")
                                        @php
                                            $resume_ranap = App\EmrInapPerencanaan::where('registrasi_id', @$p->id)->where('type', 'resume')->first();
                                        @endphp
                                        @if ($resume_ranap)
                                            <button class="btn btn-danger btn-sm btn-flat proses-tte-eresume-pasien-inap" data-id="{{@$resume_ranap->id}}">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            @if (!empty(json_decode(@$resume_ranap->tte)->base64_signed_file))
                                                <a href="{{ url('cetak-tte-eresume-pasien-inap/pdf/' . @$resume_ranap->id) }}"
                                                    target="_blank" class="btn btn-success btn-sm btn-flat"> <i
                                                        class="fa fa-print"></i> </a>
                                            @elseif (!empty($resume_ranap->tte))
                                                <a href="{{ url('tte_resume_pasien/' . @$resume_ranap->tte) }}"
                                                    target="_blank" class="btn btn-success btn-sm btn-flat"> <i
                                                        class="fa fa-print"></i> </a>
                                            @endif
                                        @else
                                                <i style="color: red;">Belum ada resume</i>
                                        @endif
                                    @elseif ($status_reg == "G")
                                        @php
                                            $resume_igd = App\EmrResume::where('registrasi_id', @$p->id)->where('type', 'resume-igd')->first();
                                        @endphp
                                        @if ($resume_igd)
                                            <button class="btn btn-danger btn-sm btn-flat proses-tte-eresume-pasien-igd" data-id="{{@$resume_igd->id}}">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            @if (!empty(json_decode(@$resume_igd->tte)->base64_signed_file))
                                                <a href="{{ url('cetak-tte-eresume-pasien-igd/pdf/' . @$resume_igd->id) }}"
                                                    target="_blank" class="btn btn-success btn-sm btn-flat"> <i
                                                        class="fa fa-print"></i> </a>
                                            @elseif (!empty($resume_igd->tte))
                                                <a href="{{ url('tte_resume_pasien/' . @$resume_igd->tte) }}"
                                                    target="_blank" class="btn btn-success btn-sm btn-flat"> <i
                                                        class="fa fa-print"></i> </a>
                                            @endif
                                        @else
                                                <i style="color: red;">Belum ada resume</i>
                                        @endif
                                    @else
                                        <button class="btn btn-danger btn-sm btn-flat proses-tte-eresume-pasien" data-registrasi-id="{{@$p->id}}">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        @if (!empty(json_decode(@$p->tte_resume_pasien)->base64_signed_file))
                                            <a href="{{ url('cetak-tte-eresume-pasien/pdf/' . @$p->id) }}"
                                                target="_blank" class="btn btn-success btn-sm btn-flat"> <i
                                                    class="fa fa-print"></i> </a>
                                        @elseif (!empty($p->tte_resume_pasien))
                                            <a href="{{ url('tte_resume_pasien/' . @$p->tte_resume_pasien) }}"
                                                target="_blank" class="btn btn-success btn-sm btn-flat"> <i
                                                    class="fa fa-print"></i> </a>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class='table-responsive'>
                <h4>E-Resume 2</h4>
                <table class='table-striped table-bordered table-hover table-condensed table' id="tabelResumePasien">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tgl. Registrasi</th>
                            <th>Poli / Kamar</th>
                            <th>Unit</th>
                            {{-- <th>TTD Pasien</th> --}}
                            <th>Pratinjau</th>
                            {{-- <th>TTE Resume</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($registrasi as $key => $p)
                            @php
                                $status_reg = cek_status_reg($p->status_reg);
                            @endphp
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ date('d-m-Y', strtotime($p->created_at)) }}</td>
                                <td>{{ @$p->rawat_inap ? baca_kamar($p->rawat_inap->kamar_id) : baca_poli($p->poli_id) }}</td>
                                <td>
                                    @if ($status_reg == "J")
                                        Rawat Jalan
                                    @elseif ($status_reg == "I")
                                        Rawat Inap
                                    @elseif ($status_reg == "G")
                                        IGD
                                    @endif
                                </td>
                                {{-- <td>
                                    <a target="_blank" href="{{ url('/signaturepad/e-resume/'.@$p->id) }}"
                                        class="btn btn-primary btn-sm btn-flat" data-toggle="tooltip" title="ttd pasien">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td> --}}
                                <td>
                                    @if ($status_reg == "I")
                                        @php
                                            $resume_ranap = App\EmrInapPerencanaan::where('registrasi_id', @$p->id)->where('type', 'resume')->first();
                                        @endphp
                                        @if ($resume_ranap)
                                            <a href="{{ url('cetak-eresume-pasien-inap/pdf/' . @$resume_ranap->id) . '?versi=2' }}"
                                                target="_blank" class="btn btn-info btn-sm btn-flat"> <i
                                                    class="fa fa-eye"></i> </a>
                                        @else
                                                <i style="color: red;">Belum ada resume</i>
                                        @endif
                                    @elseif ($status_reg == "G")
                                        @php
                                            $resume_igd = @$p->resume_igd;
                                        @endphp
                                        @if ($resume_igd)
                                            <a href="{{ url('cetak-eresume-pasien-igd/pdf/' . @$resume_igd->id) }}"
                                                target="_blank" class="btn btn-info btn-sm btn-flat"> <i
                                                    class="fa fa-eye"></i> </a>
                                        @else
                                                <i style="color: red;">Belum ada resume</i>
                                        @endif
                                    @else
                                        <a href="{{ url('cetak-eresume-pasien/pdf/' . @$p->id) }}"
                                            target="_blank" class="btn btn-info btn-sm btn-flat"> <i
                                                class="fa fa-eye"></i> </a>
                                    @endif
                                </td>
                                {{-- <td>
                                    @if ($status_reg == "I")
                                        @php
                                            $resume_ranap = App\EmrInapPerencanaan::where('registrasi_id', @$p->id)->where('type', 'resume')->first();
                                        @endphp
                                        @if ($resume_ranap)
                                            <button class="btn btn-danger btn-sm btn-flat proses-tte-eresume-pasien-inap-baru" data-id="{{@$resume_ranap->id}}">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            @if (!empty(json_decode(@$resume_ranap->tte)->base64_signed_file))
                                                <a href="{{ url('cetak-tte-eresume-pasien-inap/pdf/' . @$resume_ranap->id ) . '?versi=2' }}"
                                                    target="_blank" class="btn btn-success btn-sm btn-flat"> <i
                                                        class="fa fa-print"></i> </a>
                                            @elseif (!empty($resume_ranap->tte))
                                                <a href="{{ url('tte_resume_pasien/' . @$resume_ranap->tte) . '?versi=2' }}"
                                                    target="_blank" class="btn btn-success btn-sm btn-flat"> <i
                                                        class="fa fa-print"></i> </a>
                                            @endif
                                        @else
                                                <i style="color: red;">Belum ada resume</i>
                                        @endif
                                    @elseif ($status_reg == "G")
                                        @php
                                            $resume_igd = App\EmrResume::where('registrasi_id', @$p->id)->where('type', 'resume-igd')->first();
                                        @endphp
                                        @if ($resume_igd)
                                            <button class="btn btn-danger btn-sm btn-flat proses-tte-eresume-pasien-igd" data-id="{{@$resume_igd->id}}">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            @if (!empty(json_decode(@$resume_igd->tte)->base64_signed_file))
                                                <a href="{{ url('cetak-tte-eresume-pasien-igd/pdf/' . @$resume_igd->id) }}"
                                                    target="_blank" class="btn btn-success btn-sm btn-flat"> <i
                                                        class="fa fa-print"></i> </a>
                                            @elseif (!empty($resume_igd->tte))
                                                <a href="{{ url('tte_resume_pasien/' . @$resume_igd->tte) }}"
                                                    target="_blank" class="btn btn-success btn-sm btn-flat"> <i
                                                        class="fa fa-print"></i> </a>
                                            @endif
                                        @else
                                                <i style="color: red;">Belum ada resume</i>
                                        @endif
                                    @else
                                        <button class="btn btn-danger btn-sm btn-flat proses-tte-eresume-pasien" data-registrasi-id="{{@$p->id}}">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        @if (!empty(json_decode(@$p->tte_resume_pasien)->base64_signed_file))
                                            <a href="{{ url('cetak-tte-eresume-pasien/pdf/' . @$p->id) }}"
                                                target="_blank" class="btn btn-success btn-sm btn-flat"> <i
                                                    class="fa fa-print"></i> </a>
                                        @elseif (!empty($p->tte_resume_pasien))
                                            <a href="{{ url('tte_resume_pasien/' . @$p->tte_resume_pasien) }}"
                                                target="_blank" class="btn btn-success btn-sm btn-flat"> <i
                                                    class="fa fa-print"></i> </a>
                                        @endif
                                    @endif
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


            {{-- TRANSFER INTERNAL --}}
            <div class='table-responsive'>
                <h4>Transfer Internal</h4>
                <table class='table-striped table-bordered table-hover table-condensed table' id="tabelResumePasien">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tgl. Registrasi</th>
                            <th>Poli / Kamar</th>
                            <th>Unit</th>
                            <th>Pratinjau</th>
                            {{-- <th>TTE Resume</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transfer_internal as $key => $p)
                            @if ($p->registrasi)
                                @php
                                    $status_reg = cek_status_reg($p->registrasi->status_reg);
                                @endphp
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ date('d-m-Y', strtotime($p->registrasi->created_at)) }}</td>
                                    <td>{{ @$p->registrasi->rawat_inap ? baca_kamar($p->registrasi->rawat_inap->kamar_id) : baca_poli($p->registrasi->poli_id) }}</td>
                                    <td>
                                        @if ($status_reg == "J")
                                            Rawat Jalan
                                        @elseif ($status_reg == "I")
                                            Rawat Inap
                                        @elseif ($status_reg == "G")
                                            IGD
                                        @endif
                                    </td>
                                    <td>  
                                            <a href="{{ url('cetak-eresume-transfer-internal-new/' . @$p->id) }}"
                                                target="_blank" class="btn btn-info btn-sm btn-flat"> <i
                                                    class="fa fa-eye"></i> </a>
                                    </td>
                                    {{-- <td> --}}
                                        {{-- @if ($status_reg == "I")
                                            @php
                                                $resume_ranap = App\EmrInapPerencanaan::where('registrasi_id', @$p->id)->where('type', 'resume')->first();
                                            @endphp
                                            @if ($resume_ranap)
                                                <button class="btn btn-danger btn-sm btn-flat proses-tte-eresume-pasien-inap" data-id="{{@$resume_ranap->id}}">
                                                    <i class="fa fa-pencil"></i>
                                                </button>
                                                @if (!empty(json_decode(@$resume_ranap->tte)->base64_signed_file))
                                                    <a href="{{ url('cetak-tte-eresume-pasien-inap/pdf/' . @$resume_ranap->id) }}"
                                                        target="_blank" class="btn btn-success btn-sm btn-flat"> <i
                                                            class="fa fa-print"></i> </a>
                                                @endif
                                            @else
                                                    <i style="color: red;">Belum ada resume</i>
                                            @endif
                                        @else
                                            <button class="btn btn-danger btn-sm btn-flat proses-tte-eresume-pasien" data-registrasi-id="{{@$p->id}}">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            @if (!empty(json_decode(@$p->tte_resume_pasien)->base64_signed_file))
                                                <a href="{{ url('cetak-tte-eresume-pasien/pdf/' . @$p->id) }}"
                                                    target="_blank" class="btn btn-success btn-sm btn-flat"> <i
                                                        class="fa fa-print"></i> </a>
                                            @endif
                                        @endif --}}
                                    {{-- </td> --}}
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- EWS --}}
            <div class='table-responsive'>
                <h4>EWS</h4>
                <table class='table-striped table-bordered table-hover table-condensed table' id="tabelResumePasien">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tgl. Registrasi</th>
                            <th>Tgl. Dibuat</th>
                            <th>Tipe</th>
                            <th>Pratinjau</th>
                            <th>TTE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ews as $key => $p)
                            @if ($p->registrasi)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ date('d-m-Y', strtotime($p->registrasi->created_at)) }}</td>
                                    <td>{{ date('d-m-Y H:i', strtotime($p->created_at)) }}</td>
                                    <td>
                                        @if ($p->type == "ews-dewasa")
                                            EWS DEWASA
                                        @elseif ($p->type == "ews-anak")
                                            EWS ANAK
                                        @elseif ($p->type == "ews-maternal")
                                            EWS MATERNAL
                                        @elseif ($p->type == "ews-neonatus")
                                            EWS BAYI
                                        @endif
                                    </td>
                                    <td>  
                                        @if ($p->type == "ews-dewasa")
                                            <a class="btn btn-info btn-sm btn-flat" href="{{ url('cetak-ews-dewasa/pdf/'. $reg->id . '/' . $p->id) }}"
                                                data-toggle="tooltip" target="_blank"><i
                                                    class="fa fa-eye"></i></a>&nbsp;&nbsp;    
                                        @elseif ($p->type == "ews-anak")
                                            <a class="btn btn-info btn-sm btn-flat" href="{{ url('cetak-ews-anak/pdf/'. $reg->id . '/' . $p->id) }}"
                                                data-toggle="tooltip" target="_blank"><i
                                                    class="fa fa-eye"></i></a>&nbsp;&nbsp;    
                                        @elseif ($p->type == "ews-maternal")
                                            <a class="btn btn-info btn-sm btn-flat" href="{{ url('cetak-ews-maternitas/pdf/'. $reg->id . '/' . $p->id) }}"
                                                data-toggle="tooltip" target="_blank"><i
                                                    class="fa fa-eye"></i></a>&nbsp;&nbsp;    
                                        @elseif ($p->type == "ews-neonatus")
                                            <a class="btn btn-info btn-sm btn-flat" href="{{ url('cetak-ews-neonatus/pdf/'. $reg->id . '/' . $p->id) }}"
                                                data-toggle="tooltip" target="_blank"><i
                                                    class="fa fa-eye"></i></a>&nbsp;&nbsp;    
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-danger btn-sm btn-flat proses-tte-ews" data-id="{{@$p->id}}">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        @if (!empty($p->tte))
                                            <a href="{{ url('/dokumen_tte/' . @$p->tte) }}"
                                                target="_blank" class="btn btn-success btn-sm btn-flat"> <i
                                                    class="fa fa-print"></i> </a>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- ASKEP & ASKEB --}}
            <div class='table-responsive'>
                <h4>Askep & Askeb</h4>
                <table class='table-striped table-bordered table-hover table-condensed table' id="tabelResumePasien">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tgl. Registrasi</th>
                            <th>Tipe</th>
                            <th>Jam Tindakan</th>
                            <th>Diagnosa</th>
                            <th>Intervensi</th>
                            <th>Implementasi</th>
                            <th>Pratinjau</th>
                            <th>TTE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($askep_askeb as $key => $d)
                            @php
                                $data = [
                                    'askepId' => $d->id,
                                    'regId' => $d->registrasi_id,
                                    'type' => $d->type,
                                    'fisik' => json_decode(@$d->fisik, true) ?? @$d->fisik,
                                    'siki' => json_decode($d->pemeriksaandalam, true),
                                    'implementasi' => json_decode($d->fungsional, true),
                                    'diagnosis' => json_decode($d->diagnosis, true),
                                    'tglRegis' => Carbon\Carbon::parse($d->registrasi->created_at)->format('d-m-Y'),
                                    'tte' => $d->tte,
                                ];
                            @endphp
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ date('d-m-Y', strtotime($data['tglRegis'])) }}</td>
                                <td>
                                    {{@$data['type'] == "asuhan-keperawatan" ? 'Asuhan Keperawatan' : 'Asuhan Kebidanan'}}
                                </td>
                                <td>  
                                    @if ($data['fisik'])
                                        @if (is_array($data['fisik']))
                                            @foreach ($data['fisik'] as $jam)
                                                *{{date('d-m-Y H:i', strtotime($jam))}} <br>
                                            @endforeach
                                        @else
                                        {{date('d-m-Y H:i', strtotime($d['fisik']))}}
                                        @endif
                                    @else
                                    -
                                    @endif
                                </td>
                                <td>  
                                    @if (is_array($data['diagnosis']))
                                        @foreach ($data['diagnosis'] as $diagnosa)
                                            *{{ $diagnosa }} <br>
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    @if (is_array($data['siki']))
                                      @foreach ($data['siki'] as $intervensi)
                                        *{{ $intervensi }} <br>
                                      @endforeach
                                    @endif
                                </td>
                                <td>
                                    @if (is_array($data['implementasi']))
                                        @foreach ($data['implementasi'] as $implementasi)
                                        *{{ $implementasi }}
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    @if ($data['type'] == 'asuhan-keperawatan')
                                        <a href="{{ url('cetak-asuhan-keperawatan/pdf/'.$data['regId'].'/'.$data['askepId']) }}" class="btn btn-sm btn-info" target="_blank">
                                        <span class="fa fa-eye"></span>
                                        </a>
                                    @else
                                        <a href="{{ url('cetak-asuhan-kebidanan/pdf/'.$data['regId'].'/'.$data['askepId']) }}" class="btn btn-sm btn-info" target="_blank">
                                        <span class="fa fa-eye"></span>
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-danger btn-sm btn-flat proses-tte-askep" data-id="{{$data['askepId']}}" data-type="{{$data['type']}}" data-regid="{{$data['regId']}}">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    @if (!empty($data['tte']))
                                        <a href="{{ url('/dokumen_tte/' . @$data['tte']) }}"
                                            target="_blank" class="btn btn-success btn-sm btn-flat"> <i
                                                class="fa fa-print"></i> </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class='table-responsive'>
                <h4>SPRI</h4>
                <table class='table-striped table-bordered table-hover table-condensed table' id="tabelTriage">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tgl. Registrasi</th>
                            <th>Dokter Pengirim</th>
                            <th>Tgl. Dibuat</th>
                            <th>Pratinjau</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($spri) > 0)
                            @foreach ($spri as $key => $p)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ date('d-m-Y', strtotime($reg->created_at)) }}</td>
                                    <td>{{ baca_dokter($p->dokter_pengirim) }}</td>
                                    <td>{{ date('d-m-Y H:i', strtotime($p->created_at)) }}</td>
                                    <td>
                                        <a href="{{ url('spri/cetak/'. $p->registrasi_id) }}" target="_blank" class="btn btn-warning btn-sm">
                                            <i class="fa fa-print"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">Data tidak ditemukan</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

        </div>
    </div>

<!-- Modal TTE E-Resume Pasien Inap-->
<div id="myModal4" class="modal fade" role="dialog">
    <div class="modal-dialog">
  
      <!-- Modal content-->
      <form id="form-tte-eresume-pasien-inap" action="{{ url('tte-pdf-eresume-pasien-inap') }}" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">TTE E-Resume</h4>
        </div>
        <div class="modal-body row" style="display: grid;">
            {!! csrf_field() !!}
            <input type="hidden" class="form-control" name="resume_id" id="resume_id_hidden" disabled>
            <input type="hidden" class="form-control" name="nik" id="nik_hidden" value="{{Auth::user()->pegawai->nik}}" disabled>
          <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">Nama:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="dokter" id="dokter" value="{{Auth::user()->pegawai->nama}}" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">NIK:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="nik" value="{{substr(Auth::user()->pegawai->nik, 0, -5) . '*****'}}" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">Passphrase:</label>
            <div class="col-sm-10">
              <input type="password" class="form-control" name="passphrase" id="passphrase" value="{{session('passphrase') ? session('passphrase')['passphrase'] : ''}}">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="button-proses-tte-eresume-pasien-inap">Proses TTE</button>
        </div>
      </div>
      </form>
  
    </div>
  </div>

<!-- Modal TTE E-Resume Pasien IGD-->
<div id="myModal5" class="modal fade" role="dialog">
    <div class="modal-dialog">
  
      <!-- Modal content-->
      <form id="form-tte-eresume-pasien-igd" action="{{ url('tte-pdf-eresume-pasien-igd') }}" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">TTE E-Resume IGD</h4>
        </div>
        <div class="modal-body row" style="display: grid;">
            {!! csrf_field() !!}
            <input type="hidden" class="form-control" name="resume_id" id="resume_igd_id_hidden" disabled>
            <input type="hidden" class="form-control" name="nik" id="nik_hidden" value="{{Auth::user()->pegawai->nik}}" disabled>
          <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">Nama:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="dokter" id="dokter" value="{{Auth::user()->pegawai->nama}}" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">NIK:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="nik" value="{{substr(Auth::user()->pegawai->nik, 0, -5) . '*****'}}" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">Passphrase:</label>
            <div class="col-sm-10">
              <input type="password" class="form-control" name="passphrase" id="passphrase" value="{{session('passphrase') ? session('passphrase')['passphrase'] : ''}}">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="button-proses-tte-eresume-pasien-igd">Proses TTE</button>
        </div>
      </div>
      </form>
  
    </div>
  </div>

<!-- Modal TTE E-Resume Pasien-->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
  
      <!-- Modal content-->
      <form id="form-tte-eresume-pasien" action="{{ url('tte-pdf-eresume-pasien') }}" method="POST">
      <input type="hidden" name="id">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">TTE E-Resume</h4>
        </div>
        <div class="modal-body row" style="display: grid;">
            {!! csrf_field() !!}
            <input type="hidden" class="form-control" name="registrasi_id" id="registrasi_id_hidden" disabled>
            <input type="hidden" class="form-control" name="nik" id="nik_hidden" value="{{Auth::user()->pegawai->nik}}" disabled>
          <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">Nama:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="dokter" id="dokter" value="{{Auth::user()->pegawai->nama}}" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">NIK:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="nik" value="{{substr(Auth::user()->pegawai->nik, 0, -5) . '*****'}}" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">Passphrase:</label>
            <div class="col-sm-10">
              <input type="password" class="form-control" name="passphrase" id="passphrase" value="{{session('passphrase') ? session('passphrase')['passphrase'] : ''}}">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="button-proses-tte-eresume-pasien">Proses TTE</button>
        </div>
      </div>
      </form>
  
    </div>
  </div>

<!-- Modal TTE History Asesmen & CPPT-->
<div id="myModal2" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <form id="form-tte-eresume-medis" action="" method="POST">
      <input type="hidden" name="id">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">TTE History Asesmen & CPPT</h4>
        </div>
        <div class="modal-body row" style="display: grid;">
            {!! csrf_field() !!}
            <input type="hidden" class="form-control" name="registrasi_id" id="registrasi_id_hidden2" disabled>
            <input type="hidden" class="form-control" name="resume_id" id="resume_id" disabled>
            <input type="hidden" class="form-control" name="source" id="source" disabled>
            <input type="hidden" class="form-control" name="proses_tte" id="proses_tte" value="true">
            <input type="hidden" class="form-control" name="nik" id="nik_hidden" value="{{Auth::user()->pegawai->nik}}" disabled>
          <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">Nama:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="dokter" id="dokter" value="{{Auth::user()->pegawai->nama}}" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">NIK:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="nik" value="{{substr(Auth::user()->pegawai->nik, 0, -5) . '*****'}}" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">Passphrase:</label>
            <div class="col-sm-10">
              <input type="password" class="form-control" name="passphrase" id="passphrase" value="{{session('passphrase') ? @session('passphrase')['passphrase'] : ''}}">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="button-proses-tte-eresume-medis">Proses TTE</button>
        </div>
      </div>
      </form>
  
    </div>
  </div>

{{-- Modal TTE Triage--}}
<div id="myModal3" class="modal fade" role="dialog">
    <div class="modal-dialog">
    
        <!-- Modal content-->
        <form id="form-tte-triage" action="" method="POST">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">TTE Triage</h4>
        </div>
        <div class="modal-body row" style="display: grid;">
            {!! csrf_field() !!}
            <input type="hidden" class="form-control" name="nik" id="nik_hidden" value="{{Auth::user()->pegawai->nik}}" disabled>
            <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">Nama:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="dokter" id="dokter" value="{{Auth::user()->pegawai->nama}}" disabled>
            </div>
            </div>
            <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">NIK:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="nik" value="{{substr(Auth::user()->pegawai->nik, 0, -5) . '*****'}}" disabled>
            </div>
            </div>
            <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">Passphrase:</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" name="passphrase" id="passphrase" value="{{session('passphrase') ? @session('passphrase')['passphrase'] : ''}}">
            </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="button-proses-tte-triage" onclick="prosesTTETriage()">Proses TTE</button>
        </div>
        </div>
        </form>
    
    </div>
    </div>

    <!-- Modal TTE EWS-->
    <div id="myModal6" class="modal fade" role="dialog">
        <div class="modal-dialog">
    
        <!-- Modal content-->
        <form id="form-tte-ews" action="{{ url('tte-pdf-ews') }}" method="POST">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">TTE EWS</h4>
            </div>
            <div class="modal-body row" style="display: grid;">
                {!! csrf_field() !!}
                <input type="hidden" class="form-control" name="ews_id" id="ews_id_hidden" disabled>
                <input type="hidden" class="form-control" name="nik" id="nik_hidden" value="{{Auth::user()->pegawai->nik}}" disabled>
            <div class="form-group">
                <label class="control-label col-sm-2" for="pwd">Nama:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="dokter" id="dokter" value="{{Auth::user()->pegawai->nama}}" disabled>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="pwd">NIK:</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="nik" value="{{substr(Auth::user()->pegawai->nik, 0, -5) . '*****'}}" disabled>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="pwd">Passphrase:</label>
                <div class="col-sm-10">
                <input type="password" class="form-control" name="passphrase" id="passphrase" value="{{session('passphrase') ? session('passphrase')['passphrase'] : ''}}">
                </div>
            </div>
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="button-proses-tte-eresume-pasien-igd">Proses TTE</button>
            </div>
        </div>
        </form>
    
        </div>
    </div>

    <!-- Modal TTE ASKEP & ASKEB-->
    <div id="myModal7" class="modal fade" role="dialog">
        <div class="modal-dialog">
    
        <!-- Modal content-->
        <form id="form-tte-askep" method="POST">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">TTE ASKEP & ASKEB</h4>
            </div>
            <div class="modal-body row" style="display: grid;">
                {!! csrf_field() !!}
                <input type="hidden" class="form-control" name="askep_id" id="askep_id_hidden" disabled>
                <input type="hidden" class="form-control" name="askeb_id" id="askeb_id_hidden" disabled>
                <input type="hidden" class="form-control" name="registrasi_id" id="registrasi_id_hidden3" disabled>
                <input type="hidden" class="form-control" name="nik" id="nik_hidden" value="{{Auth::user()->pegawai->nik}}" disabled>
            <div class="form-group">
                <label class="control-label col-sm-2" for="pwd">Nama:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="dokter" id="dokter" value="{{Auth::user()->pegawai->nama}}" disabled>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="pwd">NIK:</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="nik" value="{{substr(Auth::user()->pegawai->nik, 0, -5) . '*****'}}" disabled>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="pwd">Passphrase:</label>
                <div class="col-sm-10">
                <input type="password" class="form-control" name="passphrase" id="passphrase" value="{{session('passphrase') ? session('passphrase')['passphrase'] : ''}}">
                </div>
            </div>
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="button-proses-tte-eresume-pasien-igd">Proses TTE</button>
            </div>
        </div>
        </form>
    
        </div>
    </div>

@endsection

@section('script')
    <script>
        $('#tabelResumePasien').dataTable({
            'language'    : {
                "url": "/json/pasien.datatable-language.json",
            },
            "info": false,
            "bSort": false,
            "lengthChange": false,
            "pageLength": 5,
        });
        $('#tabelHasilRehabMedik').dataTable({
            'language'    : {
                "url": "/json/pasien.datatable-language.json",
            },
            "info": false,
            "bSort": false,
            "lengthChange": false,
            "pageLength": 5,
        });
        $('#tabelTriage').dataTable({
            'language'    : {
                "url": "/json/pasien.datatable-language.json",
            },
            "info": false,
            "bSort": false,
            "lengthChange": false,
            "pageLength": 5,
        });
        
        $('.proses-tte-eresume-pasien').click(function () {
            $('#registrasi_id_hidden').val($(this).data("registrasi-id"));
            $('#myModal').modal('show');
        })
        // $('.proses-tte').click(function () {
        //     let url = $(this).data('url');
        //     let resume_id = $(this).data('resume-id');

        //     $.ajax({
        //         url: '/cetak-eresume-medis/pdf-cek-tte/' + resume_id,
        //         type: 'get',
        //         dataType: 'json',
        //         success: function(response){
        //             $('#resume_id').val(resume_id);
        //             $('#url').val(url);
        //             $('#dokter').val(response.dokter.nama);
        //             if (response.dokter.nik) {
        //                 $('#nik').val(response.dokter.nik.substring(0, response.dokter.nik.length -5) + "*****");
        //             } else {
        //                 $('#nik').val(response.dokter.nik);
        //             }
        //             $('#nik_hidden').val(response.dokter.nik);

        //             $('#myModal').modal('show');
        //         }
        //     });
        // })

        // $('#button-proses-tte').click(function (e) {
        //     e.preventDefault();
        //     let nik = $('#nik_hidden').val();
        //     let passphrase = $('#passphrase').val();
        //     let resume_id = $('#resume_id').val();

        //     let url = $('#url').val() + '&nik=' + nik + '&passphrase=' + passphrase;
        //     window.location.href = url;
        // })

        $('#form-tte-eresume-pasien').submit(function (e) {
            e.preventDefault();
            $('input').prop('disabled', false);
            $('#form-tte-eresume-pasien')[0].submit();
        })

        $('#form-tte-eresume-pasien-baru').submit(function (e) {
            e.preventDefault();
            $('input').prop('disabled', false);
            $('#form-tte-eresume-pasien-baru')[0].submit();
        })

        $('.proses-tte-resume-medis').click(function () {
            
            $('#form-tte-eresume-medis').attr('action', $(this).data("url"));
            $('#registrasi_id_hidden2').val($(this).data("registrasi-id"));
            $('#resume_id').val($(this).data("resume-id"));
            $('#source').val($(this).data("source"));
            $('#myModal2').modal('show');
        })

        $('#form-tte-eresume-medis').submit(function (e) {
            e.preventDefault();
            $('input').prop('disabled', false);
            $('#form-tte-eresume-medis')[0].submit();
        })

        function showTTEModalTriage(triage_id) {
            $('#form-tte-triage').attr('action', '/emr-soap/tte/tte-triage/'+triage_id)
            $('#myModal3').modal('show');
        }

        function prosesTTETriage() {
            $('input').prop('disabled', false)
            $('#form-tte-triage').submit();
        }

        $('.proses-tte-eresume-pasien-inap').click(function () {
            $('#resume_id_hidden').val($(this).data("id"));
            $('#myModal4').modal('show');
        })

        $('#form-tte-eresume-pasien-inap').submit(function (e) {
            e.preventDefault();
            $('input').prop('disabled', false);
            $('#form-tte-eresume-pasien-inap')[0].submit();
        })

        $('.proses-tte-eresume-pasien-igd').click(function () {
            $('#resume_igd_id_hidden').val($(this).data("id"));
            $('#myModal5').modal('show');
            
        })

        $('#form-tte-eresume-pasien-igd').submit(function (e) {
            e.preventDefault();
            $('input').prop('disabled', false);
            $('#form-tte-eresume-pasien-igd')[0].submit();
        })

        $('.proses-tte-ews').click(function () {
            $('#ews_id_hidden').val($(this).data("id"));
            $('#myModal6').modal('show');
            
        })

        $('#form-tte-ews').submit(function (e) {
            e.preventDefault();
            $('input').prop('disabled', false);
            $('#form-tte-ews')[0].submit();
        })

        $('.proses-tte-askep').click(function () {
            $('#registrasi_id_hidden3').val($(this).data("regid"));
            if($(this).data("type") == "asuhan-keperawatan") {
                $('#askep_id_hidden').val($(this).data("id"));
                $('#form-tte-askep').attr('action', "{{url('emr-riwayat-askep/tte')}}")
            } else {
                $('#askeb_id_hidden').val($(this).data("id"));
                $('#form-tte-askep').attr('action', "{{url('emr-riwayat-askeb/tte')}}")
            }
            $('#myModal7').modal('show');
            
        })

        $('#form-tte-askep').submit(function (e) {
            e.preventDefault();
            $('input').prop('disabled', false);
            $('#form-tte-askep')[0].submit();
        })

    </script>
@endsection