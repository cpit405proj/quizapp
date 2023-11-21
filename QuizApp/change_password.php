<?php
require_once 'config/database.php';
require_once 'template/header.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $token = $_GET['token'];

    if (!empty($token)) {
        $query = "SELECT * FROM password_reset WHERE token = '$token' AND expiration_date > NOW()";
        $result = $mysqli->query($query);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $userId = $row['user_id'];
            $_SESSION['reset_user_id']=$userId;
        } else {
            echo "<p>Invalid or expired token.</p>";
            exit();
        }
    } else {
        echo "<p>Token not provided.</p>";
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['reset_user_id'])) {
        $newPassword = $_POST['new_password'];

        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        $userId = $_SESSION['reset_user_id'];
        $updateQuery = "UPDATE users SET password = '$hashedPassword' WHERE user_id = $userId";
        $mysqli->query($updateQuery);

        $deleteQuery = "DELETE FROM password_reset WHERE user_id = $userId";
        $mysqli->query($deleteQuery);

        echo "<p>Password updated successfully. You can now <a href='login.php'>login</a> with your new password.</p>";

        unset($_SESSION['reset_user_id']);
        header("Location: login.php");
        exit();
    } else {
        echo "<p>Invalid request.</p>";
    }
}
?>

<div class="change-password-container">
    <h2>Change Password</h2>
    <form action="change_password.php" method="POST">
        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" id="new_password" required>
        <button type="submit">Change Password</button>
    </form>
</div>

<?php
require_once 'template/footer.php';
?>
