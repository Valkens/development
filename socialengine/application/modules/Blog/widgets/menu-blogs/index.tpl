
<div class="headline">
  <h2>
    <?php echo "Blogs";?>
  </h2>
  <?php if( count($this->navigation) > 0 ): ?>
    <div class="tabs">
      <?php
        // Render the menu
        echo $this->navigation()
          ->menu()
          ->setContainer($this->navigation)
          ->render();
      ?>
      <span style="float: right; padding-right: 4px; padding-top: 2px;">
      <a href="<?php echo $this->url(array('action' => 'rss'), 'blog_general') ?>"><img src="./application/modules/Blog/externals/images/rssBig.png" alt="RSS" title="RSS"></a>
      </span>
    </div>
  <?php endif; ?>
</div>
