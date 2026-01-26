<style>
    .card-body{
        min-height: 100px !important;
    }
    .btn-pointer{
        cursor: pointer;
    }
    .bg-disable{
        background-color: #d1d1d1 !important;
        pointer-events: none !important;
    }
</style>
<div class="row">
    <div class="col-md-12">
        {{-- <form method="POST" action="http://172.168.1.175/antrian/klinik-savetouch-new" accept-charset="UTF-8"><input name="_token" type="hidden"> --}}
            
        <form id="form-bc" method="POST" action="" accept-charset="UTF-8">
            {{ csrf_field() }}
            @if ($loket == 'B')
                <input name="kelompok" type="hidden" value="B">
                <input name="bagian" type="hidden" value="bawah">
            @else
                <input name="kelompok" type="hidden" value="C">
                <input name="bagian" type="hidden" value="atas">
            @endif
            <input name="tanggal" type="hidden" value="{{date('Y-m-d')}}">
            <input name="poli_id" id="poli_id" type="hidden" value="">
            <input name="pasienbaru" id="pasienbaru" type="hidden" value="">
            <input name="cek_norm" id="cek_norm" type="hidden" value="">
            <input name="pasien_id" id="pasien_id" type="hidden" value="">
            
            
            <div class="row" id="section-poli">
                
                @foreach ($poli as $item)
                    @php
                        $jam_sekarang = date('H:i:s');
                        $jam_buka     = $item->buka;
                        $jam_tutup     = $item->tutup;
                        $kuota = hitung_kuota_poli($item->id,date('Y-m-d'));
                    @endphp
                    
                    <div class="col-md-3">
                        @if ($jam_sekarang >= $jam_buka)
                            @if ($jam_sekarang <= $jam_tutup)
                                <button type="button" onclick="pilihPoli({{$item->id}})" {{$kuota == 0 ? 'disabled' :''}} class="card bg-orange text-white text-center {{$kuota == 0 ? 'bg-disable' :''}}" style="width:100%">   
                            @else
                                <button type="button" disabled class="card bg-orange text-white text-center bg-disable" style="width:100%">
                            @endif
                        @else
                            <button type="button" disabled class="card bg-orange text-white text-center bg-disable" style="width:100%">
                        @endif

                            <div class="card-body" style="width:100%">
                                <div class="no-block align-items-center text-center">
                                    <h3 class="font-weight-medium mb-2 mt-2 text-white">{{$item->nama}}</h3>
                                </div>
                            </div>
                        </button>
                    </div>
                @endforeach
            </div>

            <div class="row" id="section-baru-lama">
                <div class="col-md-3" style="padding:10px;"></div>
                <div class="col-md-3" style="padding:10px;">
                    <div class="card bg-cyan text-white btn-pointer" id="btn_lama">
                        <div class="card-body">
                            <div class="no-block align-items-center text-center">
                                <h2 class="font-weight-medium mb-0 mt-2 text-white">PASIEN LAMA</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3" style="padding:10px;">
                    <div class="card bg-info text-white btn-pointer" id="btn_baru">
                        <div class="card-body">
                        <div class="no-block align-items-center text-center">
                                <h2 class="font-weight-medium mb-0 mt-2 text-white">PASIEN BARU</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3" style="padding:10px;"></div>
            </div>
            
            <div class="row" id="section-cek-mr">
                <div class="col-md-2" style="padding:10px;"></div>
                <div class="col-md-5" style="padding:10px;">
                    <div class="form-group">
                        <label for="no_rm">No. Rekam Medik (RM)</label>
                        <div class="input-group mb-3">
                        <input type="text" id="no_rm" name="no_rm" class="keyboard form-control form-control-lg">
                            <div class="input-group-append">
                                <button onclick="tampil_data()" class="btn btn-info" type="button">Cek Data</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" style="padding:10px;"></div>
            </div>
            <div class="row">
                <div class="col-md-2" style="padding:10px;"></div>
                <div class="col-md-8 dataMR d-none mt-1">
                    <div class="card border-success">
                        <h3>Data Pasien</h3>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="dataPasien"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            
        </form>
        
    </div>
</div>


<script type="text/javascript">
$(document).ready(function() {

    $('#no_rm').keyboard();
    // $('#no_rm').keyboard({type:'tel'});

    $('#section-poli').show();
    $('#section-baru-lama').hide();
    $('#section-cek-mr').hide();
    $('#dataPasien').html('');

    $('#btn_lama').on('click', function() {
        $('#pasienbaru').val(0);

        $('#section-poli').hide();
        $('#section-baru-lama').hide();
        $('#section-cek-mr').show();

        $('#no_rm').focus();
        
    });

    $('#btn_baru').on('click', function() {
        $('#pasienbaru').val(1);
        $('#modalPoli').modal('hide');

        //save
        // $('#form-bc').attr('action', 'http://otista-simrs.test/antrian/savetouch');
        $('#form-bc').attr('action', 'http://172.168.1.175/antrian/savetouch');
    
        $('#form-bc').trigger( "submit" );

        $('#form-bc').submit(function() {
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                dataType: 'json',
                success: function(json) {
                    window.location.href = env('APP_URL')+"/v2";
                }
            })
            return false;
        });

    });

});

function tampil_data() {
    let no_rm = $('#no_rm').val();
   
    $('.dataMR').addClass('d-none')
    $('.respon').html('');
    if(no_rm != ''){
        $.ajax({
            url: '/reservasi/cari-pasien-rm',
            type: 'POST',
            dataType: 'json',
            data: {
                _token: $("input[name='_token']").val(),
                keyword: no_rm
            }, 
            beforeSend: function () {
                $('.btn_cekMR').addClass('disabled')
                $('.spinner-border').removeClass('d-none')
            },
            complete: function () {
                $('.btn_cekMR').removeClass('disabled')
                $('.spinner-border').addClass('d-none')
            }
        })
        .done(function(data) {
            // console.log(data)
            // var decompressData = LZString.decompressFromBase64(res);  
            // data = JSON.parse(res) 
            if (data.status == 200) {
                $('.dataMR').removeClass('d-none');
                var val = data.result;
                $('#cek_norm').val(val.no_rm);
                $('#pasien_id').val(val.id);

                $('#dataPasien').html('<table class="table" width="100%"><tr> <th>No.RM</th><td>'+(val.no_rm)+'</td></tr><tr><th>Nama</th><td>'+(val.nama)+
                    '</td></tr><tr><th>Alamat</th><td>'+(val.alamat)+
                    '</td></tr><tr><th>No.HP</th><td>'+(val.nohp)+
                    '</td></tr><tr><th>Tempat, Tgl.Lahir</th><td>'+(val.tmplahir)+', '+(val.tgllahir)
                    +'</td></tr><tr><th>&nbsp;</th><td class="text-left"><button type="button" onclick="printKarcisKlinik()" class="btn btn-success btn-pilih col-form-label"><i class="fa fa-arrow-right"></i> &nbsp;Lanjutkan</button></td></tr></table>');

            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Maaf...',
                    text: data.result
                })
            }
        });
    }else{
        Swal.fire({
            icon: 'error',
            title: 'Maaf...',
            text: 'Nomor RM belum diisi!'
        })
    }
}

function printKarcisKlinik() {

    $('#modalPoli').modal('hide');
    //save
    // $('#form-bc').attr('action', 'http://otista-simrs.test/antrian/klinik-savetouch-new');
    $('#form-bc').attr('action', 'http://172.168.1.175/antrian/klinik-savetouch-new');
    
    $('#form-bc').trigger( "submit" );

    $('#form-bc').submit(function() {
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            dataType: 'json',
            success: function(json) {
                window.location.href = env('APP_URL')+"/v2";
            }
        })
        return false;
    });
}

function pilihPoli(poli_id){
    // alert(poli_id);
    $('#poli_id').val(poli_id);
    $('#section-poli').hide();
    $('#section-baru-lama').show();
    $('#section-cek-mr').hide();

}
</script>