@extends('master')

@section('header')
  <h1>Sistem PPI</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      {{-- <h3 class="box-title">
           LAPORAN PPI
      </h3> --}}
    </div>
    <div class="box-body">
         @if ($inap->count() > 0)
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
          <thead>
            <tr>
              <th class="text-center" style="vertical-align: middle">No</th>
              <th class="text-center" style="vertical-align: middle">No. RM</th>
              <th class="text-center" style="vertical-align: middle">Nama</th>
              <th class="text-center" style="vertical-align: middle">Kelas</th>
              <th class="text-center" style="vertical-align: middle">Kamar</th>
              <th class="text-center" style="vertical-align: middle">Bed</th>
              <th class="text-center" style="vertical-align: middle">Cara Bayar</th>
              <th class="text-center" style="vertical-align: middle">Tanggal Masuk</th>
              <th class="text-center" style="vertical-align: middle">Tanggal Keluar</th>
                @if ($status_reg == 'I2')
                    <th class="text-center" style="vertical-align: middle">PPI</th>
                @endif
            </tr>
          </thead>
          <tbody>
            @foreach ($inap as $key => $d)
              @php
                $reg = Modules\Registrasi\Entities\Registrasi::where('id', @$d->registrasi_id)->first();
              @endphp
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ @$reg->pasien->no_rm }}</td>
                <td>{{ @$reg->pasien->nama }}</td>
                <td>{{ baca_kelas($d->kelas_id) }}</td>
                <td>{{ baca_kamar($d->kamar_id) }}</td>
                <td>{{ baca_bed($d->bed_id) }}</td>
                <td>{{ baca_carabayar(@$reg->bayar) }} {{ !empty(@$reg->tipe_jkn) ? ' - '.@$reg->tipe_jkn : '' }}</td>
                <td onclick="updateTgl({{ $d->registrasi_id }})">{{ tanggal_eklaim($d->tgl_masuk) }}</td>
                <td>{{ tanggal_eklaim($d->tgl_keluar) }}</td>
                @if (@$reg->status_reg == 'I2')
                    <td class="text-center">
                        <a href="{{ url('hais/inap/'.@$reg->id) }}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-pencil"> </i></a>
                </td>
                @endif
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      @endif
    </div>


@endsection

@section('script')
<script type="text/javascript">
    $('select[name="pasien_id"]').select2({
        placeholder: "Pilih Nama Pasien...",
        language : {
            "noResults":function(){
                return "Pasien Tidak Ada Atau Stok Habis!";
            }
        }, 
        ajax: {
            url: '/master-get-pasien',
            dataType: 'json',
            data: function (params) {
                return {
                    q: $.trim(params.term)
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    })
    $('select[name="tindakan_id"]').select2()

    function resetForm(){
        $('.tindakan_idGroup').removeClass('has-error');
        $('.tindakan_idError').text('')
        $('.jumlah_tindakanGroup').removeClass('has-error');
        $('.jumlah_tindakanError').text('')
    }

    function save(){
        var data = $('#formPpi').serialize()
        var id = $('input[name="id"]').val()

        var url = '{{ route('ppi.store') }}'
        $.post( url, data, function(resp){
            resetForm()
            if(resp.sukses == false){
                if(resp.error.tindakan_id){
                    $('.tindakan_idGroup').addClass('has-error');
                    $('.tindakan_idError').text(resp.error.tindakan_id[0])
                }
                if(resp.error.jumlah_tindakan){
                    $('.jumlah_tindakanGroup').addClass('has-error');
                    $('.jumlah_tindakanError').text(resp.error.jumlah_tindakan[0])
                }
            } if(resp.sukses == true){
                $('#formPpi')[0].reset();
                table.ajax.reload();
            }
        })

    }

    function hapus(id){
        if(confirm('Yakin transaksi ini akan dihapus ?')){
            $('input[name="id"]').val()
            $('input[name="_method"]').val('PATCH')
            $.get('/ppi/'+id+'/delete', function(resp){
                if(resp.sukses == false){
                    table.ajax.reload();
                }
                if (resp.sukses== true) {
                    table.ajax.reload();
                }  
            })
        }
    }
</script>
@endsection
