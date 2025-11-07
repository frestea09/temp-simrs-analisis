@extends('master')
@section('header')
    <h1>Kasir Rawat Darurat</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
     
    <div class="box-body">
        
        <div class="row">
          
          <div class="col-md-6">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">No RM/NAMA</button>
              </span>
              {!! Form::text('keyword', null, [
                'class' => 'form-control', 
                'autocomplete' => 'off', 
                'placeholder' => 'NO RM/NAMA',
                'required',
                ]) !!}
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-3">
                <button class="btn btn-primary btn-flat searchBtn">
                    <i class="fa fa-search"></i> Cari
                </button>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button">Status</button>
                </span>


                <select name="status_bayar" class="form-control">
                  <option value="">-- Semua --</option>
                  <option value="lunas">Sudah Dibayar</option>
                  <option value="belum">Belum Dibayar</option>
                </select>
              </div>
            </div>
          </div>

          
      </div>
        <hr>
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' id='kasirIgd'>
          <thead>
            <tr>
              <th class="text-center" style="vertical-align: middle;">No</th>
              <th class="text-center" style="vertical-align: middle;">Nama Pasien</th>
              <th class="text-center" style="vertical-align: middle;">No. RM</th>
              <th class="text-center" style="vertical-align: middle;">Dokter</th>
              <th class="text-center" style="vertical-align: middle;">Klinik</th>
              <th class="text-center" style="vertical-align: middle;">Cara Bayar</th>
              <th class="text-center" style="vertical-align: middle;">Keterangan</th>
              <th class="text-center" style="vertical-align: middle;">Tanggal</th>
              <th class="text-center" style="vertical-align: middle;">Tagihan</th>
              <th class="text-center" style="vertical-align: middle;">Pembayaran</th>
              <th class="text-center" style="vertical-align: middle;">No. Kwitansi</th>
              <th class="text-center" style="vertical-align: middle;">Bayar</th>
              <th class="text-center" style="vertical-align: middle;">Billing</th>
              <th class="text-center" style="vertical-align: middle;">RB</th>
              <th class="text-center" style="vertical-align: middle;">SIP</th>
              <th class="text-center" style="vertical-align: middle;">Surat Pulang Paksa</th>
              {{-- <th class="text-center" style="vertical-align: middle;">Piutang</th> --}}
            </tr>
          </thead>
          <tbody>
            @isset($today)
              @foreach ($today as $key => $d)
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $d->pasien->nama }}</td>
                    <td>{{ $d->pasien->no_rm }}</td>
                    <td>{{ baca_dokter($d->dokter_id) }}</td>
                    <td>{{ $d->poli->nama }}</td>
                    <td>{{ baca_carabayar($d->bayar) }} {{ (!empty($d->tipe_jkn) && $d->bayar == 1) ? ' - '.$d->tipe_jkn : '' }}</td>
                    <td>{{ $d->keterangan ? $d->keterangan : '-' }}</td>
                    <td>{{ $d->created_at->format('d-m-Y') }}</td>
                    <td class="text-right">{{ number_format(total_tagihan($d->id)) }}</td>
                    <td class="text-right">{{ number_format(total_dibayar($d->id)) }}</td>
                    <td class="text-center">
                      {{-- @if ($d->lunas == 'Y')
                          <i class="fa fa-check"> </i>
                      @else --}}
                          <a href="{{ url('kasir/rawatjalan/bayar/'. $d->id.'/'.$d->pasien_id) }}" class="btn btn-sm btn-info btn-flat"><i class="fa fa-credit-card"></i></a>
                      {{-- @endif --}}
                    </td>
                    <td>
                      <a href="{{ url('tindakan/entry/'. $d->id.'/'.$d->pasien_id) }}" class="btn btn-sm btn-warning btn-flat"><i class="fa fa-edit"></i></a>
                    </td>
                    <td>
                      <button type="button"
                        onclick="rincianBiaya({{ @$d->id }}, '{{ @$d->pasien->nama }}', {{ @$d->pasien->no_rm }} )"
                        class="btn btn-info btn-sm btn-flat"><i class="fa fa-search"></i></button>
                    </td>
                    <td class="text-center">
                      <a href="{{ url('tindakan/cetak-sip/'.$d->id) }}" target="_blank"  class="btn btn-warning btn-sm btn-flat"><i class="fa fa-print text-center"></i></a>
                    </td>
                    <td class="text-center">
                      <a href="{{ url('kasir/cetak-surat-pulang-paksa/'. $d->id) }}" target="_blank"  class="btn btn-warning btn-sm btn-flat"><i class="fa fa-print text-center"></i></a>
                    </td>
                  </tr>
              @endforeach
            @endisset
          </tbody>
        </table>
      </div>


      <div class="modal fade" id="modalRincianBiaya" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id=""></h4>
            </div>
            <div class="modal-body">
              <div class='table-responsive'>
                <div class="rincian_biaya">
                </div>
                {{-- <a href="{{ url('kasir/rincian-biaya/'.$d->id) }}" target="_blank" class="btn btn-info btn-sm pull-right"><i class="fa fa-print"></i></a> --}}
                <br/>
                <table class='table table-striped table-bordered table-hover table-condensed'>
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Tindakan</th>
                      {{--<th>Waktu Entry Tindakan</th>--}}
                      <th>Jenis Pelayanan</th>
                      <th>Biaya</th>
                    </tr>
                  </thead>
                  <tbody class="tagihan">
                  </tbody>
                  <tfoot>
                    <tr>
                      <th class="text-center" colspan="2">
                        <div class="rincian_biaya">
      
                        </div>
                      </th>
                      <th class="text-right">Total Tagihan</th>
                      <th class="text-right totalTagihan"></th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
  </div>

@endsection


@section('script')
  <script type="text/javascript">
    $('.select2').select2()
    $(document).ready(function() {
      var kasirIgd = $('#kasirIgd').DataTable({
        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: {
          url: '/kasir/data-igd',
          data:function(d){
            d.keyword = $('input[name="keyword"]').val();
            d.status_bayar = $('select[name="status_bayar"]').val(); // <-- tambahan
          }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            {data: 'nama', orderable: false},
            {data: 'no_rm', orderable: false},
            {data: 'dokter_umum', orderable: false},
            {data: 'poli', orderable: false},
            {data: 'cara_bayar', orderable: false},
            {data: 'keterangan', orderable: false},
            {data: 'tanggal', orderable: false},
            {data: 'tagihan', orderable: false},
            {data: 'pembayaran', orderable: false},
            {data: 'no_kuitansi', orderable: false},
            {data: 'bayar', orderable: false},
            {data: 'billing', orderable: false},
            {data: 'rincian', orderable: false},
            {data: 'sip', orderable: false},
            {data: 'pulpak', orderable: false},
        ]
      });

      $(".searchBtn").click(function (){
        kasirIgd.draw();
      });

      $('select[name="status_bayar"]').on('change', function () {
          kasirIgd.draw();
      });

      if($('select[name="carabayar"]').val() == 1) {
        $('select[name="tipe_jkn"]').removeAttr('disabled');
      } else {
        $('select[name="tipe_jkn"]').attr('disabled', true);
      }

      $('select[name="carabayar"]').on('change', function () {
        if ($(this).val() == 1) {
          $('select[name="tipe_jkn"]').removeAttr('disabled');
        } else {
          $('select[name="tipe_jkn"]').attr('disabled', true);
        }
      });
    });


  (function blink() {
    $('.blink_me').fadeOut(500).fadeIn(500, blink);
  })();

  function ribuan(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  }
  function jenisLayanan(jenis) {
    switch (jenis) {
      case 'TA':
        return 'Layanan rawat jalan';
        break;
      case 'TG':
        return 'Layanan rawat darurat';
        break;
      case 'TI':
        return 'Layanan rawat inap';
        break;
      default:
        return 'Apotik';
        break;
    }
  }

    function rincianBiaya(registrasi_id, nama, no_rm) {
    // alert(registrasi_id)
    $('#modalRincianBiaya').modal('show');
    $('.modal-title').text(nama + ' | ' + no_rm + '|' + registrasi_id)
    $('.tagihan').empty();
    $('.rincian_biaya').empty();
    $.ajax({
      url: '/informasi-rincian-biaya/' + registrasi_id,
      type: 'GET',
      dataType: 'json',
      success: function (data) {
        cetak = '<a class="btn btn-info btn-sm pull-right" style="margin-left:10px" target="_blank" href="/ranap-informasi-rincian-biaya/'+registrasi_id+'"><span class="fa fa-print"></span> Rincian Biaya</a>';
        cetak2 = '<a class="btn btn-success btn-sm pull-right" target="_blank" href="/ranap-informasi-unit-rincian-biaya/'+registrasi_id+'"><span class="fa fa-print"></span> Rincian Biaya Unit</a><br/>';
        $('.rincian_biaya').append(cetak)
        $('.rincian_biaya').append(cetak2)
        // console.log(data);
        $.each(data, function (key, value) {
          $('.tagihan').append('<tr> <td>' + (key + 1) + '</td> <td>' + value.namatarif + '</td> <td>' + jenisLayanan(value.jenis) + '</td> <td class="text-right">' +
            ribuan(value.total) + '</td> </tr>')
        });
      }
    });

    $.ajax({
      url: '/informasi-total-biaya/' + registrasi_id,
      type: 'GET',
      dataType: 'json',
      success: function (data) {
        console.log(data);
        $('.totalTagihan').html(ribuan(data))
      }
    });
  }

  </script>
@endsection
