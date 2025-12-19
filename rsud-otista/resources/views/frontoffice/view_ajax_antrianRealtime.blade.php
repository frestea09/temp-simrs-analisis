<div class='table-responsive'>
  @php
    $jambuka = jamLaporan('pratinjau');
@endphp
  <table class='table table-striped table-bordered table-hover table-condensed' id='' style="font-size:12px;">
    <thead>
      <th>No</th>
      <th>No. RM</th>
      <th>Nama Pasien</th>
      <th class="text-center">Kelamin</th>
      <th class="text-center">Tgl Registrasi</th>
      <th class="text-center">Pelayanan</th>
      <th class="text-center">Poli</th>
      <th class="text-center">No SEP</th>
      {{--<th class="text-center">RB</th>--}}
      {{--<th class="text-center">SEP</th>---}}
      <th class="text-center">E-Resume</th>
      {{--<th class="text-center">Resep</th>--}}
      {{--<th class="text-center">Hasil Lab</th>--}}
      <th class="text-center">Lembar Konsul</th>
      <th class="text-center">Hasil Radiologi</th>
      <th class="text-center">Surat Kontrol</th>
      <th class="text-center">Laporan Tindakan</th>
      <th class="text-center">Obat Farmasi</th>
      <th class="text-center">Code ICD</th>
      <th class="text-center">Hasil Coding</th>
      <th class="text-center">Pratinjau Dummy</th>
      @if ($jambuka)
        <th class="text-center">Pratinjau Semua</th>
      @endif
      
      <th class="text-center">E-Klaim</th>
      <th class="text-center">Layanan Rehab</th>
      <th class="text-center">Program Terapi</th>
      <th class="text-center">Uji Fungsi</th>
      <th class="text-center">Prostodonti</th>
      <th class="text-center">Hasil Upload</th>
      <th class="text-center">Upload Operasi</th>
    </thead>
    <tbody>
      @foreach ($registrasi as $key => $r)
        @php
          $status_reg = cek_status_reg($r->status_reg);
        @endphp
        <tr>
          <td class="text-center">{{$no++}}</td>
          <td class="text-center">{{@$r->pasien->no_rm}}</td>
          <td class="text-center {{@$r->registrasi->is_koding == 1 ? 'blink_me' : ''}}">{{@$r->pasien->nama}}</td>
          <td class="text-center">{{@$r->pasien->kelamin}}</td>
          <td class="text-center" style="font-size:11px;">{{@$r->created_at}}</td>
          <td>
            @if ($status_reg == 'I')
              {{-- Rawat Inap --}}
              @php
                $rawatinap = @$r->rawat_inap;
              @endphp
              {{ !empty($rawatinap) ? baca_kamar(@$rawatinap->kamar) : NULL }}
            @elseif ($status_reg == 'J')
              {{-- Rawat Jalan --}}
              Poli {{ @$r->poli->nama }}
            @elseif ($status_reg == 'G')
              IGD
            @endif
          </td>
          <td>{{ @$r->poli->nama }}</td>
          <td class="text-center">{{@$r->no_sep ?? '-'}}</td>
          {{--<td class="text-center">
            @if ($status_reg == "J")
              <a href="{{ url('/ranap-informasi-unit-item-rincian-biaya-tanpa-kronis/'.$r->id) }}" target="_blank"  class="btn btn-danger btn-sm btn-flat"><i class="fa fa-print text-center"></i> </a>
            @else
              <a href="{{ url('/ranap-informasi-unit-item-rincian-biaya-tanpa-rajal/'.$r->id) }}" target="_blank"  class="btn btn-danger btn-sm btn-flat"><i class="fa fa-print text-center"></i> </a>
            @endif
          </td>--}}
          {{--<td class="text-center">
            @if (!empty($r->no_sep))
            <a href="{{ url('cetak-sep-new/'.$r->no_sep) }}" target="_blank"  class="btn btn-info btn-sm btn-flat"><i class="fa fa-print text-center"></i> </a>
            @else
            -
            @endif
          </td>--}}
          <td class="text-center">
            @if (!empty(json_decode(@$r->tte_resume_pasien)->base64_signed_file))
              <a href="{{ url('cetak-tte-eresume-pasien/pdf/' . @$r->id) }}"
                target="_blank" class="btn btn-success btn-sm btn-flat"> <i
                  class="fa fa-print"></i> </a>
            @elseif (!empty(@$r->tte_resume_pasien))
              <a href="{{ url('tte_resume_pasien/' . @$r->tte_resume_pasien) }}"
                target="_blank" class="btn btn-success btn-sm btn-flat"> <i
                  class="fa fa-print"></i> </a>
            @else
              <a href="{{ url('cetak-eresume-pasien/pdf/'.@$r->id) }}" target="_blank"  class="btn btn-warning btn-sm btn-flat"><i class="fa fa-print text-center"></i> </a>
            @endif
          </td>
          {{--<td class="text-center">
            <button type="button" class="btn btn-sm btn-primary btn-flat" onclick="popupWindow('/penjualan/tab-resep/'+{{$r->id}})" style="margin-bottom: 5px;"><i class="fa fa-list"></i></button>
          </td>--}}
          {{--<td class="text-center">
            @if (!empty(json_decode(@$r->tte_hasillab_lis)->base64_signed_file))
              <a href="{{ url('pemeriksaanlab/cetakAll-lis-tte/' . @$r->id) }}"
                target="_blank" class="btn btn-success btn-sm btn-flat"> <i
                  class="fa fa-print"></i> </a>
            @else
            <a href="{{ url('pemeriksaanlab/cetakAll-lis/'.$r->id) }}" target="_blank"  class="btn btn-warning btn-sm btn-flat"><i class="fa fa-print text-center"></i> </a>
            @endif
          </td>--}}
          {{--<td class="text-center">
            @if(@$d->hasilLab_patalogi)
              <a href="{{ url('pemeriksaanlabCommon/cetakAll/'.$r->id) }}" target="_blank"  class="btn btn-warning btn-sm btn-flat"><i class="fa fa-print text-center"></i> </a>
            @endif
          </td>--}}
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
            <button type="button" class="btn btn-sm btn-success btn-flat" onclick="popupWindow('/frontoffice/tab-radiologi/'+{{$r->id}})" style="margin-bottom: 5px;"><i class="fa fa-list"></i></button>
          </td>
          <td class="text-center">
            <button type="button" class="btn btn-sm btn-info btn-flat" onclick="popupWindow('/frontoffice/tab-surkon-casemix/'+{{$r->id}})" style="margin-bottom: 5px;"><i class="fa fa-list"></i></button>
          </td>
          <td class="text-center">
            <button type="button" class="btn btn-sm btn-success btn-flat" onclick="popupWindow('/frontoffice/tab-lap-tindakan/'+{{$r->id}})" style="margin-bottom: 5px;"><i class="fa fa-list"></i></button>
          </td>
          <td class="text-center">
            <button type="button" class="btn btn-sm btn-danger btn-flat" onclick="popupWindow('/penjualan/tab-obat-farmasi/'+{{$r->id}})" style="margin-bottom: 5px;"><i class="fa fa-list"></i></button>
          </td>
          <td class="text-center">
            <a href="{{ url('frontoffice/jkn-input-diagnosa-irj/'.@$r->id) }}" target="_blank" class="btn btn-info btn-sm btn-flat"><i class="fa fa-tint"></i></a>
          </td>
          <td class="text-center">
            <button type="button" class="btn btn-sm btn-warning btn-flat" onclick="popupWindow('/frontoffice/tab-coding/'+{{$r->id}})" style="margin-bottom: 5px;"><i class="fa fa-list"></i></button>
          </td>
          <td class="text-center">
            <a href="http://172.168.1.2/frontoffice/download-all/{{@$r->id}}" target="_blank" class="btn btn-sm btn-danger btn-flat" style="margin-bottom: 5px;"><i class="fa fa-download"></i></a>
          </td>
          @if ($jambuka)
          <td class="text-center">
              <a href="{{ url('frontoffice/download-all/'.@$r->id) }}" target="_blank" class="btn btn-sm btn-danger btn-flat" style="margin-bottom: 5px;"><i class="fa fa-download"></i></a>
              {{-- <a href="http://172.168.1.2/frontoffice/download-all/{{@$r->id}}" target="_blank" class="btn btn-sm btn-danger btn-flat" style="margin-bottom: 5px;"><i class="fa fa-download"></i></a> --}}
            </td>
            @endif
          <td class="text-center">
              <a href="{{ url('cetak-e-claim/'.@$r->no_sep) }}" target="_blank" class="btn btn-sm btn-danger btn-flat" style="margin-bottom: 5px;"><i class="fa fa-download"></i></a>
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
          <td>
            @if ($r->registrasi->layanan_rehab)
              <a href="{{ url("cetak-layanan-rehab/pdf/".@$r->registrasi->id."/".@$r->registrasi->layanan_rehab->id) }}" target="_blank" class="btn btn-warning btn-sm">
                <i class="fa fa-print"></i>
              </a>
            @endif
          </td>
          <td>
            @if ($r->registrasi->program_terapi)
              <a href="{{ url("cetak-all-program-terapi/pdf/".@$r->registrasi->id."/".@$r->registrasi->pasien_id) }}" target="_blank" class="btn btn-warning btn-sm">
                  <i class="fa fa-print"></i>
                </a>
            @endif
          </td>
          <td>
            @if ($r->registrasi->uji_fungsi)
              <a href="{{ url("cetak-all-uji-fungsi/pdf/".@$r->registrasi->id."/".@$r->registrasi->pasien_id) }}" target="_blank" class="btn btn-warning btn-sm">
                <i class="fa fa-print"></i>
              </a>
            @endif
          </td>
          <td>
            @php
                $prostodonti = @App\EmrInapPenilaian::where('registrasi_id', @$r->registrasi->id)->where('type', 'prostodonti')->first();
            @endphp
            @if ($prostodonti)
              <a href="{{ url("emr-soap-print-prostodonti/".@$r->registrasi->id) }}" target="_blank" class="btn btn-warning btn-sm">
                <i class="fa fa-print"></i>
              </a>
            @endif
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