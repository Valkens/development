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
    $sql = 'UPDATE customers SET fullname=:fullname,email=:email';
    $params['fullname'] = trim($_POST['fullname']);
    $params['email'] = trim($_POST['email']);

    if ($_POST['password'] != '') {
        $sql .= ',password=:password';
        $params['password'] = md5($_POST['password']);
    }

    $sql .= ' WHERE id=:id';
    $stmt = $conn->prepare($sql);

    $params['id'] = $_GET['id'];
    $stmt->execute($params);

    header('location: ./');
} else {
    $stmt = $conn->prepare('SELECT * FROM customers WHERE id = :id');
    $stmt->execute(array(
        ':id'   => $_GET['id'],
    ));
    if ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $customer = $result;
    }
}
?>

<div id="main-content" class="pull-left">
    <div class="list-box">
        <h3 class="header">Edit customer</h3>
        <form action="" method="POST">
            <div class="control-group">
                <label>Fullname (*)</label>
                <div class="controls">
                    <input type="text" id="fullname" name="fullname" value="<?php if (isset($customer)) echo $customer['fullname'];?>" />
                </div>
            </div>

            <div class="control-group">
                <label>Email (*)</label>
                <div class="controls">
                    <input type="text" id="email" name="email" value="<?php if (isset($customer)) echo $customer['email'];?>" />
                </div>
            </div>

            <div class="control-group">
                <label>Password</label>
                <div class="controls">
                    <input type="password" id="password" name="password" />
                </div>
            </div>

            <div class="control-group">
                <label>Re-Password</label>
                <div class="controls">
                    <input type="password" id="re-password" />
                </div>
            </div>

            <div class="form-actions">
                <input type="submit" name="submit" value="Update" />
                | <a href="../customer">Cancel</a>
            </div>
        </form>
    </div>
    <br class="clear" />
</div>
<script type="text/javascript">
    $(function(){
        $('form').submit(function(){
            if ($.trim($('#fullname').val()) == ''
               || $.trim($('#email').val()) == ''
            ) {
                alert('Please complete all of the required fields');
                return false;
            }

            if ($.trim($('#email').val())) {
                var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if (!regex.test($.trim($('#email').val()))) {
                    alert('Please enter valid email');
                    return false;
                }
            }
            if ($('#password').val() != '' || $('#re-password').val() != '') {
                if ($('#password').val() != $('#re-password').val()) {
                    alert('Two passwords do not match');
                    return false;
                }
            }
        });
    });
</script>

<?php include('../template/footer.php'); ?>
