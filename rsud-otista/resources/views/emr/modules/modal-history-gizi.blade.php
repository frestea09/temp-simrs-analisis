
@if (count($historyEmr) == 0)
  <span>Tidak Ada Record</span>
@else
  <div id="data-list-history-gizi">
    <table class="table table-bordered">
      @foreach($historyEmr as $key_a => $val_a)
        <tr style="background-color:#9ad0ef">
          <th>{{ @$val_a->registrasi->reg_id }}</th>
          <th>{{ @$val_a->kamar->nama }}</th>
        </tr>
        <tr style="background-color:#9ad0ef">
          <th>{{ @date('d-m-Y, H:i', strtotime($val_a->created_at)) }}</th>
          <th>{{ @$val_a->user->name }}</th>
        </tr>
        <tr>
          <td colspan="2"><b>A:</b> {!! $val_a->assesment !!}</td>
        </tr>
        <tr>
          <td colspan="2"><b>D:</b> {!! $val_a->diagnosis !!}</td>
        </tr>
        <tr>
          <td colspan="2"><b>I:</b> {!! $val_a->intervensi !!}</td>
        </tr>
        <tr>
          <td colspan="2"><b>M:</b> {!! $val_a->monitoring !!}</td>
        </tr>
        <tr>
          <td colspan="2"><b>E:</b> {!! $val_a->evaluasi !!}</td>
        </tr>
      @endforeach
    </table>
  </div>
@endif
