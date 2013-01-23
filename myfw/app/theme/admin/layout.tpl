<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
    <title>[: block page :]Index[: endblock :]</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="description" content="Welcome to my basic template.">
    [[ $this->addCss(array('/public/css/reset.css',
                            'css/plugins.less',
                            'css/common.less',
                            'css/main.less'))
    ]]
</head>

<body>
@$this->inc('@_theme_/common/header')
[: block content :][: endblock :]
<script type="text/javascript">
    var BASE_URL = '{{$baseUrl}}';
    var ADMIN_URL = '{{$adminUrl}}';
</script>
[[ $this->addScript(array('/public/js/jquery/jquery.js',
                          '/public/js/jquery/form/validation.js',
                          'js/jquery/jquery.uniform.js',
                          'js/jquery/jquery.chosen.min.js',
                          'js/utility.js',
                          'js/main.js'))
]]

[: block script :][: endblock :]
</body>
</html>
