@php
    $jambuka = jamLaporan('pratinjau');
@endphp
<div class='table-responsive'>
  <table class='table table-striped table-bordered table-hover table-condensed' id='' style="font-size:12px;">
    <thead>
      <th>No</th>
      <th>No. RM</th>
      <th>Nama Pasien</th>
      <th class="text-center">Kelamin</th>
      <th class="text-center">Tgl Masuk</th>
      <th class="text-center">Tgl Keluar</th>
      <th class="text-center">Ruangan</th>
      <th class="text-center">No SEP</th>
      <th class="text-center">RB</th>
      <th class="text-center">SEP</th>
      <th class="text-center">E-Resume</th>
      <th class="text-center">Resep</th>
      <th class="text-center">Hasil Lab</th>
      <th class="text-center">Hasil Lab PA</th>
      <th class="text-center">Hasil Radiologi</th>
      <th class="text-center">Surat Kontrol</th>
      <th class="text-center">Lembar Konsul</th>
      <th class="text-center">APGAR Score</th>
      <th class="text-center">Gizi</th>
      <th class="text-center">Surat Kematian</th>
      <th class="text-center">Triage</th>
      <th class="text-center">CPPT</th>
      <th class="text-center">Laporan Tindakan</th>
      <th class="text-center">Laporan Persalinan</th>
      <th class="text-center">Partograf</th>
      <th class="text-center">Laporan Kuret</th>
      <th class="text-center">Code ICD</th>
      {{-- <th class="text-center">Pratinjau Semua</th> --}}
      <th class="text-center">Pratinjau Dummy</th>
      @if ($jambuka)
        <th class="text-center">Pratinjau Semua</th>
      @endif
      <th class="text-center">E-Klaim</th>
      <th class="text-center">Hasil Upload</th>
      <th class="text-center">Upload Operasi</th>
      <th class="text-center">Kriteria ICU</th>
    </thead>
    <tbody>
      @foreach ($registrasi as $key => $r)
        @php
          $status_reg = cek_status_reg($r->status_reg);
        @endphp
        <tr>
          <td class="text-center">{{$no++}}</td>
          <td class="text-center">{{$r->pasien->no_rm}}</td>
          <td class="text-center {{$r->registrasi->is_koding == 1 ? 'blink_me' : ''}}">{{$r->pasien->nama}}</td>
          <td class="text-center">{{$r->pasien->kelamin}}</td>
          <td class="text-center" style="font-size:11px;">{{$r->tgl_masuk}}</td>
          <td class="text-center" style="font-size:11px;">{{$r->tgl_keluar}}</td>
          <td>{{baca_kamar($r->kamar_id)}}</td>
          <td class="text-center">{{$r->registrasi->no_sep ?? '-'}}</td>
          <td class="text-center">
            @if ($status_reg == "J")
              <a href="{{ url('/ranap-informasi-unit-item-rincian-biaya-tanpa-kronis/'.$r->registrasi_id) }}" target="_blank"  class="btn btn-danger btn-sm btn-flat"><i class="fa fa-print text-center"></i> </a>
            @else
              <a href="{{ url('/ranap-informasi-unit-item-rincian-biaya-tanpa-rajal/'.$r->registrasi_id) }}" target="_blank"  class="btn btn-danger btn-sm btn-flat"><i class="fa fa-print text-center"></i> </a>
            @endif
          </td>
          <td class="text-center">
            @if (!empty($r->registrasi->no_sep))
            <a href="{{ url('cetak-sep-new/'.$r->registrasi->no_sep) }}" target="_blank"  class="btn btn-info btn-sm btn-flat"><i class="fa fa-print text-center"></i> </a>
            @else
            -
            @endif
          </td>
          <td class="text-center">
            @php
              $resume_ranap = App\EmrInapPerencanaan::where('registrasi_id', $r->registrasi_id)->where('type', 'resume')->first();
            @endphp
            @if ($resume_ranap)
              @if (!empty(json_decode(@$resume_ranap->tte)->base64_signed_file))
                <a href="{{ url('cetak-tte-eresume-pasien-inap/pdf/' . @$resume_ranap->id) }}"
                  target="_blank" class="btn btn-success btn-sm btn-flat"> <i
                    class="fa fa-print"></i> </a>
              @else
              <a href="{{ url('cetak-eresume-pasien-inap/pdf/'.$resume_ranap->id) }}" target="_blank"  class="btn btn-warning btn-sm btn-flat"><i class="fa fa-print text-center"></i> </a>
              @endif
            @else
              -
            @endif
          </td>
          <td class="text-center">
            <button type="button" class="btn btn-sm btn-primary btn-flat" onclick="popupWindow('/penjualan/tab-resep/'+{{$r->registrasi_id}})" style="margin-bottom: 5px;"><i class="fa fa-list"></i></button>
          </td>
          <td class="text-center">
            @if (!empty(json_decode(@$r->tte_hasillab_lis)->base64_signed_file))
              <a href="{{ url('pemeriksaanlab/cetakAll-lis-tte/' . @$r->registrasi_id) }}"
                target="_blank" class="btn btn-success btn-sm btn-flat"> <i
                  class="fa fa-print"></i> </a>
            @else
            <a href="{{ url('pemeriksaanlab/cetakAll-lis/'.$r->registrasi_id) }}" target="_blank"  class="btn btn-warning btn-sm btn-flat"><i class="fa fa-print text-center"></i> </a>
            @endif
          </td>
          <td class="text-center">
            @if(@$d->hasilLab_patalogi)
              <a href="{{ url('pemeriksaanlabCommon/cetakAll/'.$r->registrasi_id) }}" target="_blank"  class="btn btn-warning btn-sm btn-flat"><i class="fa fa-print text-center"></i> </a>
            @endif
          </td>
          
          <td class="text-center">
            <button type="button" class="btn btn-sm btn-success btn-flat" onclick="popupWindow('/frontoffice/tab-radiologi/'+{{$r->registrasi_id}})" style="margin-bottom: 5px;"><i class="fa fa-list"></i></button>
          </td>
          <td class="text-center">
            <button type="button" class="btn btn-sm btn-info btn-flat" onclick="popupWindow('/frontoffice/tab-surkon-casemix/'+{{$r->registrasi_id}})" style="margin-bottom: 5px;"><i class="fa fa-list"></i></button>
          </td>
          <td class="text-center">
            @if ($r->registrasi->konsul)
              @foreach ($r->registrasi->konsul as $konsul)
                @if (count($konsul->data_jawab_konsul) > 0)
                    <button type="button" data-toggle="tooltip"
                        data-id="{{ $konsul->id }}"
                        class="btn btn-success btn-xs btn-lihat-jawab">Lihat</button>&nbsp;&nbsp;
                @endif
              @endforeach
            @endif
          </td>
          <td class="text-center">
            @if ($r->registrasi->apgar_score)
              <a href="{{ url('emr-soap/pemeriksaan/cetak_apgar_score/'. @$r->registrasi_id .'/'. @$r->registrasi->apgar_score->id) }}" target="_blank" class="btn btn-sm btn-danger btn-flat" style="margin-bottom: 5px;"><i class="fa fa-download"></i></a>
            @endif
          </td>
          <td class="text-center">
            @if ($r->registrasi->pengkajian_gizi)
              <a href="{{ url('emr-soap/pemeriksaan/cetak_pengkajian_gizi/'. @$r->registrasi_id .'/'. @$r->registrasi->pengkajian_gizi->id) }}" target="_blank" class="btn btn-sm btn-danger btn-flat" style="margin-bottom: 5px;"><i class="fa fa-download"></i></a>
            @endif
          </td>
          <td class="text-center">
            @if ($r->registrasi->kematian)
              <a href="{{ url('emr-soap-print-surat-kematian/'. @$r->registrasi_id . '/'. @$r->registrasi->kematian->id) }}" target="_blank" class="btn btn-sm btn-danger btn-flat" style="margin-bottom: 5px;"><i class="fa fa-download"></i></a>
            @endif
          </td>
          <td class="text-center">
            @if ($r->registrasi->triage)
              <a href="{{ url('cetak-triage-igd/pdf/'. @$r->registrasi_id . '/'. @$r->registrasi->triage->id) }}" target="_blank" class="btn btn-sm btn-danger btn-flat" style="margin-bottom: 5px;"><i class="fa fa-download"></i></a>
            @endif
          </td>
          <td class="text-center">
            <button type="button" class="btn btn-sm btn-warning btn-flat" onclick="popupWindow('/frontoffice/tab-cppt-igd/'+{{$r->registrasi->id}})" style="margin-bottom: 5px;"><i class="fa fa-list"></i></button>
          </td>
          <td class="text-center">
            <button type="button" class="btn btn-sm btn-success btn-flat" onclick="popupWindow('/frontoffice/tab-lap-tindakan/'+{{$r->registrasi_id}})" style="margin-bottom: 5px;"><i class="fa fa-list"></i></button>
          </td>
          <td class="text-center">
            @if ($r->registrasi->laporan_persalinan)
              <a href="{{ url('emr-soap/pemeriksaan/cetak_laporan_persalinan' . '/' . $r->registrasi_id) }}" target="_blank" class="btn btn-sm btn-danger btn-flat" style="margin-bottom: 5px;"><i class="fa fa-download"></i></a>
            @endif
          </td>
          <td class="text-center">
            @if ($r->registrasi->partograf)
              <a href="{{ url('emr-soap/pemeriksaan/cetak_partograf' . '/' . $r->registrasi_id) }}" target="_blank" class="btn btn-sm btn-danger btn-flat" style="margin-bottom: 5px;"><i class="fa fa-download"></i></a>
            @endif
          </td>
          <td class="text-center">
            @if ($r->registrasi->laporan_kuret)
              <a href="{{ url('emr-soap/pemeriksaan/cetak_laporan_kuret' . '/' . $r->registrasi_id) }}" target="_blank" class="btn btn-sm btn-danger btn-flat" style="margin-bottom: 5px;"><i class="fa fa-download"></i></a>
            @endif
          </td>
          <td class="text-center">
            <a href="{{ url('frontoffice/jkn-input-diagnosa-irna/'.@$r->registrasi_id) }}" target="_blank" class="btn btn-info btn-sm btn-flat"><i class="fa fa-tint"></i></a>
          </td>
          {{-- <td class="text-center">
              <a href="{{ url('frontoffice/download-all/'.@$r->registrasi_id) }}" target="_blank" class="btn btn-sm btn-danger btn-flat" style="margin-bottom: 5px;"><i class="fa fa-download"></i></a>
          </td> --}}
          <td class="text-center">
            <a href="http://172.168.1.2/frontoffice/download-all/{{@$r->registrasi_id}}" target="_blank" class="btn btn-sm btn-danger btn-flat" style="margin-bottom: 5px;"><i class="fa fa-download"></i></a>
          </td>
          @if ($jambuka)
          <td class="text-center">
              <a href="{{ url('frontoffice/download-all/'.@$r->registrasi_id) }}" target="_blank" class="btn btn-sm btn-danger btn-flat" style="margin-bottom: 5px;"><i class="fa fa-download"></i></a>
            </td>
            @endif
          <td class="text-center">
              <a href="{{ url('cetak-e-claim/'.@$r->no_sep) }}" target="_blank" class="btn btn-sm btn-danger btn-flat" style="margin-bottom: 5px;"><i class="fa fa-download"></i></a>
          </td>
          <td>
            <a href="{{ url("frontoffice/hasil-upload/".@$r->registrasi->id) }}" target="_blank" class="btn btn-warning btn-sm">
              <i class="fa fa-eye"></i>
            </a>
          </td>
          <td>
            <a href="{{ url("frontoffice/hasil-upload-operasi/".@$r->registrasi->id) }}" target="_blank" class="btn btn-primary btn-sm">
              <i class="fa fa-eye"></i>
            </a>
          </td>
          <td class="text-center">
            <button type="button" class="btn btn-sm btn-info btn-flat" onclick="popupWindow('/frontoffice/tab-kriteria-icu/'+{{$r->registrasi_id}})" style="margin-bottom: 5px;"><i class="fa fa-list"></i></button>
          </td>
          {{-- <td> 
            <div class="btn-group">
              <button type="button" class="btn btn-sm btn-success">Cetak</button>
              <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
              </button>
              <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
              @foreach ($r->registrasi->ekspertise as $p)
                <li>
                <a href="{{ url("radiologi/cetak-ekpertise/".$p->id."/".$p->registrasi_id."/".$p->folio_id) }}" target="_blank" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> {{ $p->no_dokument ?$p->no_dokument: $p->created_at }} </a>
                </li>
              @endforeach
              </ul>
            </div>
          </td> --}}
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
<div class="modal fade" id="modalRincianBiaya" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id=""></h4>
      </div>
      <div class="modal-body">
        <div class='table-responsive'>
          <div class="rincian_biaya">
          </div>
          
          <br/>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th>No</th>
                <th>Tindakan</th>
                {{--<th>Waktu Entry Tindakan</th>--}}
                <th>Jenis Pelayanan</th>
                <th>Biaya</th>
              </tr>
            </thead>
            <tbody class="tagihan">
            </tbody>
            <tfoot>
              <tr>
                <th class="text-center" colspan="2">
                  <div class="rincian_biaya">

                  </div>
                </th>
                <th class="text-right">Total Tagihan</th>
                <th class="text-right totalTagihan"></th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="echocardiogramModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <form method="POST" class="form-horizontal" id="formEkspertise">
          {{ csrf_field() }}
          <input type="hidden" name="registrasi_id" value="">
          <input type="hidden" name="pasien_id" value="">
          <input type="hidden" name="jenis" value="TA">
          <input type="hidden" name="id" value="">
        <div class="table-responsive">
          <table class="table table-condensed table-bordered">
            <tbody>
              <tr>
                <th>Pasien </th> <td class="nama"></td>
                <th>Umur </th><td class="umur"></td>
              </tr>
              <tr>
                <th>Jenis Kelamin </th><td class="jk" colspan="1"></td>
                <th>No. RM </th><td class="no_rm" colspan="2"></td>
              </tr>
              <tr>
                <th>Fungsi Sistolik LV</th>
                <td>
                  <select name="fungsi_sistolik" class="form-control select2" style="width: 100%">
                    <option value="baik">Baik</option>
                    <option value="cukup">Cukup</option>
                    <option value="menurun">Menurun</option>
                  </select>
                </td>
                <th>Dimensi Ruang Jantung</th>
                <td>
                  <select name="dimensi_ruang_jantung" class="form-control select2" style="width: 100%">
                    <option value="normal">Normal</option>
                    <option value="la_dilatasi">La dilatasi</option>
                    <option value="lv_dilatasi">Lv dilatasi</option>
                    <option value="ra_dilatasi">Ra dilatasi</option>
                    <option value="rv_dilatasi">Rv dilatasi</option>
                    <option value="semua_dilatasi">semua dilatasi</option>
                  </select>
                </td>
              </tr>
              <tr>
                <th>Ef</th>
                <td>
                  <input type="number" name="ef" class="form-control">
                </td>
                <th>Lv</th>
                <td>
                  <select name="lv" class="form-control select2" style="width: 100%">
                    <option value="konsentrik(+)">Konsentrik (+)</option>
                    <option value="Eksentrik(+)">Eksentrik(+)</option>
                    <option value="(-)">(-)</option>
                  </select>
                </td>
              </tr>
              <tr>
                <th>Global</th>
                <td>
                  <select name="global" class="form-control select2" style="width: 100%">
                    <option value="normokinetik">Normokinetik</option>
                    <option value="hipokinetik">Hipokinetik</option>
                    <option value="(-)">(-)</option>
                  </select>
                </td>
                <th>Fungsi Sistolik Rv</th>
                <td>
                  <select name="fungsi_sistolik_rv" class="form-control select2" style="width: 100%">
                    <option value="baik">Baik</option>
                    <option value="menurun">Menurun</option>
                  </select>
                </td>
              </tr>
              <tr>
                <th>Tapse</th>
                <td>
                  <select name="tapse" class="form-control select2" style="width: 100%">
                    <option value="<_16">< 16</option>
                    <option value=">_16">> 16</option>
                  </select>
                </td>
                <th>Katup-Katup Jantung Mitral</th>
                <td>
                  <select name="katup_katup_jantung_mitral" class="form-control select2" style="width: 100%">
                    <option value="ms_ringan">ms_ringan</option>
                    <option value="ms_sedang">ms_sedang</option>
                    <option value="ms_berat">ms_berat</option>
                  </select>
                </td>
              </tr>
              <tr>
                <th>Katup-Katup Jantung Aorta</th>
                <td>
                  <select name="katup_katup_jantung_aorta" class="form-control select2" style="width: 100%">
                    <option value="3_cuspis">3 cuspis</option>
                    <option value="2_cuspis">2 cuspis</option>
                  </select>
                </td>
                <th>Katup-Katup Jantung Trikuspid</th>
                <td>
                  <select name="katup_katup_jantung_trikuspid" class="form-control select2" style="width: 100%">
                    <option value="tr_ringan">Tr Ringan</option>
                    <option value="tr_sedang">Tr Sedang</option>
                    <option value="tr_berat">Tr Berat</option>
                  </select>
                </td>
              </tr>
              <tr>
                <th>Katup-Katup Jantung Aorta Lain-Lain</th>
                <td>
                  <input type="text" name="katup_katup_jantung_aorta_cuspis" class="form-control">
                </td>
                <th>Katup-Katup Jantung Pulmonal</th>
                <td>
                  <select name="katup_katup_jantung_pulmonal" class="form-control select2" style="width: 100%">
                    <option value="pr_ringan">Pr Ringan</option>
                    <option value="pr_sedang">Pr Sedang</option>
                    <option value="pr_berat">Pr Berat</option>
                  </select>
                </td>
              </tr>
              <tr>
                <th>Catatan Dokter</th>
                <td colspan="3">
                  <textarea name="catatan_dokter" class="form-control wysiwyg"></textarea>
                </td>
              </tr>
              <tr>
                <th>Kesimpulan</th>
                <td colspan="3">
                  <textarea name="kesimpulan" class="form-control wysiwyg"></textarea>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary btn-flat" onclick="saveEkpertise()">Simpan</button>
      </div>
    </div>
  </div>
</div>

<div id="modals" class="modal fade" role="dialog">
  <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              {{-- <h4 class="modal-title">Jawab Konsul</h4> --}}
          </div>
          <div class="modal-body" id="dataModals">

          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
      </div>

  </div>
</div>

@section('script')
@parent
<script>
  $(document).on('click', '.btn-lihat-jawab', function() {
          let id = $(this).attr('data-id');
          $('#dataModals').html('');
          $('#dataModals').load('/emr-datajawabankonsul/' + id);
          $('#modals').modal('show');
          console.log(id);
    })
</script>
<script type="text/javascript">
  function ribuan(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  }

  function jenisLayanan(jenis) {
    switch (jenis) {
      case 'TA':
        return 'Layanan rawat jalan';
        break;
      case 'TG':
        return 'Layanan rawat darurat';
        break;
      case 'TI':
        return 'Layanan rawat inap';
        break;
      default:
        return 'Apotik';
        break;
    }
  }
  function rincianBiaya(registrasi_id, nama, no_rm) {
    $('#modalRincianBiaya').modal('show');
    $('.modal-title').text(nama + ' | ' + no_rm + '|' + registrasi_id)
    $('.tagihan').empty();
    $('.rincian_biaya').empty();
    $.ajax({
      url: '/informasi-rincian-biaya/' + registrasi_id,
      type: 'GET',
      dataType: 'json',
      success: function (data) {
        cetak = '<a class="btn btn-info btn-sm pull-right" style="margin-left:10px" target="_blank" href="/ranap-informasi-rincian-biaya/'+registrasi_id+'"><span class="fa fa-print"></span> Rincian Biaya</a>';
        cetak2 = '<a class="btn btn-success btn-sm pull-right" target="_blank" href="/ranap-informasi-unit-rincian-biaya/'+registrasi_id+'"><span class="fa fa-print"></span> Rincian Biaya Unit</a><br/>';
        cetak3 = '<a class="btn btn-danger btn-sm pull-right" style="margin-left:20px;" target="_blank" href="/ranap-informasi-unit-item-rincian-biaya-tanpa-kronis/'+registrasi_id+'"><span class="fa fa-print"></span> Rincian Biaya(Klaim)</a>';
        $('.rincian_biaya').append(cetak3)
        $('.rincian_biaya').append(cetak)
        $('.rincian_biaya').append(cetak2)
        // console.log(data);
        $.each(data, function (key, value) {
          $('.tagihan').append('<tr> <td>' + (key + 1) + '</td> <td>' + value.namatarif + '</td> <td>' + jenisLayanan(value.jenis) + '</td> <td class="text-right">' +
            ribuan(value.total) + '</td> </tr>')
        });
      }
    });

    $.ajax({
      url: '/informasi-total-biaya/' + registrasi_id,
      type: 'GET',
      dataType: 'json',
      success: function (data) {
        console.log(data);
        $('.totalTagihan').html(ribuan(data))
      }
    });
  }
  $('table').DataTable({
    paging: true, 
    // ordering: false,
    order: [],     
    columnDefs: [
        { orderable: true, targets: [5] }, 
    ],
  });

  function popupWindow(mylink) {
    console.log(mylink);
      if (!window.focus) return true;
      var href;
      if (typeof (mylink) == 'string')
        href = mylink;
      else href = mylink.href;
      window.open(href, "Resep", 'width=500,height=500,scrollbars=yes');
      return false;
    }

    
  
</script>
@endsection