<?php
session_start();
if (!isset($_SESSION['username']) == 'admin') {
    header('location: ../../login.php');
    exit();
}

include('../../pdo.php');
include('../header.php');

if (isset($_POST['submit'])) {
    if (trim($_POST['content']) != '') {
        $stmt = $pdo->prepare('UPDATE comment SET content = :content,answer=:answer WHERE id = :id');
        $stmt->execute(array(
            'id'   => $_GET['id'],
            'content' => trim($_POST['content']),
            'answer' => trim($_POST['answer'])
        ));

        header('location: ./');
    }
} else {
    $stmt = $pdo->prepare('SELECT * FROM comment WHERE id = :id');
    $stmt->execute(array(
        ':id'   => $_GET['id'],
    ));
    if ($result = $stmt->fetch()) {
        $comment = $result;
    }
}
?>

<div id="main-content" class="pull-left">
    <div class="list-box">
        <h3 class="header">Edit comment</h3>
        <form action="" method="POST">
            <div class="control-group">
                <label>Content (*)</label>
                <div class="controls">
                    <textarea id="content" name="content" cols="45" rows="6"><?php if (isset($comment)) echo $comment['content'];?></textarea>
                </div>
            </div>
            <div class="control-group">
                <label>Answer</label>
                <div class="controls">
                    <textarea id="answer" name="answer" cols="45" rows="6"><?php if (isset($comment)) echo $comment['answer'];?></textarea>
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
            if ($.trim($('#content').val()) == '') {
                alert('Please enter content');
                return false;
            }
        });
    });
</script>

<?php include('../footer.php'); ?>
