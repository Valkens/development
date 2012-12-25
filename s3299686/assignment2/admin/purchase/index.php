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
        <h3 class="header">Purchase list</h3>
        <form action="" method="post">
            <p style="padding:5px">
                <label>From: </label><input type="text" name="from" style="width:100px" class="datepicker" />
                <label>To: </label><input type="text" name="to" style="width:100px" class="datepicker" />
                <input type="submit" name="filter" value="Filter" />
                <input type="submit" name="ALL" value="All" />
            </p>
        </form>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Deal</th>
                    <th>Customer</th>
                    <th>Quantity</th>
                    <th>Total charge</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = 'SELECT p.id as p_id,u.username,p.quantity,p.totalcharge,p.dealid,p.userid,d.dealname as d_name
                                        FROM purchase as p
                                        JOIN users as u ON p.userid=u.userid
                                        JOIN deal as d ON p.dealid=d.dealid';

                if (isset($_POST['filter'])
                    && $_POST['from']
                    && $_POST['to']
                ) {
                    $sql .= " WHERE createtime BETWEEN '{$_POST['from']}' AND '{$_POST['to']}'";
                }

                $sql .= ' ORDER BY p.id DESC';
                $stmt = $pdo->prepare($sql);
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $stmt->execute();

                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr>';
                    echo "<td>{$row['p_id']}</td>";
                    echo '<td><a href="../deal/edit.php?id='.$row['dealid'].'">' . $row['d_name'] . '</a></td>';
                    echo '<td><a href="../customer/edit.php?id='.$row['userid'].'">' . htmlspecialchars($row['username']) . '</a></td>';
                    echo "<td>{$row['quantity']}</td>";
                    echo "<td>{$row['totalcharge']}$</td>";
                    echo '<td>';
                    echo "<a href='./view.php?id={$row['p_id']}'>View</a> | ";
                    echo "<a href='./delete.php?id={$row['p_id']}' class='action-delete'>Delete</a>";
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <br class="clear" />
</div>

<link rel="stylesheet" media="all" type="text/css" href="../../js/jquery-ui/css/ui-lightness/jquery-ui-1.9.2.custom.min.css" />
<link rel="stylesheet" media="all" type="text/css" href="../../js/jquery-timepicker/jquery-ui-timepicker-addon.css" />
<script type="text/javascript" src="../../js/jquery-ui/js/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" src="../../js/jquery-timepicker/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="../../js/jquery-timepicker/jquery-ui-sliderAccess.js"></script>
<style>
    .ui-datepicker {font-size:12px;}
</style>
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
