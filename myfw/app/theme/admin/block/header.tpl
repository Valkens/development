<header id="header">
    <div class="inner">
        <a class="logo" href="{{$adminUrl}}">Administrator</a>
        <ul class="nav">
            <li><a href="{{$adminUrl}}">Dashboard</a></li>
            <li class="dropdown">
                <a href="[[$this->url('route_admin_category')]]">Categories</a>
            </li>
            <li class="dropdown">
                <a href="[[$this->url('route_admin_post')]]">Posts</a>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)">System <b class="caret"></b></a>
                <ul>
                    <li><a href="[[$this->url('route_admin_system_cache')]]">Caches</a></li>
                    <li><a href="[[$this->url('route_admin_system_log')]]">Logs</a></li>
                    <li><a href="[[$this->url('route_admin_system_setting')]]">Settings</a></li>
                </ul>
            </li>
        </ul>

        <ul class="nav userNav">
            <li><a href="{{$baseUrl}}" target="_blank">Homepage</a></li>
            <li class="dropdown">
                <a href="javascript:void(0)">{{$username}} <b class="caret"></b></a>
                <ul>
                    <li><a href="{{$adminUrl}}/user/profile">Profile</a></li>
                    <li><a href="[[$this->url('route_user_logout')]]">Logout</a></li>
                </ul>
            </li>
        </ul>
    </div>
</header>