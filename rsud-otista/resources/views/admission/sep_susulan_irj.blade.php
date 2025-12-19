@extends('master')
@section('header')
  <h1>Admission </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          SEP Susulan Rawat Jalan &nbsp;
        </h3>
      </div>
      <div class="box-body">
        <div class='table-responsive'>
          <div class="row">
            <div class="col-md-6">
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button">No RM/NAMA</button>
                </span>
                {!! Form::text('keyword', null, [
                  'class' => 'form-control', 
                  'autocomplete' => 'off', 
                  'placeholder' => 'NO RM/NAMA',
                  'required',
                  ]) !!}
              </div>
              </div>
              <div class="form-group">
                <div class="col-md-6">
                    <button class="btn btn-primary btn-flat searchBtn">
                        <i class="fa fa-search"></i> Cari
                    </button>
                </div>
              </div>
            </div>
            <br/>
          </div>
          {{-- {!! Form::open(['method' => 'POST', 'url' => 'admission/sep-susulan/rawat-jalan', 'class'=>'form-hosizontal']) !!}
            <div class="row">
              <div class="col-md-3">
              <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
                </span>
                {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required', 'onchange'=>'this.form.submit()', 'autocomplete'=>'off']) !!}
              </div>
              </div>
            </div>
          {!! Form::close() !!} --}}
          <table class='table table-striped table-bordered table-hover table-condensed' id='datanew'>
            <thead>
              <tr>
                <th>No</th>
                <th>No. RM</th>
                <th>Nama</th>
                <th>Cara Bayar</th>
                <th>DPJP</th>
                <th>Klinik Tujuan</th>
                <th>Tgl Masuk</th>
                <th>Proses</th>
              </tr>
            </thead>
            {{-- <tbody>
              @foreach ($reg as $key => $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ baca_norm($d->pasien_id) }}</td>
                  <td>{{ baca_pasien($d->pasien_id) }}</td>
                  <td>{{ baca_carabayar($d->bayar) }} {{ (!empty($d->tipe_jkn)) ? ' - '.$d->tipe_jkn : '' }}</td>
                  <td>{{ baca_dokter($d->dokter_id) }}</td>
                  <td>{{ baca_poli($d->poli_id) }}</td>
                  <td>{{ $d->updated_at }}</td>
                  <td>
                    <a href="{{ url('form-sep-susulan/'.$d->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-refresh"></i></a>
                  </td>
                </tr>
              @endforeach --}}
            </tbody>
          </table>
        </div>
      @if (!empty(session('no_sep')))
        <script type="text/javascript">
          window.open("{{ url('cetak-sep/'.session('no_sep')) }}","Cetak SEP", width=800,height=325)
        </script>
      @endif
      </div>
    </div>
@endsection
@section('script')
  <script type="text/javascript">
    $('.select2').select2()
    $(document).ready(function() {
      var datanew = $('#datanew').DataTable({
        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: {
          url: '/admission/sep-susulan/data-rawat-jalan',
          data:function(d){
            d.keyword = $('input[name="keyword"]').val();
          }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            {data: 'no_rm', orderable: false},
            {data: 'nama', orderable: false},
            {data: 'cara_bayar', orderable: false},
            {data: 'dokter', orderable: false},
            {data: 'poli', orderable: false},
            {data: 'tanggal', orderable: false},
            {data: 'aksi', orderable: false}
        ]
      });

      $(".searchBtn").click(function (){
        datanew.draw();
      });
 
    });

  </script>
@endsection
