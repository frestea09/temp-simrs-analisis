<table>
    <thead>
        <tr>
            <th colspan="3">Formulir RL 3.13b</th>
        </tr>
        <tr>
            <th colspan="3">RL 3.13b Pelayanan Rersep</th>
        </tr>
    </thead>
</table>

<table class='table table-striped table-bordered table-hover table-condensed'>
    <thead>
      <tr>
          <th class="text-left" valign="top">No</th>
          <th class="text-left" valign="top">GOLONGAN OBAT</th>
          <th class="text-left">RAWAT JALAN</th>
          <th class="text-left" valign="top">IGD</th>
          <th class="text-left">RAWAT INAP</th>
      </tr>
    </thead>
    <tbody>
          <tr>
            <td>1</td>
            <td class="text-left">Obat Generik (Formularium+Non Formularium)</td>
            <td class="text-left">{{ number_format($data['rawat_jalan_formalium_non']) }}</td>
            <td class="text-left">{{ number_format($data['rawat_igd_formalium_non']) }}</td>
            <td class="text-left">{{ number_format($data['rawat_irna_formalium_non']) }}</td>
          </tr>
          <tr>
            <td>2</td>
            <td class="text-left">Obat Non Generik Formularium</td>
            <td class="text-left">{{ number_format($data['rawat_jalan_formalium']) }}</td>
            <td class="text-left">{{ number_format($data['rawat_igd_formalium']) }}</td>
            <td class="text-left">{{ number_format($data['rawat_irna_formalium']) }}</td>
          </tr>
          <tr>
            <td>3</td>
            <td class="text-left">Obat Non Generik Non Formularium</td>
            <td class="text-left">{{ number_format($data['rawat_jalan_formalium_non_genrik']) }}</td>
            <td class="text-left">{{ number_format($data['rawat_igd_formalium_non_generik']) }}</td>
            <td class="text-left">{{ number_format($data['rawat_irna_formalium_non_generik']) }}</td>
          </tr>
          <tr>
            <th>#</th>
            <th class="text-left">Total</th>
            <th class="text-left">{{ number_format($data['rawat_jalan_formalium_non'] + $data['rawat_jalan_formalium'] + $data['rawat_jalan_formalium_non_genrik']) }}</th>
            <th class="text-left">{{ number_format($data['rawat_igd_formalium_non'] + $data['rawat_igd_formalium'] + $data['rawat_igd_formalium_non_generik']) }}</th>
            <th class="text-left">{{ number_format($data['rawat_irna_formalium_non'] + $data['rawat_irna_formalium'] + $data['rawat_irna_formalium_non_generik']) }}</th>
          </tr>
      </tbody>
    </table>