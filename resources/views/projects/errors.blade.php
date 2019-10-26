@if($errors->{$bag ?? 'default'}->any())
    <div class="field m-3">
        @foreach($errors->{$bag ?? 'default'}->all() as $error)
            <li class="text-sm text-red-600"> {{$error}}</li>
        @endforeach
    </div>
@endif