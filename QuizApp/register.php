<?php
require_once 'config/database.php';
require_once 'template/header.php';

if(isset($_SESSION["user_id"])){
    header("Location: index.php");
    exit(); 
}
// Handle registration
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newUsername = $_POST['username'];
    $newEmail = $_POST['email'];
    $newPassword = $_POST['password'];

    // Check if the username or email already exists
    $checkQuery = "SELECT * FROM users WHERE username='$newUsername' OR email='$newEmail'";
    $checkResult = $mysqli->query($checkQuery);

    if ($checkResult->num_rows == 0) {
        //Read the diffrences between bcrypt and default
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        $insertQuery = "INSERT INTO users (username, email, password) VALUES ('$newUsername', '$newEmail', '$hashedPassword')";
        if ($mysqli->query($insertQuery) === TRUE) {
            header("Location: login.php");
            exit(); 
        } else {
            echo "Error: " . $insertQuery . "<br>" . $mysqli->error;
        }
    } else {
        echo "<p>Username or email is already in use.</p>";
    }
}
?>

<div class="register-container">
    <h2>Register</h2>
    <form action="register.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
    </form>
</div>

<?php 
require_once 'template/footer.php';