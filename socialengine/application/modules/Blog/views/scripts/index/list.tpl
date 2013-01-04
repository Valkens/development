
<script type="text/javascript">
  var pageAction = function(page){
    $('page').value = page;
    $('filter_form').submit();
  }
  var categoryAction = function(category){
    $('page').value = 1;
    $('category').value = category;
    $('filter_form').submit();
  }
  var tagAction = function(tag){
    $('page').value = 1;
    $('tag').value = tag;
    $('filter_form').submit();
  }
  var dateAction = function(start_date, end_date){
    $('page').value = 1;
    $('start_date').value = start_date;
    $('end_date').value = end_date;
    $('filter_form').submit();
  }
</script>
<script language=javascript type='text/javascript'>
function showhide(id)
{
    if (document.getElementById)
    {
        obj = document.getElementById(id);
        if (obj.style.display == "none")
        {
            obj.style.display = "";
            $('showlink').style.display = "none";
            $('hidelink').style.display = "";
        } else
        {
            obj.style.display = "none";
             $('showlink').style.display = "";
            $('hidelink').style.display = "none";
        }
    }
}
</script>

<div class='layout_right' >
  <div class='blogs_gutter'>
<div style="border: #DDDDDD solid 1px;  padding: 8px; ">
    <?php echo $this->htmlLink($this->owner->getHref(), $this->itemPhoto($this->owner), array('class' => 'blogs_gutter_photo')) ?>
    <?php echo $this->htmlLink($this->owner->getHref(), $this->owner->getTitle(), array('class' => 'blogs_gutter_name','style' => 'font-size:12pt;')) ?>

  <?php
      // Render the menu
      echo $this->navigation()
        ->menu()
        ->setContainer($this->gutterNavigation)
        ->setUlClass('navigation blogs_gutter_options')
        ->render();
    ?>
<!-- <span style="float: right;">
      <a href="<?php echo $this->url(array('action' => 'rss'), 'blog_general') ?>"><img src="./application/modules/Blog/externals/images/rssBig.png" alt="RSS" title="RSS"></a>
      </span>-->
  </div>
  <br/>
    <form id='filter_form' style="border: #DDDDDD solid 1px; height: 25px" class='global_form_box' method='POST'>
      <span style="font-size: 8pt; color: #6A8CAF; float:left; margin-top: 3px;"> Search Blogs </span>
	  <input type='text'  style="float:right;margin-top: 2px; margin-right: 1px; width: 70px; height:10px;" id="search" name="search" value="<?php if( $this->search ) echo $this->search; ?>"/>
      <input type="hidden" id="tag" name="tag" value="<?php if( $this->tag ) echo $this->tag; ?>"/>
      <input type="hidden" id="category" name="category" value="<?php if( $this->category ) echo $this->category; ?>"/>
      <input type="hidden" id="page" name="page" value="<?php if( $this->page ) echo $this->page; ?>"/>
      <input type="hidden" id="start_date" name="start_date" value="<?php if( $this->start_date) echo $this->start_date; ?>"/>
      <input type="hidden" id="end_date" name="end_date" value="<?php if( $this->end_date) echo $this->end_date; ?>"/>
    </form>

<br/>
    <?php if( count($this->userCategories) ): ?>
     <h3>Categories</h3>
     <ul class = "global_form_box" style="margin-bottom: 15px; padding:0px;">

        <ul>
             <?php $cats = $this->categories;
                $index = 0;
                foreach($cats as $cat): $index ++; ?>
               <div class="div_blog_categories_blog" style="font-weight: bold; padding: 5px 5px 5px 10px; ">
                <?php echo $this->htmlLink($this->url(array('category'=>$cat->category_id,'action'=>'listing','sort'=>'recent'), 'blog_general'),
                    strlen($this->translate($cat->category_name))>30?substr($this->translate($cat->category_name),0,30).'...':$this->translate($cat->category_name),
                    array('class'=>'')); ?>
                <span style="float: right; padding-left: 20px;">
                <a href="<?php echo $this->url(array('action' => 'rss','category' => $cat->category_id), 'blog_general') ?>"><img src="./application/modules/Blog/externals/images/rss.png" alt="RSS" title="RSS"></a>
                </span>
                </div>

                <?php endforeach;?>
        </ul>

 </ul>
    <?php endif; ?>
<br/>
    <?php if (count($this->userTags )):?>

               <h3><?php echo $this->translate('%1$s\'s Tags', $this->owner->getTitle()); ?></h3>
      <ul class = "global_form_box" style="margin-bottom: 15px; padding: 6px; " >
<span id="script" style="font-size: 9pt;">
             <?php $index = 0;
             $flag = false;
             foreach($this->userTags as $tag):
             $index ++;
             if(trim($tag->text) != ""):
             if($index > 25 && $flag == false): $flag = true;?>
             <p id="showlink" style="display: block; font-weight: bold">[<a id = 'title' href="#" onclick="showhide('hide'); return(false);"><?php echo $this->translate('show all');?></a>]</p>
             </span><span id="hide" style="display:none; font-size: 8pt;">
             <?php  endif;?>
             <span style="<?php if($tag->count > 99 && $tag->count < 599): echo "font-size:".($tag->count/80 + 8)."pt"; elseif($tag->count > 599): echo "font-size: 14pt"; endif; ?>">
          <a  href='javascript:void(0);'onclick='javascript:tagAction(<?php echo $tag->tag_id; ?>);' ><?php echo $tag->text?></a> (<?php echo $tag->count?>)
          </span>
             <?php endif; endforeach;
             if($flag == true):?>
             <p id="hidelink" style="display: none;font-weight: bold">[<a id = 'title' href="#" onclick="showhide('hide'); return(false);"><?php echo $this->translate('hide');?></a>]</p>
             <?php endif; ?>
</span>
 </ul>
    <?php endif; ?>

      <br/>
    <?php if( count($this->archive_list) ):?>
     <div class="header_blog">
               <div style="padding-left: 7px;">Archives</div>
        <div class="space-line"></div>
       </div>
     <div class="l"><div class="r" style="padding:1px">
        <div class="vertmenu" >
      <ul>
        <?php $index = 0; foreach ($this->archive_list as $archive): $index ++;?>
        <li class="user_music_row<?php echo $index%2; ?>">
          <a href='javascript:void(0);' onclick='javascript:dateAction(<?php echo $archive['date_start']?>, <?php echo $archive['date_end']?>);' <?php if ($this->start_date==$archive['date_start']) echo " style='font-weight: bold;'";?>><?php echo $archive['label']?></a>
        </li>
        <?php endforeach; ?>
      </ul>
 </div>
    </div></div>
    <div class="b"><div class="l"><div class="r"><div class="bl"><div class="br" style="height:7px">
</div></div></div></div></div>
    <?php endif; ?>

  </div>
</div>

<div class='layout_middle' >

<h2  style="color:#123456 ">
    <?php echo $this->translate('%1$s\'s Blogs', $this->htmlLink($this->owner->getHref(), $this->owner->getTitle()))?>
  </h2>


  <?php if( $this->paginator->getTotalItemCount() > 0 ): ?>
    <ul class='blogs_entrylist'>
    <?php foreach ($this->paginator as $item): ?>
      <li>
        <span>
          <h3 style="color: black;">
            <?php echo $this->htmlLink($item->getHref(), $item->getTitle()) ?>
          </h3>
          <div class="blog_entrylist_entry_date" style="color:#7F7F7F;">
           <?php echo $this->translate('by');?> <?php echo $this->htmlLink($item->getParent(), $item->getParent()->getTitle()) ?>
            <?php echo $this->timestamp($item->creation_date) ?>
          </div>
          <div class="blog_entrylist_entry_body">
            <?php echo substr(strip_tags($item->body), 0, 350); if (strlen($item->body)>349) echo "..."; ?>
          </div>
          <?php if ($item->comment_count > 0) :?>
            <?php echo $this->htmlLink($item->getHref(), $item->comment_count . ' ' . ( $item->comment_count != 1 ? 'comments' : 'comment' ), array('class' => 'buttonlink icon_comments')) ?>
          <?php endif; ?>
        </span>
      </li>
    <?php endforeach; ?>
    </ul>

  <?php elseif( $this->category || $this->tag ): ?>
    <div class="tip">
      <span>
        <?php echo $this->translate('%1$s has not published a blog entry with that criteria.', $this->owner->getTitle()); ?>
      </span>
    </div>

  <?php else: ?>
    <div class="tip">
      <span>
        <?php echo $this->translate('%1$s has not written a blog entry yet.', $this->owner->getTitle()); ?>
      </span>
    </div>
  <?php endif; ?>

  <?php echo $this->paginationControl($this->paginator, null, array("pagination/blogpagination1.tpl","blog"), array("orderby"=>$this->orderby)); ?>

<style type="text/css">

 ul .div_blog_categories_blog a
{
     *float: left;
}

.vertmenu ul li a {
border-bottom:0 solid #D9D9D9;
padding:5px 7px 5px 10px;

}
 .vertmenu div, td {
font-size:10pt;
}
.bl {background: url("./application/modules/Blog/externals/images/bl.gif") 0 100% no-repeat}
.br {background: url("./application/modules/Blog/externals/images/br.gif") 100% 100% no-repeat}
.tl {background: url("./application/modules/Blog/externals/images/tl.gif") 0 0 no-repeat}
.tr {background: url("./application/modules/Blog/externals/images/tr.gif") 100% 0 no-repeat; padding:0}
.t {background: url("./application/modules/Blog/externals/images/dot.gif") 0 0 repeat-x; width: auto}
.b {background: url("./application/modules/Blog/externals/images/dot.gif") 0 100% repeat-x}
.l {background: url("./application/modules/Blog/externals/images/dot.gif") 0 0 repeat-y}
.r {background: url("./application/modules/Blog/externals/images/dot.gif") 100% 0 repeat-y}
.user_music_row0{background:#f2f2f2;}
.user_music_row1{background: #ffffff;}
.vertmenu {
    font-family:Arial, Helvetica, sans-serif;
    font-size: 12px;
    width: 100%;
    padding: 0px;
    margin: 0px;
    text-align:left;
}
.vertmenu ul {
    list-style: none;
    margin: 0px;
    padding: 0px;
    border: none;
}
.vertmenu ul li {
    margin: 0px;
    padding: 0px;
}
.vertmenu ul li a {
    font-size: 100%;
    display: block;
    padding: 5px 0px 4px 12px;
    text-decoration: none;
    color: #000;
    height:15px;
}
.vertmenu ul li a:hover, .vertmenu ul li a:focus {

background-color: #D2E4F0;
}
div.header_blog {
-moz-border-radius-topleft:1ex;
-moz-border-radius-topright:1ex;
background-image:url("./application/modules/Blog/externals/images/header.gif");
background-repeat:repeat-x;
border:1px solid #BBD2E2;
color:#333333;
font-weight:bold;
padding:4px 5px 5px 6px;
}
div.header_blog_title {
-moz-border-radius-topleft:1ex;
-moz-border-radius-topright:1ex;
background-image:url("./application/modules/Blog/externals/images/header_title.gif");
background-repeat:repeat-x;
color:#333333;
font-weight:bold;
height: 27px;
padding:4px 5px 5px 6px;
}
div, td {

}
.comments > ul > li {
background-color: white;
}
.comments {
width:100%;
}
.comments .comments_options {

padding: 5px;;
}
ul.blogs_entrylist {
    border-top-width: 0px ;
}
 .blog_entrylist_entry_date  a:link, .blog_entrylist_entry_date a:visited{

}
H3  a:link ,H3  a:visited
{

}

</style>
