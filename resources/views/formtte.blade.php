<form action="/form/tte" method="POST" enctype="multipart/form-data">
    {!! csrf_field() !!}
    <input type="hidden" name="passphrase" value="F@hmi1984">
    <input type="hidden" name="nik" value="3204130801840002">
    <input type="hidden" name="jenis_response" value="BASE64">
    <input type="hidden" name="tampilan" value="invisible">
    <input type="file" name="file">
    <input type="submit" value="send">
</form>