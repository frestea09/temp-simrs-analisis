<div class="row rowAntrian d-none">
    <div class="col-md-12"><h6><b>Data Reservasi</b></h6></div>
    <div class="col-md-12"><hr/></div>
  </div>
<form id="form" class="rowAntrian d-none">
    <div class="row">
        {{ csrf_field() }}
        {{-- kolom kiri --}}
        <div class="col-md-6">
            <input type="hidden" name="jam_praktek" value="">
            <input type="hidden" name="status" value="BARU">
            <input type="hidden" name="nik" value="">
            <input type="hidden" name="norm" value="">
            {{-- <input type="hidden" name="nomorkartu" value=""> --}}
            <div class="form-group row d-none" id="niks">
                {!! Html::decode(Form::label('nik', 'NIK <i class="text-danger">*</i>', ['class' => 'col-sm-3 col-form-label',])) !!}
                <div class="col-sm-9">
                    {!! Form::text('nik', null, ['class' => 'form-control','required'=>true]) !!}
                </div>
            </div>

            <div class="form-group row d-none" id="fieldKelurahan">
                {!! Form::label('village_id', 'Kelurahan', ['class' => 'col-sm-3 col-form-label']) !!}
                <div class="col-sm-9">
                    <select name="kelurahan_id" id="kelurahan" class="form-control select2">
                    </select>
                    </select>
                    <small class="text-danger">{{ $errors->first('village_id') }}</small>
                </div>
            </div> 
            {{-- <div class="form-group row"> --}}
                {{-- {!! Form::label('jam_praktek', 'Jam Praktek', ['class' => 'col-sm-3 control-label']) !!} --}}
                {{-- <div class="col-sm-9"> --}}
                    {{-- {!! Form::text('jam_praktek', null, ['class' => 'form-control timepicker','readonly'=>true]) !!}
                    <small class="text-danger">{{ $errors->first('alamat') }}</small> --}}
                {{-- </div> --}}
                {{-- <div class="col-sm-2">sampai</div>
                <div class="col-sm-3">
                    {!! Form::text('jam_end', null, ['class' => 'form-control timepicker']) !!}
                    <small class="text-danger">{{ $errors->first('jam_end') }}</small>
                </div> --}}
            {{-- </div> --}}
            <div class="form-group row">
                {!! Html::decode(Form::label('pengirim_rujukan', 'Cara Datang<i class="text-danger">*</i>', ['class' => 'col-sm-3 col-form-label'])) !!}
                <div class="col-sm-9">
                    {!! Form::select('pengirim_rujukan', $pengirim_rujukan, 7, ['class' => 'form-control select2','style'=>'width:100%']) !!}
                </div>
            </div>  
            <div class="form-group row">
                {!! Html::decode(Form::label('bayar', 'Cara Bayar<i class="text-danger">*</i>', ['class' => 'col-sm-3 col-form-label'])) !!}
                <div class="col-sm-4">
                    {!! Form::select('bayar', $carabayar, 1, ['class' => 'form-control select2','id'=>'carabayar', 'style'=>'width:100%']) !!}
                </div>
                <div class="col-sm-5" id="tipeJKN">
                    {!! Form::select('jkn', $jenisjkn, null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                </div>
            </div>
            <div class="form-group row" id='nomorkartu'>
                {!! Html::decode(Form::label('nomorkartu', 'No. Kartu<i class="text-danger">*</i>', ['class' => 'col-sm-3 col-form-label'])) !!}
                <div class="col-sm-9">
                    {!! Form::text('nomorkartu', '', ['class' => 'form-control','placeholder'=>'No.Kartu BPJS','required'=>true]) !!}
                </div>
            </div>  
            <div class="form-group row" id='no_rujukan'>
                {!! Html::decode(Form::label('nomorreferensi', 'No. Rujukan<i class="text-danger">*</i>', ['class' => 'col-sm-3 col-form-label'])) !!}
                <div class="col-sm-9">
                    {!! Form::text('nomorreferensi', '', ['class' => 'form-control','placeholder'=>'No.Rujukan BPJS','required'=>true]) !!}
                </div>
            </div>  
        </div>  
        {{-- kolom kanan --}}
        <div class="col-md-6">
            {{-- Tgl periksa --}}
            <div class="form-group row"> 
                {!! Html::decode(Form::label('tanggalperiksa', 'Tanggal Periksa<i class="text-danger">*</i>', ['class' => 'col-sm-3 col-form-label'])) !!}
                <div class="col-sm-9">
                    {!! Form::text('tanggalperiksa', date('Y-m-d'), ['class' => 'form-control datepickers', 'id'=>'tglperiksa','autocomplete'=>'off','placeholder'=>'Tanggal Periksa']) !!}
                </div>
            </div>
            {{-- poli tujuan --}}
            <div class="form-group row">
                {!! Html::decode(Form::label('kodepoli', 'Poli Tujuan<i class="text-danger">*</i>', ['class' => 'col-sm-3 col-form-label'])) !!}
                <div class="col-sm-9">
                    <select class="form-control select2" style="width:100%" id="kodepoli" name="kodepoli" required>
                        <option value=""></option>
                        @foreach ($poli as $key => $d)
                        <option value="{{ $d->id }}">{{ $d->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            {{-- dokter --}}
            <div class="form-group row">
                {!! Html::decode(Form::label('kodedokter', 'Dokter | Jam Praktek<i class="text-danger">*</i>', ['class' => 'col-sm-3 col-form-label'])) !!}
                <div class="col-sm-9">
                    <select class="form-control select2" style="width:100%" id="kodedokter" name="kodedokter" disabled required>
                    </select>
                    <small class="text-danger d-none" id="dokter_not_found">Dokter Tidak Tersedia Pada Tanggal Periksa</small>
                </div>
            </div> 
        </div>
        
        <div class="col-md-12"><hr/></div>
            <div class="col-md-12 text-center">
            <button type="reset" class="btn btn-danger btn-sm">Reset <i class="fa-solid fa-refresh"></i> </button>
            <button class="btn btn-success btn-sm">Reservasi <i class="fa-solid fa-arrow-right"></i> </button>
        </div>
        
    </div>
</form>

@section('script')
@parent
<script type="text/javascript">

     $('#tglperiksa').on('change', function(){
        if($("select[name='kodepoli']").val() !== ''){
            $("#kodepoli").trigger('change')
        }
    })
    // change carabayar
    $('#carabayar').on('change', function(){
        bayar = $("select[name='bayar']").val()
        if(bayar !== '1'){
            $('#tipeJKN').addClass('d-none')
            $('#nomorkartu').addClass('d-none')
            $('#no_rujukan').addClass('d-none')
        }else{
            $('#tipeJKN').removeClass('d-none')
            $('#nomorkartu').removeClass('d-none')
            $('#no_rujukan').removeClass('d-none')
        }
    });

    // cari dokter hfis berdasarkan poli
    $('#kodepoli').on('change', function(){
        $('#dokter_not_found').addClass('d-none')
        poli = $("select[name='kodepoli']").val()
        $('select[name="kodedokter"]').empty()
        $('select[name="kodedokter"]').prop("disabled", true);
        
        $.ajax({
            url: '/jadwal/jadwal-dokter-hfis',
            type: 'POST',
            dataType: 'json',
            data: {
                _token: $("input[name='_token']").val(),
                poli: poli,
                reservasi: 1,
                tgl: $("input[name='tanggalperiksa']").val(),
            }, 
            beforeSend: function () {
            //   $('.overlay').removeClass('hidden')
            },
            complete: function () {
            //    $('.overlay').addClass('hidden')
            }
        })
        .done(function(res) {
            $("input[name='jam_praktek']").empty()
            // data = JSON.parse(res)
            data = res
            // console.log(data[0])
            if (data[0].metadata.code == 200) {
                $('select[name="kodedokter"]').prop("disabled", false);
                $.each(data[1], function(index, val) {
                    $('select[name="kodedokter"]').append('<option value="">-- Pilih Dokter --</option><option data-jam-praktek="'+val.jadwal+'" value="'+ val.id +'">'+ val.namadokter +' | '+val.jadwal+' </option>');
                });
            }else{
                $('#dokter_not_found').removeClass('d-none')
                $('select[name="kodedokter"]').prop("disabled", true);
            }
        }); 
        
    });

    // change kodedokter
    $('#kodedokter').on('change', function(){
        // kodedokter = $('select[name="kodedokter"]').val()
        jam_praktek = $('option:selected', this).attr('data-jam-praktek');
        $("input[name='jam_praktek']").val(jam_praktek)
        // $("#kodedokter").val().trigger('change');
    })

    // submit form reservasi
    $('#form').submit(function(event) {
      event.preventDefault();
      if($('#fieldKelurahan').css('display') == 'none'){
        
      }else{
        if($('select[name="kelurahan_id"]').val() == null){
           return Swal.fire({
                icon: 'info',
                title: 'Perhatian...',
                text: 'Kelurahan Wajib Diisi'
            })
        }
      }
    //   return
        $.ajax({
            url: '/reservasi/store',
            type: 'POST',
            dataType: 'json',
            data: $('#form').serialize(), 
            beforeSend: function () {
            //   $('.overlay').removeClass('hidden')
            },
            complete: function () {
            //    $('.overlay').addClass('hidden')
            }
        })
        .done(function(res) {
          if(res.metadata.code == 201){
            return alert(res.metadata.message)
          } 

          if(res.metadata.code == 200){
            $('input[name="id_reservasi"]').val(res.response.id);
            // cetak(res.response.id)
            Swal.fire({
                icon: 'success',
                title: 'Berhasil...',
                text: 'Reservasi Telah Berhasil Dibuat'
            }).then(() => {
            /* Read more about isConfirmed, isDenied below */
                return window.location.href = "/reservasi/cetak/"+res.response.id+"/"+res.response.norm
            })
            
          } 
            
        }); 
    });
</script>
@endsection