<table>
    <thead>
        <tr>
            <th colspan="3">Formulir RL 3.13a</th>
        </tr>
        <tr>
            <th colspan="3">RL 3.13a Pengadaan Obat</th>
        </tr>
    </thead>
</table>

<table class='table table-striped table-bordered table-hover table-condensed'>
    <thead>
    <tr>
          <th class="text-center" valign="top">No</th>
          <th class="text-center" valign="top">GOLONGAN OBAT</th>
          <th class="text-center" valign="top">JUMLAH ITEM OBAT</th>
          <th class="text-center">JUMLAH ITEM OBAT YANG TERSEDIA DI RUMAH SAKIT</th>
          <th class="text-center">JUMLAH ITEM OBAT FORMULATORIUM TERSEDIA DIRUMAH SAKIT</th>
      </tr>
    </thead>
    <tbody>
          <tr>
            <td>1</td>
            <td class="text-left">Obat Generik (Formularium+Non Formularium)</td>
            <td class="text-left">{{ $data['obat_seluruh_obat'] }}</td>
            <td class="text-left">{{ $data['obat_seluruh_obat'] }}</td>
            <td class="text-left">{{ $data['obat_seluruh_formularium_obat'] }}</td>
          </tr>
          <tr>
            <td>2</td>
            <td class="text-left">Obat Non Generik Formularium</td>
            <td class="text-left">{{ $data['stok_obat_generik_formularium'] }}</td>
            <td class="text-left">{{ $data['stok_obat_generik_formularium'] }}</td>
            <td class="text-left">{{ $data['obat_seluruh_formularium_obat'] }}</td>
          </tr>
          <tr>
            <td>3</td>
            <td class="text-left">Obat Non Generik Non Formularium</td>
            <td class="text-left">{{ $data['stok_obat_generik_non_formularium'] }}</td>
            <td class="text-left">{{ $data['stok_obat_generik_non_formularium'] }}</td>
            <td class="text-left">{{ $data['obat_seluruh_formularium_obat'] }}</td>
          </tr>
          <tr>
            <th>#</th>
            <th class="text-left">Total</th>
            <th class="text-left">{{ $data['obat_seluruh_obat'] + $data['stok_obat_generik_formularium'] + $data['stok_obat_generik_non_formularium'] }}</th>
            <th class="text-left">{{ $data['obat_seluruh_obat'] + $data['stok_obat_generik_formularium'] + $data['stok_obat_generik_non_formularium'] }}</th>
            <th class="text-left">{{ $data['obat_seluruh_formularium_obat'] + $data['obat_seluruh_formularium_obat'] + $data['obat_seluruh_formularium_obat'] }}</th>
          </tr>
      </tbody>
    </table>