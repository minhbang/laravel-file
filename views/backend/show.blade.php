@extends('kit::backend.layouts.modal')
@section('content')
    <h3>{{__('Attributes')}}</h3>
    <table class="table table-hover table-striped table-bordered table-detail">
        @foreach($file->getAttributeNames() as $attribute)
            <tr>
                <td>{{ $attribute }}</td>
                <td>{{ $file->{$attribute} }}</td>
            </tr>
        @endforeach
    </table>
    <h3>{{__('More informations')}}</h3>
    <table class="table table-hover table-striped table-bordered table-detail">
        <tr>
            <td>Path</td>
            <td>{{$file->path}}</td>
        </tr>
    </table>
@stop