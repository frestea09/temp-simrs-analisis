@if (count(@$result) == '0')
    <h5 class="text-center">Pasien ini tidak ada data exam dari RIS</h5>
@else
    @if (count(@$result) > 0)
        <table class="table table-bordered table-striped">
            <tr>
                <td>NO</td>
                <td>Assesmen ID</td>
                <td>Modality ID</td>
                <td>Tanggal</td>
                {{-- <td>attendingdoctorid</td> --}}
                <td>Image</td>
                <td>Ekspertise</td>
            </tr>
            @foreach (@$result as $key=>$item)
            @php
                $ris = json_decode($item->response,true)['response']['examlist'];
            @endphp
                @foreach ($ris as $items)
                
                    <tr>
                        <td>{{@$key+1}}</td>
                        <td>{{@$items['assessementid']}}</td>
                        <td>{{@$items['modalityid']}}</td>
                        <td>{{ \Carbon\Carbon::parse(@$items['examdate'])->format('d-m-Y') }}</td>
                        {{-- <td>{{@$items['attendingdoctorid']}}</td> --}}
                        <td><a target="_blank" href="{{url('/ris/getexamwaitingreport/'.$no_rm.'/'.@$items['assessementid'])}}">Lihat Image</a></td>
                        {{-- <td><a target="_blank" href="{{@$items['imageurl']}}">Lihat Image</a></td> --}}
                        {{-- <td><a target="_blank" href="{{@base64_decode($item->expertisefile)}}">Lihat Ekspertise</a></td> --}}
                        {{-- <td><a target="_blank" href="{{url('ris/getPdf/'.@$items['mrid']).'/'.@$items['assessementid']}}">Lihat Ekspertise</a></td> --}}
                        <td><a target="_blank" href="{{url('/ris/getpdfreport/'.$no_rm.'/'.@$items['assessementid'])}}">Lihat Ekspertise</a></td>
                    </tr>
                    
                @endforeach
            @endforeach
        </table>
        
    @endif
    {{-- <h5>Hasil RIS</h5> --}}
@endif