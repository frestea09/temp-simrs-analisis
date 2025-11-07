{{-- UPDATE SEP --}}
<div class="modal fade" id="modalUpdateSEP">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="formCariSEP">
          {{ csrf_field() }}
          <div class="form-group">
            <label for="noSEP" class="col-sm-3 control-label">No. SEP</label>
            <div class="col-sm-7">
              <input type="text" name="noSEP" class="form-control">
            </div>
            <div class="col-sm-2">
              <button type="button" class="btn btn-success btn-flat" onclick="updateSEP_Cari()"> <i class="fa fa-search"></i> CARI</button>
            </div>
          </div>
        </form>

        <div class="viewForm hidden">
          <form class="form-horizontal" id="formUpdateSEP">
            <div class="form-group">
              <label for="namaPasien" class="col-sm-3 control-label">Nama Pasien</label>
              <div class="col-sm-6">
                <input type="text" name="namaPasien" class="form-control" disabled="true">
              </div>
              <div class="col-sm-3">
                <input type="text" name="noMr" class="form-control" disabled="true">
              </div>
            </div>

            <div class="form-group">
              <label for="noSEP" class="col-sm-3 control-label">No. SEP</label>
              <div class="col-sm-9">
                <input type="text" name="noSep" class="form-control" readonly="true" >
              </div>
            </div>

             <div class="form-group">
              <label for="diagnosa" class="col-sm-3 control-label">Diagnosa Awal</label>
              <div class="col-sm-9">
                <input type="text" name="diagnosa" class="form-control" >
              </div>
            </div>

            <div class="form-group">
              <label for="catatan" class="col-sm-3 control-label">Catatan</label>
              <div class="col-sm-9">
                <input type="text" name="catatan" class="form-control" >
              </div>
            </div>

            <div class="form-group">
              <label for="kodeDPJP" class="col-sm-3 control-label">Dokter</label>
              <div class="col-sm-9">
                <select name="kodeDPJP" class="form-control select2" style="width: 100%">

                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="catatan" class="col-sm-3 control-label">Catatan</label>
              <div class="col-sm-9">
                <input type="text" name="catatan" class="form-control" >
              </div>
            </div>

          </form>
        </div>
      {{-- progress bar --}}
       <div class="progress progress-sm active hidden">
          <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
            <span class="sr-only">97% Complete</span>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-flat">Simpan</button>
      </div>
    </div>
  </div>
</div>


{{-- PENGAJUAN --}}
<div class="modal fade" id="sepPengajuan">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <form method="POST" id="formSepPengajuan" class="form-horizontal">
          {{ csrf_field() }} {{ method_field('POST') }}
          <div class="form-group nokaGroup">
            <label for="noKartu" class="col-sm-3 control-label">No. Kartu</label>
            <div class="col-sm-9">
              <input type="text" name="noKartu" maxlength="13" class="form-control">
              <small class="nokaError text-danger"></small>
            </div>
          </div>
          <div class="form-group tglSepGroup">
            <label for="tglSep" class="col-sm-3 control-label">Tanggal SEP</label>
            <div class="col-sm-9">
              <input type="text" name="tglSep" class="form-control datepicker">
              <small class="text-danger tglSepError"></small>
            </div>
          </div>
          <div class="form-group">
            <label for="jenisPelayanan" class="col-sm-3 control-label">Jenis Pelayanan</label>
            <div class="col-sm-9">
              <select name="jenisPelayanan" class="form-control select2" style="width: 100%">
                <option value="2">Rawat Jalan</option>
                <option value="1">Rawat Inap</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="jenisPengajuan" class="col-sm-3 control-label">Jenis Pengajuan</label>
            <div class="col-sm-9">
              <select name="jenisPengajuan" class="form-control select2" style="width: 100%">
                <option value="2">Pengajuan Finger Print</option>
                <option value="1">Pengajuan Backdate</option>
              </select>
            </div>
          </div>
          <div class="form-group keteranganGroup">
            <label for="keterangan" class="col-sm-3 control-label">Keterangan </label>
            <div class="col-sm-9">
              <input type="text" name="keterangan" class="form-control">
              <small class="text-danger keteranganError"></small>
            </div>
          </div>
        </form>

        {{-- progress bar --}}
       <div class="progress progress-sm active hidden">
          <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
            <span class="sr-only">97% Complete</span>
          </div>
        </div>
        <p class="respon text-center" style="font-weight: bold"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-flat" onclick="savePengajuan()">Simpan</button>
      </div>
    </div>
  </div>
</div>

{{-- APPROVAL --}}
<div class="modal fade" id="sepApproval">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-hover table-bordered table-condensed approval">
            <thead>
              <tr>
                <th>No. Kartu</th>
                <th>Tanggal</th>
                <th>Jenis Pelayanan</th>
                <th>Keterangan</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
        <br>
        {{-- progress bar --}}
       <div class="progress progress-sm active hidden">
          <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
            <span class="sr-only">97% Complete</span>
          </div>
        </div>
        <p class="respon text-center" style="font-weight: bold"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

{{-- UPDATE TGL PULANG --}}
<div class="modal fade" id="sepUpdateTglPulang">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <form method="POST" id="formsepUpdateTglPulang" class="form-horizontal">
          {{ csrf_field() }} {{ method_field('POST') }}
          <div class="form-group noSepGroup">
            <label for="noSEP" class="col-sm-3 control-label">No. SEP</label>
            <div class="col-sm-9">
              <input type="text" name="noSEP" class="form-control">
              <small class="text-danger noSepError"></small>
            </div>
          </div>
          <div class="form-group tglPulangGroup">
            <label for="tglPulang" class="col-sm-3 control-label">Tanggal Pulang</label>
            <div class="col-sm-9">
              <input type="text" name="tglPulang" class="form-control datepicker">
              <small class="text-danger tglPulangError"></small>
            </div>
          </div>
           <div class="form-group statusPulangGroup">
            <label for="statusPulang" class="col-sm-3 control-label">Status Pulang</label>
            <div class="col-sm-9">
              <select name="statusPulang" id="" onchange="kondisi(this)" class="form-control select2" style="width: 100%;">
                <option value=""></option>
              @foreach (\App\KondisiAkhirPasien::all() as $i)
                  <option value="{{ $i->id }}">{{ $i->namakondisi }}</option>
              @endforeach
              </select>
              <small class="text-danger statusPulang"></small>
            </div>
          </div> 
           <div class="form-group suratMeninggalGroup">
            <label for="suratMeninggal" class="col-sm-3 control-label">Surat Meninggal</label>
            <div class="col-sm-9">
              <input type="text" name="suratMeninggal" class="form-control" placeholder="diisi jika status pulang Meninggal, selain itu kosong">
            </div>
          </div>  
          <div class="form-group tglMeninggalGroup">
            <label for="tglMeninggal" class="col-sm-3 control-label">Tanggal Meninggal</label>
            <div class="col-sm-9">
              <input type="text" name="tglMeninggal" class="form-control datepicker" placeholder="diisi jika status pulang meninggal, selain itu kosong">
              <small class="text-danger tglMeninggalError"></small>
            </div>
          </div>
          <div class="form-group noLPManualGroup">
            <label for="noLPManual" class="col-sm-3 control-label">no.LP Manual</label>
            <div class="col-sm-9">
              <input type="text" name="noLPManual" class="form-control" placeholder="diisi jika SEPnya adalah KLL">
            </div>
          </div>  
        </form>
        {{-- progress bar --}}
       <div class="progress progress-sm active hidden">
          <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
            <span class="sr-only">97% Complete</span>
          </div>
        </div>
        <p class="respon text-center" style="font-weight: bold"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-flat" onclick="saveUpdateTanggalPulang()">Simpan</button>
      </div>
    </div>
  </div>
</div>

{{-- HAPUS SEP --}}
<div class="modal fade" id="sepHapus">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <form method="POST" id="formsepHapus" class="form-horizontal">
          {{ csrf_field() }} {{ method_field('POST') }}
          <div class="form-group noSEPGroup">
            <label for="noSEP" class="col-sm-3 control-label">No. SEP</label>
            <div class="col-sm-9">
              <input type="text" name="noSEP" class="form-control">
              <small class="text-danger noSEPError"></small>
            </div>
          </div>
        </form>
        {{-- progress bar --}}
       <div class="progress progress-sm active hidden">
          <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
            <span class="sr-only">97% Complete</span>
          </div>
        </div>
        <p class="respon text-center" style="font-weight: bold"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-flat" onclick="saveSepHapus()">Hapus</button>
      </div>
    </div>
  </div>
</div>

{{-- CARI SEP --}}
<div class="modal fade" id="sepCari">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <form method="POST" id="formsepCari" class="form-horizontal">
          {{ csrf_field() }} {{ method_field('POST') }}
          <div class="form-group noSEPGroup">
            <label for="noSEP" class="col-sm-3 control-label">No. SEP</label>
            <div class="col-sm-9">
              <input type="text" name="noSEP" class="form-control">
              <small class="text-danger noSEPError"></small>
            </div>
          </div>
        </form>
        {{-- progress bar --}}
       <div class="progress progress-sm active hidden">
          <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
            <span class="sr-only">97% Complete</span>
          </div>
        </div>
        <p class="respon text-center" style="font-weight: bold"></p>
        {{-- response --}}
        <div class="table-responsive sepResponse hidden">
          <table class="table table-bordered table-condensed">
            <tbody>
              <tr>
                <td style="width: 25%">Nama Pasien</td> <td class="respNama"></td>
              </tr>
              <tr>
                <td>No. Kartu</td> <td class="respNoka"></td>
              </tr>
              <tr>
                <td>No. Rujukan</td> <td class="respNoRujukan"></td>
              </tr>
              <tr>
                <td>No. RM</td> <td class="respMr"></td>
              </tr>
              <tr>
                <td>Tgl Lahir</td> <td class="respTglLhr"></td>
              </tr>
              <tr>
                <td>Jenis Pelayanan</td> <td class="respJnsPelayanan"></td>
              </tr>
              <tr>
                <td>Hak Kelas</td> <td class="respKelas"></td>
              </tr>
              <tr>
                <td>Jenis Peserta</td> <td class="respJenisPeserta"></td>
              </tr>
              <tr>
                <td>Catatan</td> <td class="respCatatan"></td>
              </tr>
              <tr>
                <td>Diagnosa</td> <td class="respDiagnosa"></td>
              </tr>
              <tr>
                <td>&nbsp;</td><td><button type="button" id="btnDelete" onclick="" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-trash"></i> HAPUS</button></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary btn-flat" onclick="saveCariSEP()">Cari</button>
      </div>
    </div>
  </div>
</div>

{{-- INSERT RUJUKAN KE RS LAIN --}}
<div class="modal fade" id="rujukanKeRSLain">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <form method="POST" class="form-horizontal" id="formRujukanKeRSLain">
          {{ csrf_field() }}
          <div class="form-group tipeRujukanGroup">
            <label for="tipeRujukan" class="col-sm-4 control-label">Tipe Rujukan</label>
            <div class="col-sm-8">
              <select name="tipeRujukan" class="form-control select2" onchange="rujukanTipe()" style="width: 100%">
                <option value="0">Penuh</option>
                <option value="1">Partial</option>
                <option value="2">Rujuk Balik</option>
              </select>
              <small class="text-danger tipeRujukanError"></small>
            </div>
          </div>
          <div class="form-group noSEPGroup">
            <label for="sep" class="col-sm-4 control-label">No. SEP</label>
            <div class="col-sm-8">
              <input type="text" name="noSEP" class="form-control">
              <small class="text-danger noSEPError"></small>
            </div>
          </div>
          <div class="form-group tglRujukanGroup">
            <label for="tglRujukan" class="col-sm-4 control-label">Tanggal Rujukan</label>
            <div class="col-sm-8">
              <input type="text" name="tglRujukan" value="{{ date('d-m-Y') }}" class="form-control datepicker">
              <small class="text-danger tglRujukanError"></small>
            </div>
          </div>
          <div class="form-group tglRencanaKunjunganGroup">
            <label for="tglRencanaKunjungan" class="col-sm-4 control-label">Tanggal Rencana Datang</label>
            <div class="col-sm-8">
              <input type="text" name="tglRencanaKunjungan" value="{{ date('d-m-Y') }}" class="form-control datepicker">
              <small class="text-danger tglRencanaKunjunganError"></small>
            </div>
          </div>
          <div class="form-group ppkDirujukGroup">
            <label for="ppkDirujuk" class="col-sm-4 control-label">PPK di Rujuk</label>
            <div class="col-sm-8">
              <select name="ppkDirujuk" id="ppkDirujuk" class="form-control" style="width: 100%;"></select>
              <small class="text-danger ppkDirujukError"></small>
            </div>
          </div>
          <div class="form-group jnsPelayananGroup">
            <label for="jnsPelayanan" class="col-sm-4 control-label">Jenis Pelayanan</label>
            <div class="col-sm-8">
              <select name="jnsPelayanan" class="form-control select2" onchange="rujukanTipe()" style="width: 100%">
                <option value="2">Rawat Jalan</option>
                <option value="1">Rawat Inap</option>
              </select>
              <small class="text-danger jnsPelayananError"></small>
            </div>
          </div>
          <div class="form-group catatanGroup">
            <label for="catatan" class="col-sm-4 control-label">Catatan</label>
            <div class="col-sm-8">
              <input type="text" name="catatan" class="form-control">
              <small class="text-danger catatanError"></small>
            </div>
          </div>
          <div class="form-group diagnosaRujukanGroup">
            <label for="diagRujukan" class="col-sm-4 control-label">Diagnosa Rujukan</label>
            <div class="col-sm-8">
              <input type="text" name="diagnosaRujukan" id="diagnosaRujukan" class="form-control">
              <small class="text-danger diagnosaRujukanError"></small>
            </div>
          </div>
      
          <div class="form-group poliRujukanGroup">
            <label for="poliRujukan" class="col-sm-4 control-label">Poli Rujukan</label>
            <div class="col-sm-8">
              <select name="poliRujukan" class="form-control select2" style="width: 100%">
              </select>
              <small class="text-danger poliRujukanError"></small>
            </div>
          </div>
        </form>
        {{-- progress bar --}}
       <div class="progress progress-sm active hidden">
          <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
            <span class="sr-only">97% Complete</span>
          </div>
        </div>
        <p class="respon text-center" style="font-weight: bold"></p>
        {{-- response --}}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-flat" onclick="saveRujukKeRSLain()">Simpan</button>
      </div>
    </div>
  </div>
</div>
<script>
  function rujukanTipe(){
    console.log('masuk');
    var jenis = $('select[name="jnsPelayanan"]').val(),
        tipe = $('select[name="tipeRujukan"]').val();
    if(jenis == 1 && tipe == 2){
      $('.poliRujukanGroup').hide();
    }else{
      $('.poliRujukanGroup').show();
    }
  }
</script>



