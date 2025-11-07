@if (count(@$ews) == '0')
    <h5 class="text-center">Pasien ini tidak ada data EWS</h5>
@else
    @if (count(@$ews) > 0)
        <table style="border: 1px solid black;">
            <tr style="border: 1px solid black;">
                <td style="border: 1px solid black; padding: 1rem;">NO</td>
                <td style="border: 1px solid black; padding: 1rem;">Jenis</td>
                <td style="border: 1px solid black; padding: 1rem;">Total Skor</td>
                <td style="border: 1px solid black; padding: 1rem;">Kesimpulan</td>
                <td style="border: 1px solid black; padding: 1rem;">Detail</td>
            </tr>
            @foreach (@$ews as $item)
                @php
                    $tipe = $item->type;
                    $ews = json_decode($item->diagnosis);

                    if ($tipe == "ews-dewasa") {
                        $kesadaran = @explode(',', @$ews->tingkat_kesadaran)[1];
                        $pernapasan = @explode(',', @$ews->pernapasan)[1];
                        $saturasi_oksigen = @explode(',', @$ews->saturasi_oksigen)[1];
                        $penggunaan_oksigen = @explode(',', @$ews->penggunaan_oksigen)[1];
                        $tekanan_darah = @explode(',', @$ews->tekanan_darah)[1];
                        $denyut_jantung = @explode(',', @$ews->denyut_jantung)[1];
                        $suhu = @explode(',', @$ews->suhu)[1];
                        $total_skor = $kesadaran + $pernapasan + $saturasi_oksigen + $penggunaan_oksigen + $tekanan_darah + $denyut_jantung + $suhu;

                        if ($total_skor == 0) {
                            $style = 'background-color: rgba(3, 130, 3, 0.774); color: white; font-weight: bold;';
                            $kesimpulan = 'Monitoring per-shift oleh perawat pelaksanaan dan didokumentasikan.';
                        } elseif ($total_skor <= 3) {
                            $style = 'background-color: rgb(196, 193, 0); color: white; font-weight: bold;';
                            $kesimpulan = 'Monitoring TTV per 1 jam dikaji ulang dan lapor ke dokter.';
                        } elseif ($total_skor <= 5) {
                            $style = 'background-color: rgb(255, 128, 0); color: white; font-weight: bold;';
                            $kesimpulan = 'Monitoring TTV per 30 menit pengkajian dilakukan PJ Shift & diketahui oleh dokter jaga. Dokter jaga visit pasien & melaporkan ke DPJP untuk tata laksana selanjutnya, pasien diputuskan pindah ke HCU.';
                        } elseif ($total_skor == 6) {
                            $style = 'background-color: rgb(179, 29, 29); color: white; font-weight: bold;';
                            $kesimpulan = 'Monitoring ulang tiap 10 menit & aktifkan Code Blue, laporkan segera ke dokter / DPJP & pasien rujuk ke ICU.';
                        }else{
                            $style = '';
                            $kesimpulan = '';
                        }
                        $url = url('cetak-ews-dewasa/pdf/'. $reg->id . '/' . $item->id);
                    } elseif ($tipe == "ews-maternal") {
                        $pernapasan = @ews(@$ews->pernapasan,'skor');
                        $spo2 = @ews(@$ews->spo2,'skor');
                        $suhu = @ews(@$ews->suhu,'skor');
                        $frekuensi_jantung = @ews(@$ews->frekuensi_jantung,'skor');
                        $sitolik = @ews(@$ews->sitolik,'skor');
                        $diastolik = @ews(@$ews->diastolik,'skor');
                        $nyeri = @ews(@$ews->nyeri,'skor');

                        $total_skor = $pernapasan + $spo2 + $suhu + $frekuensi_jantung + $sitolik + $diastolik + $nyeri;

                        if ($total_skor == 0) {
                            $style = 'background-color: rgba(3, 130, 3, 0.774); color: white; font-weight: bold;';
                            $kesimpulan = '	Lakukan monitoring pershift oleh perawat pelaksana & didokumentasikan.';
                        } elseif ($total_skor <= 4) {
                            $style = 'background-color: rgb(196, 193, 0); color: white; font-weight: bold;';
                            $kesimpulan = 'Monitoring per 2 jam. Pengkajian dilakukan oleh penanggungjawab shift dan dilaporkan kepada dokter penanggungjawab.';
                        } elseif ($total_skor <= 6) {
                            $style = 'background-color: rgb(255, 128, 0); color: white; font-weight: bold;';
                            $kesimpulan = 'Lakukan monitor per 1 jam. Dokter penanggungjawab ruangan/Jaga visite kepada pasien lalu melaporkan kepada DPJP. Selanjutnya pasien akan diputuskan pindah HCU/RUJUK';
                        } elseif ($total_skor >= 7) {
                            $style = 'background-color: rgb(179, 29, 29); color: white; font-weight: bold;';
                            $kesimpulan = 'Pasien pindah ICU dengan fasilitas memadai. Bila pasien diruangan biasa aktifkan code blue.';
                        }else{
                            $style = '';
                            $kesimpulan = '';
                        }
                        $url = url('cetak-ews-maternitas/pdf/'. $reg->id . '/' . $item->id);
                    } elseif ($tipe == "ews-anak") {
                        $perilaku = @explode(',', @$ews->perilaku)[1];
                        $kulit = @explode(',', @$ews->kulit)[1];
                        $pernafasan = @explode(',', @$ews->pernafasan)[1];
                        $skor_lain = @explode(',', @$ews->skor_lain)[1];
                        $total_skor = $perilaku + $kulit + $pernafasan + $skor_lain;

                        if ($total_skor == 0) {
                            $style = 'background-color: rgba(3, 130, 3, 0.774); color: white; font-weight: bold;';
                            $kesimpulan = 'Monitoring pershift oleh perawat pelaksana dan didokumentasikan.';
                        } elseif ($total_skor <= 4) {
                            $style = 'background-color: rgb(196, 193, 0); color: white; font-weight: bold;';
                            $kesimpulan = 'Monitoring per 4 jam untuk NEWS dan MEOWS per 2 jam untuk PEWS. Pengkajian ulang dilakukan oleh PJ sift';
                        } elseif ($total_skor <= 6) {
                            $style = 'background-color: rgb(255, 128, 0); color: white; font-weight: bold;';
                            $kesimpulan = 'Monitoring per 1 jam. Pengkajian ulang dilakukan oleh PJ shift dan diketahui oleh dokter jaga, dokter jaga ruangan visit. Pasien dan melaporkan ke DPJP untuk tatalaksana selanjutnya. pasien diputuskan untuk pindah Hcu atau rencana';
                        } elseif ($total_skor >= 7) {
                            $style = 'background-color: rgb(179, 29, 29); color: white; font-weight: bold;';
                            $kesimpulan = 'Aktifkan kode blue dan pasien dipindahkan ke HCU jika fasilitas memadai. Jika HCU penuh tatalaksana dilakukan di ruang perawatan dengan monitor bed side. Jika pasien sudah stabil';
                        }else{
                            $style = '';
                            $kesimpulan = '';
                        }
                        $url = url('cetak-ews-anak/pdf/'. $reg->id . '/' . $item->id);
                    } elseif ($tipe == "ews-neonatus") {
                        $tingkat_kesadaran = @explode(',', @$ews->tingkat_kesadaran)[1];
                        $suhu = @explode(',', @$ews->suhu)[1];
                        $frekuensi_nafas = @explode(',', @$ews->frekuensi_nafas)[1];
                        $denyut_jantung = @explode(',', @$ews->denyut_jantung)[1];
                        $saturasi = @explode(',', @$ews->saturasi)[1];
                        $crt = @explode(',', @$ews->crt)[1];

                        $total_skor =   (is_numeric($tingkat_kesadaran) ? $tingkat_kesadaran : 0) +
                                        (is_numeric($suhu) ? $suhu : 0) +
                                        (is_numeric($frekuensi_nafas) ? $frekuensi_nafas : 0) +
                                        (is_numeric($denyut_jantung) ? $denyut_jantung : 0) +
                                        (is_numeric($saturasi) ? $saturasi : 0) +
                                        (is_numeric($crt) ? $crt : 0);
                        $kesimpulan = "";
                        $url = url('cetak-ews-neonatus/pdf/'. $reg->id . '/' . $item->id);
                    }

                @endphp
                    <tr style="border: 1px solid black;">
                        <td style="border: 1px solid black; padding: 1rem;">{{@$loop->iteration}}</td>
                        <td style="border: 1px solid black; padding: 1rem;">{{ strtoupper(str_replace('-', ' ', @$item->type)) }}</span></td></td>
                        <td style="border: 1px solid black; padding: 1rem;">{{$total_skor}}</td>
                        <td style="border: 1px solid black; padding: 1rem;">{{$kesimpulan}}</td>
                        <td style="border: 1px solid black; padding: 1rem;">
                            <a class="btn btn-xs btn-success" href="{{$url}}"
                                data-toggle="tooltip" title="Detail" target="_blank"><i
                                    class="fa fa-eye"></i>Detail</a>&nbsp;&nbsp;    
                        </td>
                    </tr>
            @endforeach
        </table>
        
    @endif
@endif