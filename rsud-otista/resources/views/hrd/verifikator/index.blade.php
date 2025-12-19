@extends('master')

@section('header')
  <h1>Persetujuan Cuti Pegawai</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
        <table class="table table-hover table-bordered">
            <thead>
            <tr>
                <th>No</th>
                <th>Nama Pegawai</th>
                <th>Jabatan</th>
                <th>Jenis Cuti</th>
                <th>Tanggal Cuti</th>
                <th>Alamat</th>
                <th>Telp</th>
                <th>Alasan Cuti</th>
                <th>Alasan Verifikator</th>
                <th>Status</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
              @forelse( $data as $key => $d )
                <tr>
                  <td>{{ $key + 1 }}</td>
                  <td>{{ $d->cuti->pegawai->nama }} {{ $d->id }}</td>
                  <td>{{ $d->cuti->pegawai->struktur->nama }}</td>
                  <td>{{ $d->cuti->jenis_cuti->nama }}</td>
                  <td>
                    {{ \Carbon\Carbon::parse($d->cuti->tglmulai)->format('d-m-Y') }} - {{ \Carbon\Carbon::parse($d->cuti->tglselesai)->format('d-m-Y') }}<br>
                    <span class="text-center">{{ $d->cuti->lama_cuti }} Hari</span>
                  </td>
                  <td>{{ $d->cuti->alamat_cuti }}</td>
                  <td>{{ $d->cuti->telepon }}</td>
                  <td>{{ $d->cuti->alasan_cuti }}</td>
                  <td>
                    {{ $d->alasan }}
                    @if( $d->status == "ditangguhkan" || $d->status == "perubahan" )
                      <p><b>{{ $d->status }}</b> Tgl Awal : {{ \Carbon\Carbon::parse($d->tgl_awal)->format('d-m-Y')}}</p>
                      <p><b>{{ $d->status }}</b> Tgl Akhir : {{ \Carbon\Carbon::parse($d->tgl_akhir)->format('d-m-Y')}}</p>
                    @endif
                  </td>
                  <td>
                    @if( $d->status == "menunggu" )
                      <span class="label label-default">{{ $d->status }}</span>
                    @elseif( $d->status == "disetujui" )
                      <span class="label label-success">{{ $d->status }}</span>
                    @elseif( $d->status == "ditolak" )
                      <span class="label label-danger">{{ $d->status }}</span>
                    @else
                      <span class="label label-warning">{{ $d->status }}</span>
                    @endif
                  </td>
                  <td>
                    @if( $d->status_final == "menunggu" )
                      <span class="label label-default">{{ $d->status_final }}</span>
                    @elseif( $d->status_final == "disetujui" )
                      <span class="label label-success">{{ $d->status_final }}</span>
                    @elseif( $d->status_final == "ditolak" )
                      <span class="label label-danger">{{ $d->status_final }}</span>
                    @else
                      <span class="label label-warning">{{ $d->status_final }}</span>
                    @endif
                  </td>
                  <td>
                    {{-- @if($d->status == "ditolak")
                      <div class="btn-group"> 
                        <button type="button" data-id="{{ $d->id }}" data-nama="{{ $d->cuti->pegawai->nama }}" class="btn btn-success btn-flat btn-sm btn-action">
                          <i class="fa fa-check-square"></i>
                        </button> 
                      </div>
                    @else
                      @if( $d->status_final != "ditolak")
                      <div class="btn-group"> 
                        <button type="button" data-id="{{ $d->id }}" data-nama="{{ $d->cuti->pegawai->nama }}" class="btn btn-success btn-flat btn-sm btn-action">
                          <i class="fa fa-check-square"></i>
                        </button> 
                      </div>
                      @endif
                    @endif --}}
                    @if($d->tampil == "Y")
                    <div class="btn-group"> 
                      <button type="button" data-id="{{ $d->id }}" data-nama="{{ $d->cuti->pegawai->nama }}" class="btn btn-success btn-flat btn-sm btn-action">
                        <i class="fa fa-check-square"></i>
                      </button> 
                    </div>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="10" class="text-center">Data Tidak Ditemukan</td>
                </tr>
              @endforelse
            </tbody>
        </table>
    </div>
  </div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <form method="POST" action="{{ url('hrd/cuti/verifikator') }}">
        {!! csrf_field() !!}
        <input type="hidden" name="id" value="">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Persetujuan Cuti - <span id="nm"></span></h4>
      </div>
      <div class="modal-body" style="display: flow-root;">
        <div class="form-group">
          <label>Status</label>
          <select class="form-control select2" name="status" required>
            <option disabled selected>- Silahkan Pilih -</option>
            <option value="disetujui">Disetujui</option>
            <option value="ditangguhkan">Ditangguhkan</option>
            <option value="perubahan">Perubahan</option>
            <option value="ditolak">Tidak Disetujui</option>
          </select>
        </div>
        <section id="div-tgl" style="display:none;">
          <div class="form-group" >
            <label>Tgl. Mulai</label>
            <div class="tglmulaiGroup">
                <input type="text" name="tgl_awal" class="form-control datepicker">
                <small class="text-danger tglmulaiError"></small>
            </div>
          </div>
          <div class="form-group">
            <label>Tgl. Selesai</label>
            <div class="tglselesaiGroup">
                <input type="text" name="tgl_akhir" class="form-control datepicker">
                <small class="text-danger tglselesaiError"></small>
            </div>
          </div>
          </section>
        <div class="form-group" id="div-alasan" style="display:none;">
          <label>Alasan</label>
            <textarea class="form-control" name="alasan"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
      </form>
    </div>

  </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
  $(document).on('click','.btn-action',function(){
    let id = $(this).attr('data-id');
    let nama = $(this).attr('data-nama');
    $('#nm').html(nama);
    $('input[name="id"]').val(id);
    $('#div-alasan').hide();
    $('#myModal').modal('show');
  })

  $(document).on('change','select[name="status"]',function(){
    if( this.value == "ditolak" ){
      $('#div-alasan').show();
      $('#div-tgl').hide();
    }else if( this.value == "ditangguhkan"){
      $('#div-alasan').show();
      $('#div-tgl').show();
    }else if( this.value == "perubahan"){
      $('#div-alasan').show();
      $('#div-tgl').show();
    }else if( this.value == "disetujui"){
      $('#div-alasan').hide();
      $('#div-tgl').hide();
    }
  })
</script>
@endsection
