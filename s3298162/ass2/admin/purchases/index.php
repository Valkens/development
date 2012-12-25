<?php
session_start();
if (!isset($_SESSION['username']) == 'admin') {
    header('location: ../../login.php');
    exit();
}

include('../../include/function.php');
include('../header.php');
?>

<link rel="stylesheet" media="all" type="text/css" href="../../public/js/jquery-ui/css/ui-lightness/jquery-ui-1.9.2.custom.min.css" />
<style>
    .ui-datepicker {font-size:12px;}
</style>
<div id="main-content" class="pull-left">
    <div class="list-box">
        <h3 class="header">List purchase</h3>
        <form action="" method="post">
            <p style="padding:5px">
                <label>From: </label><input type="text" name="from" style="width:100px" class="datepicker" />
                <label>To: </label><input type="text" name="to" style="width:100px" class="datepicker" />
                <input type="submit" name="filter" value="Filter" />
            </p>
        </form>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Deal</th>
                    <th>User</th>
                    <th>Quantity</th>
                    <th>Total charge</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $db = connectDb();
                $sql = 'SELECT p.id as p_id,u.username,p.quantity,p.total_charge,p.id_deal,p.id_user,d.name as d_name
                                        FROM purchases as p
                                        JOIN users as u ON p.id_user=u.id
                                        JOIN deals as d ON p.id_deal=d.id';

                if (isset($_POST['filter'])
                    && $_POST['from']
                    && $_POST['to']
                ) {
                    $sql .= " WHERE createtime BETWEEN '{$_POST['from']}' AND '{$_POST['to']}'";
                }

                $sql .= ' ORDER BY p.id DESC';
                $stmt = $db->prepare($sql);
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $stmt->execute();

                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr>';
                    echo "<td>{$row['p_id']}</td>";
                    echo '<td><a href="../deals/edit.php?id='.$row['id_deal'].'">' . htmlspecialchars($row['d_name']) . '</a></td>';
                    echo '<td><a href="../users/edit.php?id='.$row['id_user'].'">' . htmlspecialchars($row['username']) . '</a></td>';
                    echo "<td>{$row['quantity']}</td>";
                    echo "<td>{$row['total_charge']}$</td>";
                    echo '<td>';
                    echo "<a href='./view.php?id={$row['p_id']}'>View</a> | ";
                    echo "<a href='./delete.php?id={$row['p_id']}' class='action-delete'>Delete</a><br />";
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <br class="clear" />
</div>

<script type="text/javascript" src="../../public/js/jquery-ui/js/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript">
    $(function(){
        $('.action-delete').click(function(e){
            e.preventDefault();
            if (confirm("Are you sure you want to delete?")) {
                document.location = $(this).attr('href');
            }
        });

        $('.datepicker').datepicker({dateFormat: 'yy-mm-dd'});
    });
</script>
<?php include('../footer.php'); ?>
