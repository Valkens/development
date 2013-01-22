<header id="header">
    <div class="inner">
        <a class="logo" href="#">Administrator</a>
        <ul class="nav">
            <li><a href="#">Dashboard</a></li>
            <li class="dropdown">
                <a href="{{$adminUrl}}/category">Category</a>
            </li>
            <li class="dropdown">
                <a href="{{$adminUrl}}/post">Post</a>
            </li>
        </ul>

        <ul class="nav userNav">
            <li><a href="#">Trang chủ</a></li>
            <li class="dropdown">
                <a href="#">Đức <b class="caret"></b></a>
                <ul>
                    <li><a href="#">Tài khoản</a></li>
                    <li><a href="{{$adminUrl}}/logout">Thoát</a></li>
                </ul>
            </li>
        </ul>
    </div>
</header>