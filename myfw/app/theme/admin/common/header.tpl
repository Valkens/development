<header id="header">
    <div class="inner">
        <a class="logo" href="{{$adminUrl}}">Administrator</a>
        <ul class="nav">
            <li><a href="{{$adminUrl}}">Dashboard</a></li>
            <li class="dropdown">
                <a href="{{$adminUrl}}/category">Category</a>
            </li>
            <li class="dropdown">
                <a href="{{$adminUrl}}/post">Post</a>
            </li>
        </ul>

        <ul class="nav userNav">
            <li><a href="{{$baseUrl}}" target="_blank">Homepage</a></li>
            <li class="dropdown">
                <a href="javascript:void(0)">Đức <b class="caret"></b></a>
                <ul>
                    <li><a href="{{$adminUrl}}/user/profile">Tài khoản</a></li>
                    <li><a href="{{$adminUrl}}/logout">Thoát</a></li>
                </ul>
            </li>
        </ul>
    </div>
</header>