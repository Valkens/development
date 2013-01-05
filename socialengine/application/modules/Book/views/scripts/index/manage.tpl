<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Book
 * @copyright  Copyright 2012 Younet Developments
 * @license    http://www.socialengine.net/license/
 * @version    $Id: manage.tpl SE-1488 duclh $
 * @author     duclh
 */
?>
<?php
$this->headLink()->appendStylesheet($this->baseUrl().'/application/css.php?request=application/modules/Book/externals/styles/main.css'); ?>

<div class="headline">
    <h2>
        <?php echo $this->translate('Books');?>
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
    </div>
    <?php endif; ?>
</div>

<div class='layout_right'></div>

<div class='layout_middle'>

    <?php if ($this->paginator->getTotalItemCount() > 0 ): ?>
    <ul class="books_browse">
        <?php foreach( $this->paginator as $item ): ?>
        <li>
            <div class='books_browse_book'>
                <?php echo $this->htmlLink($item->getHref(array('action' => 'view')), $this->itemPhoto($item, 'thumb.icon'), array('class' => 'thumb')) ?>
            </div>
            <div class='books_browse_options'>
                <?php
                    echo $this->htmlLink(array(
                                            'action' => 'edit',
                                            'book_id' => $item->getIdentity(),
                                            'route' => 'book_specific',
                                            'reset' => true,
                                            ), $this->translate('Edit Book'), array(
                                            'class' => 'buttonlink icon_book_edit',
                         ))
                ?>
                <?php
                    echo $this->htmlLink(array(
                                            'action' => 'delete',
                                            'book_id' => $item->getIdentity(),
                                            'route' => 'book_specific',
                                            'reset' => true,
                                            ), $this->translate('Delete Book'), array(
                                            'class' => 'buttonlink icon_book_delete',
                         ))
                ?>
            </div>
            <div class='books_browse_info'>
                <p class='books_browse_info_title'>
                    <?php echo $this->htmlLink($item->getHref(array('action' => 'view')), $item->getTitle()) ?>
                </p>
                <p class='books_browse_info_date'>
                    <?php echo $this->translate('Posted by ');?>
                    <?php echo $this->htmlLink($item->getOwner()->getHref(), $item->getOwner()->getTitle()) ?>
                    <?php echo $this->translate('about');?>
                    <?php echo $this->timestamp(strtotime($item->posted_date)) ?>
                </p>
                <p class='books_browse_info_blurb'>
                    <?php
                // Not mbstring compat
                echo substr(strip_tags($item->description), 0, 350); if (strlen($item->description)>349) echo "...";
                    ?>
                </p>
            </div>
        </li>
        <?php endforeach; ?>
    </ul>

    <?php elseif($this->search): ?>
    <div class="tip">
      <span>
        <?php echo $this->translate('You do not have any book entries that match your search criteria.');?>
      </span>
    </div>
    <?php else: ?>
    <div class="tip">
      <span>
        <?php echo $this->translate('You do not have any books.');?>
        <?php echo $this->translate('Get started by %1$swriting%2$s a new book.', '<a href="'.$this->url(array('action' => 'add'), 'book_general').'">', '</a>'); ?>
      </span>
    </div>
    <?php endif; ?>
    <?php echo $this->paginationControl($this->paginator, null, array("pagination/bookpagination.tpl", "book")); ?>

</div>
