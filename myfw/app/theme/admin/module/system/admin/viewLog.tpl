[[ $this->inherit('@_theme_/layout') ]]

[: block pageTitle :]System logs[: endblock :]

[: block content :]
<div id="wrapper">
    <div id="sideMenu">
        <ul>
            <li><a href="[[$this->url('route_admin_system_cache')]]">Caches</a></li>
            <li><a href="[[$this->url('route_admin_system_setting')]]">Settings</a></li>
        </ul>
    </div>

    <div id="page">
        <h1 id="pageTitle">System logs</h1>
        <div class="widget fluid">
            <div class="whead">
                <h2>View logs</h2>
                <div class="clear"></div>
            </div>
            <div class="wbody">
                <form id="frmSystemLogs" method="post">
                    <div class="formRow">
                        <div class="grid2"><label>Error logs</label></div>
                        <div class="grid10"><textarea rows="30"><?php echo $errorLogs;?></textarea></div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow rowSubmit">
                        <div class="grid2">&nbsp;</div>
                        <div class="grid4">
                            <input type="submit" class="buttonS bBlue btnAction" name="submit" value="Clear logs" />
                        </div>
                        <div class="clear"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
[: endblock :]