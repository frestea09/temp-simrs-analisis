<div class="row">
  <div class="col-md-3">

    <div class="input-group">
      <span class="input-group-btn">
        <button class="btn btn-default" type="button">Tanggal</button>
      </span>
      {!! Form::text('tglReg', null, [
        'class' => 'form-control datepicker tglReg',
        ]) !!}
    </div>
  </div>
  <div class="col-md-3">

    <div class="input-group">
      <span class="input-group-btn">
        <button class="btn btn-default" type="button">Sampai</button>
      </span>
      {!! Form::text('tglReg2', null, [
        'class' => 'form-control datepicker tglReg2',
        ]) !!}
    </div>
  </div>
  <div class="col-md-6">
    <div class="input-group">
      <span class="input-group-btn">
        <button class="btn btn-default" type="button">Poli</button>
      </span>
      <select name="poli_id" id="" class="form-control select2 selectPoli" style="width: 100%;">
        {{-- <option value="">-- Semua --</option> --}}
        @foreach($polis as $id => $nama)
          <option value="{{ $id }}" {{$id == 42 ? 'selected' :''}}>{{ $nama }}</option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="col-md-6">
      <br/>
      <div class="input-group">
        <span class="input-group-btn">
          <button class="btn btn-default" type="button">Status Pembayaran</button>
        </span>
        <select name="status_bayar" class="form-control select2" style="width: 100%;">
          <option value="">-- Semua --</option>
          <option value="lunas">Sudah Dibayar</option>
          <option value="belum">Belum Dibayar</option>
        </select>
      </div>
    </div>
</div>
<br>
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
    <div class="col-md-6">
      <div class="form-group">
          <button class="btn btn-primary searchBtn">
              <i class="fa fa-search"></i> Cari
          </button>
      </div>
    </div>
    
    

    
    
</div>

{{-- {!! Form::close() !!} --}}
<hr>

<div class='table-responsive'>
  <table class='table table-striped table-bordered table-hover table-condensed' id='tableKasir'>
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Pasien</th>
        <th>No. RM</th>
        <th>Dokter</th>
        <th>Klinik</th>
        <th>Cara Bayar</th>
        <th>Tanggal</th>
        <th>Tagihan</th>
        <th>Keterangan</th>
        {{-- <th>Total Tagihan</th> --}}
        {{-- <th>Status</th> --}}
        <th>Rincian</th>
        <th>Bayar</th>
        <th>Billing</th>
        <th>Piutang</th>
        <th>Cetak Rajal</th>
        <th>Kwitansi</th>
        <th>Kwitansi Tindakan</th>
        <th>Kwitansi Penunjang</th>
      </tr>
    </thead>
    <tbody>

    </tbody>
  </table>
</div>