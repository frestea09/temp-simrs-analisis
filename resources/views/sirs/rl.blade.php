@extends('master')
@section('header')
  <h1>RL Kemenkes/</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="row">

        {{-- <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule kemkes">
          <a href="#" ><img src="{{ asset('menu/fixed/indikatorpelayanan.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          <h5>RL 1.2 Indikator Pelayanan</h5>
        </div> --}}
        {{-- pelayanan --}}
        {{-- <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule kemkes">
          <a href="#" ><img src="{{ asset('menu/fixed/masterkamar.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          <h5>RL 1.3 Tempat Tidur</h5>
        </div> --}}
        {{-- tempat-tidur --}}
        {{-- <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule kemkes">
          <a href="#" ><img src="{{ asset('menu/fixed/dokterhfis.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          <h5>RL 2 Ketenagaan</h5>
        </div> --}}
        {{-- ketenagaan --}}
        <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule kemkes">
          <a href="{{ url('kegiatan-pelayanan-rawat-inap') }}" ><img src="{{ asset('menu/fixed/rawatinap.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          <h5>RL 3.1 Rawat Inap</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule kemkes">
          <a href="{{ url('kujungan-rawat-darurat') }}" ><img src="{{ asset('menu/fixed/igd.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          <h5>RL 3.2 Rawat Darurat</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule kemkes">
          <a href="{{ url('kegiatan-kesehatan-gigi-dan-mulut') }}" ><img src="{{ asset('menu/fixed/gigidanmulut.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          <h5>RL 3.3 Gigi Mulut</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule kemkes">
          <a href="{{ url('sirs/rl/kebidanan') }}" ><img src="{{ asset('menu/fixed/kebidanan.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          <h5>RL 3.4 Kebidanan</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule kemkes">
          <a href="{{ url('sirs/rl/perinatologi') }}" ><img src="{{ asset('menu/fixed/perinatologi.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          <h5>RL 3.5 Perinatologi</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule kemkes">
          <a href="{{ url('kegiatan-pembedahan') }}" ><img src="{{ asset('menu/fixed/pembedahan.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          <h5>RL 3.6 Pembedahan</h5>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule kemkes">
          <a href="{{ url('kegiatan-radiologi') }}" ><img src="{{ asset('menu/fixed/radiologi.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          <h5>RL 3.7 Radiologi</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule kemkes">
          <a href="{{ url('pemeriksaan-laboratorium') }}" ><img src="{{ asset('menu/fixed/laboratorium.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          <h5>RL 3.8 Laboratorium</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule kemkes">
          <a href="{{ url('kegiatan-rehabilitasi-medik') }}" ><img src="{{ asset('menu/fixed/rehabmedik.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          <h5>RL 3.9 Rehab Medik</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule kemkes">
          <a href="{{ url('kegiatan-pelayanan-khusus') }}" ><img src="{{ asset('menu/fixed/pelayanankhusus.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          <h5>RL 3.10 Pelayanan Khusus</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule kemkes">
          <a href="{{ url('kegiatan-kesehatan-jiwa') }}" ><img src="{{ asset('menu/fixed/kesehatanjiwa.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          <h5>RL 3.11 Kesehatan Jiwa</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule kemkes">
          <a href="{{ url('kegiatan-keluarga-berencana') }}" ><img src="{{ asset('menu/fixed/kb.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          <h5>RL 3.12 Keluarga Berencana</h5>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule kemkes">
          <a href="{{ url('kegiatan-rujukan') }}" ><img src="{{ asset('menu/fixed/transit.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          <h5>RL 3.14 Rujukan</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule kemkes">
          <a href="{{ url('kegiatan-cara-bayar') }}" ><img src="{{ asset('menu/fixed/carabayar.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          <h5>RL 3.15 Cara Bayar</h5>
          </a>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule kemkes">
          <a href="{{ url('sirs/rl/penyakit-rawat-inap-sebab-luar') }}" ><img src="{{ asset('menu/fixed/penyakitranap.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          <h5>RL 4A Penyakit Rawat Inap (sebab luar)</h5>
          </a>
        </div>
        {{-- sirs/rl/penyakit-rawat-inap-sebab-luar --}}
        <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule kemkes">
          <a href="#" ><img src="{{ asset('menu/fixed/penyakitranap.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          <h5>RL 4A Penyakit Rawat Inap</h5>
        </a>
        </div>
        {{-- sirs/rl/penyakit-rawat-inap --}}
        <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule kemkes">
          <a href="#" ><img src="{{ asset('menu/fixed/penyakitrajal.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          <h5>RL 4B Penyakit Rawat Jalan (sebab luar)</h5>
          </a>
        </div>
        {{-- sirs/rl/penyakit-rawat-jalan-sebab-luar --}}
        <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule kemkes">
          <a href="#" ><img src="{{ asset('menu/fixed/penyakitrajal.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          <h5>RL 4B Penyakit Rawat Jalan</h5>
          </a>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule kemkes">
          <a href="{{ url('kegiatan-pengujung') }}" ><img src="{{ asset('menu/fixed/pengunjung.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          <h5>RL 5.1 Pengunjung</h5>
          </a>
        </div>
        {{-- sirs/rl/penyakit-rawat-jalan --}}
        {{-- <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule kemkes">
          <a href="#" ><img src="{{ asset('menu/fixed/pengadaanobat.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          <h5>RL 3.13a Pengadaan Obat</h5>
        </a>
        </div> --}}
        {{-- pengadaan-obat --}}
        {{-- <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule kemkes">
          <a href="#" ><img src="{{ asset('menu/fixed/penulisanresepobat.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          <h5>RL 3.13b Penulisan dan Pelayanan Resep Obat</h5>
        </a>
        </div> --}}
        {{-- pelayanan-resep --}}
        <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule kemkes">
          <a href="{{ url('kujungan-rawat-jalan') }}" ><img src="{{ asset('menu/fixed/rawatjalan.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          <h5>RL 5.2 Kunjungan Rawat Jalan</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule kemkes">
          <a href="{{ url('10-besar-diagnosa-irna-baru') }}" ><img src="{{ asset('menu/fixed/sepuluhbesar.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          <h5>RL 5.3 10 Besar Penyakit Rawat Inap</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule kemkes">
          <a href="{{ url('10-besar-diagnosa-irj-baru') }}" ><img src="{{ asset('menu/fixed/sepuluhbesar.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          <h5>RL 5.3 10 Besar Penyakit Rawat Jalan</h5>
        </div>
        {{-- <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule kemkes">
          <a href="#" ><img src="{{ asset('menu/fixed/sepuluhbesar.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
          <h5>RL 5.4 10 Besar Penyakit Rawat Jalan</h5>
        </div> --}}
        {{-- 10-besar-diagnosa-irj-baru --}}

        <div class="clearfix"></div>
        <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule kemkes">
            <a href="{{ url('rl-pemakaian-obat') }}" ><img src="{{ asset('menu/fixed/obatlasa.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
            <h5>RL 13A Pemakaian Obat</h5>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule kemkes">
            <a href="{{ url('rl-jumlah-obat') }}" ><img src="{{ asset('menu/fixed/obathighalert.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
            <h5>RL 13B Jumlah Obat</h5>
        </div>
           <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule kemkes">
            <a href="{{ url('rl-jumlah-obat') }}" ><img src="{{ asset('menu/fixed/obathighalert.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
            <h5>RL 13B Hello</h5>
        </div>
           <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule kemkes">
        <a  href="{{ url('sirs/rl/laporan-morbiditas') }}"  ><img src="{{ asset('menu/fixed/daftarpejabat.png') }}"  width="50px" heigth="50px"  class="img-responsive" alt=""/>
             <h5>Laporan Morbiditas </h5>
        </a>
  
      </div>
         <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule kemkes">
        <a  href="{{ url('sirs/rl/filter-dbd') }}"  ><img src="{{ asset('menu/fixed/daftarpejabat.png') }}"  width="50px" heigth="50px"  class="img-responsive" alt=""/>
             <h5>Laporan DBD </h5>
        </a>
  
      </div>
       <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule kemkes">
        <a  href="{{ url('sirs/rl/filter-icd') }}"  ><img src="{{ asset('menu/fixed/daftarpejabat.png') }}"  width="50px" heigth="50px"  class="img-responsive" alt=""/>
           <h5>Laporan ICD </h5>
        </a>
     
      </div>
       <div class="col-md-2 col-sm-3 col-xs-6 text-center iconModule kemkes">
        <a  href="{{ url('sirs/rl/filter-special-attention-diseases') }}"  ><img src="{{ asset('menu/fixed/daftarpejabat.png') }}"  width="50px" heigth="50px"  class="img-responsive" alt=""/>
         <h5>Laporan Kunjungan Perhatian Khusus </h5>
        </a>
       
      </div>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
