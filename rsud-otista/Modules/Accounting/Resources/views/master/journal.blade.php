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
              <a href="{{ url('/accounting/journal_umum') }}" ><img src="{{ asset('menu/fixed/jurnal_umum.png') }}" class="img-responsive" alt="" style="50%"/>
              </a>
              <h5>Jurnal Umum</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
              <a href="{{ asset('/accounting/journal_memorial') }}" ><img src="{{ asset('menu/fixed/jurnal_memorial.png') }}" class="img-responsive" alt="" style="50%"/>
              </a>
              <h5>Jurnal Memorial</h5>
            </div> 
          </td>
        </tr>
      </table> 
      <br/>
    </div> 
  </div>


@endsection
 
