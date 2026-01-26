<form id="formPasienBaru">
    <div class="row">
        {{ csrf_field() }}
        <input type="hidden" name="status" value="BARU">
        {{-- kolom kiri --}}
        <div class="col-md-6">
            
            <div class="form-group row">
                {!! Html::decode(Form::label('nama', 'Nama<i class="text-danger">*</i>', ['class' => 'col-sm-3 col-form-label'])) !!}
                <div class="col-sm-9">
                    {!! Form::text('nama', null, ['required'=>true,'autocomplete'=>'off','class' => 'form-control keyboard', 'onkeyup'=>'this.value =
                    this.value.toUpperCase()']) !!}
                    <small class="text-danger">{{ $errors->first('nama') }}</small>
                </div>
            </div>
            {{-- <div class="form-group row d-none" id="noRm">
                {!! Html::decode(Form::label('norm', 'No.RM', ['class' => 'col-sm-3 col-form-label'])) !!}
                <div class="col-sm-9">
                    {!! Form::text('norm', null, ['class' => 'form-control','readonly'=>true]) !!}
                </div>
            </div> --}}
            <div class="form-group row">
                {!! Html::decode(Form::label('jeniskelamin', 'Jenis Kelamin<i class="text-danger">*</i>', ['class' => 'col-sm-3 col-form-label'])) !!}
                <div class="col-sm-9">
                    <input type="radio" name="jeniskelamin" value="L" required> Laki-Laki &nbsp;&nbsp;
                    <input type="radio" name="jeniskelamin" value="P"> Perempuan
                    {{-- {!! Form::select('jeniskelamin', ['','','L'=>'Laki-laki', 'P'=>'Perempuan'], NULL, ['class' => 'form-control jeniskelamin', 'style'=>'width:100%','required'=>true]) !!}
                    <small class="text-danger">{{ $errors->first('jeniskelamin') }}</small> --}}
                </div>
            </div>
            <div class="form-group row">
                {!! Html::decode(Form::label('nik', 'NIK<i class="text-danger">*</i>', ['class' => 'col-sm-3 col-form-label'])) !!}
                <div class="col-sm-9">
                    {!! Form::number('nik', null, ['autocomplete'=>'off','class' => 'form-control','placeholder'=>'NIK','required'=>true]) !!}
                    <small class="text-danger">{{ $errors->first('nik') }}</small>
                </div>
            </div>
            {{-- <div class="form-group row" style="display: none"> --}}
            <div class="form-group row">
                {!! Html::decode(Form::label('nomorkartu', 'Nomor Kartu', ['class' => 'col-sm-3 col-form-label'])) !!}
                <div class="col-sm-9">
                    {!! Form::number('nomorkartu', null, ['class' => 'form-control','placeholder'=>'No.Kartu BPJS','autocomplete'=>'off']) !!}
                    <small><i>Isi Jika Ada</i></small>
                </div>
            </div>
            {{-- <div class="form-group row">
                {!! Html::decode(Form::label('nomorkk', 'No.KK<i class="text-danger">*</i>', ['class' => 'col-sm-3 col-form-label'])) !!}
                <div class="col-sm-9">
                    {!! Form::text('nomorkk', null, ['class' => 'form-control','placeholder'=>'Nomor KK']) !!}
                </div>
            </div> --}}
            
        </div>

        {{-- kolom kanan --}}
        <div class="col-md-6"> 
            <div class="form-group row">
                {!! Html::decode(Form::label('nohp', 'No. HP / Tlp<i class="text-danger">*</i>', ['class' => 'col-sm-3 col-form-label'])) !!}
                <div class="col-sm-9">
                    {!! Form::text('nohp', null, ['class' => 'form-control','required'=>true,'autocomplete'=>'off']) !!}
                    <small class="text-danger">{{ $errors->first('nohp') }}</small>
                </div>
            </div>
            <div class="form-group row">
                {!! Form::label('tmplahir', 'Tmp, tgl lahir', ['class' => 'col-sm-3 col-form-label']) !!}
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-md-5">
                            {!! Form::text('tmplahir', null, ['class' => 'form-control', 'onkeyup'=>'this.value =
                            this.value.toUpperCase()','placeholder'=>'Tempat Lahir']) !!}
                            <small class="text-danger">{{ $errors->first('tmplahir') }}</small>
                        </div>
                        <div class="col-md-7">
                            {!! Form::text('tanggallahir', null, ['class' => 'form-control datepickers', 'id'=>'tgllahir','autocomplete'=>'off','placeholder'=>'Tanggal Lahir']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                {!! Form::label('alamat', 'Alamat, RT, RW', ['class' => 'col-sm-3 col-form-label']) !!}
                <div class="col-sm-5">
                    {!! Form::text('alamat', null, ['class' => 'form-control', 'onkeyup'=>'this.value =
                    this.value.toUpperCase()','placeholder'=>'Alamat']) !!}
                    <small class="text-danger">{{ $errors->first('alamat') }}</small>
                </div>
                <div class="col-sm-2">
                    {!! Form::text('rt', null, ['class' => 'form-control', 'placeholder'=>'RT']) !!}
                    <small class="text-danger">{{ $errors->first('rt') }}</small>
                </div>
                <div class="col-sm-2">
                    {!! Form::text('rw', null, ['class' => 'form-control', 'placeholder'=>'RW']) !!}
                    <small class="text-danger">{{ $errors->first('rw') }}</small>
                </div>
            </div>
            <div class="form-group row" id="fieldKelurahan">
                {!! Form::label('village_id', 'Kelurahan', ['class' => 'col-sm-3 col-form-label']) !!}
                <div class="col-sm-9">
                    <select name="kelurahan_id" id="kelurahan" class="form-control select2"></select>
                    </select>
                    <small class="text-danger">{{ $errors->first('village_id') }}</small>
                </div>
            </div> 
            {{-- <div class="form-group row">
                {!! Form::label('pekerjaan_id', 'Pekerjaan', ['class' => 'col-sm-3 col-form-label']) !!}
                <div class="col-sm-9">
                    {!! Form::select('pekerjaan_id', $pekerjaan, null, ['class' => 'form-control select2','id'=>'pekerjaan',
                    'style'=>'width:100%']) !!}
                    <small class="text-danger">{{ $errors->first('pekerjaan_id') }}</small>
                </div>
            </div> --}}
            {{-- <div class="form-group row">
                {!! Form::label('agama_id', 'Agama', ['class' => 'col-sm-3 col-form-label']) !!}
                <div class="col-sm-9">
                    {!! Form::select('agama_id', $agama, null, ['class' => 'form-control select2','id'=>'agama',
                    'style'=>'width:100%']) !!}
                    <small class="text-danger">{{ $errors->first('agama_id') }}</small>
                </div>
            </div> --}}
            {{-- <div class="form-group row">
                {!! Form::label('pendidikan_id', 'Pendidikan', ['class' => 'col-sm-3 col-form-label']) !!}
                <div class="col-sm-9">
                    {!! Form::select('pendidikan_id', $pendidikan, null, ['class' => 'form-control select2','id'=>'pendidikan',
                    'style'=>'width:100%']) !!}
                    <small class="text-danger">{{ $errors->first('pendidikan_id') }}</small>
                </div>
            </div> --}}

            {{-- <div class="form-group row">
                {!! Form::label('ibu_kandung', 'Ibu Kandung', ['class' => 'col-sm-3 col-form-label']) !!}
                <div class="col-sm-9">
                    {!! Form::text('ibu_kandung', '-', ['class' => 'form-control', 'onkeyup'=>'this.value =
                    this.value.toUpperCase()']) !!}
                    <small class="text-danger">{{ $errors->first('ibu_kandung') }}</small>
                </div>
            </div> --}}

            {{-- <div class="form-group row">
                {!! Form::label('status_marital', 'Status Marital', ['class' => 'col-sm-3 col-form-label']) !!}
                <div class="col-sm-9">
                    <select class="form-control select2" style="width:100%" id="status_marital" name="status_marital">
                        <option value="">-</option>
                        <option value="Blm Meninkah">Blm Menikah</option>
                        <option value="Menikah">Menikah</option>
                        <option value="Janda">Janda</option>
                        <option value="Duda">Duda</option>
                    </select>
                    <small class="text-danger">{{ $errors->first('status_marital') }}</small>
                </div>
            </div> --}}
        </div>
        <div class="col-md-12 text-center">
            <button type="reset" class="btn btn-danger btn-sm">Reset <i class="fa-solid fa-refresh"></i> </button>
            <button class="btn btn-success btn-sm">Lanjutkan <i class="fa-solid fa-arrow-right"></i> </button>
        </div>
    </div>
</form>
@section('script') 
  <script type="text/javascript">
  $(document).ready(function () {
    $('#default').keyboard();
    $('#number').keyboard();

    // submit form pasienBaru
    $('#formPasienBaru').submit(function(event) {
      event.preventDefault();
      // console.log($('#formPasienBaru').serialize());
        $.ajax({
            url: '/pasien/pasien-baru',
            type: 'POST',
            dataType: 'json',
            data: $('#formPasienBaru').serialize(), 
            beforeSend: function () {
              $('.loading').removeClass('d-none')
            },
            complete: function () {
                $('.loading').addClass('d-none')
            //    $('.overlay').addClass('hidden')
            }
        })
        .done(function(res) {
          if(res.metadata.code == 201){
            return alert(res.metadata.message)
          } 

          if(res.metadata.code == 200){
            $('.rowAntrian').removeClass('d-none') //tampilkan jika sudah ada no_rm
            $('#formPasienBaru').addClass('d-none') //hide form pasien jika sudah ada no_rm
            $('input[name="norm"]').val(res.response.no_rm)
            $('input[name="nik"]').val(res.response.nik)
            $('input[name="nomorkartu"]').val(res.response.nomorkartu)
            $('input[name="norujukan"]').val(res.response.norujukan)
            // console.log(res)
            // alert(res.metadata.message)
            Swal.fire({
                icon: 'success',
                title: 'Berhasil...',
                text: res.metadata.message
            })
            // return location.href = '/reservasi/'+res.response.norm;
          } 

          $('.loading').addClass('d-none')
        }); 
    });
  });
  </script>
  @parent
@endsection