[[ $this->inherit('@_theme_/layout') ]]
[: block page :]{{$pageTitle}}[: endblock :]

[: block content :]
<div id="wrapper">
    <div id="sideMenu">
        <ul>
            <li><a href="[[$this->url('route_admin_system_log')]]">Logs</a></li>
            <li><a href="[[$this->url('route_admin_system_setting')]]">Settings</a></li>
        </ul>
    </div>

    <div id="page">
        <h1 id="pageTitle">{{$pageTitle}}</h1>
        <div class="widget fluid">
            <div class="whead">
                <h2>Clear cache</h2>
                <div class="clear"></div>
            </div>
            <div class="wbody">
                @if (isset($error)) :
                    <div class="albox mError">{{$error}}</div>
                @endif
                @if (isset($success)) :
                    <div class="albox mSuccess">{{$success}}</div>
                @endif
                <form id="frmSystemCache" method="post">
                    <div class="formRow">
                        <div class="grid2"><label>Clear cache</label></div>
                        <div class="grid3 noSearch">
                            <select name="type" class="select">
                                @foreach ($caches as $cache) :
                                    @$selected = (isset($type) && $cache['type'] == $type) ? ' selected="selected"' : ''
                                    <option value="{{$cache['type']}}"{{$selected}}>{{$cache['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow rowSubmit">
                        <div class="grid2">&nbsp;</div>
                        <div class="grid4">
                            <input type="submit" class="buttonS bBlue btnAction" name="submit" value="Clear" />
                        </div>
                        <div class="clear"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
[: endblock :]