 <style>
    table, th, td {
        border: 0.4px solid white !important;
        font-size: 16px;
        /* background:rgba(14, 2, 2, 0.415);
        color: white; */
        background: #C3DCF4;
        color: black;
    }

    

    /* .table-responsive{
        height:550px;
        width: 100%;
        overflow-y: auto;
        border:2px solid #444;
        }
        .table-responsive:hover{
          border-color:green;
        }
        table{
          width:100%;
        }
        td{
          padding:24px;
          background:rgba(14, 2, 2, 0.267);
        
        } */


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
     text-align: center;
	}

	td {
		/* width: 10%; */
		text-align: center;
    font-weight: bold;
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
  <div class="row">
    <div class="col-md-12">
      {{-- <h3 class="text-center"><strong>Dashboard E-Resep Pasien 24-02-2025 Jalan</strong></h3>
      <p class="text-center">Mohon menunggu antrian anda untuk dipanggil, terimakasih!</p> --}}
    
      <div class="row text-center">
        <div class="col-md-6 border">
          <h4>NON RACIK</h4>
          @if (!empty($sedang_dipanggil_bpjs))
            <h2 class="text-bold" style="font-size:200pt;" id="nomor_antrian">{{@$sedang_dipanggil_bpjs->nomor}}</h2>
            <h4 class="text-bold" style="font-size:50px;" id="nama_pasien">{{@$sedang_dipanggil_bpjs->pasien->nama}}</h4>
          @endif
        </div>
        <div class="col-md-6 border">
          <h4>RACIK</h4>
        </div>
      </div>
    
      <div class="row mt-4">
        <div class="col-md-6 border">
          <h5 class="text-center">RESEP SELESAI</h5>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th style="background: #54A8E2">No Antrian</th>
                <th style="background: #54A8E2">Nama Pasien</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($data_belum_diproses as $item)
                <tr style="text-align: left"><td style="width:125px;">{{$item->nomor}}</td><td>{{@$item->pasien->nama}}</td></tr>  
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="col-md-6 border">
          <h5 class="text-center">RESEP SELESAI</h5>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th style="background: #54A8E2">No Antrian</th>
                <th style="background: #54A8E2">Nama Pasien</th>
              </tr>
            </thead>
            <tbody>
              <!-- Tidak ada data -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
    
  </div>
  

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
    // var $el = $(".table-responsive");
    // function anim() {
    // var st = $el.scrollTop();
    // var sb = $el.prop("scrollSlow")-$el.innerHeight();
    // $el.animate({scrollTop: st<sb/2 ? sb : 0}, 20000, anim);
    // }
    // function stop(){
    // $el.stop();
    // }
    // anim();
    // $el.hover(stop, anim);

    // jQuery.fn.extend({
	  //       pic_scroll:function (){
	  //           $(this).each(function(){
	  //               var _this=$(this);
	  //               var ul=_this.find("table");
	  //               var li=ul.find("tbody");
	  //               var w=li.size()*li.outerHeight();
	  //               li.clone().prependTo(ul);
	  //               var i=1,l;
	  //               _this.hover(function(){i=0},function(){i=1});
	  //               function autoScroll(){
	  //               	l = _this.scrollTop();
	  //               	if(l>=w){
	  //               		_this.scrollTop(20);
	  //               	}else{
	  //               		_this.scrollTop(l + i);
	  //               	}
	  //               }
	  //               var scrolling = setInterval(autoScroll,50);
	  //           })
	  //       }
	  //   });
		// $(function(){
		// 	// var time1 = new Date;
		// 	$(".contain").pic_scroll();
		// })

 </script>
 
  
 <script>
  var scrollContainer2 = document.getElementById('scrollContainer2');
  var scrollContainer1 = document.getElementById('scrollContainer1');
  var scrollSpeed = 1; // Adjust this value to control the scroll speed
  // function autoScroll() {
  //     scrollContainer1.scrollTop += scrollSpeed;
  //     scrollContainer2.scrollTop += scrollSpeed;

  //     // Check if the bottom of the container is reached
  //     if (scrollContainer1.scrollTop + scrollContainer1.clientHeight >= scrollContainer1.scrollHeight - 1) {
  //         // Scroll back to the top
  //         setTimeout(() => {
  //           scrollContainer1.scrollTop = 0;
  //         }, 3000);
  //       }
        
  //       // Check if the bottom of the container is reached
  //       if (scrollContainer2.scrollTop + scrollContainer2.clientHeight >= scrollContainer2.scrollHeight - 1) {
  //         // Scroll back to the top
  //         setTimeout(() => {
  //           scrollContainer2.scrollTop = 0;
  //         }, 3000);
  //     }
  // }
  // Set an interval to call the autoScroll function
  // var scrollInterval = setInterval(autoScroll, 25); // Adjust the interval as needed
</script>