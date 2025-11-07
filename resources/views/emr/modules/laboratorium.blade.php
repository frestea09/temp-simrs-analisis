@extends('master')
@section('header')
  <h1>{{baca_unit($unit)}} - Laboratorium<small></small></h1>
@endsection

@section('content')
@php
  $route = Route::current()->getName();
@endphp
@include('emr.modules.addons.profile')
<style>
  .input-cito{
    width: 100px !important;
    display: inline-block;
  }
  div.panel.box.box-primary{
    padding:0px !important;
  }
</style>
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Input Hasil Lab</h3>
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
    <br/>
    @php

      $poli = request()->get('poli');
      $dpjp = request()->get('dpjp');
    @endphp
      {{-- @if (! session('pj')) --}}
    {!! Form::open(['method' => 'POST', 'url' => 'pemeriksaanlab/store-none-lis-new', 'class' => 'form-horizontal', 'id' => "form_order_laboratorium"]) !!}
      <div class="col-md-6">
        {!! Form::hidden('pasien_id', $pasien->id) !!}
        {!! Form::hidden('poli_id', $poli) !!}
        {!! Form::hidden('ruangan_inap', $ruangan_inap) !!}
        {!! Form::hidden('kelompok', $kelompok) !!}
        {!! Form::hidden('cara_bayar_id', $reg->bayar) !!}
        {!! Form::hidden('dokter_id', $reg->dokter_id) !!}
        {!! Form::hidden('jenis', $reg->jenis_pasien) !!}
        {!! Form::hidden('reg_id', $reg->id) !!}
        {!! Form::hidden('unit', $unit) !!}
        <div class="form-group{{ $errors->has('penanggungjawab') ? ' has-error' : '' }}">
            {!! Form::label('penanggungjawab', 'Dokter Pengirim', ['class' => 'col-sm-4 control-label']) !!}
            {{-- session('pj') --}}
            <div class="col-sm-8">
                {!! Form::select('penanggungjawab', $dokter, $reg->dokter_id, ['class' => 'chosen-select']) !!}
                <small class="text-danger">{{ $errors->first('penanggungjawab') }}</small>
            </div>
        </div>
        {{-- <div class="form-group{{ $errors->has('jam') ? ' has-error' : '' }}">
          {!! Form::label('jam', 'Jam Pengambilan', ['class' => 'col-sm-4 control-label']) !!}
          <div class="col-sm-8">
              {!! Form::text('jam', null, ['class' => 'form-control timepicker']) !!}
              <small class="text-danger">{{ $errors->first('jam') }}</small>
          </div>
        </div> --}}
      </div>

      <div class="col-md-6">
        <div class="form-group{{ $errors->has('tgl_pemeriksaan') ? ' has-error' : '' }}">
          {!! Form::label('tglpemeriksaan', 'Tgl Pemeriksaan', ['class' => 'col-sm-4 control-label']) !!}
          <div class="col-sm-8">
              {!! Form::text('tgl_pemeriksaan', date('d-m-Y'), ['class' => 'form-control datepicker']) !!}
              <small class="text-danger">{{ $errors->first('tgl_pemeriksaan') }}</small>
          </div>
        </div>
        {{-- <div class="form-group{{ $errors->has('jam') ? ' has-error' : '' }}">
          {!! Form::label('jamkeluar', 'Jam Keluar', ['class' => 'col-sm-4 control-label']) !!}
          <div class="col-sm-8">
              {!! Form::text('jamkeluar', null, ['class' => 'form-control timepicker']) !!}
              <small class="text-danger">{{ $errors->first('jam') }}</small>
          </div>
        </div> --}}
      </div>

    {{-- @endif --}}
    <div id="exTab1" class="container">	
      <br/>
    <ul  class="nav nav-pills">
          <li class="{{$route == 'lab' ? 'active' :''}}">
            <a href="{{url('emr/lab/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Satuan</a>
          </li>
          <li class="{{$route == 'lab-paket' ? 'active' :''}}">
            <a href="{{url('emr/lab-paket/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Paket</a>
          </li>
        </ul> 
      </div>
    
    
    <hr></hr>
      <div class="col-md-12">
        {{-- <ul class="nav nav-tabs">
          <li><a href="#">Satuan</a></li>
          <li><a href="#">Paket</a></li>
        </ul> --}}
        {{-- <div class="box-group" id="accordion">
          
        </div> --}}
        
        <h4 class="text-center">Input Test Satuan</h4>
        <table class="table table-striped table-bordered table-hover table-condensed dataTable no-footer" id="tableLabSatuan">
          {{-- <tr><th colspan="6">{{ $lab_kat->nama }}</th></tr> --}}
          <thead>
            <tr>
              <th width="40px" class="text-center">No</th>
              <th class="text-center">Pilih</th>
              <th class="text-center">Eksekutif</th>
              <th class="text-center">Nama (General Code)</th>
              <th class="text-center" width="25%">Keterangan Klinis / Diagnosa</th>
              {{-- <th class="text-center">Hasil Text</th> --}}
              {{-- <th class="text-center">Standart</th> --}}
              {{-- <th class="text-center">Satuan</th> --}}
            </tr>
          </thead>
          @php $no = 1; @endphp
          <tbody>

            @foreach ($labsection as $lab)
            {{-- @php
                $harga =  Modules\Tarif\Entities\Tarif::where('lica_id', '=', $lab->id)->first();
            @endphp --}}
            <tr>
              <td class="text-center">{{ $no++ }}</td>
              <td width="5%" class="text-center">
                {{-- <span style="position:absolute;color:#8080803b">Pilih</span> --}}
                <input type="checkbox" onclick="validateInput(this,{{$lab->id}})" class="hasil" name="hasil[{{ $lab->id }}_{{ $lab->nama }}_{{ $lab->general_code}}]" id="" data-lab-id="{{$lab->id}}">
              </td>
              <td width="5%" class="text-center">
                {{-- <input type="number" value="Ya" class="form-control" style="text-align:center;padding:0px;height:25px" name="cito[{{ $lab->id }}]" id=""> --}}
                <input type="hidden" name="cito[{{ $lab->id }}]" value="0">
                <input type="checkbox" onclick="validateInput(this,{{$lab->id}})" name="cito[{{ $lab->id }}]" id="" value="1">
              </td>
              <td>{{ $lab->nama }} - Rp. {{ number_format($lab->total) }}</td>
              <td>
                <input type="text" name="keterangan[{{ $lab->id }}]" class="form-control keterangan{{$lab->id}}" id="" style="width:100%;">
              </td>
              {{-- <td>
                <input name="hasiltext[{{ $lab->id }}_{{ $lab_kat->id }}_{{ $sec->id }}]" class="form-control" />
              </td>
              <td width="100px" class="text-center">{{ $lab->nilairujukanbawah }} - {{ $lab->nilairujukanatas}}</td>
              <td width="150px" class="text-center">{{ $lab->satuan }}</td> --}}
            </tr>
            @endforeach
            @foreach ($labsection2 as $lab)
            {{-- @php
                $harga =  Modules\Tarif\Entities\Tarif::where('lica_id', '=', $lab->id)->first();
            @endphp --}}
            <tr>
              <td class="text-center">{{ $no++ }}</td>
              <td width="5%" class="text-center">
                {{-- <span style="position:absolute;color:#8080803b">Pilih</span> --}}
                <input type="checkbox" class="hasil" name="hasil[{{ $lab->id }}_{{ $lab->nama }}_{{ $lab->general_code}}]" id="" data-lab-id="{{$lab->id}}">
              </td>
              <td width="5%" class="text-center">
                {{-- <input type="number" value="Ya" class="form-control" style="text-align:center;padding:0px;height:25px" name="cito[{{ $lab->id }}]" id=""> --}}
                <input type="hidden" name="cito[{{ $lab->id }}]" value="0">
                <input type="checkbox" name="cito[{{ $lab->id }}]" id="" value="1">
              </td>
              <td>{{ $lab->nama }} - Rp. {{ number_format($lab->total) }}</td>
              <td>
                <input type="text" name="keterangan[{{ $lab->id }}]" class="form-control" value="" id="" style="width:100%;">
              </td>
              {{-- <td>
                <input name="hasiltext[{{ $lab->id }}_{{ $lab_kat->id }}_{{ $sec->id }}]" class="form-control" />
              </td>
              <td width="100px" class="text-center">{{ $lab->nilairujukanbawah }} - {{ $lab->nilairujukanatas}}</td>
              <td width="150px" class="text-center">{{ $lab->satuan }}</td> --}}
            </tr>
            @endforeach
          </tbody>
      </table>
        
          {{-- <div class="col-md-6">
            <div class="form-group{{ $errors->has('pesan') ? ' has-error' : '' }}">
              {!! Form::label('pesan', 'Pesan', ['class' => 'col-sm-4 control-label']) !!}
              <div class="col-sm-8">
                  {!! Form::textarea('pesan', null, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('pesan') }}</small>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group{{ $errors->has('kesan') ? ' has-error' : '' }}">
              {!! Form::label('kesan', 'Kesan', ['class' => 'col-sm-4 control-label']) !!}
              <div class="col-sm-8">
                  {!! Form::textarea('kesan', null,['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('kesan') }}</small>
              </div>
            </div>
          </div> --}}
          
        
        <button style="margin-top: 10px;" id="btnSave" class="btn btn-success btn-flat pull-right" type="submit">Simpan</button>
      </div>
    {!! Form::close() !!}
  </div>
</div>

{{-- <div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">History Order Lab</h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div>
  </div> --}}
  {{-- <div class="box-body">
    <div class='table-responsive'>
      <table class='table table-striped table-bordered table-hover table-condensed'>
        <thead>
          <tr>
            <th width="40px" class="text-center">No</th>
            <th>No. Lab</th>
            <th width="200px" class="text-center">Tanggal</th>
            <th>Cetak</th>
          </tr>
        </thead>
        <tbody>
      @if(count($hasillabs) > 0)
        @php $no = 1; @endphp
        @foreach($hasillabs as $key=>$labs)

          <tr>
            <td class="text-center">{{$key+1}}</td>
            <td>{{$labs->no_lab}}</td>
            <td class="text-center">{{date('d-m-Y, H:i',strtotime($labs->created_at))}}</td>
            <td class="text-left"><a href="{{url('cetak-lis-pdf/'.$labs->no_lab.'/'.$reg->id)}}" class="btn btn-primary btn-flat btn-xs"><i class="fa fa-print"></i> CETAK</a></td>
          </tr>
        @endforeach
      @endif
        </tbody>
      </table>
    </div> --}}
    {{-- @if(count($hasillabs) > 0)
      <a href="{{ url('pemeriksaanlab/cetakAll/'.$reg->id) }}" target="_blank" class="btn btn-warning btn-flat pull-right">CETAK</a>
    @endif --}}
  {{-- </div> --}}
{{-- </div> --}}
  {{-- </div> --}}

<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">History Tindakan Lab</h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div>
  </div>
  <div class="box-body">
    <div class='table-responsive' style="margin-top: 20px">
      <table class='table-striped table-bordered table-hover table-condensed table' >
          <thead>
              <tr>
                  <th>Waktu Order</th>
                  <th>Pemeriksaan</th>
                  <th>Keterangan / Catatan / Diagnosa</th>
                  <th>Dokter</th>
                  <th>Perawat</th>
              </tr>
          </thead>
          <tbody>
              @forelse ($folioLabs as $fol)
                  <tr>
                      <td>{{ date('d-m-Y H:i:s', strtotime($fol->created_at)) }}</td>
                      <td>{{ $fol->namatarif }}</td>
                      <td>{{ $fol->catatan }}</td>
                      <td>{{ baca_dokter($fol->dokter_pelaksana) }}</td>
                      <td>{{ baca_pegawai($fol->perawat) }}</td>
                  </tr>
              @empty
                  <tr >
                      <td colspan="5" class="text-center">Tidak Ada Data</td>
                  </tr>
              @endforelse
          </tbody>
      </table>
    </div>
  </div>
</div>

<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">History Order Lab</h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div>
  </div>
  <div class="box-body">
    <div class='table-responsive' style="margin-top: 20px">
      <table class='table-striped table-bordered table-hover table-condensed table' >
          <thead>
              <tr>
                  <th>Waktu Order</th>
                  <th style="width: 500px;">Pemeriksaan</th>
                  <th>Status</th>
                  <th>Dokter</th>
                  <th>User Order</th>
                  <th>Hapus</th>
              </tr>
          </thead>
          <tbody>
              @if (count($reg->historyOrderLab) > 0)
                @foreach ($reg->historyOrderLab as $historyOrderLab)
                  <tr>
                      <td>{{ date('d-m-Y H:i:s', strtotime($historyOrderLab->created_at)) }}</td>
                      <td>{{ $historyOrderLab->catatan }}</td>
                      <td>{{ $historyOrderLab->is_done ? 'Sudah Diproses' : 'Belum Diproses' }}</td>
                      <td>{{ baca_dokter($reg->dokter_id) }}</td>
                      <td>{{ baca_user($historyOrderLab->user_id) }}</td>
                      <td>
                        <a href="{{ url("laboratorium/histori-delete/".@$reg->id."/".@$historyOrderLab->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin Akan Menghapus Data Ini ?')">
                          <i class="fa fa-trash"></i>
                        </a>
                      </td>
                  </tr>
                @endforeach
              @else
                <tr>
                  <td colspan="6" style="text-align: center;">Tidak ada order lab sebelumnya</td>
                </tr>
              @endif
          </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

<style>
  .select2-selection__rendered{
    padding-left: 20px !important;
  }
</style>

@section('script')
  <script>
    let datatable = $('#tableLabSatuan').DataTable({
      order: [],     
      columnDefs: [
          { orderable: false, targets: [] }, 
      ],
    });
  </script>
  <script type="text/javascript">
    $('.select2').select2();
  </script>
    <script>
      function validateInput(input,id){
        var checkBox = input;
        var keterangan = $('.keterangan'+id);

        if(checkBox.checked == true){
          keterangan.attr('required', true);
        }else{
          keterangan.attr('required', false);
        }
      }

      $(':checkbox', datatable.rows().nodes()).each(function () {
        $(this).change(function () {
          let lab_id = $(this).data("lab-id");
          const inputText = document.querySelector(`input[name='keterangan[${lab_id}]']`);
          // if (this.checked) {
          //   inputText.setAttribute('required', 'required');
          // } else {
          //   inputText.removeAttribute('required');
          // }
        })
      });

      $('#form_order_laboratorium').submit(function(e) {
        if (confirm('Apakah yakin ingin order tindakan tersebut ?')) {
          e.preventDefault();
          let form = $(this);
          let foundEmptyInput = false;
          // $(this).find('#btnSave').prop('disabled',true);
          $('.hasil:checkbox:checked', datatable.rows().nodes()).each(function () {
            let lab_id = $(this).data("lab-id");
            // Checkbox
            let checkedElement = $(this).attr('type', "hidden").val(1);
            checkedElement.appendTo(form)

            // Cito
            let cito = $('input[name="cito[' + lab_id + ']"]', datatable.rows().nodes());

            cito.each(function() {
              let cito_l = $(this);
              
              if ($(cito_l).attr('type') == "checkbox") {
                if ($(cito_l).is(":checked")) {
                  $(cito_l).attr('type', 'hidden').appendTo(form)
                }
              } else {
                $(cito_l).attr('type', 'hidden').appendTo(form)
              }
              
              // Keterangan
              let keterangan = $('input[name="keterangan[' + lab_id + ']"]', datatable.rows().nodes());
              keterangan.each(function() {
                // $(this).attr('type', 'hidden').appendTo(form)
                // if ($(this).val() != "") {
                  $(this).appendTo(form);
                // } else {
                //   foundEmptyInput = true;
                // }
              })
            })
          })
          $('#form_order_laboratorium')[0].submit();
        } else{
          return false
        }

          // if (!foundEmptyInput) {
          //   $('#form_order_laboratorium')[0].submit();
          // } else {
          //   alert(`Keterangan / Diagnosa pada pemeriksaan yang dipilih wajib di isi semua!`)
          // }
      });

      $(document).ready(function() {
          
        var max_fields      = 25;
          var wrapper         = $(".input_fields_wrap"); 
          var add_button      = $(".add_field_button");
          var remove_button   = $(".remove_field_button");
          var i = 2;


           // row 3
           $(".add_daftar_2").click(function(e){
              e.preventDefault();
              // var total_fields = wrapper[0].childNodes.length;
              if(i < max_fields){
                  i++;
                  $('.daftar_obat_2').append( '<tr>'+
                  '<td class="text-center">'+(i+1)+'</td>'+
                  '<td class="text-center"><input type="text" class="form-control" name="admisi[transfer]['+i+'][dosis]"></td>'+
                  '<td class="text-center"><input type="text" class="form-control" name="admisi[transfer]['+i+'][frekuensi]"></td>'+
                  '<td class="text-center"><input type="text" class="form-control" name="admisi[transfer]['+i+'][cara]"></td>'+
                  '<td class="text-left"><input type="text" class="form-control input-cito" name="admisi[transfer]['+i+'][cara]"> <a href="#" class="remove_field_obat_2 btn btn-xs btn-danger">X</a></td>'+
                '</tr>');
                  // $(wrapper).find(".datepicker").datepicker({autoclose: true,format: "dd-mm-yyyy"})
              }
          });
          $(".daftar_obat_2").on("click",".remove_field_obat_2", function(e){ //user click on remove text
              console.log($(this));
              e.preventDefault(); $(this).closest("tr").remove(); i--;
            })

      });
</script>
@endsection