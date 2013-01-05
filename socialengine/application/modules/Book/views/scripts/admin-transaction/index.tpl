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

<br />
<?php if( count($this->paginator) ): ?>

<table class='admin_table'>
    <thead>
    <tr>
        <th class='admin_table_short'>ID</th>
        <th><?php echo $this->translate("Amount") ?></th>
        <th><?php echo $this->translate("Total") ?></th>
        <th><?php echo $this->translate("Datetime") ?></th>
        <th><?php echo $this->translate("Options") ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($this->paginator as $item): ?>
    <tr>
        <td><?php echo $item->order_id;?></td>
        <td><?php echo $item->count;?></td>
        <td><?php echo $item->total;?></td>
        <td><?php echo $item->date;?></td>
        <td>
            <?php echo $this->htmlLink(
            array('route' => 'admin_default', 'module' => 'book', 'controller' => 'transaction', 'action' => 'view', 'id' => $item->order_id),
            $this->translate('View')); ?>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<br />

<br/>
<div>
    <?php echo $this->paginationControl($this->paginator); ?>
</div>

<?php else: ?>
<div class="tip">
    <span>
      <?php echo $this->translate("There are no transactions by your members yet.") ?>
    </span>
</div>
<?php endif; ?>