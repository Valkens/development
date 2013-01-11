[[ $this->inherit('@_theme_/layout') ]]
[: block page :]{{$pageTitle}}[: endblock :]

[: block content :]
<div id="wrapper">
    <div id="sideMenu">
        <ul>
            <li><a href="{{$adminUrl}}/category">List</a></li>
        </ul>
    </div>

    <div id="page">
        <h1 id="pageTitle">Add new category</h1>

        <div class="widget fluid">
            <div class="whead">
                <h2>Category's information</h2>
                <div class="clear"></div>
            </div>

            <div class="wbody">
                <form id="formAdd" method="post">
                    <div class="formRow">
                        <div class="grid3"><span class="required fleft">*</span><label>Parent</label></div>
                        <div class="grid4">
                            <select name="parent">
                                <option value="-1">Select...</option>
                                <option value="1">Cate 1</option>
                                <option value="2">Cate 2</option>
                            </select>
                        </div>
                        @if (isset($errors['parent'])) :
                            <div class="clear"></div>
                            <div class="grid3">&nbsp;</div>
                            <div class="stError">{{$errors['parent']}}</div>
                        @endif
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <div class="grid3"><span class="required fleft">*</span><label>Name</label></div>
                        <div class="grid4"><input type="text" name="name" maxlength="100" /></div>
                        @if (isset($errors['name'])) :
                        <div class="clear"></div>
                        <div class="grid3">&nbsp;</div>
                        <div class="stError">{{$errors['name']}}</div>
                        @endif
                        <div class="clear"></div>
                    </div>
                    <div class="formRow rowSubmit">
                        <div class="grid3">&nbsp;</div>
                        <div class="grid4">
                            <input type="submit" class="buttonS bLightBlue" name="submit" value="Submit" />
                        </div>
                        <div class="clear"></div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
[: endblock :]