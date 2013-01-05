<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Book
 * @copyright  Copyright 2012 Younet Developments
 * @license    http://www.socialengine.net/license/
 * @version    $Id: bookpagination.tpl SE-1488 duclh $
 * @author     duclh
 */
?>

<?php if ($this->pageCount > 1): ?>
<div class="paginationControl">

    <?php /* Previous page link */ ?>
    <?php if (isset($this->previous)): ?>
    <a href="<?php echo $this->url(array('page' => $this->previous), 'book_pagination', false);?>"><?php echo $this->translate('&#171; Previous');?></a>
    <?php if (isset($this->previous)): ?>
    &nbsp;|
    <?php endif; ?>
    <?php endif; ?>

    <?php foreach ($this->pagesInRange as $page): ?>
    <?php if ($page != $this->current): ?>
    <a href="<?php echo $this->url(array('page' => $page), 'book_pagination', true);?>"><?php echo $page;?></a> |
    <?php else: ?>
    <?php echo $page; ?> |
    <?php endif; ?>
    <?php endforeach; ?>

    <?php /* Next page link */ ?>
    <?php if (isset($this->next)): ?>
    <a href="<?php echo $this->url(array('page' => $this->next), 'book_pagination', true);?>"><?php echo $this->translate('Next &#187;');?></a>
    <?php endif; ?>

</div>
<?php endif; ?>