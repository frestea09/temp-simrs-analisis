
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>RUMAH SAKIT UMUM DAERAH OTO ISKANDAR DI NATA</title>

  <link rel="shortcut icon" href="assets/img/favicon.ico" />
    
  <!-- Bootstrap core CSS -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,200i,300,300i,400,400i,600,600i,700,700i,900,900i" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Merriweather:300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template -->
  <link href="assets/css/display.css" rel="stylesheet">

</head>

<body onload="goforit()">
	<div class="gap">&nbsp;</div>
	
    <div class="header">
        <div class="header-bg"></div>
        <span id="clock" class="clock-right"></span>
    </div>
    
    <div class="sidebar">
        <div class="sidebar-bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-12 my-auto">
                    <div class="sidebar-content">
                        
                        <div class="loketbigtop">
                            <div class="loketbigtop-bg"></div>
                            <div class="row h-100">
                                <div class="my-loketbigtop">
                                    <div id="loket_panggil"></div>
                                </div>
                            </div>
                        </div>

                        <div class="loketbig">
                            <div class="loketbig-bg"></div>
                            <div class="row h-100">
                                <div class="my-loketbig">
                                    <div class="loketbig-content">
                                        <div class="top">ANTRIAN PENDAFTARAN</div>
                                        <div class="content">
                                            <div id="antrian_loket_panggil"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="side-right">
        <div class="video-player">
            <div class="overlay"></div>
            <video id="myVideoss" autoplay="autoplay" muted="muted" loop>
                <source class="active" src="assets/video/video_display_jkn.mp4" type="video/mp4">
            </video>
        </div>
    </div>

    <div class="clear"></div>
    
    <div class="loket">
        <div class="loket-bg"></div>
        <div class="row h-100">
            <div class="my-loket">
                <div class="loket-content">
                    <div class="top">LOKET 01</div>
                    <div class="content">
                        <div id="antrian_loket1"></div>
                    </div>
                </div>
            </div>
            <div class="my-loket">
                <div class="loket-content">
                    <div class="top">LOKET 02</div>
                    <div class="content">
                        <div id="antrian_loket2"></div>
                    </div>
                </div>
            </div>
            <div class="my-loket">
                <div class="loket-content">
                    <div class="top">LOKET 03</div>
                    <div class="content">
                        <div id="antrian_loket3"></div>
                    </div>
                </div>
            </div>
            <div class="my-loket">
                <div class="loket-content">
                    <div class="top">LOKET 04</div>
                    <div class="content">
                        <div id="antrian_loket4"></div>
                    </div>
                </div>
            </div>
        
        </div>
    </div>
    
    <div class="runningtext">
        <div class="row h-100 ">
            <div class="runningtext-content">
<!--                <marquee behavior="scroll" direction="left">Information running text... </marquee>-->
                <div id="slideshow"></div>
            </div>
            
        </div>
    </div>
    
    
	<div id="audio_antrian"></div>
	
  <!-- Bootstrap core JavaScript -->
<!--   <script src="assets/vendor/jquery/jquery.min.js"></script> -->
  <script src="http://172.168.1.5/simrs/resources/jquery/jquery-1.11.1.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Custom scripts for this template -->
  <script src="assets/js/display.js"></script>
  <script src="http://172.168.1.5/simrs/resources/assets/js/clock.js"></script>

    
    <script type="text/javascript">

		$(document).ready(function(){
   
			load_information();
            cek_call_loket();
            load_loket_all();

			//refresh per 1 minute = 60000
			setInterval(function(){
                cek_call_loket();
				
			},3000);//2000 
			
			setInterval(function(){
                load_loket_all();			
			},60000);//5000

			
			setInterval(function() { 
			  	$('#slideshow > div:first')
			    .fadeOut(1000)
			    .next()
			    .fadeIn(2000)
			    .end()
			    .appendTo('#slideshow');
			},  6000);//6000

			setInterval(function(){
                load_information();
                
			},120000);//120000

			/*
			var myvid = document.getElementById('myVideo');
			myvid.addEventListener('ended', function(e) {
			  // get the active source and the next video source.
			  // I set it so if there's no next, it loops to the first one
			  var activesource = document.querySelector("#myVideo source.active");
			  var nextsource = document.querySelector("#myVideo source.active + source") || document.querySelector("#myVideo source:first-child");
			  
			  // deactivate current source, and activate next one
			  activesource.className = "";
			  nextsource.className = "active";
			  
			  // update the video source and play
			  myvid.src = nextsource.src;
			  myvid.play();
			});*/
			
		}); 

		function cek_call_loket(){
			
            $.ajax({
				type: "POST",
				url: "ajax/call.php",
                data: "loket=reguler",
				success: function(msg){				

                    //alert(msg);
                    if(msg != 0){
                        var suara = msg.split('|');
                        var call_id = suara[0];
                        var call_voice = suara[1];
                        
                        if(call_id > 0){
                            //update call status
                        	update_calling(call_id);

                			$( "#loket_panggil" ).html('LOKET '+ suara[5]);
        					$( "#antrian_loket_panggil" ).html(suara[7]);
        					load_loket_all();	
                            
                            //load voice
                            $( "#audio_antrian" ).html(call_voice);

                         	// update ended voice #wav11
							$("#wav11").bind('ended', function(){
	            			    // done playing
	                        	update_calling_finish(call_id,suara[3],suara[4],suara[5],suara[6]);
	                        	//reset_calling();
								
                    
	                            load_loket_all();	
	            			});
	            			
                        }

                        return true;
                    }

                    return false;
				}
			});
            return false;
		}
        
        function update_calling(id_call){
            $.ajax({
				type: "POST",
				url: "ajax/call_update.php",
                data: "id_call="+id_call,
				success: function(msg){				
                    //alert(msg);
                    
					return false;
				}
			});
		}

        function update_calling_finish(id_call, id_antrian, tipe, loket, user){
            $.ajax({
				type: "POST",
				url: "ajax/call_update_finish.php",
                data: "is_ended=yes&id_call="+id_call+"&id_antrian="+id_antrian+"&loket_type="+tipe+"&loket="+loket+"&user="+user,
				success: function(msg){				
                    //alert(msg);
                    //$( "#loket_panggil" ).html('LOKET '+loket);
					return msg;
				}
			});
			
			return false;
		}

        function reset_calling(){
            $.ajax({
				type: "POST",
				url: "ajax/reset_calling.php",
				success: function(msg){				
                    //alert(msg);
                    
					return msg;
				}
			});
			
			return false;
		}
		
		function load_loket_all(){
            $.ajax({
				type: "POST",
				url: "ajax/display.php",
                data: "loket_type=reguler",
				success: function(msg){				
                    var loket = msg.split('|');
                    //alert(msg);
                    
					$( "#antrian_loket1" ).html(loket[2]);
					$( "#antrian_loket2" ).html(loket[3]);
					$( "#antrian_loket3" ).html(loket[4]);
					$( "#antrian_loket4" ).html(loket[5]);
					
					$( "#antrian_loket_panggil" ).html(loket[0]);
					$( "#loket_panggil" ).html('LOKET 0'+loket[1]);
					return false;
				}
			});
		}

		function load_information(){
            $.ajax({
				type: "POST",
				url: "ajax/information.php",
                data: "position=display_antrian",
				success: function(msg){				
					$( "#slideshow" ).html(msg);
					return false;
				}
			});
		}
		
    </script>
</body>
</html>

