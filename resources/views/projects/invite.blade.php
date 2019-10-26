<ul class="card mt-3">
    <h3 class="font-normal text-xl py-2 -m-5 mb-6 border-l-4 border-blue-light pl-4">
        Invite a User
    </h3>
    <form method="POST" action="{{$project->path().'/invitations'}}" class="text-right">
        @csrf
        <input name="email" type="email" class="border border-gray-500 rounded w-full py-2" placeholder="Email Address" required>

        <button type="submit" class="bg-blue text-sm text-white font-semibold mt-1 py-2 px-4 border border-gray-400 rounded-lg shadow">
            Invite
        </button>
    </form>
    @include('projects.errors',['bag'=>'invitations'])
</ul>