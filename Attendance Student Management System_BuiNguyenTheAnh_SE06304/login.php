<?php
include 'db.php';

$error = "";
if (!empty($_POST)) {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Tìm người dùng dựa trên email
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Kiểm tra mật khẩu
            if (password_verify($password, $user['password'])) {
                echo "<script>alert('Log in successfully!'); window.location.href='mainpage.php';</script>";
            } else {
                $error = "Wrong password.";
            }
        } else {
            $error = "Email doesn't exist.";
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1 style="text-align: center;">Login Form</h1>
        <?php if (!empty($error)) { ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php } ?>
        <form method="post">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>
