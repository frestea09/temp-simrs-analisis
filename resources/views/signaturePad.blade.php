<html>
<head>
    <title>Signature Pad Dev</title>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap4.3.1.css')}}">
    <script src="{{ asset('style') }}/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="{{asset('assets/js/signature_pad.js')}}"></script>
    <link rel="stylesheet" href="{{ asset('style') }}/bower_components/font-awesome/css/font-awesome.min.css">

  
    <style>
        .kbw-signature { width: 100%; height: 200px;}
        #sig {
            /* width: 110% !important; */
        }
        .hidden {
            display: none;
        }
    </style>
  
</head>
<body style="background-color: #258dc8; padding: 2rem;">
<div class="container" style="background-color: white; padding: 1rem;">
    <div class="row justify-content-center">
        <div class="col-md-12 text-center">
            <h4 class="text-center text-primary" style="font-weight: bold;">
                SIGNATURE PAD <br>{{ config('app.nama') }} <br>
                <!-- {{ config('app.alamat') }}<br> -->
            </h4>
            @if ($message = Session::get('success'))
                <div class="alert alert-success  alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">×</button>  
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            <br>
            <form method="POST" action="{{ route('signaturepad.upload') }}" id="signature-form">
                {{ csrf_field() }}
                <div class="col-md-12 d-flex flex-column align-items-center">
                    <br>
                    <small class="text-danger" for="">Mohon untuk memastikan isi dokumen sebelum menandatangan!</small>
                    <br>
                    <label class="" for="">Tanda Tangan Sebagai (Nela Nurlima):</label>
                    <div class="col-4 p-0" style="border: 2px solid black; height: 400px;">
                        <canvas id="sig" ></canvas>
                    </div>
                    <br/>
                    <button id="clear" class="btn btn-danger btn-sm">Bersihkan Tanda Tangan</button>
                    <button id="save" type="submit" class="btn btn-success btn-sm" disabled>Proses Tanda Tangan</button>
                </div>
                <br/>
            </form>
            <div class="overlay hidden">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
            <div id="ttd-sukses-msg" style="display: none;">
                <span class="text-success">Tanda Tangan Berhasil</span><br>
                <span class="text-danger">Halaman akan di load ulang dalam <i>10 Detik</i></span>
            </div>
        </div>
    </div>

</div>
<script type="text/javascript">
    $('#clear').click(function(e) {
        e.preventDefault();
        signaturePad.clear();
        $('#save').prop('disabled', true);
    });
    const canvas = document.querySelector("canvas");
    const signaturePad = new SignaturePad(canvas, {
        backgroundColor: "rgb(0,0,0,0)"
    });
    signaturePad.addEventListener("endStroke", () => {
        $('#save').prop('disabled', false);
    }, { once: true });
    $('#save').click(function(e) {
        e.preventDefault();
        
        let dataPost = {
            signed: signaturePad.toDataURL(),
            _token: $('input[name="_token"]').val()
        }

        $.ajax({
            type: 'POST',
            url: '/signaturepad',
            data: dataPost,
            beforeSend: function (){
                $('#signature-form').addClass('hidden');
                $('.overlay').removeClass('hidden');
            },
            success: function (data) {
                if (data.sukses == true) {
                    $('.overlay').addClass('hidden');
                    $('#ttd-sukses-msg').show();
                    setTimeout(() => {
                        window.location.reload();
                    }, 10000);
                } else {
                    $('#signature-form').removeClass('hidden');
                }
            }
        });
    })
</script>
</body>
</html>