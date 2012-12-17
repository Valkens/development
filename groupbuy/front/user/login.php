<?php
if (isset($_SESSION['customer'])) {
    header('location: ./?m=user&a=logout');
    exit();
}

if (isset($_POST['submit'])) {
    if (trim($_POST['email'])) {
        if (filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)) {
            $email = trim($_POST['email']);
        } else {
            $errors[] = 'Please enter valid email';
        }
    } else {
        $errors[] = 'Please enter Email';
    }
    if (trim($_POST['password'])) {
        $password = $_POST['password'];
    } else {
        $errors[] = 'Please enter password';
    }

    if (isset($email) && isset($password)) {
        $conn = dbConnect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $stmt = $conn->prepare('SELECT * FROM customers WHERE email = :email AND password=MD5(:password)');
        $stmt->execute(array('email' => $email, 'password' => $password));
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $_SESSION['customer']['id'] = $row['id'];
            $_SESSION['customer']['fullname'] = $row['fullname'];
            $_SESSION['customer']['email'] = $email;

            header('location: ./');
            exit();
        } else {
            $errors[] = 'Your login was invalid';
        };
    }
}
?>

<div id="contents">
    <div id="main">
        <form id="login-form" action="" method="post">
            <fieldset>
                <legend>Login</legend>
                <ul class="error">
                    <?php
                    if (isset($errors)) {
                        foreach ($errors as $error) {
                            echo "<li>+ {$error}.</li>";
                        }
                    }
                    ?>
                </ul>
                <table>
                    <tr>
                        <td><label>(*) Email:</label></td>
                        <td><input type="text" name="email" maxlength="64" /></td>
                    </tr>
                    <tr>
                        <td><label>(*) Password:</label></td>
                        <td><input type="password" name="password" /></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Login" />
                        </td>
                    </tr>
                </table>
            </fieldset>
        </form>
        <br class="clear" />
    </div>
</div>