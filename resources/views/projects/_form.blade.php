 @csrf
        <h1 class="text-2xl font-normal mb-10 text-center" >edit my Project</h1>

        <div class="field mb-6">
            <label class="text-lg mb-2 block" for="title" class="lable">Title</label>
            <div class="control">
                <input
                        class="bg-transparent border border-gray-400 rounded p-2 text w-full"
                        type="text"
                        name="title"
                        placeholder="My next project.."
                        value="{{$project->title}}">
            </div>
        </div>

        <div class="field mb-6">
            <label class="text-lg mb-2 block" for="description">Description</label>
            <div class="control">
                <textarea  class="bg-transparent border border-gray-400 rounded p-2 h-48 text w-full"
                           id="description"
                           name="description"
                           class="textarea"
                           placeholder="Add you description for the project :)">{{$project->description}}</textarea>
            </div>
        </div>
        <div class="field">
            <div class="control">
                <button class="bg-blue text-sm text-white font-semibold my-4 py-2 px-5 border border-gray-400 rounded-lg shadow"
                        type="submit">{{$buttonText}}</button>
                <a class="md:m-3" href="{{$project->path()}}"> Cancle</a>
            </div>
            @if($errors->any())
                <div class="field m-3">
                        @foreach($errors->all() as $error)
                            <li class="text-sm text-red-600"> {{$error}}</li>
                        @endforeach
                </div>
            @endif
        </div>