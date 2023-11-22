<?php
require_once 'config/database.php';
require_once 'template/header.php';



// Display the user role
$userRole = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : 'Guest';

?>

<div class="welcome-message">
    <h2>Welcome to the Dashboard!</h2>
    <p>Your role: <?php echo $userRole; ?></p>
</div>

<?php 
require_once 'template/footer.php';
?>
