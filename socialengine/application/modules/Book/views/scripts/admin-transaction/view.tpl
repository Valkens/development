<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Book
 * @copyright  Copyright 2012 Younet Developments
 * @license    http://www.socialengine.net/license/
 * @version    $Id: Index.tpl SE-1488 duclh $
 * @author     duclh
 */
?>
<h2>
    <?php echo $this->translate('Books Plugin') ?>
</h2>

<?php if( count($this->navigation) ): ?>
<div class='tabs'>
    <?php
      // Render the menu
      //->setUlClass()
    echo $this->navigation()->menu()->setContainer($this->navigation)->render()
    ?>
</div>
<?php endif; ?>

<table class='admin_table'>
    <thead>
    <tr>
        <th>Book</th>
        <th><?php echo $this->translate("Quantity") ?></th>
        <th><?php echo $this->translate("Total") ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($this->orders as $order) : ?>
    <tr>
        <td><a href="<?php echo $this->url(array('action' => 'view', 'book_id'=> $order->book_id), 'book_specific');?>"><?php echo $order->title;?></a></td>
        <td><?php echo $order->quantity;?></td>
        <td><?php echo ($order->quantity * $order->price);?>$</td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<br />