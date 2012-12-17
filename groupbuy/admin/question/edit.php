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
    if (trim($_POST['content']) != '') {
        $stmt = $conn->prepare('UPDATE questions SET content = :content,answer=:answer WHERE id = :id');
        $stmt->execute(array(
            'id'   => $_GET['id'],
            'content' => trim($_POST['content']),
            'answer' => trim($_POST['answer'])
        ));

        header('location: ./');
    }
} else {
    $stmt = $conn->prepare('SELECT * FROM questions WHERE id = :id');
    $stmt->execute(array(
        ':id'   => $_GET['id'],
    ));
    if ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $question = $result;
    }
}
?>

<div id="main-content" class="pull-left">
    <div class="list-box">
        <h3 class="header">Edit question</h3>
        <form action="" method="POST">
            <div class="control-group">
                <label>Content (*)</label>
                <div class="controls">
                    <textarea id="content" name="content" cols="45" rows="6"><?php if (isset($question)) echo $question['content'];?></textarea>
                </div>
            </div>
            <div class="control-group">
                <label>Answer</label>
                <div class="controls">
                    <textarea id="answer" name="answer" cols="45" rows="6"><?php if (isset($question)) echo $question['answer'];?></textarea>
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

<?php include('../template/footer.php'); ?>
