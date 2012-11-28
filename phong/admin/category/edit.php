<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location: ../user/login.php');
    exit();
}

include('../../libs/config.php');
include('../../libs/db.php');
include('../template/header.php');

$conn = dbConnect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if (isset($_POST['submit'])) {
    if (trim($_POST['name']) != '') {
        $stmt = $conn->prepare('UPDATE categories SET name = :name WHERE id = :id');
        $stmt->execute(array(
            'id'   => $_GET['id'],
            'name' => trim($_POST['name'])
        ));

        header('location: ./');
    }
} else {
    $stmt = $conn->prepare('SELECT * FROM categories WHERE id = :id');
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
                    <input type="text" id="category-name" name="name" value="<?php if (isset($category)) echo $category['name'];?>" />
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

<?php include('../template/footer.php'); ?>
