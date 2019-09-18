@extends('layouts.app')

@section('content')
    <div id="crud-app">
        <section class="content-header">
            <h1 class="pull-left">$MODEL_NAME_PLURAL$</h1>
            <h1 class="pull-right">
               <a class="btn btn-primary pull-right" href="#" style="margin-top: -10px;margin-bottom: 5px" @click="modal('POST')">Add New</a>
            </h1>
        </section>
        <div class="content" style="padding-top: 30px;">
            <div class="box box-primary">
                <div class="box-body">
                    @include('$VIEW_PREFIX$$MODEL_NAME_PLURAL_CAMEL$.table')
                </div>
            </div>
        </div>
        <!-- --------- Modals ---------- -->
        @include('$VIEW_PREFIX$$MODEL_NAME_PLURAL_CAMEL$.form')
        @include('$VIEW_PREFIX$$MODEL_NAME_PLURAL_CAMEL$.delete')
        @include('$VIEW_PREFIX$$MODEL_NAME_PLURAL_CAMEL$.show')
        @include('layouts.modal.info')        
    </div>
@endsection

@push('vue-scripts')  
    <script src="/app/js/models/$MODEL_NAME_CAMEL$-config.js"></script>
    <script>
        var token = '{{ csrf_token() }}';
        var fieldInitOrder = 'id';
        var apiUrl = { 
            show:  "{{ route('$API_PREFIX$.$API_VERSION$.$VIEW_PREFIX$$MODEL_NAME_PLURAL_CAMEL$.show') }}/",
            index: "{{ route('$API_PREFIX$.$API_VERSION$.$VIEW_PREFIX$$MODEL_NAME_PLURAL_CAMEL$.index') }}",  
            store: "{{ route('$API_PREFIX$.$API_VERSION$.$VIEW_PREFIX$$MODEL_NAME_PLURAL_CAMEL$.store') }}",  
            update: "{{ route('$API_PREFIX$.$API_VERSION$.$VIEW_PREFIX$$MODEL_NAME_PLURAL_CAMEL$.update') }}/",  
            delete: "{{ route('$API_PREFIX$.$API_VERSION$.$VIEW_PREFIX$$MODEL_NAME_PLURAL_CAMEL$.delete') }}/"
        };
    </script>
    <script src="/app/js/crud.js"></script>    
@endpush

@push('vue-styles')
    <link rel="stylesheet" href="/app/css/vue-styles.css">
@endpush



                                                                                                                                                                                                                                                                                                                                                                                                      