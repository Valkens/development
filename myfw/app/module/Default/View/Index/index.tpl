[[ $this->inherit('@_layout_/default/layout') ]]
[: block page :]{{$pageTitle}}[: endblock :]
[: block contents :]
    @foreach ($users as $user):
    <p>{{$user->name}}</p>
    @endforeach
[: endblock :]