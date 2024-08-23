<script>
    $(document).on('change', 'select[name=type]', function () {
        $.ajax({
            url: '{{ route("order.clients", $shop->keyword) }}',
            type: 'GET',
            data: {type: $(this).val()},
            contentType: false,
            success: function (success) {
                const option = success.map((client) => `<option value="${client.id}">${client.fio}</option>`);
                $('select[name=type]').html(option).select2();
            },
            error: function (success) {
                /*This error responsive*/
            },
            cache: false,

            xhr: function () {
                myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) {
                    return myXhr;
                }
            }
        });
    });

</script>
