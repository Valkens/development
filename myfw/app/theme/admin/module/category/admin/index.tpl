[[ $this->inherit('@_theme_/layout') ]]
[: block page :]{{$pageTitle}}[: endblock :]

[: block content :]
<div id="wrapper">
    <h1 id="pageTitle">
        List category
        <a href="{{$adminUrl}}/category/add" class="buttonS bDefault btnAction fright">Add</a>
    </h1>
    <div class="widget">
        <table width="100%" cellspacing="0" cellpadding="0" class="tDefault checkAll check dTable">
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
                        <a href="{{$adminUrl}}/category/edit/{{$category->id}}">Edit</a> |
                        <a href="{{$adminUrl}}/category/delete/{{$category->id}}">Delete</a>
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
                            <a href="{{$adminUrl}}/category/edit/{{$child->id}}">Edit</a> |
                            <a href="{{$adminUrl}}/category/delete/{{$child->id}}">Delete</a>
                        </td>
                    </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>
    </div>
</div>
[: endblock :]