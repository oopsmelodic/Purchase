<input id="input-1" multiple type="file" class="file file-loading" data-allowed-file-extensions='["txt","jpg","tif","doc","pdf"]'>

<script>

    $("#input-1").fileinput({
        uploadUrl: "/php/upload.php", // server upload action
        uploadAsync: true,
        maxFileCount: 5
    });

</script>