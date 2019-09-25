@extends('layouts.app')
@section('content')
    <header class="flex items-center  py-4">
        <div class="flex justify-between items-end w-full">
            <h2 class="font-normal text-gray-500"> My Projects </h2>
            <a href="/projects/create" class="bg-blue text-sm text-white font-semibold py-2 px-4 border border-gray-400 rounded-lg shadow"> New Project</a>
        </div>
    </header>
<div class="lg:flex flex-wrap -mx-3">
    @forelse($projects as $project)
        <div class="lg:w-1/3 px-3 pb-6">
           @include('projects.card')
        </div>
    @empty
        <h1>No project yet</h1>
    @endforelse

</div>
@endsection