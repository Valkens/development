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
<script type="text/javascript">
    en4.core.runonce.add(function(){$$('th.admin_table_short input[type=checkbox]').addEvent('click', function(){ $$('td.delete_books input[type=checkbox]').set('checked', $(this).get('checked', false)); })});

    var delectSelected = function(){
        var checkboxes = $$('td.delete_books input[type=checkbox]');
        var selecteditems = [];

        checkboxes.each(function(item, index){
            var checked = item.get('checked', false);
            var value = item.get('value', false);
            if (checked == true && value != 'on'){
                selecteditems.push(value);
            }
        });

        $('ids').value = selecteditems;
        //$('delete_selected').submit();
    }
</script>
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
        <th class='admin_table_short'><input type='checkbox' class='checkbox' /></th>
        <th class='admin_table_short'>ID</th>
        <th><?php echo $this->translate("Title") ?></th>
        <th><?php echo $this->translate("Owner") ?></th>
        <th><?php echo $this->translate("Date") ?></th>
        <th><?php echo $this->translate("Options") ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($this->paginator as $item): ?>
    <tr>
        <td class="delete_books"><input type='checkbox' class='checkbox' value="<?php echo $item->book_id ?>"/></td>
        <td><?php echo $item->getIdentity() ?></td>
        <td><?php echo $item->getTitle() ?></td>
        <td><?php echo $item->getOwner()->getTitle() ?></td>
        <td><?php echo $this->locale()->toDateTime($item->posted_date) ?></td>
        <td>
            <?php echo $this->htmlLink($item->getHref(array('action' => 'view')), $this->translate('view')); ?>
            |
            <?php echo $this->htmlLink(
            array('route' => 'admin_default', 'module' => 'book', 'controller' => 'manage', 'action' => 'edit', 'id' => $item->book_id),
            $this->translate('edit'),
            array('class' => 'smoothbox')); ?>
            |
            <?php echo $this->htmlLink(
            array('route' => 'admin_default', 'module' => 'book', 'controller' => 'manage', 'action' => 'delete', 'id' => $item->book_id),
            $this->translate('delete'),
            array('class' => 'smoothbox')); ?>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<br />

<div class='buttons'>
    <button onclick="javascript:delectSelected();" type='submit'>
        <?php echo $this->translate("Delete Selected") ?>
    </button>
</div>

<form id='delete_selected' method='post' action="<?php echo $this->url(array('module' => 'book', 'controller' => 'manage', 'action' =>'deleteselected'), null, true) ?>">
<input type="hidden" id="ids" name="ids" value=""/>
</form>
<br/>
<div>
    <?php echo $this->paginationControl($this->paginator); ?>
</div>

<?php else: ?>
<div class="tip">
    <span>
      <?php echo $this->translate("There are no book by your members yet.") ?>
    </span>
</div>
<?php endif; ?>