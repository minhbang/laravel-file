@extends('backend.layouts.main')
@section('content')
    <div id="file-manage-tools" class="hidden">
        <div class="dataTables_toolbar">
            {!! Html::linkButton('#', trans('common.all'), ['class'=>'filter-clear', 'type'=>'warning', 'size'=>'xs', 'icon' => 'list']) !!}
        </div>
    </div>
    <div class="ibox" style="display: none">
        <div class="ibox-title"><h5></h5></div>
        <div class="ibox-content">
            {!! Form::open(['id' => 'form-file', 'files' => true]) !!}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::text("title", null, [
                            'class' => 'form-control input-sm',
                            'data-error' => trans('file::error.empty_title'),
                            'placeholder' => trans('file::common.title').'...'
                        ]) !!}
                        <p class="help-block with-errors"></p>
                    </div>
                    <div class="form-group">
                        {!! Form::file("name", [
                            'class' => 'form-control filestyle',
                            'data-error' => trans('file::error.empty_file'),
                            'data-buttonText' => trans('file::common.select_file'),
                            'data-buttonName'=>"btn-white",
                            'data-size'=>"sm"
                        ]) !!}
                        <p class="help-block with-errors"></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-sm" style="margin-right: 5px">
                            <i class="fa fa-cloud-upload"></i> {{trans('file::common.upload')}}
                        </button>
                        <button type="reset" class="btn btn-sm btn-white cancel">
                            <i class="fa fa-close"></i> {{trans('common.cancel')}}
                        </button>
                    </div>
                    <div class="progress progress-small">
                        <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0"
                             aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                            <span class="sr-only">0%</span>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <div class="ibox ibox-table">
        <div class="ibox-title">
            <h5>{!! trans('file::common.list') !!}</h5>
        </div>
        <div class="ibox-content">
            {!! $table->render('_datatable') !!}
        </div>
    </div>
@stop

@section('script')
    <script type="text/javascript">
        var
                form = $('#form-file'),
                ibox = form.closest('.ibox'),
                ibox_title = ibox.find('h5'),
                progress = $('.progress'),
                progress_bar = $('.progress_bar'),
                percent = progress.find('.sr-only'),
                oTable = $('#file-manage'),
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
                                oTable.dataTable().fnReloadAjax();
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

        function datatableDrawCallback(oTable) {
            oTable.find('a.quick-update').quickUpdate({
                url: '{{ route('backend.file.quick_update', ['file' => '__ID__']) }}',
                container: '#file-manage',
                dataTable: oTable
            });
            oTable.find('a.replace').click(function (e) {
                e.preventDefault();
                showForm(this);
            });
        }
    </script>
    @include(
        '_datatable_script',
        [
            'name' => trans('file::common.file'),
            'data_url' => route('backend.file.data'),
            'drawCallback' => 'window.datatableDrawCallback'
        ]
    )
@stop