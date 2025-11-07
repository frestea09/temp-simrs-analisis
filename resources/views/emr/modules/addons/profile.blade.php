@php

  $poli = request()->get('poli');
  $dpjp = request()->get('dpjp');
  $gizi = request()->get('gizi');
@endphp

<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="row">
    <div class="col-md-12">
      @if ($unit == 'jalan')
        @php
              $poli_id = Auth::user()->poli_id;
              $currentUrl = url()->current();

              $next = App\HistorikunjunganIRJ::leftJoin('registrasis', 'histori_kunjungan_irj.registrasi_id', '=', 'registrasis.id')
                ->whereNull('registrasis.deleted_at')
                ->orderBy('histori_kunjungan_irj.created_at', 'ASC')
                ->where('registrasis.id', '>', @$reg->id);

              if ($poli_id != '') {
                $poli_id = explode(",", $poli_id);
                $next = $next->whereIn('histori_kunjungan_irj.poli_id', $poli_id);
              }

              $next = $next->select('histori_kunjungan_irj.*', 'registrasis.id as reg_id', 'registrasis.dokter_id as dokter_id')->first();

              $url = str_replace(@$reg->id, @$next->registrasi_id, @$currentUrl);

        @endphp
        @if (isset($next) && $reg->id != $next->registrasi_id)
          <a href="{{$url . "?poli=$next->poli_id&dpjp=$next->dokter_id"}}" class="btn btn-primary btn-sm" data-registrasi-id="{{$next->registrasi_id}}" style="margin-bottom: .5rem;">Next : {{baca_pasien($next->pasien_id)}}</a>
        @endif
      @endif
        <!-- Widget: user widget style 1 -->
        <div class="box box-widget widget-user">
            <div class="box-header with-border">
                <h3 class="box-title">Data Pasien</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
              </div>
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class='table-responsive'>
                <table class='table table-striped table-bordered table-hover table-condensed'>
                  <thead>
                    <tr>
                      <th class="text-center">No. RM</th>
                      <th>Nama</th>
                      <th>Alamat</th>
                      <th>Usia</th>
                      <th>Tgl Lahir</th>
                      @if ($unit == 'inap')
                        <th>Pekerjaan</th>
                      @endif
                      <th>Bayar</th>
                      <th>
                        @if ($unit == 'inap')
                        Kamar
                        @else
                        Poli
                        @endif
                      </th>
                      <th>DPJP</th>
                      <th>Dokter Konsul</th>
                      <th>Kunj.</th>
                      {{-- <th>Id Observation SS</th> --}}
                      <th>
                        @if ($unit == 'inap') 
                        Tgl. Masuk
                        @else
                        Tgl.Reg
                        @endif
                      </th>
                      @if ($gizi)
                        <th>Diagnosa Awal</th>
                      @endif
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="text-center">{{ @$reg->pasien->no_rm }}</td>
                      <td>{{ @$reg->pasien->nama }}</td>
                      <td>{{ @$reg->pasien->alamat }}</td>
                      <td>{{ hitung_umur(@$reg->pasien->tgllahir) }}</td>
                      <td>{{ date("d-m-Y", strtotime(@$reg->pasien->tgllahir)) }}</td>
                      @if ($unit == 'inap')
                        <td>{{ (!empty(@$reg->pasien->pekerjaan_id)) ? baca_pekerjaan(@$reg->pasien->pekerjaan_id) : '' }}</td>
                      @endif
                      <td>{{ baca_carabayar(@$reg->bayar) }} {{@$reg->tipe_jkn}}</td>
                      <td>
                        @if ($unit == 'inap')
                          {{ @$reg->rawat_inap ? baca_kamar(@$reg->rawat_inap->kamar_id) : NULL }}
                        @else
                          @if(cek_folio_counts(@$reg->id, @$reg->poli_id) > 0)
                            @if ($poli)
                              {{ baca_poli(@$poli) }}
                            @else
                                {{-- <span style="color: red">{{ !empty(@$reg->poli_id) ? @$reg->poli->nama : NULL }}</span></td> --}}
                                {{ !empty(@$reg->poli_id) ? @$reg->poli->nama : NULL }}
                            @endif
                          @else
                            @if ($poli)
                            <span style="color: red">{{ baca_poli(@$poli) }}</span>
                            @else
                              <span style="color: red">{{ !empty(@$reg->poli_id) ? @$reg->poli->nama : NULL }}</span>
                            @endif
                          @endif
                        @endif  
                      </td>
                      <td>
                        {{-- {{ $dpjp ? baca_dokter(@$dpjp) : baca_dokter(@$reg->dokter_id) }} --}}
                        @php
                            $user   =  App\User::where('poli_id', 'like', '%'. $reg->poli_id .'%')->pluck('id');
                            $poli = Modules\Poli\Entities\Poli::where('id',$reg->poli_id)->first();
                            // dd($dokter);
                            // Jika rawat inap, ambil semua dokter
                            if ($unit == "inap") {
                              $dokter =  Modules\Pegawai\Entities\Pegawai::where('kategori_pegawai', '1')->get();
                            } else { // Ambil sesuai poli
                              if(!$poli->dokter_id){
                                $dokter = Modules\Pegawai\Entities\Pegawai::where('kategori_pegawai','1')->get(); 
                              }else{
                                $dokter = Modules\Pegawai\Entities\Pegawai::whereIn('id',explode (",", $poli->dokter_id))->get();
                              }
                            }
                        @endphp
                        <select name="dokter_id" class="form-control" id="dokter_id" onchange="editDokter({{ $reg->id }})">
                          @if ($unit == 'inap')
                              @foreach ($dokter as $d)
                                <option value="{{ $d->id }}" {{ $d->id == $reg->dokter_id ? 'selected' : '' }}>{{ $d->nama }}</option>
                              @endforeach
                            @else
                              {{-- <option value="">{{ $dpjp ? baca_dokter(@$dpjp) : baca_dokter(@$reg->dokter_id) }}</option> --}}
                              @foreach ($dokter as $d)
                                 <option value="{{ $d->id }}" {{ $d->id == $reg->dokter_id ? 'selected' : '' }}>{{ $d->nama }}</option>
                              @endforeach
                            @endif
                        </select>
                      </td>
                      <td>
                        {{baca_dokter(@App\EmrKonsul::where('registrasi_id', $reg->id)->latest()->first()->dokter_penjawab)}}
                      </td>
                      <td>
                        @if (@$reg->poli_id == 27)
                          @php
                            $count = \Modules\Registrasi\Entities\Registrasi::where('pasien_id', $reg->pasien_id)->where('poli_id', 27)->count();
                          @endphp
                          {{ @$count > 1 ? 'Kunjungan Ke-'.@$count : 'Baru' }}
                        @else
                          {{ (@$reg->jenis_pasien == 1) ? 'Baru' : 'Lama' }}
                        @endif
                      </td>
                      {{-- <td>{{ @$riwayat->id_observation_ss }}</td> --}}
                      <td>
                        @if ($unit == 'inap')
                        {{ @$reg->rawat_inap ? tanggal(@$reg->rawat_inap->tgl_masuk) : NULL }}
                        @else
                        {{ date('d-m-Y H:i',strtotime(@$reg->created_at)) }}
                        @endif
                      </td>   
                      @if ($gizi)
                          @php
                              $diagnosa_inap = Modules\Icd10\Entities\Icd10::where('nomor', $reg->diagnosa_inap)->first();
                              $diagnosa_awal = Modules\Icd10\Entities\Icd10::where('nomor', $reg->diagnosa_awal)->first();
                              $diagnosa = $diagnosa_inap->nama ?? $diagnosa_awal->nama ?? '-';
                          @endphp
                          <td>{{ $diagnosa }}</td>
                      @endif
                    </tr>
                  </tbody>
                </table>
              </div>
            <div class="widget-user-image">
            </div>
        </div>
    </div>
</div>





{{-- @section('script')
@parent

<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script type="text/javascript">
    $('.select2').select2()




    function showNote(id) {
     
          $('#pemeriksaanModel').modal()
          $('.modal-title').text('Catataan Order Radiologi')
          $("#form")[0].reset()
          $.ajax({
            url: '/radiologi/showNoteEmr/'+id,
            type: 'GET',
            dataType: 'json',
          })
          .done(function(data) {
            $('input[name="id_reg"]').val(data.id)
            $('input[name="tgl_order"]').val(data.perawat_ibs1)
            $('input[name="catatan"]').val(data.perawat_ibs2)
          })
          .fail(function() {
            alert(data.error);
          });
      }



      function saveNote() {
        var id_reg =  $('input[name="id_reg"]').val();

        $.ajax({
          headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: '/radiologi/updateNoteEmr/'+id_reg,
          type: 'POST',
          dataType: 'json',
          data: {
            note: $('input[name="catatan"]').val(),
            tgl_note: $('input[name="tgl_order"]').val()
          }
        })
        .done(function(data) {
          alert('berhasil simpan catatan')
        
        })
        .fail(function() {
          alert('gagal input');
        });

    }




      
    </script>
@endsection     --}}