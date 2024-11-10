@extends('Backend.dashboard.layout')

@section('content') 
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            {{ Breadcrumbs::render() }}
        </div>
    </div>
@endsection