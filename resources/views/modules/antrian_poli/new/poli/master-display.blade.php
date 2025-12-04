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
            font-size: 18pt;
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
            font-size: 100px;
            font-weight: bold;
            /* margin-top: 40px; */
        }

        .text-bp{
            font-size: 25px;
        }
        .nama_pasien {
            font-size: 50px;
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
            width: 150px;
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
                    <div class="col-sm-12">
                        <div class="blockloket2">
                            <div class="loketheader text-center">
                                {{strtoupper($poli->nama)}}
                            </div>
                            <input type="hidden" name="poli_id" value="{{$poli->id}}">
                            <div class="d-flex" style="height: 60vh; overflow: hidden">
                                <div class="flex-1 container-box" style="border-right: black solid 2px; overflow: hidden;">
                                    <div class="header-sub" style="position: absolute; left: 15px; right: 50%;">
                                        <h4 class="text-center" style="font-weight: bold; color: black;">Belum Dipanggil</h4>
                                    </div>
                                    <div style="padding: 2rem; margin-top: 5rem;" id="top-point">
                                        <table class="table-list-pasien">
                                            <tbody id="antrianBP">
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="bottom-point"></div>
                                </div>
                                <div class="flex-1">
                                    <div class="header-sub">
                                        <h4 class="text-center" style="font-weight: bold; color: black;">Sedang Dipanggil</h4>
                                    </div>
                                    <div class="text-center" style="display: flex;flex-flow:column;justify-content:center;height:80%">
                                        {{-- @if( !@$lastCall->register_antrian->nomorantrian )
                                            <div id="nomorAntrian" class="nomor_antrian">
                                                @if (status_antrolo())
                                                    {{ @$lastCall->kelompok . @$lastCall->nomor }}
                                                @else
                                                    {{ @$lastCall->poli->bpjs . @$lastCall->nomor }}
                                                @endif

                                            </div>
                                        @else --}}
                                            <div id="nomorAntrian" class="nomor_antrian">
                                                {{ @$lastCall->register_antrian->nomorantrian_jkn }}
                                            </div>
                                        {{-- @endif --}}
                                        <div id="namaAntrian" class="nama_pasien">
                                            {{ @$lastCall->register_antrian->pasien->nama }}
                                        </div>
                                        <div id="dokter" class="dokter">
                                            {{ @baca_dokter($lastCall->register_antrian->dokter_id) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- jQuery 3 -->
    <script src="{{ asset('style') }}/bower_components/jquery/dist/jquery.min.js"></script>

    

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

        $(document).ready(function() {
            confirm('Klik dimana saya pada halaman web ini! sampai terdengar suara notifikasi. Jika text terlalu besar maka kecilkan dengan menekan CTRL + "-"');
            document.addEventListener('click', function() {
                new Audio('/audio/notif.mp3').play();
            })
        });

        function ajaxAntrian() {
            $.ajax({
                url: "/antrian_poliklinik/get-current-call",
                method: "POST",
                dataType: "json",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    poli_id: $('input[name="poli_id"]').val()
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

                        if (antrian != null) {

                            console.log("nomorantrian_jkn:", antrian.register_antrian.nomorantrian_jkn);

                            // parse nomor antrian baru EVA-PAR1, EVA-PAR11, dst
                            const parsed = parseNomorAntrian(antrian.register_antrian.nomorantrian_jkn);

                            $('#nomorAntrian').html(antrian.register_antrian.nomorantrian_jkn);
                            $('#namaAntrian').html(antrian.register_antrian?.pasien?.nama ?? '');

                            $.get('/get-dokter/' + antrian.register_antrian.dokter_id, function(response) {
                                $('#dokter').html(response.nama);
                            });

                            if (bacaNomorAntrianBPJS(antrian.register_antrian.nomorantrian_jkn)) {

                                    const kode = bacaNomorAntrianBPJS(antrian.register_antrian.nomorantrian_jkn); // PAR11

                                    audios.push(
                                        ...kode.replace(/\d+/g, '').split('').map(char => new Audio('/audio/' + char + ".mp3")), // P A R
                                        new Audio('/audio/' + kode.match(/\d+/)[0] + '.mp3'), // 11
                                        new Audio('/audio/ke_poli.mp3'),
                                        new Audio('/audio/' + antrian.poli.audio + '.mp3')
                                    );
                                } else {

                                // fallback lama
                                audios.push(
                                    ...antrian.kelompok.split('').map(char => new Audio('/audio/' + char + ".mp3")),
                                    new Audio('/audio/' + antrian.suara),
                                    new Audio('/audio/ke_poli.mp3'),
                                    new Audio('/audio/' + antrian.poli.audio + ".mp3")
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

        function splitNomorAntrian(nomor) {
            const match = nomor.match(/^([A-Z]+)?(\d+)$/i);
            if (!match) return { kelompok: '', urutan: 0 };

            return {
                kelompok: match[1] ?? '',
                urutan: parseInt(match[2])
            };
        }
        function parseNomorAntrian(nomor) {
            if (!nomor) return false;

            // ambil prefix & angka paling belakang
            const match = nomor.match(/^(.*?)(\d+)$/);
            if (!match) return false;

            const prefix = match[1]; // EVA-PAR
            const angka = match[2];  // 1 / 11 / 23 / dst

            // buang simbol, sisakan huruf → EVA PAR → EVAPAR
            const prefixHuruf = prefix.replace(/[^A-Za-z]/g, "");

            return {
                prefix: prefixHuruf,   // EVAPAR
                angka: angka           // 1 / 11 / ...
            };
        }
        function ajaxAntrianBP() {
            $.ajax({
                type: 'GET',
                url: '/antrian_poliklinik/belum-dipanggil/' + $('input[name="poli_id"]').val(),
                success: function (data) {
                    let antrianBP = data;
                    console.log(data);

                    let poliId = {{ $poli->id }};

                    // if (poliId != 2) {
                    //     antrianBP.sort(function(a, b) {
                    //     const aNomor = bacaNomorAntrianBPJS(a.nomorantrian);
                    //     const bNomor = bacaNomorAntrianBPJS(b.nomorantrian);

                    //     const urutanA = aNomor 
                    //         ? parseInt(splitNomorAntrian(aNomor).urutan) 
                    //         : parseInt(a.nomor_antrian ?? 0);

                    //     const urutanB = bNomor 
                    //         ? parseInt(splitNomorAntrian(bNomor).urutan) 
                    //         : parseInt(b.nomor_antrian ?? 0);

                    //     return urutanA - urutanB;
                    //     });
                    // }
                    let html = "";
                    antrianBP.sort((a, b) => {
                        let numA = parseInt((a?.nomorantrian || '').match(/\d+$/)?.[0]) || 0;
                        let numB = parseInt((b?.nomorantrian || '').match(/\d+$/)?.[0]) || 0;
                        return numA - numB; // ascending
                    });
                    antrianBP.forEach(rehab_medis => {
                        if (rehab_medis != null) {
                            // if (rehab_medis.nomorantrian_jkn) {
                            //     html += `<tr>
                            //                 <td class="nomor text-bp">${rehab_medis.nomorantrian_jkn}</td>
                            //                 <td class="text-center text-bp">${rehab_medis?.nama ?? ''}</td>
                            //             </tr>`
                            // } else {
                                html += `<tr>
                                            <td class="nomor text-bp">${rehab_medis.nomorantrian}</td>
                                            <td class="text-center text-bp">${rehab_medis?.nama ?? ''}</td>
                                        </tr>`
                            // }
                        }
                    })
                    $('#antrianBP').html(html);
                    if (html == undefined) {
                        $('#antrianBP').html('');
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
            if (!nomorAntrian) return false;

            // Jika format EVA-PAR11 → ambil PAR11
            if (nomorAntrian.includes("-")) {
                const bagian = nomorAntrian.split("-")[1]; // PAR11
                return bagian || false;
            }

            return false;
        }
    </script>

    <script>
    $(document).ready(function () {
        autoScroll();
    });
    </script>
</body>

</html>
