<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
    <title>[: block page :]Index[: endblock :]</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="description" content="Welcome to my basic template.">
    [[ $this->addCss(array('/public/css/reset.css',
                           '/public/css/style.css',
                           'css/common.css',
                           'css/post.css'))
    ]]
</head>

<body>
<div id="wrapper">
    <header id="header">
        <div class="wrapper">
            <nav>
                <ul>
                    <li><a rel="external" href="#" class="active">Home</a></li>
                    <li><a rel="external" href="#">About us</a></li>
                    <li><a rel="external" href="#">Contacts</a></li>
                </ul>
            </nav>
        </div>
    </header>

    [: block content :][: endblock :]
        [[ $this->addScript(array('/public/js/jquery/jquery.js',
                                  '/public/js/jquery/jquery.elastic/jquery.elastic.source.js',
                                  'js/main.js'))
    ]]

    <footer id="footer">
        <div class="wrapper">
            <div class="center">
                <div class="info">
                    <div class="readers">
                        <span class="count">11,773,943</span> Readers Per Month
                    </div>
                    <blockquote>
                        <em>Mobile Nations</em> brings you the very best of
                        <a href="http://androidcentral.com">Android Central</a>,
                        <br />
                        <a href="http://crackberry.com">CrackBerry</a>,
                        <a href="http://imore.com">iMore</a>,
                        <a href="http://webosnation.com">webOS Nation</a>, and <a href="http://wpcentral.com">WPCentral</a>
                    </blockquote>
                </div>
            </div>
        </div>
    </footer>
</div>

</body>
</html>
