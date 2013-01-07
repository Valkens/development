[[ $this->inherit('@_theme_/layout') ]]
[: block page :]{{$pageTitle}}[: endblock :]

[: block content :]
<div id="wrapper">
    <div id="sideMenu">
        <ul>
            <li><a href="#">General</a></li>
            <li><a href="#">Price</a></li>
            <li><a href="#">Meta infomation</a></li>
        </ul>
    </div>

    <div id="page">
        <h5 id="pageTitle">
            Thêm sản phẩm mới
            <a href="#" class="buttonS bDefault addLink">Xoa</a>
            <a href="#" class="buttonS bDefault addLink mr5">Them</a>
        </h5>

        <div class="widget fluid">
            <div class="whead">
                <h6>Form input</h6>
                <div class="clear"></div>
            </div>

            <div class="wbody">
                <form id="formAdd">
                    <div class="formRow">
                        <div class="grid3"><label>Usual input field <span class="required">*</span>:</label></div>
                        <div class="grid9"><input type="text" name="regular"></div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <div class="grid3"><label>Place holder:</label></div>
                        <div class="grid9"><input type="text" name="regular" placeholder="Place holder"></div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <div class="grid3"><label>Disabled field:</label></div>
                        <div class="grid9"><input type="text" name="regular"></div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <div class="grid3"><label>Text area:</label></div>
                        <div class="grid9"><textarea rows="8" cols="" name="textarea" class="auto"></textarea></div>
                        <div class="clear"></div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
[: endblock :]