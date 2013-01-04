<?php
$this->headLink()
        ->prependStylesheet($this->baseUrl().'/application/css.php?request=application/modules/Blog/widgets/statistic-blogs/styles.css');

?>
<h3><?php echo $this->translate('Statistics');?></h3>
<ul class = "global_form_box" style="margin-bottom: 15px; padding : 0px 15px 15px 15px;">
	<br/>
                        <div style=" float:left; "> Blogs </div> <div style = "text-align:right; padding-right: 30px;">  <?php echo $this->count_blogs; ?>  </div>
                        <br/>
                         <div style="float:left; " >  Active Bloggers  </div>  <div style = "text-align:right;padding-right: 30px;">  <?php echo $this->count_bloggers ?></div>
                         <br/>

 </ul>

