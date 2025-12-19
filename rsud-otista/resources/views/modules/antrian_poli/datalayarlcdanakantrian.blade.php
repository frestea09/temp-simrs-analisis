
<style>
 .qbox {
  height: 260px;
  width: 100%;
  box-sizing: border-box;
  overflow: hidden;
}

.marq {
  position: relative;
  box-sizing: border-box;
}

.item {
  background: #4CAF50;
  color: white;
  box-sizing: border-box;
  padding: 5px;
  margin-bottom: 8px;
}
table{
        line-height: 2.4; 
        font-size: 28px; 
        font-weight: bold;
        text-align: center;
        width: 100%;
      }
</style>
<script>

// $(document).ready(function() {

// $m = $('.marq');
// $q = $('.qbox');
// var mh = $m.height();
// var qh = $q.height();
// var currscr = 0;

// var interval;
// var waitingTimeBottom = 3000;
// var waitingTimeTop = 5000

// scroll();

// function scroll() {

//     var xpx = mh - qh;
//     if (mh > qh) {
//         currscr = xpx;

//         interval = setInterval(function() {
//             autoscroll();
//         }, 50);

//     } else {
//         console.log("too few items");
//     }
// }

// function autoscroll() {

//     if (currscr > 0) {
//         var ch = $m.css('top').replace('px', '');
//         $m.css('top', (ch - 1) + 'px');
//         --currscr;
//     } else {
//         clearInterval(interval);
//         $m.delay(waitingTimeBottom).animate({
//             'top': '0px'
//         }, 3000, function() {
//             setTimeout(function() {
//                 scroll();
//             }, waitingTimeTop);
//         });
//     }
// }

// });

</script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> --}}
<div class="qbox">
  <div class="marq">
    <table class="table">
        @foreach ($antrian as $key => $d)
        <tr>
            <td style="padding-left:0px;width: 30%"">{{ $d->kelompok}} {{ $d->nomor}}</td>
            <td style="padding-left: 40px;width: 100%">{{ baca_pasien($d->pasien_id)}}</td>
        </tr>
      @endforeach
    <table>
  </div>
</div>