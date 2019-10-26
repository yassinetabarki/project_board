@extends('layouts.app')
@section('content')
    <header class="flex items-center  py-4">
        <div class="flex justify-between items-end w-full">
            <p class="font-normal text-gray-500">
                <a href="/projects">My Projects</a>/{{$project->title}}
            </p>
            <div class="flex items-center">
                    @foreach($project->members as $member)
                        <img class="rounded-full w-8 mr-2"
                             src="{{gravatar_email($member->email)}}"
                             alt="{{$member->name}} avatars's">
                    @endforeach
                    <a href="{{$project->path().'/edit'}}"
                    class="bg-blue text-sm text-white font-semibold py-2 px-4 border border-gray-400 rounded-lg shadow"> Edit Project</a>
            </div>

        </div>
    </header>
    <main>
        <div class="flex -mx-3">
            <div class="w-3/4 px-3 mb-6">
               <div class="mb-8">
                   <h2 class="text-gray-500 text-lg mb-3"> Tasks</h2>
                   {{--Tasks--}}
                   @foreach($project->tasks as $task)
                       <div class="card mb-3">
                         <form method="POST" action="{{$project->path().'/tasks/'.$task->id}}">
                           @method('PATCH')
                           @csrf
                               <div class="flex">
                                   <input name="body" class="w-full {{$task->completed ? 'text-gray-500':''}}" value="{{$task->body}}">
                                   <input  name="completed"  type="checkbox" onchange="this.form.submit()"{{$task->completed ?'checked' :''}}>
                               </div>
                        </form>
                       </div>
                    @endforeach
                   <div class="card mb-3">
                       <form method="POST" action="{{$project->path().'/tasks'}}">
                           @csrf
                           <input name="body"  placeholder="Add Task..." class="w-full">
                       </form>
                   </div>
               </div>
                <div>
                    {{--General--}}
                    <h2 class="text-gray-500 text-lg mb-3"> General Notes</h2>
                    <form method="POST" action="{{$project->path()}}">
                        @csrf
                        @method('PATCH')
                        <textarea name="notes" class="card w-full">{{$project->notes}}</textarea>
                        <button  class="bg-blue text-sm text-white font-semibold my-4 py-2 px-5 border border-gray-400 rounded-lg shadow"
                                 type="submit">Add Note</button>
                    </form>
                    @include('projects.errors')
                </div>
            </div>
            <div class="w-1/4 px-3" style="margin-top: 38px">
                @include('projects.card')
                @include('projects.activity.card')
                @can('manage',$project)
                    @include('projects.invite')
                @endcan
            </div>
        </div>
    </main>

@endsection