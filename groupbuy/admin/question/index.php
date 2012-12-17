<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location: ../user/login.php');
    exit();
}

include('../../libs/config.php');
include('../../libs/db.php');
include('../../libs/function.php');
include('../template/header.php');
?>

<div id="main-content" class="pull-left">
    <div class="list-box">
        <h3 class="header">Question list</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Deal</th>
                    <th>Customer</th>
                    <th>Content</th>
                    <th>Answer</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $conn = dbConnect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

                // Get all category
                $stmt = $conn->prepare('SELECT q.id as q_id,c.fullname,c.id as c_id,d.name as d_name,d.id as d_id,q.content,q.answer
                                        FROM questions as q
                                        JOIN deals as d ON q.id_deal=d.id
                                        JOIN customers as c ON q.id_customer=c.id  ORDER BY q.id DESC');
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $stmt->execute();

                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr>';
                    echo "<td>{$row['q_id']}</td>";
                    echo '<td><a href="../deal/edit.php?id='.$row['d_id'].'">' . substring(htmlspecialchars($row['d_name']), 60) . '</a></td>';
                    echo '<td><a href="../customer/edit.php?id='.$row['c_id'].'">' . htmlspecialchars($row['fullname']) . '</a></td>';
                    echo '<td>' . substring(htmlspecialchars($row['content']), 60) . '</td>';
                    echo '<td>' . ($row['answer'] ? substring(htmlspecialchars($row['answer']), 60) : '[No answer]') . '</td>';
                    echo '<td>';
                    echo "<a href='./edit.php?id={$row['q_id']}'>Edit</a><br />";
                    echo "<a href='./delete.php?id={$row['q_id']}' class='action-delete'>Delete</a>";
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
