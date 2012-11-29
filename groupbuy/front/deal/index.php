<div id="contents">
    <div id="main">
        <div>
            <?php
            $stmt = $conn->prepare('SELECT * FROM deals WHERE id=:id');
            $stmt->execute(array('id' => $_GET['did']));
            $deal = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>
            <h4><span>Deal: '<?php echo $deal['name'];?>'</span></h4>
            <div id="deal">
                <?php
                    echo "<img src='./{$deal['summary_image']}' width='230' height='160'>";
                    echo '<h3>Conditions: </h3>';
                    echo "<p class='condition'>{$deal['conditions']}</p>";
                ?>
                <h3>Detailed images: </h3>
                <div class="list-image">
                    <?php
                        for ($i = 1; $i <= 4; $i++) {
                            $img = $deal['image' . $i];
                            if ($img != '') {
                                echo "<img src='$img' />";
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
        <br class="clear" />
    </div>
</div>