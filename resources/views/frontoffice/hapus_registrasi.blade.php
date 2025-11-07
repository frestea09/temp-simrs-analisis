@extends('master')
@section('header')
  <h1>Data Regstrasi</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {{-- {!! Form::open(['method' => 'POST', 'url' => 'frontoffice/supervisor/registrasibytanggal', 'class' => 'form-horizontal']) !!} --}}
          <div class="row">
            {{-- <div class="col-md-6">
              {!! Form::label('poli_id', 'Poli', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-8">
                      <select name="poli_id" class="form-control select2">
                          <option value="" selected>[Semua Poli]</option>
                          @foreach ($poli as $item)
                              <option value="{{ $item->id }}">{{ $item->nama }}</option>
                          @endforeach
                      </select>
                  </div>
                </div> --}}
    
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
             
              {{-- <br/> --}}
              {{-- <div class="form-group{{ $errors->has('tanggal') ? ' has-error' : '' }}">
                  {!! Form::label('tanggal', 'Tanggal', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      {!! Form::text('tanggal', (!empty(Request::segment(4))) ? Request::segment(4) : null, ['class' => 'form-control datepicker', 'autocomplete'=>'off','onchange'=>'this.form.submit()']) !!}
                      <small class="text-danger">{{ $errors->first('tanggal') }}</small>
                  </div>
              </div> --}}
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
      {{-- {!! Form::close() !!} --}}
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' id='datanew'>
          <thead>
            <tr>
              <th>No</th>
              <th>No. RM</th>
              <th>Nama</th>
              <th>Poli</th>
              <th>Alamat</th>
              <th>Cara Bayar</th>
              <th>Tanggal Registrasi</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            {{-- @foreach ($registrasi as $key => $d)
              @if (!empty($d->pasien_id))
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ !empty(@$d->pasien_id) ? @$d->pasien->no_rm : '' }}</td>
                  <td>{{ !empty(@$d->pasien_id) ? @$d->pasien->nama : '' }}</td>
                  <td>{{ !empty(@$d->poli_id) ? @$d->poli->nama : '' }}</td>
                  <td>{{ !empty(@$d->pasien_id) ? @$d->pasien->alamat : '' }}</td>
                  <td>{{ !empty(@$d->pasien_id) ? @$d->bayars->carabayar: '' }} {{ !empty(@$d->tipe_jkn) ? ' - '.@$d->tipe_jkn : '' }}</td>
                  <td>{{ @$d->created_at->format('d-m-Y H:i:s') }}</td>
                  <td>
                    @if (@$d->lunas != 'N' )
                         LUNAS
                    @else
                         BELUM LUNAS
                    @endif
                  </td>
                  <td>
                    @if (@$d->lunas == 'N' )
                      
                      @if ( json_decode(Auth::user()->is_edit,true)['hapus'] == 1)
                        @if (count(@$d->folio) == 0)
                          <a href="{{ url('frontoffice/supervisor/soft-delete-registrasi/'.@$d->id) }}" onclick="return confirm('Yakin pasien: {{ @$d->pasien->nama }} akan di hapus?')" class="btn btn-danger btn-flat btn-sm"> <i class="fa fa-trash-o"></i> </a>  
                        @else
                          <small><i>Sudah Ada Billing</i></small>
                        @endif
                        
                      @else
                      @endif
                     @else
                     <i class="fa fa-remove"></i>
                     @endif
                  </td>
                </tr>
              @endif
              
            @endforeach --}}
          </tbody>
        </table>
      </div>

    </div>
    <div class="box-footer">
    </div>
  </div>


@endsection

@section('script')
  <script>
    $('.select2').select2()
    $(document).ready(function() {
      var datanew = $('#datanew').DataTable({
        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: {
          url: '/frontoffice/supervisor/data-hapusregistrasi',
          data:function(d){
            d.keyword = $('input[name="keyword"]').val();
          }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            {data: 'no_rm', orderable: false},
            {data: 'nama', orderable: false},
            // {data: 'dokter_umum', orderable: false},
            {data: 'poli', orderable: false},
            {data: 'alamat', orderable: false},
            {data: 'cara_bayar', orderable: false},
            {data: 'tanggal', orderable: false},
            {data: 'status', orderable: false},
            {data: 'aksi', orderable: false},
        ]
      });

      $(".searchBtn").click(function (){
        datanew.draw();
      });
    });
  </script>
@endsection
