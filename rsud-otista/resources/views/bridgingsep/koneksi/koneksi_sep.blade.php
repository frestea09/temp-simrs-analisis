<div class="">
  <div class="operlay">
    &nbsp;<br/>
  <i style="font-size:30px" class="fa fa-refresh fa-spin"></i>
  </div>
    <b><span class="status"></span></b><br/>
    <span class="text-primary" style="font-size:16px;">
      <br/><b>
        <span class="ping"></span>
        </b></span>
</div>

<script type="text/javascript">
  $(document).ready(function() {
      type = '{{$type}}'
      $.ajax({
        url: '/data-koneksi-vclaim/'+type,
        dataType: 'json',
        beforeSend: function () {
        },
        complete: function () {
           $('.operlay').addClass('hidden')
        }
      })
      .done(function(res) {
        if(res.status == 'Terputus'){
          $('.ping').append('<span style="color:red">'+res.ping+'</span>')
          $('.status').append('<span style="color:red">'+res.status+'</span>')
        }else{
          $('.ping').append(res.ping)
          $('.status').append(res.status)

        }
      });
  });

</script>