@extends('master')

@section('header')
  <h1>SIPEKA</h1>
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="box box-primary">
  <div class="box-header with-border">
    <h4 class="box-title">Periode Tanggal</h4>
  </div>
  <div class="box-body">
    {!! Form::open(['method' => 'POST', 'url' => 'sipeka/dashboard', 'class'=>'form-horizontal']) !!}
      <div class="row">
        <div class="col-md-4">
          <div class="input-group">
            <span class="input-group-btn"><button class="btn btn-default" type="button">Tanggal</button></span>
            {!! Form::text('tga', request('tga'), ['class' => 'form-control datepicker']) !!}
          </div>
        </div>

        <div class="col-md-4">
          <div class="input-group">
            <span class="input-group-btn"><button class="btn btn-default" type="button">Sampai</button></span>
            {!! Form::text('tgb', request('tgb'), ['class' => 'form-control datepicker']) !!}
          </div>
        </div>

        <div class="col-md-4">
          <button type="submit" name="lanjut" value="1" class="btn btn-primary">Tampilkan</button>
          <button type="submit" name="pdf" value="1" class="btn btn-danger" formtarget="_blank">PDF</button>
          <button type="submit" name="excel" value="1" class="btn btn-success">Excel</button>
        </div>
      </div>
    {!! Form::close() !!}
    <hr>

    <div class='table-responsive'>
      <table class='table table-striped table-bordered table-hover table-condensed'>
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>No. HP</th>
            <th>Tanggal Kejadian</th>
            <th>Lokasi Kejadian</th>
            <th>Bagian Permasalahan</th>
            <th>Jenis Permasalahan Petugas/Karyawan</th>
            <th>Bidang Petugas/Karyawan</th>
            <th>Nama Petugas/Karyawan yang bersangkutan</th>
            <th>Fasilitas yang Bermasalah</th>
            <th>Jenis Permasalahan Fasilitas</th>
            <th>Jenis Permasalahan Administrasi</th>
            <th>Komplain</th>
            <th>Disposisi</th>
            <th>Dokumen</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @php $no = 1; @endphp
          @foreach ($sipeka as $d)
          <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $d->nama }}</td>
            <td>{{ $d->no_hp }}</td>
            <td>{{ $d->tanggal_kejadian }}</td>
            <td>{{ $d->lokasi_kejadian }}</td>
            <td>{{ $d->bagian_permasalahan }}</td>
            <td>
              @php $data = json_decode($d->jenis_permasalahan_petugas, true); @endphp
              @if(!empty($data))
                <ul style="margin: 0; padding-left: 20px;">
                  @foreach($data as $item)<li>{{ $item }}</li>@endforeach
                </ul>
              @endif
            </td>
            <td>{{ $d->bidang_petugas_karyawan }}</td>
            <td>{{ $d->nama_petugas_karyawan }}</td>
            <td>
              @php $data = json_decode($d->masalah_fasilitas, true); @endphp
              @if(!empty($data))
                <ul style="margin: 0; padding-left: 20px;">
                  @foreach($data as $item)<li>{{ $item }}</li>@endforeach
                </ul>
              @endif
            </td>
            <td>
              @php $data = json_decode($d->jenis_masalah_fasilitas, true); @endphp
              @if(!empty($data))
                <ul style="margin: 0; padding-left: 20px;">
                  @foreach($data as $item)<li>{{ $item }}</li>@endforeach
                </ul>
              @endif
            </td>
            <td>{{ $d->jenis_permasalahan_administrasi }}</td>
            <td>{{ $d->komplain }}</td>

            <td>
              {{-- STATUS & AKSI BERDASARKAN DISPOSISI --}}
              @if ($d->disposisi === null)
                {{-- STEP 1: Awal, Kasubag pilih bidang --}}
                @if (Auth::user()->id == 922)
                  <div class="dropdown">
                    <button class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown">
                      Verif Ke
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item btn btn-warning btn-sm" onclick="updateBidang({{ $d->id }}, 390, 'keuangan')">Keuangan</a>
                      <a class="dropdown-item btn btn-warning btn-sm" onclick="updateBidang({{ $d->id }}, 850, 'pelayanan medis')">Pelayanan Medis</a>
                      <a class="dropdown-item btn btn-warning btn-sm" onclick="updateBidang({{ $d->id }}, 1310, 'keperawatan')">Keperawatan</a>
                      <a class="dropdown-item btn btn-warning btn-sm" onclick="updateBidang({{ $d->id }}, 1306, 'penunjang medis')">Penunjang Medis</a>
                      <a class="dropdown-item btn btn-warning btn-sm" onclick="updateBidang({{ $d->id }}, 842, 'penunjang non medis')">Penunjang Non Medis</a>
                    </div>
                  </div>
                @else
                  <span class="badge badge-secondary">Menunggu Verifikasi Kasubag</span>
                @endif

              @elseif($d->disposisi == 1)
                {{-- STEP 2: Menunggu keputusan bidang --}}
                @if (Auth::user()->id == $d->user_bidang_id)
                  <button class="btn btn-success btn-sm" onclick="setujuKabid({{ $d->id }})">Dilanjutkan</button>
                  <button class="btn btn-danger btn-sm" onclick="tolakKabid({{ $d->id }})">Tidak Dilanjutkan</button>
                @else
                  <span class="badge badge-info">Menunggu keputusan {{ ucfirst(str_replace('_',' ',$d->bidang)) }}</span>
                @endif

              @elseif($d->disposisi == 2)
                {{-- STEP 3: Kasubag kirim ke Direktur --}}
                @if (Auth::user()->id == 922)
                  <button class="btn btn-primary btn-sm" onclick="kirimKeDirektur({{ $d->id }})">Kirim ke Direktur</button>
                @else
                  <span class="badge badge-warning">Menunggu Kasubag</span>
                @endif

              @elseif($d->disposisi == 4)
                <span class="badge badge-success">Selesai</span>

              @elseif($d->disposisi == 5)
                <span class="badge badge-danger">Tidak Dilanjutkan</span>
              @endif
            </td>
            <td>
              {{-- Jika Kabid (masing-masing bidang) --}}
              @if(Auth::user()->id == $d->user_bidang_id && in_array($d->disposisi, [1,2]))
                  @if ($d->disposisi == 1)
                    <button type="button" class="btn btn-sm btn-primary" 
                            onclick="document.getElementById('dokumen-{{ $d->id }}').click()">
                      Upload
                    </button>
                    <input type="file" id="dokumen-{{ $d->id }}" 
                          onchange="uploadDokumen({{ $d->id }})" style="display:none;">
                  @endif
                  @if ($d->dokumen)
                    <a href="{{ asset('dokumen_sipeka/'.$d->dokumen) }}" 
                      target="_blank" class="btn btn-sm btn-info">
                      Lihat
                    </a>
                  @endif

              {{-- Jika Kasubag (cek file) --}}
              @elseif(Auth::user()->id == 922 && $d->dokumen)
                  <a href="{{ asset('dokumen_sipeka/'.$d->dokumen) }}" 
                    target="_blank" class="btn btn-sm btn-info">
                    Lihat
                  </a>
                  <button class="btn btn-sm btn-warning" onclick="kembalikanKeKabid({{ $d->id }})">
                    Kembalikan
                  </button>

              {{-- Jika Direktur --}}
              @elseif(Auth::user()->id == 1309 && $d->disposisi == 4)
                  <a href="{{ asset('sipeka/laporan-pdf/'.$d->id) }}" 
                    target="_blank" class="btn btn-sm btn-danger">
                    Pdf
                  </a>

              {{-- Jika dokumen sudah ada tapi bukan Kasubag/Direktur --}}
              @elseif($d->dokumen)
                  <span class="badge badge-secondary">ada</span>

              {{-- Kalau belum ada dokumen sama sekali --}}
              @else
                  <span class="badge badge-secondary">Belum ada</span>
              @endif
            </td>
            <td>{{@$d->status}}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
  function updateBidang(id, user_id, bidang) {
    $.ajax({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      url: '/sipeka/update-bidang/' + id,
      type: "POST",
      data: { user_bidang_id: user_id, bidang: bidang },
      dataType: "json",
      success: function(data){
        alert('Berhasil dikirim ke bidang ' + bidang);
        location.reload();
      }
    });
  }

  function setujuKabid(id){ updateDisposisi(id, 2, "Proses"); }
  function tolakKabid(id){ updateDisposisi(id, 5, "Tidak Dilanjutkan"); }
  function kirimKeDirektur(id){ updateDisposisi(id, 4, "Selesai"); }

  // --- Core update ---
  function updateDisposisi(id, val, status = null){
    $.ajax({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      url: '/sipeka/update-disposisi/' + id,
      type: "POST",
      data: { disposisi: val, status: status },
      dataType: "json",
      success: function(data){
        alert('Proses berhasil');
        location.reload();
      }
    });
  }

  // --- Upload dokumen dari Kabid ---
  function uploadDokumen(id){
      let input = document.getElementById('dokumen-'+id);
      let file = input.files[0];
      let formData = new FormData();
      formData.append("dokumen", file);
      formData.append("_token", "{{ csrf_token() }}");

      fetch("{{ url('sipeka/upload-dokumen') }}/" + id, {
          method: "POST",
          body: formData
      })
      .then(res => res.json())
      .then(data => {
          alert("Upload berhasil!");
          location.reload();
      })
      .catch(err => alert("Upload gagal"));
  }

  // --- Kembalikan dari Kasubag ke Kabid ---
  function kembalikanKeKabid(id){
      if(confirm("Apakah anda yakin ingin mengembalikan dokumen?")){
          fetch("{{ url('sipeka/kembalikan-dokumen') }}/" + id, {
              method: "POST",
              headers: {
                  "X-CSRF-TOKEN": "{{ csrf_token() }}",
                  "Content-Type": "application/json"
              },
              body: JSON.stringify({ status: "Revisi" })
          })
          .then(res => res.json())
          .then(data => {
              alert("Dokumen berhasil dikembalikan.");
              location.reload();
          })
          .catch(err => alert("Gagal mengembalikan dokumen"));
      }
  }
</script>
@endsection