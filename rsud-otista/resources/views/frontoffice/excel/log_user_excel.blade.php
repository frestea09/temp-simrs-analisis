<table class='table table-striped table-bordered table-hover table-condensed' id='data'>
  <thead>
    <tr>
      <th width="40px" class="text-center">No</th>
      <th class="text-center">User</th>
      <th class="text-center">Tanggal</th>
      <th class="text-center">CPPT</th>
      <th class="text-center">ASESMEN</th>
      <th class="text-center">BILLING</th>
      <th class="text-center">E-RESEP</th>
    </tr>
  </thead>
  <tbody>
    @if (isset($log) && !empty($log))

    @foreach ($log as $no => $d)
    @php
    $cppt = \App\LogUser::where('user_id',$d->user_id)->where('tanggal',$d->tanggal)->where('text','cppt')->count();
    $asesmen =
    \App\LogUser::where('user_id',$d->user_id)->where('tanggal',$d->tanggal)->where('text','asesmen')->count();
    $billing =
    \App\LogUser::where('user_id',$d->user_id)->where('tanggal',$d->tanggal)->where('text','billing')->count();
    $eresep = \App\LogUser::where('user_id',$d->user_id)->where('tanggal',$d->tanggal)->where('text','eresep')->count();
    @endphp
    <tr>
      <td>{{$no+1}}</td>
      <td>{{baca_user($d->user_id)}}</td>
      <td>{{date('d-m-Y',strtotime($d->tanggal))}}</td>
      <td class="text-center">{!!$cppt > 0 ? '✓' :''!!}</td>
      <td class="text-center">{!!$asesmen > 0 ? '✓' :''!!}</td>
      <td class="text-center">{!!$billing > 0 ? '✓' :''!!}</td>
      <td class="text-center">{!!$eresep > 0 ? '✓' :''!!}</td>
    </tr>
    @endforeach

    @endif
  </tbody>
</table>