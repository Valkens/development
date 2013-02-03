[[ $this->inherit('@_theme_/layout') ]]

[: block pageTitle :]Add new post[: endblock :]

[: block content :]
<div id="wrapper">
    <div id="sideMenu">
        <ul>
            <li><a href="[[$this->url('route_admin_post')]]">List of posts</a></li>
        </ul>
    </div>

    <div id="page">
        <h1 id="pageTitle">Add new post</h1>

        <div class="widget fluid">
            @if ($subcategories) :
            <div class="whead">
                <h2>Post's information</h2>
                <div class="clear"></div>
            </div>
            <div class="wbody">
                <form id="frmPostAdd" method="post" enctype="multipart/form-data">
                    <div class="formRow">
                        <div class="grid2"><span class="required fleft">*</span><label>Category</label></div>
                        <div class="grid2 noSearch">
                            <select name="subcategory" class="select">
                                @foreach ($subcategories as $category) :
                                    @$selected = (isset($input['subcategory']) && $input['subcategory'] == $category->id) ? 'selected= "selected"' : ''
                                    <option value="{{$category->id}}"{{$selected}}>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <div class="grid2"><span class="required fleft">*</span><label>Title</label></div>
                        <div class="grid8"><input id="title" type="text" name="title" maxlength="255" class="required" value="{{@$input['title']}}" /></div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <div class="grid2"><span class="required fleft">*</span><label>Slug</label></div>
                        <div class="grid8"><input id="slug" type="text" name="slug" maxlength="255" class="required" value="{{@$input['slug']}}" /></div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <div class="grid2"><span class="required fleft">*</span><label>Thumbnail</label></div>
                        <div class="grid5">
                            <input id="thumbnail" type="file" name="thumbnail" />
                            <div class="clear"></div>
                            <label class="error" for="thumbnail" generated="true">{{@$errors['thumbnail']}}</label>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <div class="grid2"><label>Featured</label></div>
                        <div class="grid2">
                            <label>Yes&nbsp;</label>
                            <input type="radio" name="featured_status" value="1"{{(@$input['featured_status'] == 1) ? ' checked="checked"' : ''}} />&nbsp;
                            <label>No&nbsp;</label>
                            <input type="radio" name="featured_status" value="0"{{(@$input['featured_status'] == 0) ? ' checked="checked"' : ''}} />
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <div class="grid2"><label>Meta description</label></div>
                        <div class="grid7"><textarea cols="40" rows="5" name="meta_description">{{@$input['meta_description']}}</textarea></div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <div class="grid2"><span class="required fleft">*</span><label>Description</label></div>
                        <div class="grid7"><textarea cols="40" rows="5" name="description" class="required">{{@$input['description']}}</textarea></div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <div class="grid2"><label>Tags:</label></div>
                        <div class="grid9"><input type="text" id="tags" name="tags" class="tags" value="{{@$input['tags']}}"/></div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <div class="grid2"><label>Status</label></div>
                        <div class="grid3">
                            <label>Show&nbsp;</label>
                            <input type="radio" name="status" value="1" checked="checked"{{(@$input['status'] == 1) ? ' checked="checked"' : ''}} />&nbsp;
                            <label>Hidden&nbsp;</label>
                            <input type="radio" name="status" value="0"{{(@$input['status'] == 0) ? ' checked="checked"' : ''}} />
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <div class="grid2"><label>Allow comment</label></div>
                        <div class="grid2">
                            <label>Yes&nbsp;</label><input type="radio" name="comment_allowed" value="1" checked="checked"{{(@$input['comment_allowed'] == 1) ? ' checked="checked"' : ''}} />&nbsp;
                            <label>No&nbsp;</label><input type="radio" name="comment_allowed" value="0"{{(@$input['comment_allowed'] == 0) ? ' checked="checked"' : ''}} />
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <div class="grid2"><label>Content</label></div>
                        <div class="grid10">
                            <textarea id="editor1" class="ckeditor" cols="40" rows="5" name="content">{{@$input['content']}}</textarea>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow rowSubmit">
                        <div class="grid2">&nbsp;</div>
                        <div class="grid4">
                            <input type="submit" class="buttonS bBlue btnAction" value="Save" />
                        </div>
                        <div class="clear"></div>
                    </div>
                </form>
            </div>
            @else :
            <div class="albox mWarning">Please create at least one Sub-category.</div>
            @endif
        </div>
    </div>
</div>
[: endblock :]

[: block script :]
<script type="text/javascript" src="{{$baseUrl}}/app/theme/admin/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    $(function(){
        // Generate slug
        $('#title').change(function(){
            $('#slug').val($.Utility.generateSlug($(this).val()));
        });

        // Form validation
        $('#frmPostAdd').validate();
        $("#thumbnail").rules("add", {
            required: true,
            accept: "png|jpg|jpeg|gif",
            messages: {
                required: "Please choose an image file",
                accept: "Only accept Png, Jpeg, Jpg, Gif file"
            }
        });
        

        //Tags input
        $('#tags').tagsInput({
            width: '100%',
            'height': '',
            'defaultText': 'Add a tag',
            autocomplete_url: "[[$this->url('route_admin_tag_suggest')]]",
            autocomplete: {
                selectFirst: true, 
                width:'100px',
                autoFill: true
            }
        });
    });
</script>
[: endblock :]