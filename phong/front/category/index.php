<div id="contents">
    <div id="main">
        <div>
            <?php
            $cateInfo = current(array_filter($categories, create_function('$val', 'return $val["id"]==' . $_GET['cid'] . ';')));
            ?>
            <h4><span>All deals of '<?php echo $cateInfo['name'];?>' category</span></h4>
            <div class="items">
                <?php
                $stmt = $conn->prepare('SELECT * FROM deals WHERE id_category=:id');
                $stmt->execute(array('id' => $_GET['cid']));
                while($deal = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<div class="item">';
                    echo "<img src='./{$deal['summary_image']}' width='230' height='160'>";
                    echo "<p class='name'>{$deal['name']}</p>";
                    echo "<p><span>Description:</span> {$deal['description']}</p>";
                    echo "<p><span>Original price:</span> {$deal['original_price']}$</p>";
                    echo "<p><span>Group buy price:</span> {$deal['group_buy_price']}$</p>";
                    echo "<p><span>Current buyers:</span> {$deal['buyers']}</p>";
                    $now = new DateTime();
                    $ref = new DateTime($deal['expired_time']);
                    $diff = $now->diff($ref);
                    echo '<p><span>Time left to buy: </span>';
                    printf('%d days, %d hours, %d minutes', $diff->d, $diff->h, $diff->i);
                    echo '</p>';
                    echo '<p><span>Status: </span>' . (($deal['status'] == 0) ? 'Active' : 'Sold out') . '</p>';
                    echo "<a href='./?m=deal&did={$deal['id']}'>View more</a>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
        <br class="clear" />
    </div>
</div>