<button type="button" id="historiAskeb" data-pasienID="{{ $reg->pasien_id }}"
  class="btn btn-md btn-info">
  <i class="fa fa-th-list"></i> Asuhan Kebidanan Sebelumnya
</button>

{{-- Modal Histori Askep --}}
<div class="modal fade" id="showHistoriAskeb" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="">Asuhan Kebidanan Sebelumnya</h4>
          </div>
          <div class="modal-body">
              <div id="dataHistoriAskeb">
                  <div class="spinner-square">
                      <div class="square-1 square"></div>
                      <div class="square-2 square"></div>
                      <div class="square-3 square"></div>
                  </div>
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
          </div>
      </div>
  </div>
</div>
{{-- End Modal Histori Askep --}}

<h5><b>Jam Tindakan</b></h5>
<table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
  <tr>
    <td style="padding: 5px; width: auto;">
      <input type="datetime-local" name="jam_tindakan[]" style="width: 85%; display: inline-block;" class="form-control">
      <button type="button" class="btn btn-success btn-flat btn-sm" style="" onclick="cloneJamTindakan()">Tambah</button>
    </td>
  </tr>
  <tr id="template-jam-tindakan" style="display: none;">
    <td style="padding: 5px; width: auto;">
      <input type="datetime-local" name="jam_tindakan[]" style="width: 85%; display: inline-block;" class="form-control new-jam-tindakan" disabled>
    </td>
  </tr>
</table>
<h5><b>Tindakan</b></h5>
<table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
  <tr>
    <td style="padding: 5px; width: auto;">
      <input type="text" name="keterangan[]" style="width: 85%; display: inline-block;" class="form-control">
      <button type="button" class="btn btn-success btn-flat btn-sm" style="" onclick="cloneKeterangan()">Tambah</button>
    </td>
  </tr>
  <tr id="template-keterangan" style="display: none;">
    <td style="padding: 5px; width: auto;">
      <input type="text" name="keterangan[]" style="width: 85%; display: inline-block;" class="form-control new-keterangan" disabled>
    </td>
  </tr>
</table>

<h5><b>Diagnosa</b></h5>
<table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
  <tr>
    <td style="padding:5px;">
      <select class="form-control select2-diagnosis" name="diagnosa[]" id="select2-diagnosis" style="width: 100%;">
          <option value="">-- Pilih --</option>
        @foreach ($diagnosaKeperawatan as $data)
          <option value="{{ $data->nama }}">{{ $data->nama.' ('.$data->kode.')' }}</option>
        @endforeach
      </select>
      <button type="button" class="btn btn-success btn-flat btn-sm" onclick="cloneDiagnosis()">Tambah</button>
    </td>
  </tr>
  <tr id="template-diagnosis" style="display: none;">
    <td style="padding: 5px;">
      <select name="diagnosa[]" class="form-control new-diagnosa" style="width: 350px;" disabled onchange="getAskep()">
        <option value="">-- Pilih</option>
        @foreach ($diagnosaKeperawatan as $data)
          <option value="{{ $data->nama }}">{{ $data->nama.' ('.$data->kode.')' }}</option>
        @endforeach
      </select>
    </td>
  </tr>
  <tr>
    <td style="font-weight: bold;">Diagnosa Yang Telah Dipilih :</td>
  </tr>
  <tr>
    <td>
      @if (@$diagnosis != null)
        @foreach (@$diagnosis as $diagnosa)
        - {{ $diagnosa }} <br>
        @endforeach
      @else
        <i>Belum Ada Yang Dipilih</i>
      @endif
    </td>
  </tr>
</table>

<h5><b>Intervensi</b></h5>
<table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
  <tr>
    <td style="padding:5px;">
      <select class="form-control select2-pemeriksaanDalam" name="pemeriksaanDalam[]" multiple="multiple" id="select2-pemeriksaanDalam"  style="width: 100%;">
      </select>
    </td>
  </tr>
  <tr>
    <td style="font-weight: bold;">Intervensi Yang Telah Dipilih :</td>
  </tr>
  <tr>
    <td>
      @if (@$siki != null)
        @foreach (@$siki as $siki)
        * {{ $siki }} <br>
        @endforeach
      @else
        <i>Belum Ada Yang Dipilih</i>
      @endif
    </td>
  </tr>
</table>

<h5><b>Implementasi</b></h5>
<table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
  <tr>
    <td style="padding:5px;">
      <select class="form-control select2-fungsional" name="fungsional[]" multiple="multiple" id="select2-fungsional"  style="width: 100%;">
      </select>
    </td>
  </tr>
  <tr>
    <td style="font-weight: bold;">Implementasi Yang Telah Dipilih :</td>
  </tr>
  <tr>
    <td>
      @if (@$implementasi != null)
        @foreach (@$implementasi as $i)
        * {{ $i }} <br>
        @endforeach
      @else
        <i>Belum Ada Yang Dipilih</i>
      @endif
    </td>
  </tr>
</table>

<script>
  function cloneDiagnosis() {
      let templateElement = $('#template-diagnosis');
      let clonedElement = templateElement.clone(); // Clone the template element
      clonedElement.removeAttr('id'); // Remove id attribute to avoid duplicate ids
      clonedElement.show(); // Ensure the cloned element is visible (if it was hidden)

      clonedElement.find('.new-diagnosa').select2({
          placeholder: "Pilih Diagnosa",
          allowClear: true,
          width: '85%'
      });
      clonedElement.find('.new-diagnosa').attr('disabled', false);

      clonedElement.insertBefore(templateElement);
  }

  function cloneJamTindakan() {
      let templateElement = $('#template-jam-tindakan');
      let clonedElement = templateElement.clone(); // Clone the template element
      clonedElement.removeAttr('id'); // Remove id attribute to avoid duplicate ids
      clonedElement.show(); // Ensure the cloned element is visible (if it was hidden)

      clonedElement.find('.new-jam-tindakan').attr('disabled', false);

      clonedElement.insertBefore(templateElement);
  }

  function getAskep() {
      let diagnosis = [];
      $('select[name="assesment[]"]:not([disabled]').each(function (i) {
      if ($(this).val() != '') {
          diagnosis.push($(this).val());
      }
      })

      var planning = $('#select-planning');
      var implementasi = $('#select-implementasi');
      let diagnosa = diagnosis.join("|");

      planning.empty();
      implementasi.empty();

      $.ajax({
      url: '/emr-get-askep?multiple=true&namaDiagnosa='+diagnosa,
      type: 'get',
      dataType: 'json',
      })
      .done(function(res) {
      if(res[0].metadata.code == 200){
          $.each(res[1], function(index, val){
          planning.append('<option value="'+ val.namaIntervensi +'">'+ val.namaIntervensi +'</option>');
          })
          $.each(res[2], function(index, val){
          implementasi.append('<option value="'+ val.namaImplementasi +'">'+ val.namaImplementasi +'</option>');
          })
      }
      })
      
  };


  function cloneKeterangan() {
        let templateElement = $('#template-keterangan');
        let clonedElement = templateElement.clone();
        clonedElement.removeAttr('id');
        clonedElement.show();

        clonedElement.find('.new-keterangan').attr('disabled', false);

        clonedElement.insertBefore(templateElement);
    }
</script>