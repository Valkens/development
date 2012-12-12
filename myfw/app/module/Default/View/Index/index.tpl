[[ $this->inherit('@_layout_/default/layout') ]]
[: block page :]{{$pageTitle}}[: endblock :]

[: block content :]
[[ echo count($images) ]]
@foreach ($images as $image):
  <p><img src="{{$image}}" /></p>
@endforeach

[: endblock :]