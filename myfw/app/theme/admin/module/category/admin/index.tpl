[[ $this->inherit('@_theme_/layout') ]]

{% block pageTitle %}List of categories{% endblock %}

{% block content %}
<div id="wrapper">
    <h1 id="pageTitle">
        List of categories
        <a href="{{$this->url('route_admin_category_add')}}" class="buttonS bBlue btnAction fright">Add</a>
    </h1>
    <div class="widget">
        @if ($categories) :
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
                @foreach ($parentCategories as $category) :
                    <tr>
                        <td>#{{$category->id}}</td>
                        <td style="text-align:left;text-indent:5px">{{$category->name}}</td>
                        <td>{{$category->slug}}</td>
                        <td>{{$category->meta_description}}</td>
                        <td>{{$category->sort}}</td>
                        <td>
                            <a class="fleft" href="{{$this->url('route_admin_category_edit', array('id' => $category->id))}}">
                                <span class="iedit tip_ne" title="Edit"></span>
                            </a>
                            <a class="fleft delete_link" href="{{$this->url('route_admin_category_delete', array('id' => $category->id))}}">
                                <span class="idelete tip_ne" title="Delete"></span>
                            </a>
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
                                <a class="fleft" href="{{$this->url('route_admin_category_edit', array('id' => $child->id))}}">
                                    <span class="iedit tip_ne" title="Edit"></span>
                                </a>
                                <a class="fleft delete_link" href="{{$this->url('route_admin_category_delete', array('id' => $child->id))}}">
                                    <span class="idelete tip_ne" title="Delete"></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
                </tbody>
            </table>
            <div id="alertMessage"></div>
        @else :
            <div class="albox mWarning">No categories.</div>
        @endif
    </div>
</div>
{% endblock %}

{% block script %}
<script type="text/javascript">
$(function(){
    $('.delete_link').live('click', function(e) {
        var el = $(this);
        e.preventDefault();
        $.confirm({
            'title': 'Confirm delete',
            'message': "<strong>You want to delete this category </strong>",
            'buttons': {
                'Yes' : {
                    'class' : 'buttonM bBlue btnAction',
                    'action': function() {
                        loading('Deleting...');
                        $.post(el.attr('href'), function(res) {
                            if (res.success) {
                                if (res.redirect) {
                                    window.location = res.href;
                                } else {
                                    unloading();
                                    showAlertMessageWarning(res.msg, 2000);
                                }
                            } else {
                                console.log(res);
                            }
                        }, 'json');
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
{% endblock %}