[[ $this->inherit('../Layout/default/layout') ]]
[: block page :]List user[: endblock :]
[: block contents :]
    @foreach ($users as $user):
    <p>{{$user->name}}</p>
    @endforeach
[: endblock :]