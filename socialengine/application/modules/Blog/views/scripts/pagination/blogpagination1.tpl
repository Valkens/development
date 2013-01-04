
<?php if ($this->pageCount > 1): ?>
  <div class = "pagin">
	<?php /* first page link */ ?>
    <?php if (isset($this->previous)): ?>
      <a href="javascript:void(0)" onclick="javascript:pageAction(<?php echo $this->first;?>)"><img src='./application/modules/Blog/externals/images/first.png'/></a>
      <?php if (isset($this->first)): ?>
      &nbsp;
      <?php endif; ?>
    <?php endif; ?>
    <?php /* Previous page link */ ?>
    <?php if (isset($this->previous)): ?>
      <a href="javascript:void(0)" onclick="javascript:pageAction(<?php echo $this->previous;?>)"><img src='./application/modules/Blog/externals/images/prev.png'/></a>
      <?php if (isset($this->previous)): ?>
      &nbsp;
      <?php endif; ?>
    <?php endif; ?>
	Page:
    <?php foreach ($this->pagesInRange as $page): ?>
	<span style = "margin:4px;">
      <?php if ($page != $this->current): ?>
        <a href="javascript:void(0)" onclick="javascript:pageAction(<?php echo $page;?>)"><?php echo $page;?></a> 
      <?php else: ?>
        <?php echo $page; ?> 
      <?php endif; ?>
	 </span>
    <?php endforeach; ?>

    <?php /* Next page link */ ?>
    <?php if (isset($this->next)): ?>
        <a href="javascript:void(0)" onclick="javascript:pageAction(<?php echo $this->next;?>)"><img src='./application/modules/Blog/externals/images/next.png'/></a>
    <?php endif; ?>
	<?php /* Last page link */ ?>
    <?php if (isset($this->next)): ?>
        <a href="javascript:void(0)" onclick="javascript:pageAction(<?php echo $this->last;?>)"><img src='./application/modules/Blog/externals/images/last.png'/></a>
    <?php endif; ?>
  </div>
<?php endif; ?>
 <style type="text/css">
 .pagin
 {
	background-color:#E9F4FA;
	font-size:8pt !important;
	padding:6px;
	text-align:center;
 }
</style>