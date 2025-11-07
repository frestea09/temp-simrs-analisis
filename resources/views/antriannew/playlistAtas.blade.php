<!DOCTYPE html>
<html lang="">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Suara Antrian</title>
    <style type="text/css">
      .bg-image{
        /* background: url("/images/bg-rsu.png") no-repeat center center; */
        background-image: linear-gradient(-60deg, #ff5858 0%, #f09819 100%);
      }
      .my-container {
        position: fixed;
        background: #5C97FF;
        overflow: hidden;
      }
      .bg-image:after {
        content: '';
        display: block;
        position: absolute;
        z-index: 0;
        left: 25%;
        top: 0;
        width: 50%;
        height: 100%;
        z-index: 1;
        margin: 0 auto;
        opacity: 0.2;
        background-repeat: no-repeat;
        -ms-background-size: contain;
        -o-background-size: contain;
        -moz-background-size: contain;
        -webkit-background-size: contain;
        background-size: contain;
        background-position: center center;
      }
      h2{
        color: white;
        font-family: 'Verdana';
        text-shadow: 1px 1px 1px #000000;
        text-align: center;
      }
      h3{
        color: white;
        font-family: 'Verdana';
        text-shadow: 1px 1px 1px #000000;
        text-align: center;
        font-size: 50px;
      }
      .besar { 
        text-transform: uppercase; 
      }
      .logo{
        margin-top: 20px;
        margin-left: 40%;
        text-align: center;
      }
      .notif{
        bottom: 10px;
        position: fixed;
        color: white;
        font-family: 'Verdana';
        text-shadow: 1px 1px 1px #000000;
        text-align: left;
      }
      .layarantrian a{
        bottom: 20px;
        right: 20px;
        position: fixed;
        color: white;
        font-family: 'Serif';
        text-shadow: 1px 2px 2px #000000;
        text-align: right;
        font-size: 20pt;
        text-decoration: none;

      }
    </style>

  </head>
  <body class="hold-transition login-page bg-image"> 
    <div class="row">
        <div class="col-md-12" id="suara_antrian_new"></div>
      </div>
    <!-- jQuery 3 -->
    <script src="{{ asset('/js/jquery.js') }}"></script>
    <script type="text/javascript">
      jQuery(document).ready(function (){
        var audioArray = document.getElementsByClassName('antrian');
        var i = 0;
        audioArray[i].play();
        for (i = 0; i < audioArray.length - 1; ++i) {
            audioArray[i].addEventListener('ended', function(e){
              var currentSong = e.target;
              var next = $(currentSong).nextAll('audio');
              if (next.length) $(next[0]).trigger('play');
            });
        }
      });
  </script>

@foreach ($antrian as $key => $d)
  <audio id="song-{{ $start + $no }}" preload class="antrian">
    <source src="/audio/nomorurut.mp3" type="audio/mpeg" muted="muted"/>
  </audio>
  <audio id="song-{{ $start + $no }}" preload class="antrian">
    <source src="/audio/{{ $d->kelompok }}.mp3" type="audio/mpeg"muted="muted" />
  </audio>
  <audio id="song-{{ $start + $no }}" preload class="antrian">
    <source src="/audio/{{ $d->suara }}" type="audio/mpeg" muted="muted" />
  </audio>
  <audio id="song-{{ $start + $no }}" preload class="antrian">
    <source src="/audio/diloket.mp3" type="audio/mpeg" muted="muted"/>
  </audio>
  <audio id="song-{{ $start + $no }}" preload class="antrian">
    <source src="/audio/{{ $d->loket }}.mp3" type="audio/mpeg" muted="muted"/>
  </audio>
  @php
    DB::table('antrians')->where('id', $d->id)->update(['panggil' => 1]);
  @endphp
@endforeach
   

  {{-- <META HTTP-EQUIV="REFRESH" CONTENT="{{ $delay }}"> --}}

  </body>
  <script type="text/javascript">
  
</script>
</html>
