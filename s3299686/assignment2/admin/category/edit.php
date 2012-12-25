<?php
session_start();
if (!isset($_SESSION['username']) == 'admin') {
    header('location: ../../login.php');
    exit();
}

include('../../pdo.php');
include('../header.php');

if (isset($_POST['submit'])) {
    if (trim($_POST['name']) != '') {
        $stmt = $pdo->prepare('UPDATE category SET category = :name WHERE id = :id');
        $stmt->execute(array(
            'id'   => $_GET['id'],
            'name' => trim($_POST['name'])
        ));

        header('location: ./');
    }
} else {
    $stmt = $pdo->prepare('SELECT * FROM category WHERE id = :id');
    $stmt->execute(array(
        ':id'   => $_GET['id'],
    ));
    if ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $category = $result;
    }
}
?>

<div id="main-content" class="pull-left">
    <div class="list-box">
        <h3 class="header">Edit category</h3>
        <form action="" method="POST">
            <div class="control-group">
                <label>Name (*)</label>
                <div class="controls">
                    <input type="text" id="category-name" name="name" value="<?php if (isset($category)) echo $category['category'];?>" />
                </div>
            </div>

            <div class="form-actions">
                <input type="submit" name="submit" value="Update" />
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
