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
        <h3 class="header">List question</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Deal</th>
                    <th>User</th>
                    <th>Content</th>
                    <th>Answer</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $db = connectDb();
                $stmt = $db->prepare('SELECT q.id as q_id,u.username,u.id as u_id,d.name as d_name,d.id as d_id,q.content,q.answer
                                        FROM questions as q
                                        JOIN deals as d ON q.id_deal=d.id
                                        JOIN users as u ON q.id_user=u.id  ORDER BY q.id DESC');
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $stmt->execute();

                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr>';
                    echo "<td>{$row['q_id']}</td>";
                    echo '<td><a href="../deal/edit.php?id='.$row['d_id'].'">' . htmlspecialchars($row['d_name']) . '</a></td>';
                    echo '<td><a href="../user/edit.php?id='.$row['u_id'].'">' . htmlspecialchars($row['username']) . '</a></td>';
                    echo '<td>' . htmlspecialchars($row['content']) . '</td>';
                    echo '<td>' . ($row['answer'] ? htmlspecialchars($row['answer']) : 'No answer') . '</td>';
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
