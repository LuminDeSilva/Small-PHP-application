<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
}

$user_id = $_SESSION["user_id"];
$user_name = $_SESSION["user_name"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>ICAE2</title>
<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f8f9fa;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100vh;
        margin: 0;
    }

    h1 {
        color: #007BFF;
        margin-bottom: 20px;
    }

    .button-container {
        display: flex;
    }

    a {
        display: inline-block;
        background-color: #007BFF;
        color: #fff;
        padding: 8px 16px;
        text-decoration: none;
        border-radius: 4px;
        margin: 5px;
        transition: background-color 0.3s;
    }

    a:hover {
        background-color: #0056b3;
    }
</style>
</head>
<body>
    <h1>Welcome <?php echo $user_name; ?></h1>
    <div class="button-container">
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
