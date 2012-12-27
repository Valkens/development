<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location: ../../login.php');
    exit();
}
include '../../include/function.php';
include('../header.php');
?>

<div id="main-content" class="pull-left">
    <div class="list-box">
        <h3 class="header">Summary</h3>
        <table class="data-table">
            <thead>
            <tr>
                <th>Best buy deal</th>
                <th>Best revenue deal</th>
                <th>Best saving deal</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <?php
                    $db = connectDb();
                    $sql = 'SELECT * FROM deals where id=(SELECT id_deal FROM purchases GROUP BY id_deal ORDER BY COUNT(id) DESC LIMIT 1)';
                    $query = $db->query($sql);
                    if ($row = $query->fetch()) {
                        echo "<a href='../deals/edit.php?id={$row['id']}'>{$row['name']}</a>";
                    }
                    ?>
                </td>
                <td>
                    <?php
                    $sql = 'SELECT * FROM deals where id=(SELECT id_deal FROM purchases GROUP BY id_deal ORDER BY SUM(total_charge) DESC LIMIT 1)';
                    $query = $db->query($sql);
                    if ($row = $query->fetch()) {
                        echo "<a href='../deals/edit.php?id={$row['id']}'>{$row['name']}</a>";
                    }
                    ?>
                </td>
                <td>
                    <?php
                    $sql = 'SELECT * FROM deals ORDER BY saving DESC LIMIT 1';
                    $query = $db->query($sql);
                    if ($row = $query->fetch()) {
                        echo "<a href='../deals/edit.php?id={$row['id']}'>{$row['name']}</a>";
                    }
                    ?>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <br class="clear" />
</div>

<?php include('../footer.php'); ?>
