<?php
    if (isset($_POST['submit'])) {
        if ($_POST['question_content']) {
            $stmt = $conn->prepare('INSERT INTO questions (id_customer,id_deal,content) VALUES(:id_customer,:id_deal,:content)');
            $stmt->execute(array(
                'id_customer' => $_SESSION['customer']['id'],
                'id_deal' => (int) $_GET['did'],
                'content' => $_POST['question_content']
            ));
        }
    }
?>
<link rel="stylesheet" href="./public/js/slider/bjqs.css" />
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
                    if (strtotime($deal['expired_time']) > time()) {
                        echo '<a href="./?m=deal&a=cart&did='.$_GET['did'].'" style="display:block;margin-bottom:10px"';
                        echo (!isset($_SESSION['customer'])) ? ' onclick="alert(\'Please login\');return false;"' : '';
                        echo '><img src="./public/images/buy_ico.png">';
                        echo '</a>';
                    }
                    echo '<h3>Conditions: </h3>';
                    echo "<p class='condition'>{$deal['conditions']}</p>";
                ?>
                <h3>Detailed images: </h3>
                <div class="list-image">
                    <ul class="bjqs">
                        <?php
                        for ($i = 1; $i <= 4; $i++) {
                            $img = $deal['image' . $i];
                            if ($img != '') {
                                echo "<li><img src='$img' /></li>";
                            }
                        }
                        ?>
                    </ul>
                </div>
                <br class="clear" />
            </div>
            <br class="clear" />
        </div>
        <br class="clear" />
        <hr />
        <form id="question-form" action="" method="post">
            <label style="float:left;margin-right:10px">Question: </label>
            <textarea name="question_content" cols="45" rows="6"></textarea>
            <br />
            <input type="submit" name="submit" value="Post" />
        </form>
        <div id="questions-list">
            <?php
            $stmt = $conn->prepare('SELECT * FROM questions JOIN customers ON questions.id_customer=customers.id WHERE id_deal=:id');
            $stmt->execute(array('id' => $_GET['did']));

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<div class="question">';
                echo '<span class="fullname">' . htmlspecialchars($row['fullname']) . ' : </span>';
                echo htmlspecialchars($row['content']);
                if ($row['answer']) {
                    echo '<div class="answer"><span style="text-decoration:underline">Answer</span> : ';
                    echo htmlspecialchars($row['answer']);
                    echo '</div>';
                }
                echo '</div>';
            }
            ?>
        </div>
        <br class="clear" />
    </div>
</div>
<script type="text/javascript" src="./public/js/slider/js/bjqs-1.3.min.js"></script>
<script type="text/javascript">
    $(function(){
        $('#question-form').submit(function(){
        <?php if (!isset($_SESSION['customer'])) { ?>
            alert('Please login');
            return false;
            <?php } ?>
            if ($.trim($('#question-form textarea[name=question_content]').val()) == '') {
                alert('Please enter question content');
                return false;
            }
        });

        $('.list-image').bjqs({
            height      : 320,
            width       : 620,
            responsive  : true
        });
    });
</script>