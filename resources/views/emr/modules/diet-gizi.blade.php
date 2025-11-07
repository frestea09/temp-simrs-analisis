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
<h1>EDUKASI DIET</h1>
@endsection

@section('content')
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">
    </h3>
  </div>
  <div class="box-body">
    <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">
    

    @include('emr.modules.addons.profile')
    <form method="POST" action="{{ url('emr-diet-gizi/diet/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
      <div class="row">
        <div class="col-md-12">
          @include('emr.modules.addons.tab-gizi')
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('cara_bayar', $reg->bayar) !!}
          {!! Form::hidden('unit', $unit) !!}
          <br>
          

          {{-- DIET --}}
          <div class="col-md-6">
            <h5><b>DIET</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:20px;"> 
              {{-- <tr>
                <td style="width:20%;">Kode</td>
                <td style="padding: 5px;">
                  {!! Form::text('kodeDiet', null, ['class' => 'form-control', 'id'=>'kode_diet']) !!}
                      <small class="text-danger">{{ $errors->first('kode_diet') }}</small>
                </td>
              </tr> --}}
              <tr>
                <td>Diet</td>
                <td style="padding: 5px;">
                  {{-- {!! Form::text('kodeDiet', null, ['class' => 'form-control', 'id'=>'kode_diet']) !!}
                      <small class="text-danger">{{ $errors->first('kode_diet') }}</small> --}}
                    <input name="namaDiet" style="display:inline-block; resize: vertical;" placeholder="Diet Rendah Lemak dan Rendah Kalori" class="form-control" required>

                </td>
              </tr>
              <tr>
                <td>Jenis Diet</td>
                <td>
                  <select name="jenisDiet" class="form-control select2" id="" style="width: 100%;">
                    <option value="">-- Pilih --</option>
                    <option value="MC">MC</option>
                    <option value="Blenderice">Blenderice</option>
                    <option value="Sippy">Sippy</option>
                    <option value="TD I">TD I</option>
                    <option value="TD II">TD II</option>
                    <option value="TD III">TD III</option>
                    <option value="TD IV">TD IV</option>
                    <option value="Lainnya">Lainnya</option>
                  </select>
                </td>
              </tr>
              <tr>
                  <td style="padding: 5px;" colspan="2">
                    <textarea rows="15" name="catatan" style="display:inline-block" placeholder="[Masukkan Catatan Dokter]" class="form-control"></textarea></td>
                  </td>
              </tr>
            </table>       
            <div class="col-md-12 text-right">
                <button class="btn btn-success">Simpan</button>
            </div>
          </div>

          {{-- Alergi --}}
          <div class="col-md-6">
            <div class="box box-solid box-warning">
              <div class="box-header">
                <h5><b>Catatan Medis</b></h5>
              </div>
              <div class="box-body table-responsive" style="max-height: 400px">
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box bordered"
                style="font-size:12px;">
                @if (count($riwayat) == 0)
                <tr>
                  <td><i>Belum ada catatan</i></td>
                </tr>  
                @endif
                @foreach ($riwayat as $item)
                <tr>
                  <td> 
                    <b>{{$item->nama}}</b><br/>
                    <b>Jenis</b> : {{@$item->jenis_diet}}<br/>
                    <b>Catatan</b> : {{$item->catatan_dokter}}
                    <span class="pull-right">{{date('d-m-Y, H:i:s',strtotime($item->created_at))}}</span>
                  </td>
                </tr>
                @endforeach
              </table>
              </div>
              </div> 
          </div>
        </div>   
      </div>
    </form>
    <br/>
    <br/>

    <div class="modal fade" id="kodeDiet" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id=""></h4>
          </div>
          <div class="modal-body">
            <div class='table-responsive'>
              <table id='dataKode' class='table table-striped table-bordered table-hover table-condensed'>
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
    {{-- <div class="modal fade" id="kode" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id=""></h4>
          </div>
          <div class="modal-body">
            <div class='table-responsive'>
              <table id='dataKode' class='table table-striped table-bordered table-hover table-condensed'>
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Diet</th>
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
    </div> --}}
  </div>

  @endsection

  @section('script')
  <script type="text/javascript">
  // $("input[name='kodeDiet']").on('focus', function () {
  //       $("#dataKode").DataTable().destroy()
  //       $("#kodeDiet").modal('show');
  //       $('#dataKode').DataTable({
  //           "language": {
  //               "url": "/json/pasien.datatable-language.json",
  //           },

  //           pageLength: 10,
  //           autoWidth: false,
  //           processing: true,
  //           serverSide: true,
  //           ordering: false,
  //           ajax: '/sep/getdatadiet',
  //           columns: [
  //               // {data: 'rownum', orderable: false, searchable: false},
  //               {data: 'id'},
  //               {data: 'kode'},
  //               // {data: 'nama'},
  //               {data: 'add', searchable: false}
  //           ]
  //       });
  //     });
  $("input[name='kodeDiet']").on('focus', function () {
        $("#dataKode").DataTable().destroy()
        $("#kodeDiet").modal('show');
        $('#dataKode').DataTable({
            "language": {
                "url": "/json/pasien.datatable-language.json",
            },

            pageLength: 10,
            autoWidth: false,
            processing: true,
            serverSide: true,
            ordering: false,
            ajax: '/sep/getdatadiet',
            columns: [
                // {data: 'rownum', orderable: false, searchable: false},
                {data: 'id'},
                {data: 'kode'},
                {data: 'nama'},
                {data: 'add', searchable: false}
            ]
        });
      });

      // $(document).on('click', '.addKode', function (e) {
      //   document.getElementById("kode_diet").value = $(this).attr('data-kode');
      //   $('#kodeDiet').modal('hide');
      // });
      $(document).on('click', '.addKode', function (e) {
        document.getElementById("kode_diet").value = $(this).attr('data-kode');
        $('#kodeDiet').modal('hide');
      });
    // $(".skin-red").addClass( "sidebar-collapse" );
    //     $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    //       var target = $(e.target).attr("href") // activated tab
          // alert(target);
        // });
        $('.select2').select2();
         
  </script>
  @endsection