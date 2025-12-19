<li class="{{ $route == 'soap' ? 'active' : '' }}"><a
        href="{{ url('emr/soap-farmasi/' . $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">CPPT</a>
</li>
<li><a
        href="{{ url('emr-soap/pemeriksaan/penelusuran-obat-igd/'. $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Rekonsiliasi Obat</a>
</li>
<li><a
        href="{{ url('emr-soap/pemeriksaan/inap/daftar-pemberian-terapi/'. $unit . '/' . $registrasi_id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}">Pemberian Terapi</a>
</li>
<li>
        <a href="#" id="historipenjualaneresep" data-bayar="{{@$reg->bayar ? $reg->bayar :''}}" data-registrasiID="{{ $reg->id }}">History E-Resep
        </a>
</li>
<div class="modal fade" id="showHistoriPenjualanEresep" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="">History E-Resep</h4>
                </div>
                <div class="modal-body">
                <div id="dataHistoriEresep"></div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
                </div>
                </div>
        </div>
</div>