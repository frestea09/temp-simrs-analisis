<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Pendaftaran</title>
        <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    </head>
	<body>
        <div class="container">
            <div class="row setup-content" id="step-4">
                <div class="col-xs-12 col-md-6 col-md-offset-3">
                    <div class="col-md-12 colForm">	
                        <div style="text-align: center;">
                            <h3>{{ config('app.nama') }}</h3>
                            <h4>RESUME PENDAFTARAN ONLINE</h4>
                            <br/>
                        </div>
                        <table class="table resume_reservasi">
                            <tbody>
                                <tr>
                                    <td>No. RM</td>
                                    <td>:</td>
                                    <td>{{ $data['no_rm'] }}</td>
                                </tr>
                                <tr>
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td>{{ $data['nama'] }}</td>
                                </tr>
                                <tr>
                                    <td>Jenis Kelamin</td>
                                    <td>:</td>
                                    <td>{{ ($data['kelamin'] == 'L') ? 'Laki-laki' : 'Perempuan' }} </td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>:</td>
                                    <td>{{ $data['alamat'] }}</td>
                                </tr>
                                <tr>
                                    <td>No. Handphone</td>
                                    <td>:</td>
                                    <td>{{ $data['no_hp'] }}</td>
                                </tr>
                                <tr>
                                    <td>No. Rujukan</td>
                                    <td>:</td>
                                    <td>{{ $data['no_rujukan'] }}</td>
                                </tr>
                                <tr>
                                    <td>Tgl. Periksa</td>
                                    <td>:</td>
                                    <td>{{ $data['tglperiksa'] }}</td>
                                </tr>
                                <tr>
                                    <td>Poliklinik</td>
                                    <td>:</td>
                                    <td>{{ \Modules\Poli\Entities\Poli::find($data['kode_poli'])->nama }}</td>
                                </tr>
                                <tr>
                                    <td>Dokter</td>
                                    <td>:</td>
                                    <td>{{ \Modules\Pegawai\Entities\Pegawai::find($data['kode_dokter'])->nama }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <i>* Simpan Kode Pendaftaran Online Anda</i>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>