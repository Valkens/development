<?php
session_start();
include 'include/function.php';
$db = connectDb();

if (isset($_POST['submit'])) {
    if (!trim($_POST['username'])) {
        $errors[] = 'Please enter Username';
    } else {
        $username = $_POST['username'];
    }
    if ($_POST['password']) {
        $password = $_POST['password'];
    } else {
        $errors[] = 'Please enter password';
    }

    if (isset($username) && isset($password)) {
        $stmt = $db->prepare('SELECT * FROM users WHERE username = :username AND password=MD5(:password)');
        $stmt->execute(array('username' => $username, 'password' => $password));
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $_SESSION['userid'] = $row['id'];
            $_SESSION['username'] = $row['username'];

            if ($username == admin) {
                header('location: ./admin');
            } else {
                header('location: ./');
            }
            exit();
        } else {
            $errors[] = 'Your login was invalid';
        };
    }
}
?>

<?php include 'public/header.php';?>

<div id="main">
    <div id="sidebar" class="float_l">
        <?php include 'public/categories.php';?>
    </div>
    <div id="content" class="float_r">
        <h2>User login</h2>
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
            <div id="form_login">
                <form method="post" action="#">

                    <label>Username:</label>
                    <input type="text" name="username" class="input_field" />
                    <div class="cleaner h10"></div>
                    <label>Password:</label> <input type="password" name="password" class="input_field" />
                    <div class="cleaner h10"></div>

                    <input type="submit" value="Login" id="submit" name="submit" class="submit_btn float_l" />
                </form>
            </div>
        </div>
    </div>
    <div class="cleaner"></div>
</div>

<?php include 'public/bottom.php';