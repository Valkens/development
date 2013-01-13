[[ $this->inherit('@_theme_/layout') ]]
[: block page :]{{$pageTitle}}[: endblock :]

[: block content :]
<div id="wrapper">
    <div id="sideMenu">
        <ul>
            <li><a href="{{$adminUrl}}/category">List category</a></li>
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
                <form id="frmCategoryAdd" method="post">
                    <div class="formRow">
                        <div class="grid3"><span class="required fleft">*</span><label>Parent</label></div>
                        <div class="grid4">
                            <select name="parent">
                                <option value="0">None</option>
                                @foreach ($categories as $category) :
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
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
                        <div class="grid4"><input id="name" type="text" name="name" maxlength="100" class="required" /></div>
                        @if (isset($errors['name'])) :
                        <div class="clear"></div>
                        <div class="grid3">&nbsp;</div>
                        <div class="stError">{{$errors['name']}}</div>
                        @endif
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <div class="grid3"><span class="required fleft">*</span><label>Slug</label></div>
                        <div class="grid4"><input id="slug" type="text" name="slug" maxlength="100" class="required" /></div>
                        @if (isset($errors['slug'])) :
                        <div class="clear"></div>
                        <div class="grid3">&nbsp;</div>
                        <div class="stError">{{$errors['slug']}}</div>
                        @endif
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <div class="grid3"><label>Meta description</label></div>
                        <div class="grid5"><textarea cols="40" rows="5" name="meta_description" class="required"></textarea></div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <div class="grid3"><label>Sort</label></div>
                        <div class="grid3"><input id="sort" type="text" maxlength="3" name="sort" /></div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow rowSubmit">
                        <div class="grid3">&nbsp;</div>
                        <div class="grid4">
                            <input type="submit" class="buttonS bBlue btnAction" name="submit" value="Submit" />
                        </div>
                        <div class="clear"></div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        // Generate slug
        $('#name').change(function(){
            $('#slug').val($.Utility.generateSlug($(this).val()));
        });
        $('#frmCategoryAdd').validate({
            rules: {
                sort: {
                    digits: true
                }
            }
        });
    });
</script>
[: endblock :]