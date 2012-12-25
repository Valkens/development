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
        <h3 class="header">Categories<a href="./add.php">Add new category</a></h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $pdo->prepare('SELECT * FROM category');
                $stmt->execute();
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr>';
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['category']}</td>";
                    echo '<td>';
                    echo "<a href='./edit.php?id={$row['id']}'>Edit</a>";
                    echo " | <a href='./delete.php?id={$row['id']}' class='action-delete'>Delete</a>";
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
