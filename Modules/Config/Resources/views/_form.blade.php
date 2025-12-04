{{-- <div class="row"> --}}
  {{-- Kolom kiri --}}
  {{-- <div class="col-md-6">
    <div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
        {!! Form::label('nama', 'Nama', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('nama', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('nama') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('alamat') ? ' has-error' : '' }}">
        {!! Form::label('alamat', 'Alamat', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('alamat', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('alamat') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('website') ? ' has-error' : '' }}">
        {!! Form::label('website', 'Website', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('website', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('website') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        {!! Form::label('email', 'Email ', ['class' =>'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'contoh: foo@bar.com']) !!}
            <small class="text-danger">{{ $errors->first('email') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('logo') ? ' has-error' : '' }}">
        {!! Form::label('logo', 'Logo', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
                {!! Form::file('logo', ['class' => 'form-control']) !!}
                <p class="help-block">Help block text</p>
                <small class="text-danger">{{ $errors->first('logo') }}</small>
            </div>
    </div>
    <div class="form-group{{ $errors->has('bayardepan') ? ' has-error' : '' }}">
        {!! Form::label('bayardepan', 'Bayar Depan', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::select('bayardepan', ['Y'=>'Ya', 'N'=>'Tidak'], null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('bayardepan') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('kasirtindakan') ? ' has-error' : '' }}">
        {!! Form::label('kasirtindakan', 'Kasir Tindakan', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::select('kasirtindakan', ['Y'=>'Ya', 'N'=>'Tidak'], null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('kasirtindakan') }}</small>
        </div>
    </div>

  </div>
  {{-- Kolom Kanan --}}
  <div class="col-md-6">
    <div class="form-group{{ $errors->has('antrianfooter') ? ' has-error' : '' }}">
        {!! Form::label('antrianfooter', 'Antrian Footer', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('antrianfooter', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('antrianfooter') }}</small>
        </div>
    </div>
  <div class="form-group{{ $errors->has('tahuntarif') ? ' has-error' : '' }}">
      {!! Form::label('tahuntarif', 'Tahun Tarif', ['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-9">
          {!! Form::select('tahuntarif', $tahun, null, ['class' => 'form-control']) !!}
          <small class="text-danger">{{ $errors->first('tahuntarif') }}</small>
      </div>
  </div>
    <div class="form-group{{ $errors->has('panjangkodepasien') ? ' has-error' : '' }}">
        {!! Form::label('panjangkodepasien', 'Panjang Kode Pasien', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('panjangkodepasien', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('panjangkodepasien') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('ipsep') ? ' has-error' : '' }}">
        {!! Form::label('ipsep', 'IP SEP', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('ipsep', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('ipsep') }}</small>
        </div>
    </div> --}}
    {{-- <div class="form-group{{ $errors->has('usersep') ? ' has-error' : '' }}">
        {!! Form::label('usersep', 'User SEP', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('usersep', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('usersep') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('ipinacbg') ? ' has-error' : '' }}">
        {!! Form::label('ipinacbg', 'IP INACBG', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('ipinacbg', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('ipinacbg') }}</small>
        </div>
    </div>

    <div class="btn-group pull-right">
        <a href="{{ route('config') }}" class="btn btn-warning btn-flat">Batal</a>
        {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
    </div>

  </div>
</div> --}}
