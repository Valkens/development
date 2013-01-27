[[ $this->inherit('@_theme_/layout') ]]
[: block content :]
<div id="wrapper">
    <div id="sideMenu">
        <ul>
            <li><a href="{{$adminUrl}}/category">List category</a></li>
            <li><a href="{{$adminUrl}}/category/add">Add new category</a></li>
        </ul>
    </div>

    <div id="page">
        <h1 id="pageTitle">Edit category</h1>

        <div class="widget fluid">
            <div class="whead">
                <h2>Category's information</h2>
                <div class="clear"></div>
            </div>

            @if ($category) :
            <div class="wbody">
                <form id="frmCategoryEdit" method="post">
                    <div class="formRow">
                        <div class="grid2"><span class="required fleft">*</span><label>Parent</label></div>
                        <div class="grid4 noSearch">
                            <select name="parent" class="select">
                                <option value="0">None</option>
                                @foreach ($categories as $obj) :
                                    @$selected = ($obj->id == $category->id_parent) ? ' selected="selected"' : ''
                                <option value="{{$obj->id}}"{{$selected}}>{{$obj->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <div class="grid2"><span class="required fleft">*</span><label>Name</label></div>
                        <div class="grid4"><input id="name" type="text" name="name" maxlength="100" value="{{$category->name}}" /></div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <div class="grid2"><span class="required fleft">*</span><label>Slug</label></div>
                        <div class="grid4"><input id="slug" type="text" name="slug" maxlength="100" value="{{$category->slug}}" /></div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <div class="grid2"><label>Meta description</label></div>
                        <div class="grid7"><textarea cols="40" rows="5" name="meta_description">{{$category->meta_description}}</textarea></div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <div class="grid2"><label>Sort</label></div>
                        <div class="grid2"><input id="sort" type="text" maxlength="3" name="sort" value="{{$category->sort}}" /></div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow rowSubmit">
                        <div class="grid2">&nbsp;</div>
                        <div class="grid4">
                            <input type="submit" class="buttonS bBlue btnAction" name="submit" value="Save" />
                        </div>
                        <div class="clear"></div>
                    </div>
                </form>
            </div>
            @else :
            <div class="albox mError">This category is not exist.</div>
            @endif
        </div>
    </div>
</div>
[: endblock :]

[: block script :]
<script type="text/javascript">
$(function(){
    // Generate slug
    $('#name').change(function(){
        $('#slug').val($.Utility.generateSlug($(this).val()));
    });
    $('#frmCategoryEdit').validate({
        rules: {
            sort: {
                digits: true
            }
        }
    });
});
</script>
[: endblock :]