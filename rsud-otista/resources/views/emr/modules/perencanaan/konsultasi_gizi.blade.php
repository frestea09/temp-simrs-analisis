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
<h1>Order Diet</h1>
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
    <form method="POST" action="{{ url('emr-soap/perencanaan/konsultasi-gizi/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
      <div class="row">
        <div class="col-md-12">
          @include('emr.modules.addons.tabs')
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('cara_bayar', $reg->bayar) !!}
          {!! Form::hidden('unit', $unit) !!}
          <br>
          <div class="col-md-6">
            <h5><b>Order Diet</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;"> 
              <tr>
                <td>Tanggal Penyajian</td>
                <td>
                  <input type="date" name="form[tanggal_penyajian]" class="form-control">
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;">Waktu Makan</td>
                <td>
                    <select name="form[waktu_makan]" class="select2" style="width: 100%;">
                        <option value="">-- Pilih Salah Satu --</option>
                        <option value="Pagi">Pagi</option>
                        <option value="Siang">Siang</option>
                        <option value="Malam">Malam</option>
                    </select>
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;">Bentuk Makanan</td>
                <td>
                    <select name="form[bentuk_makanan]" class="select2" style="width: 100%;">
                        <option value="">-- Pilih Salah Satu --</option>
                        <option value="MC">MC</option>
                        <option value="BR">BR</option>
                        <option value="Sippy">Sippy</option>
                        <option value="TD I (Makanan Saring)">TD I (Makanan Saring)</option>
                        <option value="TD II (Makanan Lunak (Bubur))">TD II (Makanan Lunak (Bubur))</option>
                        <option value="TD III (Makanan Lunak (Tim))">TD III (Makanan Lunak (Tim))</option>
                        <option value="TD IV (Makanan Biasa)">TD IV (Makanan Biasa)</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                    <input type="text" placeholder="isi jika lainnya" name="form[bentuk_makanan_lainnya]" class="form-control">
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;">Jenis Diet</td>
                  <td>
                    <select name="form[jenis_diet]" class="select2" style="width: 100%;">
                        <option value="">-- Pilih Salah Satu --</option>
                        <option value="DL">DL</option>
                        <option value="DM">DM</option>
                        <option value="RL">RL</option>
                        <option value="RG">RG</option>
                        <option value="RS">RS</option>
                        <option value="DH">DH</option>
                        <option value="R.Pur">R.Pur</option>
                        <option value="TKTP">TKTP</option>
                        <option value="DJ">DJ</option>
                        <option value="R.Prot">R.Prot</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                    <input type="text" placeholder="isi jika lainnya" name="form[jenis_diet_lainnya]" class="form-control">
                </td>
              </tr>
            </table>
          </div>
          {{-- Alergi --}}
          <div class="col-md-6">
            <div class="box box-solid box-warning">
              <div class="box-header">
                <h5><b>Riwayat</b></h5>
              </div>
              <div class="box-body table-responsive" style="max-height: 400px">
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box bordered"
                style="font-size:12px;">
                @if (count($riwayats) == 0)
                <tr>
                  <td><i>Belum ada riwayat</i></td>
                </tr>  
                @endif
                @foreach ($riwayats as $item)
                  <tr>
                    <td> 
                      <b>Tangal Penyajian	 :</b> {{@json_decode(@$item->keterangan, true)['tanggal_penyajian']}}<br/>
                      <b>Waktu Makan  :</b> {{@json_decode(@$item->keterangan, true)['waktu_makan']}}<br/>
                      <b>Bentuk Makanan	 :</b> {{@json_decode(@$item->keterangan, true)['bentuk_makanan']}}<br/>
                      <b>Bentuk Makanan	Lainnya :</b> {{@json_decode(@$item->keterangan, true)['bentuk_makanan_lainnya']}}<br/>
                      <b>Jenis Diet	 :</b> {{@json_decode(@$item->keterangan, true)['jenis_diet']}}<br/>
                      <b>Jenis Diet	Lainnya :</b> {{@json_decode(@$item->keterangan, true)['jenis_diet_lainnya']}}<br/>
                      {{date('d-m-Y, H:i:s',strtotime($item->created_at))}}
                    
                      <span class="pull-right">
                        <a onclick="return confirm('Yakin akan menghapus data?')" href="{{url('emr-soap-delete/'. $unit . '/' .$reg->id.'/'.$item->id)}}" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash text-danger"></i></a>&nbsp;&nbsp;
                      </span>
                    </td>
                  </tr>
                @endforeach
              </table>
              </div>
              </div> 
          </div>
          
          <br /><br />
        </div>
      </div>
      
      <div class="col-md-12 text-right">
        <button class="btn btn-success">Simpan</button>
      </div>
    </form>
    <br/>
    <br/>
    {{-- <div class="col-md-12 text-right">
      <table class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
        <thead>
          <tr>
            <th>No</th>
            <th>Kode(ICD 9)</th>
            <th>Deskripsi</th>
            <th>Diagnosa</th>
            <th>Tanggal</th>
          </tr>
        </thead>
         <tbody>
          @foreach ($riwayat as $key=>$item)
              <tr>
                <td>{{$key+1}}</td>
                <td>{{$item->icd9}}</td>
                <td>{{baca_icd9($item->icd9)}}</td>
                <td>{{$item->diagnosis}}</td>
                <td>{{date('d-m-Y, H:i:s',strtotime($item->created_at))}}</td>
              </tr>
          @endforeach
         </tbody>
      </table>
    </div> --}}
    
  </div>

  @endsection

  @section('script')

  <script type="text/javascript">
  //ICD 10
  $('.select2').select2();
  $("input[name='diagnosa_awal']").on('focus', function () {
        $("#dataICD10").DataTable().destroy()
        $("#ICD10").modal('show');
        $('#dataICD10').DataTable({
            "language": {
                "url": "/json/pasien.datatable-language.json",
            },

            pageLength: 10,
            autoWidth: false,
            processing: true,
            serverSide: true,
            ordering: false,
            ajax: '/sep/geticd9',
            columns: [
                // {data: 'rownum', orderable: false, searchable: false},
                {data: 'id'},
                {data: 'nomor'},
                {data: 'nama'},
                {data: 'add', searchable: false}
            ]
        });
      });

      $(document).on('click', '.addICD', function (e) {
        document.getElementById("diagnosa_awal").value = $(this).attr('data-nomor');
        $('#ICD10').modal('hide');
      });
    $(".skin-red").addClass( "sidebar-collapse" );
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
          var target = $(e.target).attr("href") // activated tab
          // alert(target);
        });
        $("#date_tanpa_tanggal").datepicker( {
            format: "mm-yyyy",
            viewMode: "months", 
            minViewMode: "months"
        });
        $("#date_dengan_tanggal").attr('required', true);  
         
  </script>
  @endsection