@extends('master')

@section('header')
  <h1>Master Jurnal Memorial</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          @if (isset($is_edit) && $is_edit == 1) Ubah Jurnal Memorial {{$data['code']}} @else Tambah Jurnal Memorial @endif  &nbsp;

        </h3>
      </div>
      <div class="box-body">
          @if (isset($is_edit) && $is_edit == 1)
            {!! Form::model($data, ['route' => ['journal_memorial.update', $data['id']], 'class' => 'form-horizontal', 'method' => 'PUT']) !!}
          @else
            {!! Form::open(['method' => 'POST', 'route' => 'journal_memorial.store', 'class' => 'form-horizontal']) !!}
          @endif
            <div class="col-sm-6">
                <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
                    {!! Form::label('code', 'Kode Jurnal', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-8">
                        @if (isset($is_edit) && $is_edit == 1)
                        {!! Form::label('code', 'Kode Jurnal', ['class' => 'col-sm-4 control-label']) !!}
                        @else
                        {!! Form::text('code', null, ['class' => 'form-control', 'required' => 'required']) !!}
                        @endif
                        <small class="text-danger">{{ $errors->first('code') }}</small>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('tanggal') ? ' has-error' : '' }}">
                    {!! Form::label('tanggal', 'Tanggal Transaksi', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-8">
                        {!! Form::text('tanggal', date('d-m-Y'), ['class' => 'form-control datepicker']) !!}
                        <small class="text-danger">{{ $errors->first('tanggal') }}</small>
                    </div>
                </div>
                {{-- <div class="form-group{{ $errors->has('contact_type') ? ' has-error' : '' }}">
                    {!! Form::label('contact_type', 'Contact Type', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-8" style="padding-top: 5px;">
                        {!! Form::radio('contact_type', 'tanpa_contact', true, ['class' => 'contact_type']) !!} Tanpa Contact &nbsp;
                        {!! Form::radio('contact_type', 'customer', false, ['class' => 'contact_type']) !!} Customer &nbsp;
                        {!! Form::radio('contact_type', 'supplier', false, ['class' => 'contact_type']) !!} Supplier 
                        <small class="text-danger">{{ $errors->first('contact_type') }}</small>
                    </div>
                </div>
                <div hidden id="supplier" class="form-group{{ $errors->has('id_supplier') ? ' has-error' : '' }}">
                    {!! Form::label('id_supplier', 'Supplier', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-8">
                        {!! Form::select('id_supplier', $supplier, null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                        <small class="text-danger">{{ $errors->first('id_supplier') }}</small>
                    </div>
                </div>
                <div hidden id="customer" class="form-group{{ $errors->has('id_customer') ? ' has-error' : '' }}">
                    {!! Form::label('id_customer', 'Customer', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-8">
                        {!! Form::select('id_customer', $customer, null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                        <small class="text-danger">{{ $errors->first('id_customer') }}</small>
                    </div>
                </div> --}}
                <div class="form-group{{ $errors->has('keterangan') ? ' has-error' : '' }}">
                    {!! Form::label('keterangan', 'Keterangan', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-8">
                        {!! Form::text('keterangan', null, ['class' => 'form-control']) !!}
                        <small class="text-danger">{{ $errors->first('keterangan') }}</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
              <hr>
                <div class="row box-repeat">
                  <div class="boxrep col-sm-12">
                    <div class="col-sm-1 text-right" style="text-align: -webkit-right;">
                        <a href="javascript:;" onclick="removeBox(this)" class="remove-box btn btn-danger">
                            <i class="fa fa-close"></i>
                        </a>
                    </div>
                    <div class="col-sm-5">
                      <div class="form-group{{ $errors->has('id_akun_coa') ? ' has-error' : '' }}">
                          {!! Form::label('id_akun_coa', 'Akun COA', ['class' => 'col-sm-4 control-label']) !!}
                          <div class="col-sm-8">
                              {!! Form::select('journal_detail[0][id_akun_coa]', $akun_coa, null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                              <small class="text-danger">{{ $errors->first('id_akun_coa') }}</small>
                          </div>
                      </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group{{ $errors->has('debit') ? ' has-error' : '' }}">
                            {!! Form::label('debit', 'Debit', ['class' => 'col-sm-4 control-label']) !!}
                            <div class="col-sm-8">
                                {!! Form::text('journal_detail[0][debit]', 0, ['class' => 'form-control']) !!}
                                <small class="text-danger">{{ $errors->first('debit') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group{{ $errors->has('credit') ? ' has-error' : '' }}">
                            {!! Form::label('credit', 'Credit', ['class' => 'col-sm-4 control-label']) !!}
                            <div class="col-sm-8">
                                {!! Form::text('journal_detail[0][credit]', 0, ['class' => 'form-control']) !!}
                                <small class="text-danger">{{ $errors->first('credit') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-1">
                    </div>
                    <div class="col-sm-5">
                      <div class="form-group{{ $errors->has('keterangan') ? ' has-error' : '' }}">
                          {!! Form::label('keterangan', 'Keterangan', ['class' => 'col-sm-4 control-label']) !!}
                          <div class="col-sm-8">
                              {!! Form::text('journal_detail[0][keterangan]', null, ['class' => 'form-control']) !!}
                              <small class="text-danger">{{ $errors->first('keterangan') }}</small>
                          </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      {{-- <div class="form-group{{ $errors->has('id_kas_dan_bank') ? ' has-error' : '' }}">
                          {!! Form::label('id_kas_dan_bank', 'Kas dan Bank', ['class' => 'col-sm-4 control-label']) !!}
                          <div class="col-sm-8">
                              {!! Form::select('journal_detail[0][id_kas_dan_bank]', $kas_bank, null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                              <small class="text-danger">{{ $errors->first('id_kas_dan_bank') }}</small>
                          </div>
                      </div> --}}
                    </div>
                  </div>
                  <br>
                  <div class="btn-rmv form-action col-md-12 text-right">
                    <a href="javascript:;" class="btn btn-success add">
                        <i class="fa fa-plus"></i> Add New Input
                    </a>
                </div>
                </div>
              </div>
              <div class="col-sm-12">
                <hr>
                <div class="btn-group pull-right">
                    <a href="{{ route('journal_memorial.index') }}" class="btn btn-warning btn-flat">Batal</a>
                    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
                </div>
            </div>
            {!! Form::close() !!}
      </div>
    </div>
@stop

@section('script')
    <script>
      $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()
        $('.contact_type').change(function () {
          $('#supplier').hide()
          $('#customer').hide()
          if ($(this).val() == 'supplier') {
            $('#supplier').show()
          }
          if ($(this).val() == 'customer') {
            $('#customer').show()
          }
        })
        var index = 1;
        $('.add').click(function() {
            nomer = index++
            $('.btn-rmv').before(`
                <div class="boxrep col-sm-12">
                    <div class="col-sm-1 text-right" style="text-align: -webkit-right;">
                        <a href="javascript:;" onclick="removeBox(this)" class="remove-box btn btn-danger">
                            <i class="fa fa-close"></i>
                        </a>
                    </div>
                    <div class="col-sm-5">
                      <div class="form-group{{ $errors->has('id_akun_coa') ? ' has-error' : '' }}">
                          {!! Form::label('id_akun_coa', 'Akun COA', ['class' => 'col-sm-4 control-label']) !!}
                          <div class="col-sm-8">
                              {!! Form::select('journal_detail[`+nomer+`][id_akun_coa]', $akun_coa, null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                              <small class="text-danger">{{ $errors->first('id_akun_coa') }}</small>
                          </div>
                      </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group{{ $errors->has('debit') ? ' has-error' : '' }}">
                            {!! Form::label('debit', 'Debit', ['class' => 'col-sm-4 control-label']) !!}
                            <div class="col-sm-8">
                                {!! Form::text('journal_detail[`+nomer+`][debit]', 0, ['class' => 'form-control']) !!}
                                <small class="text-danger">{{ $errors->first('debit') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group{{ $errors->has('credit') ? ' has-error' : '' }}">
                            {!! Form::label('credit', 'Credit', ['class' => 'col-sm-4 control-label']) !!}
                            <div class="col-sm-8">
                                {!! Form::text('journal_detail[`+nomer+`][credit]', 0, ['class' => 'form-control']) !!}
                                <small class="text-danger">{{ $errors->first('credit') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-1">
                    </div>
                    <div class="col-sm-5">
                      <div class="form-group{{ $errors->has('keterangan') ? ' has-error' : '' }}">
                          {!! Form::label('keterangan', 'Keterangan', ['class' => 'col-sm-4 control-label']) !!}
                          <div class="col-sm-8">
                              {!! Form::text('journal_detail[`+nomer+`][keterangan]', null, ['class' => 'form-control']) !!}
                              <small class="text-danger">{{ $errors->first('keterangan') }}</small>
                          </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      {{-- <div class="form-group{{ $errors->has('id_kas_dan_bank') ? ' has-error' : '' }}">
                          {!! Form::label('id_kas_dan_bank', 'Kas dan Bank', ['class' => 'col-sm-4 control-label']) !!}
                          <div class="col-sm-8">
                              {!! Form::select('journal_detail[`+nomer+`][id_kas_dan_bank]', $kas_bank, null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                              <small class="text-danger">{{ $errors->first('id_kas_dan_bank') }}</small>
                          </div>
                      </div> --}}
                    </div>
                  </div>`);
            $('.select2').select2()
            $('.contact_type').change(function () {
            $('#supplier').hide()
            $('#customer').hide()
            if ($(this).val() == 'supplier') {
                $('#supplier').show()
            }
            if ($(this).val() == 'customer') {
                $('#customer').show()
            }
            })
        });
      })
      function removeBox(params) {
          $(params).parent().parent().remove()
      }
    </script>
@endsection