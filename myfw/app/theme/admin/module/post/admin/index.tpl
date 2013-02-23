[[ $this->inherit('@_theme_/layout') ]]

{% block pageTitle %}List of posts{% endblock %}

{% block content %}
<div id="wrapper">
    <h1 id="pageTitle">
        List of posts
        <a href="{{$this->url('route_admin_post_add')}}" class="buttonS bBlue btnAction fright">Add</a>
    </h1>
    <div class="widget">
        @if ($posts) :
            <table width="100%" cellspacing="0" cellpadding="0" class="tDefault">
                <thead>
                <tr>
                    <td>ID</td>
                    <td>Thumbnail</td>
                    <td>Title</td>
                    <td>Category</td>
                    <td>Description</td>
                    <td>Featured status</td>
                    <td>Status</td>
                    <td>Comment count</td>
                    <td>Action</td>
                </tr>
                </thead>
                <tbody>
                @foreach ($posts as $post) :
                <tr>
                    <td>#{{$post->id}}</td>
                    <td><img src="{{$post->thumbnail}}" width="50" height="50" /></td>
                    <td>{{$post->title}}</td>
                    <td>{{$postCategories[$post->subcategory_id]}}</td>
                    <td>{{$post->description}}</td>
                    <td>
                        @echo ($post->featured_status) ? '<span class="stSuccess">[Yes]</span>' : '<span class="stError">[No]</span>';
                    </td>
                    <td>
                        @echo ($post->status) ? '<span class="stSuccess">[Show]</span>' : '<span class="stError">[Hidden]</span>';
                    </td>
                    <td>{{$post->comment_count}}</td>
                    <td>
                        <a class="fleft" href="{{$this->url('route_admin_post_edit', array('id' => $post->id))}}">
                            <span class="iedit tip_ne" title="Edit"></span>
                        </a> 
                        <a class="fleft delete_link" href="{{$this->url('route_admin_post_delete', array('id' => $post->id))}}">
                            <span class="idelete tip_ne" title="Delete"></span>
                        </a>
                    </td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="9">
                            <div class="paginator">
                                @echo $paginator->display_pages()
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        @else :
            <div class="albox mWarning">No posts.</div>
        @endif
    </div>
</div>
{% endblock %}

{% block script %}
<script type="text/javascript">
    $(function(){
        $('.delete_link').live('click', function(e) {
            e.preventDefault();
            $.confirm({
                'title': 'Confirm delete',
                'message': "<strong>You want to delete this Post</strong>",
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
{% endblock %}