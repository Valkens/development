<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location: ../user/login.php');
    exit();
}

include('../../libs/config.php');
include('../../libs/db.php');
include('../template/header.php');
?>

<div id="main-content" class="pull-left">
    <div class="list-box">
        <h3 class="header">Deal list <a href="./add.php">Add new</a></h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Original Price</th>
                    <th>Group buy price</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $conn = dbConnect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

                // Get all category
                $stmt = $conn->prepare('SELECT * FROM categories');
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $stmt->execute();
                $categories = $stmt->fetchAll();

                $stmt = $conn->prepare('SELECT * FROM deals');
                $stmt->execute();
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $row['category'] = current(array_filter($categories, create_function('$val', 'return $val["id"]==' . $row['id_category'] . ';')));

                    echo '<tr>';
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['name']}</td>";
                    echo "<td>{$row['category']['name']}</td>";
                    echo '<td><image src="../../' . (($row['summary_image']) ? $row['summary_image'] : 'public/images/no_image.png') . '" width="80" height="80" /></td>';
                    echo "<td>{$row['original_price']}$</td>";
                    echo "<td>{$row['group_buy_price']}$</td>";
                    echo '<td>' . (($row['status']==0) ? '<font color="red">[Inactive]</font>' : '<font color="green">[Active]</font>') . '</td>';
                    echo '<td>';
                    echo "<a href='./edit.php?id={$row['id']}'>Edit</a><br />";
                    echo "<a href='./delete.php?id={$row['id']}' class='action-delete'>Delete</a>";
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <br class="clear" />
</div>

<script type="text/javascript">
    $(function(){
        $('.action-delete').click(function(e){
            e.preventDefault();
            if (confirm("Are you sure you want to delete?")) {
                document.location = $(this).attr('href');
            }
        });


    });
</script>
<?php include('../template/footer.php'); ?>
