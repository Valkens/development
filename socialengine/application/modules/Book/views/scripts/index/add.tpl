<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Book
 * @copyright  Copyright 2012 Younet Developments
 * @license    http://www.socialengine.net/license/
 * @version    $Id: Create.tpl SE-1488 duclh $
 * @author     duclh
 */
?>

<div class="headline">
    <h2>
        <?php echo $this->translate('Books');?>
    </h2>
    <div class="tabs">
        <?php
        // Render the menu
        echo $this->navigation()
                  ->menu()
                  ->setContainer($this->navigation)
                  ->render();
        ?>
    </div>
</div>

<?php
    $user = Engine_Api::_()->user()->getViewer();
    $mtable  = Engine_Api::_()->getDbtable('permissions', 'authorization');
    $msselect = $mtable->select()
    ->where("type = 'book'")
    ->where("level_id = ?",$user->level_id)
    ->where("name = 'max'");
    $mallow = $mtable->fetchRow($msselect);
    $max_books =  Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('book', $this->viewer, 'max');

    if (is_null($max_books)) {
        if (!empty($mallow))
        $max_books = $mallow['value'];
    }
    $cout_book = Book_Model_Book::getCountBook($this->viewer);

    if($max_books === '' || $cout_book < $max_books):
        echo $this->form->render($this);
    else: ?>
    <div style="color: red; padding-left: 300px;">
        <?php echo $this->translate("Sorry! Maximum numbers of allowed book : "); echo $max_books; echo " books" ; ?>
    </div>
<?php endif; ?>