<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Book
 * @copyright  Copyright 2012 Younet Developments
 * @license    http://www.socialengine.net/license/
 * @version    $Id: Cart.tpl SE-1488 duclh $
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
        <?php echo $this->translate('Your book cart');?>
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
    <form action="" method="post">
        <table>
            <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Amount</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($this->listBook as $book) :
                $bookTotalPrice = $this->cartSession->list[$book->book_id]['quantity'] * $book->price;
                $orderTotal += $bookTotalPrice;
            ?>
                <tr>
                    <td><?php echo $this->escape($book->getTitle());?></td>
                    <td><?php echo $book->price;?>$</td>
                    <td>
                        <select name="quantity[<?php echo $book->book_id;?>]">
                        <?php
                            for ($i = 1; $i <= 10; $i++) {
                                $selected = ($this->cartSession->list[$book->book_id]['quantity'] == $i) ? ' selected="selected"' : '';
                                echo "<option value=\"$i\"$selected>$i</option>";
                            }
                        ?>
                        </select>
                    </td>
                    <td style="text-align: right"><?php echo $bookTotalPrice;?>$</td>
                    <td><button type="submit" name="delete" value="<?php echo $book->book_id;?>">Delete</button></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
            <tr>
                <td>Order total: <?php echo $orderTotal;?>$</td>
                <td colspan="4">
                    <button type="submit" name="submit" value="clear">Clear</button>
                    <button type="submit" name="submit" value="update">Update</button>
                    <a href="<?php echo $this->url(array('route' => 'book_general', 'action' => 'index'));?>"><button type="button">Continue</button></a>
                    <a href="<?php echo $this->url(array('route' => 'book_general', 'action' => 'checkout'));?>"><button type="button">Checkout</button></a>
                </td>
            </tr>
            </tfoot>
        </table>
    </form>
    <?php endif ;?>
</div>