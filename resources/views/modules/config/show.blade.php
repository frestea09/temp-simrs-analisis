@extends('master')

@section('header')
  <h1>Konfigurasi Rumah Sakit</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data Konfigurasi Rumah Sakit
          <a href="{{ route('config.edit', $config->id) }}" class="btn btn-default"><i class="fa fa-edit"></i> Update Data</a>
        </h3>
      </div>
      <div class="box-body">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <tbody>
              <tr>
                <th>Nama</th>
                <td>{{ @$config->nama ? @$config->nama : '' }}</td>
              </tr> 
              {{-- <tr> 
                <th>Antrian Footer</th>
                <td>{{ @$config->antrianfooter }}</td>
              </tr> --}}
              <tr>
                <th>Alamat</th>
                <td>{{ $config->alamat }}</td>
              </tr>
              <tr>
                <th>Website</th>
                <td>{{ $config->website }}</td>
              </tr>
              {{-- <tr>  
                <th>Panjang Kode Pasien</th>
                <td>{{ $config->panjangkodepasien }}</td>
              </tr> --}}
              <tr>
                <th>Email</th>
                <td>{{ $config->email }}</td>
              </tr>
              {{-- <tr>
                <th>Bayar Depan</th>
                <td>{{ $config->bayardepan }}</td>
                <th>User SEP</th>
                <td>{{ $config->usersep }}</td>
              </tr> --}}
              {{-- <tr>
                <th>Kasir Tindakan</th>
                <td>{{ $config->kasirtindakan }}</td>
                <th>IP INACBG</th>
                <td>{{ $config->ipinacbg }}</td>
              </tr> --}}
              <tr>
                <th>Visi dan Misi</th>
                <td>{{ $config->visi_misi}}</td>
              </tr>
              {{-- <tr>  
                <th>Kode Pos</th>
                <td>{{ $config->kode_pos }}</td>
              </tr> --}}
              <tr>  
                <th>Satu Sehat Organization</th>
                <td>{{ @$config->id_organization }}</td>
              </tr>
              <tr>
                <th>Direktur</th>
                <td>{{ @$config->pegawai_id ? @Modules\Pegawai\Entities\Pegawai::find(@$config->pegawai_id)->nama : '' }}</td>
              </tr>
              {{-- <tr>
                <th>Tahun</th>
                <td>{{ @$config->tahuntarif ? @Modules\Config\Entities\Tahuntarif::find(@$config->tahuntarif)->tahun : '' }}</td>
              </tr> --}}

              {{-- <tr>
                <th>Logo</th>
                <td><img src="images/{{ $config->logo }}"></td>
                <th>Organization Satu Sehat</th>
                <td >{{ $config['id_organization'] }}</td>
              </tr> --}}
            </tbody>
          </table>
        </div>
      </div>
    </div>
@stop
