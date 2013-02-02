[[ $this->inherit('@_theme_/layout') ]]
[: block content :]
<div id="wrapper">
    <h1 id="pageTitle">
        {{$pageTitle}}
        <a href="[[$this->url('route_admin_category_add')]]" class="buttonS bBlue btnAction fright">Add</a>
    </h1>
    <div class="widget">
        <table width="100%" cellspacing="0" cellpadding="0" class="tDefault">
            <thead>
            <tr>
                <td>ID</td>
                <td>Name</td>
                <td>Slug</td>
                <td>Description</td>
                <td>Sort</td>
                <td>Action</td>
            </tr>
            </thead>
            <tbody>
            @foreach ($categories as $category) :
                <tr>
                    <td>#{{$category->id}}</td>
                    <td style="text-align:left;text-indent:5px">{{$category->name}}</td>
                    <td>{{$category->slug}}</td>
                    <td>{{$category->meta_description}}</td>
                    <td>{{$category->sort}}</td>
                    <td>
                        <a href="[[$this->url('route_admin_category_edit', array('id' => $category->id))]]">Edit</a> |
                        <a class="delete_link" href="{{$adminUrl}}/category/delete/{{$category->id}}">Delete</a>
                    </td>
                </tr>
                @foreach ($category->childs as $child) :
                    <tr>
                        <td>#{{$child->id}}</td>
                        <td style="text-align:left;text-indent:5px">- - - {{$child->name}}</td>
                        <td>{{$child->slug}}</td>
                        <td>{{$child->meta_description}}</td>
                        <td>{{$child->sort}}</td>
                        <td>
                            <a href="[[$this->url('route_admin_category_edit', array('id' => $child->id))]]">Edit</a> |
                            <a class="delete_link" href="{{$adminUrl}}/category/delete/{{$child->id}}">Delete</a>
                        </td>
                    </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>
    </div>
</div>
[: endblock :]

[: block script :]
<script type="text/javascript">
$(function(){
    $('.delete_link').live('click', function(e) {
        e.preventDefault();
        $.confirm({
            'title': 'Confirm delete',
            'message': "<strong>You want to delete this category </strong>",
            'buttons': {
                'Yes' : {
                    'class' : 'buttonM bBlue btnAction',
                    'action': function() {
                        loading('Checking');
                        $('#preloader').html('Deleting...');
                        setTimeout('unloading()', 900);
                    }
                },
                'No' : {
                    'class'	: 'buttonM bRed btnAction'
                }
            }
        })
    });
});
</script>
[: endblock :]