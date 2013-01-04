<?php
$this->headLink()
        ->prependStylesheet($this->baseUrl().'/application/css.php?request=application/modules/Blog/widgets/search-blogs/styles.css')
?>
<script type="text/javascript">
 var pageAction =function(page){
    $('page').value = page;
    $('filter_form').submit();
  }
</script>
  <div>
  <?php echo $this->form->render($this) ?>
</div>
