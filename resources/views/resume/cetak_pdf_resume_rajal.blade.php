<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Resume Pasien</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            padding: 15px;
            /* text-align: left; */
        }
    </style>
  </head>
  <body>


    <table>
        <tr>
          <th colspan="1">
            <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
          </th>
          <th colspan="5" style="font-size: 18pt;">
            <b>ASESMEN AWAL RAWAT JALAN POLIKLINIK {{ baca_poli(@$reg->poli_id) }}</b>
          </th>
        </tr>
        <tr>
          <td colspan="6">
            Tanggal Pemeriksaan : {{ date('d-m-Y',strtotime(@$emrPemeriksaan->created_at)) }}
          </td>
        </tr>
        <tr>
            <td colspan="2">
                <b>Nama Pasien</b><br>
                {{ $reg->pasien->nama }}
            </td>
            <td colspan="2">
                <b>Tgl. Lahir</b><br>
                {{ !empty($reg->pasien->tgllahir) ? hitung_umur($reg->pasien->tgllahir) : NULL }} 
            </td>
            <td>
                <b>Jenis Kelamin</b><br>
                {{ $reg->pasien->kelamin }}
            </td>
            <td>
                <b>No MR.</b><br>
                {{ $reg->pasien->no_rm }}
            </td>
        </tr>
        <tr>
            <td colspan="5">
                <b>Alamat Lengkap</b><br>
                {{ $reg->pasien->alamat }}
            </td>
            <td>
                <b>No Telp</b><br>
                {{ $reg->pasien->nohp }}
            </td>
        </tr>
        <tr>
          <td>
              <b>ANAMNESA</b>
          </td>
          <td colspan="5">
              {{ @json_decode(@$emrPemeriksaan->fisik, true)['anamnesa'] }}
          </td>
        </tr>
        <tr>
          <td>
              <b>PEMERIKSAAN FISIK</b>
          </td>
          <td colspan="5">
            1. Tanda Vital <br/>
            - TD : {{ @json_decode(@$emrPemeriksaan->fisik, true)['tanda_vital']['tekanan_darah'] }} mmHG &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            - Nadi : {{ @json_decode(@$emrPemeriksaan->fisik, true)['tanda_vital']['nadi'] }} x/menit &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            - RR : {{ @json_decode(@$emrPemeriksaan->fisik, true)['tanda_vital']['RR'] }} x/menit &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            - Temp : {{ @json_decode(@$emrPemeriksaan->fisik, true)['tanda_vital']['temp'] }} °C &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <br/>
            - Berat Badan : {{ @json_decode(@$emrPemeriksaan->fisik, true)['tanda_vital']['BB'] }} Kg &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            - Tinggi Badan : {{ @json_decode(@$emrPemeriksaan->fisik, true)['tanda_vital']['TB'] }} Cm &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <br/><br/>
            2. Pemeriksaan Fisik Dokter : <br/>
            {{ @json_decode(@$emrPemeriksaan->fisik, true)['pemeriksaan_fisik'] }} 
          </td>
        </tr>
        <tr>
          <td colspan="2" style="vertical-align: top">
            <b>STATUS PEDIATRI</b>
            <br>
            {{ @json_decode(@$emrPemeriksaan->fisik, true)['status_pediatri']['status_gizi'] }}
            <br>
            {{ @json_decode(@$emrPemeriksaan->fisik, true)['status_pediatri']['riwayat_imunisasi'] }}
            <br>
            {{ @json_decode(@$emrPemeriksaan->fisik, true)['status_pediatri']['riwayat_tumbuh_kembang'] }}
          </td>
          <td colspan="4" style="text-align: center">
            <b>STATUS LOKALIS</b>
            <br>
            @if (@$gambar->image != null)
              <img src="{{ public_path('images/'.@$gambar->image) }}" alt="" style="width: 400px; height: 200px;">
            @else
              <h4><i>Tidak Ada Status Lokalis</i></h4>
            @endif
          </td>
        </tr>
        <tr>
          <td colspan="6">
            <b>PEMERIKSAAN PENUNJANG</b> <br>
            @foreach (@$rads as $rad)
            - {{ @$rad->namatarif }} <b>({{ baca_dokter(@$rad->dokter_pelaksana) }})</b><br>
            @endforeach
            @foreach (@$labs as $lab)
            - {{ @$lab->namatarif }} <b>({{ baca_dokter(@$lab->dokter_pelaksana) }})</b><br>
            @endforeach
          </td>
        </tr>
        <tr>
          <td colspan="6" style="vertical-align: top;">
            <b>DIAGNOSIS</b>
            <br>
            {{ @json_decode(@$emrPemeriksaan->fisik, true)['diagnosis'] }}
          </td>
        </tr>
        <tr>
          <td colspan="6" style="vertical-align: top;">
              <b>TINDAKAN</b><br/>
              @foreach (@$folio as $tindakan)
              - {{ @$tindakan->namatarif }}<br>
              @endforeach
          </td>
        </tr>
        <tr>
          <td colspan="6" style="vertical-align: top;">
            <b>PENGOBATAN</b><br/>
            @foreach (@$obats as $obat)
            - {{ substr(strtoupper(baca_obat(@$obat->masterobat_id)), 0, 40) }}<br>
            @endforeach
          </td>
        </tr>
        
        
        <tr>
          <td>
              <b>PLANNING</b>
          </td>
          <td colspan="5">
            {{ @json_decode(@$emrPemeriksaan->fisik, true)['planning'] }}
          </td>
        </tr>
        <tr>
          <td>
              <b>PENANGANAN PASIEN</b>
          </td>
          <td colspan="5">
            {{ @json_decode(@$emrPemeriksaan->fisik, true)['penanganan_pasien'] }}
          </td>
        </tr>
        {{-- <tr>
            <td>
                <b>Nama Jelas DPJP</b>
            </td>
            <td colspan="5">
                {{ baca_dokter($reg->dokter_id) }}
            </td>
        </tr>
        <tr>
            <td>
                <b>Jenis Pembayaran</b>
            </td>
            <td colspan="5">
                {{ baca_carabayar($reg->bayar) }}
            </td>
        </tr>
        <tr>
            <td>
                <b>Keluhan Utama</b>
            </td>
            <td colspan="5">
                {{@json_decode($soap->fisik,true)['keluhan_utama']}}
            </td>
        </tr>
        <tr>
            <td>
                <b>Riwayat Penyakit Sekarang</b>
            </td>
            <td colspan="5">
                {{@json_decode($soap->fisik,true)['riwayat_penyakit_sekarang']}}
            </td>
        </tr>


        <tr>
          <td>
              <b>Diagnosa Keperawatan</b>
          </td>
          <td colspan="5">
              {{@json_decode($soap->fisik,true)['diagnosa_perawat']}}
          </td>
      </tr>



      <tr>
        <td>
            <b>Planning</b>
        </td>
        <td colspan="5">
            {{@json_decode($soap->fisik,true)['planing']}}
        </td>
    </tr>
    




        <tr>
            <th colspan="6">Keadaan Umum</th>
        </tr>
        <tr>
            <th>Tampak Tidak Sakit</th>
            <th>Sakit Ringan</th>
            <th>Sakit Sedang</th>
            <th colspan="3">Sakit Berat</th>
        </tr>
        <tr>
            <td>
                {{@json_decode($soap->fisik,true)['keadaan_umum']['tampak_tidak_sakit']}}
            </td>
            <td>
                 {{@json_decode($soap->fisik,true)['keadaan_umum']['sakit_ringan']}}
            </td>
            <td>
                {{@json_decode($soap->fisik,true)['keadaan_umum']['sakit_sedang']}} 
            </td>
            <td colspan="3">
                {{@json_decode($soap->fisik,true)['keadaan_umum']['sakit_berat']}} 
            </td>
        </tr>
        <tr>
            <th colspan="6">Kesadaran</th>
        </tr>
        <tr>
            <th>Compos Mentis</th>
            <th>Apatis</th>
            <th>Somnolen</th>
            <th>Sopor</th>
            <th colspan="2">Coma</th>
        </tr>
        <tr>
            <td>
                {{@json_decode($soap->fisik,true)['kesadaran']['compos_mentis']}}
            </td>
            <td>
                 {{@json_decode($soap->fisik,true)['kesadaran']['apatis']}}
            </td>
            <td>
                {{@json_decode($soap->fisik,true)['kesadaran']['somnolen']}}
           </td>
           <td>
            {{@json_decode($soap->fisik,true)['kesadaran']['sopor']}}
            </td>
            <td colspan="2">
                {{@json_decode($soap->fisik,true)['kesadaran']['coma']}}
           </td>
        </tr>
            
        

        <tr>
          <th colspan="6">GCS</th>
      </tr>
      <tr>
          <th>E</th>
          <th>M</th>
          <th>V</th>
          <th>Tekanan Darah</th>
          <th>Nadi</th>
          <th>Frekuensi Nafas</th> --}}
          {{-- <th>Suhu</th>
          <th>Berat Badan</th>
          <th colspan="2">Tinggi Badan</th> --}}
      {{--</tr>
      <tr>
          <td>
              {{@json_decode($soap->fisik,true)['GCS']['E']}}
          </td>
          <td>
              {{@json_decode($soap->fisik,true)['GCS']['M']}}
          </td>
          <td>
              {{@json_decode($soap->fisik,true)['GCS']['V']}}
         </td>
         <td>
          {{@json_decode($soap->fisik,true)['GCS']['tekanan_darah']}}
          </td>
          <td>
            {{@json_decode($soap->fisik,true)['GCS']['nadi']}}
          </td>
          <td>
            {{@json_decode($soap->fisik,true)['GCS']['frekuensi_nafas']}}
        </td> --}}
        {{-- <td>
          {{json_decode($soap->fisik,true)['GCS']['suhu']}}
        </td>
         <td>
          {{json_decode($soap->fisik,true)['GCS']['BB']}} kg
          </td>
          <td colspan="2">
              {{json_decode($soap->fisik,true)['GCS']['TB']}} cm
         </td> --}}
      {{-- </tr>
        
       
        <tr>
            <th colspan="6">Asesmen Nyeri</th>
        </tr>
        <tr>
            <th>Provokatif</th>
            <th>Quality</th>
            <th>Region</th>
            <th>Severty</th>
            <th>Time</th>
            <th>Nyeri Hilang Jika</th>
            
          
        </tr>
        <tr>
            <td>
                {{@json_decode($soap->fisik,true)['asesmen_nyeri']['provokatif']}}
            </td>
            <td>
                {{@json_decode($soap->fisik,true)['asesmen_nyeri']['quality']}}
            </td>
            <td>
                {{@json_decode($soap->fisik,true)['asesmen_nyeri']['region']}}
           </td>
           <td>
                 {{@json_decode($soap->fisik,true)['asesmen_nyeri']['severty']}}
            </td>
            <td>
                {{@json_decode($soap->fisik,true)['asesmen_nyeri']['time']}}
             </td>
             <td>
                {{@json_decode($soap->fisik,true)['asesmen_nyeri']['nyeri_hilang_jika']}}
             </td>
        </tr>


        <tr>
            <th colspan="6">Persarafan</th>
        </tr>
             
        <tr>
            <td colspan="3">
              <b>Tidak Ada Keluhan :</b>
            </td>
            <td colspan="3">
               <b>{{@json_decode($soap->fisik,true)['persarafan']['tidak_ada_keluhan']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Tremor </b>
            </td>
            <td colspan="3">
               <b>{{@json_decode($soap->fisik,true)['persarafan']['tremor']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Kejang </b>
            </td>
            <td colspan="3">
               <b>{{@json_decode($soap->fisik,true)['persarafan']['kejang']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Paralise </b>
            </td>
            <td colspan="3">
               <b>{{@json_decode($soap->fisik,true)['persarafan']['paralise']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>hemiparese </b>
            </td>
            <td colspan="3">
               <b>{{@json_decode($soap->fisik,true)['persarafan']['hemiparese']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Catatan </b>
            </td>
            <td colspan="3">
               <b>{{@json_decode($soap->fisik,true)['persarafan']['text']}}</b>
             </td>
        </tr>
    




      
        <tr>
            <th colspan="6">Pernapasan</th>
        </tr>
        <tr>
            <th>Tidak Ada Keluhan</th>
            <th>Sekret</th>
            <th>Sesak Napas</th>
            <th colspan="3">Catatan</th>
           
            
          
        </tr>
        <tr>
            <td>
                {{@json_decode($soap->fisik,true)['pernapasan']['tidak_ada_keluhan']}}
            </td>
            <td>
                {{@json_decode($soap->fisik,true)['pernapasan']['sekret']}}
            </td>
            <td>
                {{@json_decode($soap->fisik,true)['pernapasan']['sesak_napas']}}
           </td>
           <td colspan="3">
                 {{@json_decode($soap->fisik,true)['pernapasan']['text']}}
            </td>
          
        </tr>





        <tr>
            <th colspan="6">Pencernaan</th>
        </tr>
        <tr>
            <th>Tidak Ada Keluhan</th>
            <th>konstipasi</th>
            <th>Mual/Muntah</th>
            <th>Diare</th>
            <th colspan="2">Catatan</th>
           
            
          
        </tr>
        <tr>
            <td>
                {{@json_decode($soap->fisik,true)['pencernaan']['tidak_ada_keluhan']}}
            </td>
            <td>
                {{@json_decode($soap->fisik,true)['pencernaan']['konstipasi']}}
            </td>
            <td>
                {{@json_decode($soap->fisik,true)['pencernaan']['mual']}}
           </td>
           <td>
            {{@json_decode($soap->fisik,true)['pencernaan']['diare']}}
          </td>
           <td colspan="2">
                 {{@json_decode($soap->fisik,true)['pencernaan']['text']}}
            </td>
          
        </tr>




        <tr>
            <th colspan="6">Endokrin</th>
        </tr>
        <tr>
            <th>Tidak Ada Keluhan</th>
            <th>Kringat Banyak</th>
            <th>Pembesaran Kelenjar Tiroid</th>
            <th>Diare</th>
            <th>Napas Bau</th>
            <th colspan="1">Catatan</th>
           
          
        </tr>
        <tr>
            <td>
                {{@json_decode($soap->fisik,true)['endokrin']['tidak_ada_keluhan']}}
            </td>
            <td>
                {{@json_decode($soap->fisik,true)['endokrin']['keringat_banyak']}}
            </td>
            <td>
                {{@json_decode($soap->fisik,true)['endokrin']['pembesaran_kelenjar_tiroid']}}
           </td>
           <td>
                {{@json_decode($soap->fisik,true)['endokrin']['diare']}}
             </td>
             <td>
            {{@json_decode($soap->fisik,true)['endokrin']['napas_baus']}}
             </td>
           <td colspan="1">
                {{@json_decode($soap->fisik,true)['endokrin']['text']}}
            </td>
          
        </tr>







        <tr>
            <th colspan="6">Kardiovaskuler</th>
        </tr>
        <tr>
            <th>Tidak Ada Keluhan</th>
            <th>Oedema</th>
            <th>Chest Pain</th>
            <th colspan="3">Catatan</th>
           
          
        </tr>
        <tr>
            <td>
                {{@json_decode($soap->fisik,true)['kardiovaskuler']['tidak_ada_keluhan']}}
            </td>
            <td>
                {{@json_decode($soap->fisik,true)['kardiovaskuler']['oedema']}}
            </td>
            <td>
                {{@json_decode($soap->fisik,true)['kardiovaskuler']['chest_pain']}}
           </td>
          
           <td colspan="3">
                {{@json_decode($soap->fisik,true)['kardiovaskuler']['text']}}
            </td>
          
        </tr>





        <tr>
            <th colspan="6">abdomen</th>
        </tr>
             
        <tr>
            <td colspan="3">
              <b>Tidak Ada Keluhan :</b>
            </td>
            <td colspan="3">
               <b>{{@json_decode($soap->fisik,true)['abdomen']['tidak_ada_keluhan']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Membesar </b>
            </td>
            <td colspan="3">
               <b>{{@json_decode($soap->fisik,true)['abdomen']['membesar']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Nyeri Tekan </b>
            </td>
            <td colspan="3">
               <b>{{@json_decode($soap->fisik,true)['abdomen']['nyeri_tekan']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Luka </b>
            </td>
            <td colspan="3">
               <b>{{@json_decode($soap->fisik,true)['abdomen']['luka']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Distensi </b>
            </td>
            <td colspan="3">
               <b>{{@json_decode($soap->fisik,true)['abdomen']['distensi']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>L I </b>
            </td>
            <td colspan="3">
               <b>{{@json_decode($soap->fisik,true)['abdomen']['L_I']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>L II </b>
            </td>
            <td colspan="3">
               <b>{{@json_decode($soap->fisik,true)['abdomen']['L_II']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>L III </b>
            </td>
            <td colspan="3">
               <b>{{@json_decode($soap->fisik,true)['abdomen']['L_III']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>L IV </b>
            </td>
            <td colspan="3">
               <b>{{@json_decode($soap->fisik,true)['abdomen']['L_IV']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Catatan </b>
            </td>
            <td colspan="3">
               <b>{{@json_decode($soap->fisik,true)['abdomen']['text']}}</b>
             </td>
        </tr> --}}









        {{-- <tr>
            <th colspan="6">Reproduksi</th>
        </tr>
             
        <tr>
            <td colspan="3">
              <b>Tidak Ada Keluhan :</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['reproduksi']['tidak_ada_keluhan']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Keputihan </b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['reproduksi']['keputihan']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Haid Teratur </b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['reproduksi']['haid_teratur']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>KB </b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['reproduksi']['kb']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>HPHT </b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['reproduksi']['hpht']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>TP </b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['reproduksi']['tp']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>UK</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['reproduksi']['uk']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>DD </b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['reproduksi']['dd']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Catatan </b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['reproduksi']['text']}}</b>
             </td>
        </tr>











        <tr>
            <th colspan="6">Kulit</th>
        </tr>
             
        <tr>
            <td colspan="3">
              <b>Tidak Ada Keluhan :</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['kulit']['tidak_ada_keluhan']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Luka </b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['kulit']['luka']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Warna </b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['kulit']['warna']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Lecet </b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['kulit']['lecet']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Turgor </b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['kulit']['turgor']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Catatan </b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['kulit']['text']}}</b>
             </td>
        </tr>







        <tr>
            <th colspan="6">Urinaria</th>
        </tr>
             
        <tr>
            <td colspan="3">
              <b>Tidak Ada Keluhan :</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['urinaria']['tidak_ada_keluhan']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Warna </b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['urinaria']['warna']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Produksi </b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['urinaria']['produksi']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Catatan </b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['urinaria']['text']}}</b>
             </td>
        </tr>






        <tr>
            <th colspan="6">Mata</th>
        </tr>
             
        <tr>
            <td colspan="3">
              <b>Tidak Ada Keluhan</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['mata']['tidak_ada_keluhan']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Normal </b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['mata']['normal']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Kuning </b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['mata']['kuning']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Pucat </b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['mata']['pucat']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Catatan </b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['mata']['text']}}</b>
             </td>
        </tr>














       


        <tr>
            <th colspan="6">Otot, Sendi, dan Tulang</th>
        </tr>
             
        <tr>
            <td colspan="3">
              <b>Tidak Ada Keluhan</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['ost']['tidak_ada_keluhan']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Gerakan Terbatas</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['ost']['gerakan_terbatas']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Nyeri </b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['ost']['nyeri']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Catatan </b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['ost']['text']}}</b>
             </td>
        </tr>







        <tr>
            <th colspan="6">Keadaan Emosional</th>
        </tr>
             
        <tr>
            <td colspan="3">
              <b>Butuh Pertolongan</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['keadaan_emosional']['butuh_pertolongan']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Kooperatif </b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['keadaan_emosional']['kooperatif']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Ingin Tahu </b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['keadaan_emosional']['ingin_tahu']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Bingung </b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['keadaan_emosional']['bingung']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Catatan </b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['keadaan_emosional']['text']}}</b>
             </td>
        </tr>






        
        <tr>
            <th colspan="6">Gigi</th>
        </tr>
             
        <tr>
            <td colspan="3">
              <b>Tidak Ada Keluhan</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['gigi_check']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Catatan</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['gigi']}}</b>
             </td>
        </tr>










        <tr>
            <th colspan="6">Telinga</th>
        </tr>
             
        <tr>
            <td colspan="3">
              <b>Tidak Ada Keluhan</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['telinga_check']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Catatan</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['telinga']}}</b>
             </td>
        </tr>



        
        <tr>
            <th colspan="6">Tenggorokan</th>
        </tr>
             
        <tr>
            <td colspan="3">
              <b>Tidak Ada Keluhan</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['tenggorokan_check']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Catatan</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['tenggorokan']}}</b>
             </td>
        </tr>



        <tr>
            <th colspan="6">Hidung / Muka</th>
        </tr>
             
        <tr>
            <td colspan="3">
              <b>Tidak Ada Keluhan</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['hidung_muka_check']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Catatan</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['hidung_muka']}}</b>
             </td>
        </tr>


       






       









        
        <tr>
            <th colspan="6">Edukasi Diberkan Kepada</th>
        </tr>
             
        <tr>
            <td colspan="3">
              <b>Orang Tua</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['edukasi_diberikan']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Keluarga</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['edukasi_diberikan_keluarga']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Hubungan (keluarga) </b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['hubungan']}}</b>
             </td>
        </tr>
       






        <tr>
            <th colspan="6">Bicara</th>
        </tr>
             
        <tr>
            <td colspan="3">
              <b>Normal</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['normal']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Gangguan Bicara</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['gangguan_bicara']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Kapan Gangguan</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['kapan_gangguan']}}</b>
             </td>
        </tr>








        <tr>
            <th colspan="6">Bicara Sehari-hari</th>
        </tr>
             
        <tr>
            <td colspan="3">
              <b>Indonesia (aktif / pasif)</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['indonesia']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>  Inggris (aktif / pasif)</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['inggris']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Bahasa Daerah</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['daerah']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Jelaskan</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['jelaskan']}}</b>
             </td>
        </tr>







        <tr>
            <th colspan="6">Perlu Penerjemah</th>
        </tr>
             
        <tr>
            <td colspan="3">
              <b>Perlu Penerjemah</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['perlu_penerjemah']}}</b>
             </td>
        </tr>








        
        <tr>
            <th colspan="6">Hambatan Edukasi</th>
        </tr>
             
        <tr>
            <td colspan="3">
              <b>Bahasa</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['bahasa']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Pendengaran</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['pendengaran']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Hilang Memori</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['hilang_memori']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Motivasi Buruk</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['motivasi_buruk']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Masalah Penglihatan</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['masalah_penglihatan']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>cemas</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['cemas']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Tidak Di Temukan Hambatan Belajar</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['hambatan_belajar']}}</b>
             </td>
        </tr>





        <tr>
            <th colspan="6">Kebutuhan Edukasi</th>
        </tr>
             
        <tr>
            <td colspan="3">
              <b>Proses Penyakit</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['proses_penyakit']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Pengobatan</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['pengobatan']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Nutrisi</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['nutrisi']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Catatan</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['lainnya_kebutuhan']}}</b>
             </td>
        </tr>
        




        <tr>
            <th colspan="6">Alergi</th>
        </tr>
             
        <tr>
            <td colspan="3">
              <b>Tidak Alergi</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['tidak_alergi']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Alergi</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['ya_alergi']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Jelaskan Alergi</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['jelaskan_alergi']}}</b>
             </td>
        </tr>











        
        <tr>
            <th colspan="6">Status Pediatri</th>
        </tr>
             
        <tr>
            <td colspan="3">
              <b>Status Gizi</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['gizi']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Riwayat Imunisasi</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['imunisasi']}}</b>
             </td>
        </tr>
        <tr>
            <td colspan="3">
              <b>Riwayat Tumbuh Kembang</b>
            </td>
            <td colspan="3">
               <b>{{json_decode($soap->fisik,true)['jelaskan_alergi']}}</b>
             </td>
        </tr> --}}










    </table>
    <br>
    <!-- <table>
        <tr>
            <td style="text-align: right !important!;">
                Dicetak Tanggal<br>
                {{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}
            </td>
        </tr>
    </table> -->
    <table style="border: 0px;">
      <tr style="border: 0px;">
        <td colspan="3" style="text-align: center; border: 0px;">

        </td>
        <td colspan="3" style="text-align: center; border: 0px;">
          Dokter
        </td>
      </tr>
      <tr style="border: 0px;">
        <td colspan="3" style="text-align: center; border: 0px;">

        </td>
        <td colspan="3" style="text-align: center; border: 0px;">
          
        </td>
      </tr>
      <tr style="border: 0px;">
        <td colspan="3" style="text-align: center; border: 0px;">

        </td>
        <td colspan="3" style="text-align: center; border: 0px;">
          {{ baca_dokter(@$reg->dokter_id) }}
        </td>
      </tr>
    </table>

  </body>
</html>
 