<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Notifikasi Eresep</title>
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('style') }}/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('style') }}/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('style') }}/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="{{ asset('Nivo-Slider/style/style.css') }}" type="text/css" />

    <script src="{{ asset('/js/tanggal.js') }}" charset="utf-8"></script>

    <style type="text/css" media="screen">
      body{
        background-color: #7FB77E;
      }
      #header{
        background-color: white;
        width: auto;
        height: 130px;
        /* border-top: 1px solid grey;
        border-bottom: 6px solid orange; */
        border-top: 1px solid grey;
        border-bottom: 6px solid green;

      }

      #judul{
        height: 150px;
        width: 100%;
        font-size: 28pt;
        font-weight: bold;
        color: green;
        margin-top: 3px;
        background-color: orange;
        border-top: 0;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
        padding: 15px 20px;
        -webkit-box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
        -moz-box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
        box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
        /* text-shadow: 1px 1px 2px #000000; */
      }

      .blockloket{
        height: 550px auto !important;
        width: 100%;
        margin:20px auto;
        background-color:none;
        -webkit-box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
        -moz-box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
        box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.4);
        background-color: white;
        float: left;
        border-radius: 3px;
        /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#f8ffe8+0,e3f5ab+0,b7df2d+100 */
        background: #EEF1FF; /* Old browsers */
      }

      .loketheader{
          width: 100%;
          height: 85px;
          padding: 10px 20px;
          color: white;
          font-weight: bold;
          text-shadow: 3px 3px 5px #000000;
          font-size: 34pt;
          border-bottom: 1px solid green;
          /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#bfd255+0,72aa00+0,72aa00+38,8eb92a+70,9ecb2d+100 */
          background: #AAC4FF; /* Old browsers */
      }

      .logo{
        width: 200px;
        float: left;
        margin-right: 20px;
      }
      .nama{
        font-weight: bold;
        padding-top: 10px;
        font-size: 25pt;
        color: green;
        float: left;
        text-shadow: 1px 1px 0px #000000;

      }
      .alamat{
        font-size: 13pt;
        margin-right: 130px;
      }
      .tanggal{
        font-size: 24px;
        font-weight: bold;
        color: green;
        padding-top: 35px;
        text-shadow: 1px 1px 0px #000000;
      }
      .btn-area{
          padding-top: 20px;
          width: 100%;
          font-family: Verdana;
          color: green;
          font-size: 100pt;
          letter-spacing: -5px;
          font-weight: bold;
          text-shadow: 2px 2px 2px #000000;

      }
    </style>
  <body>

<div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        
            <div class="blockloket">
                <div class="loketheader text-center" style="font-size: 40pt !important;">
                    INFORMASI E-RESEP PASIEN
                    {{-- {{date('d-m-Y')}} {{ucfirst($unit)}}--}}
                </div>
                <br/>
                <div class="text-center" style="z-index: 99">
                    <div class="row">
                        <div class="col-md-12"><br/><br/>
                          <table class="table table-bordered table-striped" style="font-size: 20pt !important;">
                            <thead>
                              <tr>
                                <th scope="col">#</th>
                                <th scope="col">No.RM</th>
                                <th scope="col">Pasien</th>
                                <th scope="col">Bayar</th>
                                @if ($unit !== 'inap')
                                  <th class="text-center" scope="col">Poli</th>
                                @endif
                                @if ($unit == 'inap')
                                  <th class="text-center">Kamar</th>
                                @endif
                                <th class="text-center" scope="col">Waktu</th>
                                <th class="text-center" scope="col">Status</th>
                              </tr>
                            </thead>
                            <tbody>
                        
                                @foreach ($data_belum_diproses as $key=> $item)
                                <tr>
                                  <th scope="row">{{$key+1}}</th>
                                  <td class="text-left">{{@$item->registrasi->pasien->no_rm}}</td>
                                  <td class="text-left">{{@$item->registrasi->pasien->nama}}
                                    @if (@$item->jenis_resep == 'racikan')
                                        <span style="color:green">(Ada Racikan)</span>
                                    @endif
                                  </td>
                                  <td class="text-left">{{@baca_carabayar($item->registrasi->bayar)}}</td>
                                  @if ($unit !== 'inap')
                                  <td>
                                    @php
                                      $histori = \App\HistorikunjunganIRJ::where('registrasi_id',@$item->registrasi->id)->orderBy('id','DESC')->first();
                                    @endphp
                                    
                                    @if ($histori)
                                      {{baca_poli(@$histori->poli_id)}}  
                                    @else
                                      {{@$item->registrasi->poli->nama}}
                                    @endif
                                  </td>
                                  @endif
                                  @if ($unit =='inap')
                                  @php
                                    $irna = \App\Rawatinap::where('registrasi_id',@$item->registrasi->id)->first();
                                  @endphp
                                  <td>
                                    @if ($irna)
                                      {{@baca_kamar(@$irna->kamar_id)}}
                                    @endif
                                  </td>
                                  @endif
                                  <td>{{@date('H:i',strtotime($item->created_at))}}</td>
                                  <td>
                                    @if ($item->proses =='belum_diproses')
                                         <label for="" class="text-warning">DALAM ANTRIAN</label>
                                    @elseif($item->proses == 'dibatalkan')
                                         <label for="" class="text-danger">DI BATALKAN</label>
                                    @else
                                        <label for="" class="text-success"> <blink>DI PROSES</blink> </label>
                                    @endif
                                  </td>
                                </tr> 
                                @endforeach
                               
                            </tbody>
                          </table>
                        
                        </div>
                      
                        
                       </div>

                </div>
                
            </div>
        {{-- </div> --}}

      </div>
    </div>
    <div class="row">
        <div class="text-center" style="font-size: 23pt; font-weight: bold; color:white;">
          {{ configrs()->antrianfooter }}
        </div>
      </div>


</div>

  
        <style>
            blink {
              -webkit-animation: 2s linear infinite kedip; /* for Safari 4.0 - 8.0 */
              animation: 2s linear infinite kedip;
            }
            
            /* for Safari 4.0 - 8.0 */
            @-webkit-keyframes kedip { 
              0% {
                visibility: hidden;
              }
              50% {
                visibility: hidden;
              }
              100% {
                visibility: visible;
              }
            }
            
            @keyframes kedip {
              0% {
                visibility: hidden;
              }
              50% {
                visibility: hidden;
              }
              100% {
                visibility: visible;
              }
            }</style>
           

  <META HTTP-EQUIV="REFRESH" CONTENT="{{70}}"; URL={{ url('/display/eresep/'.$unit) }}">

  </body>
  
</html>
