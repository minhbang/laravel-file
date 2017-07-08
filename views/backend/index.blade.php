@extends('kit::backend.layouts.master')
@section('content')
    @include("file::backend._upload_form")
    <div class="ibox ibox-table">
        <div class="ibox-title">
            <h5>{!! trans('file::common.list') !!}</h5>
            <div class="buttons">
                {!! Html::linkButton('#', trans('common.filter'), ['class'=>'advanced_filter_collapse','type'=>'info', 'size'=>'xs', 'icon' => 'filter']) !!}
                {!! Html::linkButton('#', trans('common.all'), ['class'=>'advanced_filter_clear', 'type'=>'warning', 'size'=>'xs', 'icon' => 'list']) !!}
                {!! Html::linkButton('#', trans('file::common.add_new'), ['class'=>'add-new', 'type'=>'primary', 'size'=>'xs', 'icon' => 'upload']) !!}
            </div>
        </div>
        <div class="ibox-content">
            <div class="bg-warning dataTables_advanced_filter hidden">
                <form class="form-horizontal" role="form">
                    {!! Form::hidden('filter_form', 1) !!}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('filter_created_at', trans('common.created_at'), ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-9">
                                    {!! Form::daterange('filter_created_at', [], ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('filter_updated_at', trans('common.updated_at'), ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-9">
                                    {!! Form::daterange('filter_updated_at', [], ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            {!! $html->table(['id' => 'file-manage']) !!}
        </div>
    </div>
@endsection

@push('scripts')
<script type="text/javascript">
    window.datatableDrawCallback = function (dataTableApi) {
        dataTableApi.$('a.quick-update').quickUpdate({
            'url': '{{ route('backend.file.quick_update', ['file' => '__ID__']) }}',
            'container': '#file-manage',
            'dataTableApi': dataTableApi
        });
        dataTableApi.$('a.replace').click(function (e) {
            e.preventDefault();
            $('#form-file').ajaxFileUpload().showReplace(this);
        });
    };
    window.settings.mbDatatables = {
        trans: {
            name: '{{trans('file::common.file')}}'
        }
    }
</script>
{!! $html->scripts() !!}
<script type="text/javascript">
    $('#form-file').ajaxFileUpload({
        url_store: '{{route('backend.file.store')}}',
        url_update: '{{route('backend.file.update', ['file' => '__ID__'])}}',
        datatableApi: window.LaravelDataTables['file-manage'],
        trans: {
            add_new: "{{trans('file::common.add_new')}}",
            replace: "{{trans('file::common.replace')}}",
            ajax_upload: "{{trans('file::error.ajax_upload')}}",
            unable_upload: "{{trans('file::error.unable_upload')}}"
        }
    });
</script>
@endpush