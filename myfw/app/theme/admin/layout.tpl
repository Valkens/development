<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <title>{{$pageTitle}}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="description" content="Welcome to my basic template.">
    @$this->inc('@_theme_/block/css')
</head>

<body>
@$this->inc('@_theme_/block/header')

[: block content :][: endblock :]

@$this->inc('@_theme_/block/javascript')

[: block script :][: endblock :]
</body>
</html>
