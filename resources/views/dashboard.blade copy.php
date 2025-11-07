@extends('master')
@section('header')
  <h1> {{ Auth::user()->name }}, <small> Anda Masuk ke sebagai : </small> {{ ucfirst(Auth::user()->role()->first()->display_name)}}</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-body">

{{-- @if (@\App\Satusehat::find(16)->aktif) --}}
  <div class="row">
    <div class="col-lg-2 col-xs-4">
      <!-- small box -->
      <div class="small-box bg-primary">
        <div class="inner text-center">
          <h3>{{ $total }}</h3>

          <p>Total </p>
        </div>
      </div>
    </div>
    <div class="col-lg-2 col-xs-4">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner text-center">
              <h3>{{ $rajal }}</h3>
              <p>Rawat Jalan</p>
            </div>
          </div>
        </div>

        <div class="col-lg-2 col-xs-4">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner text-center">
              <h3>{{ $igd }}</h3>

              <p>Rawat Darurat</p>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-xs-4">
          <!-- small box -->
          <div class="small-box bg-teal color-palette">
            <div class="inner text-center">
              <h3>{{ $irna }}</h3>

              <p>Rawat Inap</p>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-xs-4">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner text-center">
              <h3>{{ $l }}</h3>

              <p>Laki - laki</p>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-2 col-xs-4">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner text-center">
              <h3>{{ $p }}</h3>

              <p>Perempuan</p>
            </div>
          </div>
        </div>
        <!-- ./col -->
        
        
        

      </div>
  {{-- @endif --}}

    </div>
  </div>


  {{-- @if (@\App\Satusehat::find(17)->aktif) --}}
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
            <div class="box-header with-border">
              <i class="fa fa-bar-chart-o"></i>

              <h3 class="box-title">Grafik Kunjungan Klinik Hari Ini</h3>

            </div>
            <div class="box-body">
              <div id="bar-chart" style="height: 350px;"></div>
            </div>
            <!-- /.box-body-->
          </div>
      </div>
  </div>
  {{-- @endif --}}

  {{-- DASHBOARD KLINIK --}}
  {{-- @if (@\App\Satusehat::find(15)->aktif) --}}
      
  {{-- Kunjungan Klinik --}}
  <div class="row">
    <div class="col-md-12">
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">
            Kunjungan Pasien Per Klinik &nbsp;
          </h3>
        </div>
        <div class="box-body">
          <div class='table-responsive'>
            <table class='table table-striped table-bordered table-hover table-condensed'>
              <thead>
                <tr>
                  <th>No</th>
                  <th>Klinik</th>
                  <th class="text-center">Jumlah</th>
                </tr>
              </thead>
              <tbody>
                @foreach (@$poli as $d)
                  @if (!empty(@$d->poli_id))
                    <tr>
                      <td>{{ $no++ }}</td>
                      <td>{{ !empty(@$d->poli_id) ? @baca_poli($d->poli_id)  : '' }}</td>
                      <td class="text-center">{{ @pasien_perpoli(date('Y-m-d'), $d->poli_id) }}</td>
                    </tr>
                  @endif

                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- @endif --}}



        {{-- display tempat tidur --}}
     {{-- <div class="row">
      <div class="col-md-12">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">
              Display Data Tempat Tidur &nbsp;
            </h3>
          </div>
          <div class="box-body">
            <h4>
              <div class="row">
                  <div class="col-lg-3 col-xs-6">
                      <!-- small box -->
                      <div class="small-box bg-aqua">
                          <div class="inner">
                              <h3>{{ @Modules\Bed\Entities\Bed::where('hidden', 'N')->count() }}</h3>
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
                          <div class="inner">
                              <h3>{{ @Modules\Bed\Entities\Bed::where('hidden', 'N')->where('reserved', 'Y')->count() }}</h3>
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
                          <div class="inner">
                              <h3>{{ @Modules\Bed\Entities\Bed::where('hidden', 'N')->where('reserved', 'N')->count() }}</h3>
                              <p>Jumlah Tersedia</p>
                              <div class="icon" style="margin-top: 10px;">
                                  <i class="fa fa-bed"></i>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-lg-3 col-xs-6">
                      <!-- small box -->
                      <div class="small-box bg-blue">
                          <div class="inner">
                              <h3>
                                @php
                                    @$total =  @ceil((((Modules\Bed\Entities\Bed::where('hidden', 'N')->where('reserved', 'Y')->count()) / @(Modules\Bed\Entities\Bed::where('hidden', 'N')->count())) * 100/100) * 100);
                                @endphp
                                  {{@$total}}
                                  %
                              </h3>
                              <p>Persentase Tempat Tidur</p>
                              <div class="icon" style="margin-top: 10px;">
                                  <i class="fa fa-bed"></i>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
            </h4>
          </div>
        </div>
      </div>
    </div> --}}
@endsection
