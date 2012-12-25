<?php
session_start();
include 'include/function.php';

$db = connectDb();
?>

<?php include 'public/header.php';?>

<div id="main">
    <div id="sidebar" class="float_l">
        <?php include 'public/categories.php';?>
    </div>
    <div id="content" class="float_r">
        <h1>Deals</h1>
        <?php
        $sql = 'SELECT * FROM deals WHERE status=1 ORDER BY id DESC';
        $result = $db->query($sql);
        $deals = $result->fetchAll(PDO::FETCH_ASSOC);
        foreach ($deals as $deal) {
        ?>
        <div class="product_box">
            <a href="cate.php?id=<?php echo $deal['id'];?>"><img src="<?php echo $deal['image'];?>" width="200" height="150" /></a>
            <h3><?php echo $deal['name'];?></h3>
            <p class="product_price">$ <?php echo $deal['group_buy_price'];?></p>
            <a href="#" class="add_to_card">Buy</a>
            <a href="deal-detail.php?id=<?php echo $deal['id'];?>" class="detail">Detail</a>
        </div>
        <?php } ?>
    </div>
    <div class="cleaner"></div>
</div>

<?php include 'public/bottom.php';