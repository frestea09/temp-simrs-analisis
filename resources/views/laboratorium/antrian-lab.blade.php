@extends('master')

@section('header')
    <h1>Laboratorium {{date('d-m-Y')}} {{ucfirst($unit)}}</h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
                Belum Diperiksa &nbsp;
            </h3>
        </div>
        <div class="box-body" id="tableAntrianBelumPeriksa">

        </div>
        Keterangan <br>
        <button type="button" class="btn btn-sm btn-success btn-flat">
            <i class="fa fa-check"></i>
        </button> Tandai Selesai/Sudah di Proses
        &nbsp; &nbsp; &nbsp; &nbsp;
    </div>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
                Sudah Diperiksa &nbsp;
            </h3>
        </div>
        <div class="box-body">
            <div class='table-responsive' id="tableAntrianSudahPeriksa">
            </div>
        </div>
    </div>

@stop

@section('script')
    <script type="text/javascript">
        $('.select2').select2();

        function blink() {
            $('.blink_me').fadeOut(500).fadeIn(500, blink);
        }
        $(document).ready(function(){
            refreshTable();
            setInterval(() => {
                refreshTable();
            }, 15000);
        })
        function refreshTable() {
            var unit = '{{ $unit }}';
            $('#tableAntrianBelumPeriksa').load('/laboratorium/antrian-belum-periksa/' + unit);
            $('#tableAntrianSudahPeriksa').load('/laboratorium/antrian-sudah-periksa/' + unit);
        }
        function markAsDone(service_notif_id){
            $.get('/laboratorium/tandai-selesai/' + service_notif_id , function(response) {
                if(response.success == true){
                    refreshTable();
                }else{
                    alert('Gagal! ' + response.error)
                }
            })
            .fail(function(xhr, status, error) {
                console.error(status, error);
            });
        }
    </script>
@endsection
