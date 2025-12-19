@extends('master')
@section('header')
  <h1>Logistik Non Medik - Penerimaan</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Daftar Penerimaan
      </h3>
    </div>
    <div class="box-body">
        {!! Form::open(['method' => 'POST', 'url' => 'logistiknonmedik/nonmedikpenerimaan', 'class'=>'form-hosizontal']) !!}
        <div class="row">
          <div class="col-md-6">
            <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
                </span>
                {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
                <small class="text-danger">{{ $errors->first('tga') }}</small>
            </div>
          </div>

          <div class="col-md-6">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">Sampai Tanggal</button>
              </span>
                {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required', 'onchange'=>'this.form.submit()']) !!}
            </div>
          </div>
          </div>
        {!! Form::close() !!}
        <hr>

        <div class='table-responsive col-md-12'>
          <table class='table table-striped table-bordered table-hover table-condensed tabeldata'>
            <thead>
              <tr>
                <th>No</th>
                <th>No.PO </th>
                <th>Supplier</th>
                <th>Tanggal</th>
                <th>Petugas</th>
                <th>Proses</th>
              </tr>
            </thead>
            <tbody>
                @if (isset($data))
                    @foreach ($data as $d)
                        @php
                            $awal = new DateTime($d->tanggal);
                            $today = new DateTime();
                            $noPO = \App\LogistikNonMedik\LogistikNonMedikNoPo::where('no_po',$d->no_po)->first();
                            $tempo = $today->diff($awal)->format("%a");
                            if(!empty($noPO)){
                                $id = $noPO->id;
                            } else {
                                $id = $d->no_po;
                            }
                        @endphp
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $d->no_po }}</td>
                            <td>{{ $d->supplier }}</td>
                            <td>{{ $d->tanggal }}</td>
                            <td>{{ \App\User::where('id', $d->user)->first()->name }}</td>
                            <td>
                                <a href="{{ url('logistiknonmedik/nonmedikpenerimaan/add-penerimaan/'.$id) }}" class="btn btn-primary btn-flat btn-sm">PROSES</a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
          </table>
        </div>
    </div>
  </div>
@endsection
@section('script')
  <script type="text/javascript">
    function tutup(){
      $('#Modal').modal('hide');
      $('#form')[0].reset();
      table.ajax.reload()
    }
    
    $('.select2').select2()
    function tambah(){
        $('#Modal').modal({
          backdrop: 'static',
          keyboard : false,
        })
        $('.modal-title').text('Tambah Po')
        $('input[name="id"]').val('')
        $('input[name="_method"]').val('POST')
        $('#form')[0].reset();
      }

      $('.uang').maskNumber({
      thousands: '.',
      integer: true,
    });

    function ribuan(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
    }

    function setSatuan() {
      var masterbarang_id = $('select[name="masterbarang_id"]').val()
      $.ajax({
        url: '/cari-barang/'+masterbarang_id,
        type: 'GET',
        dataType: 'json',
      })
      .done(function(json) {
        $('input[name="jumlah"]').focus()
      });
    }

    function hapus(id){
      $.ajax({
        url: '/logistiknonmedik/logistiknonmedikpo/'+id,
        type: 'POST',
        dataType: 'json',
        data: {
          '_method': 'DELETE',
          '_token': $('input[name="_token"]').val()
        },
      })
      .done(function(json) {
        if (json.sukses == true) {
          table1.ajax.reload()
        }
      });
    }

    function save(){
        var data = $('#form').serialize()
        var id = $('input[name="id"]').val()

        if(id == ''){
            var url = '{{ route('logistiknonmedikpo.store') }}'
        } else {
            var url = '/logistiknonmedik/satuan-barang/'+id
        }

        $.post( url, data, function(resp){
          if (resp.sukses == true) {
            table1.ajax.reload()
          }
        })
    }
  </script>
@endsection
