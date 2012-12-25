<?php
session_start();
include 'include/function.php';

$db = connectDb();
$id = (int)$_GET['id'];
$sql = "SELECT * FROM deals WHERE id=$id";
$result = $db->query($sql);
$deal = $result->fetch(PDO::FETCH_ASSOC);
?>

<?php include 'public/header.php';?>
    <div id="main">
        <div id="sidebar" class="float_l">
            <?php include 'public/categories.php';?>
        </div>
        <div id="content" class="float_r">

            <h1><?php echo $deal['name'];?></h1>
            <div class="content_half float_l">
                <img src="<?php echo $deal['image'];?>" width="200" height="150" />
            </div>
            <div class="content_half float_r">
                <table style="color:#666">
                    <tr>
                        <td height="30" width="160">Origin price:</td>
                        <td><?php echo $deal['original_price'];?>$</td>
                    </tr>
                    <tr>
                        <td height="30" width="160">Price:</td>
                        <td><?php echo $deal['group_buy_price'];?>$</td>
                    </tr>
                    <tr>
                        <td height="30" width="160">Saving percent:</td>
                        <td><?php echo $deal['saving'];?>%</td>
                    </tr>
                    <tr>
                        <td height="30" width="160">Expired time:</td>
                        <td><?php echo $deal['expired_time'];?></td>
                    </tr>
                    <tr>
                        <td height="30">Availability:</td>
                        <td><?php echo ($deal['status']) ? 'Active' : 'Sold out';?></td>
                    </tr>
                    <tr>
                        <td height="30">Description:</td>
                        <td><?php echo $deal['description'];?></td>
                    </tr>
                </table>
                <div class="cleaner h20"></div>
                <a href="buy.php?id=<?php echo $_GET['id'];?>" class="add_to_card">Buy</a>
            </div>
            <div class="cleaner h30"></div>

            <h5 style="text-decoration:underline">Conditions</h5>
            <p><?php echo $deal['conditions'];?></p>

            <div class="cleaner h20"></div>

             <h5 style="text-decoration:underline">Questions</h5>
            <form id="form_question" action="" method="post">
                <label style="float:left;margin-right:10px">Question: </label>
                <textarea name="content" cols="45" rows="6"></textarea>
                <br />
                <input type="submit" name="submit" value="Post" />
            </form>
            <div class="cleaner h20"></div>
            <div id="questions-list">
                <?php
                if (isset($_POST['submit'])) {
                    if ($_POST['content']) {
                        $stmt = $db->prepare('INSERT INTO questions (id_user,id_deal,content) VALUES(:id_user,:id_deal,:content)');
                        $stmt->execute(array(
                            'id_user' => $_SESSION['userid'],
                            'id_deal' => (int) $_GET['id'],
                            'content' => $_POST['content']
                        ));
                    }
                }

                $stmt = $db->prepare('SELECT * FROM questions JOIN users ON questions.id_user=users.id WHERE id_deal=:id');
                $stmt->execute(array('id' => $_GET['id']));

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<div class="question">';
                    echo '<span class="fullname">' . htmlspecialchars($row['username']) . ' : </span>';
                    echo htmlspecialchars($row['content']);
                    if ($row['answer']) {
                        echo '<div class="answer"><span style="text-decoration:underline">Answer</span> : ';
                        echo htmlspecialchars($row['answer']);
                        echo '</div>';
                    }
                    echo '</div>';
                    echo '<div class="cleaner h20"></div>';
                }
                ?>
            </div>

            <div class="cleaner h50"></div>

        </div>
        <div class="cleaner"></div>
    </div>

<?php include 'public/bottom.php';