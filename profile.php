<?php
    session_start();
    include("config.php");

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

    header {
        background-color: #333;
        color: #fff;
        text-align: center;
        padding: 10px;
    }

    main {
        max-width: 600px;
        margin: 20px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        color: #007BFF;
    }

    p {
        margin: 10px 0;
    }

    .profile-card {
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
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
<h2>User Profile Details</h2>
<div class="profile-card">
    <?php
        $sql = "SELECT * FROM users WHERE id = $user_id";
        $result = mysqli_query($conn, $sql);
    
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            
            // Store user details in variables
            $uname = $row['uname'];
            $username = $row['username'];
            $useremail = $row['uemail'];
            $userpassword = $row['upassword'];

            echo "<p><strong>User ID:</strong> $user_id</p>";
            echo "<p><strong>Name:</strong> $uname</p>";
            echo "<p><strong>Username:</strong> $username</p>";
            echo "<p><strong>Email:</strong> $useremail</p>";
        } 
        else {
            echo "User not found.";
        }  
    ?>
</div>
<div class="button-container">
    <a href="change_password.php">Change Password</a>
    <a href="logout.php">Logout</a>
</div>
</body>
</html>
