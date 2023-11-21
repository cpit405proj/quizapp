<?php
require_once 'config/database.php';
require_once 'template/header.php';

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username='$username'";
    $result = $mysqli->query($query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION["user_id"] = $row['user_id'];
            $_SESSION['user_role'] = $row['role'];
            header("Location: index.php");
            exit();
        }
    }
    echo "<p>Invalid username or password. </p>";
}
?>

<div class="login-container">
    <h2>Login</h2>
    <form action="login.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <a href="reset_password.php">Forgot your password? </a>
        <button type="submit">Login</button>
    </form>
</div>

<?php 
require_once 'template/footer.php';
?>
