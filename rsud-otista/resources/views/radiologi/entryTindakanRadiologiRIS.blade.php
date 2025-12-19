@extends('master')

@section('header')
  <h1>
    @if (substr($jenis->status_reg,0,1) == 'G')
      Entry Tindakan Radiologi - Rawat Darurat
    @else
      Entry Tindakan Radiologi - Rawat Jalan
    @endif
  </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        {{-- <h3 class="box-title">
          Data Rekam Medis &nbsp;
        </h3> --}}
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-aqua-active" style="height: 180px;">
              <div class="row">
                <div class="col-md-2">
                  <h4 class="widget-user-username">Nama</h4>
                  <h5 class="widget-user-desc">No. RM</h5>
                  <h5 class="widget-user-desc">Alamat</h5>
                  <h5 class="widget-user-desc">Cara Bayar</h5>
                  <h5 class="widget-user-desc">DPJP</h5>
                  <h5 class="widget-user-desc">Klinik</h5>
                </div>
                <div class="col-md-7">
                  <h4 class="widget-user-username">:{{ @$pasien->nama}}</h4>
                  <h5 class="widget-user-desc">: {{ @$pasien->no_rm }}</h5>
                  <h5 class="widget-user-desc">: {{ @$pasien->alamat}}</h5>
                  <h5 class="widget-user-desc">: {{ baca_carabayar($jenis->bayar) }} </h5>
                  <h5 class="widget-user-desc">: {{ baca_dokter($jenis->dokter_id) }}</h5>
                  <h5 class="widget-user-desc">: {{ !empty($jenis->poli_id) ? baca_poli($jenis->poli_id) : NULL }}</h5>
                </div>
                <div class="col-md-3 text-center">
                  <h3>Total Tagihan</h3>
                  <h2 style="margin-top: -5px;">Rp. {{ number_format($tagihan,0,',','.') }}</h2>
                </div>
              </div>


            </div>
            <div class="widget-user-image">

            </div>

          </div>
          <!-- /.widget-user -->
          </div>
        </div>
        {{-- ======================================================================================================================= --}}
        <div class="box box-info">
          <div class="box-body">
            {!! Form::open(['method' => 'POST', 'url' => 'ris/store', 'class' => 'form-horizontal']) !!}
              <div class="col-md-6">
                @php

                  if (cek_status_reg($jenis->status_reg) == "I") {
                    $unit = "inap";
                  } elseif (cek_status_reg($jenis->status_reg) == "G") {
                    $unit = "igd";
                  } elseif (cek_status_reg($jenis->status_reg) == "J") {
                    $unit = "jalan";
                  }

                  $data['dokters_poli'] = Modules\Poli\Entities\Poli::where('id', 1)->pluck('dokter_id');
                  $data['perawats_poli'] = Modules\Poli\Entities\Poli::where('id', 1)->pluck('perawat_id');
                  $dokter_pengirim =   Modules\Pegawai\Entities\Pegawai::where('kategori_pegawai', 1)->get();
                  $dokter =  (explode(",", $data['dokters_poli'][0]));

                @endphp
                {!! Form::hidden('pasien_id', $pasien->id) !!}
                {!! Form::hidden('cara_bayar_id', $jenis->bayar) !!}
                {!! Form::hidden('dokter_id', $jenis->dokter_id) !!}
                {!! Form::hidden('unit', @$unit) !!}
                {!! Form::hidden('reg_id', $jenis->id) !!}

                <div class="form-group{{ $errors->has('dokter_id') ? ' has-error' : '' }}">
                    {!! Form::label('dokter_id', 'Dokter Radiologi', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-8">
                      <select name="dokter_radiologi" id="" class="form-control select2" style="width:100%">
                        @foreach ($dokter as $d)
                        <option value="{{ $d }}">{{ baca_dokter($d) }}</option>
                        @endforeach
                      </select>
                        <small class="text-danger">{{ $errors->first('dokter_id') }}</small>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('pelaksana') ? ' has-error' : '' }}">
                  {!! Form::label('pelaksana', 'Pelaksana ', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::select('radiografer', $perawat, session('radiografer'), ['class' => 'form-control select2', 'style'=>'width: 100%', 'placeholder'=>'','required'=>true]) !!}
                      <small class="text-danger">{{ $errors->first('pelaksana') }}</small>
                  </div>
                </div>
                <div class="form-group{{ $errors->has('jam') ? ' has-error' : '' }}">
                  {!! Form::label('pemeriksaan', 'Diagnosis', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      <textarea name="pemeriksaan" class="form-control" id="" cols="30" rows="7"></textarea>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group{{ $errors->has('tgl_pemeriksaan') ? ' has-error' : '' }}">
                  {!! Form::label('tglpemeriksaan', 'Tgl Pemeriksaan', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('tgl_pemeriksaan', date('d-m-Y'), ['class' => 'form-control datepicker']) !!}
                      <small class="text-danger">{{ $errors->first('tgl_pemeriksaan') }}</small>
                  </div>
                </div>
                <div class="form-group{{ $errors->has('poli') ? ' has-error' : '' }}">
                  {!! Form::label('poli', 'Poli ', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      <select name="poli_id" class="chosen-select">
                        @foreach ($opt_poli as $p)
                          <option value="{{$p->id}}">{{$p->nama}}</option>
                        @endforeach
                      </select>
                      <small class="text-danger">{{ $errors->first('poli') }}</small>
                  </div>
                </div>
                <div class="form-group{{ $errors->has('cyto') ? ' has-error' : '' }}">
                  {!! Form::label('cyto', 'Cyto', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                    <select class="chosen-select" name="cyto">
                      <option value="" selected>Tidak</option>
                      <option value="1">Ya</option>
                    </select>
                      <small class="text-danger">{{ $errors->first('cyto') }}</small>
                  </div>
              </div>
              </div>

              <div class="col-md-12">
                <h4>Input RIS</h4>
                <table style="width: 100%" class="daftar_obat_2 table table-striped table-bordered table-hover table-condensed form-box"
                  style="font-size:12px;">
                  <tr>
                    <th  class="text-center" style="width:50px;"><b>No</b></th>
                    <th class="text-center" style="width:250px;"><b>Tindakan</b></th>
                    <th class="text-center" style="width:250px;"><b>Jumlah</b></th>
                    
                  </tr>
                  @for ($i=0;$i <= 2; $i++) 
                    <tr>
                      <td class="text-center">{{$i+1}}</td>
                      <td>
                        <select name="exam[{{$i}}][examlist]" id="" class="form-control examlist"></select>
                        <input type="hidden" value="{{date('d-m-Y')}}" name="exam[{{$i}}][tgl]">
                      </td>
                      <td class="text-center"><input type="number" value="1" class="form-control" name="exam[{{$i}}][jumlah]"></td>
                    </tr>
                  @endfor
                  <tfoot>
                    <tr>
                      <td colspan="7" class="text-right">
                        <button type="button" class="add_daftar_2">Tambah Kolom</button>
                      </td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            
              <div class="col-md-12">
                
                @if (substr($jenis->status_reg,0,1) == 'G')
                  <a href="{{ url('radiologi/cetakRincianRad/ird/'.$reg_id) }}" class="btn btn-primary btn-flat pull-right">SELESAI</a>
                @else
                  <a href="{{ url('radiologi/cetakRincianRad/irj/'.$reg_id) }}" class="btn btn-primary btn-flat pull-right">SELESAI</a>
                @endif
                <button class="btn btn-success btn-flat pull-right" type="submit">Simpan</button>
              </div>
            {!! Form::close() !!}
          </div>
        </div>
        {{-- ======================================================================================================================= --}}
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th>No</th>
                <th>Tindakan</th>
                <th>Pelayanan</th>
                <th>Biaya</th>
                <th>Jml</th>
                <th>Total</th>
                <th>Dokter Radiologi</th>
                <th>Pelaksana</th>
                <th>Admin</th>
                <th>Waktu</th>
                <th>Periksa</th>
                <th>Bayar</th>
                {{-- @role(['supervisor', 'rawatdarurat','administrator']) --}}
                <th>Hapus</th>
                {{-- @endrole --}}
                <th>Note</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($folio as $key => $d)
              
              <tr>
                <td>{{ $no++ }}</td>
                @if (@$d->verif_kasa_user = 'tarif_new')
                  <td>{{ ($d->tarif_id <> 0 ) ? $d->tarif_baru->nama : 'Penjualan Obat' }}</td>
                  <td>
                    @if ($d->jenis == 'TA')
                      Radiologi RJ
                    @elseif($d->jenis == 'TG')
                      Radiologi RD
                    @endif
                  </td>
                  {{-- @if($jenis->poli->kelompok == 'ESO') --}}
                    @if(!empty(@$d->cyto))
                      @php
                      $cyto = $d->cyto;
                      $jml = ($d->total - $cyto) / $d->tarif_baru->total;
                      $hargaSatuan = $d->total / $jml;
                      @endphp
                      <td>{{ ($d->tarif_id <> 0 ) ? number_format($hargaSatuan,0,',','.') : '' }}</td>
                      <td>{{ ($d->tarif_id <> 0 ) ? $jml : '' }}</td>
                    @elseif (!empty(@$d->cyto_biasa))
                      @php
                      $cyto = $d->cyto_biasa;
                      $jml = ($d->total - $cyto) / $d->tarif_baru->total;
                      $hargaSatuan = $d->total / $jml;
                      @endphp
                      <td>{{ ($d->tarif_id <> 0 ) ? number_format($hargaSatuan ,0,',','.') : '' }}</td>
                      <td>{{ ($d->tarif_id <> 0 ) ? $jml : '' }}</td>
                    @else
                      <td>{{ ($d->tarif_id <> 0 ) ? number_format($d->tarif_baru->total,0,',','.') : '' }}</td>
                      <td>{{ ($d->tarif_id <> 0 ) ? ($d->total / $d->tarif_baru->total) : '' }}</td>
                    @endif
                  {{-- @else --}}
                      {{-- <td>{{ ($d->tarif_id <> 0 ) ? number_format($d->tarif_baru->total,0,',','.') : '' }}</td>
                      <td>{{ ($d->tarif_id <> 0 ) ? ($d->total / $d->tarif_baru->total) : '' }}</td>
                  @endif --}}
                 
                @else
                  <td>{{ ($d->tarif_id <> 0 ) ? $d->tarif->nama : 'Penjualan Obat' }}</td>
                  <td>
                    @if ($d->jenis == 'TA')
                      Radiologi RJ
                    @elseif($d->jenis == 'TG')
                      Radiologi RD
                    @endif
                  </td>
                  <td>{{ ($d->tarif_id <> 0 ) ? number_format($d->tarif->total,0,',','.') : '' }}</td>
                  <td>{{ ($d->tarif_id <> 0 ) ? ($d->total / $d->tarif->total) : '' }}</td>
                @endif
                  <td>{{ number_format($d->total,0,',','.') }}</td>
                  <td>{{ baca_dokter($d->dokter_radiologi) }}</td>
                  <td>{{ baca_dokter($d->radiografer) }}</td>
                  <td>{{ $d->user->name }}</td>
                  <td>{{ $d->created_at->format('d-m-Y') }}</td>
                  <td>
                    @if(!$d->waktu_periksa)
                      <button type="button" class="btn btn-sm btn-info btn-flat" data-id="{{ @$d->id }}" onclick="periksa({{ $d->id }})"><i class="fa fa-pencil"></i></button>
                    @else
                      {{ @$d->waktu_periksa }}
                    @endif
                  </td>
                  <td>
                    @if ($d->lunas == 'Y')
                      <i class="fa fa-check"></i>
                    @else
                      <i class="fa fa-remove"></i>
                    @endif
                  </td>
                  {{-- @role(['supervisor', 'radiologi','administrator']) --}}
                  <td>
                    @if ($d->lunas == 'Y')
                      <i class="fa fa-check"></i>
                    @else
                      @if ( json_decode(Auth::user()->is_edit,true)['hapus'] == 1)
                        <a href="{{ url('radiologi/hapus-tindakan/'.$d->id.'/'.$d->registrasi_id.'/'.$d->pasien_id) }}" onclick="return confirm('Yakin akan di hapus?')" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-trash-o"></i></a>
                      @else
                      @endif
                    @endif

                  </td>
                  {{-- @endrole --}}
                  <td>
                    <button type="button" class="btn btn-sm btn-info btn-flat" data-id="{{ @$d->id }}" onclick="showNote({{ $d->id }})"><i class="fa fa-book"></i></button>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>


      </div>
    </div>


    <div class="modal fade" id="pemeriksaanModel" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body">
            <form method="POST" class="form-horizontal" id="form">
              <table class="table table-condensed table-bordered">
                <tbody>
                    <tr>
                      <th>Tanggal Order :<input class="form-control" type="date" name="tgl_order"> </th>
                      
                    </tr>
                    <tr>
                     
                        <th>Catatan : <input type="text" class="form-control" name="catatan" id="catatan"> </th>
                        <input type="hidden" name="id_reg"> 
                      
                    </tr>
                </tbody>
              </table>
            </form>
          </div>
          {{-- <div class="modal-footer">
            <button type="button" onclick="saveNote()" class="btn btn-default btn-flat">Simpan</button>
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
          </div> --}}
        </div>
      </div>
    </div>



@stop

@section('script')
<script type="text/javascript">
  $('.select2').select2();
</script>
  <script>
    $(document).ready(function() {
        obat()
        modality()
        var max_fields      = 25;
        var wrapper         = $(".daftar_obat_2"); 
        var add_button      = $(".add_field_button");
        var remove_button   = $(".remove_field_button");
        var dateToday = "{{date('d-m-Y')}}" 
        console.log(dateToday)
        var i = 2;
         // row 3
         $(".add_daftar_2").click(function(e){
            e.preventDefault();
            // var total_fields = wrapper[0].childNodes.length;
            if(i < max_fields){
                i++;
                $('.daftar_obat_2').append( '<tr>'+
                '<td class="text-center">'+(i+1)+'</td>'+
                '<td><select name="exam['+i+'][examlist]" id="" class="form-control examlist"></select><input type="hidden" value="'+dateToday+'" name="exam['+i+'][tgl]"></td>'+
                '<td class="text-center"><input type="number" value="1" class="form-control" name="exam['+i+'][jumlah]"></td>'+
                // '<td class="text-center"><input type="text" class="form-control" name="admisi[transfer]['+i+'][cara]"></td>'+
                '<td style="width:20px" class="text-center"><a href="#" class="remove_field_obat_2 btn btn-xs btn-danger">X</a></td>'+
              '</tr>');

                $(wrapper).find(".datepicker").datepicker({autoclose: true,format: "dd-mm-yyyy"})
                obat()
                modality()
            }
        });
        $(".daftar_obat_2").on("click",".remove_field_obat_2", function(e){ //user click on remove text
            // console.log($(this));
            e.preventDefault(); $(this).closest("tr").remove(); i--;
          })

      // MASTER TINDAKAN
      function obat(){
          $('.examlist').select2({
            placeholder: "Klik untuk mencari tindakan",
            width: '100%',
            ajax: {
                url: '/ris/get-tarif-ris/',
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
      }
      
      function modality(){
          $('.modality').select2({
            placeholder: "Klik untuk mencari modality",
            width: '100%',
            ajax: {
                url: '/ris/get-modality',
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
      }
      
        
     // HISTORY EXAM
     $(document).on('click', '#exam', function (e) {
        var id = $(this).attr('data-reg');
        // alert(id)
        $('#showExam').modal('show');
        $('#dataExam').load("/ris/getexam/"+id);
      });  

    });
</script>
<script type="text/javascript">
  $('.select2').select2()

  function ribuan(x) {
     return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  }

  $(document).ready(function() {
    //TINDAKAN entry
    $('select[name="kategoriTarifID"]').on('change', function() {
        var tarif_id = $(this).val();
        if(tarif_id) {
            $.ajax({
                url: '/tindakan/getTarif/'+tarif_id,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    //$('select[name="tarif_id"]').append('<option value=""></option>');
                    $('select[name="tarif_id"]').empty();
                    $.each(data, function(id, nama, total) {
                        $('select[name="tarif_id"]').append('<option value="'+ nama.id +'">'+ nama.nama +' | '+ ribuan(nama.total)+'</option>');
                    });

                }
            });
        }else{
            $('select[name="tarif_id"]').empty();
        }
    });
  });





    
  function showNote(id) {

      $('#pemeriksaanModel').modal()
      $('.modal-title').text('Catataan Order Radiologi')
      $("#form")[0].reset()
      $.ajax({
        url: '/radiologi/showNoteEmr/'+id,
        type: 'GET',
        dataType: 'json',
      })
      .done(function(data) {
        $('input[name="id_reg"]').val(data.id)
        $('input[name="tgl_order"]').val(data.embalase)
       $('input[name="catatan"]').val(data.catatan)
      })
      .fail(function() {
        alert(data.error);
      });

    }
  
  function periksa(id) {      
    $.ajax({
      url: '/radiologi/proses-periksa/'+id,
      type: 'GET',
      dataType: 'json',
    })
    .done(function(data) {
      if(data.status == '200'){
        alert(data.message);
        window.location.reload();
      }else{
        alert(data.message);
      }

    })
    .fail(function() {
      alert(data.error);
    });

  }


  

</script>
@endsection
