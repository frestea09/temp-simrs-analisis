<div class="row">
    {{-- kolom kiri --}}
    <div class="col-md-6 rowPasien">
        <h6><b>Data Pasien</b></h6>
    </div>
    {{-- <div class="col-md-6 text-right">
        <a class="btn btn-info btn-sm" style="font-size: 12px;" data-toggle="collapse" href="#collapseExample"
            role="button" aria-expanded="false" aria-controls="collapseExample">
            Pasien lama ? klik disini untuk mencari
        </a>
    </div> --}}

</div>
<div class="row">
    <div class="col-md-12">
        <div class="collapse" id="collapseExample">
            {{-- form cari --}}
            <div class="card card-body mt-3 border-info">
                <div class="form-group row">
                    <div class="col-sm-10">
                        <form id="formCari">
                            {{ csrf_field() }}
                            {!! Form::text('keyword', null, ['class' => 'form-control', 'onkeyup'=>'this.value =
                            this.value.toUpperCase()','placeholder'=>'NIK']) !!}
                            <small class="text-danger">{{ $errors->first('nama') }}</small>
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" href="#" class="btn btn-info btn-sm btn-cari col-sm-12"> <i
                                class="fa fa-search"></i> Cari</button>
                    </div>
                    </form>
                </div>
                <div class="p-2 mb-2 bg-danger text-white not-found d-none"><small> <i
                            class="fa fa-close"></i>&nbsp;<small id="message"></small></div>
            </div>

            
        </div>
        <!-- Modal -->
        <div class="modal fade" id="modalPencarian" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Hasil Pencarian</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered table-striped table-pasien">
                            
                            <tbody id="dataPasien">
                                
                            </tbody>
                        </table>
                    </div>
                    {{-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
@parent
<script type="text/javascript">

    $(document).ready(function () {
    // function abc() {
    //     console.log('a')
    // }
    $('#formCari').submit(function(event) {
        event.preventDefault();
    });
    $('#kelurahan').select2({
            placeholder: "Klik untuk mencari kelurahan",
            width: '100%',
            ajax: {
                url: '/pasien/get-kelurahan/',
                dataType: 'json',
                data: function (params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true,
                
            },
            minimumInputLength: 3,
            language: {
                inputTooShort: function() {
                    return 'Minmial 3 Huruf';
                }
            }
        })
    // Assign data to form pasien
    $('.table-pasien').on('click', '.btn-pilih', function() {
        // btn-pilih
        id = $(this).attr("data-id");
        console.log(id)
        // event.preventDefault();
        $.ajax({
            url: '/reservasi/pilih-pasien',
            type: 'POST',
            dataType: 'json',
            data: {
                _token: $("input[name=_token]").val(),
                id:id
            }, 
            beforeSend: function () {
            //   $('.overlay').removeClass('hidden')
            },
            complete: function () {
            //    $('.overlay').addClass('hidden')
            }
        })
        .done(function(res) {
            // console.log(res)
             if(res.status == 200){
                $('.rowAntrian').removeClass('d-none') //tampilkan jika sudah ada no_rm
                $('#formPasienBaru').addClass('d-none') //hide form pasien jika sudah ada no_rm

                $('input[name="nama"]').val(res.result.nama)
                $('input[name="norm"]').val(res.result.no_rm)
                $('input[name="nomorkartu"]').val(res.result.no_jkn)
                $('input[name="status"]').val('LAMA')
                $('input[name="nik"]').val(res.result.nik)
                $('input[name="tmplahir"]').val(res.result.tmplahir)
                $('input[name="tgllahir"]').val(res.result.tgllahir)
                $('input[name="alamat"]').val(res.result.alamat)
                $('input[name="ibu_kandung"]').val(res.result.ibu_kandung)
                $('input[name="rt"]').val(res.result.rt)
                $('input[name="rw"]').val(res.result.rw)
                $('input[name="nohp"]').val(res.result.nohp)
                $('select[name="kelamin"]').val(res.result.kelamin);
                $("#pekerjaan").val(res.result.pekerjaan_id).trigger('change');
                $("#status_marital").val(res.result.status_marital).trigger('change');
                $("#agama").val(res.result.agama_id).trigger('change');
                $("#pendidikan").val(res.result.pendidikan_id).trigger('change');
                $("#pekerjaan").val(res.result.pekerjaan_id).trigger('change');
                // $("#kelurahan").val(res.result.village_id).trigger('change');
                $('#fieldKelurahan').addClass('d-none')
                $('#noRm').removeClass('d-none')
                // $("#regency_id").val(res.result.regency_id).trigger('change');

             }
             $('#modalPencarian').modal('hide')
             $('#dataPasien').html('')
        });
    })
    $('.btn-cari').on('click', function(){
        $('#dataPasien').html('')

        $('.not-found').addClass('d-none')
        cari = $('input[name="keyword"]').val()
        if(cari !== ''){
            $.ajax({
            url: '/reservasi/cari-pasien-nik',
            type: 'POST',
            dataType: 'json',
            data: $('#formCari').serialize(), 
            beforeSend: function () {
            //   $('.overlay').removeClass('hidden')
            },
            complete: function () {
            //    $('.overlay').addClass('hidden')
            }
        })
        .done(function(res) {
            val = res.result
            if(res.status == 200){
                $('#modalPencarian').modal('show')
                // $.each(res.result, function(index, val) {
                    // console.log(val.nama)
                    $('#dataPasien').append('<tr> <th>NIK</th><td>'+(val.nik)+'</td></tr><tr> <th>No.RM</th><td>'+(val.no_rm)+'</td></tr><tr><th>Nama</th><td>'+(val.nama)+
                    '</td></tr><tr><th>Alamat</th><td>'+(val.alamat)+
                    '</td></tr><tr><th>No.HP</th><td>'+(val.nohp)+
                    '</td></tr><tr><th>Tempat,Tgl.Lahir</th><td>'+(val.tmplahir)+', '+(val.tgllahir)
                    +'</td></tr><tr><th>&nbsp;</th><td class="text-left"><button type="submit" data-id="'+val.id+'" class="btn btn-success btn-pilih col-form-label btn-sm"><i class="fa fa-arrow-right"></i> &nbsp;Lanjutkan</button></td></tr>')
                // })
                // $('#message').append(res.result)
            }
            // jika pasien tidak ditemukan
            if(res.status == 500){
                // $('.not-found').removeClass('d-none')
                // $('#message').append(res.result)
                Swal.fire({
                    icon: 'error',
                    title: 'Maaf...',
                    text: res.result
                })
            }
        });
        }else{
            return alert('Form Pencarian wajib diisi')
        }
        // nama = $('input[name="nama"]').val(cari)
        
       
    });

    $( function() {
            $( ".datepickers" ).datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
            autoclose: true
            });
        });
    
});
</script>
@endsection