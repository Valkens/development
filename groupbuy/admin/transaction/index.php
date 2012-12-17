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

<link rel="stylesheet" media="all" type="text/css" href="../../public/js/jquery-ui/css/ui-lightness/jquery-ui-1.9.2.custom.min.css" />
<style>
    .ui-datepicker {font-size:12px;}
</style>
<div id="main-content" class="pull-left">
    <div class="list-box">
        <h3 class="header">Transaction list</h3>
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
                $conn = dbConnect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
                $sql = 'SELECT t.id as t_id,c.fullname,t.quantity,t.total_charge,t.id_deal,t.id_customer,d.name as d_name
                                        FROM transactions as t
                                        JOIN customers as c ON t.id_customer=c.id
                                        JOIN deals as d ON t.id_deal=d.id';

                if (isset($_POST['filter'])
                    && $_POST['from']
                    && $_POST['to']
                ) {
                    $sql .= " WHERE timestamp BETWEEN '{$_POST['from']}' AND '{$_POST['to']}'";
                }

                $sql .= ' ORDER BY t.id DESC';
                $stmt = $conn->prepare($sql);
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $stmt->execute();

                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr>';
                    echo "<td>{$row['t_id']}</td>";
                    echo '<td><a href="../deal/edit.php?id='.$row['id_deal'].'">' . substring(htmlspecialchars($row['d_name']), 60) . '</a></td>';
                    echo '<td><a href="../customer/edit.php?id='.$row['id_customer'].'">' . htmlspecialchars($row['fullname']) . '</a></td>';
                    echo "<td>{$row['quantity']}</td>";
                    echo "<td>{$row['total_charge']}$</td>";
                    echo '<td>';
                    echo "<a href='./view.php?id={$row['t_id']}'>View</a><br />";
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
<?php include('../template/footer.php'); ?>
