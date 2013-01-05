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

<div class='global_form'>
    <form method="post" class="global_form" action="<?php echo $this->url() ?>">
        <div>
            <div>
                <h3>
                    <?php echo $this->translate('Delete this book ?');?>
                </h3>
                <p>
                    <?php echo $this->translate('Are you sure that you want to delete this book with the title "%1$s" lIt will not be recoverable after being deleted.', $this->book->title); ?>
                </p>
                <br />
                <p>
                    <input type="hidden" name="confirm" value="true"/>
                    <button type='submit'><?php echo $this->translate('Delete');?></button>
                    <?php echo $this->translate('or');?> <a href='<?php echo $this->url(array('action' => 'manage'), 'book_general', true) ?>'><?php echo $this->translate('cancel');?></a>
                </p>
            </div>
        </div>
    </form>
</div>