[[ $this->inherit('@_theme_/layout') ]]
[: block page :]{{$pageTitle}}[: endblock :]

[: block content :]
<div id="wrapper">
    <div id="sideMenu">
        <ul>
            <li><a href="{{$adminUrl}}/post">List post</a></li>
        </ul>
    </div>

    <div id="page">
        <h1 id="pageTitle">Add new post</h1>

        <div class="widget fluid">
            <div class="whead">
                <h2>Post's information</h2>
                <div class="clear"></div>
            </div>

            <div class="wbody">
                <form id="frmPostAdd" method="post">
                    <div class="formRow">
                        <div class="grid3"><span class="required fleft">*</span><label>Category</label></div>
                        <div class="grid4 noSearch">
                            <select name="category" class="select">
                                <option value="0">None</option>
                                @foreach ($categories as $category) :
                                <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <div class="grid3"><span class="required fleft">*</span><label>Title</label></div>
                        <div class="grid4"><input id="title" type="text" name="name" maxlength="255" class="required" /></div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <div class="grid3"><span class="required fleft">*</span><label>Slug</label></div>
                        <div class="grid4"><input id="slug" type="text" name="slug" maxlength="255" class="required" /></div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <div class="grid3"><span class="required fleft">*</span><label>Thumbnail</label></div>
                        <div class="grid4"><input type="file" name="thumbnail" class="required" /></div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <div class="grid3"><label>Featured</label></div>
                        <div class="grid3">
                            <label>Yes&nbsp;</label><input type="radio" name="featured_status" value="1" checked="checked" />&nbsp;
                            <label>No&nbsp;</label><input type="radio" name="featured_status" value="0" />
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <div class="grid3"><span class="required fleft">*</span><label>Description</label></div>
                        <div class="grid5"><textarea cols="40" rows="5" name="description" class="required"></textarea></div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <div class="grid3"><label>Meta description</label></div>
                        <div class="grid5"><textarea cols="40" rows="5" name="meta_description" class="required"></textarea></div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <div class="grid3"><label>Status</label></div>
                        <div class="grid3">
                            <label>Show&nbsp;</label><input type="radio" name="status" value="1" checked="checked" />&nbsp;
                            <label>Hidden&nbsp;</label><input type="radio" name="status" value="0" />
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <div class="grid3"><label>Allow comment</label></div>
                        <div class="grid3">
                            <label>Yes&nbsp;</label><input type="radio" name="comment_status" value="1" checked="checked" />&nbsp;
                            <label>No&nbsp;</label><input type="radio" name="comment_status" value="0" />
                        </div>
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
        $('#title').change(function(){
            $('#slug').val($.Utility.generateSlug($(this).val()));
        });
    });
</script>
[: endblock :]