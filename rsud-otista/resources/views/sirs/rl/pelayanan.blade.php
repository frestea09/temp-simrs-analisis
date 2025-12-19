@extends('master')
@section('header')
  <h1>Laporan RL 1.2 Pelayanan </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'pelayanan', 'class'=>'form-hosizontal']) !!}
      <div class="row">
        {{-- <div class="col-md-3">
          <div class="input-group{{ $errors->has('batas') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('batas') ? ' has-error' : '' }}" type="button">Batas</button>
              </span>
              {!! Form::number('batas', 10, ['class' => 'form-control', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('batas') }}</small>
          </div>
        </div> --}}
        <div class="col-md-3">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tahun</button>
              </span>
              <select name="tahun" class="form-control">
                @if(isset($data['thn']))
                <option value="2021" {{ ($data['thn']==2021) ? "selected" : "" }}>2021</option>
                <option value="2020" {{ ($data['thn']==2020) ? "selected" : "" }}>2020</option>
                <option value="2019" {{ ($data['thn']==2019) ? "selected" : "" }}>2019</option>
                {{-- <option value="2018" {{ ($data['thn']==2018) ? "selected" : "" }}>2018</option>
                <option value="2017" {{ ($data['thn']==2017) ? "selected" : "" }}>2017</option> --}}
                @else
                <option value="2021">2021</option>
                <option value="2020">2020</option>
                <option value="2019">2019</option>
                {{-- <option value="2018">2018</option>
                <option value="2017">2017</option> --}}
                @endif
              </select>
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>
        {{-- <div class="col-md-3">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
              </span>
              {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required', 'autocomplete' => 'off']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>

        <div class="col-md-3">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">s/d Tanggal</button>
            </span>
              {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required', 'autocomplete' => 'off']) !!}
          </div>
        </div> --}}
        <div class="col-md-3">
          <input type="submit" name="view" class="btn btn-primary btn-flat" value="VIEW">
          <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value=" &#xf1c3; EXCEL">
        </div>
      </div>
      {!! Form::close() !!}
      <hr>
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data-table">
          <thead>
            <tr>
              {{-- <th>No</th> --}}
              <th>Bulan</th>
              <th>Bor</th>
              <th>Los</th>
              <th>Bto</th>
              <th>Toi</th>
              <th>Ndr</th>
              <th>Gdr</th>
              <th>Idr</th>
              <th>Rata-rata Kunjungan/Hari</th>
            </tr>
          </thead>
          <tbody>
            @php
              $totBOR = 0;
              $totLOS = 0;
              $totBTO = 0;
              $totTOI = 0;
              $totNDR = 0;
              $totGDR = 0;
              $totIDR = 0;
              $totKunj = 0;
            @endphp
            @if ( isset($data['inap']) )
              @foreach ($data['inap'] as $key => $d)
                <tr>
                  {{-- <td>{{ $no++ }}</td> --}}
                  <td>{{ $data['bulan'][$d->bln] }}</td>
                  <td>
                    {{-- 
                               jml hari perawatan 
                      BOR = -------------------------- x 100%
                            jml tt x hari kerja efektif
                    --}}
                    @if($d->lama_rawat != 0)
                    {{ number_format( ($d->lama_rawat / ($data['kamar']*cal_days_in_month(CAL_GREGORIAN,$d->bln,$data['thn'])))*100/10 ,2) }}
                    @php $totBOR += ( ($d->lama_rawat / ($data['kamar']*cal_days_in_month(CAL_GREGORIAN,$d->bln,$data['thn'])))*100/10) @endphp
                    @else
                    {{ 0 }}
                    @endif
                  </td>
                  <td>
                    {{-- 
                               jml lama dirawat 
                      LOS = --------------------------
                            pasien keluar hidup & mati
                    --}}
                    @if($d->total_pasien != 0)
                    {{ number_format(($d->lama_rawat-1)/$d->total_pasien,2) }}
                    @php $totLOS += (($d->lama_rawat-1)/$d->total_pasien) @endphp
                    @else
                    {{ 0 }}
                    @endif
                  </td>
                  <td>
                    {{-- 
                           pasien keluar hidup & mati 
                      BTO = --------------------------
                                   jml tt
                    --}}
                    {{ number_format($d->total_pasien/$data['kamar'],2) }}
                    @php $totBTO += ($d->total_pasien/$data['kamar']) @endphp
                  </td>
                  <td>
                    {{-- 
                           (jml tt x hari kerja efektif) - jml hari perawatan
                      TOI = ---------------------------------------------------
                                      pasien keluar hidup & mati
                    --}}
                    @if($d->total_pasien != 0)
                    {{ number_format( (($data['kamar']*cal_days_in_month(CAL_GREGORIAN,$d->bln,$data['thn'])) - $d->lama_rawat) / $d->total_pasien,2) }}
                    @php $totTOI += ( (($data['kamar']*cal_days_in_month(CAL_GREGORIAN,$d->bln,$data['thn'])) - $d->lama_rawat) / $d->total_pasien) @endphp
                    @else
                    {{ 0 }}
                    @endif
                  </td>
                  <td>
                    {{-- 
                           pasien keluar mati > 48 jam x 1000
                      NDR = ----------------------------------
                                    pasien keluar mati
                    --}}
                    @if($d->keluar_mati != 0)
                    {{ number_format( ($d->mati_kurang_48 * 1000) / $d->keluar_mati ) }}
                    @php $totNDR += ( ($d->mati_kurang_48 * 1000) / $d->keluar_mati ) @endphp
                    @else
                    {{ 0 }}
                    @endif
                  </td>
                  <td>
                    {{-- 
                           pasien keluar mati x 1000
                      GDR = -------------------------
                           pasien keluar hidup & mati
                    --}}
                    @if($d->total_pasien != 0)
                    {{ number_format( ($d->keluar_mati * 1000) / $d->total_pasien ) }}
                    @php $totGDR += ( ($d->keluar_mati * 1000) / $d->total_pasien ) @endphp
                    @else
                    {{ 0 }}
                    @endif
                  </td>
                  <td>
                    {{-- 
                           jml bayi lahir mati x 1000
                      IDR = -------------------------
                           jml bayi lahir hidup & mati
                    --}}
                    @if($d->bayi_lahir_hidup != 0 || $d->bayi_lahir_mati != 0)
                    {{ number_format( ($d->bayi_lahir_mati * 1000) / ($d->bayi_lahir_hidup + $d->bayi_lahir_mati) ) }}
                    @php $totIDR += ( ($d->bayi_lahir_mati * 1000) / ($d->bayi_lahir_hidup + $d->bayi_lahir_mati) ) @endphp
                    @else
                    {{ 0 }}
                    @endif
                  </td>
                  <td>-</td>
                </tr>
              @endforeach
              <tr>
                <th>Total</th>
                <th>{{ number_format($totBOR,2) }}</th>
                <th>{{ number_format($totLOS,2) }}</th>
                <th>{{ number_format($totBTO,2) }}</th>
                <th>{{ number_format($totTOI,2) }}</th>
                <th>{{ number_format($totNDR,2) }}</th>
                <th>{{ number_format($totGDR,2) }}</th>
                <th>{{ number_format($totIDR,2) }}</th>
                <th>{{ number_format($totKunj,2) }}</th>
              </tr>
            @endif
            </tbody>
          </table>
        </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
  @endsection

  @section('script')
  <script>
    $('#data-table').DataTable({
      'language'    : {
        "url": "/json/pasien.datatable-language.json",
      },
      'paging'      : false,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : false
    });
  </script>
  @endsection