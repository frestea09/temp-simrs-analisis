<table class='table-striped table-bordered table-hover table-condensed table' id='responseTimeIRJ'>
    <thead>
        <tr>
            <th class="text-center">No.</th>
            <th class="text-center">No.RM</th>
            <th class="text-center">Nama Pasien</th>
            <th class="text-center">Jenis</th>
            <th class="text-center">Poli</th>
            <th class="text-center">Tanggal</th>
            <th class="text-center">Chek In</th>
            <th class="text-center">Registrasi</th>
            <th class="text-center">SEP</th>
            <th class="text-center">Masuk Poli</th>
            <th class="text-center">Proses Poli</th>
            <th class="text-center">E Resep</th>
            <th class="text-center">Tunggu Pendaftaran</th>
            <th class="text-center">Tunggu Poli</th>
            <th class="text-center">Lama Pelayanan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $key=>$item)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{@$item->no_rm}}</td>
                <td>{{@$item->nama}}</td>
                <td>
                    @php
                         if (@$item->checkin != null) {
                            $time       = '08:00:00';
                            @$checkin    = date('H:i:s', strtotime(@$item->checkin));
                            if (\Carbon\Carbon::parse(@$checkin)->greaterThan(\Carbon\Carbon::parse($time))) {
                                 echo 'On Site';
                            } else {
                                echo 'Perjanjian';
                            }
                        } else {
                            echo 'Online';
                        }
                    @endphp
                </td>
                <td>{{@$item->poli}}</td>
                <td>{{@$item->tanggal ? @date('d-m-Y', strtotime($item->tanggal)) : '-'}}</td>
                <td>
                    {{@$item->checkin}}
                </td>
                <td>{{@$item->start_regis ? @date('H:i', strtotime(@$item->start_regis)) : '-'}}</td>
                <td>
                    @php
                        if($item->no_sep !== null){
                            echo $item->no_sep;
                        }else{
                            echo '-';
                        }
                    @endphp
                </td>
                <td>
                    @php
                        if ($item->status_panggil == 0) {
                            echo '-';
                        }else{
                            echo $item->enter_poli ? date('H:i', strtotime($item->enter_poli)) : '-';
                        }
                    @endphp
                </td>
                <td>
                    @php    
                        if (@$item->cppt != null) {
                            echo @date('H:i', strtotime($item->cppt));
                        }
                        if (@$item->asesmen != null) {
                            echo @date('H:i', strtotime($item->asesmen));
                        }
                        
                    @endphp
                </td>
                <td>{{@$item->eresep ? @date('H:i', strtotime($item->eresep)) : '-'}}</td>
                <td>
                    @php
                        if ($item->checkin != null && $item->start_regis != null) {
                            @$time       = '08:00:00';
                            @$checkin    = date('H:i:s', strtotime($item->checkin));
                            if (\Carbon\Carbon::parse($checkin)->greaterThan(\Carbon\Carbon::parse($time))) {
                                @$diff = @\Carbon\Carbon::parse($item->checkin)->diffInMinutes(\Carbon\Carbon::parse($item->start_regis));
                                echo @$diff == 0 ? '1 Menit' : @$diff . " Menit";
                            } else {
                                echo '5 Menit';
                            }
                        }
                    @endphp 
                </td>
                <td>
                    @php
                          if ($item->start_regis != null && $item->status_panggil != 0) {
                                @$diff = \Carbon\Carbon::parse($item->start_regis)->diffInMinutes(\Carbon\Carbon::parse($item->enter_poli));
                                echo @$diff == 0 ? '1 Menit' : $diff . ' Menit';
                            }
                    @endphp
                </td>
                <td>
                    @php
                        $time       = '08:00:00';
                        $checkin    = date('H:i:s', strtotime($item->checkin));
                        if (\Carbon\Carbon::parse($checkin)->greaterThan(\Carbon\Carbon::parse($time))) {
                            if ($item->checkin != null && $item->eresep != null) {
                                @$diff = @\Carbon\Carbon::parse($item->checkin)->diffInMinutes(\Carbon\Carbon::parse($item->eresep));
                                echo @$diff == 0 ? '1 Menit' : @$diff . ' Menit';
                            }
                            if ($item->checkin != null && $item->cppt != null) {
                                @$diff = @\Carbon\Carbon::parse($item->checkin)->diffInMinutes(\Carbon\Carbon::parse($item->cppt));
                                echo @$diff == 0 ? '1 Menit' : @$diff . ' Menit';
                            }
                            if ($item->checkin != null && $item->asesmen != null) {
                                @$diff = @\Carbon\Carbon::parse($item->checkin)->diffInMinutes(\Carbon\Carbon::parse($item->asesmen));
                                echo @$diff == 0 ? '1 Menit' : @$diff . ' Menit';
                            }
                        } else {
                            if ($item->eresep != null) {
                                @$diff = @\Carbon\Carbon::parse($item->start_regis)->subMinute(5)->diffInMinutes(\Carbon\Carbon::parse($item->eresep));
                                echo @$diff == 0 ? '1 Menit' : @$diff . ' Menit';
                            }
                            if ($item->cppt != null) {
                                @$diff = @\Carbon\Carbon::parse($item->start_regis)->subMinute(5)->diffInMinutes(\Carbon\Carbon::parse($item->cppt));
                                echo @$diff == 0 ? '1 Menit' : @$diff . ' Menit';
                            }
                            if ($item->asesmen != null) {
                                @$diff = @\Carbon\Carbon::parse($item->start_regis)->subMinute(5)->diffInMinutes(\Carbon\Carbon::parse($item->asesmen));
                                echo @$diff == 0 ? '1 Menit' : @$diff . ' Menit';
                            }
                        }
                    @endphp
                </td>
            </tr>
        @endforeach
    </tbody>
</table>