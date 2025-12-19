@php
    $route = Route::current()->getName();
    $poli = request()->get('poli');
    $dpjp = request()->get('dpjp');
@endphp
<style>
    .dropdown:hover .dropdown-menu {
        display: block;
    }
</style>
@if (Auth::user()->email == 'sidangTA@sim.rs')
<ul id="myTab" class="nav nav-tabs">
    <li class="{{ $route == 'soap' ? 'active' : '' }}">
            <a href="{{ url('emr/soap/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">CPPT</a>
    </li>

    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Perencanaan <span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            <li><a href="{{ url('emr-soap/perencanaan/surat/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Surat
            Sakit</a></li>
            <li><a
            href="{{ url('emr-soap/perencanaan/kematian/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Surat
            Kematian</a></li>
        </ul>
    </li>

    <li class="{{ $route == 'emr-soap-icare' ? 'active' : '' }}"><a
            href="{{ url('emr-soap-icare/fkrtl/jalan/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">I-Care</a>
    </li>

    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Upload Hasil<span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
                <li>
                        <a href="{{url("/emr/upload-hasil/usg/". $unit . '/' . $registrasi_id)}}">USG</a>
                        <a href="{{url("/emr/upload-hasil/ekg/". $unit . '/' . $registrasi_id)}}">EKG</a>
                        <a href="{{url("/emr/upload-hasil/ctg/". $unit . '/' . $registrasi_id)}}">CTG</a>
                        <a href="{{url("/emr/upload-hasil/lain/". $unit . '/' . $registrasi_id)}}">LAINNYA</a>
                </li>
        </ul>
    </li>
    <li class="{{ $route == 'emr-resume' ? 'active' : '' }}"><a
            href="{{ url('emr/resume/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Histori Resume</a>
    </li>
</ul>



@else



<ul id="myTab" class="nav nav-tabs">
    {{-- <li class="{{$route == 'medical_history' ? 'active' :''}}"><a
            href="{{url('emr/'.$unit.'/'.$registrasi_id.'?poli='.$poli.'&dpjp='.$dpjp)}}">Riwayat</a></li> --}}

    @php
        @$dataPegawai = Auth::user()->pegawai->kategori_pegawai;
        if (!@$dataPegawai) {
            @$dataPegawai = 1;
        }
        $polis = Modules\Poli\Entities\Poli::where('id', $reg->poli_id)->first();
    @endphp

    @if ($unit == 'farmasi')
        @include('emr.modules.addons.tab-farmasi')
    @else
        @if (@$dataPegawai == '1')
            @if ($unit == "inap")
                @php
                    /**
                     * Update menu dokter!!!
                     */
                    $section = null;
                    // $dokter_inap = Modules\Pegawai\Entities\Pegawai::find(@$reg->rawat_inap->dokter_id);
                    $dokter_inap = Auth::user()->pegawai;

                    if (@$reg->poli_id == 15 || @$reg->poli_id == 24) { // Poli Obgyn atau IGD Ponek
                        $section = "obgyn";
                    // } elseif (@date_diff(@date_create(@$reg->pasien->tgllahir), @date_create(date('Y-m-d')))->days <= 28 || @$reg->input_from == "registrasi-ranap-langsung") { // Pasien bayi usia 0 - 28 hari atau dari registrasi ranap langsung
                    } elseif (in_array(@$reg->rawat_inap->kelompokkelas_id, [15, 16, 27, 28, 29, 30, 31])) { // Jika rawat inap kamar nya bougenvile dan room in dan NICU == neonatus
                        $section = "neonatus";
                    } else {
                        $section = "umum";
                    }
                    
                @endphp

                @if ($section == "umum")
                    @include('emr.modules.addons.inap.tab-dokter-umum')
                @elseif ($section == "neonatus")
                    @include('emr.modules.addons.inap.tab-dokter-neonatus')
                @elseif ($section == "obgyn")
                    @include('emr.modules.addons.inap.tab-dokter-obgyn')
                @else
                    @include('emr.modules.addons.tab-dokter')
                @endif
            @else
                @include('emr.modules.addons.tab-dokter')
            @endif
        @elseif(@$dataPegawai == '19')
            <li>
                <a href="{{ url('emr-soap/perencanaan/visum/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Visum</a>
            </li>
            <br>
            <br>
        @else
            @include('emr.modules.addons.tab-perawat')
        @endif
    @endif
</ul>

@section('script')
    @parent
    <script type="text/javascript">
        $(".skin-blue").addClass("sidebar-collapse");
        // $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        //   var target = $(e.target).attr("href") // activated tab
        //   // alert(target);
        // });

        $('#dokter_id').select2()

        function editDokter(id) {
            var dok = $('#dokter_id').val();
            $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/emr/editDokter/' + dok + '/' + id,
                    type: 'POST',
                    dataType: 'json',
                })
                .done(function(data) {
                    alert('Berhasil Ubah DPJP');
                    location.reload();
                })
                .fail(function() {
                    alert('Gagal Ubah DPJP');
                });

        }
    </script>
@endsection

@endif