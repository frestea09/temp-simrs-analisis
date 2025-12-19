@extends('master')
@section('header')
  <h1>Bridging E-Klaim Rawat Jalan dan Rawat Darurat<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    @php
        $coder = !empty(Auth::user()->coder_nik) ? Auth::user()->coder_nik : config('app.coder_nik');
    @endphp

    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'frontoffice/e-claim/dataRawatJalan', 'class'=>'form-hosizontal']) !!}
      <div class="row">

        <div class="col-sm-6">
          <div class="input-group{{ $errors->has('no_rm') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('no_rm') ? ' has-error' : '' }}" type="button">No. RM</button>
              </span>
              {{-- {!! Form::text('no_rm', null, ['class' => 'form-control']) !!} --}}
              <select name="no_rm" class="form-control" id="selectRM" onchange="this.form.submit()">
              </select>
              <small class="text-danger">{{ $errors->first('no_rm') }}</small>
          </div>
        </div>

        {{-- <div class="col-sm-3">
          <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-search"></i> CARI</button>
        </div> --}}

        </div>
      {!! Form::close() !!}
      <hr>
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' id="data">
          <thead>
            <tr>
              <th>No. RM</th>
              <th>Nama Pasien</th>
              <th>Poli</th>
              <th>DPJP</th>
              <th>SEP (INACBG)</th>
              <th>SEP (IDRG)</th>
              <th>Tgl Reg</th>
              @role('administrator')
                <th>Status</th>
              @endrole
              {{-- <th class="text-center">Proses</th> --}}
              <th class="text-center">Cetak</th>
              <th>Final</th>
              <th>Hapus</th>
              <th>Upload</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($reg as $key => $d)
              <tr>
                <td>{{ $d->no_rm }}</td>
                <td>
                  @php
                      $icd10 = App\PerawatanIcd10::where('registrasi_id',$d->id)->first();
                      // dd($icd10);
                      $icd9 = App\PerawatanIcd9::where('registrasi_id',$d->id)->first();
                  @endphp
                  @if ($icd10 || $icd9)
                  <span style="color:green"><b>{{ @$d->nama }}</b></span>
                  @else
                  {{ @$d->nama }}
                  @endif
                </td>
                {{-- <td>{{ $d->nama }}</td> --}}
                <td>{{ !empty($d->poli_id) ? strtoupper($d->poli->nama) : '' }}</td>
                <td>{{ baca_dokter($d->dokter_id) }}</td>
                <td>
                  @if ($d->no_sep <> '')
                    @if (\App\Inacbg::where('registrasi_id', $d->id)->count() == 1)
                      <a href="{{ url('frontoffice/e-claim/bridging/'.$d->id.'/?edit=1') }}" class="btn btn-default btn-sm btn-flat" title="EDIT KLAIM"><b>{{ $d->no_sep }}</b></a>
                    @else
                      <a href="{{ url('frontoffice/e-claim/bridging/'.$d->id) }}" class="btn btn-default btn-sm btn-flat"><b>{{ $d->no_sep }}</b></a>
                    @endif
                  @else
                    @if (\App\Inacbg::where('registrasi_id', $d->id)->count() == 1)
                      <a href="{{ url('frontoffice/e-claim/bridging/'.$d->id.'/?edit=1') }}" class="btn btn-default btn-sm btn-flat" title="EDIT KLAIM"><b>EDIT KLAIM</b></a>
                    @else
                      <a href="{{ url('frontoffice/e-claim/bridging/'.$d->id) }}" class="btn btn-default btn-sm btn-flat"><b>PROSES</b></a>
                    @endif
                  @endif
                </td>
               
               
                <td>
                  @if ($d->no_sep <> '')
                    @if (\App\Inacbg::where('registrasi_id', $d->id)->count() == 1)
                      <a href="{{ url('frontoffice/e-claim/bridging-idrg/'.$d->id.'/?edit=1') }}" class="btn btn-default btn-sm btn-flat" title="EDIT KLAIM"><b>{{ $d->no_sep }}</b></a>
                    @else
                      <a href="{{ url('frontoffice/e-claim/bridging-idrg/'.$d->id) }}" class="btn btn-default btn-sm btn-flat"><b>{{ $d->no_sep }}</b></a>
                    @endif
                  @else
                    @if (\App\Inacbg::where('registrasi_id', $d->id)->count() == 1)
                      <a href="{{ url('frontoffice/e-claim/bridging-idrg/'.$d->id.'/?edit=1') }}" class="btn btn-default btn-sm btn-flat" title="EDIT KLAIM"><b>EDIT KLAIM</b></a>
                    @else
                      <a href="{{ url('frontoffice/e-claim/bridging-idrg/'.$d->id) }}" class="btn btn-default btn-sm btn-flat"><b>PROSES</b></a>
                    @endif
                  @endif
                </td>
                <td>{{ $d->created_at->format('d-m-Y H:i:s') }}</td>
                @role('administrator')
                  <td>
                    <button class="btn btn-flat btn-sm btn-success" onclick="statusInaCbg({{ $d->id }})"><i class="fa fa-folder-open"></i></button>
                  </td>
                @endrole

                {{-- <td class="text-center">
                  @if (\App\Inacbg::where('registrasi_id', $d->id)->count() == 1)
                    <a href="{{ url('frontoffice/e-claim/bridging/'.$d->id.'/?edit=1') }}" class="btn btn-default btn-sm btn-flat" title="EDIT KLAIM"><i class="fa fa-check"></i></a>
                  @else
                    <a href="{{ url('frontoffice/e-claim/bridging/'.$d->id) }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-flash"></i></a>
                  @endif
                </td> --}}
                <td class="text-center">
                  @if (\App\Inacbg::where('registrasi_id', $d->id)->count() == 1)
                    <a href="{{ url('/eklaim-detail-bridging/'.$d->id) }}" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-print"></i></a>
                  @endif
                </td>
                <td>
                  @if (\App\Inacbg::where('registrasi_id', $d->id)->count() == 1)
                    <button type="button" onclick="finalKlaim({{ $d->id }})" class="btn btn-sm btn-success btn-flat"><i class="fa  fa-paper-plane-o"></i></button>
                  @endif
                </td>
                <td class="text-center">
                  @if (\App\Inacbg::where('registrasi_id', $d->id)->count() == 1)
                    <button class="btn btn-danger btn-flat btn-sm" onclick="hapusClaim('{{ $d->no_sep }}', '{{ $coder }}')"><i class="fa fa-remove"></i></button>
                  @endif
                </td>
                <td>
                  <a href="{{ url('frontoffice/uploadDokument/'.$d->id) }}" class="btn btn-sm btn-flat btn-warning"><i class="fa fa-upload"></i></a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      {{-- Modal Final Claim --}}
      <div class="modal fade" id="finalKlaimModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
              <div class="table-responsive">
                <table class="table table-hover table-condensed table-bordered">
                  <tbody>
                    <tr>
                      <td>Nama Pasien</td><td id="namaPasien"></td>
                    </tr>
                    <tr>
                      <td>No. RM</td><td id="noMR"></td>
                    </tr>
                    <tr>
                      <td>No. JKN</td><td id="noJkn"></td>
                    </tr>
                    <tr>
                      <td>No. SEP</td><td id="noSep"></td>
                    </tr>
                    <tr>
                      <td>Dokter</td><td id="dokter"></td>
                    </tr>
                    <tr>
                      <td>Diagnosa</td><td id="diagnosa"></td>
                    </tr>
                    <tr>
                      <td>Prosedur</td><td id="prosedur"></td>
                    </tr>
                    <tr>
                      <td>Biaya Rumah Sakit</td><td id="totalRS"></td>
                    </tr>
                    <tr>
                      <td>Dijamin</td><td id="dijamin"></td>
                    </tr>
                    <tr>
                      <td>Kode Grouper</td><td id="kodeGrouper"></td>
                    </tr>
                    <tr>
                      <td>Grouper</td><td id="grouper"></td>
                    </tr>
                    <tr>
                      <td>Deskripsi</td><td id="description"></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary btn-flat" id="tbFinal" onclick="">Final dan Kirim DC</button>
            </div>
          </div>
        </div>
      </div>

    </div>
    <div class="box-footer">
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="statusInaCbg" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <div class="table-responsive">
            <table class="table table-bordered table-condensed">
              <thead class="thead-light">
                <tr>
                  <th>No.</th>
                  <th>Nama</th>
                  <th>No. RM</th>
                  <th>No. Kartu</th>
                  <th>No. SEP</th>
                  <th>Kls Rawat</th>
                  <th>Dokter</th>
                  <th>Total RS</th>
                  <th>Diagnosa</th>
                  <th>Prosedur</th>
                  <th>Kd Gruper</th>
                  <th>Dijamin</th>
                  <th>Petugas</th>
                  <th>Hapus</th>
                </tr>
              </thead>
              <tbody id="viewInacbg">
              </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary btn-flat">Save</button>
        </div>
      </div>
    </div>
  </div>


@endsection

@section('script')
  <script type="text/javascript">
    function ribuan(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    $('#selectRM').select2({
      placeholder: "Pilih No Rm...",
      ajax: {
          url: '/pasien/master-pasien/',
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

    function finalKlaim(registrasi_id) {
      $('#finalKlaimModal').modal('show')
      $('.modal-title').text('Final Klaim & Kirim DC')
      $.ajax({
        url: '/inacbg/get-dataklaim/'+registrasi_id,
        type: 'GET',
        dataType: 'json',
      })
      .done(function(resp) {
        $('#namaPasien').text(resp.pasien_nama)
        $('#noMR').text(resp.no_rm)
        $('#noJkn').text(resp.no_kartu)
        $('#noSep').text(resp.no_sep)
        $('#dokter').text(resp.dokter)
        $('#diagnosa').text(resp.icd1)
        $('#prosedur').text(resp.prosedur1)
        $('#totalRS').text(resp.total_rs)
        $('#dijamin').text(resp.dijamin)
        $('#kodeGrouper').text(resp.kode)
        $('#grouper').text(resp.who_update)
        $('#description').text(resp.deskripsi_grouper)
        $('#tbFinal').attr('onclick', 'saveFinalKlaim("'+resp.no_sep+'", "{{ $coder }}")');
      });
    }

    function saveFinalKlaim(no_sep, coder_nik) {
      $.ajax({
        url: '/inacbg/save-final-klaim/'+no_sep+'/'+coder_nik,
        type: 'GET',
        dataType: 'json',
      })
      .done(function(resp) {
        if (resp.sukses == true) {
          $('#finalKlaimModal').modal('hide')
          alert('No. SEP '+resp.no_sep+' sdh di Kirim DC')
        }
      });
    }

    function statusInaCbg(registrasi_id){
      $('#statusInaCbg').modal('show')
      $('.modal-title').text('Status Grouper InaCbg')
      $.ajax({
        url: '/inacbg/get-status-klaim/'+registrasi_id,
        type: 'GET',
        dataType: 'json',
      })
      .done(function(resp){
        $('#viewInacbg').empty()
        $.each(resp, function(index, val){
          var dijamin = (val.dijamin != null) ? ribuan(val.dijamin) : null
          var btn = '<button class="btn btn-sm btn-danger btn-flat" onclick="hapusInacbg('+val.id+')"><i class="fa fa-trash"></i></button>'
          var hapus = (val.kode == null ) ? btn : '<i class="fa fa-check"></i>'
          $('#viewInacbg').append('<tr> <td>'+(index +1)+'</td> <td>'+val.pasien_nama+'</td>  <td>'+val.no_rm+'</td>  <td>'+val.no_kartu+'</td> <td>'+val.no_sep+'</td> <td>'+val.kelas_perawatan+'</td> <td>'+val.dokter+'</td> <td>'+ribuan(val.total_rs)+'</td> <td>'+val.icd1+'</td> <td>'+val.prosedur1+'</td> <td>'+val.kode+'</td> <td>'+dijamin+'</td> <td>'+val.who_update+'</td> <td class="text text-center">'+hapus+'</td> </tr>')
        })
      })
    }

    function hapusInacbg(id){
      if(confirm("Yakin akan di hapus? Pastikan data yang di hapus adalah data salah!")){
        $.ajax({
          url: '/inacbg/delete-inacbg/'+id,
          type: 'GET',
          dataType: 'json',
        })
        .done(function(resp){
          if (resp.sukses == true){
            statusInaCbg({{ session('registrasi_id') }})
          }
        })
      }
    }

    function hapusClaim(no_sep, coder){
      if(confirm('Yakin akan di hapus?')){
        $.get('/inacbg/hapus-klaim/'+no_sep+'/'+coder, function(resp){
          if(resp.proses == true){
            location.reload()
          }
        })
      }
    }
  </script>
@endsection
