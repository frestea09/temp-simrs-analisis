            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Antrian</h3>
              </div>
              <div class="panel-body">
                <div class='table-responsive' style="min-height: 50%">
                  <table class='table table-striped table-bordered table-hover table-condensed'>
                    <thead>
                      <tr>
                        <th class="text-center">Antrian</th>
                        <th>Waktu Antri</th>
                        <th class="text-center">Panggil</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($antrian as $key => $d)
                        <tr>
                          <td class="text-center">{{ $d->nomor }}</td>
                          <td>{{ $d->created_at }}</td>
                          <td class="text-center">
                            <div class="btn-group">
                              <a href="{{ route('antrian5.panggil',$d->id) }}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-microphone"></i></a>
                              {{-- <a href="{{ route('antrian2.panggil',$d->id) }}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-microphone"></i></a> --}}
                              <button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                              </button>
                              <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                                @for ($i = 1; $i <= 6; $i++)
                                  <li><a href="{{ route('antrian.panggil-beda',[$d->id,$i]) }}">Loket {{$i}}</a></li>
                                    
                                @endfor
                              </ul>
                              </div>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="panel-footer">

              </div>
            </div>
          </div>
          {{-- ============================ --}}
