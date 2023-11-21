<?php
require_once 'config/database.php';
require_once 'template/header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = $mysqli->query($query);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        // Delete any existing tokens for the user
        $deleteQuery = "DELETE FROM password_reset WHERE user_id = {$user['user_id']}";
        $mysqli->query($deleteQuery);

        // Generate a unique token to prevent brute forcing
        $token = bin2hex(random_bytes(32));

        // Calculate the expiration date
        $expirationDate = date('Y-m-d H:i:s', strtotime('+1 day'));

        $insertQuery = "INSERT INTO password_reset (user_id, token, expiration_date) VALUES ('{$user['user_id']}', '$token', '$expirationDate')";
        $mysqli->query($insertQuery);

        // TODO: Send an email

    } 
        // The message will appear wether the email of the user has been found or not, to prevent information gathering
        echo "<p>An email has been sent to your email address with instructions to reset your password.</p>";
}
?>

<div class="reset-password-container">
    <h2>Reset Password</h2>
    <form action="reset_password.php" method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <button type="submit">Reset Password</button>
    </form>
</div>

<?php
require_once 'template/footer.php';
?>
