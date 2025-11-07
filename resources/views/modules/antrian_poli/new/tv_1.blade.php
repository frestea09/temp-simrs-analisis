<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nomor Antrian Poli</title>
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('style') }}/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('style') }}/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('style') }}/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="{{ asset('Nivo-Slider/style/style.css') }}" type="text/css" />

    <script src="{{ asset('/js/tanggal.js') }}" charset="utf-8"></script>

    <style type="text/css" media="screen">
        body {
            background-color: #097e37;
        }

        #header {
            background-color: white;
            width: auto;
            height: 130px;
            border-top: 1px solid grey;
            border-bottom: 6px solid green;

        }

        #judul {
            height: 150px;
            width: 100%;
            font-size: 28pt;
            font-weight: bold;
            color: green;
            margin-top: 3px;
            background-color: #097e37;
            border-top: 0;
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
            padding: 15px 20px;

            /* text-shadow: 1px 1px 2px #000000; */
        }

        .blockloket {
            height: 350px;
            width: 100%;
            margin: 20px auto;
            background-color: none;
            -webkit-box-shadow: 0px 1px 5px 0px rgba(0, 0, 0, 0.4);
            -moz-box-shadow: 0px 1px 5px 0px rgba(0, 0, 0, 0.4);
            box-shadow: 0px 1px 5px 0px rgba(0, 0, 0, 0.4);
            background-color: white;
            float: left;
            border-radius: 3px;
            /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#f8ffe8+0,e3f5ab+0,b7df2d+100 */
            /* background: #EEF1FF;  */
            background: white;
        }

        .blockloket2 {
            width: 100%;
            margin: 20px auto;
            background-color: none;
            -webkit-box-shadow: 0px 1px 5px 0px rgba(0, 0, 0, 0.4);
            -moz-box-shadow: 0px 1px 5px 0px rgba(0, 0, 0, 0.4);
            box-shadow: 0px 1px 5px 0px rgba(0, 0, 0, 0.4);
            background-color: white;
            float: left;
            border-radius: 3px;
            background: white;
            min-height: 320px;
        }

        .loketheader {
            width: 100%;
            height: 85px;
            padding: 10px 20px;
            color: white;
            font-weight: bold;
            text-shadow: 3px 3px 5px #000000;
            font-size: 30pt;
            border-bottom: 1px solid green;
            /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#bfd255+0,72aa00+0,72aa00+38,8eb92a+70,9ecb2d+100 */
            background-color: #18a450;
        }

        .logo {
            width: 200px;
            float: left;
            margin-right: 20px;
        }

        .nama {
            font-weight: bold;
            padding-top: 10px;
            font-size: 25pt;
            color: green;
            float: left;
            text-shadow: 1px 1px 0px #000000;

        }

        .alamat {
            font-size: 13pt;
            margin-right: 130px;
        }

        .tanggal {
            font-size: 24px;
            font-weight: bold;
            color: green;
            padding-top: 35px;
            text-shadow: 1px 1px 0px #000000;
        }

        .hari {
            float: right;
            font-size: 24px;
            font-weight: bold;
            color: white;
            padding: 20px;
            border: none;
            background: #c9d0f7;
            color: #097e3;
            text-shadow: 1px 1px 1px #000000;
            position: relative;
        }

        .btn-area {
            padding-top: 20px;
            width: 100%;
            font-family: Verdana;
            color: green;
            font-size: 100pt;
            letter-spacing: -5px;
            font-weight: bold;
            text-shadow: 2px 2px 2px #000000;
        }

        .blink_me {
            animation: blinker 4s linear infinite;
            color: #d0ae06;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }


        .header_antrian {

            font-size: 100pt;
            margin-right: 20px;
            font-weight: bold;
            color: rgb(31, 20, 143);
            margin-top: 3px;
            font-family: Arial;

            text-shadow: 2px 2px 3px #000000;
            /*background-color: #87C3FF;*/
        }

        .dokter {
            margin-top: -0px;
            color: green;
            font-family: Arial;
            font-size: 25pt;
        }

        .nama_antrian {
            margin-top: 5px;
            color: rgb(9, 13, 9);
            font-family: Arial;
            font-size: 30pt;
            /* font-weight: bold; */

        }

        .header_antrian_on {
            animation: blinker 2s linear infinite;
            color: rgb(243, 10, 10);
            font-size: 100pt;
            margin-right: 20px;
            font-weight: bold;
            margin-top: 3px;
            font-family: Arial;
            text-shadow: 2px 2px 3px #000000;
            /*background-color: #87C3FF;*/
        }

        .nama_antrian_on {
            margin-top: 5px;
            color: rgb(12, 11, 9);
            font-family: Arial;
            font-size: 30pt;
        }

        .antrianku {
            font-size: 24px;
            color: white;
            padding: 10px;
            border: none;
            color: white;
            text-shadow: 1px 1px 1px #000000;
            /* background: #c9d0f7; */
            background: white;
            position: relative;
            font-weight: bold;
        }

        .nama {
            font-weight: bold;
            padding-top: 10px;
            font-size: 25pt;
            color: white;
            float: left;
            text-shadow: 1px 1px 0px #000000;
        }

        .tanggal {
            font-size: 24px;
            font-weight: bold;
            color: white;
            padding-top: 35px;
            text-shadow: 1px 1px 0px #000000;
        }

        .nama_marquee {
            color: #05692d;
            font-family: Arial;
            font-size: 17pt;
            font-weight: bold;
        }
        .nomor_antrian {
            font-size: 60px;
            font-weight: bold;
            /* margin-top: 40px; */
        }

        .nama_pasien {
            font-size: 40px;
        }

        .d-flex {
            display: flex;
        }

        .flex-1 {
            flex: 1;
        }

        .table-list-pasien {
            width: 100%;
        }

        tr {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .nomor {
            width: 120px;
            text-align: center; 
            background-color:rgb(47, 209, 112);
            padding: .5rem;
        }

        .header-sub {
            padding: 1rem 0; 
            background-color: rgb(47, 209, 112); 
            color: white;
        }
    </style>

<body>

    <div class="container-fluid">
        <div class="contents">
            <div class="row">
                <div class="col-md-12">
                    <div id="judul">
                        <table class="col-md-1" style="width:100%">
                            <tr>
                                <td>
                                    <img src="{{ asset('/images/' . configrs()->logo) }}"
                                        style="height: 90px;margin-left: 30px">
                                </td>
                                <td class="nama" style="font-size:20pt; text-align: center">
                                    {{ configrs()->nama }}
                                    <br>
                                    <span style="font-size: 18pt; font-weight: normal; text-align: center">
                                        {{ configrs()->alamat }} Tlp. {{ configrs()->tlp }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <table class="col-md-1" style="width:100%">
                            <tr>
                                <div class="antrianku">
                                    <marquee class="nama_marquee" style="text-transform: uppercase;">ANTRIAN RAWAT JALAN
                                        / POLI KLINIK -
                                        <script type="text/javascript">
                                            show_hari()
                                        </script> - {{ configrs()->nama }}
                                    </marquee>
                                </div>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            {{-- <div class="row">
                <div class="col-md-12">
                    <div class="col-sm-12">
                        <div class="blockloket">
                            <div class="loketheader text-center">
                                POLI REHAB MEDIS
                            </div>
                            <div class="text-center">
                                <div id="RM_antrian" class="nomor_antrian">
                                    {{ @$antrianRM->kelompok . @$antrianRM->nomor }}
                                </div> --}}
                                {{-- <div id="RM_nama" class="nama_pasien">
                                    {{ @$antrianRM->register_antrian->pasien->nama }}</div> --}}
                            {{-- </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            
            <div class="row">
                <div class="col-md-12">
                    <div class="col-sm-12">
                        <div class="blockloket2">
                            <div class="loketheader text-center">
                                POLI REHAB MEDIS
                            </div>
                            <div class="d-flex" style="height: 320px; overflow: hidden">
                                <div class="flex-1 container-box" style="border-right: black solid 2px; overflow: hidden;">
                                    <div class="header-sub" style="position: absolute; left: 15px; right: 50%;">
                                        <h4 class="text-center" style="font-weight: bold; color: black;">Belum Dipanggil</h4>
                                    </div>
                                    <div style="padding: 2rem; margin-top: 5rem;" id="top-point">
                                        <table class="table-list-pasien">
                                            <tbody id="antrian_belum_dipanggil_rehab_medis">
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="bottom-point"></div>
                                </div>
                                <div class="flex-1">
                                    <div class="header-sub">
                                        <h4 class="text-center" style="font-weight: bold; color: black;">Sedang Dipanggil</h4>
                                    </div>
                                    <div class="text-center">
                                        {{-- @if( !baca_nomorantrian_bpjs(@$antrianRM->register_antrian->nomorantrian) )
                                            <div id="20_antrian" class="nomor_antrian">
                                                {{ @$antrianRM->kelompok . @$antrianRM->nomor }}
                                            </div>
                                        @else
                                        @endif --}}
                                        <div id="20_antrian" class="nomor_antrian">
                                            {{ @$antrianRM->register_antrian->nomorantrian_jkn }}
                                        </div>
                                        <div id="20_nama" class="nama_pasien">
                                            {{ @$antrianRM->register_antrian->pasien->nama }}
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="flex-1" style=" border-left: black solid 2px;">
                                    <div class="header-sub">
                                        <h4 class="text-center" style="font-weight: bold;">Sudah Dipanggil</h4>
                                    </div>
                                    <div style="padding: 2rem;" class="antrian_sudah_dipanggil">
                                        <table class="table-list-pasien">
                                            <tbody>
                                                @foreach ($antrianSP as $pasien)
                                                <tr>
                                                    <td class="nomor">{{$pasien->kelompok . $pasien->nomor}}</td>
                                                    <td class="text-center">{{$pasien->register_antrian->pasien->nama}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" id="suara_antrian_tv2"></div>
        </div>

    </div>
    </div>

    <!-- jQuery 3 -->
    <script src="{{ asset('style') }}/bower_components/jquery/dist/jquery.min.js"></script>

    <script type="text/javascript">
        // setInterval(function() {
        //     $('#suara_antrian_tv2').load("{{ route('antrian_poli.ajax_suara_tv2') }}");
        // }, 15000);
    </script>

    <script type="text/javascript">
        let intervalId;

        let ajaxDelay = 5000;
        function startInterval() {
            intervalId = setInterval(() => {
                ajaxAntrian();
            }, ajaxDelay);
        }

        function pauseInterval() {
            clearInterval(intervalId);
        }

        let intervalBP;

        intervalBP = setInterval(() => {
            ajaxAntrianBP();
        }, 10000);

        // Init ajax
        startInterval();
        ajaxAntrianBP();

        // $(document).ready(function() {
        //     confirm('Klik dimana saya pada halaman web ini! sampai terdengar suara notifikasi. Jika text terlalu besar maka kecilkan dengan menekan CTRL + "-"');
        //     document.addEventListener('click', function() {
        //         new Audio('/audio/notif.mp3').play();
        //         startInterval();
        //     })
        // });

        function ajaxAntrian() {
            $.ajax({
                url: "/antrian_poliklinik/tv1",
                method: "POST",
                dataType: "json",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(data) {
                    let antrianDipanggil = Object.values(data[0]);

                    pauseInterval();

                    let audioDelay = antrianDipanggil.length * 9000;
                    setTimeout(() => {
                        startInterval();
                        console.log('mulai ajax lagi dalam ' +  (audioDelay + ajaxDelay) + 's');
                    }, audioDelay);

                    let audios = [];

                    antrianDipanggil.forEach(antrian => {
                        if(antrian != null){
                            if (bacaNomorAntrianBPJS(antrian.register_antrian.nomorantrian)) {
                                $('#' + antrian.poli_id + '_antrian').html(antrian.register_antrian.nomorantrian_jkn);
                                $('#' + antrian.poli_id + '_nama').html(antrian.register_antrian?.pasien?.nama ?? '');
                                // 2X play
                                audios.push(
                                    // new Audio('/audio/in.mp3'),
                                    // new Audio('/audio/nomorurut.mp3'),
                                    ...bacaNomorAntrianBPJS(antrian.register_antrian.nomorantrian).substr(0, 3).split('').map(char => new Audio('/audio/' + char + ".mp3")),
                                    new Audio('/audio/' + bacaNomorAntrianBPJS(antrian.register_antrian.nomorantrian).substr(3) + '.mp3'),
                                    new Audio('/audio/ke_poli.mp3'),
                                    new Audio('/audio/' + antrian.poli.audio + '.mp3')
                                );
                            } else {
                                $('#' + antrian.poli_id + '_antrian').html(antrian.register_antrian.nomorantrian_jkn);
                                $('#' + antrian.poli_id + '_nama').html(antrian.register_antrian?.pasien?.nama ?? '');
                                // 2X play
                                audios.push(
                                    // new Audio('/audio/in.mp3'),
                                    // new Audio('/audio/nomorurut.mp3'),
                                    ...antrian.kelompok.split('').map(char => new Audio('/audio/' + char + ".mp3")),
                                    new Audio('/audio/' + antrian.suara),
                                    new Audio('/audio/ke_poli.mp3'),
                                    new Audio('/audio/' + antrian.poli.audio + '.mp3')
                                );
                            }
                        }
                    });
                    // Play Audio

                    if(audios.length > 0){
                        audios.forEach((audio, i) => {
                            audio.onended = function() {
                                if (i != audios.length - 1) {
                                    audios[i + 1].play();
                                } else {
                                    // Update database setelah audio selesai
                                    console.log('selesai panggil')
                                }
                            };
                        });
                        audios[0].play();
                        antrianDipanggil.forEach(antrian => {
                            $.ajax({
                                url: "/antrian_poliklinik/update/" + antrian.id, 
                                method: "POST", 
                                dataType: "json", 
                                data: {
                                    _token: $('meta[name="csrf-token"]').attr('content'),
                                },
                                success: function(data) {
                                    console.log(data);
                                    // location.reload();
                                },
                                error: function(xhr, status, error) {
                                    console.error("Error:", status, error);
                                }
                            });
                        })
                    }
                    
                },
                error: function(xhr, status, error) {
                    console.error("Error:", status, error);
                }
            });
        }

        function ajaxAntrianBP() {
            $.ajax({
                type: 'GET',
                url: '/antrian_poliklinik/tv1/belum-dipanggil',
                success: function (data) {
                    let poli_rehab_medis = data;
                    poli_rehab_medis.sort((a, b) => {
                        let numA = parseInt((a?.nomorantrian || '').match(/\d+$/)?.[0]) || 0;
                        let numB = parseInt((b?.nomorantrian || '').match(/\d+$/)?.[0]) || 0;
                        return numA - numB; // ascending
                    });
                    let html;
                    console.log(data);
                    poli_rehab_medis.forEach(rehab_medis => {
                        if (rehab_medis != null) {
                            // if (bacaNomorAntrianBPJS(rehab_medis.nomorantrian)) {
                            //     html += `<tr>
                            //                 <td class="nomor">${bacaNomorAntrianBPJS(rehab_medis.nomorantrian)}</td>
                            //                 <td class="text-center">${rehab_medis?.nama ?? ''}</td>
                            //             </tr>`
                            // } else {
                                html += `<tr>
                                            <td class="nomor">${rehab_medis.nomorantrian}</td>
                                            <td class="text-center">${rehab_medis?.nama ?? ''}</td>
                                        </tr>`
                            // }
                        }
                    })
                    $('#antrian_belum_dipanggil_rehab_medis').html(html);
                    if (html == undefined) {
                        $('#antrian_belum_dipanggil_rehab_medis').html('');
                    }
                    html = null;
                }
            });
        }

        function autoScroll() {
            $('.container-box').animate({
                scrollTop: 0
            }, 0);

            $('.container-box').animate({
                scrollTop: $("#bottom-point").offset().top
            }, 25000, () => {
                autoScroll();
            });
        }

        function bacaNomorAntrianBPJS(nomorAntrian) {
            if (nomorAntrian === null || nomorAntrian.length <= 8) {
                return false;
            }

            const antrian = nomorAntrian.substring(8);
            if (!/[a-zA-Z]/.test(antrian)) {
                return false;
            }

            return antrian;
        }
    </script>

    <script>
    $(document).ready(function () {
        autoScroll();
    });
    </script>
</body>

</html>
