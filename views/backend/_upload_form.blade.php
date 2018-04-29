<div class="ibox" style="display: none">
    <div class="ibox-title"><h5></h5></div>
    <div class="ibox-content">
        {!! Form::open(['id' => 'form-file', 'files' => true]) !!}
        {!! Form::hidden('tmp', isset($tmp) ? $tmp : 0) !!}
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::text("title", null, [
                    'class' => 'form-control input-sm',
                    'data-error' => __('Title is empty'),
                    'placeholder' => __('Title').'...'
                    ]) !!}
                    <p class="help-block with-errors"></p>
                </div>

                <div class="form-group">
                    {!! Form::file("name", [
                    'class' => 'form-control filestyle',
                    'data-error' => __('No file selected'),
                    'data-buttonText' => ' '.__('Select file...'),
                    'data-buttonName'=>"btn-white",
                    'data-size'=>"sm"
                    ]) !!}
                    <p class="help-block with-errors"></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-sm" style="margin-right: 5px">
                        <i class="fa fa-cloud-upload"></i> {{__('Upload')}}
                    </button>
                    <button type="reset" class="btn btn-sm btn-white cancel">
                        <i class="fa fa-close"></i> {{__('Cancel')}}
                    </button>
                    <div class="progress progress-small" style="display: none">
                        <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0"
                             aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                            <span class="sr-only">0%</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>