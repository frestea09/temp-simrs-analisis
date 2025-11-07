<div class='table-responsive'>
  <table class='table table-striped table-bordered table-hover table-condensed' id='dataICD'>
    <thead>
      <tr>
        <th>Nomor</th>
        <th>Nama</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($icd10 as $key => $d)
        <tr class="pilih" data-icd10="{{ $d->nama }}">
          <td>{{ $d->nomor }}</td>
          <td>{{ $d->nama }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

<!-- DataTables -->
<script src="{{ asset('style') }}/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('style') }}/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
  $(function () {
    $('#dataICD').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    });
  });

</script>
