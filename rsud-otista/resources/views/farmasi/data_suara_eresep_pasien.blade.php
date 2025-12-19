 <style>
    table, th, td {
        border: 0.4px solid white !important;
        font-size: 16px;
        background:rgba(14, 2, 2, 0.415);
        color: white;
    }

  .contain{
    height: 85vh;
    position: relative;
		width: 100%;
		overflow: auto;
	}

	.contain table thead th {
		position: sticky; 
		top: 0; 
		background: rgba(11, 2, 2, 0.923);
		border-top: 0px;
	}

	table{
		line-height: 2.4; 
		font-size: 14px; 
		text-align: center;
	}

	th {
		 background-color: #eee;
	}

	td {
		/* width: 10%; */
		text-align: center;
	}

     .blink_me {
        animation: blinker 2s linear infinite;
        color: #f6ce06;
      }

     .blink_warning {
        animation: blinker 2s linear infinite;
        color: #ffb804 !important;
      }

     .label_success {
        color: #00ff08 !important;
      }

      .antrian{
         color: white;
      }

      @keyframes blinker {
        50% {
          opacity: 0;
        }
      }
 </style>
 {{-- <p class="text-right">* klik di mana saja, jika suara tidak muncul</p> --}}
 @if (!empty($sedang_dipanggil_bpjs))
  <div class="text-center" style="margin: 3rem 0;">
    <h3 class="text-bold">NOMOR ANTRIAN BPJS</h3>
    <h2 class="text-bold" id="nomor_antrian">{{@$sedang_dipanggil_bpjs->kelompok.''.@$sedang_dipanggil_bpjs->nomor}}</h2>
    <h4 class="text-bold" id="nama_pasien">{{@$sedang_dipanggil_bpjs->pasien->nama}}</h4>
  </div>
 @endif
 @if (!empty($sedang_dipanggil_umum))
  <div class="text-center" style="margin: 3rem 0;">
    <h3 class="text-bold">NOMOR ANTRIAN UMUM</h3>
    <h2 class="text-bold" id="nomor_antrian">{{@$sedang_dipanggil_umum->kelompok.''.@$sedang_dipanggil_umum->nomor}}</h2>
    <h4 class="text-bold" id="nama_pasien">{{@$sedang_dipanggil_umum->pasien->nama}}</h4>
  </div>
 @endif


@if (!empty($sedang_dipanggil_bpjs) && $sedang_dipanggil_bpjs->panggil_play == 0)
  @php
      $sedang_dipanggil_bpjs->update(['panggil_play' => '1']);
  @endphp
  {{-- <audio id="notif" preload class="notif">
      <source src="/audio/in.mp3" type="audio/mpeg" />
  </audio> --}}
  {{-- <audio id="notif" preload class="notif">
    <source src="/audio/nomorurut.mp3" type="audio/mpeg" />
  </audio> --}}
  @if ($sedang_dipanggil_bpjs->kelompok)  
    <audio id="notif" preload class="notif">
      <source src="{{"/audio/$sedang_dipanggil_bpjs->kelompok.mp3"}}" type="audio/mpeg" />
    </audio>
  @endif
  <audio id="notif" preload class="notif">
    <source src="{{"/audio/$sedang_dipanggil_bpjs->nomor.mp3"}}" type="audio/mpeg" />
  </audio>
@endif
@if (!empty($sedang_dipanggil_umum) && $sedang_dipanggil_umum->panggil_play == 0)
  @php
      $sedang_dipanggil_umum->update(['panggil_play' => '1']);
  @endphp
  {{-- <audio id="notif" preload class="notif">
      <source src="/audio/in.mp3" type="audio/mpeg" />
  </audio>
  <audio id="notif" preload class="notif">
    <source src="/audio/nomorurut.mp3" type="audio/mpeg" />
  </audio> --}}
  @if ($sedang_dipanggil_umum->kelompok)  
    <audio id="notif" preload class="notif">
      <source src="{{"/audio/$sedang_dipanggil_umum->kelompok.mp3"}}" type="audio/mpeg" />
    </audio>
  @endif
  <audio id="notif" preload class="notif">
    <source src="{{"/audio/$sedang_dipanggil_umum->nomor.mp3"}}" type="audio/mpeg" />
  </audio>
@endif

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

 <script>
      $(document).ready(function() { 
       

       var audioArray = document.getElementsByClassName('notif');
       var i = 0;
       if(audioArray.length !== 0){
           audioArray[i].play();
           for (i = 0; i < audioArray.length - 1; ++i) {
               audioArray[i].addEventListener('ended', function(e){
                 var currentSong = e.target;
                 var next = $(currentSong).nextAll('audio');
                 if (next.length) $(next[0]).trigger('play');
               });
           } 
       }

   });
 </script>