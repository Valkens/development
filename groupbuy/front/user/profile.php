<?php
if (!isset($_SESSION['customer'])) {
    header('location: ./');
    exit();
}

$conn = dbConnect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
$stmt = $conn->prepare('SELECT * FROM customers WHERE email = :email');
$stmt->execute(array('email' => $_SESSION['customer']['email']));

$customer = $stmt->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['submit'])) {
    if (trim($_POST['fullname'])) {
        $fullname = trim($_POST['fullname']);
    } else {
        $errors[] = 'Please enter Fullname';
    }
    if (trim($_POST['password'])) {
        if ($_POST['password'] == $_POST['re_password']) {
            $password = $_POST['password'];
        } else {
            $errors[] = 'Two passwords do not match';
        }
    }

    if (isset($fullname) || isset($password)) {
        $sql = 'UPDATE customers SET ';
        if (isset($fullname)) {
            $sql .= 'fullname=:fullname';
            $params['fullname'] = $fullname;
        }
        if (isset($password)) {
            $sql .= ',password=:password';
            $params['password'] = md5($password);
        }

        $sql .= ' WHERE id=:id';
        $stmt = $conn->prepare($sql);

        $params['id'] = (int) $customer['id'];
        $stmt->execute($params);

        if ($stmt->rowCount()) {
            $customer['fullname'] = $_SESSION['customer']['fullname'] = $fullname;
            $successes[] = 'Your profile information has been changed';
        }
    }
}
?>

<div id="contents">
    <div id="main">
        <form id="login-form" action="" method="post">
            <fieldset>
                <legend>Profile information</legend>
                <ul class="error">
                    <?php
                    if (isset($errors)) {
                        foreach ($errors as $error) {
                            echo "<li>+ {$error}.</li>";
                        }
                    }
                    ?>
                </ul>
                <ul class="success">
                    <?php
                    if (isset($successes)) {
                        foreach ($successes as $success) {
                            echo "<li>+ {$success}.</li>";
                        }
                    }
                    ?>
                </ul>
                <table>
                    <tr>
                        <td><label>(*) Fullname:</label></td>
                        <td><input type="text" name="fullname" maxlength="100" value="<?php echo $customer['fullname'];?>" /></td>
                    </tr>
                    <tr>
                        <td><label>Password:</label></td>
                        <td><input type="password" name="password" /></td>
                    </tr>
                    <tr>
                        <td><label>Re-Password:</label></td>
                        <td><input type="password" name="re_password" /></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Submit" />
                        </td>
                    </tr>
                </table>
            </fieldset>
        </form>
        <br class="clear" />
    </div>
</div>