@extends('layouts.app')
@section('content')
<form class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 md:px-16 rounded shadow " action="/projects" method="POST">
  @include('projects._form', [
        'project'=>new App\Project,
        'buttonText'=>'Create Project'
  ])
</form>
@endsection