<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location: ../user/login.php');
    exit();
}

include('../../libs/config.php');
include('../../libs/db.php');
include('../template/header.php');

if (isset($_POST['submit'])) {
    if (trim($_POST['name']) != '') {
        $conn = dbConnect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $stmt = $conn->prepare('INSERT INTO categories (name) VALUES(:name)');
        $stmt->execute(array(
            'name' => trim($_POST['name'])
        ));
        if ($stmt->rowCount()) {
            header('location: ./');
        }
    }
}
?>

<div id="main-content" class="pull-left">
    <div class="list-box">
        <h3 class="header">Add new category</h3>
        <form action="" method="POST">
            <div class="control-group">
                <label>Name (*)</label>
                <div class="controls">
                    <input type="text" id="category-name" name="name" />
                </div>
            </div>

            <div class="form-actions">
                <input type="submit" name="submit" value="Submit" />
                | <a href="./">Cancel</a>
            </div>
        </form>
    </div>
    <br class="clear" />
</div>
<script type="text/javascript">
    $(function(){
        $('form').submit(function(){
            if ($.trim($('#category-name').val()) == '') {
                alert('Please enter category name');
                return false;
            }
        });
    });
</script>

<?php include('../template/footer.php'); ?>
