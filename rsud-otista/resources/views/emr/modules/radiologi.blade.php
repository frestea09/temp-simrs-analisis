@extends('master')
@section('header')
<h1>{{baca_unit($unit)}} - Radiologi <small></small></h1>
@endsection

@section('content')
@include('emr.modules.addons.profile')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Data Tindakan Radiologi {{baca_unit($unit)}}</h3>
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
      {!! Form::open(['method' => 'POST', 'url' => url('emr/save-tindakan'), 'class' => 'form-horizontal', 'id' => 'form_order_radiologi']) !!}
      {!! Form::hidden('registrasi_id', $reg->id) !!}
      {!! Form::hidden('jenis', $jenis->jenis_pasien) !!}
      {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
      {!! Form::hidden('dokter_id', $jenis->dokter_id) !!}
      {!! Form::hidden('page', 'rad'.ucfirst($unit)) !!}
      <div class="row">
        <div class="col-md-7">
          <div class="form-group{{ $errors->has('pelaksana') ? ' has-error' : '' }}">
            {!! Form::label('pelaksana', 'Pengirim', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
                {{-- {!! Form::select('pelaksana', $pelaksana, session('pelaksana'), ['class' => 'chosen-select', 'placeholder'=>'']) !!} --}}
                <select class="form-control select2" name="pelaksana" style="width: 100%;">
                          
                  @foreach ($pelaksana as $d)
                    <option value="{{ $d->id }}" {{ $d->id == $jenis->dokter_id ? 'selected' : '' }}> {{ $d->nama }} </option>
                  @endforeach
           
               </select>
                <small class="text-danger">{{ $errors->first('pelaksana') }}</small>
            </div>
          </div>
          <div class="form-group{{ $errors->has('dokter_id') ? ' has-error' : '' }}">
              {!! Form::label('dokter_id', 'Dokter Radiologi', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                <select name="dokter_radiologi" id="" class="form-control select2">
                  @foreach ($dokter as $d)
                    @if (isset($dokter_radiologi_gigi))
                      <option value="{{ $d->id }}" {{$dokter_radiologi_gigi == $d->id ? 'selected' : ''}}>{{ baca_dokter($d->id) }}</option>
                    @else
                      <option value="{{ $d->id }}">{{ baca_dokter($d->id) }}</option>
                    @endif
                  @endforeach
                </select>
                {{-- {!! Form::select('dokter_radiologi', $radiografer, '', ['class' => 'form-control select2', 'style'=>'width: 100%', 'placeholder'=>'']) !!} --}}
                  <small class="text-danger">{{ $errors->first('dokter_id') }}</small>
              </div>
          </div>
          <div class="form-group{{ $errors->has('cara_bayar_id') ? ' has-error' : '' }}">
            {!! Form::label('cara_bayar_id', 'Cara Bayar', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
                {!! Form::select('cara_bayar_id', $carabayar, $reg->bayar, ['class' => 'form-control select2', 'style'=>'width:100%;']) !!}
                <small class="text-danger">{{ $errors->first('cara_bayar_id') }}</small>
            </div>
          </div>
          <div class="form-group{{ $errors->has('status_puasa') ? ' has-error' : '' }}">
              {!! Form::label('status_puasa', 'Status Puasa', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                  {!! Form::select(
                      'status_puasa',
                      ['Ya' => 'Ya', 'Tidak' => 'Tidak'], 
                      old('status_puasa', $reg->status_puasa ?? 'Tidak'),
                      ['class' => 'form-control', 'id' => 'status_puasa', 'style'=>'width:100%;']
                  ) !!}
                  <small class="text-danger">{{ $errors->first('status_puasa') }}</small>
              </div>
          </div>
          <div id="puasa_fields" style="display:none;">
              <div class="form-group">
                  {!! Form::label('mulai_puasa', 'Mulai Puasa', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-4">
                      {!! Form::datetimeLocal('mulai_puasa', old('mulai_puasa', $reg->mulai_puasa ?? null), ['class' => 'form-control']) !!}
                  </div>
              </div>
              <div class="form-group">
                  {!! Form::label('selesai_puasa', 'Berakhir Puasa', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-4">
                      {!! Form::datetimeLocal('selesai_puasa', old('selesai_puasa', $reg->selesai_puasa ?? null), ['class' => 'form-control']) !!}
                  </div>
              </div>
          </div>
        </div>

        <div class="col-md-5">
          <div class="form-group{{ $errors->has('jumlah') ? ' has-error' : '' }}">
              {!! Form::label('jumlah', 'Jumlah', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                  {!! Form::number('jumlah', 1, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('jumlah') }}</small>
              </div>
          </div>
          <div class="form-group">
              {!! Form::label('tanggal', 'Tanggal', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                  {!! Form::text('tanggal', date("d-m-Y"), ['class' => 'form-control datepicker']) !!}
                  <small class="text-danger">{{ $errors->first('jumlah') }}</small>
              </div>
          </div>
          <div class="form-group{{ $errors->has('poli_id') ? ' has-error' : '' }}">
              {!! Form::label('poli_id', 'Pelayanan', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                  <select class="form-conterol select2" name="poli_id" style="width: 100%;">
                    {{-- <option value="" selected>[Pilih]</option> --}}
                    @foreach ($opt_poli as $key => $d)
                      {{-- @if ($d->id == $jenis->poli_id)
                        <option value="" selected></option>
                        <option value="{{ $d->id }}">{{ $d->nama }}</option>
                      @else --}}
                        <option value="{{ $d->id }}">{{ $d->nama }}</option>
                      {{-- @endif --}}

                    @endforeach
                  </select>
                  <small class="text-danger">{{ $errors->first('poli_id') }}</small>
              </div>
          </div>
        
        </div>
        <div class="form-group{{ $errors->has('tarif_id') ? ' has-error' : '' }}">
          <div class="col-sm-12">
            <table class="table table-striped table-bordered table-hover table-condensed dataTable no-footer" id="tableRadiologi">
              {{-- <tr><th colspan="6">{{ $lab_kat->nama }}</th></tr> --}}
              <thead>  
                <tr>
                  <th width="40px" class="text-center">No</th>
                  <th class="text-center">Pilih</th>
                  <th class="text-center">Eksekutif</th>
                  <th class="text-center">Nama</th>
                  {{-- <th class="text-center">Kategori Tarif</th> --}}
                  <th class="text-center" width="25%">Keterangan Klinis / Diagnosa</th>
                  <th class="text-center">Harga</th>
                </tr>
              </thead>
              @php $no = 1; @endphp
              <tbody>
                @foreach ($tindakan as $rad)
                <tr>
                  <td class="text-center">{{ $no++ }}</td>
                  <td width="5%" class="text-center">
                    <input type="checkbox" name="tarif_id[]" value="{{ $rad->id }}" id="" class="checkbox">
                  </td>
                  <td width="5%" class="text-center">
                    <input type="hidden" name="cito[{{ $rad->id }}]" id="" value="0">
                    <input type="checkbox" name="cito[{{ $rad->id }}]" id="" value="1">
                  </td>
                  <td class="nama_pemeriksaan">{{ $rad->nama }}</td>
                  {{-- <td>{{ $rad->namatarif }}</td> --}}
                  <td>
                    <input type="text" name="keterangan[{{ $rad->id }}]" class="form-control" value="" id="" style="width:100%;">
                  </td>
                  <td>
                    Rp. {{ number_format(@$rad->total,0,',','.') }}
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
             <small class="text-danger">{{ $errors->first('tarif_id') }}</small>
          </div>
        </div>
        <div class="form-group">
          {!! Form::label('', '', ['class' => 'col-sm-3 control-label']) !!}
          <div class="col-sm-9">
              <a href="{{ url('tindakan') }}" class="btn btn-warning btn-flat">Kembali</a>
              {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat pull-right', 'onclick'=>'javascript:return confirm("Yakin Data Ini Sudah Benar")']) !!}
          </div>
      </div>
      </div>
      {!! Form::close() !!}
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
              <th>Pengirim</th>
              <th>Dokter Radiologi</th>
              <th>Cara Bayar</th>
              <th>Admin</th>
              <th>Waktu</th>
              <th>Catatan</th>
              {{-- <th>Bayar</th> --}}
              @role(['rawatjalan','supervisor', 'rawatdarurat','administrator'])
              <th>Hapus</th>
              @endrole
              {{-- <th>Note</th> --}}
            </tr>
          </thead>
          @php
            $noData = 1;
          @endphp
          <tbody>
            @foreach ($folio as $key => $d)
              <tr>
                <td>{{ $noData++ }}</td>
                @if (@$d->verif_kasa_user = 'tarif_new')
                  <td>{{ ($d->tarif_id <> 10000 ) ? $d->tarif_baru->nama : 'Penjualan Obat' }}</td>
                  <td>{{ baca_poli($d->poli_id) }}</td>
                  @if(@$d->cyto)
                    @php
                     $cyto = ($d->tarif_baru->total * 30) / 100;
                     $hargaTotal = $d->tarif_baru->total + $cyto;
                    @endphp
                    <td class="text-right">{{ number_format($hargaTotal, 0, ',', '.') }}</td>
                    <td class="text-right">{{ floor($d->total / $hargaTotal) }}</td>
                  @else
                    <td class="text-right">{{ ($d->tarif_id <> 10000 ) ? number_format($d->tarif_baru->total,0,',','.') : '' }}</td>
                    <td class="text-right">{{ ($d->tarif_id <> 10000 ) ? ($d->total / $d->tarif_baru->total) : '' }}</td>
                  @endif
                @else
                <td>{{ ($d->tarif_id <> 10000 ) ? $d->tarif->nama : 'Penjualan Obat' }}</td>
                <td>{{ baca_poli($d->poli_id) }}</td>
                <td class="text-right">{{ ($d->tarif_id <> 10000 ) ? number_format($d->tarif->total,0,',','.') : '' }}</td>
                <td class="text-right">{{ ($d->tarif_id <> 10000 ) ? ($d->total / $d->tarif->total) : '' }}</td>
                @endif
                {{-- <td class="text-right">{{ ($d->tarif_id <> 10000 ) ? number_format($d->tarif->total,0,',','.') : '' }}</td>
                <td class="text-center">{{ ($d->tarif_id <> 10000 ) ? ($d->total / $d->tarif->total) : '' }}</td> --}}
                <td class="text-right">{{ number_format($d->total,0,',','.') }}</td>
                <td>{{ baca_dokter($d->dokter_pelaksana) }}</td>
                <td>{{ baca_dokter($d->dokter_radiologi) }}</td>
                <td>{{ baca_carabayar($d->cara_bayar_id) }}</td>
                <td>{{ $d->user->name }}</td>
                <td>{{ $d->created_at->format('d-m-Y') }}</td>
                <td>{!!@$d->diagnosa !!}</td>
                @role(['rawatjalan','kasir', 'supervisor', 'rawatdarurat','administrator'])
                <td>
                  @if ($d->lunas == 'Y')
                    <i class="fa fa-check"></i>
                  @else
                    <a href="{{ url('tindakan/hapus-tindakan/'.$d->id.'/'.$d->registrasi_id.'/'.$d->pasien_id) }}" onclick="return confirm('Yakin akan di hapus?')" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-trash-o"></i></a>
                  @endif

                </td>
                @endrole
                {{-- <td>
                  <button type="button" class="btn btn-sm btn-info btn-flat" data-id="{{ @$d->id }}" onclick="showNote({{ $d->id }})"><i class="fa fa-book"></i></button>
                </td> --}}
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  {{-- <div class="box box-primary">
    <div class="box-header with-border">
      <h4>Order Radiologi</h4>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
      @include('tinymce')
      @if ($unit == 'jalan')
        {!! Form::open(['method' => 'POST', 'url' => 'tindakan/simpanRadJalan', 'class' => 'form-horizontal']) !!}
      @elseif($unit == 'igd')
        {!! Form::open(['method' => 'POST', 'url' => 'tindakan/simpanRadIgd', 'class' => 'form-horizontal']) !!}
      @elseif($unit == 'inap')
        {!! Form::open(['method' => 'POST', 'url' => 'tindakan/simpanRadInap', 'class' => 'form-horizontal']) !!}
      @endif
        
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('dokter', $reg->dokter_id) !!}
          <textarea id="editor1" name="pemeriksaan" rows="10" cols="80"></textarea>
          <br/>
          <div class="row">
            <div class="col-sm-12">
              <div class="btn-group pull-right">
                  <a href="{{ url('tindakan') }}" class="btn btn-warning btn-flat">Batal</a>
                  {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
              </div>
            </div>
          </div>
        {!! Form::close() !!}
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr><th colspan='4'>Order Radiologi Sebelumnya</th></tr>
              <tr>
                <th class="text-center">No</th>
                <th class="text-center">Pemeriksaan</th>
                <th class="text-center">Oleh</th>
                <th class="text-center">Tgl Order</th>
              </tr>
            </thead>
            <tbody>
              @php $no = 1; @endphp
              @foreach ($order as $d)
                <tr>
                  <th class="text-center" width="50px">{{ $no++ }}</td>
                  <td>{!! $d->pemeriksaan !!}</td>
                  <td>{{ App\User::find($d->user_id)->name }}</td>
                  <td width="200px">{{ $d->created_at->format('d - m - Y / H:i:s') }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
    </div>
  </div> --}}
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
        <div class="modal-footer">
          <button type="button" onclick="saveNote()" class="btn btn-default btn-flat">Simpan</button>
          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
        </div>
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
  var datatable = $('#tableRadiologi').DataTable({
        paging: true,
        ordering: false,
        pageLength: 20,
  });


</script>

  <script>
    $(document).ready(function() {
        function togglePuasaFields() {
            let val = $('#status_puasa').val();
            if(val === 'Ya'){
                $('#puasa_fields').show();
            } else {
                $('#puasa_fields').hide();
            }
        }

        togglePuasaFields();

        $('#status_puasa').change(function(){
            togglePuasaFields();
        });
    });
  </script>

  <script type="text/javascript">
    $('.select2').select2();
 
      $(document).ready(function() {
          // Select2 Multiple
          $('.select2-multiple').select2({
              placeholder: "Pilih Multi Tindakan",
              allowClear: true
          });

      });




    $(':checkbox', datatable.rows().nodes()).each(function () {
      $(this).change(function () {
        const inputText = document.querySelector(`input[name='keterangan[${this.value}]']`);
        if (this.checked) {
          inputText.setAttribute('required', 'required');
        } else {
          inputText.removeAttribute('required');
        }
      })
    });


    $('#form_order_radiologi').submit(function (e) {
      e.preventDefault();
      let form = $(this);
      let foundEmptyInput = false;
      $(':checkbox:checked', datatable.rows().nodes()).each(function () {
        // Checkbox
        let checkedElement = $(this).attr('type', "hidden");

        // Textbox (Keterangan / Diagnosa)
        let inputText = $(`input[name="keterangan[${checkedElement.val()}]"]`, datatable.rows().nodes());
        inputText.attr('type', "hidden");

        // Pemeriksaan
        let pemeriksaan = $(this).closest('tr').find('.nama_pemeriksaan').text();

        if (inputText.val() != "") {
          checkedElement.appendTo(form);
          inputText.appendTo(form);
        } else {
          foundEmptyInput = true;
          alert(`Keterangan / Diagnosa pada pemeriksaan ${pemeriksaan} wajib di isi!`)
        }
      })
      if (!foundEmptyInput) {
        $('#form_order_radiologi')[0].submit();
      }
    })


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



 function saveNote() {
   var id_reg =  $('input[name="id_reg"]').val();

   $.ajax({
     headers: {
     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     },
     url: '/radiologi/updateNoteEmr/'+id_reg,
     type: 'POST',
     dataType: 'json',
     data: {
       note: $('input[name="catatan"]').val(),
       tgl_note: $('input[name="tgl_order"]').val()
     }
   })
   .done(function(data) {
     alert('berhasil simpan catatan')
   
   })
   .fail(function() {
     alert('gagal input');
   });

}



</script>
@endsection
