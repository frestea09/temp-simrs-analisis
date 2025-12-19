@extends('master')

@section('header')
  <h1>FORM PEGAWAI</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
           KEPEGAWAIAN
      </h3>
    </div>
    <div class="box-body">
        <form method="POST" class="form-horizontal" id="formBiodata" enctype="multipart/form-data">
            {{ csrf_field() }} 
            @if (isset($biodata))
                {{ method_field('PUT') }}
            @else 
                {{ method_field('POST') }}
            @endif
            <input type="hidden" name="id" value="{{ isset($biodata) ? $biodata->id : NULL }}">
            <div class="row">
                <div class="col-sm-6">
                    @if(isset($biodata) && $biodata->pegawai_id == null)
                    <div class="form-group namaGroup">
                        <label for="nama" class="col-sm-4 control-label">SINKRON DATA</label>
                        <div class="col-sm-8">
                            <select name="pegawai_id" id="masterPegawai" class="form-control">
                            </select>
                        </div>
                    </div>
                    @php
                        $peg = \Modules\Pegawai\Entities\Pegawai::find($biodata->pegawai_id);
                    @endphp
                    <div class="form-group namaGroup">
                        <label for="nama" class="col-sm-4 control-label">PEGAWAI</label>
                        <div class="col-sm-8">
                            <input type="text" disabled name="namapeg" value="{{ isset($peg->nama) ? $peg->nama : NULL }}" class="form-control">
                            <small class="text-danger namaError"></small>
                        </div>
                    </div>
                    <hr>
                    @endif
                    <div class="form-group namaGroup">
                        <label for="nama" class="col-sm-4 control-label">Nama Lengkap</label>
                        <div class="col-sm-8">
                            <input type="text" name="namalengkap" value="{{ isset($biodata) ? $biodata->namalengkap : NULL }}" class="form-control">
                            <small class="text-danger namaError"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ttl" class="col-sm-4 control-label">TTL</label>
                        <div class="col-sm-4 tmplahirGroup">
                            <input type="text" name="tmplahir" class="form-control" value="{{ isset($biodata->pegawai->tmplahir) ? $biodata->pegawai->tmplahir : null }}">
                            <small class="text-danger tmplahirError"></small>
                        </div>
                        <div class="col-sm-4 tgllahirGroup">
                            <input type="text" name="tgllahir" class="form-control datepicker" value="{{ isset($biodata->pegawai->tgllahir) ? \Carbon\Carbon::parse($biodata->pegawai->tgllahir)->format('d-m-Y') : null }}">
                            <small class="text-danger tgllahirError"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="jk" class="col-sm-4 control-label">Kelamin / Gol Darah</label>
                        <div class="col-sm-4">
                            <select class="form-control select2" name="kelamin">
                                @if (isset($biodata) && $biodata->kelamin == 'L')
                                    <option value="L" selected>Laki - Laki</option>
                                    <option value="P">Perempuan</option>
                                @elseif(isset($biodata) && $biodata->kelamin == 'P')
                                    <option value="L">Laki - Laki</option>
                                    <option value="P" selected>Perempuan</option>
                                @else 
                                    <option value="L">Laki - Laki</option>
                                    <option value="P">Perempuan</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <select class="form-control select2" name="goldarah">
                                @if (isset($biodata) && $biodata->goldarah == 'A')
                                    <option value="A" selected>A</option>
                                    <option value="B">B</option>
                                    <option value="O">O</option>
                                    <option value="AB">AB</option>
                                @elseif (isset($biodata) && $biodata->goldarah == 'B')
                                    <option value="A">A</option>
                                    <option value="B" selected>B</option>
                                    <option value="O">O</option>
                                    <option value="AB">AB</option>
                                @elseif (isset($biodata) && $biodata->goldarah == 'O')
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="O" selected>O</option>
                                    <option value="AB">AB</option>
                                @elseif (isset($biodata) && $biodata->goldarah == 'AB')
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="O">O</option>
                                    <option value="AB" selected>AB</option>
                                @else
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="O">O</option>
                                    <option value="AB">AB</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group sukuGroup">
                        <label for="suku" class="col-sm-4 control-label">Suku / Agama *</label>
                        <div class="col-sm-4">
                            <input type="text" name="suku" class="form-control" value="{{ isset($biodata) ? $biodata->suku : NULL }}">
                            <small class="text-danger sukuError"></small>
                        </div>
                        <div class="col-sm-4">
                            <select class="form-control select2" name="agama_id">
                                @foreach ($agama as $d)
                                    @if (isset($biodata) && $biodata->agama_id == $d->id )
                                        <option value="{{ $d->id }}" selected>{{ $d->agama }}</option>
                                    @else 
                                        <option value="{{ $d->id }}">{{ $d->agama }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="warga" class="col-sm-4 control-label">Kewargaan / Status *</label>
                        <div class="col-sm-4">
                            <input type="text" name="warganegara" class="form-control" value="{{ isset($biodata) ? $biodata->warganegara : 'WNI' }}">
                        </div>
                        <div class="col-sm-4">
                            <select class="form-control select2" name="statuskawin">
                                @if (isset($biodata) && $biodata->statuskawin == 'Blm Menikah')
                                    <option value="Blm Menikah" selected="true">Blm Menikah</option>
                                    <option value="Menikah">Menikah</option>
                                    <option value="Janda">Janda</option>
                                    <option value="Duda">Duda</option>
                                @elseif (isset($biodata) && $biodata->statuskawin == 'Menikah')
                                    <option value="Blm Menikah">Blm Menikah</option>
                                    <option value="Menikah" selected="true">Menikah</option>
                                    <option value="Janda">Janda</option>
                                    <option value="Duda">Duda</option>
                                @elseif (isset($biodata) && $biodata->statuskawin == 'Janda')
                                    <option value="Blm Menikah">Blm Menikah</option>
                                    <option value="Menikah">Menikah</option>
                                    <option value="Janda" selected="true">Janda</option>
                                    <option value="Duda">Duda</option>
                                @elseif (isset($biodata) && $biodata->statuskawin == 'Duda')
                                    <option value="Blm Menikah">Blm Menikah</option>
                                    <option value="Menikah">Menikah</option>
                                    <option value="Janda">Janda</option>
                                    <option value="Duda" selected="true">Duda</option>
                                @else
                                    <option value="Blm Menikah" selected="true">Blm Menikah</option>
                                    <option value="Menikah">Menikah</option>
                                    <option value="Janda">Janda</option>
                                    <option value="Duda">Duda</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group alamatGroup">
                        <label for="alamat" class="col-sm-4 control-label">Alamat Tinggal *</label>
                        <div class="col-sm-8">
                            {{-- <input type="text" name="alamat" class="form-control" value="{{ isset($biodata) ? $biodata->alamat : NULL }}"> --}}
                            <textarea class="form-control" name="alamat">{{ isset($biodata->pegawai->alamat) ? $biodata->pegawai->alamat : null }}</textarea>
                            <small class="text-danger alamatError"></small>
                        </div>
                    </div>
                    <div class="form-group province_idGroup">
                        <label for="provinsi" class="col-sm-4 control-label">Provinsi *</label>
                        <div class="col-sm-8 province_idGroup">
                            <select class="form-control select2" name="province_id">
                                    <option value=""></option>
                                @foreach ($provinsi as $d)
                                    @if (isset($biodata) && $biodata->province_id == $d->id)
                                        <option value="{{ $d->id }}" selected> {{ $d->name }} </option>
                                    @else 
                                        <option value="{{ $d->id }}"> {{ $d->name }} </option>
                                    @endif
                                @endforeach
                            </select>
                            <small class="text-danger province_idError"></small>
                        </div>
                    </div>
                    <div class="form-group regency_idGroup">
                        <label for="kota" class="col-sm-4 control-label">Kabupaten / Kota *</label>
                        <div class="col-sm-8 regency_idGroup">
                            <select class="form-control select2" name="regency_id">
                                @if (isset($biodata) && $biodata->regency_id != null)
                                    <option value="{{ $biodata->regency_id }}" selected> {{ $kabupaten }} </option>
                                @endif
                            </select>
                            <small class="text-danger regency_idError"></small>
                        </div>
                    </div>
                    <div class="form-group district_idGroup">
                        <label for="kecamatan" class="col-sm-4 control-label">Kecamatan *</label>
                        <div class="col-sm-8 district_idGroup">
                            <select class="form-control select2" name="district_id">
                                @if (isset($biodata) && $biodata->district_id != null)
                                    <option value="{{ $biodata->district_id }}" selected> {{ $kecamatan }} </option>
                                @endif
                            </select>
                            <small class="text-danger district_idError"></small>
                        </div>
                    </div>
                    <div class="form-group village_idGroup">
                        <label for="desa" class="col-sm-4 control-label">Desa / Kelurahan *</label>
                        <div class="col-sm-8 village_idGroup">
                            <select class="form-control select2" name="village_id">
                                @if (isset($biodata) && $biodata->village_id != null)
                                    <option value="{{ $biodata->village_id }}" selected> {{ $desa }} </option>
                                @endif
                            </select>
                            <small class="text-danger village_idError"></small>
                        </div>
                    </div>
                    <div class="form-group notlpGroup">
                        <label for="telepon" class="col-sm-4 control-label">Telepon *</label>
                        <div class="col-sm-8">
                            <input type="text" name="notlp" class="form-control" value="{{ isset($biodata) ? $biodata->notlp : NULL }}">
                            <small class="text-danger notlpError"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nohp" class="col-sm-4 control-label">Hp / Kode Pos *</label>
                        <div class="col-sm-4 nohpGroup">
                            <input type="text" name="nohp" class="form-control" value="{{ isset($biodata) ? $biodata->nohp : NULL }}">
                            <small class="text-danger nohpError"></small>
                        </div>
                        <div class="col-sm-4 kdposGroup">
                            <input type="text" name="kdpos" class="form-control" value="{{ isset($biodata) ? $biodata->kdpos : NULL }}">
                            <small class="text-danger kdposError"></small>
                        </div>
                    </div>
                    <div class="form-group emailGroup">
                        <label for="email" class="col-sm-4 control-label">Email *</label>
                        <div class="col-sm-8">
                            <input type="text" name="email" class="form-control" value="{{ isset($biodata) ? $biodata->email : NULL }}">
                            <small class="text-danger emailError"></small>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="depan" class="col-sm-4 control-label">Gelar Dpn</label>
                                <div class="col-sm-8">
                                    <input type="text" name="gelar_dpn" class="form-control" value="{{ isset($biodata) ? $biodata->gelar_dpn : NULL }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tmt" class="col-sm-4 control-label">TMT CPNS </label>
                                <div class="col-sm-8">
                                    <input type="text" name="tmtcpns" class="form-control datepicker" value="{{ isset($biodata) ? $biodata->TMTCPNS : NULL }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="dupeg" class="col-sm-4 control-label">Dupeg</label>
                                <div class="col-sm-8">
                                    <input type="text" name="dupeg" class="form-control" value="{{ isset($biodata) ? $biodata->dupeg : NULL }}">
                                </div>
                            </div>
                            <div class="form-group emailGroup">
                                <label for="nokartupegawai" class="col-sm-4 control-label">No. KarPeg *</label>
                                <div class="col-sm-8">
                                    <input type="text" name="nokartupegawai" class="form-control" value="{{ isset($biodata) ? $biodata->nokartupegawai : NULL }}"> 
                                    <small class="text-danger nokartupegawaiError"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="noaskes" class="col-sm-4 control-label">No. Askes</label>
                                <div class="col-sm-8">
                                    <input type="text" name="noaskes" class="form-control" value="{{ isset($biodata) ? $biodata->noaskes : NULL }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="npwp" class="col-sm-4 control-label">NPWP</label>
                                <div class="col-sm-8">
                                    <input type="text" name="npwp" class="form-control" value="{{ isset($biodata) ? $biodata->npwp : NULL }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="depan" class="col-sm-4 control-label">Gelar Blkg</label>
                                <div class="col-sm-8">
                                    <input type="text" name="gelar_blk" class="form-control" value="{{ isset($biodata) ? $biodata->gelar_blk : NULL }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="masakerja" class="col-sm-4 control-label"> Masa Kerja</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="dupeg" class="col-sm-4 control-label"></label>
                                <div class="col-sm-8">
                                    <input type="text" disabled class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="noktp" class="col-sm-4 control-label">No. KTP</label>
                                <div class="col-sm-8">
                                    <input type="text" name="noktp" class="form-control" value="{{ isset($biodata) ? $biodata->noktp : NULL }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="notaspen" class="col-sm-4 control-label">No. Taspen</label>
                                <div class="col-sm-8">
                                    <input type="text" name="notaspen" class="form-control" value="{{ isset($biodata) ? $biodata->notaspen : NULL }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="nokarsu" class="col-sm-4 control-label">No. KARSU</label>
                                <div class="col-sm-8">
                                    <input type="text" name="nokarsu" class="form-control" value="{{ isset($biodata) ? $biodata->nokarsu : NULL }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="jenisfungsional" class="col-sm-4 control-label">Jenis Fungsional</label>
                                <div class="col-sm-8">
                                    <input type="text" name="jenisfungsional" class="form-control" value="{{ isset($biodata) ? $biodata->jenisfungsional : NULL }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="fungsional" class="col-sm-4 control-label">Fungsional</label>
                                <div class="col-sm-8">
                                    <input type="text" name="fungsional" class="form-control" value="{{ isset($biodata) ? $biodata->fungsional : NULL }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="fungsionaltertentu" class="col-sm-4 control-label">Fungsional Tertentu</label>
                                <div class="col-sm-8">
                                    <input type="text" name="fungsionaltertentu" class="form-control" value="{{ isset($biodata) ? $biodata->fungsionaltertentu : NULL }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="foto" class="col-sm-4 control-label">Foto</label>
                                <div class="col-sm-8">
                                    <input type="file" name="foto" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            @if (isset($biodata) && $biodata->foto != '')
                                <img src="{{ asset('images/pegawai/'.$biodata->foto) }}" class="img img-responsive" alt="Foto Pegawai">
                            @endif
                        </div>
                    </div>
                    <button class="btn btn-default btn-flat" type="button" onclick="save()">SIMPAN</button>
                </div>
            </div>
        </form>
    </div>
    <div class="overlay hidden">
        <i class="fa fa-refresh fa-spin"></i>
    </div>
  </div>


@endsection

@section('script')
<script type="text/javascript">
    // $('.select2_').select2({
    //     // ajax: {
    //     //     url: '{{ url("hrd/biodata/search/pegawai") }}',
    //     //     dataType: 'json'
    //     // }
    //     placeholder: "Pilih No Rm...",
    //     ajax: {
    //         url: '/pasien/master-pasien/',
    //         dataType: 'json',
    //         data: function (params) {
    //             return {
    //                 q: $.trim(params.term)
    //             };
    //         },
    //         processResults: function (data) {
    //             return {
    //                 results: data
    //             };
    //         },
    //         cache: true
    //     }
    // })

    $('#masterPegawai').select2({
        placeholder: "Pilih Pegawai",
        ajax: {
            url: '{{ url("hrd/biodata/search/pegawai") }}',
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
            cache: true
        }
    })

    // $('.select2').select2()

    function save(){
        var data = $('#formBiodata').serialize()
        var id = $('input[name="id"]').val()

        if (id != '') {
			url = '/hrd/biodata/'+id
		} else {
			url = '{{ route('biodata.store') }}'
        }
        
        $.ajax({
            url :  url,
            type : 'POST',
            dataType : 'json',
            data : new FormData($('#formBiodata')[0]),
            contentType : false,
            cache : false,
            processData : false,
            beforeSend : function(){
                $('.overlay').removeClass('hidden')
            },
            success : function(resp){
                $('.overlay').addClass('hidden')
            if(resp.sukses == false){
                if(resp.error.namalengkap){
                    $('.namaGroup').addClass('has-error')
                    $('.namaError').text(resp.error.namalengkap[0]);
                }
                if(resp.error.tmplahir){
                    $('.tmplahirGroup').addClass('has-error')
                    $('.tmplahirError').text(resp.error.tmplahir[0]);
                }
                if(resp.error.tgllahir){
                    $('.tgllahirGroup').addClass('has-error')
                    $('.tgllahirError').text(resp.error.tgllahir[0]);
                }
                if(resp.error.suku){
                    $('.sukuGroup').addClass('has-error')
                    $('.sukuError').text(resp.error.suku[0]);
                }
                if(resp.error.alamat){
                    $('.alamatGroup').addClass('has-error')
                    $('.alamatError').text(resp.error.alamat[0]);
                }
                if(resp.error.province_id){
                    $('.province_idGroup').addClass('has-error')
                    $('.province_idError').text(resp.error.province_id[0]);
                }
                if(resp.error.regency_id){
                    $('.regency_idGroup').addClass('has-error')
                    $('.regency_idError').text(resp.error.regency_id[0]);
                }
                if(resp.error.district_id){
                    $('.district_idGroup').addClass('has-error')
                    $('.district_idError').text(resp.error.district_id[0]);
                }
                if(resp.error.village_id){
                    $('.village_idGroup').addClass('has-error')
                    $('.village_idError').text(resp.error.village_id[0]);
                }
                if(resp.error.notlp){
                    $('.notlpGroup').addClass('has-error')
                    $('.notlpError').text(resp.error.notlp[0]);
                }
                if(resp.error.nohp){
                    $('.nohpGroup').addClass('has-error')
                    $('.nohpError').text(resp.error.nohp[0]);
                }
                if(resp.error.kdpos){
                    $('.kdposGroup').addClass('has-error')
                    $('.kdposError').text(resp.error.kdpos[0]);
                }
                if(resp.error.email){
                    $('.emailGroup').addClass('has-error')
                    $('.emailError').text(resp.error.email[0]);
                }
                if(resp.error.nokartupegawai){
                    $('.nokartupegawaiGroup').addClass('has-error')
                    $('.nokartupegawaiError').text(resp.error.nokartupegawai[0]);
                }
            }
            if(resp.sukses == true){
                alert('sukses')
                location.reload();
            }
            }
        })
        // .done(function(resp){
        //     $('.overlay').addClass('hidden')
        //     if(resp.sukses == false){
        //         if(resp.error.namalengkap){
        //             $('.namaGroup').addClass('has-error')
        //             $('.namaError').text(resp.error.namalengkap[0]);
        //         }
        //         if(resp.error.tmplahir){
        //             $('.tmplahirGroup').addClass('has-error')
        //             $('.tmplahirError').text(resp.error.tmplahir[0]);
        //         }
        //         if(resp.error.tgllahir){
        //             $('.tgllahirGroup').addClass('has-error')
        //             $('.tgllahirError').text(resp.error.tgllahir[0]);
        //         }
        //         if(resp.error.suku){
        //             $('.sukuGroup').addClass('has-error')
        //             $('.sukuError').text(resp.error.suku[0]);
        //         }
        //         if(resp.error.alamat){
        //             $('.alamatGroup').addClass('has-error')
        //             $('.alamatError').text(resp.error.alamat[0]);
        //         }
        //         if(resp.error.province_id){
        //             $('.province_idGroup').addClass('has-error')
        //             $('.province_idError').text(resp.error.province_id[0]);
        //         }
        //         if(resp.error.regency_id){
        //             $('.regency_idGroup').addClass('has-error')
        //             $('.regency_idError').text(resp.error.regency_id[0]);
        //         }
        //         if(resp.error.district_id){
        //             $('.district_idGroup').addClass('has-error')
        //             $('.district_idError').text(resp.error.district_id[0]);
        //         }
        //         if(resp.error.village_id){
        //             $('.village_idGroup').addClass('has-error')
        //             $('.village_idError').text(resp.error.village_id[0]);
        //         }
        //         if(resp.error.notlp){
        //             $('.notlpGroup').addClass('has-error')
        //             $('.notlpError').text(resp.error.notlp[0]);
        //         }
        //         if(resp.error.nohp){
        //             $('.nohpGroup').addClass('has-error')
        //             $('.nohpError').text(resp.error.nohp[0]);
        //         }
        //         if(resp.error.kdpos){
        //             $('.kdposGroup').addClass('has-error')
        //             $('.kdposError').text(resp.error.kdpos[0]);
        //         }
        //         if(resp.error.email){
        //             $('.emailGroup').addClass('has-error')
        //             $('.emailError').text(resp.error.email[0]);
        //         }
        //         if(resp.error.nokartupegawai){
        //             $('.nokartupegawaiGroup').addClass('has-error')
        //             $('.nokartupegawaiError').text(resp.error.nokartupegawai[0]);
        //         }
        //     }
        //     if(resp.sukses == true){
        //         alert('sukses')
        //         location.reload();
        //     }

        // })
        
    }

</script>
@endsection
