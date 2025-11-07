<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="refresh" content="65" />
    <title>Display Tempat Tidur</title>
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
        .container {
            width: 100vw;
            height: 100vh;
            background: rgb(2, 0, 36);
            background: linear-gradient(207deg, rgba(2, 0, 36, 1) 0%, rgba(9, 9, 121, 1) 37%, rgba(0, 212, 255, 1) 100%);
        }

        .header h1 {
            color: white;
            font-weight: bold;
            text-align: center;
            padding: 0;
            margin-bottom: 0;
        }

        .header h2 {
            color: white;
            font-weight: bold;
            text-align: center;
            padding: 0;
            margin-top: 10px;
        }

        .content {
            display: flex;
            flex-wrap: wrap;
            flex-direction: row;
            gap: 10px;
            justify-content: space-between;
            align-items: center;
        }

        .content-item {
            width: 24%;
            height: 200px;
            background-color: white;
        }

        .general {
            margin-top: 40px
        }

        .inner-container {
            display: flex;
            flex-direction: row;
            justify-content: space-around
        }

        .inner-container inner {
            width: 30%;
        }

        .room-name {
            width: 100%;
            height: auto;
            background-color: white;
            color: blue;
            border-radius: 5px;
            padding: 10px 15px;
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            width: 100%;
            margin-bottom: 10px
        }
    </style>

<body>

    <div class="container">
        <div class="header">
            <h1>{{ configrs()->nama }}</h1>
            <h2>Ketersedian Ruang Rawat Inap</h2>
            <h2 style="font-size: 18px; text-align: start">Last Update: {{now()->formatLocalized('%d %B %Y %H:%M')}}</h2>
        </div>
        <div class="row general">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner" style="margin-left: 10px">
                        <h3>{{ $beds->count() }}</h3>
                        <p>Jumlah Kapasitas</p>
                        <div class="icon" style="margin-top: 10px;">
                            <i class="fa fa-bed"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner" style="margin-left: 10px">
                        <h3>{{ $beds->where('reserved', 'Y')->count() }}</h3>
                        <p>Jumlah Terisi</p>
                        <div class="icon" style="margin-top: 10px;">
                            <i class="fa fa-bed"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner" style="margin-left: 10px">
                        <h3>{{ $beds->where('reserved', 'N')->count() }}</h3>
                        <p>Jumlah Tersedia</p>
                        <div class="icon" style="margin-top: 10px;">
                            <i class="fa fa-bed"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner" style="margin-left: 10px">
                        <h3>{{ round(($beds->where('reserved', 'Y')->count() / $beds->count()) * 100) }}%</h3>
                        <p>Persentase Tempat Tidur</p>
                        <div class="icon" style="margin-top: 10px;">
                            <i class="fa fa-bed"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: 20px; overflow: scroll; height: 70vh" id="scrollContainer">
            <div class="room-container">
                @foreach ($rooms as $room)
                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-blue" style="padding: 10px">
                            <div class="room-name text-blue">
                                {{ strtoupper($room->nama) }}
                            </div>
                            <div class="inner-container">
                                <div class="inner">
                                    <h3 style="text-align: center">{{ $room->bed->count() }}</h3>
                                    <p>Jumlah Bed</p>
                                </div>
                                <div class="inner">
                                    <h3 style="text-align: center">{{ $room->bed->where('reserved', 'N')->count() }}
                                    </h3>
                                    <p>Bed Tersedia</p>
                                </div>
                                <div class="inner">
                                    <h3 style="text-align: center">{{ $room->bed->where('reserved', 'Y')->count() }}
                                    </h3>
                                    <p>Bed Terisi</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


    <script>
        var scrollContainer = document.getElementById('scrollContainer');
        var scrollSpeed = 1; // Adjust this value to control the scroll speed
        function autoScroll() {
            scrollContainer.scrollTop += scrollSpeed;

            // Check if the bottom of the container is reached
            if (scrollContainer.scrollTop + scrollContainer.clientHeight >= scrollContainer.scrollHeight) {
                // Scroll back to the top
                scrollContainer.scrollTop = 0;
            }
        }
        // Set an interval to call the autoScroll function
        var scrollInterval = setInterval(autoScroll, 15); // Adjust the interval as needed
        // Stop auto-scrolling when the mouse enters the scrollable area
        scrollContainer.addEventListener('mouseenter', function() {
            clearInterval(scrollInterval);
        });
        // Resume auto-scrolling when the mouse leaves the scrollable area
        scrollContainer.addEventListener('mouseleave', function() {
            scrollInterval = setInterval(autoScroll, 50);
        });
        setInterval(function(){
            location.reload();
        }, 60000)
    </script>

</body>

</html>
