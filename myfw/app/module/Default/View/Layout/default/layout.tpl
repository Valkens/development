<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <title>[: block page :]Index[: endblock :]</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    [[ $this->addCss(array('public/css/reset.css', 'public/css/style.css', 'public/css/post.css')) ]]
</head>
<body>
[: block content :][: endblock :]
[[ $this->addScript(array('public/js/jquery/jquery.js',
                    'public/js/jquery/jquery.elastic/jquery.elastic.source.js',
                    'public/js/main.js'))
]]
</body>
</html>