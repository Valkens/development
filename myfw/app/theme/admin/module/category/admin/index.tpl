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
                <td>Description</td>
                <td>Slug</td>
                <td>Action</td>
            </tr>
            </thead>
            <tbody>
            @foreach ($categories as $category) :
            <tr>
                <td>#{{$category->id}}</td>
                <td>{{$category->name}}</td>
                <td>{{$category->slug}}</td>
                <td>{{$category->description}}</td>
                <td>
                    <a href="{{$adminUrl}}/category/edit/{{$category->id}}">Edit</a> |
                    <a href="{{$adminUrl}}/category/delete/{{$category->id}}">Delete</a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
[: endblock :]