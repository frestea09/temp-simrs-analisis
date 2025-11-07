@extends('master')
@section('header')
  <h1>Penyakit Rawat Inap (sebab luar) - RL 4A</h1>
@endsection

@section('content')
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Periode</h3>
  </div>
  <div class="box-body">
  {!! Form::open(['method' => 'POST', 'url' => 'sirs/rl/penyakit-rawat-inap-sebab-luar', 'class'=>'form-horizontal']) !!}
    {{ csrf_field() }}
    <div class="row">
      <div class="col-md-7">
        <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Tanggal</button>
            </span>
            {!! Form::text('tga', $tga, ['class' => 'form-control datepicker', 'autocomplete' => 'off']) !!}
            <small class="text-danger"></small>
          </div>
        </div>
        <div class="col-md-6">
          <div class="input-group">
          <span class="input-group-btn">
            <button class="btn btn-default" type="button">Sampai</button>
          </span>
          {!! Form::text('tgb', $tgb, ['class' => 'form-control datepicker', 'autocomplete' => 'off']) !!}
          </div>
        </div>
      </div>
      <div class="col-md-5">
        <div class="form-group text-center">
          <input type="submit" name="submit" class="btn btn-primary btn-flat" value="TAMPILKAN">
          <input type="submit" name="submit" class="btn btn-success btn-flat fa-file-excel-o" value="EXCEL">
          {{-- <input type="submit" name="submit" class="btn btn-danger btn-flat fa-file-pdf-o" value="CETAK"> --}}
        </div>
      </div>
    </div>
  {!! Form::close() !!}
  <hr>
  <div class='table-responsive'>
    <table class='table table-bordered table-hover'>
      <thead>
        <tr>
          <th class="text-center">No</th>
          <th class="text-center">DTD</th>
          <th class="text-center">TERPERINCI</th>
          <th class="text-center">Nama</th>
          <th class="text-center">6hr L</th>
          <th class="text-center">6hr P</th>
          <th class="text-center">6-28hr L</th>
          <th class="text-center">6-28hr P</th>
          <th class="text-center">28hr-1th L</th>
          <th class="text-center">28hr-1th P</th>
          <th class="text-center">1-4th L</th>
          <th class="text-center">1-4th P</th>
          <th class="text-center">4-14th L</th>
          <th class="text-center">4-14th P</th>
          <th class="text-center">14-24th L</th>
          <th class="text-center">14-24th P</th>
          <th class="text-center">24-44th L</th>
          <th class="text-center">24-44th P</th>
          <th class="text-center">44-64th L</th>
          <th class="text-center">44-64th P</th>
          <th class="text-center">>64th L</th>
          <th class="text-center">>64th P</th>
          <th class="text-center">L</th>
          <th class="text-center">P</th>
          <th class="text-center">Pasien Keluar (Hidup & Mati) L</th>
          <th class="text-center">Pasien Keluar (Hidup & Mati) P</th>
          <th class="text-center">Jumlah Pasien Keluar (Hidup & Mati)</th>
          <th class="text-center">Jumlah Pasien Keluar Mati</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($p_icd10 as $i)
          @php 
              $kelamin    = explode('||',$i['gender']);
              // $gender     = array_count_values($kelamin);
              // $range      = getRange($i['lahir'], $i['gender']);
              $mati       = array_count_values(explode('||',$i['mati']));
              // $jumlahPasienKeluar    = count(array_filter(explode('||', $i['kondisi_akhir'])));
              $jumlahPasienKeluar    = count( array_unique( explode('||', $i['pasien_id']) ) );
              $jumlahPasienKeluarMati    = array_filter(explode('||', $i['kondisi_akhir']));
              $pasienKeluar = array_filter(explode('||', $i['gender']));

              // 35698||10307||35698||82414||82414||10307||35698||10307

              $lahir = explode('||',$i['lahir']);
              $gender = explode('||',$i['gender']);

              $pasien_id = explode('||', $i['pasien_id']);
              // dd( $pasien_id, $jumlahPasienKeluar );

              $same = '';

              $jmlPasienMati = 0;
              $pasienKeluarLaki = 0;
              $pasienKeluarPerempuan = 0;

              $jkPasien = [];
              $pasienLahir = [];
              $pasienGender = [];

              foreach( $pasien_id as $k => $v){
                if( $v != $same ){
                  $same = $v;
                    if(isset($jumlahPasienKeluarMati[$k])){
                      if( $jumlahPasienKeluarMati[$k] == 4 ){ // 4: pasien meninggal
                          $jmlPasienMati += 1;
                      }
                    }
                    
                    if(isset($pasienKeluar[$k])){
                      if( $pasienKeluar[$k] == "L" ){ // pasien keluar
                          $pasienKeluarLaki += 1;
                      }else{
                          $pasienKeluarPerempuan += 1;
                      }
                    }

                      // pasien jenis kelamin
                      if(isset($kelamin[$k])){
                        $jkPasien[] = $kelamin[$k];
                      }
                      // lahir & gender
                      if(isset($lahir[$k])){
                        $pasienLahir[] = $lahir[$k];
                      }
                      if(isset($gender[$k])){
                        $pasienGender[] = $gender[$k];
                      }
                }
              }

              $pasienLahirImplode = implode('||',$pasienLahir);
              $pasienGenderImplode = implode('||',$pasienLahir);
              // dd($pasienLahirImplode);
              $gender     = array_count_values($jkPasien);
              $range      = getRange($pasienLahirImplode, $pasienGenderImplode);

              // $jmlPasienMati = 0;
              // foreach( $jumlahPasienKeluarMati as $val ){
              //     if( $val == 4 ){ // 4: pasien meninggal
              //         $jmlPasienMati += 1;
              //     }
              // }

              // $pasienKeluarLaki = 0;
              // $pasienKeluarPerempuan = 0;
              // foreach( $pasienKeluar as $val ){
              //     if( $val == "L" ){
              //         $pasienKeluarLaki += 1;
              //     }else{
              //         $pasienKeluarPerempuan += 1;
              //     }
              // }
          @endphp
          <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $i['dtd'] }}</td>
              <td>
                @foreach (array_count_values(explode('||', $i['daftar'])) as $k => $v)
                  {{ $k.', ' }}
                @endforeach
              </td>
              {{-- <td>{{ $i['nama'] }}</td> --}}
              <td>{{ getICD9($i['dtd']) }}</td>
              <td class="text-center">{{ $range[0] }}</td>
              <td class="text-center">{{ $range[1] }}</td>
              <td class="text-center">{{ $range[2] }}</td>
              <td class="text-center">{{ $range[3] }}</td>
              <td class="text-center">{{ $range[4] }}</td>
              <td class="text-center">{{ $range[5] }}</td>
              <td class="text-center">{{ $range[6] }}</td>
              <td class="text-center">{{ $range[7] }}</td>
              <td class="text-center">{{ $range[8] }}</td>
              <td class="text-center">{{ $range[9] }}</td>
              <td class="text-center">{{ $range[10] }}</td>
              <td class="text-center">{{ $range[11] }}</td>
              <td class="text-center">{{ $range[12] }}</td>
              <td class="text-center">{{ $range[13] }}</td>
              <td class="text-center">{{ $range[14] }}</td>
              <td class="text-center">{{ $range[15] }}</td>
              <td class="text-center">{{ $range[16] }}</td>
              <td class="text-center">{{ $range[17] }}</td>
              <td class="text-center">{{ (isset($gender['L'])) ? $gender['L'] : 0 }}</td>
              <td class="text-center">{{ (isset($gender['P'])) ? $gender['P'] : 0 }}</td>
              <td class="text-center">{{ $pasienKeluarLaki }}</td>
              <td class="text-center">{{ $pasienKeluarPerempuan }}</td>
              <td class="text-center">{{ $pasienKeluarPerempuan + $pasienKeluarLaki }}</td>
              <td class="text-center">{{ $jmlPasienMati }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection

@section('script')
  <script type="text/javascript">
    $(document).ready(function() {
        $('.table').DataTable({
            searching   : true,
            ordering    : true,
        })
        $('.datepicker').datepicker();
    });
  </script>
@endsection