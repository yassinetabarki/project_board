<div class="card mt-3 text-sm">
    <ul>
        @foreach($project->activity->slice(0,5) as $activity)
            <li class="{{$loop->last ? '':'mb-1'}}">
                @include("projects.activity.{$activity->description}")
                <span class="text-gray-500">{{$activity->created_at->diffForHumans(null,true)}}</span>
            </li>
        @endforeach
    </ul>
</div>