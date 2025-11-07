@extends('master')
@section('header')
  <h1>Pegawai Rumah Sakit</h1>
@endsection
@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data Pegawai &nbsp;
          <a href="{{ route('pegawai.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
        <div class='table-responsive'>
          <div id="alert-box"></div>
          <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Satu Sehat</th>
                <th>Kuota Poli</th>
                <th>Kode Antrian</th>
                {{-- <th>TTL</th>
                <th>Kelamin</th>
                <th>Agama</th>
                <th>Alamat</th> --}}
                {{-- <th>Alamat</th>
                <th>SIP</th>
                <th>STR</th>
                <th>Kompetensi</th>
                <th>Tupoksi</th>
                <th>Inhealth</th>
                <th>PoliType</th>
                <th>TTD</th> --}}
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($pegawai as $key => $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $d->nama }}</td>
                  <td>{{ @$d->id_dokterss }}</td>
                  <td>{{$d->kuota_poli}}</td>
                  <td>{{$d->kode_antrian}}</td>
                  <td class="text-center">
                    <a href="{{ route('pegawai.edit', $d->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                    <a href="{{ route('pegawai.destroy', $d->id) }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                    <button type="button"
                            class="btn btn-success btn-sm btn-kuota"
                            data-id="{{ $d->id }}"
                            data-nama="{{ $d->nama }}"
                            data-kuota="{{ $d->kuota_poli }}">
                        <i class="fa fa-user"></i>
                    </button>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <div class="modal fade" id="kuotaModal" tabindex="-1" role="dialog" aria-labelledby="kuotaModalLabel">
          <div class="modal-dialog" role="document">
            <form id="formKuota">
              @csrf
              <input type="hidden" name="id" id="kuota_id">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title" id="kuotaModalLabel">Ubah Kuota Poli</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label>Nama Dokter</label>
                    <input type="text" class="form-control" id="kuota_nama" readonly>
                  </div>
                  <div class="form-group">
                    <label>Kuota Poli</label>
                    
                    <input type="number" class="form-control" name="kuota_poli" id="kuota_poli" required placeholder="Masukkan kuota baru">
                    <small class="form-text text-muted">
                      Kuota saat ini: <strong><span id="kuota_saat_ini"></span></strong>
                    </small>

                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Simpan</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
              </div>
            </form>
          </div>
        </div>

        </div>
      </div>
    </div>
@stop

@section('script')
<script>
  $(document).ready(function () {
    
    $('.btn-kuota').click(function () {
      $('#kuota_id').val($(this).data('id'));
      $('#kuota_nama').val($(this).data('nama'));
      // $('#kuota_poli').val($(this).data('kuota'));
      $('#kuota_poli').val(''); 
      $('#kuota_saat_ini').text($(this).data('kuota')); // ← Tambahkan ini
      $('#kuotaModal').modal('show');
    });

    // AJAX form submission
    $('#formKuota').submit(function (e) {
      e.preventDefault(); // stop form submit

      const formData = $(this).serialize();
      $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
      $.ajax({
        url: '{{ route("pegawai.update.kuota") }}',
        type: 'POST',
        data: formData,
        success: function (response) {
          $('#kuotaModal').modal('hide');

          // Update kuota langsung di tabel
          const pegawaiId = $('#kuota_id').val();
          const kuotaBaru = $('#kuota_poli').val();
          $("button[data-id='" + pegawaiId + "']").closest('tr').find('td:nth-child(4)').text(kuotaBaru);

          // Tampilkan alert sukses
          $('#alert-box').html(`<div class="alert alert-success alert-dismissible">
              Kuota berhasil diperbarui.
              <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>`);
        },
        error: function (xhr) {
          alert('Terjadi kesalahan saat menyimpan data.');
        }
      });
    });
  });
</script>
@endsection


