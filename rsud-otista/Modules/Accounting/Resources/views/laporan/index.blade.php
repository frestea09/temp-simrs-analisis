@extends('master')
@section('header')
  <h1>{{ucfirst(request()->segment(1))}} - {{ucfirst(request()->segment(count(request()->segments())))}}<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body"> 
      {{-- PENDAFTARAN --}}
      <table style="width:100%">
        <tr>
          <td> 
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
              <a href="{{ url('/accounting/laporan/journal') }}" ><img src="{{ asset('menu/fixed/jurnal.png') }}" width="50px" class="img-responsive" alt="" style="50%"/>
              </a>
              <h5>Jurnal</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
              <a href="{{ asset('/accounting/laporan/buku_besar') }}" ><img src="{{ asset('menu/fixed/buku_besar.png') }}" width="50px" class="img-responsive" alt="" style="50%"/>
              </a>
              <h5>Buku Besar</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
              <a href="{{ asset('/accounting/laporan/buku_besar_pembantu') }}" ><img src="{{ asset('menu/fixed/buku_besar_pembantu.png') }}" width="50px" class="img-responsive" alt="" style="50%"/>
              </a>
              <h5>Buku Besar Pembantu</h5>
            </div> 
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
              <a href="{{ asset('/accounting/laporan/neraca') }}" ><img src="{{ asset('menu/fixed/neraca.png') }}" width="50px" class="img-responsive" alt="" style="50%"/>
              </a>
              <h5>Neraca</h5>
            </div> 
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
              <a href="{{ asset('/accounting/laporan/laba_rugi') }}" ><img src="{{ asset('menu/fixed/laba_rugi.png') }}" width="50px" class="img-responsive" alt="" style="50%"/>
              </a>
              <h5>Laba Rugi</h5>
            </div> 
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
              <a href="{{ asset('/accounting/laporan/arus_kas') }}" ><img src="{{ asset('menu/fixed/arus_kas.png') }}" width="50px" class="img-responsive" alt="" style="50%"/>
              </a>
              <h5>Arus Kas</h5>
            </div> 
          </td>
        </tr>
      </table> 
      <br/>
    </div> 
  </div>


@endsection
 
