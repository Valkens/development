<?php
session_start();
include 'include/function.php';
$db = connectDb();

if (isset($_POST['submit'])) {
    if (!trim($_POST['username'])) {
        $errors[] = 'Please enter username';
    } else {
        $sql = "SELECT * FROM users WHERE username='". $_POST['username']."'";
        $result = $db->query($sql);
        if ($result->fetch(PDO::FETCH_ASSOC)) {
            $errors[] = 'This username has already been registered';
        } else {
            $username = $_POST['username'];
        }
    }
    if ($_POST['email']) {
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please enter valid email';
        } else {
            $email = $_POST['email'];
        }
    } else {
        $errors[] = 'Please enter email';
    }
    if ($_POST['password']) {
        if ($_POST['password'] != $_POST['re_password']) {
            $errors[] = 'Two passwords do not match';
        } else {
            $password = $_POST['password'];
        }
    } else {
        $errors[] = 'Please enter password';
    }

    if (isset($username) && isset($email) && isset($password)) {
        $query = $db->prepare('INSERT INTO users (username,email,password) VALUES(:username,:email,:password)');
        $query->execute(array(
            'username' => $username,
            'email' => $email,
            'password' => md5($password),
        ));
        if ($query->rowCount()) {
            $_SESSION['username'] = $username;
            $_SESSION['userid'] = $db->lastInsertId();
            header('location: ./');
            exit();
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
        <h2>Registry</h2>
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
                <form method="post" name="contact" action="#">
                    <label>Username (*):</label>
                    <input type="text" name="username" class="input_field" />
                    <div class="cleaner h10"></div>
                    <label>Email (*):</label>
                    <input type="text" name="email" class="input_field" />
                    <div class="cleaner h10"></div>
                    <label>Password (*):</label> <input type="password" name="password" class="input_field" />
                    <div class="cleaner h10"></div>
                    <label>Re-Password:</label> <input type="password" name="re_password" class="input_field" />
                    <div class="cleaner h10"></div>
                    <input type="submit" value="Registry" id="submit" name="submit" class="submit_btn float_l" />
                </form>
            </div>
        </div>
    </div>
    <div class="cleaner"></div>
</div>

<?php include 'public/bottom.php';