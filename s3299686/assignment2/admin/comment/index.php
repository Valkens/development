<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location: ../login.php');
    exit();
}

include('../../pdo.php');
include('../header.php');
?>

<div id="main-content" class="pull-left">
    <div class="list-box">
        <h3 class="header">Comment list</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Deal</th>
                    <th>User</th>
                    <th>Content</th>
                    <th>Answer</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $pdo->prepare('SELECT q.id as q_id,u.username,u.userid as u_id,d.dealname as d_name,d.dealid as d_id,q.content,q.answer
                                        FROM comment as q
                                        JOIN deal as d ON q.dealid=d.dealid
                                        JOIN users as u ON q.userid=u.userid  ORDER BY q.id DESC');
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $stmt->execute();

                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr>';
                    echo "<td>{$row['q_id']}</td>";
                    echo '<td><a href="../deal/edit.php?id='.$row['d_id'].'">' . htmlspecialchars($row['d_name']) . '</a></td>';
                    echo '<td><a href="../user/edit.php?id='.$row['u_id'].'">' . htmlspecialchars($row['username']) . '</a></td>';
                    echo '<td>' . htmlspecialchars($row['content']) . '</td>';
                    echo '<td>' . ($row['answer'] ? htmlspecialchars($row['answer']) : '[No answer]') . '</td>';
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
<?php include('../footer.php'); ?>
