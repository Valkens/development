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
        <h3 class="header">Customer list</h3>
        <table class="data-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Fullname</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $conn = dbConnect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

            // Get all category
            $stmt = $conn->prepare('SELECT * FROM customers');
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>';
                echo "<td>{$row['id']}</td>";
                echo "<td>{$row['fullname']}</td>";
                echo "<td>{$row['email']}</td>";
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
