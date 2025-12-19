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
            min-height: 265px;
        }

        .loketheader {
            width: 100%;
            height: 85px;
            padding: 10px 20px;
            color: white;
            font-weight: bold;
            text-shadow: 3px 3px 5px #000000;
            font-size: 34pt;
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
            margin-top: 40px;
        }

        .nama_pasien {
            font-size: 30px;
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

            <div class="row">
                <div class="col-md-12">
                    <div class="col-sm-6">
                        <div class="blockloket">
                            <div class="loketheader text-center">
                                POLI BEDAH ANAK
                            </div>
                            {{-- <div class="text-center">
                                <div id="BA_antrian" class="nomor_antrian">
                                    {{ @$antrianBA->kelompok . @$antrianBA->nomor }}</div> --}}
                                {{-- <div id="BA_nama" class="nama_pasien">
                                    {{ @$antrianBA->register_antrian->pasien->nama }}</div> --}}
                            {{-- </div> --}}
                            <div class="d-flex" style="height: 265px; overflow: hidden">
                                <div class="flex-1 container-box-1" style="border-right: black solid 2px; overflow: hidden;">
                                    <div class="header-sub" style="position: absolute; left: 15px; right: 50%;">
                                        <h4 class="text-center" style="font-weight: bold; color: black;">Belum Dipanggil</h4>
                                    </div>
                                    <div style="padding: 2rem; margin-top: 5rem;" id="top-point-1">
                                        <table class="table-list-pasien">
                                            <tbody id="antrian_belum_dipanggil_bedah_anak">
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="bottom-point-1"></div>
                                </div>
                                <div class="flex-1">
                                    <div class="header-sub">
                                        <h4 class="text-center" style="font-weight: bold; color: black;">Sedang Dipanggil</h4>
                                    </div>
                                    <div class="text-center">
                                        {{-- <div id="BA_antrian" class="nomor_antrian">
                                            {{ @$antrianBA->kelompok . @$antrianBA->nomor }}
                                        </div>
                                        <div id="BA_nama" class="nama_pasien">
                                            {{ @$antrianBA->register_antrian->pasien->nama }}
                                        </div> --}}
                                        {{-- @if( !baca_nomorantrian_bpjs(@$antrianBA->register_antrian->nomorantrian) )
                                            <div id="28_antrian" class="nomor_antrian">
                                                {{ @$antrianBA->kelompok . @$antrianBA->nomor }}
                                            </div>
                                        @else
                                        @endif --}}
                                        <div id="28_antrian" class="nomor_antrian">
                                            {{ @$antrianBA->register_antrian->nomorantrian_jkn }}
                                        </div>
                                        <div id="28_nama" class="nama_pasien">
                                            {{ @$antrianBA->register_antrian->pasien->nama }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="blockloket">
                            <div class="loketheader text-center" >
                                POLI BEDAH SARAF
                            </div>
                            {{-- <div class="text-center">
                                <div id="BS_antrian" class="nomor_antrian">
                                    {{ @$antrianBS->kelompok . @$antrianBS->nomor }}</div> --}}
                                {{-- <div id="BS_nama" class="nama_pasien">
                                    {{ @$antrianBS->register_antrian->pasien->nama }}</div> --}}
                            {{-- </div> --}}
                            <div class="d-flex" style="height: 265px; overflow: hidden">
                                <div class="flex-1 container-box-2" style="border-right: black solid 2px;  overflow: hidden;">
                                    <div class="header-sub" style="position: absolute; left: 15px; right: 50%;">
                                        <h4 class="text-center" style="font-weight: bold; color: black;">Belum Dipanggil</h4>
                                    </div>
                                    <div style="padding: 2rem; margin-top: 5rem;" id="top-point-2">
                                        <table class="table-list-pasien">
                                            <tbody id="antrian_belum_dipanggil_bedah_saraf">
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="bottom-point-2"></div>
                                </div>
                                <div class="flex-1">
                                    <div class="header-sub">
                                        <h4 class="text-center" style="font-weight: bold; color: black;">Sedang Dipanggil</h4>
                                    </div>
                                    <div class="text-center">
                                        {{-- @if( !baca_nomorantrian_bpjs(@$antrianBS->register_antrian->nomorantrian) )
                                            <div id="11_antrian" class="nomor_antrian">
                                                {{ @$antrianBS->kelompok . @$antrianBS->nomor }}
                                            </div>
                                        @else
                                        @endif --}}
                                        <div id="11_antrian" class="nomor_antrian">
                                            {{ @$antrianBS->register_antrian->nomorantrian_jkn }}
                                        </div>
                                        <div id="11_nama" class="nama_pasien">
                                            {{ @$antrianBS->register_antrian->pasien->nama }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-sm-6">
                        <div class="blockloket">
                            <div class="loketheader text-center">
                                POLI ASTER
                            </div>
                            {{-- <div class="text-center">
                                <div id="AS_antrian" class="nomor_antrian">
                                    {{ @$antrianAS->kelompok . @$antrianAS->nomor }}</div> --}}
                                {{-- <div id="AS_nama" class="nama_pasien">
                                    {{ @$antrianAS->register_antrian->pasien->nama }}</div> --}}
                            {{-- </div> --}}
                            <div class="d-flex" style="height: 265px; overflow: hidden">
                                <div class="flex-1  container-box-3" style="border-right: black solid 2px; overflow: hidden;">
                                    <div class="header-sub" style="position: absolute; left: 15px; right: 50%;">
                                        <h4 class="text-center" style="font-weight: bold; color: black;">Belum Dipanggil</h4>
                                    </div>
                                    <div style="padding: 2rem; margin-top: 5rem;" id="top-point-3">
                                        <table class="table-list-pasien">
                                            <tbody id="antrian_belum_dipanggil_aster">
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="bottom-point-3"></div>
                                </div>
                                <div class="flex-1">
                                    <div class="header-sub">
                                        <h4 class="text-center" style="font-weight: bold; color: black;">Sedang Dipanggil</h4>
                                    </div>
                                    <div class="text-center">
                                        {{-- @if( !baca_nomorantrian_bpjs(@$antrianAS->register_antrian->nomorantrian) )
                                            <div id="10_antrian" class="nomor_antrian">
                                                {{ @$antrianAS->kelompok . @$antrianAS->nomor }}
                                            </div>
                                        @else
                                        @endif --}}
                                        <div id="10_antrian" class="nomor_antrian">
                                            {{ @$antrianAS->register_antrian->nomorantrian_jkn }}
                                        </div>
                                        <div id="10_nama" class="nama_pasien">
                                            {{ @$antrianAS->register_antrian->pasien->nama }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="blockloket">
                            <div class="loketheader text-center" >
                                POLI JANTUNG ANAK
                            </div>
                            {{-- <div class="text-center">
                                <div id="JA_antrian" class="nomor_antrian">
                                    {{ @$antrianJA->kelompok . @$antrianJA->nomor }}</div> --}}
                                {{-- <div id="JA_nama" class="nama_pasien">
                                    {{ @$antrianJA->register_antrian->pasien->nama }}</div> --}}
                            {{-- </div> --}}
                            <div class="d-flex" style="height: 265px; overflow: hidden">
                                <div class="flex-1  container-box-4" style="border-right: black solid 2px; overflow: hidden;">
                                    <div class="header-sub" style="position: absolute; left: 15px; right: 50%;">
                                        <h4 class="text-center" style="font-weight: bold; color: black;">Belum Dipanggil</h4>
                                    </div>
                                    <div style="padding: 2rem; margin-top: 5rem;" id="top-point-4">
                                        <table class="table-list-pasien">
                                            <tbody id="antrian_belum_dipanggil_jantung_anak">
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="bottom-point-4"></div>
                                </div>
                                <div class="flex-1">
                                    <div class="header-sub">
                                        <h4 class="text-center" style="font-weight: bold; color: black;">Sedang Dipanggil</h4>
                                    </div>
                                    <div class="text-center">
                                        {{-- @if( !baca_nomorantrian_bpjs(@$antrianJA->register_antrian->nomorantrian) )
                                            <div id="30_antrian" class="nomor_antrian">
                                                {{ @$antrianJA->kelompok . @$antrianJA->nomor }}
                                            </div>
                                        @else
                                        @endif --}}
                                        <div id="30_antrian" class="nomor_antrian">
                                            {{ @$antrianJA->register_antrian->nomorantrian_jkn }}
                                        </div>
                                        <div id="30_nama" class="nama_pasien">
                                            {{ @$antrianJA->register_antrian->pasien->nama }}
                                        </div>
                                    </div>
                                </div>
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
                url: "/antrian_poliklinik/tv5",
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
                        console.log('mulai ajax lagi dalam ' + (audioDelay + ajaxDelay) + 's');
                    }, audioDelay);

                    let audios = [];
                    // console.log(data);

                    antrianDipanggil.forEach(antrian => {
                        if(antrian != null){
                            if (bacaNomorAntrianBPJS(antrian.register_antrian.nomorantrian)) {
                                $('#' + antrian.poli_id + '_antrian').html(antrian.register_antrian.nomorantrian_jkn);
                                $('#' + antrian.poli_id + '_nama').html(antrian.register_antrian?.pasien?.nama ?? '');
                                // 2X play
                                audios.push(
                                    // new Audio('/audio/in.mp3'),
                                    // new Audio('/audio/nomorurut.mp3'),
                                    // ...antrian.regDummy.nomorantrian.substr(8, 3).split('').map(char => new Audio('/audio/' + char + ".mp3")),
                                    ...bacaNomorAntrianBPJS(antrian.register_antrian.nomorantrian).substr(0, 3).split('').map(char => new Audio('/audio/' + char + ".mp3")),
                                    // new Audio('/audio/' + antrian.regDummy.nomorantrian.substr(11) + '.mp3'),
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

                            // audios.push(
                            //     new Audio('/audio/in.mp3'),
                            //     new Audio('/audio/nomorurut.mp3'),
                            //     ...antrian.kelompok.split('').map(char => new Audio('/audio/' + char + ".mp3")),
                            //     new Audio('/audio/' + antrian.suara),
                            //     new Audio('/audio/ke_poli.mp3'),
                            //     new Audio('/audio/' + antrian.poli.audio + '.mp3')
                            // );
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
                url: '/antrian_poliklinik/tv5/belum-dipanggil',
                success: function (data) {
                    
                    // Bedah Anak
                    let poli_bedah_anak = data[0];
                    poli_bedah_anak.sort((a, b) => {
                        let numA = parseInt((a?.nomorantrian || '').match(/\d+$/)?.[0]) || 0;
                        let numB = parseInt((b?.nomorantrian || '').match(/\d+$/)?.[0]) || 0;
                        return numA - numB; // ascending
                    });
                    let html;
                    poli_bedah_anak.forEach(bedah_anak => {
                        if (bedah_anak != null) {
                            // if (bacaNomorAntrianBPJS(bedah_anak.nomorantrian)) {
                            //     html += `<tr>
                            //                 <td class="nomor">${bacaNomorAntrianBPJS(bedah_anak.nomorantrian)}</td>
                            //                 <td class="text-center">${bedah_anak?.nama ?? ''}</td>
                            //             </tr>`
                            // } else {
                                html += `<tr>
                                            <td class="nomor">${bedah_anak.nomorantrian}</td>
                                            <td class="text-center">${bedah_anak?.nama ?? ''}</td>
                                        </tr>`
                            // }
                        }
                    })
                    $('#antrian_belum_dipanggil_bedah_anak').html(html);
                    if (html == undefined) {
                        $('#antrian_belum_dipanggil_bedah_anak').html('');
                    }
                    html = null;

                    // Bedah Saraf
                    let poli_bedah_saraf = data[1];
                     poli_bedah_saraf.sort((a, b) => {
                        let numA = parseInt((a?.nomorantrian || '').match(/\d+$/)?.[0]) || 0;
                        let numB = parseInt((b?.nomorantrian || '').match(/\d+$/)?.[0]) || 0;
                        return numA - numB; // ascending
                    });
                    poli_bedah_saraf.forEach(bedah_saraf => {
                        if (bedah_saraf != null) {
                            // if (bacaNomorAntrianBPJS(bedah_saraf.nomorantrian)) {
                            //     html += `<tr>
                            //                 <td class="nomor">${bacaNomorAntrianBPJS(bedah_saraf.nomorantrian)}</td>
                            //                 <td class="text-center">${bedah_saraf?.nama ?? ''}</td>
                            //             </tr>`
                            // } else {
                                html += `<tr>
                                            <td class="nomor">${bedah_saraf.nomorantrian}</td>
                                            <td class="text-center">${bedah_saraf?.nama ?? ''}</td>
                                        </tr>`
                            // }
                        }
                    })
                    $('#antrian_belum_dipanggil_bedah_saraf').html(html);
                    if (html == undefined) {
                        $('#antrian_belum_dipanggil_bedah_saraf').html('');
                    }
                    html = null;

                    // Aster
                    let poli_aster = data[2];
                    poli_aster.sort((a, b) => {
                        let numA = parseInt((a?.nomorantrian || '').match(/\d+$/)?.[0]) || 0;
                        let numB = parseInt((b?.nomorantrian || '').match(/\d+$/)?.[0]) || 0;
                        return numA - numB; // ascending
                    });
                    poli_aster.forEach(aster => {
                        if (aster != null) {
                            // if (bacaNomorAntrianBPJS(aster.nomorantrian)) {
                            //     html += `<tr>
                            //                 <td class="nomor">${bacaNomorAntrianBPJS(aster.nomorantrian)}</td>
                            //                 <td class="text-center">${aster?.nama ?? ''}</td>
                            //             </tr>`
                            // } else {
                                html += `<tr>
                                            <td class="nomor">${aster.nomorantrian}</td>
                                            <td class="text-center">${aster?.nama ?? ''}</td>
                                        </tr>`
                            // }
                        }
                    })
                    $('#antrian_belum_dipanggil_aster').html(html);
                    if (html == undefined) {
                        $('#antrian_belum_dipanggil_aster').html('');
                    }
                    html = null;

                    // Jantung Anak
                    let poli_jantung_anak = data[3];
                    poli_jantung_anak.sort((a, b) => {
                        let numA = parseInt((a?.nomorantrian || '').match(/\d+$/)?.[0]) || 0;
                        let numB = parseInt((b?.nomorantrian || '').match(/\d+$/)?.[0]) || 0;
                        return numA - numB; // ascending
                    });
                    poli_jantung_anak.forEach(jantung_anak => {
                        if (jantung_anak != null) {
                            // if (bacaNomorAntrianBPJS(jantung_anak.nomorantrian)) {
                            //     html += `<tr>
                            //                 <td class="nomor">${bacaNomorAntrianBPJS(jantung_anak.nomorantrian)}</td>
                            //                 <td class="text-center">${jantung_anak?.nama ?? ''}</td>
                            //             </tr>`
                            // } else {
                                html += `<tr>
                                            <td class="nomor">${jantung_anak.nomorantrian}</td>
                                            <td class="text-center">${jantung_anak?.nama ?? ''}</td>
                                        </tr>`
                            // }
                        }
                    })
                    $('#antrian_belum_dipanggil_jantung_anak').html(html);
                    if (html == undefined) {
                        $('#antrian_belum_dipanggil_jantung_anak').html('');
                    }
                    html = null;
                }
            });
        }

        function autoScroll() {
            $('.container-box-1').animate({
                scrollTop: 0
            }, 0);

            $('.container-box-1').animate({
                scrollTop: $("#bottom-point-1").offset().top
            }, 25000, () => {
                autoScroll();
            });
            $('.container-box-2').animate({
                scrollTop: 0
            }, 0);

            $('.container-box-2').animate({
                scrollTop: $("#bottom-point-2").offset().top
            }, 25000, () => {
                autoScroll();
            });
            $('.container-box-3').animate({
                scrollTop: 0
            }, 0);

            $('.container-box-3').animate({
                scrollTop: $("#bottom-point-3").offset().top
            }, 25000, () => {
                autoScroll();
            });
            $('.container-box-4').animate({
                scrollTop: 0
            }, 0);

            $('.container-box-4').animate({
                scrollTop: $("#bottom-point-3").offset().top
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
