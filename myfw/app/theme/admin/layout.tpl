<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
    <title>[: block page :]Index[: endblock :]</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="description" content="Welcome to my basic template.">
    [[ $this->addCss(array('/public/css/reset.css',
                           '/public/css/reset.css',
                           'css/common.css',
                           'css/plugins.css',
                           'css/main.css'))
    ]]
    [[ $this->addScript(array('/public/js/jquery/jquery.js',
                              '/public/js/jquery/form/validation.js',
                              'js/jquery/jquery.uniform.js',
                              'js/jquery/jquery.chosen.min.js',
                              'js/utility.js',
                              'js/main.js'))
    ]]
</head>

<body>
@$this->inc('@_theme_/common/header')
[: block content :][: endblock :]
</body>
</html>
