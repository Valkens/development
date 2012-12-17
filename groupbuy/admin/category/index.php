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
        <h3 class="header">Category list <a href="./add.php">Add new</a></h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $conn = dbConnect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
                $stmt = $conn->prepare('SELECT * FROM categories');
                $stmt->execute();
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr>';
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['name']}</td>";
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
            if (confirm("Are you sure you want to delete?\nDeleting this category will delete all deals assigned to it !")) {
                document.location = $(this).attr('href');
            }
        });
    });
</script>
<?php include('../template/footer.php'); ?>
