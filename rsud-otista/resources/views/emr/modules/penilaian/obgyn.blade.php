@extends('master')

<style>
    #canvas_div {
        text-align: center;
        display: block;
        margin-left: auto;
        margin-right: auto;
        padding-top: 50px;
    }
    canvas {
        border: 2px solid black;
    }
    .form-box td,
    select,
    input,
    textarea {
        font-size: 12px !important;
    }

    .history-family input[type=text] {
        height: 20px !important;
        padding: 0px !important;
    }

    .history-family-2 td {
        padding: 1px !important;
    }
</style>
@section('header')
    <h1>Penilaian Status Lokalis Obgyn</h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
            </h3>
        </div>
        <div class="box-body">
            <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">
            <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
            {{-- <script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script> --}}

            @include('emr.modules.addons.profile')
            <form class="form-horizontal">
                <div class="row">
                    <div class="col-md-12">
                        @include('emr.modules.addons.tabs')
                        {{ csrf_field() }}
                        {!! Form::hidden('registrasi_id', $reg->id) !!}
                        {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                        {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                        {!! Form::hidden('unit', $unit) !!}
                        <br>

                        <input type="hidden" id="pasienId" value="{{ @$reg->pasien_id }}">
                        <input type="hidden" id="caraBayars" value="{{ @$reg->bayar }}">
                        <input type="hidden" id="regId" value="{{ @$reg->id }}">
                        <input type="hidden" id="poli" value="{{ @$reg->poli_id }}">
                        <input type="hidden" id="dpjp" value="{{ @$reg->dokter_id }}">
                        <input type="hidden" id="unit" value="{{ @$unit }}">
                        <input type="hidden" id="cppt" value="{{ @$cppt_id }}">




                        {{-- Anamnesis --}}
                        <div class="col-md-6">
                           
                        </div>
                        {{-- Alergi --}}
                        {{-- <div class="col-md-6">
                            <div class="box box-solid box-warning">
                                <div class="box-header">
                                    <h5><b>Catatan Medis</b></h5>
                                </div>
                                <div class="box-body table-responsive" style="max-height: 400px">
                                    <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box bordered"
                                           style="font-size:12px;"> --}}
                                        {{-- @if (count($riwayat) == 0)
                                            <tr>
                                                <td><i>Belum ada catatan</i></td>
                                            </tr>
                                        @endif --}}
                                        {{-- @foreach ($riwayat as $item)
                                            <tr>
                                                <td>
                                                    <b>Keterangan	:</b> {{json_decode($item->fisik,true)['fisik']}}<br/>
                                                    {{date('d-m-Y, H:i:s',strtotime($item->created_at))}}</td>
                                            </tr>
                                        @endforeach --}}
                                    {{-- </table>
                                </div>
                            </div>
                        </div> --}}

                        <br /><br />


                    </div>
                </div>


              <div id="canvas_div" style="overflow-x: auto;">
               {{-- @if ( @$dataImage[0]["image"]  != null) --}}
                {{-- <canvas id="canvas" width="500" height="600" style="background-image: url('/images/{{ @$dataImage[0]["image"] }}')"></canvas>     
               @else --}}
                <canvas id="canvas" width="740" height="650" style="background-image: url('/images/bgObgyn.jpg')"></canvas>
               {{-- @endif --}}
              </div>
              <div class="text-center"
                    style="width: 100%; display:flex; justify-content:center; gap: 10px; margin-top: 10px">
                    <div class="btn btn-warning" onclick="clearArea()">Clear Area</div>
                    <div style="display: flex; align-items:center; gap:5px">
                        <span>Line Width: </span>
                        <input type="number" name="" class="form-control" id="selWidth" value="2"
                            style="width: 100px">
                    </div>
                    <div style="display: flex; align-items:center; gap:5px">
                        <span>Color: </span>
                        <input type="color" name="" class="form-control" id="selColor" value="#ff0000"
                            style="width: 100px">
                    </div>
                </div>
              



                <div class="col-md-12 text-right">
                    <a href="#" class="btn btn-success" onclick="saveDrawing();">Simpan</a>
                    {{-- <input type="submit" onclick="saveImage()"> --}}
                </div>

            </form>
        </div>



        <script>
    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');
    let isDrawing = false;
    let x = 0;
    let y = 0;
    var offsetX;
    var offsetY;

    function startup() {
      canvas.addEventListener('touchstart', handleStart);
      canvas.addEventListener('touchend', handleEnd);
      canvas.addEventListener('touchcancel', handleCancel);
      canvas.addEventListener('touchmove', handleMove);
      canvas.addEventListener('mousedown', (e) => {
        x = e.offsetX;
        y = e.offsetY;
        isDrawing = true;
      });

      canvas.addEventListener('mousemove', (e) => {
        if (isDrawing) {
          drawLine(context, x, y, e.offsetX, e.offsetY);
          x = e.offsetX;
          y = e.offsetY;
        }
      });

      canvas.addEventListener('mouseup', (e) => {
        if (isDrawing) {
          drawLine(context, x, y, e.offsetX, e.offsetY);
          x = 0;
          y = 0;
          isDrawing = false;
        }
      });
    }

    document.addEventListener("DOMContentLoaded", startup);

    const ongoingTouches = [];

    function handleStart(evt) {
      evt.preventDefault();
      const touches = evt.changedTouches;
      offsetX = canvas.getBoundingClientRect().left;
      offsetY = canvas.getBoundingClientRect().top;
      for (let i = 0; i < touches.length; i++) {
        ongoingTouches.push(copyTouch(touches[i]));
      }
    }

    function handleMove(evt) {
      evt.preventDefault();
      const touches = evt.changedTouches;
      for (let i = 0; i < touches.length; i++) {
        const color = document.getElementById('selColor').value;
        const idx = ongoingTouchIndexById(touches[i].identifier);
        if (idx >= 0) {
          context.beginPath();
          context.moveTo(ongoingTouches[idx].clientX - offsetX, ongoingTouches[idx].clientY - offsetY);
          context.lineTo(touches[i].clientX - offsetX, touches[i].clientY - offsetY);
          context.lineWidth = document.getElementById('selWidth').value;
          context.strokeStyle = color;
          context.lineJoin = "round";
          context.closePath();
          context.stroke();
          ongoingTouches.splice(idx, 1, copyTouch(touches[i]));  // swap in the new touch record
        }
      }
    }

    function handleEnd(evt) {
      evt.preventDefault();
      const touches = evt.changedTouches;
      for (let i = 0; i < touches.length; i++) {
        const color = document.getElementById('selColor').value;
        let idx = ongoingTouchIndexById(touches[i].identifier);
        if (idx >= 0) {
          context.lineWidth = document.getElementById('selWidth').value;
          context.fillStyle = color;
          ongoingTouches.splice(idx, 1);  // remove it; we're done
        }
      }
    }

    function handleCancel(evt) {
      evt.preventDefault();
      const touches = evt.changedTouches;
      for (let i = 0; i < touches.length; i++) {
        let idx = ongoingTouchIndexById(touches[i].identifier);
        ongoingTouches.splice(idx, 1);  // remove it; we're done
      }
    }

    function copyTouch({ identifier, clientX, clientY }) {
      return { identifier, clientX, clientY };
    }

    function ongoingTouchIndexById(idToFind) {
      for (let i = 0; i < ongoingTouches.length; i++) {
        const id = ongoingTouches[i].identifier;
        if (id === idToFind) {
          return i;
        }
      }
      return -1;    // not found
    }

    function drawLine(context, x1, y1, x2, y2) {
      context.beginPath();
      context.strokeStyle = document.getElementById('selColor').value;
      context.lineWidth = document.getElementById('selWidth').value;
      context.lineJoin = "round";
      context.moveTo(x1, y1);
      context.lineTo(x2, y2);
      context.closePath();
      context.stroke();
    }

    function clearArea() {
  var canvas = document.getElementById("canvas");
  var ctx = canvas.getContext("2d");
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  // canvas.style.backgroundImage = "url('/images/gigi.jpg')";
}
    </script>

        @endsection

        @section('script')

            <script type="text/javascript">
    $(".skin-red").addClass( "sidebar-collapse" );
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
          var target = $(e.target).attr("href") // activated tab
          // alert(target);
        });
        $('.select2').select2();
        $("#date_tanpa_tanggal").datepicker( {
            format: "mm-yyyy",
            viewMode: "months",
            minViewMode: "months"
        });
        $("#date_dengan_tanggal").attr('required', true);



  </script>

<script>

function saveDrawing(event) {
    var unit = $("#unit").val();
    var regId = $("#regId").val();
    var canvas = document.getElementById("canvas");
    var dataURL = canvas.toDataURL("image/png");
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    var fisik = $("#fisik").val();
    var pasienId = $("#pasienId").val();
    var caraBayar = $("#caraBayars").val();
    var cppt_id = $("#cppt").val();
    var poli = $("#poli").val();
    var dpjp = $("#dpjp").val();

    // buat temporary canvas untuk menggambar background
    var tmpCanvas = document.createElement('canvas');
    tmpCanvas.width = canvas.width;
    tmpCanvas.height = canvas.height;
    var tmpCtx = tmpCanvas.getContext('2d');
    var img = new Image();
    img.onload = function() {
        tmpCtx.drawImage(img, 0, 0);
        // tambahkan gambar yang tercoret ke dalam temporary canvas
        tmpCtx.drawImage(canvas, 0, 0);
        // simpan gambar dengan background yang tercoret
        var imageData = tmpCanvas.toDataURL('image/png');
        var formData = new FormData();
        formData.append('drawing', imageData);
        formData.append('registrasi_id', regId);
        formData.append('pasien_id', pasienId);
        formData.append('cara_bayar', caraBayar);
        formData.append('unit', unit);
        formData.append('fisik', fisik);
        formData.append('cppt_id', cppt_id);

        $.ajax({
            url: "/emr-soap/penilaian/obgyn/" + unit + "/" + regId,
            type: "POST",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': csrf_token
            },
            contentType: false,
            processData: false,
            success: function(data) {
                console.log(data);
                alert('Gambar berhasil tersimpan');
                // window.location.href = "/emr-soap/pemeriksaan/obgyn/"+unit+"/"+regId+"?poli="+poli+"&dpjp="+dpjp;
                window.open('','_self').close();
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                alert('Terjadi kesalahan saat menyimpan gambar.');
            }
        });
    };
    img.src = '/images/bgObgyn.jpg';
}



  </script>

        @endsection