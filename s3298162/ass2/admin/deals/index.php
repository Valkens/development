<?php
session_start();
if (!isset($_SESSION['username']) == 'admin') {
    header('location: ../../login.php');
    exit();
}

include('../../include/function.php');
include('../header.php');
?>

<div id="main-content" class="pull-left">
    <div class="list-box">
        <h3 class="header">List deal <a href="./add.php">Add new deal</a></h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Id</th>
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
                $db = connectDb();

                // Get all category
                $stmt = $db->prepare('SELECT * FROM categories');
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $stmt->execute();
                $categories = $stmt->fetchAll();

                $stmt = $db->prepare('SELECT * FROM deals ORDER BY id DESC');
                $stmt->execute();
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $row['category'] = current(array_filter($categories, create_function('$val', 'return $val["id"]==' . $row['id_category'] . ';')));

                    echo '<tr>';
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['name']}</td>";
                    echo "<td>{$row['category']['categoryname']}</td>";
                    echo '<td><image src="../../' . (($row['image']) ? $row['image'] : '') . '" width="80" height="80" /></td>';
                    echo "<td>{$row['original_price']}$</td>";
                    echo "<td>{$row['group_buy_price']}$</td>";
                    echo '<td>' . (($row['status']==0) ? '<font color="red">Inactive</font>' : '<font color="green">[Active]</font>') . '</td>';
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
<?php include('../footer.php'); ?>
