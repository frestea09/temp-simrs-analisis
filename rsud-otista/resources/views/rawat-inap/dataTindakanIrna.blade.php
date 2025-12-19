<div class='table-responsive'>
  <form id="lunaskan">
  <table class='table table-striped table-bordered table-hover table-condensed' id="tindakanIrna">
    <thead>
      <tr>
        {{-- <th class="text-center"></th> --}}
        <th class="text-center">No</th>
        <th class="text-center">Tindakan</th>
        <th class="text-center">Pelaksana</th>
        <th class="text-center">Pelayanan</th>
        <th class="text-center">Total</th>
        <th class="text-center">Cara Bayar</th>
        <th class="text-center">Admin</th>
        <th class="text-center">Waktu</th>
        <th class="text-center">Waktu Visit Dokter</th>
        <th class="text-center">Dibayar</th>
        <th class="text-center">Sinkron</th>
        @role(['rawatinap', 'supervisor', 'administrator'])
        <th class="text-center">Proses</th>
        @endrole
      </tr>
    </thead>
    <tbody>
      {{ csrf_field() }}
    @foreach ($folio as $key => $d)
      <tr>
        {{-- <td>
        @if($d->cara_bayar_id != 1)
          <input type="checkbox" name="lunas[]" value="{{ $d->id }}">
        @else
          @role(['administrator'])
            <input type="checkbox" name="lunas[]" value="{{ $d->id }}">
          @endrole
        @endif
        </td> --}}
        <td>{{ $no++ }}</td>
        <td>{{ $d->namatarif }}</td>
        <td>{{ $d->dokter_pelaksana ? baca_dokter(@$d->dokter_pelaksana)  :'-' }}</td>
        <td>
          @if ($d->jenis == 'TA')
            Rawat Jalan
          @elseif ($d->jenis == 'TG')
            Rawat Darurat
          @elseif ($d->jenis == 'TI')
          

            @if ($d->poli_tipe == 'L')
              (Laboratorium)
            @elseif ($d->poli_tipe == 'R')
              (Radiologi)
            @elseif($d->poli_tipe == 'O')
              (Operasi)
            @else
              Rawat Inap
            @endif
          @elseif ($d->jenis == 'ORJ')
            Farmasi
          @endif
        </td>
        @if ($d->jenis == 'ORJ')
        <td class="text-right">{{ number_format($d->total - $d->dijamin,0,',','.') }}</td>
        
        @else
        <td class="text-right">{{ number_format($d->total - $d->dijamin,0,',','.') }}</td>
            
        @endif

        <td width="100px">
          {{ baca_carabayar($d->cara_bayar_id) }}
          {{-- <div class="form-group">
            {!! Form::select('bayar', $carabayar, $d->cara_bayar_id, ['class' => 'form-control select2', 'id' => $d->id, 'hidden'=>'hidden','selected'=>'selected']) !!}
          </div> --}}
        </td>
        {{-- <td>{{ baca_carabayar($d->cara_bayar_id) }}</td> --}}
        <td>{{ $d->user->name }}</td>
        <td>{{ date('d-m-Y H:i', strtotime($d->created_at)) }}</td>
        <td>{{ date('H:i', strtotime(@$d->waktu_visit)) }}</td>
        <td class="text-center">
          @if ($d->lunas == 'Y')
            <i class="fa fa-check"></i>
          @else
            <i class="fa fa-remove"></i>
          @endif
        </td>
        <!-- Inhealth sinkron -->
        <td class="text-center">
          {{-- @if( $d->cara_bayar_id == 8)
          <input type="hidden" name="no_sjp_inhealth" value="{{ isset($inhealth->no_sjp) ? $inhealth->no_sjp : null }}">
          <input type="hidden" name="jenis_pelayanan_inhealth" value="4">
          @php
            $kode_jenpel = \DB::table('tarifs')->where('id', $d->tarif_id)->first()->inhealth_jenpel;
          @endphp
          <input type="hidden" name="kode_tindakan_inhealth" value="{{ $kode_jenpel }}">
          <input type="hidden" name="tglmasukrawat" value="{{ $data['rawatinap']->tgl_masuk }}">
          <input type="hidden" name="dokter_pelaksana_inhealth" value="{{ $d->dokter_pelaksana }}">
          <input type="hidden" name="poli_inhealth" value="{{ $d->poli_id }}">
          <button id="btn-{{ $d->id }}" type="button" {{ ($d->sinkron_inhealth == "sinkron") ? "disabled" : "" }} {{ ($kode_jenpel==null) ? "disabled" : "" }} href="javascript:void(0)" data-id="{{ $d->id }}" class="btn btn-primary btn-sm btn-flat inhealth-tindakan"><i class="fa fa-check"></i></button>
          @endif --}}
        </td>
        <!-- Inhealth sinkron -->
        @role(['rawatinap', 'supervisor', 'administrator'])
        <td width="75px;" class="text-center">
          @if ($d->lunas == 'Y')
            <i class="fa fa-check"></i>
          @else
            @if ($d->tarif_id != 10000)
              <a class="btn btn-info btn-sm btn-flat" onclick="editTindakan({{ $d->id.','.$d->tarif_id }})"><i class="fa fa-edit"></i></a>
              <a href="{{ url('rawat-inap/hapus-tindakan/'.$d->id.'/'.$d->registrasi_id) }}" onclick="return confirm('Yakin akan di hapus?')" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-trash-o"></i></a>
            @endif
          @endif
        </td>
        <!-- Modal Update Tindakan-->
        {{-- <div class="modal fade" id="modalUpdateTindakan{{ $d->id }}" role="dialog" aria-labelledby="" aria-hidden="true">
          <div class="modal-dialog modal-lg">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="">Tambah Obat Racikan</h4>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-md-12">
                        <form method="POST" id="formUpdateJenisTindakan" class="form-horizontal">
                          {{ csrf_field() }}
                          {{ method_field('POST') }}
                          <input type="hidden" name="idJenisTindakan" id="idJenisTindakan{{ $d->id }}">
                          <div class="form-group row">
                            <div class="col-sm-12">
                              <label for="">Tindakan</label>
                              <input type="text" value="{{ $d->namatarif }}" class="form-control" disabled>
                            </div>
                          </div>
                          <div class="form-group row">
                            <div class="col-sm-12">
                              <label for="">Jenis Tindakan</label>
                              <br>
                              <select name="jenis_editModals" id="jenis_editModals{{ $d->id }}" class="form-control" onchange="setValueJenis(this.value)" required>
                                <option value="" selected disabled></option>
                                <option value="TG">Rawat Darurat</option>
                                <option value="TI">Rawat Inap</option>
                                <option value="TA">Rawat Jalan</option>
                              </select>
                            </div>
                          </div>
                          <div class="form-group row">
                            <div class="col-sm-12">
                              <label for="">Waktu</label>
                              <input type="text" value="{{ $d->created_at->format('d-m-Y') }}" class="form-control" disabled>
                            </div>
                          </div>
                          <div class="form-group row">
                            <div class="col-sm-12" style="text-align: right">
                                <button id="btn-save-resep-modal" class="btn btn-primary" type="button" onclick="editJenisTindakan({{ $d->id }})" >Perbarui Data</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
              </div>
          </div>
        </div> --}}
        <!-- End Modal UPDATE Tindakan-->
        @endrole
      </tr>
    @endforeach
      {{-- <tr>
        <td><button type="button" onclick="lunas()" class="btn btn-success btn-flat btn-sm"><i class="fa fa-check"></i></button></td>
        <td colspan="4">UPDATE TERBAYAR</td>
      @role(['administrator'])
        <td><button type="button" onclick="belumLunas()" class="btn btn-danger btn-flat btn-sm"><i class="fa fa-check"></i></button></td>
        <td colspan="4">UPDATE BELUM TERBAYAR</td>
      @endrole
      </tr> --}}
    </tbody>
  </table>
  </form>
  </div>
<script type="text/javascript">
  // $('.select2').select2();
  // var vals = '';
  $('select[name="bayar"]').on('change', function(){
    $.get('/rawat-inap/updateCaraBayar/'+$(this).attr('id')+'/'+$(this).val(), function(){
      location.reload();
    });
  })

  // function setValueJenis(val){
  //   vals = val;
  // }
  function lunas(){
    var data = $('#lunaskan').serialize();
    if(confirm('Yakin akan di lunaskan?')){
      $.post('/rawat-inap/lunas', data, function(resp){
        if(resp.sukses == true){
          location.reload()
        }
      })
    }
  }
  function belumLunas(){
    var data = $('#lunaskan').serialize();
    if(confirm('Yakin belum lunas?')){
      $.post('/rawat-inap/belumLunas', data, function(resp){
        if(resp.sukses == true){
          location.reload()
        }
      })
    }
  }

  // function editJenisTindakan(idJenisTindakan){
  //   var idJenis = idJenisTindakan;
  //   var jenis = vals;
  //   var dataForm = $('#formUpdateJenisTindakan').serialize();
  //   let dataForm = {
  //     "id" : idJenis,
  //     "jenis" : jenis,
  //     "_token" : $('input[name=_token]').val(),
  //   };
  //   console.log(dataForm);
  //   $.ajax({
  //     headers: {
  //       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
  //     },
  //     url: "/rawat-inap/edit-jenis-tindakan/"+idJenis,
  //     method: 'POST',
  //     dataType: 'json',
  //     data: dataForm,
  //   }).done(function(resp){
  //       if(resp.sukses == true){
  //         alert(resp.text);
  //         location.reload(true);
  //       }else{
  //         alert(resp.text);
  //       }
  //   });
  // }
</script>