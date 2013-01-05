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
    <?php if (!isset($this->listBook)) : ?>
    <h4>Your book cart is empty</h4>
    <?php else : ?>
    <form name="paypal_form" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" enctype="application/x-www-form-urlencoded">
        <table>
            <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Amount</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($this->listBook as $k => $book) :
            $bookTotalPrice = $this->cartSession->list[$book->book_id]['quantity'] * $book->price;
            $orderTotal += $bookTotalPrice;
            $i = "_" . ($k + 1);
            ?>
            <tr>
                <td><?php echo $this->escape($book->getTitle());?></td>
                <td><?php echo $book->price;?>$</td>
                <td style="text-align: center"><?php echo $this->cartSession->list[$book->book_id]['quantity'];?></td>
                <td style="text-align: right"><?php echo $bookTotalPrice;?>$</td>
            </tr>
            <tr style="display:none">
                <input type="hidden" name="item_number<?php echo $i;?>" value="<?php echo $book->book_id;?>:<?php echo $this->viewer->getIdentity();?>" />
                <input type="hidden" name="item_name<?php echo $i;?>" value="<?php echo $book->getTitle();?>" />
                <input type="hidden" name="amount<?php echo $i;?>" value="<?php echo $book->price;?>" />
                <input type="hidden" name="quantity<?php echo $i;?>" value="<?php echo $this->cartSession->list[$book->book_id]['quantity'];?>" />
            </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
            <tr>
                <td>Order total: <?php echo $orderTotal;?>$</td>
                <td colspan="4">
                    <button type="submit" name="submit" value="update">Pay Now</button>
                    <a href="<?php echo $this->url(array('action' => 'cart'), 'book_general');?>"><button type="button">Back</button></a>
                </td>
            </tr>
            </tfoot>
        </table>
        <input type="hidden" name="cmd" value="_cart" />
        <input type="hidden" name="upload" value="1" />
        <input type="hidden" name="business" value="leduc_seller_1353120385_biz@gmail.com" />
        <input type="hidden" name="receiver" value="leduc_seller_1353120385_biz@gmail.com" />
        <input type="hidden" name="charset" value="utf-8" />
        <input type="hidden" name="currency_code" value="USD">
        <input type="hidden" name="return" value="http://<?php echo $_SERVER['SERVER_NAME'] . $this->url(array('action'=>'success'), 'book_payment');?>">
        <input type="hidden" name="notify_url" value="http://<?php echo $_SERVER['SERVER_NAME'] . $this->url(array('action'=>'notify'), 'book_payment');?>">
    </form>
    <?php endif ;?>
</div>