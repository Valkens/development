<div class="headline">
  <h2>
    <?php echo $this->translate('Import Blogs');?>
  </h2>
  <div class="tabs">
    <?php
      // Render the menu
      echo $this->navigation()
        ->menu()
        ->setContainer($this->navigation)
        ->render();
    ?>
    <span style="float: right;">
      <a href="<?php echo $this->url(array('action' => 'rss'), 'blog_general') ?>"><img src="./application/modules/Blog/externals/images/rssBig.png" alt="RSS" title="RSS"></a>
      </span>
  </div>
</div>

<?php    $user = Engine_Api::_()->user()->getViewer();
        $mtable  = Engine_Api::_()->getDbtable('permissions', 'authorization');
        $msselect = $mtable->select()
                    ->where("type = 'blog'")
                    ->where("level_id = ?",$user->level_id)
                    ->where("name = 'max'");
        $mallow = $mtable->fetchRow($msselect);
        $max_blogs =  Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('blog', $user, 'max');
        if($max_blogs == "")
        {
            if (!empty($mallow))
                $max_blogs = $mallow['value'];
        }
        $cout_blog = Blog_Model_Blog::getCountBlog($user);
        if($cout_blog < $max_blogs):
             echo $this->form->render($this);
        else: ?>
           <div style="color: red; padding-left: 300px;">
                <?php echo $this->translate("Sorry! Maximum numbers of allowed blog entries : "); echo $max_blogs; echo " blog entries" ; ?> 
           </div> 
        <?php endif; ?>
<script type="text/javascript">
var system_id = <?php echo $this->system_id; ?>;
function updateTextFields() {
  if ($('system').selectedIndex == 3) {
    $('username-wrapper').show();
	 $('filexml-wrapper').hide();
	  $('submit-wrapper').show();
  } else {
    $('username-wrapper').hide();
	 $('filexml-wrapper').show();
	  $('submit-wrapper').show();
  }
  if ($('system').selectedIndex == 0)
  {
	 $('filexml-wrapper').hide();
	 $('username-wrapper').hide();
	 $('submit-wrapper').hide();
  }
}
if(system_id == 0 )
{
	 $('filexml-wrapper').hide();
	 $('username-wrapper').hide();
	  $('submit-wrapper').hide();
}
</script>