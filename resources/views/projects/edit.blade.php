@extends('layouts.app')
@section('content')
    <form class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 md:px-16 rounded shadow " action="{{$project->path()}}" method="POST">
        @method('PATCH')
        @include('projects._form', [
            'buttonText'=>'Update Project'
        ])
    </form>
@endsection