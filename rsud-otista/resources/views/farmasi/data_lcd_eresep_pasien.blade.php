 <style>
    table, th, td {
        border: 0.4px solid white !important;
        font-size: 16px;
        background:rgba(14, 2, 2, 0.415);
        color: white;
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
  <div class="row">
    <div class="text-center col-md-6" style="margin: 3rem 0; height: 100%;">
      <h3 class="text-bold">NON RACIK</h3>
      @if (!empty($sedang_dipanggil_bpjs))
        <h2 class="text-bold" style="font-size: 300pt;" id="nomor_antrian">{{@$sedang_dipanggil_bpjs->nomor}}</h2>
        <h4 class="text-bold" style="font-size: 48pt;" id="nama_pasien">{{@$sedang_dipanggil_bpjs->pasien->nama}}</h4>
      @endif
    </div>
    
    <div class="text-center col-md-6" style="margin: 3rem 0; height: 100%;">
      <h3 class="text-bold">RACIK</h3>
      {{-- @if (!empty($sedang_dipanggil_umum))
        <h2 class="text-bold" style="font-size: 300pt;" id="nomor_antrian">{{@$sedang_dipanggil_umum->kelompok.''.@$sedang_dipanggil_umum->nomor}}</h2>
        <h4 class="text-bold" style="font-size: 48pt;" id="nama_pasien">{{@$sedang_dipanggil_umum->pasien->nama}}</h4>
      @endif --}}
    </div>
  </div>
 {{-- <div class="row">
  <div class="col-md-6" style="overflow: hidden;">
    <table class="table table-bordered table-striped">
   
   <div class="table-responsive">
    <div class="contain table-responsive" id="scrollContainer1" style="overflow: hidden;">
    <table class="table table-bordered table-hover">
      <table class="table" id="table-container1">
        <thead>
            <tr>
                <th scope="col">No Antrian</th>
                <th scope="col">No.RM</th>
                <th scope="col">Pasien</th>
                <th scope="col">Kode</th>
                @if ($unit !== 'inap')
                  <th class="text-center" scope="col">Poli</th>
                @endif
                @if ($unit == 'inap')
                  <th class="text-center">Kamar</th>
                @endif
                <th class="text-center" scope="col">Waktu Antrian</th>
                <th class="text-center" scope="col">Tahapan</th>
              </tr>
        </thead>
        <tbody id="x">
           
          @foreach ($data_belum_diproses as $key=> $item)
          <tr >
            <td scope="row">{{@$item->kelompok.''.@$item->nomor}}</td>
            <td class="text-left">{{@$item->registrasi->pasien->no_rm}}</td>
            <td class="text-left">{{@$item->registrasi->pasien->nama}}
              @if (@$item->jenis_resep == 'racikan')
                  <span style="color: orange">(Ada Racikan)</span>
              @endif
            </td>
            <td class="text-left">
              @php
                  @$Antri = \App\AntrianPoli::where('id',@$item->registrasi->antrian_poli_id)->first();
              @endphp
              @if( !baca_nomorantrian_bpjs(@$item->registrasi->nomorantrian) )
                  {{ @$Antri->kelompok .  @$Antri->nomor }}
              @else
                  {{ baca_nomorantrian_bpjs(@$item->registrasi->nomorantrian) }}
              @endif  
            </td>
            <td class="text-left">{{@$item->informasi}}</td>
            <td class="text-left">{{@baca_carabayar($item->registrasi->bayar)}}</td>
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
              @if (@$sedang_dipanggil->id == $item->id && $item->proses == "belum_diproses")
                <label for="" class="antrian blink_warning">Sedang Dipanggil</label>
              @else
                @if ($item->proses =='belum_diproses')
                     <label for="" class="antrian text-warning">dalam antrian</label>
                @elseif($item->proses == 'dibatalkan')
                     <label for="" class="text-danger">dibatalkan</label>
                @else
                    <label for="" class="blink_me text-success"> dalam proses</label>
                @endif
              @endif
            </td>

          </tr> 
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <div class="col-md-6" style="overflow: hidden;">
    <div class="contain table-responsive"  id="scrollContainer2" style="overflow: hidden;">
      <table class="table" id="table-container2">
        <thead>
            <tr>
                <th scope="col">No Antrian</th>
                <th scope="col">No.RM</th>
                <th scope="col">Pasien</th>
                <th scope="col">Bayar</th>
                @if ($unit !== 'inap')
                  <th class="text-center" scope="col">Poli</th>
                @endif
                @if ($unit == 'inap')
                  <th class="text-center">Kamar</th>
                @endif
                <th class="text-center" scope="col">Waktu Antrian</th>
                <th class="text-center" scope="col">Tahapan</th>
              </tr>
        </thead>
        <tbody id="x">
          @foreach ($data_sudah_diproses as $key=> $item)
          <tr>
            <td class="text-center">{{@$item->kelompok.''.@$item->nomor}}</td>
            <td class="text-left">{{@$item->registrasi->pasien->no_rm}}</td>
            <td class="text-left">{{@$item->registrasi->pasien->nama}}
              @if (@$item->jenis_resep == 'racikan')
                  <span style="color: orange">(Ada Racikan)</span>
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
                    <label for="" class="antrian text-warning">dalam antrian</label>
                @elseif($item->proses == 'dibatalkan')
                    <label for="" class="text-danger">dibatalkan</label>
                @elseif ($item->proses == 'selesai')
                    <label for="" class="label_success text-success">selesai</label>
                @else
                    <label for="" class="blink_me text-success"> dalam proses</label>
                @endif
            </td>

          </tr> 
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
 </div> --}}

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