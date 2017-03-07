<script type="text/javascript">
    var
            form = $('#form-file'),
            ibox = form.closest('.ibox'),
            ibox_title = ibox.find('h5'),
            progress = $('.progress'),
            progress_bar = $('.progress_bar'),
            percent = progress.find('.sr-only'),
            input_title = form.find('input[name="title"]'),
            input_name = form.find('input[name="name"]'),
            url_store = '{{route('backend.file.store')}}',
            url_update = '{{route('backend.file.update', ['file' => '__ID__'])}}';
    function showForm(element) {
        if ($(element).is('.add-new')) {
            // create
            ibox_title.html('{{trans('file::common.add_new')}}');
            input_title.prop('required', true).closest('.form-group').show();
            input_name.prop('required', true);
            form.attr('action', url_store);
        } else {
            // Update
            ibox_title.html('{{trans('file::common.replace')}}: ' + $(element).closest('tr').find('.file-title a').text());
            input_title.prop('required', false).closest('.form-group').hide();
            input_name.prop('required', true);
            form.attr('action', url_update.replace('__ID__', $(element).data('id')));
        }
        form.validator();
        ibox.show();
    }
    $(document).ready(function () {
        $('.add-new').click(function (e) {
            e.preventDefault();
            showForm(this);
        });
        form.find('.cancel').click(function (e) {
            form.validator('destroy');
            ibox.hide();
        });

        var options = {
            beforeSend: function () {
                progress_bar.width('0%');
                percent.html("0%");
            },
            uploadProgress: function (event, position, total, percentComplete) {
                progress_bar.width(percentComplete + '%');
                percent.html(percentComplete + '%');
            },
            success: function () {

            },
            complete: function (response) {
                if (response.status == 200) {
                    if (response.responseJSON != undefined) {
                        var data = response.responseJSON;
                        $.fn.mbHelpers.showMessage(data.type, data.content);
                        if (data.type == 'success') {
                            if (oTable != undefined) {
                                oTable.dataTable().fnReloadAjax();
                            }
                            form.closest('.ibox').hide();
                        }
                    } else {
                        $.fn.mbHelpers.showMessage('error', '{{trans('file::error.unable_upload')}}');
                    }
                }
            },
            error: function () {
                $.fn.mbHelpers.showMessage('error', '{{trans('file::error.unable_upload')}}');
            }
        };

        form.ajaxForm(options);

    });
</script>