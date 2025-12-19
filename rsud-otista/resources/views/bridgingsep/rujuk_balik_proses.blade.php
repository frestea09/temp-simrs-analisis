@extends('master')

@section('header')
<h1>Pembuatan Rujuk Balik (PRB)</h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="box-widget widget-user">
                        <div class="widget-user-header bg-aqua-active">
                            <div class="row">
                                <div class="col-md-2">
                                    <h4 class="widget-user-username">Nama</h4>
                                    <h5 class="widget-user-desc">No. RM</h5>
                                    <h5 class="widget-user-desc">Tgl Lahir / Umur</h5>
                                    <h5 class="widget-user-desc">Alamat</h5>
                                    <h5 class="widget-user-desc">Cara Bayar</h5>
                                    @if($reg->bayar == 1)
                                        <h5 class="widget-user-desc">No JKN</h5>
                                    @endif
                                    <h5 class="widget-user-desc">DPJP</h5>
                                </div>
                                <div class="col-md-6">
                                    <h3 class="widget-user-username">:{{ $pasien->nama}}</h3>
                                    <h5 class="widget-user-desc">: {{ $pasien->no_rm }}</h5>
                                    <h5 class="widget-user-desc">: {{ !empty($pasien->tgllahir) ? $pasien->tgllahir : ''}} / {{ !empty($pasien->tgllahir) ? hitung_umur($pasien->tgllahir) : NULL }}</h5>
                                    <h5 class="widget-user-desc">: {{ $pasien->alamat}}</h5>
                                    <h5 class="widget-user-desc">: {{ baca_carabayar($reg->bayar) }} </h5>
                                @if($reg->bayar == 1)
                                    <h5 class="widget-user-desc">: {{ $pasien->no_jkn}}</h5>
                                @endif
                                    <h5 class="widget-user-desc">: {{ baca_dokter($reg->dokter_id)}}</h5>
                                </div>
                                <div class="col-md-3 text-center">
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="box-body">
            @if( $prb != '' )
            {!! Form::open(['method' => 'POST', 'url' => 'bridgingsep/rujuk-balik/save/'.$prb->id, 'class' => 'form-horizontal']) !!}
            @else
            {!! Form::open(['method' => 'POST', 'url' => 'bridgingsep/rujuk-balik/save', 'class' => 'form-horizontal']) !!}
            @endif
                {!! Form::hidden('reg_id', $reg->id) !!}
                {!! Form::hidden('pasien_id', $pasien->id) !!}
                <div class="row">
                    <div class="col-md-6">
                      <div class="form-group{{ $errors->has('no_sep') ? ' has-error' : '' }}">
                          {!! Form::label('no_sep', 'NO SEP', ['class' => 'col-sm-3 control-label']) !!}
                          <div class="col-sm-9">
                              @if( $prb != '' )
                              <button type="button" class="btn btn-default btn-block btn-search-sep" style="margin-bottom: 5px;">Search</button>
                              {!! Form::text('no_sep', ( $prb != '' ) ? $prb->no_sep : $reg->no_sep, ['class' => 'form-control', 'required']) !!}
                                {{-- @if( $reg->no_sep != null )
                                {!! Form::text('no_sep', ( $prb != '' ) ? $prb->no_sep : $reg->no_sep, ['class' => 'form-control', 'required']) !!}
                                @else
                                <button type="button" class="btn btn-default btn-block btn-search-sep">Search</button>
                                @endif --}}
                              @else
                              <button type="button" class="btn btn-default btn-block btn-search-sep" style="margin-bottom: 5px;">Search</button>
                              {!! Form::text('no_sep', ( $prb != '' ) ? $prb->no_sep : $reg->no_sep, ['class' => 'form-control', 'required']) !!}
                                {{-- @if( $reg->no_sep != null )
                                {!! Form::text('no_sep', ( $prb != '' ) ? $prb->no_sep : $reg->no_sep, ['class' => 'form-control', 'required']) !!}
                                @else
                                <button type="button" class="btn btn-default btn-block btn-search-sep">Search</button>
                                @endif --}}
                              @endif
                              
                              <small class="text-danger">{{ $errors->first('no_sep') }}</small>
                          </div>
                      </div>
                      <div class="form-group{{ $errors->has('no_kartu') ? ' has-error' : '' }}">
                        {!! Form::label('no_kartu', 'NO KARTU', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::text('no_kartu', ( $prb != '' ) ? $prb->no_kartu : $reg->no_rujukan, ['class' => 'form-control', 'required']) !!}
                            <small class="text-danger">{{ $errors->first('no_kartu') }}</small>
                        </div>
                      </div>
                      <div class="form-group{{ $errors->has('alamat') ? ' has-error' : '' }}">
                        {!! Form::label('alamat', 'ALAMAT', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            <textarea class="form-control" name="alamat" row="10" required>{{ ( $prb != '' ) ? $prb->alamat : $pasien->alamat }}</textarea>
                            <small class="text-danger">{{ $errors->first('alamat') }}</small>
                        </div>
                      </div>
                      <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        {!! Form::label('email', 'Email', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::email('email', ( $prb != '' ) ? $prb->email : null , ['class' => 'form-control', 'placeholder' => 'email@gmail.com', 'required']) !!}
                            <small class="text-danger">{{ $errors->first('email') }}</small>
                        </div>
                      </div>
                      <div class="form-group{{ $errors->has('program_prb') ? ' has-error' : '' }}">
                        {!! Form::label('program_prb', 'PROGRAM PRB', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            <select class="form-control select2" name="program_prb" required>
                              <option selected disabled> Silahkan Pilih </option>
                              @foreach( $program_prb as $key_p => $val_p )
                                @if($prb != '')
                                  <option value="{{ $key_p }}" {{ ($prb->program_prb == $key_p ? 'selected' : '') }}>{{ $val_p }}</option>
                                @else
                                  <option value="{{ $key_p }}">{{ $val_p }}</option>
                                @endif
                              @endforeach
                            </select>
                            <small class="text-danger">{{ $errors->first('program_prb') }}</small>
                        </div>
                      </div>
                    </div>
                     <div class="col-md-6">
                      <div class="form-group{{ $errors->has('kode_dokter_dpjp') ? ' has-error' : '' }}">
                        {!! Form::label('kode_dokter_dpjp', 'KODE DOKTER DPJP', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            {{-- {!! Form::text('kode_dokter_dpjp', ( $prb != '' ) ? $prb->kode_dpjp : ((isset($kode_dokter_dpjp->kode_bpjs) ? $kode_dokter_dpjp->kode_bpjs : '')), ['class' => 'form-control', 'required']) !!} --}}
                            <select name="kode_dokter_dpjp" class="form-control select2">
                              {{-- <option value="0" {{ ($klasifikasi == '0') ? 'selected' : '' }}>SEMUA</option> --}}
                              @foreach ($dokter as $item)
                                <option value={{@$item->kode_bpjs}} {{ (@$item->kode_bpjs == @$kode_dokter_dpjp->kode_bpjs) ? 'selected' : '' }}>{{@$item->nama}}</option>
                              @endforeach
                            </select>
                            <small class="text-danger">{{ $errors->first('kode_dokter_dpjp') }}</small>
                        </div>
                      </div>
                      <div class="form-group{{ $errors->has('keterangan') ? ' has-error' : '' }}">
                        {!! Form::label('keterangan', 'KETERANGAN', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            <textarea class="form-control" name="keterangan" row="10" placeholder="Kecapekan kerja" required>{{ ( $prb != '' ) ? $prb->keterangan : null }}</textarea>
                            <small class="text-danger">{{ $errors->first('keterangan') }}</small>
                        </div>
                      </div>
                      <div class="form-group{{ $errors->has('saran') ? ' has-error' : '' }}">
                        {!! Form::label('saran', 'SARAN', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                          <textarea class="form-control" name="saran" row="10" placeholder="Pasien harus olahraga bersama setiap minggu dan cuti, edukasi agar jangan disuruh kerja terus, lama lama stress." required>{{ ( $prb != '' ) ? $prb->saran : null }}</textarea>
                            <small class="text-danger">{{ $errors->first('saran') }}</small>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <hr>
                      <div class="row">
                        <div class="col-sm-12 text-right" style="margin-bottom: 10px;">
                          @if( $prb != '' )
                          <a href="{{ url('bridgingsep/rujuk-balik/'.$prb->reg_id) }}" class="btn btn-primary">Buat Baru PRB</a>
                          @endif
                          <a href="javascript:void(0)" class="btn btn-default btn-add-row"><i class="fa fa-plus"></i> Tambah Baris</a>
                        </div>
                      </div>
                      <table class="table table-bordered table-obat">
                        <thead>
                          <tr>
                            <th class="text-center" width="20%">Obat</th>
                            <th class="text-center" width="20%">Signa 1</th>
                            <th class="text-center" width="20%">Signa 2</th>
                            <th class="text-center" width="20%">Jumlah</th>
                            <th class="text-center" width="10%">Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          @if( count($prb_detail) > 0 )
                          @foreach( $prb_detail as $val_p )
                          <tr>
                            <td>
                              {{-- <select class="form-control select2-ajax obat-id" name="obat_id[]" style="width: 100%" required>
                                <option selected disabled>Silahkan Pilih</option>
                              </select> --}}

                              <select name="obat_id[]" class="form-control select2" style="width:100% !important">
                                <option value="" disabled selected>Pilih Obat</option>
                                @foreach ($obat_prb as $item)
                                  <option value={{@$item->kode}} {{ (@$item->kode == @$val_p->kode_obat) ? 'selected' : '' }}>{{@$item->nama}}</option>
                                @endforeach
                              </select>
                            </td>
                            <td>
                              <input class="form-control" type="text" name="signa_1[]" required value="{{ $val_p->signa_1 }}">
                              {{-- <select class="form-control select2 obat-signa-1" name="signa_1[]" style="width: 100%" required>
                                <option selected disabled>Silahkan Pilih</option>
                                @foreach( $signa as $key_s => $val_s )
                                <option value="{{ $val_s->nama }}" {{ ($val_p->signa_1 == $val_s->nama ? 'selected' : '') }}>{{ $val_s->nama }}</option>
                                @endforeach
                              </select> --}}
                            </td>
                            <td>
                              <input class="form-control" type="text" name="signa_2[]" required value="{{ $val_p->signa_2 }}">
                              {{-- <select class="form-control select2 obat-signa-2" name="signa_2[]" style="width: 100%" required>
                                <option selected disabled>Silahkan Pilih</option>
                                @foreach( $signa as $key_t => $val_t )
                                <option value="{{ $val_t->nama }}" {{ ($val_p->signa_2 == $val_t->nama ? 'selected' : '') }}>{{ $val_t->nama }}</option>
                                @endforeach
                              </select> --}}
                            </td>
                            <td>
                              <input class="form-control obat-jumlah" type="text" name="jml[]" required onkeypress='return event.charCode >= 48 && event.charCode <= 57' value="{{ $val_p->jumlah }}">
                            </td>
                            <td class="text-center">
                              <a href="javascript:void(0)" class="btn btn-danger btn-delete-row"><i class="fa fa-trash-o"></i> Hapus</a>
                            </td>
                          </tr>
                          @endforeach
                          @else
                          <tr>
                            <td>
                              <select name="obat_id[]" class="form-control select2"  style="width: 100% !important;">
                                <option value="" disabled selected>Pilih Obat</option>
                                @foreach ($obat_prb as $item)
                                  <option value={{@$item->kode}} {{ (@$item->kode == @$val_p->kode_obat) ? 'selected' : '' }}>{{@$item->nama}}</option>
                                @endforeach
                              </select>
                            </td>
                            <td>
                              <input class="form-control obat-signa-1" type="text" name="signa_1[]" required value="">
                              {{-- <select class="form-control select2 obat-signa-1" name="signa_1[]" style="width: 100%" required>
                                <option selected disabled>Silahkan Pilih</option>
                              </select> --}}
                            </td>
                            <td>
                              {{-- <select class="form-control select2 obat-signa-2" name="signa_2[]" style="width: 100%" required>
                                <option selected disabled>Silahkan Pilih</option>
                              </select> --}}
                              <input class="form-control obat-signa-2"  type="number" name="signa_2[]" required value="">
                            </td>
                            <td>
                              <input class="form-control obat-jumlah" type="number" name="jml[]" required onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                            </td>
                            <td class="text-center">
                              <a href="javascript:void(0)" class="btn btn-danger btn-delete-row"><i class="fa fa-trash-o"></i> Hapus</a>
                            </td>
                          </tr>
                          @endif
                        </tbody>
                      </table>
                    </div>
                    <div class="col-sm-12 text-right">
                        <button class="btn btn-{{ ($prb != '' ? 'primary' : 'success') }}" type="submit">{{ ($prb != '') ? 'Update' : 'Simpan' }}</button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
<hr>
        <div class="box-body">
          <h2>Daftar PRB</h2>
            <div class='table-responsive'>
                <table class='table table-striped table-bordered table-hover table-condensed' id="data">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No SRB</th>
                            <th>No SEP</th>
                            <th>No Kartu</th>
                            <th>Program PRB</th>
                            <th>Keterangan</th>
                            <th>Saran</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach( $bpjs_prb as $key_b => $val_b )
                        <tr>
                          <td>{{ ($key_b+1) }}</td>
                          <td>{{ $val_b->no_srb }}</td>
                          <td>{{ $val_b->no_sep }}</td>
                          <td>{{ $val_b->no_kartu }}</td>
                          <td>{{ $val_b->program_prb }}</td>
                          <td>{{ $val_b->keterangan }}</td>
                          <td>{{ $val_b->saran }}</td>
                          <td class="text-center">
                            <a href="{{ url('bridgingsep/rujuk-balik/'.$val_b->reg_id.'/'.$val_b->id) }}" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                            <a href="{{ url('bridgingsep/cetak-rujuk-balik/'.$val_b->reg_id.'/'.$val_b->id) }}" target="__blank" class="btn btn-info"><i class="fa fa-print"></i></a>
                            <a href="javascript:void(0)" class="btn btn-danger btn-delete-prb" data-id="{{ $val_b->id }}"><i class="fa fa-trash-o"></i></a>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>

    <!-- Modal -->
  <div id="modalSearchSEP" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Cari SEP</h4>
        </div>
        <div class="modal-body" style="display: block">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group{{ $errors->has('sep_number') ? ' has-error' : '' }}">
                {!! Form::label('sep_number', 'SEP', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-7">
                    {!! Form::text('sep_number', null, ['class' => 'form-control', 'required']) !!}
                    <small class="text-danger">{{ $errors->first('sep_number') }}</small>
                </div>
                <div class="col-sm-2">
                  <button type="button" class="btn btn-default btn-search-sep-bpjs">Cari</button>
                </div>
              </div>
              <div id="response-sep"></div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary btn-pilih-sep" style="display: none;">Pilih</button>
        </div>
      </div>

    </div>
  </div>


@endsection

@section('script')
<script>

  $(document).ready(function() {

    var LIST_OBAT     = '{!! json_encode($obat_prb) !!}';
    var LIST_SIGNA1   = '{!! json_encode($signa) !!}';
    var LIST_SIGNA2   = '{!! json_encode($signa) !!}';

    $('.select2').select2();

    function initSelect2Ajax(){
      $('.obat-id').select2({
        placeholder: "Pilih No Rm...",
        ajax: {
            url: '/bridgingsep/rujuk-balik/ref/obat/prb',
            dataType: 'json',
            data: function (params) {
                return {
                    q: $.trim(params.term)
                };
            },
            processResults: function (data) {
                console.log(data)
                return {
                    results: data
                };
            },
            cache: true
        }
      });
    }
    
    $(document).on('click','.btn-add-row', function(){
      let table   = $('.table-obat');
      let row     = table.find('#master-row').html();
      table.append('<tr>' + row + '</tr>')

    })

    $(document).on('click','.btn-delete-prb',function(){
      let id = $(this).data('id');
      swal({
        title: "Yakin Akan Dihapus ?",
        text: "Ketika Dihapus, Data Tidak Bisa Dikembalikan!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          deletePRB(id);
        }
      });
    })

    $(document).on('click','.btn-search-sep',function(){
      $('input[name="sep_number"]').val('');
      $('#response-sep').html('');
      $('.btn-pilih-sep').hide();
      $('#modalSearchSEP').modal('show');
    })

    let no_sep_bpjs = '';
    let no_kartu_bpjs = '';
    $(document).on('click','.btn-search-sep-bpjs',function(){
        let sep_number  = $('input[name="sep_number"]').val();
        if( sep_number == '' ) {
          swal({
                title: "Error!",
                text: "SEP Number Wajib Diinput!",
                icon: "error",
                button: "Okay!",
              });
          return
        }
        $.ajax({
            type: "POST",
            url: "{{ url('/') }}/bridgingsep/rujuk-balik/cari-sep",
            dataType: "JSON",
            data : { 
                        _token: "{{ csrf_token() }}",
                        sep: sep_number
                    },
            success: function(res){
              $('#response-sep').html(res.html);
              if( res.status == "success" ) {
                $('.btn-pilih-sep').show();
                no_sep_bpjs     = res.data.no_sep;
                no_kartu_bpjs   = res.data.no_kartu;
              }else{
                $('.btn-pilih-sep').hide();
              }
            }
        });
    })

    $(document).on('click','.btn-pilih-sep',function(){
      $('input[name="no_sep"]').val(no_sep_bpjs);
      $('input[name="no_kartu"]').val(no_kartu_bpjs);
      $('#modalSearchSEP').modal('hide');
    });

    function deletePRB(id) {
        $.ajax({
            type: "DELETE",
            url: "{{ url('/') }}/bridgingsep/rujuk-balik/"+id,
            dataType: "JSON",
            data : { 
                        _token: "{{ csrf_token() }}" 
                    },
            success: function(res){
              if( res.status == "success" ){
                location.reload();
              }else{
                swal("Error", res.text, "error");
              }
            }
        });
    }

    function addNewObatLine() {
      $(document.body).on('click', '.btn-add-row', function(e) {
          e.preventDefault();

          var temp = `<tr>
                          <td> 
                            <select name="obat_id[]" class="form-control select2" style="width: 100% !important;"> 
                              <option value="" disabled selected>Pilih Obat</option>
                              @foreach ($obat_prb as $item)
                                <option value={{@$item->kode}} {{ (@$item->kode == @$val_p->kode_obat) ? 'selected' : '' }}>{{@$item->nama}}</option>
                              @endforeach
                            </select>
                          </td>
                            <td>
                              <input class="form-control obat-signa-1" type="text" name="signa_1[]" required value="">
                            </td>
                            <td>
                              <input class="form-control obat-signa-2" type="text" name="signa_2[]" required value="">
                            </td>
                            <td>
                              <input class="form-control obat-jumlah" type="text" name="jml[]" required onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                            </td>
                            <td class="text-center">
                              <a href="javascript:void(0)" class="btn btn-danger btn-delete-row"><i class="fa fa-trash-o"></i> Hapus</a>
                            </td>
                          </tr>`;

          $('.table-obat').append(temp);
          // initObat($('.table-obat tbody tr').last().find('select.obat-id'));
          initSigna1($('.table-obat tbody tr').last().find('select.obat-signa-1'));
          initSigna2($('.table-obat tbody tr').last().find('select.obat-signa-2'));
          $('.table-obat tbody tr').last().find('select.select2').select2();
          initSelect2Ajax();
      });
  }

    function removeObatLine() {
        $(document.body).on('click', '.btn-delete-row', function(e) {
            e.preventDefault();
            var line 	= $(this).closest('tr'); 
            line.remove();
        });
    }

    function initTableObat() {
      $('.table-obat tbody tr').each(function(i) {

          // var sel_a 	= $(this).find('.obat-id');
          // initObat(sel_a);

          var sel_b 	= $(this).find('.obat-signa-1');
          initSigna1(sel_b);

          var sel_d 	= $(this).find('.obat-signa-2');
          initSigna2(sel_d);

      });
   }

    function initObat(ele) {
      try {
        LIST_OBAT = JSON.parse(LIST_OBAT);
      }
      catch (err) {
        LIST_OBAT = LIST_OBAT;
      }
      
      LIST_OBAT.forEach(function(item, key) {
          $(ele).append(
              `<option value="${item.id}">
                  ${item.nama}
              </option>`
          );
      });
    }

    function initSigna1(ele) {
      try {
        LIST_SIGNA1 = JSON.parse(LIST_SIGNA1);
      }
      catch (err) {
        LIST_SIGNA1 = LIST_SIGNA1;
      }
      LIST_SIGNA1.forEach(function(item) {
          $(ele).append(
              `<option value="${item.nama}">
                  ${item.nama}
              </option>`
          );
      });
    }

    function initSigna2(ele) {
      try {
        LIST_SIGNA2 = JSON.parse(LIST_SIGNA2);
      }
      catch (err) {
        LIST_SIGNA2 = LIST_SIGNA2;
      }
      LIST_SIGNA2.forEach(function(item) {
          $(ele).append(
              `<option value="${item.nama}">
                  ${item.nama}
              </option>`
          );
      });
    }

    initTableObat();
    removeObatLine();
    addNewObatLine();
    initSelect2Ajax();
    
  })
</script>
@endsection