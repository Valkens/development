<?php
session_start();
if (!isset($_SESSION['username']) == 'admin') {
    header('location: ../../login.php');
    exit();
}

include('../../pdo.php');
include('../header.php');
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
                $stmt = $pdo->prepare('SELECT * FROM category');
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $stmt->execute();
                $list_category = $stmt->fetchAll();

                $stmt = $pdo->prepare('SELECT * FROM deal ORDER BY dealid DESC');
                $stmt->execute();
                while($row = $stmt->fetch()) {
                    $row['category'] = current(array_filter($list_category, create_function('$val', 'return $val["id"]==' . $row['categoryid'] . ';')));

                    echo '<tr>';
                    echo "<td>{$row['dealid']}</td>";
                    echo "<td>{$row['dealname']}</td>";
                    echo "<td>{$row['category']['category']}</td>";
                    echo '<td><image src="../../' . (($row['img']) ? $row['img'] : '') . '" width="80" height="80" /></td>';
                    echo "<td>{$row['olprice']}$</td>";
                    echo "<td>{$row['price']}$</td>";
                    echo '<td>' . (($row['status']==0) ? '<font color="red">Inactive</font>' : '<font color="green">Active</font>') . '</td>';
                    echo '<td>';
                    echo "<a href='./edit.php?id={$row['dealid']}'>Edit</a><br />";
                    echo "<a href='./delete.php?id={$row['dealid']}' class='action-delete'>Delete</a>";
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
