<?php
if (isset($_SESSION['customer'])) {
    header('location: ./?m=user&a=logout');
    exit();
}

if (isset($_POST['submit'])) {
    if (trim($_POST['fullname'])) {
        $fullname = trim($_POST['fullname']);
    } else {
        $errors[] = 'Please enter Fullname';
    }
    if (trim($_POST['email'])) {
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $stmt = $conn->prepare('SELECT * FROM customers WHERE email = :email');
            $stmt->execute(array('email' => trim($_POST['email'])));
            if (count($stmt->fetchAll())) {
                $errors[] = 'This email has already been registered';
            } else {
                $email = trim($_POST['email']);
            }
        } else {
            $errors[] = 'Please enter valid email';
        }
    } else {
        $errors[] = 'Please enter Email';
    }
    if (trim($_POST['password']) || trim($_POST['re_password'])) {
        if ($_POST['password'] == $_POST['re_password']) {
            $password = $_POST['password'];
        } else {
            $errors[] = 'Two passwords do not match';
        }
    } else {
        $errors[] = 'Please enter password';
    }

    if (isset($fullname) && isset($email) && isset($password)) {
        $conn = dbConnect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $stmt = $conn->prepare('INSERT INTO customers (fullname,email,password) VALUES(:fullname,:email,:password)');
        $stmt->execute(array(
            'fullname' => $fullname,
            'email' => $email,
            'password' => md5($password),
        ));
        if ($stmt->rowCount()) {
            $_SESSION['customer']['fullname'] = $fullname;
            $_SESSION['customer']['email'] = $email;

            header('location: ./');
            exit();
        }
    }
}
?>

<div id="contents">
    <div id="main">
        <form id="login-form" action="" method="post">
            <fieldset>
                <legend>Signup</legend>
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
                        <td><label>(*) Fullname:</label></td>
                        <td><input type="text" name="fullname" maxlength="100" /></td>
                    </tr>
                    <tr>
                        <td><label>(*) Email:</label></td>
                        <td><input type="text" name="email" maxlength="64" /></td>
                    </tr>
                    <tr>
                        <td><label>(*) Password:</label></td>
                        <td><input type="password" name="password" /></td>
                    </tr>
                    <tr>
                        <td><label>(*) Re-Password:</label></td>
                        <td><input type="password" name="re_password" /></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Submit" />
                            <input type="reset" value="Reset" />
                        </td>
                    </tr>
                </table>
            </fieldset>
        </form>
        <br class="clear" />
    </div>
</div>