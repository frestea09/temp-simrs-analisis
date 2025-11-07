<div class='table-responsive'>
  <table class='table table-striped table-bordered table-hover table-condensed' id='datas'>
    <thead>
      <tr>
        <th>Antrian</th>
        {{-- <th style="width:8%">Antrian Booking</th> --}}
        <th>Pasien</th>
        <th>RM</th>
        <th>Usia</th>
        <th>Tgl.Lahir</th>
        <th>Dokter</th>
        <th>Poli</th>
        <th>Bayar</th>
        <th style="width:8%">Tgl.Reg</th>
      
        {{-- <th>Cara Daftar</th>   --}}
        <th>Cara Registrasi</th>
        {{-- <th style="width:8%">LAB</th>
        <th style="width:8%">RAD</th> --}}
        {{-- <th style="width:8%">SBPK</th> --}}
        {{-- <th style="width:8%">ECHO</th> --}}
        <th>Proses</th>
        <th>Barcode 2</th>
        {{-- <th class="text-center" style="vertical-align: middle">RB</th> --}}
        {{-- <th>Cetak</th> --}}
        <th>RB Obat Kronis</th>
        <th>RB Obat N.Kronis</th>
        <th>RB</th>
        <th>Kontrol</th>
        <th>SOAP</th>  
      
        {{-- <th>Antrian</th> --}}
        {{-- <th>SOAP</th> --}}
        <th>Poli</th>
        <th>SPRI</th>
        <th>Resep</th>
        <th>Cetakan Resep</th>
        <th>Cetak Konsul</th>
        <th>Surat Kontrol</th>
        <th>Surat Sakit</th>
        <th>SPRI MANUAL</th>
        {{-- <th>Gelang</th> --}}
      </tr>

     


    </thead>
    <tbody>
      @foreach ($registrasi as $key => $d)
          
          @if ($d->carabayar !== 'Umum')
            @if (!$d->no_sep)
                <tr style="background-color: rgb(255, 221, 221)">
            @else
                <tr id="row-{{ $d->id }}">  
            @endif
          
          @else
                <tr id="row-{{ $d->id }}">
          @endif
            <td>
                <div style="display: flex; gap: 5px">
                    @php
                        $colors = ['#00c0ef', '#FE7A36', '#3652AD', '#280274', '#191D88', '#1450A3', '#337CCF', '#FFC436', '#7E2553', '#2D3250','black']
                    @endphp
                    <a href="{{ (($d->status) > 8) ? 'javascript:void(0)' : url('/antrian_poli/panggilkembali2/'.@$d->nomor_antrian.'/'.@$d->antrian_poli_id.'/'.@$d->poli_id.'/'.$d->id)}}" 
                        {{ (($d->status) > 8) ? "disabled" : "" }} 
                        class="btn btn-sm btn-flat"
                        style="background-color: {{@$colors[$d->status]}}; color:white">
                        <i class="fa fa-microphone"></i>
                    </a>
                    {{-- @if( !baca_nomorantrian_bpjs(@$d->nomorantrian) )
                        {{ @$d->kelompok_antrian .  @$d->nomor_antrian }}
                    @else
                        {{ baca_nomorantrian_bpjs(@$d->nomorantrian) }}
                    @endif --}}
                    @if(!empty($d->nomorantrian_jkn))
                        {{ $d->nomorantrian_jkn }}
                    @elseif(!empty($d->nomorantrian))
                        {{ $d->nomorantrian }}
                    @else
                        {{ @$d->kelompok_antrian . @$d->nomor_antrian }}
                    @endif
                </div>
            </td>
            <td>
              @php
                  $sign_pad = $d->sign_pad; // dari controller
                  $ttd_pasien = $d->tanda_tangan;
              @endphp
              <span>
                  <i class="{{ (!$sign_pad && (empty($ttd_pasien))) ? 'blink_red' : '' }}">
                      {{ @$d->nama }}
                      {!! @$d->no_jkn ? '<br/>('.@$d->no_jkn.')' : '' !!}
                  </i>
              </span>
            </td>
            <td>{{ @$d->no_rm }}</td>
            <td>{{ hitung_umur(@$d->tgllahir) }}</td>
            <td>{{ date("d-m-Y", strtotime(@$d->tgllahir)) }}</td>
            <td>{{ @$d->dokter_dpjp }}</td>
            {{-- <td>
              @if(cek_folio_counts($d->id, $d->poli_id) > 0)
                {{ !empty($d->poli_id) ? $d->poli->nama : NULL }}
              @else
                <span style="color: red">{{ !empty($d->poli_id) ? $d->poli->nama : NULL }}</span></td>
              @endif --}}
            <td class="poli-status" data-id="{{ $d->id }}" data-poli="{{ $d->poli_id }}"></td>
            <td> {{ @$d->carabayar }} {{ @$d->carabayar ? @$d->tipe_jkn : ''}} </td> 
            <td> {{ date('d/m/Y H:i',strtotime(@$d->tgl_reg)) }}  </td>
            <td>
                {{@$d->cara_registrasi}}
            </td>
            <td>
              @if(@$d->id_kunjungan)
                  <a href="{{ url('tindakan/entry/'. @$d->id.'/'.@$d->pasien_id.'/'.@$d->id_kunjungan) }}" class="btn btn-sm btn-info btn-flat"><i class="fa fa-edit"></i></a>
              @else
                  <span class="text-danger">Maaf, Data tidak tersedia</span>
              @endif
            </td>
            <td> 
              <a href="{{ url('frontoffice/cetak_barcode2/'.$d->pasien_id.'/'.$d->id) }}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-print text-center"></i> </a>
            </td>
            <td>
              <a href="{{ url('tindakan/cetak-rincian-biaya-kronis/'. @$d->id) }}" target="_blank" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-print"></i></a>
            </td>
            <td>
              <a href="{{ url('tindakan/cetak-rincian-biaya-non-kronis/'. @$d->id) }}" target="_blank" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-print"></i></a>
            </td>
            <td class="text-center td-btn"> 
              <button type="button"
                onclick="rincianBiaya({{ @$d->id }}, '{{ RemoveSpecialChar(@$d->nama) }}', {{ @$d->no_rm }}, '{{ @$d->id }}' )"
                class="btn btn-info btn-sm btn-flat"><i class="fa fa-search"></i></button>
            </td>
            <td>
              <a href="{{ url('resume-medis/jalan/'.$d->id) }}" class="btn btn-warning btn-flat btn-sm"><i class="fa fa-paste"></i></a>
            </td>
            {{-- <td class="text-center">
              @if (!$d->nomorantrian)
                <a href="{{ url('/frontoffice/cetak-tracer/'.$d->id)}}" target="_blank" class="btn bg-purple btn-flat btn-sm"><i class="fa fa-print"></i></a>
              @else
                -
              @endif
            </td> --}}
            {{-- <td>
              <a href="{{ url('soap/jalan/'.$d->id) }}" class="btn btn-success btn-flat btn-sm"><i class="fa fa-paste"></i></a>
            </td> --}}

          
            @isset($d->status_reg)
              @if ( (substr(@$d->status_reg, 0, 1) == 'J'))
    
                <td class="text-center">
                  <a href="{{url('emr-soap/anamnesis/umum/jalan/'.@$d->id.'?poli='.@$d->poli_id.'&dpjp='.@$d->dokter_id)}}" target="_blank" class="btn btn-success btn-flat btn-sm"><i class="fa fa-paste"></i></a>
                </td> 
              @elseif (substr(@$d->status_reg, 0, 1) == 'I')

                <td class="text-center">
                  <a href="{{url('emr-soap/anamnesis/umum/inap/'.$d->id.'?poli='.@$d->poli_id.'&dpjp='.@$d->dokter_id)}}" target="_blank" class="btn btn-success btn-flat btn-sm"><i class="fa fa-paste"></i></a>
                </td>
              @endif
            @endisset

            <td>
              <a onclick="loadModal('{{ url('tindakan/order-poli/'.$d->id.'/'.$d->pasien_id) }}')" class="btn btn-warning btn-flat btn-sm"><i class="fa fa-plus"></i></a>
            </td>
            
            <td class="text-center spri-status" data-id="{{ $d->id }}">
                <small class="text-muted">Memuat...</small>
            </td>
           
            {{-- <td class="text-center">
              <a href="{{ url('tindakan/cetak-gelang/'.$d->id) }}"  target="_blank" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-print"></i></a>
             
            </td> --}}
            <td>
              <button type="button" class="btn btn-sm btn-primary btn-flat" onclick="popupWindow('/penjualan/tab-resep/' + {{$d->id}})" style="margin-bottom: 5px;"><i class="fa fa-list"></i></button>
            </td>
            <td class="text-center resep-status" data-id="{{ $d->id }}">
                <small class="text-muted">Memuat...</small>
            </td>
            {{-- <td>
              @if (@$d->resepNoteId)
              <a class="btn btn-warning btn-xs" href="{{url('/farmasi/eresep-print/'.@$d->resepNoteId)}}" target="_blank">Cetak</a>
              @endif
            </td> --}}
            <td>
              @if (@$d->konsulJawabId)
                <a id="btn-cetakKonsul" href="#modalCetakKonsul{{ @$d->id }}" class="btn btn-warning btn-sm" data-toggle="modal" data-id="{{ @$d->konsulJawabId }}"><i class="fa fa-print"></i></a>
              @else
                <span><i>belum ada</i></span>
              @endif
            </td>
            <td>
              <a href="{{url('/tindakan/cetak-kontrol/'.$d->id)}}" class="btn btn-info btn-xs">Cetak</a>
            </td>
            <td>
              <a href="{{url('/emr-soap-print-surat-byreg/'.$d->id)}}" class="btn btn-primary btn-xs">Cetak</a>
            </td>
            <td class="text-center">
              <a href="{{ url('create-spri-manual/'.$d->id) }}" target="_blank" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-bed"></i></a> 
              </td>
          </tr>

          <!-- Modal Cetak Konsul-->
          <div class="modal fade" id="modalCetakKonsul{{ $d->id }}" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="">Masukkan Keterangan Untuk Konsul</h4>
                    </div>
                    <div class="modal-body">
                      <div class="row">
                        <div class="col-md-12">
                          <form method="POST" id="formCetakKonsul" class="form-horizontal">
                            {{ csrf_field() }}
                            {{ method_field('POST') }}
                            <input type="hidden" name="regId" id="regId{{ $d->id }}" value="{{ $d->id }}">
                            <div class="form-group row">
                              <div class="col-sm-12">
                                <div>
                                  <label for="">Keterangan</label>
                                  <input type="text" name="keteranganCetakKonsul{{ $d->id }}" id="keteranganCetakKonsul{{ $d->id }}" class="form-control">
                                </div>
                              </div>
                            </div>
                            <div class="form-group row">
                              <div class="col-sm-12" style="text-align: right">
                                  <button id="" class="btn btn-primary" type="button" onclick="cetakKonsul({{ $d->id }})" >Cetak Konsul</button>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
          </div>
          <!-- End Modal Cetak Konsul-->
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
                <th class="text-right">Total Tagihan Seluruh</th>
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

@section('script')
@parent
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
        cetak3 = '<a class="btn btn-danger btn-sm pull-right" style="margin-left:20px;" target="_blank" href="/ranap-informasi-unit-item-rincian-biaya-tanpa-kronis/'+registrasi_id+'"><span class="fa fa-print"></span> Rincian Biaya(Klaim)</a>';
        $('.rincian_biaya').append(cetak3)
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
  // $('table').DataTable({
  //   paging: false, 
  //   // ordering: false,
  //   order: [],     
  //   columnDefs: [
  //       { orderable: true, targets: [5] }, 
  //   ],
  // });

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

    function cetakKonsul(registrasi_id){
    var regId = registrasi_id;
    var keterangan = $('#keteranganCetakKonsul'+registrasi_id).val();

    let dataForm = {
      "regId" : regId,
      "keterangan" : keterangan,
      "_token" : $('input[name=_token]').val(),
    };

    // console.log(dataForm);
    $.ajax({
      url: "/emr-konsul/buat-cetak-konsul",
      method: 'POST',
      dataType: 'json',
      data: dataForm,
    }).done(function(resp){
      if(resp.sukses == true){
        alert(resp.text);
        $('#modalCetakKonsul'+regId).modal('hide');
        window.open('/emr-konsul/cetak-konsul/'+resp.regId+'/'+resp.konsulId, '_blank');
        // location.reload(true);
      }else{
        alert(resp.text);
      }
    }).fail(function (res){
      if (res.status == 0) {
        alert('Gagal Terhubung ke Server, Silahkan Hubungi Pak T10')
      } else {
        alert('Gagal menyimpan')
      }
    });
  }

  
</script>
@endsection