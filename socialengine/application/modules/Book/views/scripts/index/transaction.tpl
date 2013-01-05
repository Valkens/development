<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Book
 * @copyright  Copyright 2012 Younet Developments
 * @license    http://www.socialengine.net/license/
 * @version    $Id: Checkout.tpl SE-1488 duclh $
 * @author     duclh
 */
?>

<style>
    #cart table{
        border: 1px solid #F1F1F1;
    }
    #cart table th {
        padding: 5px;
        text-align: center;
        border-left: 1px solid #F1F1F1;
    }
    #cart table td{
        padding: 5px;
        border: 1px solid #F1F1F1;
    }
    #cart table td button{
        font-size: 0.7em !important;
    }
</style>

<div class="headline">
    <h2>
        <?php echo $this->translate('Cart review');?>
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

<div id="cart">
    <?php if (!isset($this->orders)) : ?>
    <h4>You don't have any transaction.</h4>
    <?php else : ?>
        <table>
            <thead>
            <tr>
                <th>Order</th>
                <th>Amount</th>
                <th>Total</th>
                <th>Datetime</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($this->orders as $order) : ?>
                <tr>
                <td><a href="<?php echo $this->url(array('id'=> $order->order_id), 'book_transaction');?>">#<?php echo $order->order_id;?></a></td>
                <td><?php echo $order->count;?></td>
                <td><?php echo $order->total;?>$</td>
                <td><?php echo $order->date;?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif ;?>
</div>