@extends('master')

@section('header')
  <h1>SOAP</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
      </h3>
    </div>
    <div class="box-body">
        <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">
        {{-- <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
        <script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>  --}}
        @include('emr.modules.addons.profile')
        <div class="row">
            <div class="col-md-12">
             @include('emr.modules.addons.tabs')
                <form method="POST" action="{{ url('save-emr') }}" class="form-horizontal">
                    {{ csrf_field() }}
                    {!! Form::hidden('registrasi_id', $reg->id) !!}
                    {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                    {!! Form::hidden('unit', $unit) !!}
                    <br> 
                      <div class="col-md-6">  
                          {{-- <div class="table-responsive" style="height:600px;"> --}}
                            <h3 style="margin-top:0px !important">E - RESEP</h3>
                            <a href="{{ url('cetak-emr/'.$reg->id) }}" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i></a>
                            <a href="{{ url('cetak-emr/pdf/'.$reg->id) }}" target="_blank" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i></a>
                            <a href="{{ url('cetak-emr-rencana-kontrol/pdf/'.$reg->id) }}" target="_blank" class="btn btn-warning"><i class="fa fa-file-pdf-o"></i></a>
                            {{-- <button type="button" class="btn btn-warning btn-flat btn-history-resep pull-right" data-id="{{ $reg->id }}"><i class="fa fa-bars" aria-hidden="true"></i> HISTORI E-RESEP</button> --}}
                            <button type="button" id="historipenjualaneresep" data-bayar="{{@$reg->cara_bayar}}" data-registrasiID="{{ $reg->id }}" class="btn btn-warning btn-sm btn-flat pull-right">
                              <i class="fa fa-th-list"></i> HISTORY E-RESEP
                            </button>
                            {{-- <button type="button" class="btn btn-primary btn-flat btn-add-resep pull-right" data-id="{{ $reg->id }}"><i class="fa fa-address-card-o" aria-hidden="true"></i> TAMBAH E-RESEP</button><br/> --}}
                            
                        {{-- </div> --}}
                      </div>
                      
                    <br/>
                    <br/> 
                    
                </form>
                <form method="POST" action="{{ url('frontoffice/simpan_diagnosa_rawatinap') }}" class="form-horizontal">
                  {{ csrf_field() }}
                  {!! Form::hidden('registrasi_id', $reg->id) !!}
                  {!! Form::hidden('cara_bayar', $reg->bayar) !!} 
                  {!! Form::hidden('unit', $unit) !!}
                </form>
                
            </div>

            {{-- form eresep --}}
            <div class="col-md-12">
                <!-- Modal content-->
                <input type="hidden" name="pasien_id" value="{{$reg->pasien_id}}">
                <input type="hidden" name="uuid" value="{{$uuid}}">
                <input type="hidden" name="reg_id" value="{{$reg->id}}">
                <input type="hidden" name="source" value="{{$unit}}">
                <div class="modal-content">
                  <div class="modal-body" style="display:grid;">
                    <h3>Daftar E-Resep</h3>
                    <div class="row">
                      <div class="col-sm-6">
                        {{-- <div class="form-group row">
                          <label class="control-label col-sm-4">Nama Racikan:</label>
                          <div class="col-sm-8">
                            <input type="text" name="nama_racikan" class="form-control">
                          </div>
                        </div> --}}
                        <div class="form-group row">
                          <label class="control-label col-sm-4">Nama Obat:</label>
                          <div class="col-sm-8">
                            <select name="masterobat_id" id="masterObat" class="form-control" onchange="cariBatch()"></select>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="control-label col-sm-4">Stok:</label>
                          <div class="col-sm-8">
                            <input type="text" name="last_stok" class="form-control" disabled>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="control-label col-sm-4">Qty:</label>
                          <div class="col-sm-8">
                            <input type="number" class="form-control" name="qty">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="control-label col-sm-4">Jenis</label>
                          <div class="col-sm-8">
                            <select class="form-control select2" id="jenis_obat" name="jenis_obat" style="width: 100%">
                                <option value="non_racik" selected>NON RACIK</option>
                                <option value="racikan" >RACIKAN</option>
                            </select>
                          </div>
                        </div>
                        {{-- <div class="form-group row{{ $errors->has('kronis') ? ' has-error' : '' }}">
                          {!! Form::label('kronis', 'Kronis', ['class' => 'col-sm-4 control-label']) !!}
                          <div class="col-sm-8"> --}}
                            {{-- {!! Form::select('kronis', ['Y'=>'Ya', 'N'=>'Tidak'], 'N', ['class' => 'form-control select2']) !!} --}}
                            {{-- <select name="kronis" id="" class="form-control">
                              <option value="N">Tidak</option>
                              <option value="Y">Ya</option>
                            </select>
                            <small class="text-danger">{{ $errors->first('kronis') }}</small>
                          </div> 
                        </div> --}}
                        <input type="hidden" name="kronis" value="N">
                       
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group row">
                          <label class="control-label col-sm-4">Signa:</label>
                          <div class="col-sm-8">
                            {{-- <select class="form-control select2" name="cara_minum" style="width: 100%">
                              <option value="" ></option>
                              @foreach($cara_minum as $key => $item)
                              <option value="{{ $item->nama }}" >{{ $item->nama }}</option>
                              @endforeach
                            </select>
                            <br><a target="_blank" href="{{url('penjualan/master-cara-minum')}}" style="text-decoration: none;font-size:12px;">Tambah Data Cara Minum</a> --}}
                            <input type="text" class="form-control" name="cara_minum">
                          </div>
                        </div>
                        {{-- <div class="form-group row">
                          <label class="control-label col-sm-4">Petunjuk Peracikan:</label>
                          <div class="col-sm-8"> --}}
                            {{-- <select class="form-control select2" name="takaran" style="width: 100%">
                              <option value=""></option>
                              @foreach($takaran as $key => $item)
                              <option value="{{ $item->nama }}" >{{ $item->nama }}</option>
                              @endforeach
                            </select> --}}
                            {{-- <input type="text" class="form-control" name="takaran">
                            
                          </div>
                        </div> --}}
                        {{-- <div class="form-group row">
                          <label class="control-label col-sm-4">Dosis:</label>
                          <div class="col-sm-8"> --}}
                            {{-- <select class="form-control select2" name="tiket" style="width: 100%">
                              <option value="" ></option>
                              @foreach($tiket as $key => $item)
                              <option value="{{ $item->nama }}" >{{ $item->nama }}</option>
                              @endforeach
                            </select> --}}
                            {{-- <input type="text" class="form-control" name="tiket"> --}}
                            {{-- <br><a href="{{url('farmasi/etiket')}}" target="_blank" style="text-decoration: none;font-size:12px;">Tambah Data Dosis</a> --}}
                          {{-- </div>
                        </div> --}}
                        <div class="form-group row">
                          <label class="control-label col-sm-4">Informasi:</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" name="informasi">
                          </div>
                        </div>

                        <div class="text-right">
                          
                        <button type="button" class="btn btn-primary" id="btn-save-resep">Tambah</button>
                        <p style="color:red">* Klik <span class="text-primary">"Tambah"</span> Obat Dahulu setelah memilih obat, Lalu Klik <span class="text-success">"Simpan Saja"</span> Atau <span class="text-info">"Simpan & Buat Template"</span></p>
                        </div>
                      </div>
                    </div>
                    <br/> 
                    <h3><b style="color:blue;">Data Obat Pasien </b></h3>
                    <table class='table table-striped table-bordered table-hover table-condensed'>
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama Obat</th>
                          {{-- <th>Stok</th> --}}
                          <th>Qty</th>
                          <th>Cara Bayar</th>
                          <th>Harga Jual</th>
                          <th>Signa</th>
                          {{-- <th>Cara Minum</th> --}}
                          {{-- <th>Takaran</th> --}}
                          <th>Racikan</th>
                          <th>Informasi</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody id="listResep">
                        @foreach ($show as $key=>$val)
                        <tr>
                          <td>{{$key+1}}</td>
                          <td>{{$val->logistik_batch->master_obat->nama}}</td>
                          {{-- <td>
                            @if ($val->logistik_batch['stok'] <= 0)
                              <i style="color:red;font-size:11px;">Stok Kurang atau habis</i>
                            @else  
                              {{$val->logistik_batch['stok']}}
                            @endif
                            @php
                                $dataQty = $val->id
                            @endphp
                          </td> --}}
                          <td data-id="{{$val->id}}" style="width: 10%;"><input onchange="editQty({{$val->id}})" style="width: 100%;" type="number" name="edit-qty-{{$val->id}}" value="{{$val->qty}}"/></td>
                          <td>{{$val->cara_bayar}}</td>
                          <td>Rp. {{number_format($val->logistik_batch->hargajual_umum)}}</td>
                          {{-- <td>{{$val->tiket}}</td> --}}
                          {{-- <td>{{$val->cara_minum}}</td> --}}
                          <td><input onchange="editSigna({{$val->id}})" style="width: 100%;" type="text" name="edit-signa-{{$val->id}}" value="{{$val->cara_minum}}"/></td>
                          {{-- <td>{{$val->takaran}}</td> --}}
                          <td>{{$val->obat_racikan}}</td>
                          <td>{{$val->informasi}}</td>
                          <td>
                            <button type="button" data-id="{{$val->id}}" class="btn btn-sm btn-danger btn-flat del-detail-resep"><i class="fa fa-trash" aria-hidden="true"></i></button>
                            {{-- <button type="button" data-id="{{$val->id}}" data-tiket={{$val->tiket}} value="{{ $val->qty }}" class="btn btn-sm btn-primary btn-flat edit-detail-resep"><i class="fa fa-pencil" aria-hidden="true"></i></button> --}}
                            {{-- <button onclick="editForm()" class="btn btn-xs btn-info btn-flat"> --}}
                         </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                  <div class="modal-footer">
                    <div class="form-group row">
                      <label class="control-label col-sm-4">Nama Racikan:</label>
                      <div class="col-sm-8">
                        <input type="text" name="nama_racikan" class="form-control">
                        <br/>
                        <button type="button" id="btn-final-resep" class="btn btn-success" ><b style="color:black"> Tambahan Obat Khusus Hari ini<b></button>
                        <button type="button" id="btn-final-resep-duplicate-next" class="btn btn-warning"><b style="color:white">Simpan & Buat Template Dari Riwayat Sebelumnya</b> </button>
                      </div>
                    </div>
                    @if (!empty(@$use_template))
                      <a href="{{url('emr/eresep/cancel-use-template/' . $unit . '/' . $reg->id . '/' . $uuid . '?poli=' . $reg->poli_id . '&dpjp=' . $reg->dokter_id)}}" class="btn btn-danger"><span> Batal Gunakan Template<small></a>
                    @endif
                    {{-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> --}}
                    
                  </div>
                </div>
        
            </div>

            {{-- <div class="col-md-4">
              <h5>Template Obat</h5>
              <div class="table-responsive" style="max-height: 400px !important;border:1px solid blue">
                <table class="table table-bordered" id="data" style="font-size: 12px;">
                     
                    <tbody>
                      @if (count($template) == 0)
                          <tr>
                            <td>Tidak ada record</td>
                          </tr>
                      @endif
                        @foreach( $template as $key_a => $val_a )
                          <tr style="border-top: 2px solid red;">
                            <td style="border-top: 2px solid orange;">Racikan</td>
                            <td style="border-top: 2px solid orange;">{{$val_a->nama_racikan}}</td>
                          </tr>
                          <tr>
                            <td>Pembuat</td>
                            <td>{{$val_a->user->name}}</td>
                          </tr>
                          <tr>
                            <td><button data-toggle="collapse" data-target="#{{$key_a}}" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-eye-open"></span></button></td>
                            <td><a onclick="return confirm('Yakin akan menggunakan template?')" href="/emr/eresep/edit-template/{{$unit}}/{{$registrasi_id}}/{{$val_a->uuid}}" class="btn btn-success btn-xs">Gunakan Template</a></td>
                          </tr>
                          <tr>
                            <td colspan="2">
                              <div class="accordian-body collapse" id="{{$key_a}}"> 
                                <table class="table table-striped">
                                    <thead>
                                      <tr class="info">
                                        <th>Nama Obat</th>
                                        <th>Qty</th>
                                      </tr>
                                      @foreach ($val_a->resep_detail as $v)
                                      <tr>
                                        <td>{{$v->logistik_batch->master_obat->nama}}</td>
                                        <td>{{$v->qty}}</td>
                                      </tr>
                                          
                                      @endforeach
                                    </thead>
                                </table>
                              </div>
                            </td>
                          </tr> 
                        @endforeach
                        </tbody>
                    </table>  
              </div>
            </div> --}}
            {{-- tabel template  obat--}}

    </div>
  </div>
  <div class="modal fade" id="icd9" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="">Data ICD9</h4>
              </div>
              <div class="modal-body">
                  <div class='table-responsive'>
                      <table id='dataICD9' class='table table-striped table-bordered table-hover table-condensed'>
                          <thead>
                              <tr>
                                  <th>No</th>
                                  <th>Kode</th>
                                  <th>Nama</th>
                                  <th>Add</th>
                              </tr>
                          </thead>
                      </table>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
          </div>
      </div>
  </div>
  
  <div class="modal fade" id="icd10" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="">Data ICD10</h4>
              </div>
              <div class="modal-body">
                  <div class='table-responsive'>
                      <table id='dataICD10' class='table table-striped table-bordered table-hover table-condensed'>
                          <thead>
                              <tr>
                                  <th>No</th>
                                  <th>Kode</th>
                                  <th>Nama</th>
                                  <th>Add</th>
                              </tr>
                          </thead>
                      </table>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
          </div>
      </div>
  </div>
  {{-- Modal Eresep --}}
  {{-- <div id="myModalAddResep" class="modal fade" role="dialog">
   
  </div> --}}
  {{-- Modal History Penjualan ======================================================================== --}}
  <div class="modal fade" id="showHistoriPenjualanEresep" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="">History E-Resep</h4>
        </div>
        <div class="modal-body">
          <div id="dataHistoriEresep"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
  @includeIf('emr.modules.form_edit_eresep')

@endsection

@section('script')

    <script type="text/javascript">

      var buatResep = true;

      $('.sidebar').click(function (e) {
        if (buatResep == true) {
          e.preventDefault()
          alert('Eresep belum disimpan, harap simpan eresep terlebih dahulu')
        }
      })

      $('.logo').click(function (e) {
        if (buatResep) {
          e.preventDefault()
          alert('Eresep belum disimpan, harap simpan eresep terlebih dahulu')
        }
      })

      $('#myTab').click(function (e) {
        if (buatResep) {
          e.preventDefault()
          alert('Eresep belum disimpan, harap simpan eresep terlebih dahulu')
        }
      })

      function editQty(id){
        let qty = $('input[name=edit-qty-'+id+']').val();
        let body = {
          "qty" : qty,
          "_token" : $('input[name=_token]').val(),
        };
        // console.log(body);
        $.ajax({
          url: '/tindakan/e-resep/detail/editQty/'+id,
          type: 'POST',
          dataType: 'json',
          data:body,
          success: function (res){
            if(res.status == true){
              $('#listResep').html(res.html);
              $('#total_harga_umum').html(res.total);
            }else{
              alert("Perubahan Gagal");
            }
          },
          error: function (res){
            if (res.status == 500) {
              alert('Internal Server Error 1')
            } else if (res.status == 0) {
              alert('Gagal terhubung ke server, silahkan periksa jaringan kembali')
            } else {
              alert('Gagal merubah qty obat')
            }
          }
        });
      }
      function editSigna(id){
        let datas = $('input[name=edit-signa-'+id+']').val();
        let body = {
          "signa" : datas,
          "_token" : $('input[name=_token]').val(),
        };
        
        $.ajax({
          url: '/tindakan/e-resep/detail/editSigna/'+id,
          type: 'POST',
          dataType: 'json',
          data:body,
          success: function (res){
            if(res.status == true){
              return alert("Berhasil Ubah Signa")
            }else{
              alert("Perubahan Gagal");
            }
          },
          error: function (res){
            if (res.status == 500) {
              alert('Internal Server Error 2')
            } else if (res.status == 0) {
              alert('Gagal terhubung ke server, silahkan periksa jaringan kembali')
            } else {
              alert('Gagal merubah signa obat')
            }
          }
        });
      }

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
        // HISTORY RESEP
        $(document).on('click', '#historipenjualaneresep', function (e) {
          var id = $(this).attr('data-registrasiID');
          var bayar = $(this).attr('data-bayar');
          $('#showHistoriPenjualanEresep').modal('show');
          $('#dataHistoriEresep').load("/penjualan/"+id+"/"+bayar+"/history-eresep");
        });
        // BTN SAVE RESEP
        $(document).on('click','#btn-save-resep',function(){
        let body = {
            "uuid" : $('input[name=uuid]').val(),
            "reg_id" : $('input[name=reg_id]').val(),
            "pasien_id" : $('input[name=pasien_id]').val(),
            "source" : $('input[name=source]').val(),
            "masterobat_id" : $('select[name=masterobat_id]').val(),
            "qty" : $('input[name=qty]').val(),
            "cara_bayar" : $('select[name=cara_bayar]').val(),
            "tiket" : $('input[name=tiket]').val(),
            "cara_minum" : $('input[name=cara_minum]').val(),
            "kronis" : $('select[name=kronis]').val(),
            "takaran" : $('input[name=takaran]').val(),
            "jenis_obat" : $('select[name=jenis_obat]').val(),
            "informasi" : $('input[name=informasi]').val(),
            "_token" : $('input[name=_token]').val(),
        };
        $.ajax({
            url: '/tindakan/e-resep/save-detail',
            type: 'POST',
            dataType: 'json',
            data: body,
            success: function (res){
            if(res.status == true){
                $('input[name="uuid"]').val(res.uuid);
                $('#listResep').html(res.html);
                $('select[name="masterobat_id"]').val('');
                $('input[name="qty"]').val('');
                
                $('#masterObat').focus();
                $('#masterObat').select2('open');
                buatResep = true;
                // window.location.reload();
            }else{
              return alert(res.data)
            }
            }
        });
        })
        // BTN FINAL RESEP
        $(document).on('click','#btn-final-resep',function(){
        if( confirm('Yakin Akan Tambah Obat Pasien Hari ini..?') ){
            let body = {
            "duplicate" : true,
            "nama_racikan": $('input[name=nama_racikan]').val(),
            "uuid" : $('input[name=uuid]').val(),
            "_token" : $('input[name=_token]').val(),
            };
            $.ajax({
            url: '/tindakan/e-resep/save-resep',
            type: 'POST',
            dataType: 'json',
            data: body,
            success: function (res){
                if(res.status == true){
                    $('#myModalAddResep').modal('hide');
                    if(!alert('Berhasil Add E-Resep !')){
                      // window.location.href = '/emr/jalan'
                      window.location.href = '/emr-soap/anamnesis/main/'+res.unit+'/'+res.regId
                    }
                }else{
                  alert(res.message)
                }
            }
            });
        }
        })

        // BTN FINAL RESEP DAN BUAT TEMPLATE
        $(document).on('click','#btn-final-resep-duplicate-next',function(){
        if( confirm('Yakin Akan Memproses Obat Pasien Dari Riwayat Sebelumnya ...?') ){
            let body = {
            "duplicate" : true,
            "nama_racikan": $('input[name=nama_racikan]').val(),
            "uuid" : $('input[name=uuid]').val(),
            "_token" : $('input[name=_token]').val(),
            };
            $.ajax({
            url: '/tindakan/e-resep/save-resep-duplicate-next',
            type: 'POST',
            dataType: 'json',
            data: body,
            success: function (res){
                if(res.status == true){
                    $('#myModalAddResep').modal('hide');
                    if(!alert('Berhasil Add E-Resep From History !')){
                      // window.location.href = '/emr/jalan'
                      window.location.href = '/emr-soap/anamnesis/main/'+res.unit+'/'+res.regId
                    }
                    // }
                    
                }else{
                  alert(res.message)
                }
            }
            });
        }
        })

        // DELETE DETAIL RESEP
        $(document).on('click','.del-detail-resep',function(){
        let id = $(this).attr('data-id');
        let body = {
            "_token" : $('input[name=_token]').val(),
        };
        $.ajax({
            url: '/tindakan/e-resep/detail/'+id+'/delete',
            type: 'DELETE',
            dataType: 'json',
            data: body,
            success: function (res){
              if(res.status == true){
                  $('#listResep').html(res.html);
                  $('#total_harga_umum').html(res.total);
              }
            },
            error: function (res){
              if (res.status == 500) {
                alert('Internal Server Error 3')
              } else if (res.status == 0) {
                alert('Gagal terhubung ke server, silahkan periksa jaringan kembali')
              } else {
                alert('Gagal menghapus obat')
              }
            }
        });
        })

        // MASTER OBAT
        $('#masterObat').select2({
            placeholder: "Klik untuk isi nama obat",
            width: '100%',
            ajax: {
                url: '/penjualan/resep/master-obat-baru/',
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


        function cariBatch() {
            var masterobat_id= $("select[name='masterobat_id']").val();
            $.get('/penjualan/get-obat-baru/'+masterobat_id, function(resp){
                console.log(resp)
                $('input[name="last_stok"]').val(resp.obat.stok);
                $('input[name="qty"]').focus();
            })
        }
        $(document).ready(function(){
            $(document).on('click','.btn-delete-resume-medis',function(){
                let id = $(this).data('id');
                swal({
                    title: "Yakin Akan Dihapus?",
                    text: "Ketika Dihapus, Anda Tidak Bisa Mengembalikan Data Ini!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        callAjax(id);
                    }
                });
            })

            function callAjax(id) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('/') }}/emr/"+id,
                    dataType: "JSON",
                    data : { 
                                _token: "{{ csrf_token() }}" 
                            },
                    success: function(res){
                        console.log(res)
                        location.reload();
                    }
                });
            }

            $('#kondisi_akhir').change(function(){
                if ($('#kondisi_akhir').val() === "4" || $('#nokontrol').prop("checked") === true) {
                    $("#rencana_kontrol").val('');
                    $("#rencana_kontrol").attr('required', false);
                    $("#rencana_kontrol").attr('disabled', true);
                } else {
                    $("#rencana_kontrol").attr('required', true);
                    $("#rencana_kontrol").attr('disabled', false);
                }
            });


            $('#nokontrol').click(function(){
                $("#rencana_kontrol").val('');
                if ($('#kondisi_akhir').val() === "4" || $('#nokontrol').prop("checked") === true) {
                    $("#rencana_kontrol").attr('required', false);
                    $("#rencana_kontrol").attr('disabled', true);
                } else {
                    $("#rencana_kontrol").attr('required', true);
                    $("#rencana_kontrol").attr('disabled', false);
                }
            });

        //     $(document).on('click','.edit-detail-resep',function(e){
        //       e.preventDefault();
        //       let id = $(this).attr('data-id');
        //       let tiket = $(this).attr('data-tiket');
        //       let qty = $(this).attr('value');
        //       // let url: '/tindakan/e-resep/detail/editQty/'+id+'',
        // let body = {
        //     "_token" : $('input[name=_token]').val(),
        // };
        //         $('#modal-form').modal('show');
        //         $('#modal-form .modal-title').text('Edit QTY ERESEP');
        //         $('#modal-form [name=qty]').val(qty);
        //         $('#modal-form [name=tiket]').val(tiket);
        //         $('#modal-form form').attr('action', '/tindakan/e-resep/detail/editQty/'+id+'');
        //         // $('#modal-form [name=qty]').focus();        
                
        //    $.ajax({
        //     url: '/tindakan/e-resep/detail/editQty/'+id+'',
        //     type: 'POST',
        //     dataType: 'json',
        //     data: body,
        //     success: function (res){
        //     if(res.status == true){
        //         $('#listResep').html(res.html);
        //     }
        //     }
        // });
        // })

        // EDIT DETAIL RESEP

    //  function editForm(url) {
    //             $('#modal-form').modal('show');
    //             $('#modal-form .modal-title').text('Edit QTY ERESEP');

    //             $('#modal-form form')[0].reset();
    //             $('#modal-form form').attr('action', url);
    //             $('#modal-form [name=_method]').val('put');
    //             $('#modal-form [name=]').focus();        
                
    // $.get(url)
    //       .done((response) => {
    //         $('#modal-form [name=qty]').val(response.qty);
    //         // $('#modal-form [name=id_kondektur]').val(response.id_kondektur);
    //         // $('#modal-form [name=id_kondektur]').val(response.id_kondektur);
    //         // $('#modal-form [name=id_kondektur]').val(response.id_kondektur);
    //         // $('#modal-form [name=id_kategori]').val(response.id_kategori);
    //         // $('#modal-form [name=merk]').val(response.merk);
    //         // $('#modal-form [name=harga_beli]').val(response.harga_beli);
    //         // $('#modal-form [name=harga_jual]').val(response.harga_jual);
    //         // $('#modal-form [name=diskon]').val(response.diskon);
    //         // $('#modal-form [name=stok]').val(response.stok);
    //        })
    //       .fail((errors) => {
    //         alert('Tidak Dapat Mengedit Data');
    //         return;
    //       });
    //     }   
        });
       
    </script>
@endsection

@section('css')
    <style>
      #btn-save-resep:focus {
        background-color: green;
      }
    </style>
@endsection

