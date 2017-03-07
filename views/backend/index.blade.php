@extends('backend.layouts.main')
@section('content')
    <div id="file-manage-tools" class="hidden">
        <div class="dataTables_toolbar">
            {!! Html::linkButton('#', trans('common.all'), ['class'=>'filter-clear', 'type'=>'warning', 'size'=>'xs', 'icon' => 'list']) !!}
        </div>
    </div>
    @include("file::backend._upload_form")
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
        var oTable = $('#file-manage');
    </script>

    @include('file::backend._upload_script')

    <script type="text/javascript">
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