[[ $this->inherit('@_theme_/layout') ]]\

[: block pageTitle :]System settings[: endblock :]

[: block content :]
<div id="wrapper">
    <div id="sideMenu">
        <ul>
            <li><a href="[[$this->url('route_admin_system_cache')]]">Caches</a></li>
            <li><a href="[[$this->url('route_admin_system_log')]]">Logs</a></li>
        </ul>
    </div>

    <div id="page">
        <h1 id="pageTitle">System settings</h1>
        <div class="widget fluid">
            <div class="whead">
                <h2>Settings</h2>
                <div class="clear"></div>
            </div>
            <div class="wbody">
                @if (isset($success)) :
                    <div class="albox mSuccess">{{$success}}</div>
                @endif
                <form id="frmSystemSetting" method="post">
                    <fieldset>
                        <legend>General</legend>
                        <div class="formRow">
                            <div class="grid2"><label>Site title</label></div>
                            <div class="grid6">
                                <input type="text" class="required" name="site_title" value="{{$options['site_title']}}" />
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="formRow">
                            <div class="grid2"><label>Site email</label></div>
                            <div class="grid4">
                                <input type="text" class="required" name="site_email" value="{{$options['site_email']}}" />
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="formRow">
                            <div class="grid2"><label>Date format</label></div>
                            <div class="grid3">
                                <input type="text" class="required" name="date_format" value="{{$options['date_format']}}" />
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="formRow">
                            <div class="grid2"><label>Time format</label></div>
                            <div class="grid3">
                                <input type="text" class="required" name="time_format" value="{{$options['time_format']}}" />
                            </div>
                            <div class="clear"></div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>Post</legend>
                        <div class="formRow">
                            <div class="grid2"><label>E-mail me whenever</label></div>
                            <div class="grid3">
                                @$checked = ($options['comment_notify_email']) ? ' checked=checked' : ''
                                <input type="checkbox" class="check" name="comment_notify_email"{{$checked}} />
                                <label>Anyone posts a comment</label>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="formRow">
                            <div class="grid2"><label>Comment black list</label></div>
                            <div class="grid7">
                                <textarea name="comment_black_list" rows="5" cols="40">{{$options['comment_black_list']}}</textarea>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="formRow">
                            <div class="grid2"><label>Thumbnail size</label></div>
                            <div class="grid2">
                                <label>Width </label>
                                <input id="image_thumbnail_size_w" class="required" type="text" name="image_thumbnail_size_w" value="{{$options['image_thumbnail_size_w']}}" />
                                <label>Height </label>
                                <input id="image_thumbnail_size_h" class="required" type="text" name="image_thumbnail_size_h" value="{{$options['image_thumbnail_size_h']}}" />
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="formRow">
                            <div class="grid2"><label>Medium size</label></div>
                            <div class="grid2">
                                <label>Width </label>
                                <input id="image_medium_size_w" class="required" type="text" name="image_medium_size_w" value="{{$options['image_medium_size_w']}}" />
                                <label>Height </label>
                                <input id="image_medium_size_h" class="required" type="text" name="image_medium_size_h" value="{{$options['image_medium_size_h']}}" />
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="formRow">
                            <div class="grid2"><label>Large size</label></div>
                            <div class="grid2">
                                <label>Width </label>
                                <input id="image_large_size_w" class="required" type="text" name="image_large_size_w" value="{{$options['image_large_size_w']}}" />
                                <label>Height </label>
                                <input id="image_large_size_h" class="required" type="text" name="image_large_size_h" value="{{$options['image_large_size_h']}}" />
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="clear"></div>
                    </fieldset>

                    <fieldset>
                        <legend>Mail server</legend>
                        <div class="formRow">
                            <div class="grid2"><label>Server name</label></div>
                            <div class="grid4">
                                <input type="text"  class="required" name="mail_server_name" value="{{$options['mail_server_name']}}" />
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="formRow">
                            <div class="grid2"><label>Port</label></div>
                            <div class="grid2">
                                <input id="mail_server_port" class="required" type="text" name="mail_server_port" value="{{$options['mail_server_port']}}" />
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="formRow">
                            <div class="grid2"><label>Login</label></div>
                            <div class="grid4">
                                <input type="text"  class="required" name="mail_server_login" value="{{$options['mail_server_login']}}" />
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="formRow">
                            <div class="grid2"><label>Password</label></div>
                            <div class="grid4">
                                <input type="text"  class="required" name="mail_server_password" value="{{$options['mail_server_password']}}" />
                            </div>
                            <div class="clear"></div>
                        </div>
                    </fieldset>
                    
                    <div class="formRow rowSubmit">
                        <div class="grid2">&nbsp;</div>
                        <div class="grid4">
                            <input type="submit" class="buttonS bBlue btnAction" value="Update" />
                        </div>
                        <div class="clear"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
[: endblock :]

[: block script :]
<script type="text/javascript">
    $(function(){
        $('#frmSystemSetting').validate({
            rules: {
                mail_server_port: {
                    digits: true,
                    maxlength: 3
                },
                image_thumbnail_size_w : {
                    digits: true,
                    maxlength: 4
                },
                image_thumbnail_size_h : {
                    digits: true,
                    maxlength: 4
                },
                image_medium_size_w : {
                    digits: true,
                    maxlength: 4
                },
                image_medium_size_h : {
                    digits: true,
                    maxlength: 4
                },
                image_large_size_w : {
                    digits: true,
                    maxlength: 4
                },
                image_large_size_h : {
                    digits: true,
                    maxlength: 4
                },
            }
        });
    });
</script>
[: endblock :]