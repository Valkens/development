<?php
session_start();
if (!isset($_SESSION['username']) == 'admin') {
    header('location: ../../login.php');
    exit();
}

include('../../include/function.php');
include('../header.php');

if (isset($_POST['submit'])) {
    if (trim($_POST['name']) != '') {
        $db = connectDb();
        $stmt = $db->prepare('INSERT INTO categories (categoryname) VALUES(:name)');
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

<?php include('../footer.php'); ?>
