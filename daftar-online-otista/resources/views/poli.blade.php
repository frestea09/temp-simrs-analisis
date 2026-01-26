<style>
    .card-body{
        min-height: 100px !important;
    }
    .bg-disable{
        background-color: #d1d1d1 !important;
        pointer-events: none !important;
    }
</style>
<div class="row">
    @foreach ($poli as $item)
    @php
        $jam_sekarang = date('H:i:s');
        $jam_buka     = $item->buka;
        $jam_tutup     = $item->tutup;
        $kuota = hitung_kuota_poli($item->id,date('Y-m-d'));
    @endphp
    <div class="col-md-3">
        {{-- <form method="POST" action="http://127.0.0.1:8000/antrian/klinik-savetouch" accept-charset="UTF-8"><input name="_token" type="hidden"> --}}
        <form method="POST" action="http://172.168.1.175/antrian/klinik-savetouch" accept-charset="UTF-8">
            {{ csrf_field() }}
            @if ($loket == 'B')
                <input name="kelompok" type="hidden" value="B">
                <input name="bagian" type="hidden" value="bawah">
            @else
                <input name="kelompok" type="hidden" value="C">
                <input name="bagian" type="hidden" value="atas">
            @endif
            <input name="poli_id" type="hidden" value="{{$item->id}}">
            <input name="tanggal" type="hidden" value="{{date('Y-m-d')}}">
            {{-- <input class="btnTouch" type="submit" value="LOKET 2" style="width: 200px;background:red;position: absolute;
            opacity: 0;height: 200px;"> --}}
            {{-- <img src="{{asset('rsud/img/button/led-circle-yellow-md.png')}}" width="200px"> --}}
            @if ($jam_sekarang >= $jam_buka)
                @if ($jam_sekarang <= $jam_tutup)
                    <button type="submit" {{$kuota == 0 ? 'disabled' :''}} class="card bg-orange text-white text-center {{$kuota == 0 ? 'bg-disable' :''}}" style="width:100%">   
                @else
                    <button type="submit" disabled class="card bg-orange text-white text-center bg-disable" style="width:100%">
                @endif
            @else
                <button type="submit" disabled class="card bg-orange text-white text-center bg-disable" style="width:100%">
            @endif

            
                <div class="card-body" style="width:100%">
                    <div class="no-block align-items-center text-center">
                        <h3 class="font-weight-medium mb-2 mt-2 text-white">{{$item->nama}}</h3>
                    </div>
                </div>
            </button>
        </form>
    </div>
        
    @endforeach
</div>