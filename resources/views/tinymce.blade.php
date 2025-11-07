<script type="text/javascript" src="{{ URL::asset('tinymce/tinymce.min.js') }}"></script>
<script type="text/javascript">
tinymce.init({
    selector: "textarea",
    plugins: [
        "advlist autolink lists link responsivefilemanager charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste image responsivefilemanager"
    ],

    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | responsivefilemanager",
    // external_filemanager_path:"/filemanager/",
    // filemanager_title:"Responsive Filemanager" ,
    // external_plugins: { "filemanager" : "/filemanager/plugin.min.js"}
});
</script>
