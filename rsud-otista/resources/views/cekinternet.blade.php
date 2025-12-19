<?php
//buat fungsi untuk cek internet
function cek_internet(){
 $connected = @fsockopen("www.google.co.id", 80);
 if ($connected){
  $is_conn = true; //jika koneksi tersambung
  fclose($connected);
 }else{
  $is_conn = false; //jika koneksi gagal
 }
 return $is_conn;
}
?>

@if (cek_internet() == true)
<i class="fa fa-circle text-success" style="font-size:8pt">Online</i>
@else
<i class="fa fa-circle text-yellow" style="font-size:8pt">Offline</i>
    
@endif
