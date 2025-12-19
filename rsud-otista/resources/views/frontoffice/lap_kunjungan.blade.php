@extends('master')
@section('header')
<h1>Laporan Kunjungan </h1>
@endsection

@section('content')
<div class="box box-primary">
  <div class="box-header with-border">
  </div>
  <div class="box-body">
    {!! Form::open(['method' => 'POST', 'url' => 'frontoffice/laporan/kunjungan', 'class'=>'form-horizontal']) !!}
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="tanggal" class="col-md-3">Tanggal</label>
          <div class="col-md-4">
            <input type="text" autocomplete="off" name="tga" value="{{ !empty($_POST['tga']) ? $_POST['tga'] : '' }}"
              class="form-control datepicker">
            <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
          <div class="col-md-4">
            <input type="text" autocomplete="off" name="tgb" value="{{ !empty($_POST['tgb']) ? $_POST['tgb'] : '' }}"
              class="form-control datepicker">
            <small class="text-danger">{{ $errors->first('tgb') }}</small>
          </div>
        </div>
        <div class="form-group">
          <label for="tanggal" class="col-md-3">Cara Bayar</label>
          <div class="col-md-8">
            <select class="form-control select2" name="jenis_pasien">
              @if (!empty($_POST['jenis_pasien']) && $_POST['jenis_pasien'] == 1)
              <option value="">[Semua]</option>
              
              @elseif (!empty($_POST['jenis_pasien']) && $_POST['jenis_pasien'] == 2)
              <option value="">[Semua]</option>
              <option value="1">JKN</option>
              <option value="2" selected>Umum</option>
              @else
              <option value="">[Semua]</option>
              <option value="1">JKN</option>
              <option value="2">Umum</option>
              @endif

            </select>
          </div>
        </div>
        <div class="form-group">
          @php
              	$cara_bayar = Modules\Registrasi\Entities\Carabayar::all();	
          @endphp
          <label for="tanggal" class="col-md-3">Kategori JKN</label>
          <div class="col-md-8">
            <select class="form-control select2" name="tipe_jkn">
              @if (!empty($_POST['tipe_jkn']) && $_POST['tipe_jkn'] == 'PBI')
              <option value="">[Semua]</option>
              @foreach ($cara_bayar as $bayar)
              <option value="{{ $bayar->id }}">{{ baca_carabayar($bayar->id) }}</option>
              @endforeach
              @elseif (!empty($_POST['tipe_jkn']) && $_POST['tipe_jkn'] == 'NON PBI')
              <option value="">[Semua]</option>
              @foreach ($cara_bayar as $bayar)
              <option value="{{ $bayar->id }}">{{ baca_carabayar($bayar->id) }}</option>
              @endforeach
              @else
              <option value="">[Semua]</option>
              @foreach ($cara_bayar as $bayar)
              <option value="{{ $bayar->id }}">{{ baca_carabayar($bayar->id) }}</option>
              @endforeach
              @endif

            </select>
          </div>
        </div>

        {{-- dimas --}


        {{-- enddimas --}}

        <div class="form-group">
          <label for="tanggal" class="col-md-3">Pekerjaan</label>
          <div class="col-md-8">
            <select class="form-control select2" name="pekerjaan">
              <option value="">[Semua]</option>
              @foreach ($pekerjaan as $key => $p)
              @if (!empty($_POST['pekerjaan']) && $_POST['pekerjaan'] == $d->id)
              <option value="{{ $p->id }}" selected>{{ $p->nama }}
              @else
              <option value="{{ $p->id }}">{{ $p->nama }}
              @endif

              @endforeach
            </select>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="tanggal" class="col-md-3">Nama Poli</label>
          <div class="col-md-8">
            <select class="form-control select2" name="poli_id">
              <option value="">[Semua]</option>
              @foreach ($poli as $key => $d)
              @if (!empty($_POST['poli_id']) && $_POST['poli_id'] == $d->id)
              <option value="{{ $d->id }}" selected>{{ $d->nama }}</option>
              @else
              <option value="{{ $d->id }}">{{ $d->nama }}</option>
              @endif
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="tanggal" class="col-md-3">Nama Dokter</label>
          <div class="col-md-8">
            <select class="form-control select2" name="dokter_id">
              <option value="">[Semua]</option>
              @foreach ($dokter as $key => $d)
              @if (!empty($_POST['dokter_id']) && $_POST['dokter_id'] == $d->id)
              <option value="{{ $d->id }}" selected>{{ $d->nama }}</option>
              @else
              <option value="{{ $d->id }}">{{ $d->nama }}</option>
              @endif

              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="tanggal" class="col-md-3">Cara Pulang</label>
          <div class="col-md-8">
            <select class="form-control select2" name="cara_pulang_id">
              <option value="">[Semua]</option>
              @foreach ($caraPulang as $key => $c)
              @if (!empty($_POST['cara_pulang_id']) && $_POST['cara_pulang_id'] == $d->id)
              <option value="{{ $c->id }}" selected>{{ $c->namakondisi }}
              @else
              <option value="{{ $c->id }}">{{ $c->namakondisi }}
              @endif

              @endforeach
            </select>
          </div>
        </div>
      </div>
        
      <div class="col-md-12">
        <div class="form-group">
          <label for="tanggal" class="col-md-3"> &nbsp; </label>
          <div class="col-md-9" style="text-align: end;">
            {{-- <input type="submit" name="lanjut" class="btn btn-primary btn-flat" value="LANJUT"> --}}
            <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value="EXCEL">
            <input type="submit" name="pdf" class="btn btn-danger btn-flat fa-file-excel-o" value="CETAK"
              formtarget="_blank">
          </div>
        </div>
      </div>
      </div>
    </div>

    {!! Form::close() !!}
    <hr>
    {{-- ================================================================================================== --}}
    <div class='table-responsive'>
      <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
        <thead>
          <tr>
						<td><i>Untuk Mengurangi beban server, laporan hanya bisa langsung diexport Excel</i></td>
					  </tr>
          {{-- <tr>
            <th>No</th>
            <th>Nama</th>
            <th>No.Hp</th>
            <th>Nama Ibu Kandung</th>
            <th>Alamat</th>
            <th>provinsi</th>
            <th>kabupaten</th>
            <th>kecamatan</th>
            <th>No. RM</th>
            <th>Umur</th>
            <th>SEP</th>
            <th>L/P</th>
            <th>Klinik Tujuan</th>
            <th>Dokter DPJP</th>
            <th>Cara Bayar</th>
            <th>Tanggal</th>
            <th>Kunjungan</th>
            <th>ICD9</th>
            <th>Diagnosa</th>
            <th>Kondisi Akhir</th>
            <th>Keterangan</th>
            <th>Obat Dokter</th>
          </tr> --}}
        </thead>
        <tbody>
          @foreach ($reg as $key => $d)
          <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $d->nama }}</td>
            <td>{{ $d->nohp }}</td>
            <td>{{ $d->ibu_kandung }}</td>
            <td>{{ $d->alamat }}</td>
            <td>{{ $d->provinsi}}</td>
            <td>{{ $d->kabupaten }}</td>
            <td>{{ $d->kecamatan }}</td>
            <td>{{ $d->no_rm }}</td>
            <td>{{ hitung_umur($d->tgllahir) }}</td>
            <td class="text-center">{{ $d->sep }}</td>
            <td class="text-center">{{ $d->kelamin }}</td>
            <td>{{ baca_poli($d->poli_id) }}</td>
            <td>{{ baca_dokter($d->dokter_id) }}</td>
            <td>{{ baca_carabayar($d->bayar) }} {{ ($d->bayar == 1) ? $d->tipe_jkn : NULL }}</td>
            <td>{{ $d->created_at->format('d-m-Y') }}</td>
            <td>{{ $d->status }}</td>
            <td>
              @if($d->registrasi)
                @if(count($d->registrasi->icd9s) > 0)
                  @foreach ($d->registrasi->icd9s as $data)
                    {{ @baca_icd9($data->icd9) }}. <br><br>
                  @endforeach
                @endif
              @else
                -
              @endif
            </td>
            <td>
              @if($d->registrasi)
                @if(count($d->registrasi->icd10s) > 0)
                  @foreach ($d->registrasi->icd10s as $data)
                    * {{ @baca_icd10($data->icd10) . '(' .@$data->kasus. ')' }} <br>
                  @endforeach
                @endif
              @else
                -
              @endif
            </td>
            <td>
              {{ @$d->registrasi ? @$d->registrasi->kondisiAkhir->namakondisi : '-' }}
            </td>
            <td>
              {{ @$d->keterangan }}
            </td>
            <td>
              <ul>
                @if (!empty(@$d->resep->resep_detail))
                  @foreach (@$d->resep->resep_detail as $res)
                    <li>{{@$res->logistik_batch->nama_obat}} [{{@$res->qty}}]</li>
                  @endforeach
                @endif
              </ul>
            </td>
          </tr>
          @endforeach

        </tbody>
      </table>
    </div>


  </div>
  <div class="box-footer">
  </div>
</div>


@endsection

@section('script')
<script type="text/javascript">
  $(document).ready(function() {
    $('.select2').select2();

    if($('select[name="jenis_pasien"]').val() == 1) {
      $('select[name="tipe_jkn"]').removeAttr('disabled');
    } else {
      $('select[name="tipe_jkn"]').attr('disabled', true);
    }

    $('select[name="jenis_pasien"]').on('change', function () {
      if ($(this).val() == 1) {
        $('select[name="tipe_jkn"]').removeAttr('disabled');
      } else {
        $('select[name="tipe_jkn"]').attr('disabled', true);
      }

    });
  });

</script>
@endsection