 <div class="card" style="height: 300px">
        <a href="{{$project->path()}}" class="font-normal text-xl py-2 -m-5 border-l-4 border-blue-light pl-4">{{$project->title}}</a>
        <div class="text-gray-600 pl-4">{{str_limit($project->description)}}</div>
 </div>