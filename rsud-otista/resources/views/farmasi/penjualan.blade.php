@extends('master')
@section('header')
  <h1>Farmasi - Penjualan <small></small></h1>
@endsection

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
  
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'frontoffice/cek-pasien-penjualan', 'class'=>'form-hosizontal']) !!}
      <input type="hidden" name="tgl" value="{{date('Y-m-d')}}">
      <div class="row">
        <div class="col-md-4">
          <div class="input-group{{ $errors->has('norm') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('norm') ? ' has-error' : '' }}" type="button">Cek RM Pasien</button>
              </span>
              {!! Form::text('norm', NULL, ['class' => 'form-control', 'placeholder'=>'Input Nomor RM Disini']) !!}
              <small class="text-danger">{{ $errors->first('norm') }}</small>
          </div>
        </div>
        <div class="col-md-4">
          <div class="input-group{{ $errors->has('nama_pasien') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('nama_pasien') ? ' has-error' : '' }}" type="button">Cek Nama Pasien</button>
              </span>
              {!! Form::text('nama_pasien', NULL, ['class' => 'form-control','placeholder'=>'Input Nama Pasien Disini']) !!}
              <small class="text-danger">{{ $errors->first('nama_pasien') }}</small>
          </div>
        </div>
        <div class="col-md-4">
          <div class="input-group{{ $errors->has('alamat') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('alamat') ? ' has-error' : '' }}" type="button">Cek Alamat Pasien</button>
              </span>
              {!! Form::text('alamat', NULL, ['class' => 'form-control','placeholder'=>'Input Alamat Pasien Disini']) !!}
              <small class="text-danger">{{ $errors->first('alamat') }}</small>
          </div>
        </div>
        {{-- <div class="col-md-4">
          <div class="input-group{{ $errors->has('tgl') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tgl') ? ' has-error' : '' }}" type="button">Tanggal Registrasi</button>
              </span>
              {!! Form::text('tgl', NULL, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('tgl') }}</small>
          </div>
        </div> --}}
       
       
        <div class="col-md-4">
          <input type="submit" name="cari" class="btn btn-primary btn-flat" value="CARI PASIEN">
        </div>
      </div>
      {!! Form::close() !!}
      {{-- {!! Form::open(['method' => 'POST', 'url' => 'frontoffice/cek-pasien-penjualan', 'class'=>'form-hosizontal']) !!}
      <input type="hidden" name="tgl" value="{{date('Y-m-d')}}">
      <input type="hidden" name="cari" value="cari">
      <div class="row">
          <div class="col-md-6">
            <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">NOMOR RM</button>
                </span>
                <select name="norm" class="form-control" id="selectRM" onchange="this.form.submit()">
                </select>
                <small class="text-danger">{{ $errors->first('tga') }}</small>
            </div>

          </div>

          <div class="col-md-6">

          </div>
        </div>
      {!! Form::close() !!} --}}


        @if (isset($cekpasien))
        @section('script')
        @parent
        <script type="text/javascript">
          $(".skin-blue").addClass( "sidebar-collapse" ); 
        </script>
        @endsection
       <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed'>
          <thead>
            <tr>
              <th>Nama</th>
              <th>RM</th>
              <th>Poli</th>
              <th>Jenis</th>
              <th>Tgl Eklaim</th>
              <th>Tgl Registrasi</th>
              <th>Di Bayar</th>
              <th>Proses</th>
              <th>Proses New</th>
              <th>Tanggal Entry</th>
              <th>Resep</th>
              {{-- <th>Copy Resep</th> --}}
              <th>Faktur</th>
               <th>F. Kronis K</th> 
              <th>Etiket Biru</th>
              <th>RB</th>
              <th>Edit</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($cekpasien as $key => $d)
              @php
                // $d = $cekpasien;
                $d->registrasi_id = $d->id;
                // @$ranap = \App\Rawatinap::where('registrasi_id', $d->id)->->orderBy('id','DESC')->first();
                // $penjualan = App\Penjualan::where('registrasi_id', $d->id)->orderBy('created_at', 'asc')->get();
                $tgl_entry = App\Penjualan::where('registrasi_id', $d->id)->orderBy('created_at', 'desc')->first();
              @endphp
                <tr>
                  <td>{{ strtoupper(@$d->pasien->nama) }}
                  @if (cek_status_reg($d->status_reg) == 'J')
                    (<b style="color:blue;">RAJAL</b>)
                  @elseif (cek_status_reg($d->status_reg) == 'I')
                    (<b style="color:blue;">INAP</b>)
                  @elseif (cek_status_reg($d->status_reg) == 'G')
                    (<b style="color:blue;">IGD</b>)
                  @endif

                  @if ($d->status_reg == 'I3')
                      (<b style="color:green;">PASIEN INAP SUDAH PULANG</b>)
                  @endif
                  </td>
                  <td>{{ @$d->pasien->no_rm }}</td>
                  <td>{{ strtoupper(baca_poli($d->poli_id)) }}</td>
                  <td>{{ baca_carabayar($d->bayar) }}</td>
                  <td>{{ tanggal_eklaim($d->created_at) }}</td>
                  <td>{{ $d->created_at }}</td>
                  <td>
                    @if ($d->lunas == 'Y')
                        {{ 'Lunas' }}
                    @else
                        {{ 'Belum Lunas' }}
                    @endif
                  </td>
                  <td>
                    <a href="{{ url('penjualan/form-penjualan-baru/'.@$d->pasien_id).'/'.$d->registrasi_id }}" class="btn btn-success btn-flat btn-sm"><i class="fa fa-check"></i></a>
                  </td>
                  <td>
                    <a href="{{ url('penjualannew/form-penjualan-baru/'.@$d->pasien_id).'/'.$d->registrasi_id }}" class="btn btn-primary btn-flat btn-sm"><i class="fa fa-check"></i></a>
                   </td>
                  <td><small>{{ @$tgl_entry->created_at }}</small></td>
                  <td>
                    <button type="button" class="btn btn-sm btn-primary btn-flat" onclick="popupWindow('/penjualan/tab-resep/'+{{$d->registrasi_id}})" style="margin-bottom: 5px;"><i class="fa fa-list"></i></button>
                  </td>
                  {{-- <td>
                    @if ($penjualan->first())
                    <div class="btn-group">
                       <button type="button" class="btn btn-sm btn-danger">Cetak</button>
                       <button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown">
                           <span class="caret"></span>
                           <span class="sr-only">Toggle Dropdown</span>
                       </button>
                       <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                         @foreach ($penjualan as $p)
                           <li><a href="{{ url('copy-resep/cetak-detail-resep-farmasi/'.$p->id) }}" class="btn btn-flat btn-sm" target="_blank">{{ $p->no_resep }}</a></li>
                         @endforeach
                       </ul>
                   </div>
                   @endif
                  </td> --}}
                  {{-- <td>
                    @if ($penjualan->first())
                    <div class="btn-group">
                       <button type="button" class="btn btn-sm btn-success">Cetak</button>
                       <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
                           <span class="caret"></span>
                           <span class="sr-only">Toggle Dropdown</span>
                       </button>
                       <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                         @foreach ($penjualan as $p)
                           <li><a href="{{ url('copy-resep/cetak-detail-copy-resep-farmasi/'.$p->id) }}" class="btn btn-flat btn-sm" target="_blank">{{ $p->no_resep }}</a></li>
                         @endforeach
                       </ul>
                   </div>
                   @endif
                  </td> --}}
                  <td>
                    <button type="button" class="btn btn-sm btn-danger btn-flat" onclick="popupWindow('/penjualan/tab-faktur/'+{{$d->registrasi_id}})" style="margin-bottom: 5px;"><i class="fa fa-list-alt"></i></button>
                  </td>
                    {{-- <td>
                      @if ($penjualan->first())
                      <div class="btn-group">
                         <button type="button" class="btn btn-sm btn-danger">Cetak</button>
                         <button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown">
                             <span class="caret"></span>
                             <span class="sr-only">Toggle Dropdown</span>
                         </button>
                         <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                           @foreach ($penjualan as $p)
                           <li>
                              <a href="{{ url('farmasi/cetak-detail/'.$p->id) }}" class="btn btn-flat btn-sm" target="_blank">{{ $p->no_resep }}</a>
                           </li>
                           @endforeach
                         </ul>
                     </div>
                     @endif
                    </td> --}}
                    {{-- <td>
                      @foreach ($penjualan as $penj)

                         @php
                             
                             $detail = \App\Penjualandetail::where('penjualan_id', $penj->id)->where('is_kronis', 'Y')->first();
                         @endphp
                         @if ($detail != null)
                         <a href="{{ url('farmasi/cetak-fakturkronis/'.$penj->id) }}" class="btn btn-danger btn-flat btn-sm" target="_blank"> <i class="fa fa-file-pdf-o"></i> </a>
                         @endif
                      @endforeach
                    </td>  --}}
                    <td>
                      <button type="button" class="btn btn-sm btn-default btn-flat" onclick="popupWindow('/penjualan/tab-fkronis/'+{{$d->registrasi_id}})" style="margin-bottom: 5px;"><i class="fa fa-indent"></i></button>
                    </td>
                    <td>
                      <button type="button" class="btn btn-sm btn-info btn-flat" onclick="popupWindow('/penjualan/tab-etiket/'+{{$d->registrasi_id}})" style="margin-bottom: 5px;"><i class="fa fa-id-card"></i></button>
                    </td>
                    <td>
                      <button type="button"
                      onclick="rincianBiaya({{ @$d->registrasi_id }}, '{{ RemoveSpecialChar(@$d->pasien->nama) }}', {{ @$d->pasien->no_rm }}, '{{ @$d->registrasi_id }}' )"
                      class="btn btn-info btn-sm btn-flat"><i class="fa fa-search"></i></button>
                    </td>
                    <td>
                      <button type="button" class="btn btn-sm btn-warning btn-flat" onclick="popupWindow('/penjualan/tab-edit/'+{{$d->registrasi_id}})" style="margin-bottom: 5px;"><i class="fa fa-edit"></i></button>
                    </td>
                    {{-- <td>
                      @if(count($penjualan) > 0)
                         <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-warning">Edit</button>
                            <button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown">
                               <span class="caret"></span>
                               <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                            @foreach($penjualan as $p)
                                  <li><a target="_blank" href="{{url('penjualan/editformpenjualan/'.baca_jenispasien($d->status_reg).'/'.$d->registrasi_id.'/'.$p->id)}}" class="btn btn-sm btn-block">{{ $p->no_resep }}</a></li>
                            @endforeach
                            </ul>
                         </div>
                      @endif
                      </td>  --}}
                </tr>
              @endforeach
          </tbody>
        </table>
         {{-- <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
         <th>
           <td>
             " Pasien  <b class="text-green">{{ baca_pasien($cekpasien->pasien_id) }} </b>| NOMOR RM <b class="text-red"> {{ baca_norm($cekpasien->pasien_id) }} </b> Berada di
           <b class="text-blue">
            @if ($cekpasien->status_reg == 'J1')
              RAWAT JALAN (J1)
              @elseif ($cekpasien->status_reg == 'J2')
              RAWAT JALAN (J2)
              @elseif ($cekpasien->status_reg == 'J3')
              RAWAT JALAN (J3)
              @elseif ($cekpasien->status_reg == 'G1')
              RAWAT DARURAT (G1)
              @elseif ($cekpasien->status_reg == 'G2')
              RAWAT DARURAT (G2)
              @elseif ($cekpasien->status_reg == 'G3')
              RAWAT DARURAT (G3)
              @elseif ($cekpasien->status_reg == 'I1')
              RAWAT INAP (I1)
              @elseif ($cekpasien->status_reg == 'I2')
              RAWAT INAP (I2)
              @elseif ($cekpasien->status_reg == 'I3')
              PULANG DARI RAWAT INAP (I3)
            @endif
          </b>"
           </td>
           <td>
           <i> RegID: {{ $cekpasien->id }} Registrasi: {{ $cekpasien->created_at }} PasienID: {{ $cekpasien->pasien_id }}</i>
           </td>
          
        </th>
        </table> --}}
        </div>
        @endif
    </div>
    <div class="box-footer">
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
  
  {{-- <div class="box box-primary">
    <div class="box-header with-border">
      <div class="box-title">
        <h4>PENJUALAN LAMA</h4>
      </div>
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="{{ url('penjualan/jalan') }}" ><img src="{{ asset('menu/tablets.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Rawat Jalan</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="{{ url('penjualan/irna') }}" ><img src="{{ asset('menu/tablets.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Rawat Inap</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="{{ url('penjualan/darurat') }}" ><img src="{{ asset('menu/tablets.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Rawat Darurat</h5>
      </div>

      <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="{{ url('penjualanbebas') }}" ><img src="{{ asset('menu/tablets.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Penjualan Bebas</h5>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div> --}}


  <div class="box box-danger">
    <div class="box-header with-border">

      <div class="box-title">
        {{-- <h4>PENJUALAN BARU (PER BATCH)</h4> --}}
      </div>
    </div>
    <div class="box-body">
      <div class="col-md-12">

        {{-- <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
          <a href="{{ url('penjualan/jalan-baru') }}" ><img src="{{ asset('menu/fixed/rawatjalan.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          </a>
          <h5>Rawat Jalan</h5>
        </div> --}}
        {{-- <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
          <a href="{{ url('penjualan/jalan-baru-fast') }}" ><img src="{{ asset('menu/fixed/rawatjalan.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          </a>
          <h5>Rawat Jalan (<b>Akses Cepat</b>)</h5>
        </div> --}}
        {{-- <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
          <a href="{{ url('penjualan/irna-baru') }}" ><img src="{{ asset('menu/fixed/rawatinap.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          </a>
          <h5>Rawat Inap</h5>
        </div> --}}
        {{-- <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
          <a href="{{ url('penjualan/darurat-baru') }}" ><img src="{{ asset('menu/fixed/igd.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          </a>
          <h5>Rawat Darurat</h5>
        </div> --}}
        {{-- <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
          <a href="#" ><img src="{{ asset('menu/dollar-symbol-3.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thu"/>
          <h5>Rawat Darurat</h5>
        </div> --}}
  
        {{-- <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
          <a href="{{ url('penjualanbebas-baru') }}" ><img src="{{ asset('menu/fixed/penjualanbebas.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          </a>
          <h5>Penjualan Bebas</h5>
        </div> --}}
      </div>

      
      <div class="col-md-12">
        <h4>PENJUALAN BARU (PER BATCH) - <b>NEW UPDATE</b></h4>  
        <p>Tampilan menu penjualan terbaru, yang tidak lemot</p>
        <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
          <a href="{{ url('penjualan/jalan-baru-fast') }}" ><img src="{{ asset('menu/fixed/rawatjalan.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          </a>
          <h5>Rawat Jalan</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
          <a href="{{ url('penjualan/irna-baru-fast') }}" ><img src="{{ asset('menu/fixed/rawatinap.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          </a>
          <h5>Rawat Inap</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
          <a href="{{ url('penjualan/darurat-baru-fast') }}" ><img src="{{ asset('menu/fixed/igd.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          </a>
          <h5>Rawat Darurat</h5>
        </div>
        {{-- <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
          <a href="#" ><img src="{{ asset('menu/dollar-symbol-3.png') }}" width="50px" heigth="50px"  class="img-responsive img-circle img-thu"/>
          <h5>Rawat Darurat</h5>
        </div> --}}
  
        
        <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
          <a href="{{ url('penjualanbebas-baru') }}" ><img src="{{ asset('menu/fixed/penjualanbebas.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          </a>
          <h5>Penjualan Bebas</h5>
        </div>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>


  @endsection
  @section('script')

  <script type="text/javascript">
   function popupWindow(mylink) {
      if (!window.focus) return true;
      var href;
      if (typeof (mylink) == 'string')
        href = mylink;
      else href = mylink.href;
      window.open(href, "Resep", 'width=500,height=500,scrollbars=yes');
      return false;
    }
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
      // alert(registrasi_id)
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
          cetak2 = '<a class="btn btn-success btn-sm pull-right" target="_blank" href="/ranap-informasi-unit-rincian-biaya-tanpa-rajal/'+registrasi_id+'"><span class="fa fa-print"></span> Rincian Biaya Unit Tanpa Rajal</a><br/>';
          cetak3 = '<a class="btn btn-danger btn-sm pull-right" style="margin-left:20px;" target="_blank" href="/ranap-informasi-unit-item-rincian-biaya-tanpa-rajal/'+registrasi_id+'"><span class="fa fa-print"></span> Rincian Biaya(Klaim)</a>';
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
    // $(".skin-blue").addClass( "sidebar-collapse" );
    $('#selectRM').select2({
        placeholder: "Pilih No Rm...",
        ajax: {
            url: '/pasien/master-pasien/',
            dataType: 'json',
            data: function (params) {
                return {
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
