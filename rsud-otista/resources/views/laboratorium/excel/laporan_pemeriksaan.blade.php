<table>
    <thead>
        <tr>
            <th>NO</th>
            <th>TGL DAFTAR</th>
            <th>NO RM</th>
            <th>NAMA PASIEN</th>
            <th>ASAL PASIEN</th>
            <th>TGL PEMERIKSAAN</th>
            <th>DOKTER</th>
            <th>PENJAMIN</th>
            <th>JUMLAH PEMERIKSAAN LIS</th>
            <th>PEMERIKSAAN LIS</th>
        </tr>
    </thead>
    <tbody>
        @if ($kunjungan)
                
            @foreach ($kunjungan as $key=>$k)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ Carbon\Carbon::parse($k->registrasi->created_at)->format('d-m-Y') }} </td>
                    <td>{{ @$k->registrasi->pasien->no_rm }}</td>
                    <td>{{ @$k->registrasi->pasien->nama }}</td>
                    <td>
                    @isset($k->jenis)
                        @if($k->jenis == 'TA')
                            <i>Rawat Jalan</i>
                        @elseif($k->jenis == 'TI')
                            <i>Rawat Inap</i>
                        @else
                            <i>Gawat Darurat</i>
                        @endif
                    @endisset
                    </td>
                    {{-- <td> {{@$hasilLab->no_lab}} </td> --}}
                    <td> {{@$k->created_at}} </td>
                    {{-- <td> {{@baca_poli($k->poli_id)}} </td> --}}
                    <td> {{@baca_dokter($k->dokter_id)}} </td>
                    <td> {{baca_carabayar(@$k->registrasi->bayar)}} </td>
                    <td style="text-align: center;"> 
                        {{-- @if (is_iterable($k->hasillab))
                        @foreach ($k->hasillab as $hasilLab)
                            @php
                            $tp = 0;
                            $tp += $hasilLab->total_pemeriksaan;
                            @endphp
                            {{$tp}}
                        @endforeach
                        @else
                        0
                        @endif --}}
                    </td>
                    <td> 
                        {{-- @if (is_iterable($k->hasillab))
                        @foreach ($k->hasillab as $hlab)
                            Nomor Lab : <b>{{$hlab->no_lab}}</b>
                            <br>
                            <br>
                            @if (is_iterable($hlab->jenis_pemeriksaan))
                            <ul>
                                @forelse ($hlab->jenis_pemeriksaan as $key => $jenis_pemeriksaan)
                                <li><b>{{$key}}</b></li>
                                @if (is_iterable($jenis_pemeriksaan))
                                    @foreach ($jenis_pemeriksaan as $pem)
                                    - {{$pem->test_name}} <br>
                                    @endforeach
                                @endif
                                @empty
                                -
                                @endforelse
                            </ul>
                            @endif
                            <br>
                            <hr style="color: black;">
                            <br>
                        @endforeach
                        @endif --}}
                    </td>
                    {{-- <td>{{@baca_carabayar(@$k->jenis_pasien)}}</td> --}}
                </tr>
            @endforeach
        @endif
    </tbody>
</table>