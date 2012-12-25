<?php
session_start();
include 'include/function.php';
$db = connectDb();

if (isset($_POST['submit'])) {
    if ($_POST['password']) {
        if ($_POST['password'] != $_POST['re_password']) {
            $errors[] = 'Two passwords do not match';
        } else {
            $password = $_POST['password'];
        }
    } else {
        $errors[] = 'Please enter new password';
    }

    if (isset($password)) {
        $sql = 'UPDATE users SET password=:password WHERE id=:id';
        $query = $db->prepare($sql);
        $query->execute(array(
            'password' => md5($_POST['password']),
            'id' => $_SESSION['userid']
        ));

        if ($query->rowCount()) {
            $success = 'Your password is changed';
        }
    }
}
?>

<?php include 'public/header.php';?>

<div id="main">
    <div id="sidebar" class="float_l">
        <?php include 'public/categories.php';?>
    </div>
    <div id="content" class="float_r">
        <h2>Change password</h2>
        <div class="content_half float_l">
            <div class="error">
                <?php
                if (isset($errors)) {
                    foreach ($errors as $error) {
                        echo "<li>$error</li>";
                    }
                }
                ?>
            </div>
            <div class="success">
                <?php
                if (isset($success)) {
                    echo $success;
                }
                ?>
            </div>
            <div id="form_login">
                <form method="post" name="contact" action="#">

                    <label>New password (*):</label>
                    <input type="password" name="password" class="input_field" />
                    <div class="cleaner h10"></div>
                    <label>Re-enter new password (*):</label> <input type="password" name="re_password" class="input_field" />
                    <div class="cleaner h10"></div>

                    <input type="submit" value="Change" id="submit" name="submit" class="submit_btn float_l" />
                </form>
            </div>
        </div>
    </div>
    <div class="cleaner"></div>
</div>

<?php include 'public/bottom.php';