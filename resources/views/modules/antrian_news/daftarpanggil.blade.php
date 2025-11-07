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
                            <a href="{{ url('antrian-news/'.$bagian.'/'.$no_loket.'/panggil/'.$d->id) }}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-microphone"></i></a>
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
