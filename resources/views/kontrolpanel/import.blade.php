@extends('master')
@section('header')
  <h1>Control Panel - Import <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
          <a href="{{ url('cari-file-pasien') }}" ><img src="{{ asset('menu/fixed/importpasien.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
          </a>
          <h5>Import Pasien</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
          <a href="{{ url('cari-file-pegawai') }}" ><img src="{{ asset('menu/fixed/importpasien.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
          </a>
          <h5>Import Pegawai</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
          <a href="{{ url('cari-file-irj') }}" ><img src="{{ asset('menu/fixed/importtarifrajal.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
          </a>
          <h5>Import Tarif Rawat Jalan</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
          <a href="{{ url('cari-filetarif-new') }}" ><img src="{{ asset('menu/fixed/importtarifrajal.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
          </a>
          <h5>Import Tarif New</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
          <a href="{{ url('cari-file-igd') }}" ><img src="{{ asset('menu/fixed/importtarifigd.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
          </a>
          <h5>Import Tarif Rawat Darurat</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
          <a href="{{ url('cari-file-irna') }}" ><img src="{{ asset('menu/fixed/importtarifranap.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          </a>
          <h5>Import Tarif Rawat Inap</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
          <a href="{{ url('cari-file-icd9') }}" ><img src="{{ asset('menu/fixed/icd9.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
          </a>
          <h5>Import ICD 9</h5>
        </div>
      </div>
      <div class="row">
        <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
          <a href="{{ url('cari-file-icd10') }}" ><img src="{{ asset('menu/fixed/icd10.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
          </a>
          <h5>Import ICD 10</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
          <a href="{{ url('cari-file-province') }}" ><img src="{{ asset('menu/fixed/icd10.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
          </a>
          <h5>Import jadwal dokter</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
          <a href="{{ url('cari-file-lis') }}" ><img src="{{ asset('menu/fixed/importtarifranap.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
          </a>
          <h5>Import Tindakan LIS</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
          <a href="{{ url('cari-file-ris') }}" ><img src="{{ asset('menu/fixed/importtarifranap.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
          </a>
          <h5>Import Tindakan RIS</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
          <a href="{{ url('cari-file-batch') }}" ><img src="{{ asset('menu/fixed/importtarifrajal.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
          </a>
          <h5>Import Logistik Batch</h5>
        </div>

      </div>
      
      {{-- <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('cari-file-province') }}" ><img src="{{ asset('menu/fixed/importpasien.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Impor Province</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('cari-file-kabupaten') }}" ><img src="{{ asset('menu/fixed/importpasien.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Impor Kabupaten</h5>
      </div> --}}
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
