@extends('master')

<style>
  .form-box td,
  select,
  input,
  textarea {
    font-size: 12px !important;
  }

  .history-family input[type=text] {
    height: 20px !important;
    padding: 0px !important;
  }

  .history-family-2 td {
    padding: 1px !important;
  }
</style>
@section('header')
<h1>ANESTESI</h1>
@endsection

@section('content')
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">
    </h3>
  </div>
  <div class="box-body">
    <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>

    @include('emr_rawatinap.modules.addons.profile')
    <form method="POST" action="{{ url('emr-anestesi-inap/'.$reg->id) }}" class="form-horizontal">
      <div class="row">
        <div class="col-md-12">
          @include('emr_rawatinap.modules.addons.tabs')
          @php
              $dpjp = request()->get('dpjp');
          @endphp
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('cara_bayar', $reg->bayar) !!}
          {!! Form::hidden('unit', $unit) !!}
          {!! Form::hidden('record_id', @$history?$history->id : '') !!}
          {!! Form::hidden('dokter_id', @$dpjp?@$dpjp:$reg->dokter_id) !!}
          
          {{-- row 1 --}}
          <div class="col-md-12">
            <h4 class="text-center">ASSESMENT PRA-SEDASI /  PRA-ANESTESI</h4>
            <table style="width: 100%" border="1" cellspacing="0" cellpadding="5" >
              <tr>
                <td>Pekerjaan : {{@$pasien->pekerjaan->nama}}</td>
                <td colspan="10" rowspan="2">Cara Penerimaan  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : 
                  <input type="checkbox" {{@$histori->politipe =='J' ? 'checked' :''}}>&nbsp;IRJ 
                  <input type="checkbox" {{@$histori->politipe =='G' ? 'checked' :''}}>&nbsp;IRD <br/>
                  <input style="margin-left:130px;" type="checkbox" {{@$histori->politipe =='I' ? 'checked' :''}}>&nbsp;Langsung TP2RI </td>
              </tr>
              <tr>
                <td rowspan="2">Alamat Lengkap &nbsp;&nbsp;&nbsp; :&nbsp;&nbsp; {{@$pasien->alamat}},{{@$pasien->kabupaten->name}},{{@$pasien->kecamatan->name}}, {{@$pasien->kelurahan->name}}<br/>&nbsp;</td>
                {{-- <td>Cara masuk dikirim oleh </td> --}}
              </tr>
              <tr>
                <td colspan="10" rowspan="3">Cara masuk dikirim oleh &nbsp;&nbsp;&nbsp; :
                  <br/><input type="checkbox" {{@$registrasi->pengirim_rujukan =='9' ? 'checked' :''}}> Dokter&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox"> Instansi Lain
                  <br/><input type="checkbox" {{@$registrasi->pengirim_rujukan =='6' ? 'checked' :''}}> Puskesmas&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox"> Kasus Polisi
                  <br/><input type="checkbox" {{@$registrasi->pengirim_rujukan =='2' ? 'checked' :''}}> RS Lain&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  {{-- <input type="checkbox" {{@$registrasi->pengirim_rujukan =='7' ? 'checked' :''}}> Datang Sendiri --}}
                </td>
              </tr>
              <tr>
                <td>No. Telp / HP :&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;{{@$pasien->nohp}} </td>
              </tr>
              <tr>
                <td rowspan="3">Status Perkawinan :
                  <input type="checkbox" {{@$pasien->status_marital == 'Menikah' ? 'checked' : ''}}> Kawin&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" {{@$pasien->status_marital == 'Duda' ? 'checked' : ''}}> Duda
                  <br/><input type="checkbox" style="margin-left:107px;" {{@$pasien->status_marital == 'Blm Menikah' || @$pasien->status_marital == 'Blm Meninkah' ? 'checked' : ''}}> Belum Kawin&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox"> Dibawah Umur
                  <br/><input type="checkbox" style="margin-left:107px;"  {{@$pasien->status_marital == 'Janda' ? 'checked' : ''}}> Janda
                </td>
              </tr>
              <tr>
                <td rowspan="4" colspan="4" class="text-center">Tanggal Masuk</td>
                <td colspan="2" class="text-center">Tanggal</td>
                <td colspan="2" class="text-center">Bulan</td>
                <td colspan="2" class="text-center">Tahun</td>
              </tr>
              <tr>
                <td rowspan="3">Cara Bayar  : <b>{{baca_carabayar_new(@$registrasi->bayar)}}</b></td>
              </tr>
              <tr class="text-center">
                <td>{!!@$inap->tgl_masuk ? @substr(@$inap->tgl_masuk,8,1) : '&nbsp;'!!}</td>
                <td>{!!@$inap->tgl_masuk ? @substr(@$inap->tgl_masuk,9,1) : '&nbsp;'!!}</td>
                <td>{!!@$inap->tgl_masuk ? @substr(@$inap->tgl_masuk,5,1) : '&nbsp;'!!}</td>
                <td>{!!@$inap->tgl_masuk ? @substr(@$inap->tgl_masuk,6,1) : '&nbsp;'!!}</td>
                <td>{!!@$inap->tgl_masuk ? @substr(@$inap->tgl_masuk,2,1) : '&nbsp;'!!}</td>
                <td>{!!@$inap->tgl_masuk ? @substr(@$inap->tgl_masuk,3,1) : '&nbsp;'!!}</td>
              </tr>
              <tr>
                <td colspan="6">Jam&nbsp;&nbsp;&nbsp;:</td>
              </tr>
              <tr>
                <td rowspan="3">Nama dan alamat  : {{@$pasien->ibu_kandung}}<br/>Keluarga terdekat&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
              </tr>
              <tr>
                <td rowspan="2" colspan="4" class="text-center">Dipindahkan Ke <br/>Ruang</td>
                <td colspan="2" rowspan="2" class="text-center">&nbsp;</td>
                <td colspan="4" class="text-center">Tanggal/Bulan</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td rowspan="4" style="padding:0px;">
                  <table border="1" cellspacing="0" style="width:100%;">
                    <tr class="text-center">
                      <td>Bag/Spes<br/><br/><br/></td>
                      <td>Ruang Rawat<br/>&nbsp;<br/>{{@$inap->kamar->nama}}</td>
                      <td>Kelas<br/>&nbsp;<br/>{{@$inap->kelas->nama}}</td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td rowspan="2" colspan="4" class="text-center">Tanggal Keluar</td>
                <td colspan="2" class="text-center">Tanggal</td>
                <td colspan="2" class="text-center">Bulan</td>
                <td colspan="2" class="text-center">Tahun</td>
              </tr>
              <tr>
                <td>{!!@$inap->tgl_keluar ? @substr(@$inap->tgl_keluar,8,1) : '&nbsp;'!!}</td>
                <td>{!!@$inap->tgl_keluar ? @substr(@$inap->tgl_keluar,9,1) : '&nbsp;'!!}</td>
                <td>{!!@$inap->tgl_keluar ? @substr(@$inap->tgl_keluar,5,1) : '&nbsp;'!!}</td>
                <td>{!!@$inap->tgl_keluar ? @substr(@$inap->tgl_keluar,6,1) : '&nbsp;'!!}</td>
                <td>{!!@$inap->tgl_keluar ? @substr(@$inap->tgl_keluar,2,1) : '&nbsp;'!!}</td>
                <td>{!!@$inap->tgl_keluar ? @substr(@$inap->tgl_keluar,3,1) : '&nbsp;'!!}</td>
              </tr>
              <tr>
                <td colspan="10">Lama Dirawat&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Hari</td>
              </tr>
              <tr>
                <td rowspan="" colspan="7">Diagnosa Masuk&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<br/>&nbsp;</td>
                <td rowspan="" colspan="4">Dilengkapi oleh&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<br/>&nbsp;</td>
              </tr>
              <tr>
                <td colspan="7">Diagnosa Utama <br/>Ditulis dengan<br/> Huruf Balok&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
                <td colspan="4" style="vertical-align:top"><center>Kode ICD 10</center></td>
              </tr>
              <tr>
                <td colspan="7" rowspan="7">
                  <p style="float:left">Diagnosa Sekunder<br/> (Komplikasi+Penyerta) <br/>Ditulis dengan Huruf<br/> Balok&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                  <p style="float:left;margin-left:20px;">1.<br/>2.<br/>3.<br/>4.<br/>5.<br/>6.</p>
                </td>
                <td colspan="4" style="vertical-align:top">
                  <center>Kode ICD 10</center></td>
              </tr>
              <tr>
                <td colspan="4">1.</td>
              </tr>
              <tr>
                <td colspan="4">2.</td>
              </tr>
              <tr>
                <td colspan="4">3.</td>
              </tr>
              <tr>
                <td colspan="4">4.</td>
              </tr>
              <tr>
                <td colspan="4">5.</td>
              </tr>
              <tr>
                <td colspan="4">6.</td>
              </tr>
              <tr>
                <td colspan="7" style="vertical-align:middle">Komplikasi &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
                <td colspan="4">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="7" style="vertical-align:middle">Penyebab Luar Cedera dan keracunan/Morfologi Neoplasma&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
                <td colspan="4">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="11">
                  <table border="1" style="width:100%;" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="text-center">Nama Operasi/Tindakan</td>
                      <td class="text-center">Gol. Operasi</td>
                      <td class="text-center">Jenis Anestesi</td>
                      <td class="text-center">Tanggal</td>
                      <td class="text-center">Kode ICD 9CM</td>
                    </tr>
                    @for ($i = 1; $i <= 7; $i++)
                    <tr>
                        <td>{{$i}}.</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>{{$i}}.</td>
                    </tr>
                    @endfor
                    <tr>
                      <td colspan="3">&nbsp;</td>
                      <td colspan="2">Pengkode&nbsp;&nbsp;&nbsp;:</td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td>Infeksi Nosokomial &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
                <td colspan="10">Penyebab Infeksi &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
              </tr>
              <tr>
                <td>Imunisasi yang Pernah di dapat &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
                <td colspan="10">Pengobatan Radioterapi/Kedokteran Nuklir : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
              </tr>
              <tr>
                <td>Imunisasi yang diperoleh <br/>Selama di rawat &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
                <td colspan="10">Transfusi Darah :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Cc/Gol. : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<br/>&nbsp;</td>
              </tr>
              <tr>
                <td >Keadaan Keluar &nbsp;&nbsp;&nbsp; :
                  <br/><input type="checkbox"> Sembuh&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox"> Meninggal > 48 Jam
                  <br/><input type="checkbox"> Belum Sembuh&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox"> Meninggal < 48 Jam
                  <br/><input type="checkbox"> Membaik
                </td>
                <td  colspan="10">Cara Keluar  &nbsp;&nbsp;&nbsp; :
                  <br/><input type="checkbox"> Di izinkan Pulang&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox"> Pulang Atas Permintaan Sendiri
                  <br/><input type="checkbox"> Pindah RS Lain&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox"> Dirujuk ke.............................
                  <br/><input type="checkbox"> Lain-lain.............................
                </td>
                
              </tr>
              <tr>
                <td colspan="11">Cara Pembayaran  &nbsp;&nbsp;&nbsp; :<input type="checkbox"> Umum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox"> Asuransi Lain&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <input type="checkbox">BPJS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox"> Lain-lain :..................................
                </td>
              </tr>
              <tr>
                <td >Nama DPJP &nbsp;&nbsp;&nbsp; :
                  <br/>1.
                  <br/>2.
                </td>
                <td  colspan="10">Tanda Tangan &nbsp;&nbsp;&nbsp; :
                  <br/>1.
                  <br/>2.
                </td>
              </tr>
            </table>
          </div> 
          <br /><br />
        </div>
      </div>
       
      <div class="col-md-12 text-right">
        <br/>
        <button class="btn btn-success">Simpan</button>
      </div>
    </form>
    <br/>
    <div class="row">
      <div class="col-md-12">
        <h4 class="text-center"><b>Catatan Medis</b></h4>
        <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
          <thead>
            <tr>
              <th>No</th>
              <th>Penginput</th>
              <th>Tanggal</th>
              <th>-</th>
            </tr>
          </thead>
          <tbody>
             @foreach ($riwayat as $key=>$item)
              <tr>
                <td>{{$key+1}}</td>
                <td>{{baca_user($item->user_id)}}</td>
                <td>{{date('d-m-Y H:i',strtotime($item->created_at))}}</td>
                <td>
                  {{-- <button type="button" id="historipasien" id-data="{{@$item->id}}" class="btn btn-warning btn-xs btn-flat">
                    <i class="fa fa-th-list"></i> Lihat
                  </button> --}}
                  <a target="_blank" class="btn btn-xs btn-success" href="{{url('emr-operasi-belakang-cetak/'.$item->id)}}"><i class="fa fa-print"></i> Cetak</a>
                  <a class="btn btn-danger btn-xs btn-flat" onclick="return confirm('Yakin akan menghapus data?')" href="{{url('emr-operasi-belakang/'.$reg->id.'/'.$item->id.'/delete')}}" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i> Hapus</button>&nbsp;&nbsp;
                </td>
              </tr>
             @endforeach
          </tbody>
        </table>
      </div>
    </div> 
  </div>

  @endsection

  @section('script')

  <script type="text/javascript">
    $(".skin-red").addClass( "sidebar-collapse" );
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
          var target = $(e.target).attr("href") // activated tab
          // alert(target);
        });
        $('.select2').select2();
        $("#date_tanpa_tanggal").datepicker( {
            format: "mm-yyyy",
            viewMode: "months", 
            minViewMode: "months"
        });
        $("#date_dengan_tanggal").attr('required', true);  
         
        // HISTORY PASIEN
        $(document).on('click', '#historipasien', function (e) {
          $('#dataHistoriPasien').html('');
          var id = $(this).attr('id-data');
          $('#showHistoriPasien').modal('show');
          $('#dataHistoriPasien').load("/rekonsiliasi-obat-show/"+id);
        });

        // MASTER OBAT
        $('.masterObat').select2({
            placeholder: "Klik untuk isi nama obat",
            width: '100%',
            ajax: {
                url: '/penjualan/master-obat-rekonsiliasi/',
                dataType: 'json',
                data: function (params) {
                    return {
                        j: 1,
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        })
  </script>
  @endsection