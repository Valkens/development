<?php if( !$this->blog || ($this->blog->draft==1 && !$this->blog->isOwner($this->viewer()))): ?>
<?php echo $this->translate('The blog you are looking for does not exist or has not been published yet.');?>
<?php return; // Do no render the rest of the script in this mode
endif; ?>

<script type="text/javascript">
  var categoryAction = function(category){
    $('category').value = category;
    $('filter_form').submit();
  }
  var tagAction =function(tag){
    $('tag').value = tag;
    $('filter_form').submit();
  }
  var dateAction =function(start_date, end_date){
    $('start_date').value = start_date;
    $('end_date').value = end_date;
    $('filter_form').submit();
  }
  function become()
  {
     var request = new Request.JSON({
            'method' : 'post',
            'url' :  '<?php echo $this->url(array('action' => 'become'), 'blog_general') ?>',
            'data' : {
                'blog_id' : <?php echo $this->blog->blog_id; ?>  
                
            },
            'onComplete':function(responseObject)
            {  
                $('become_count').innerHTML =  <?php echo $this->blog->become_count; ?> +1 ;
                $('btnBecome').innerHTML = "";
               
            }
        });
        request.send();
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
  <div style="border: #DDDDDD solid 1px;  padding: 8px; overflow-y: auto;">
    <?php echo $this->htmlLink($this->owner->getHref(), $this->itemPhoto($this->owner), array('class' => 'blogs_gutter_photo')) ?>
    <?php echo $this->htmlLink($this->owner->getHref(), $this->owner->getTitle(), array('class' => 'blogs_gutter_name','style' => 'font-size:12pt;'));
    ?>
 <?php
      // Render the menu
      echo $this->navigation()
        ->menu()
        ->setContainer($this->gutterNavigation)
        ->setUlClass('navigation blogs_gutter_options')
        ->render();
    ?>
    <?php if($this->viewer->getIdentity() > 0): ?>
        <?php if(Blog_Api_Core::checkUserBecome($this->viewer->getIdentity(),$this->blog->blog_id)): ?>
        <div id="btnBecome">
        <a class="buttonlink icon_blog_become"  style="font-size: 8pt; margin-bottom: 4px" onclick="this.disabled=true; become(); "  href="javascript:;"><?php echo $this->translate('Become Member');?></a>
        </div>
        <?php endif; ?>
       
    <?php endif; ?>


    <div style="padding-bottom: 5px;"><span style="font-weight: bold"><?php echo $this->translate('Members');?>:</span> <span id = "become_count"><?php echo $this->blog->become_count?></span> <?php echo 'member(s)'; ?></div>
   
<?php
$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
?>
    <div style="display: inline; float: left; width: 170px;">
        <div class="chartblock chartblock-orange">
            <h3>Shares <span title="Total shares for this time period" class="q ">?</span></h3>
            <h4 class=""><?php $shares = Blog_Api_Addthis::widget('shares',$url);  ?></h4>
        </div>
        <div class="chartblock chartblock-blue">
            <h3>Clicks <span title="Total traffic back from shares for this time period" class="q ">?</span></h3>              
            <h4 class=""><?php $clicks = Blog_Api_Addthis::widget('clicks',$url); ?></h4>  
        </div>
        <div class="chartblock chartblock-dark">
            <h3>Viral Lift <span title="Percentage increase in traffic due to shares and clicks" class="q ">?</span></h3>
            <h4><?php echo round(($clicks*100)/$shares,2); ?>%</h4>                    
        </div>            
    </div>
    <!-- AddThis Button BEGIN -->
    <div class="addthis_toolbox addthis_default_style ">
    <a class="addthis_button_preferred_1"></a>
    <a class="addthis_button_preferred_2"></a>
    <a class="addthis_button_preferred_3"></a>
    <a class="addthis_button_preferred_4"></a>
    <a class="addthis_button_compact"></a>
    <a class="addthis_counter addthis_bubble_style"></a>
    </div>
    <script type="text/javascript">var addthis_config = {"data_track_clickback":true};</script>
    <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('blog.domain');?>"></script>
    <!-- AddThis Button END -->
</div> 
  <br/>
    <form id='filter_form' class='global_form_box' style="border: #DDDDDD solid 1px; height: 25px" method='post' action='<?php echo $this->url(array('user_id' => $this->blog->owner_id), 'blog_view') ?>'>
     <span style="font-size: 8pt; color: #6A8CAF; float:left; margin-left: 1px; margin-top: 3px;"> <?php echo $this->translate('Search Blogs');?> </span> 
     <input id="search"  style="float:right; margin-top: 2px; margin-right: 1px; width: 75px; height:10px;" name="search" type='text' />
      <input type="hidden" id="tag" name="tag" value=""/>
      <input type="hidden" id="category" name="category" value=""/>
      <input type="hidden" id="start_date" name="start_date" value="<?php if ($this->start_date) echo $this->start_date;?>"/>
      <input type="hidden" id="end_date" name="end_date" value="<?php if ($this->end_date) echo $this->end_date;?>"/>
    </form>
<br/>
    <?php if (count($this->userCategories )):?>

        <h3><?php echo $this->translate('Categories');
         ?> </h3>
        <ul class = "global_form_box" style="margin-bottom: 15px; padding:0px;">
            <ul>
         <li style="font-weight: bold; padding: 5px 5px 5px 10px;"> <a href='javascript:void(0);' onclick='javascript:categoryAction(0);'><?php if( !$this->category )echo $this->translate('All Categories')?></a></li>
             <?php 
                $index = 0;
                $owner_id = $this->blog->owner_id;
                foreach ($this->userCategories as $category): $index ++; ?>
                <div class ="div_blog_categories_blogS" style="font-weight: bold; padding: 5px 5px 5px 10px;  ;<?php echo $index%2; ?>">
                <a href='javascript:void(0);' onclick='javascript:categoryAction(<?php echo $category->category_id?>);'>
                  <?php echo $this->translate($category->category_name)?></a>
                <span style="float: right; padding-left: 20px;">
                    <a href="<?php echo $this->url(array('action' => 'rss','category' => $category->category_id, 'owner'=>$owner_id), 'blog_general') ?>"><img src="./application/modules/Blog/externals/images/rss.png" alt="RSS" title="RSS"></a>
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
    <?php if (count($this->archive_list )):?>

               <h3> <?php echo $this->translate('Archives');?></h3>     
        
       
      <ul class = "global_form_box" style="margin-bottom: 15px; ">
        <?php  $index = 0; foreach ($this->archive_list as $archive): $index ++; ?>
        <li style="font-weight: bold; padding: 5px 5px 5px 0px; ">
          <a href='javascript:void(0);' onclick='javascript:dateAction(<?php echo $archive['date_start']?>, <?php echo $archive['date_end']?>);' <?php if ($this->start_date==$archive['date_start']) echo " style='font-weight: bold;'";?>><?php echo $archive['label']?></a>
        </li>
        <?php endforeach; ?>
      </ul>

    <?php endif; ?>
      
  </div>
</div>

<div class='layout_middle'>           
<h2 style=" color:#123456;">
    <?php echo $this->translate('%1$s\'s Blog', $this->htmlLink($this->owner->getHref(), $this->owner->getTitle()))?>
  </h2>
  <?php if ($this->blog->owner_id == $this->viewer->getIdentity()&&$this->blog->draft == 1):?>
    <div class="tip">
      <span>
        <?php echo $this->translate('This blog entry has not been published. You can publish it by %1$sediting the entry%2$s.', '<a href="'.$this->url(array('blog_id' => $this->blog->blog_id), 'blog_edit', true).'">', '</a>'); ?>
      </span>
    <br/>
  <?php endif; ?>
<div style="">
      <h3 style="color:#5F93B4;">
        <?php echo $this->blog->getTitle() ?>
      </h3>
      <div class="blog_entrylist_entry_date" style="margin: 5px;margin-left:0px; color:#7F7F7F;">
        <?php echo $this->translate('Posted by');?> <?php echo $this->htmlLink($this->owner->getHref(), $this->owner->getTitle()) ?>
        <?php echo $this->timestamp($this->blog->creation_date) ?>
        <?php if( $this->category ): ?>
          -
          <?php echo $this->translate('Filed in') ?>
          <a href='javascript:void(0);' onclick='javascript:categoryAction(<?php echo $this->category->category_id?>);'><?php echo $this->translate($this->category->category_name) ?></a>
        <?php endif; ?>
        <?php if (count($this->blogTags )):?>
          -
          <?php foreach ($this->blogTags as $tag): ?>
            <a href='javascript:void(0);' onclick='javascript:tagAction(<?php echo $tag->getTag()->tag_id; ?>);'>#<?php echo $tag->getTag()->text?></a>&nbsp;
          <?php endforeach; ?>
        <?php endif; ?>
        -
        <?php echo $this->translate(array('%s view', '%s views', $this->blog->view_count), $this->locale()->toNumber($this->blog->view_count)) ?>
      </div>
      </div>
      <div class="blog_entrylist_entry_body">
        <?php echo $this->blog->body ?>
      </div>
      <br/>
 <!-- AddThis Button BEGIN -->
 <div class="addthis_toolbox addthis_default_style">
 <a class="addthis_button_google_plusone addthis_32x32_style"></a>
<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
<a class="addthis_counter addthis_pill_style"></a>
</div>
   <!-- AddThis Button END -->
  <?php echo $this->action("list", "comment", "core", array("type"=>"blog", "id"=>$this->blog->getIdentity())) ?>
    </div>
    </div></div>
</div>
<style type="text/css">

  
 ul .div_blog_categories_blogS a
{
     *float: left;
}

.centeredImage
    {
    text-align:center;
    margin-top:0px;
    margin-bottom:0px;
    padding:0px;
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
.comments_author_photo a
{
     padding: 0px !important;
    height:auto !important;
}
.comments_author a
{
    padding: 0px !important;
    height:auto !important;
}
.comments_comment_options a
{
    padding: 0px !important;
    height:auto !important;
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

.comments {
width:100%;
}
.comments .comments_options {

padding: 5px;;
}
.comments_author a:link, a:visited {
color:#5F93B4;
text-decoration:none;
}
.blog_entrylist_entry_date  a:link, .blog_entrylist_entry_date a:visited{
 
}
.chartblock.chartblock-orange {
    background: none repeat scroll 0 0 #F75C39;
}
.chartblock.chartblock-blue {
    background: none repeat scroll 0 0 #0077CC;
}
.chartblock.chartblock-dark {
    background: none repeat scroll 0 0 #424242;
}
.chartblock {
    -moz-border-radius: 4px 4px 4px 4px;
    cursor: default;
    margin-bottom: 5px;
    padding: 5px 8px;
    position: relative;
}
.chartblock span.q {
    background: url("./application/modules/Blog/externals/images/question_mark_1.png") no-repeat scroll 0 0 transparent;
    display: inline-block;
    height: 14px;
    line-height: 14px;
    overflow: hidden;
    text-indent: -9999px;
    width: 14px;
}
.chartblock h3 {
    color: #FFFFFF;
    display: inline;
    font-size: 15px;
    margin: 0;
    padding: 0;
}
.chartblock h4 {
    color: #FFFFFF;
    font-size: 13px;
    margin: 0 !important;
    padding: 0;
    position: absolute;
    right: 10px;
    text-align: right;
    top: 6px;
    border-bottom:none;
}
</style>
