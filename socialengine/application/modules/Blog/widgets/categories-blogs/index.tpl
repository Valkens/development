<?php
$this->headLink()
        ->prependStylesheet($this->baseUrl().'/application/css.php?request=application/modules/Blog/widgets/categories-blogs/styles.css');

?>

<ul class = "global_form_box" style="margin-bottom: 15px; padding:0px;">
        <ul>
             <?php $cats = $this->categories;
                $index = 0;
                foreach($cats as $cat): $index ++; ?>
                <div class="div_blog_categories_blogs" style="font-weight: bold; padding: 5px 5px 5px 10px; ">
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

 <style type="text/css">
.layout_blog_categories_blogs ul .div_blog_categories_blogs a
{
     *float: left;
}
 </style>