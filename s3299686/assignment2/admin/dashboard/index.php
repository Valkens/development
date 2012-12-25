<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location: ../../login.php');
    exit();
}

include('../../pdo.php');
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
                        $sql = 'SELECT * FROM deal where dealid=(SELECT id FROM purchase GROUP BY dealid ORDER BY COUNT(*) DESC LIMIT 1)';
                        $query = $pdo->query($sql);
                        if ($row = $query->fetch()) {
                            echo "<a href='../deal/edit.php?id={$row['dealid']}'>{$row['dealname']}</a>";
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        $sql = 'SELECT * FROM deal where dealid=(SELECT id FROM purchase GROUP BY dealid ORDER BY SUM(totalcharge) DESC LIMIT 1)';
                        $query = $pdo->query($sql);
                        if ($row = $query->fetch()) {
                            echo "<a href='../deal/edit.php?id={$row['dealid']}'>{$row['dealname']}</a>";
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        $sql = 'SELECT * FROM deal ORDER BY saving DESC LIMIT 1';
                        $query = $pdo->query($sql);
                        if ($row = $query->fetch()) {
                            echo "<a href='../deal/edit.php?id={$row['dealid']}'>{$row['dealname']}</a>";
                        }
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php include('../footer.php'); ?>
