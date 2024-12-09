<?php
include 'db.php';

$error = "";
if (!empty($_POST)) {
    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['dob']) && isset($_POST['password']) && isset($_POST['confirm']) && isset($_POST['address'])) {
        
        $name = $_POST['name'];
        $email = $_POST['email'];
        $dob = $_POST['dob'];
        $password = $_POST['password'];
        $confirm = $_POST['confirm'];
        $address = $_POST['address'];
        
        // Kiểm tra email đã tồn tại
        $check_email = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($check_email);

        if ($result && $result->num_rows > 0) {
            $error = "Email already exists. Please use another email.";
        } else {
            // Kiểm tra mật khẩu
            if (strlen($password) >= 6 && 
                preg_match('/[A-Z]/', $password) &&     // Chứa ít nhất một chữ hoa
                preg_match('/[a-z]/', $password) &&     // Chứa ít nhất một chữ thường
                preg_match('/[0-9]/', $password) &&     // Chứa ít nhất một số
                preg_match('/[\W_]/', $password)) {     // Chứa ít nhất một ký tự đặc biệt
                
                if ($password === $confirm) {
                    // Mã hóa mật khẩu trước khi lưu
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    // Chèn dữ liệu vào bảng users
                    $sql = "INSERT INTO users (name, email, dob, password, address) VALUES ('$name', '$email', '$dob', '$hashed_password', '$address')";

                    if ($conn->query($sql) === TRUE) {
                        // Hiển thị thông báo và chuyển hướng
                        echo "<script>alert('Đăng ký thành công!'); window.location.href='login.php';</script>";
                        exit();
                    } else {
                        $error = "Lỗi: " . $conn->error;
                    }
                } else {
                    $error = "Password and Confirm Password do not match.";
                }
            } else {
                $error = "Password must have at least 6 characters, including uppercase letters, lowercase letters, numbers and special characters.";
            }
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
    <title>Register Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1 style="text-align: center;">Register Form</h1>
        <?php if (!empty($error)) { ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php } ?>
        <form method="post">
            <div class="form-group">
                <label for="name">Full name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <input type="date" class="form-control" id="dob" name="dob" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm">Confirm Password:</label>
                <input type="password" class="form-control" id="confirm" name="confirm" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>
