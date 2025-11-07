@extends('master')

<style>
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
<h1>Odontogram</h1>
<style>
   path:hover,rect:hover{fill: #000 !important;}
 </style>
@endsection

@section('content')
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">
    </h3>
  </div>
  <div class="box-body">
    <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">
    

    @include('emr.modules.addons.profile')
    <form method="POST" action="{{ url('emr-odontogram/odontogram/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
      <div class="row">
        <div class="col-md-12">
          @include('emr.modules.addons.tabs')
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('cara_bayar', $reg->bayar) !!}
          {!! Form::hidden('unit', $unit) !!}
          <br>

          <svg
          width="231.64313mm"
          height="97.664886mm"
          viewBox="0 0 231.64313 97.664886"
          version="1.1"
          id="svg5"
          inkscape:version="1.2.1 (9c6d41e410, 2022-07-14)"
          sodipodi:docname="gigi.svg"
          xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"
          xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
          xmlns="http://www.w3.org/2000/svg"
          xmlns:svg="http://www.w3.org/2000/svg">
         <sodipodi:namedview
            id="namedview7"
            pagecolor="#ffffff"
            bordercolor="#666666"
            borderopacity="1.0"
            inkscape:showpageshadow="2"
            inkscape:pageopacity="0.0"
            inkscape:pagecheckerboard="0"
            inkscape:deskcolor="#d1d1d1"
            inkscape:document-units="mm"
            showgrid="false"
            inkscape:zoom="1.1893044"
            inkscape:cx="368.2825"
            inkscape:cy="173.63091"
            inkscape:window-width="1920"
            inkscape:window-height="991"
            inkscape:window-x="-9"
            inkscape:window-y="-9"
            inkscape:window-maximized="1"
            inkscape:current-layer="g2829" />
         <defs
            id="defs2" />
         <g
            inkscape:label="Layer 1"
            inkscape:groupmode="layer"
            id="layer1"
            transform="translate(-24.094462,-67.412825)">
           <g
              id="g1615"
              transform="translate(-11.822303,-6.5116577)">
             <g
                id="g1415"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P18B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P18L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P18R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P18T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P18C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text1555"><tspan
                  sodipodi:role="line"
                  id="tspan1553"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">18</tspan></text>
           </g>
           <g
              id="g1633"
              transform="translate(2.1905589,-6.5116577)">
             <g
                id="g1627"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P17B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P17L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P17R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P17T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P17C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text1631"><tspan
                  sodipodi:role="line"
                  id="tspan1629"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">17</tspan></text>
           </g>
           <g
              id="g1651"
              transform="translate(16.203421,-6.5116577)">
             <g
                id="g1645"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P16B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P16L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P16R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P16T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P16C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text1649"><tspan
                  sodipodi:role="line"
                  id="tspan1647"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">16</tspan></text>
           </g>
           <g
              id="g1669"
              transform="translate(30.216283,-6.5116577)">
             <g
                id="g1663"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P15B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P15L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P15R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P15T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P15C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text1667"><tspan
                  sodipodi:role="line"
                  id="tspan1665"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">15</tspan></text>
           </g>
           <g
              id="g1687"
              transform="translate(44.229144,-6.5116577)">
             <g
                id="g1681"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P14B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P14L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P14R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P14T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P14C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text1685"><tspan
                  sodipodi:role="line"
                  id="tspan1683"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">14</tspan></text>
           </g>
           <g
              id="g1705"
              transform="translate(58.242006,-6.5116577)">
             <g
                id="g1699"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P13B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P13L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P13R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P13T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P13C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text1703"><tspan
                  sodipodi:role="line"
                  id="tspan1701"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">13</tspan></text>
           </g>
           <g
              id="g1723"
              transform="translate(72.254868,-6.5116577)">
             <g
                id="g1717"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P12B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P12L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P12R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P12T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P12C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text1721"><tspan
                  sodipodi:role="line"
                  id="tspan1719"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">12</tspan></text>
           </g>
           <g
              id="g1741"
              transform="translate(86.26773,-6.5116577)">
             <g
                id="g1735"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P11B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P11L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P11R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P11T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P11C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text1739"><tspan
                  sodipodi:role="line"
                  id="tspan1737"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">11</tspan></text>
           </g>
           <g
              id="g1813"
              transform="translate(30.216283,19.946677)">
             <g
                id="g1807"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P55B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P55L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P55R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P55T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P55C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text1811"><tspan
                  sodipodi:role="line"
                  id="tspan1809"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">55</tspan></text>
           </g>
           <g
              id="g1831"
              transform="translate(44.229144,19.946677)">
             <g
                id="g1825"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P54B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P54L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P54R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P54T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P54C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text1829"><tspan
                  sodipodi:role="line"
                  id="tspan1827"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">54</tspan></text>
           </g>
           <g
              id="g1849"
              transform="translate(58.242006,19.946677)">
             <g
                id="g1843"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P53B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P53L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P53R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P53T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P53C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text1847"><tspan
                  sodipodi:role="line"
                  id="tspan1845"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">53</tspan></text>
           </g>
           <g
              id="g1867"
              transform="translate(72.254868,19.946677)">
             <g
                id="g1861"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P52B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P52L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P52R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P52T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P52C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text1865"><tspan
                  sodipodi:role="line"
                  id="tspan1863"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">52</tspan></text>
           </g>
           <g
              id="g1885"
              transform="translate(86.26773,19.946677)">
             <g
                id="g1879"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P51B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P51L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P51R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P51T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P51C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text1883"><tspan
                  sodipodi:role="line"
                  id="tspan1881"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">51</tspan></text>
           </g>
           <g
              id="g1903"
              transform="translate(30.216283,46.405011)">
             <g
                id="g1897"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P85B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P85L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P85R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P85T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P85C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text1901"><tspan
                  sodipodi:role="line"
                  id="tspan1899"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">85</tspan></text>
           </g>
           <g
              id="g1921"
              transform="translate(44.229144,46.405011)">
             <g
                id="g1915"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P84B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P84L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P84R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P84T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P84C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text1919"><tspan
                  sodipodi:role="line"
                  id="tspan1917"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">84</tspan></text>
           </g>
           <g
              id="g1939"
              transform="translate(58.242006,46.405011)">
             <g
                id="g1933"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P83B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P83L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P83R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P83T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P83C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text1937"><tspan
                  sodipodi:role="line"
                  id="tspan1935"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">83</tspan></text>
           </g>
           <g
              id="g1957"
              transform="translate(72.254868,46.405011)">
             <g
                id="g1951"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P82B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P82L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P82R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P82T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P82C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text1955"><tspan
                  sodipodi:role="line"
                  id="tspan1953"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">82</tspan></text>
           </g>
           <g
              id="g1975"
              transform="translate(86.26773,46.405011)">
             <g
                id="g1969"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P81B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P81L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P81R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P81T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P81C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text1973"><tspan
                  sodipodi:role="line"
                  id="tspan1971"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">81</tspan></text>
           </g>
           <g
              id="g1993"
              transform="translate(-11.822303,72.863346)">
             <g
                id="g1987"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P48B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P48L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P48R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P48T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P48C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text1991"><tspan
                  sodipodi:role="line"
                  id="tspan1989"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">48</tspan></text>
           </g>
           <g
              id="g2011"
              transform="translate(2.1905589,72.863346)">
             <g
                id="g2005"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P47B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P47L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P47R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P47T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P47C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text2009"><tspan
                  sodipodi:role="line"
                  id="tspan2007"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">47</tspan></text>
           </g>
           <g
              id="g2029"
              transform="translate(16.203421,72.863346)">
             <g
                id="g2023"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P46B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P46L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P46R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P46T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P46C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text2027"><tspan
                  sodipodi:role="line"
                  id="tspan2025"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">46</tspan></text>
           </g>
           <g
              id="g2047"
              transform="translate(30.216283,72.863346)">
             <g
                id="g2041"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P45B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P45L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P45R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P45T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P45C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text2045"><tspan
                  sodipodi:role="line"
                  id="tspan2043"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">45</tspan></text>
           </g>
           <g
              id="g2065"
              transform="translate(44.229144,72.863346)">
             <g
                id="g2059"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P44B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P44L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P44R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P44T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P44C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text2063"><tspan
                  sodipodi:role="line"
                  id="tspan2061"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">44</tspan></text>
           </g>
           <g
              id="g2083"
              transform="translate(58.242006,72.863346)">
             <g
                id="g2077"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P43B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P43L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P43R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P43T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P43C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text2081"><tspan
                  sodipodi:role="line"
                  id="tspan2079"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">43</tspan></text>
           </g>
           <g
              id="g2101"
              transform="translate(72.254868,72.863346)">
             <g
                id="g2095"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P42B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P42L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P42R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P42T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P42C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text2099"><tspan
                  sodipodi:role="line"
                  id="tspan2097"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">42</tspan></text>
           </g>
           <g
              id="g2119"
              transform="translate(86.26773,72.863346)">
             <g
                id="g2113"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P41B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P41L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P41R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P41T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P41C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text2117"><tspan
                  sodipodi:role="line"
                  id="tspan2115"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">41</tspan></text>
           </g>
           <g
              id="g2379"
              transform="translate(208.31253,-6.5116577)">
             <g
                id="g2373"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P28B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P28L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P28R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P28T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P28C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text2377"><tspan
                  sodipodi:role="line"
                  id="tspan2375"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">28</tspan></text>
           </g>
           <g
              id="g2397"
              transform="translate(194.29967,-6.5116577)">
             <g
                id="g2391"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P27B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P27L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P27R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P27T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P27C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text2395"><tspan
                  sodipodi:role="line"
                  id="tspan2393"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">27</tspan></text>
           </g>
           <g
              id="g2415"
              transform="translate(180.28681,-6.5116577)">
             <g
                id="g2409"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P26B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P26L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P26R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P26T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P26C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text2413"><tspan
                  sodipodi:role="line"
                  id="tspan2411"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">26</tspan></text>
           </g>
           <g
              id="g2433"
              transform="translate(166.27395,-6.5116577)">
             <g
                id="g2427"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P25B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P25L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P25R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P25T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P25C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text2431"><tspan
                  sodipodi:role="line"
                  id="tspan2429"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">25</tspan></text>
           </g>
           <g
              id="g2451"
              transform="translate(152.26109,-6.5116577)">
             <g
                id="g2445"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P24B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P24L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P24R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P24T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P24C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text2449"><tspan
                  sodipodi:role="line"
                  id="tspan2447"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">24</tspan></text>
           </g>
           <g
              id="g2469"
              transform="translate(138.24822,-6.5116577)">
             <g
                id="g2463"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P23B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P23L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P23R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P23T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P23C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text2467"><tspan
                  sodipodi:role="line"
                  id="tspan2465"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">23</tspan></text>
           </g>
           <g
              id="g2487"
              transform="translate(124.23536,-6.5116577)">
             <g
                id="g2481"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P22B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P22L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P22R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P22T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P22C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text2485"><tspan
                  sodipodi:role="line"
                  id="tspan2483"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">22</tspan></text>
           </g>
           <g
              id="g2505"
              transform="translate(110.2225,-6.5116577)">
             <g
                id="g2499"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P21B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P21L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P21R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P21T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P21C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text2503"><tspan
                  sodipodi:role="line"
                  id="tspan2501"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">21</tspan></text>
           </g>
           <g
              id="g2525"
              transform="translate(110.2225,19.946677)">
             <g
                id="g2519"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P61B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P61L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P61R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P61T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P61C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text2523"><tspan
                  sodipodi:role="line"
                  id="tspan2521"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">61</tspan></text>
           </g>
           <g
              id="g2543"
              transform="translate(124.23536,19.946677)">
             <g
                id="g2537"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P62B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P62L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P62R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P62T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P62C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text2541"><tspan
                  sodipodi:role="line"
                  id="tspan2539"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">62</tspan></text>
           </g>
           <g
              id="g2561"
              transform="translate(138.24823,19.946677)">
             <g
                id="g2555"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P63B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P63L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P63R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P63T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P63C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
               <text
                  xml:space="preserve"
                  style="font-size:26.7524px;font-family:sans-serif;-inkscape-font-specification:'sans-serif, Normal';fill:#000000;stroke-width:4.11941"
                  x="449.78433"
                  y="-308.08868"
                  id="text1231"><tspan
                    sodipodi:role="line"
                    id="tspan1229"
                    style="stroke-width:4.11941"
                    x="449.78433"
                    y="-308.08868"></tspan><tspan
                    sodipodi:role="line"
                    style="stroke-width:4.11941"
                    id="tspan1233"
                    x="449.78433"
                    y="-274.64819" /></text>
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text2559"><tspan
                  sodipodi:role="line"
                  id="tspan2557"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">63</tspan></text>
           </g>
           <g
              id="g2579"
              transform="translate(152.26109,19.946677)">
             <g
                id="g2573"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P64B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P64L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 c -6.80682,-6.752217 -13.61364,-13.504433 -20.42046,-20.25665 0,27.797614 0,55.595234 0,83.392854 6.80682,-6.75222 13.61364,-13.50443 20.42046,-20.25665 0,-14.29318 0,-28.58637 0,-42.879554 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P64R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P64T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P64C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text2577"><tspan
                  sodipodi:role="line"
                  id="tspan2575"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">64</tspan></text>
           </g>
           <g
              id="g2597"
              transform="translate(166.27395,19.946677)">
             <g
                id="g2591"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P65B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P65L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P65R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P65T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P65C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text2595"><tspan
                  sodipodi:role="line"
                  id="tspan2593"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">65</tspan></text>
           </g>
           <g
              id="g2617"
              transform="translate(110.2225,46.405011)">
             <g
                id="g2611"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P71B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P71L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P71R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P71T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P71C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text2615"><tspan
                  sodipodi:role="line"
                  id="tspan2613"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">71</tspan></text>
           </g>
           <g
              id="g2635"
              transform="translate(124.23536,46.405011)">
             <g
                id="g2629"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P72B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P72L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P72R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P72T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P72C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text2633"><tspan
                  sodipodi:role="line"
                  id="tspan2631"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">72</tspan></text>
           </g>
           <g
              id="g2653"
              transform="translate(138.24823,46.405011)">
             <g
                id="g2647"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P73B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P73L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P73R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P73T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P73C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text2651"><tspan
                  sodipodi:role="line"
                  id="tspan2649"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">73</tspan></text>
           </g>
           <g
              id="g2671"
              transform="translate(152.26109,46.405011)">
             <g
                id="g2665"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P74B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P74L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P74R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P74T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P74C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text2669"><tspan
                  sodipodi:role="line"
                  id="tspan2667"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">74</tspan></text>
           </g>
           <g
              id="g2689"
              transform="translate(166.27395,46.405011)">
             <g
                id="g2683"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P75B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P75L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P75R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P75T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P75C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text2687"><tspan
                  sodipodi:role="line"
                  id="tspan2685"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">75</tspan></text>
           </g>
           <g
              id="g2709"
              transform="translate(110.2225,72.863346)">
             <g
                id="g2703"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P31B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P31L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P31R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P31T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P31C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text2707"><tspan
                  sodipodi:role="line"
                  id="tspan2705"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">31</tspan></text>
           </g>
           <g
              id="g2727"
              transform="translate(124.23536,72.863346)">
             <g
                id="g2721"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P32B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P32L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P32R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P32T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P32C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text2725"><tspan
                  sodipodi:role="line"
                  id="tspan2723"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">32</tspan></text>
           </g>
           <g
              id="g2745"
              transform="translate(138.24822,72.863346)">
             <g
                id="g2739"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P33B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P33L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P33R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P33T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P33C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text2743"><tspan
                  sodipodi:role="line"
                  id="tspan2741"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">33</tspan></text>
           </g>
           <g
              id="g2763"
              transform="translate(152.26108,72.863346)">
             <g
                id="g2757"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P34B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P34L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P34R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P34T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P34C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text2761"><tspan
                  sodipodi:role="line"
                  id="tspan2759"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">34</tspan></text>
           </g>
           <g
              id="g2781"
              transform="translate(166.27394,72.863346)">
             <g
                id="g2775"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P35B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P35L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P35R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P35T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P35C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text2779"><tspan
                  sodipodi:role="line"
                  id="tspan2777"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">35</tspan></text>
           </g>
           <g
              id="g2799"
              transform="translate(180.28681,72.863346)">
             <g
                id="g2793"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P36B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P36L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P36R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P36T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P36C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text2797"><tspan
                  sodipodi:role="line"
                  id="tspan2795"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">36</tspan></text>
           </g>
           <g
              id="g2817"
              transform="translate(194.29967,72.863346)">
             <g
                id="g2811"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P37B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P37L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P37R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P37T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P37C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text2815"><tspan
                  sodipodi:role="line"
                  id="tspan2813"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">37</tspan></text>
           </g>
           <g
              id="g2835"
              transform="translate(208.31253,72.863346)">
             <g
                id="g2829"
                transform="matrix(0.1303601,0,0,0.1303601,31.438819,64.491847)"
                style="stroke-width:2.02963;stroke-dasharray:none">
               <path
                  id="P38B"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="-9.6420355"
                  d="M 57.059049,137.9306 36.802405,158.35106 H 57.188241 99.809412 120.19525 L 99.938603,137.9306 H 99.809412 57.188241 Z" />
               <path
                  id="P38L"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 57.059049,95.051046 -20.42046,-20.25665 v 20.38584 42.621174 20.38584 l 20.42046,-20.25665 v -0.12919 -42.621174 z"
                  inkscape:transform-center-x="-9.6420355" />
               <path
                  id="P38R"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  d="m 99.856697,95.132951 20.420463,-20.25665 v 20.38584 42.621169 20.38584 L 99.856697,138.0125 v -0.12919 -42.621169 z"
                  inkscape:transform-center-x="9.6420355" />
               <path
                  id="P38T"
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  inkscape:transform-center-y="9.6420345"
                  d="M 99.922886,94.955533 120.17953,74.535073 H 99.793692 57.172516 36.786678 l 20.256647,20.42046 h 0.129191 42.621176 z" />
               <rect
                  style="opacity:1;fill:#ffffff;stroke:#000000;stroke-width:2.02963;stroke-linecap:square;stroke-dasharray:none;stroke-opacity:0.988599;stop-color:#000000"
                  id="P38C"
                  width="42.766087"
                  height="42.975067"
                  x="57.172516"
                  y="94.955528" />
             </g>
             <text
                xml:space="preserve"
                style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-size:6.35px;line-height:125%;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';text-align:center;text-anchor:middle;stroke-width:0.264583"
                x="41.569614"
                y="92.152351"
                id="text2833"><tspan
                  sodipodi:role="line"
                  id="tspan2831"
                  style="font-style:normal;font-variant:normal;font-weight:600;font-stretch:normal;font-family:'Open Sans';-inkscape-font-specification:'Open Sans Semi-Bold';stroke-width:0.264583"
                  x="41.569614"
                  y="92.152351">38</tspan></text>
           </g>
         </g>
       </svg>
       <p id="demo" style="margin-top:50px; font-size:25px; margin-left:25%; font-weight:bold;"></p>
       {{-- <p id="gigiT"></p> --}}
</div>
<div class="row">
   <div class="col-md-4" style="margin-top: 50px;">
      <label for="">Occlusi</label>
      <select class="form-control" name="occlusi" id="occlusi">
        <option value="Normal Bite">Normal Bite</option>
        <option value="Cross Bite">Cross Bite</option>
        <option value="Steep Bite">Steep Bite</option>
      </select>
    </div>
    <div class="col-md-4" style="margin-top: 50px;">
      <label for="">Torus Palatinus</label>
      <select class="form-control" name="torus_palatinus" id="torus_palatinus">
         <option value="Tidak Ada">Tidak Ada</option>
         <option value="Kecil">Kecil</option>
         <option value="Sedang">Sedang</option>
         <option value="Besar">Besar</option>
         <option value="Multiple">Multiple</option>
       </select>
    </div>
   </div>

   <div class="row">
      <div class="col-md-4" style="margin-top: 50px;">
         <label for="">Torus Mandibularis</label>
         <select class="form-control" name="torus_mandibularis" id="torus_mandibularis">
            <option value="Tidak Ada">Tidak Ada</option>
            <option value="Sisi Kiri">Sisi Kiri</option>
            <option value="Sisi Kanan">Sisi Kanan</option>
            <option value="Kedua Sisi">Kedua Sisi</option>
          </select>
       </div>
       <div class="col-md-4" style="margin-top: 50px;">
         <label for="">Platanum</label>
         <select class="form-control" name="palatanum" id="palatanum">
            <option value="Dalam">Dalam</option>
            <option value="Sedang">Sedang</option>
            <option value="Rendah">Rendah</option>
          </select>
       </div>
      </div>

   <div class="row">
      <div class="col-md-4" style="margin-top: 50px;">
         <label for="">Diastema</label>
                <select class="form-control" name="diastema" id="diastema">
                        <option value="Tidak Ada">Tidak Ada</option>
                        <option value="Ada">Ada</option>
                      </select>
       </div>
       <div class="col-md-4" style="margin-top: 50px;">
         <label for="">Gigi Anomali</label>
         <select class="form-control" name="gigi_anomali" id="gigi_anomali">
            <option value="Tidak Ada">Tidak Ada</option>
            <option value="Ada">Ada</option>
          </select>
       </div>
      </div>

      <div class="col-md-8" style="margin-top: 50px;">
         <label for="">Lain Lain</label>
         <textarea rows="10" class="form-control" name="lain_lain" id="lain_lain"></textarea>
       </div>
       <div class="clearfix"></div>
       <div class="row">
         <div class="col-md-2">
            @for ( $i = 11; $i < 86; $i++) 
                @if ($i === 19 || $i === 20 || $i === 29 || $i === 30 || $i === 39 || $i === 40 || $i === 49 || $i === 50 || $i === 56 || $i === 57 || $i === 58 || $i === 59 || $i === 60 || $i === 66 || $i === 67 || $i === 68 || $i === 69 || $i === 70 || $i === 76 || $i === 77 || $i === 78 || $i === 79 || $i === 80  )  @php continue; @endphp 
               @else
                  <input class="form-control mb-2" placeholder="Diagnosa Gigi {{ $i }}" type="text" id="inputgigi{{ $i }}" name="inputGigi{{ $i }}"> 
               @endif
            @endfor
          </div>

       <div class="col-md-8 text-right" style="margin-top:30px;">
         <button class="btn btn-success">Simpan</button>
     </div>
</div>
</div>
</div>
      </div>
    </form>
  @endsection

  @section('script')
    {{-- ID C --}}
      @for ( $i = 11; $i < 86; $i++) 
         @if ($i === 19 || $i === 20 || $i === 29 || $i === 30 || $i === 39 || $i === 40 || $i === 49 || $i === 50 || $i === 56 || $i === 57 || $i === 58 || $i === 59 || $i === 60 || $i === 66 || $i === 67 || $i === 68 || $i === 69 || $i === 70 || $i === 76 || $i === 77 || $i === 78 || $i === 79 || $i === 80  )  @php continue; @endphp 
         @else

         {{-- MODAL --}}
         <div id="modalGigiPC{{ $i }}" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Input Kondisi</h4>
                </div>
                <div class="modal-body">
                  <form>
                     <div class="form-group">
                        <label for="gigiP{{ $i }}C">Gigi</label>
                        <input type="text" id="gigiP{{ $i }}C" class="form-control" value="P{{ $i }}C" readonly>
                     </div>
                     <div class="form-group">
                        <label for="kondisiP{{ $i }}C">Kondisi</label>
                        <input type="text" id="kondisiP{{ $i }}C" class="form-control">
                     </div>
                     <div class="form-group">
                        <label for="diagnosaP{{ $i }}C">Diagnosa</label>
                        <input type="text" id="diagnosaP{{ $i }}C" class="form-control">
                     </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                  <button type="button" class="btn btn-primary" id="simpanP{{ $i }}C">Simpan</button>
                </div>
              </div>
            </div>
          </div>
          {{-- END OF MODAl --}}

         {{-- MODAL --}}
         <div id="modalGigiPT{{ $i }}" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Input Kondisi</h4>
                </div>
                <div class="modal-body">
                  <form>
                     <div class="form-group">
                        <label for="gigiP{{ $i }}T">Gigi</label>
                        <input type="text" id="gigiP{{ $i }}T" class="form-control" value="P{{ $i }}T" readonly>
                     </div>
                     <div class="form-group">
                        <label for="kondisiP{{ $i }}T">Kondisi</label>
                        <input type="text" id="kondisiP{{ $i }}T" class="form-control">
                     </div>
                     <div class="form-group">
                        <label for="diagnosaP{{ $i }}T">Diagnosa</label>
                        <input type="text" id="diagnosaP{{ $i }}T" class="form-control">
                     </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                  <button type="button" class="btn btn-primary" id="simpanP{{ $i }}T">Simpan</button>
                </div>
              </div>
            </div>
          </div>
          {{-- END OF MODAl --}}

         {{-- MODAL --}}
         <div id="modalGigiPR{{ $i }}" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Input Kondisi</h4>
                </div>
                <div class="modal-body">
                  <form>
                     <div class="form-group">
                        <label for="gigiP{{ $i }}R">Gigi</label>
                        <input type="text" id="gigiP{{ $i }}R" class="form-control" value="P{{ $i }}R" readonly>
                     </div>
                     <div class="form-group">
                        <label for="kondisiP{{ $i }}R">Kondisi</label>
                        <input type="text" id="kondisiP{{ $i }}R" class="form-control">
                     </div>
                     <div class="form-group">
                        <label for="diagnosaP{{ $i }}R">Diagnosa</label>
                        <input type="text" id="diagnosaP{{ $i }}R" class="form-control">
                     </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                  <button type="button" class="btn btn-primary" id="simpanP{{ $i }}R">Simpan</button>
                </div>
              </div>
            </div>
          </div>
          {{-- END OF MODAl --}}

         {{-- MODAL --}}
         <div id="modalGigiPL{{ $i }}" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Input Kondisi</h4>
                </div>
                <div class="modal-body">
                  <form>
                     <div class="form-group">
                        <label for="gigiP{{ $i }}L">Gigi</label>
                        <input type="text" id="gigiP{{ $i }}L" class="form-control" value="P{{ $i }}L" readonly>
                     </div>
                     <div class="form-group">
                        <label for="kondisiP{{ $i }}L">Kondisi</label>
                        <input type="text" id="kondisiP{{ $i }}L" class="form-control">
                     </div>
                     <div class="form-group">
                        <label for="diagnosaP{{ $i }}L">Diagnosa</label>
                        <input type="text" id="diagnosaP{{ $i }}L" class="form-control">
                     </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                  <button type="button" class="btn btn-primary" id="simpanP{{ $i }}L">Simpan</button>
                </div>
              </div>
            </div>
          </div>
          {{-- END OF MODAl --}}

         {{-- MODAL --}}
         <div id="modalGigiPB{{ $i }}" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Input Kondisi</h4>
                </div>
                <div class="modal-body">
                  <form>
                     <div class="form-group">
                        <label for="gigiP{{ $i }}B">Gigi</label>
                        <input type="text" id="gigiP{{ $i }}B" class="form-control" value="P{{ $i }}B" readonly>
                     </div>
                     <div class="form-group">
                        <label for="kondisiP{{ $i }}B">Kondisi</label>
                        <input type="text" id="kondisiP{{ $i }}B" class="form-control">
                     </div>
                     <div class="form-group">
                        <label for="diagnosaP{{ $i }}B">Diagnosa</label>
                        <input type="text" id="diagnosaP{{ $i }}B" class="form-control">
                     </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                  <button type="button" class="btn btn-primary" id="simpanP{{ $i }}B">Simpan</button>
                </div>
              </div>
            </div>
          </div>
          {{-- END OF MODAl --}}

            <script>
                  document.getElementById("P{{ $i }}C").onmouseover = function() {mouseOverP{{ $i }}C()};
                  document.getElementById("P{{ $i }}C").onmouseout = function() {mouseOutPC()};  
                  document.getElementById("P{{ $i }}C").onclick = function(){showModalP{{ $i }}C()};

                  document.getElementById("P{{ $i }}T").onmouseover = function() {mouseOverP{{ $i }}T()};
                  document.getElementById("P{{ $i }}T").onmouseout = function() {mouseOutPT()};  
                  document.getElementById("P{{ $i }}T").onclick = function(){showModalP{{ $i }}T()};

                  document.getElementById("P{{ $i }}R").onmouseover = function() {mouseOverP{{ $i }}R()};
                  document.getElementById("P{{ $i }}R").onmouseout = function() {mouseOutPR()};  
                  document.getElementById("P{{ $i }}R").onclick = function(){showModalP{{ $i }}R()};

                  document.getElementById("P{{ $i }}L").onmouseover = function() {mouseOverP{{ $i }}L()};
                  document.getElementById("P{{ $i }}L").onmouseout = function() {mouseOutPL()};  
                  document.getElementById("P{{ $i }}L").onclick = function(){showModalP{{ $i }}L()};

                  document.getElementById("P{{ $i }}B").onmouseover = function() {mouseOverP{{ $i }}B()};
                  document.getElementById("P{{ $i }}B").onmouseout = function() {mouseOutPB()};  
                  document.getElementById("P{{ $i }}B").onclick = function(){showModalP{{ $i }}B()};
                  function mouseOverP{{ $i }}C() {
                     document.getElementById("demo").innerHTML ="P{{ $i }}C";
                  }
                  function mouseOverP{{ $i }}T() {
                     document.getElementById("demo").innerHTML ="P{{ $i }}T";
                  }
                  function mouseOverP{{ $i }}R() {
                     document.getElementById("demo").innerHTML ="P{{ $i }}R";
                  }
                  function mouseOverP{{ $i }}L() {
                     document.getElementById("demo").innerHTML ="P{{ $i }}L";
                  }
                  function mouseOverP{{ $i }}B() {
                     document.getElementById("demo").innerHTML ="P{{ $i }}B";
                  }
                  function showModalP{{ $i }}C() {
                     $('#modalGigiPC{{ $i }}').modal("show");
                  }                    
                  function showModalP{{ $i }}T() {
                     $('#modalGigiPT{{ $i }}').modal("show");
                  }                    
                  function showModalP{{ $i }}R() {
                     $('#modalGigiPR{{ $i }}').modal("show");
                  }                    
                  function showModalP{{ $i }}L() {
                     $('#modalGigiPL{{ $i }}').modal("show");
                  }                    
                  function showModalP{{ $i }}B() {
                     $('#modalGigiPB{{ $i }}').modal("show");
                  }                    
            </script>

            <script>
               var gigi{{ $i }} = {
               c:{},
               t:{},
               r:{},
               l:{},
               b:{}
            };


            var gigic{{ $i }} = {};
            var gigit{{ $i }} = {};
            var gigir{{ $i }} = {};
            var gigil{{ $i }} = {};
            var gigib{{ $i }} = {};
      
            </script>

            <script>
               $("#simpanP{{ $i }}C, #simpanP{{ $i }}T, #simpanP{{ $i }}R, #simpanP{{ $i }}L, #simpanP{{ $i }}B").click(function() {
                  // var kondisiGigi{{ $i }} = $("#inputgigi{{ $i }}").val();
                  
                  var kondisiP{{ $i }}C = $('#kondisiP{{ $i }}C').val();
                  var diagnosaP{{ $i }}C = $('#diagnosaP{{ $i }}C').val();

                  var kondisiP{{ $i }}T = $('#kondisiP{{ $i }}T').val();
                  var diagnosaP{{ $i }}T = $('#diagnosaP{{ $i }}T').val();

                  var kondisiP{{ $i }}R = $('#kondisiP{{ $i }}R').val();
                  var diagnosaP{{ $i }}R = $('#diagnosaP{{ $i }}R').val();

                  var kondisiP{{ $i }}L = $('#kondisiP{{ $i }}L').val();
                  var diagnosaP{{ $i }}L = $('#diagnosaP{{ $i }}L').val();

                  var kondisiP{{ $i }}B = $('#kondisiP{{ $i }}B').val();
                  var diagnosaP{{ $i }}B = $('#diagnosaP{{ $i }}B').val();

                  $('#modalGigiPC{{ $i }}').modal("hide");
                  gigic{{ $i }}.c{{ $i }} = {kondisi: kondisiP{{ $i }}C, diagnosa: diagnosaP{{ $i }}C};

                  $('#modalGigiPT{{ $i }}').modal("hide");
                  gigit{{ $i }}.t{{ $i }} = {kondisi: kondisiP{{ $i }}T, diagnosa: diagnosaP{{ $i }}T};


                  $('#modalGigiPR{{ $i }}').modal("hide");
                  gigir{{ $i }}.r{{ $i }} = {kondisi: kondisiP{{ $i }}R, diagnosa: diagnosaP{{ $i }}R};


                  $('#modalGigiPL{{ $i }}').modal("hide");
                  gigil{{ $i }}.l{{ $i }} = {kondisi: kondisiP{{ $i }}L, diagnosa: diagnosaP{{ $i }}L};

                  $('#modalGigiPB{{ $i }}').modal("hide");
                  gigib{{ $i }}.b{{ $i }} = {kondisi: kondisiP{{ $i }}B, diagnosa: diagnosaP{{ $i }}B};
                  
                  gigi{{ $i }} = {gigic{{ $i }}, gigit{{ $i }}, gigir{{ $i }}, gigil{{ $i }}, gigib{{ $i }}};

                  $('#inputgigi{{ $i }}').val(JSON.stringify(gigi{{ $i }}));
                  
                  // console.log(gigi{{ $i }});
               });

            </script>

            <script> 
               function mouseOutPC() {
                  document.getElementById("demo").innerHTML ="";
                  }
               function mouseOutPT() {
                  document.getElementById("demo").innerHTML ="";
                  }
               function mouseOutPR() {
                  document.getElementById("demo").innerHTML ="";
                  }
               function mouseOutPL() {
                  document.getElementById("demo").innerHTML ="";
                  }
               function mouseOutPB() {
                  document.getElementById("demo").innerHTML ="";
                  }
            </script>


         @endif
      @endfor
  @endsection