
  
  <style>

.blink_me {
        animation: blinker 2s linear infinite;
        color: green;
      }

      @keyframes blinker {
        50% {
          opacity: 0;
        }
      }

  </style>
  {{-- @if($datanotif->status == 'Y')
      <b class="blink_me" >Baru</b>
  @elseif($datanotif->status == 'N')
      <b style="color:yellow">Menunggu</b>
  @else
      <b style="color:red">Selesai</b>
  @endif --}}
  @if($datanotif->status == 'Y')
      <b class="blink_me" >Baru</b>
  @endif

