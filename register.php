<?php
    //session_start();
    require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>ICAE2</title>
<style>
    .requiredlabel {
        color: #FF0000; 
        font-weight: bold;
    }
    
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

    h2 {
        color: #007BFF;
        margin-bottom: 8px;
    }

    form {
        background-color: #fff;
        padding: 10px 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 300px;
        max-width: 100%;
    }

    input {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .error {
        color: #FF0000;
        font-size: 14px;
        font-weight: bold;
    }

    input[type="submit"], input[type="reset"] {
        background-color: #007BFF;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover, input[type="reset"]:hover {
        background-color: #0056b3;
    }

    .login-link {
        margin-top: 3px;
        color: #007BFF;
        text-decoration: none;
        font-weight: bold;
        transition: color 0.3s;
    }

    .login-link:hover {
        text-decoration: underline;
        color: #0056b3;
    }

</style>
</head>
<body>  
    <h2>Register</h2>
    <?php
        $nameErr = $unameErr = $passwordErr = $emailErr = $websiteErr = $curuserErr = "";
        $name = $uname = $password = $email = $website = "";

        if (isset($_POST["submitbtn"])) {

            //getting user input values
            $name = $_POST["name"];
            $uname = $_POST["uname"];
            $email = $_POST["uemail"];
            $password = $_POST["upassword"];
            $website = $_POST["uwebsite"];
            
            //name validation
            if (empty($name)) {
                $nameErr = "Name is required";
            } 
            else {
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
                    $nameErr = "Only letters and white space allowed in name"; 
                    $name = "";
                }
                else {
                    $name = test_input($name);
                }
            }
            //username validation
            if (empty($uname)) {
                $unameErr = "Username is required";
            } 
            else {
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z ]*$/",$uname)) {
                    $unameErr = "Only letters and white space allowed in username"; 
                    $uname = "";
                }
                else {
                    $uname = test_input($uname); 
                }
            }

            //user email validation
            if (empty($email)) {
                $emailErr = "Email is required";
            } 
            else {
                // check if e-mail address is well-formed
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailErr = "Invalid email format"; 
                    $email = "";
                }
                else {
                    $email = test_input($email);
                }
            }
            
            //user password validation
            //password validation
            if (empty($password)) {
                $passwordErr = "Password is required";
            } 
            else {
                // Add additional password validation rules
                $uppercase = preg_match('@[A-Z]@', $password);
                $specialChars = preg_match('/[^\w]/', $password);
                
				// password length validation
                if (strlen($password) < 8 || strlen($password) > 20) {
                    $passwordErr = "Password must be between 8 and 20 characters";
                    $password = "";
                } 
				// password uppercase validation
                elseif (!$uppercase) {
                    $passwordErr = "Password must contain at least one uppercase letter";
                    $password = "";
                } 
				// password special character validation
                elseif (!$specialChars) {
                    $passwordErr = "Password must contain at least one special character";
                    $password = "";
                }
                else {
                    $password = test_input($password); 
                }
            }

            //user website validation
            if (empty($website)) {
                $website = "";
            } 
            else {
                // check if URL address syntax is valid (this regular expression also allows dashes in the URL)
                if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
                    $websiteErr = "Invalid URL";
                    $website = ""; 
                }
                else {
                    $website = test_input($website);  
                }
            }
			
			// get the registered user from the database (same username and password)
			$curusersql = "SELECT username, upassword 
						  FROM users 
						  WHERE username = '$uname' OR upassword = '$password'";
			$curuserres = mysqli_query($conn, $curusersql);
			
			// check the username or password already there
			if (mysqli_num_rows($curuserres) > 0){
				$curuserErr = "Username or Password Already Exists.!";
			}
			else {
				//query to store the values
				if($nameErr == "" && $unameErr == "" && $passwordErr == "" && 
					$emailErr == "" && $websiteErr == "" && $curuserErr == "") {

					$sql = "INSERT INTO users 
                        (uname, username, uemail, upassword, uwebsite) 
                        VALUES 
                        ('$name', '$uname', '$email', '$password', '$website')";
                
					$result = mysqli_query($conn, $sql);
					if ($result) {
						//echo "Success";
						header("Location:login.php");
					}
					else {
						echo "Registration Fails.!" . mysqli_error($conn);
					}
				}
            }
        }
		function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
        <p><span class="requiredlabel">* required field</span></p>
		
		<span class="error">* <?php echo $curuserErr;?></span><br>
        
        Name: <span class="error">* <?php echo $nameErr;?></span>
        <input type="text" name="name" value="">
        <br>
        
        Username: <span class="error">* <?php echo $unameErr;?></span>
        <input type="text" name="uname" value="">
        <br>
        
        E-mail: <span class="error">* <?php echo $emailErr;?></span>
        <input type="text" name="uemail" value="">
        <br>
        
        Password: <span class="error">* <?php echo $passwordErr;?></span>
        <input type="text" name="upassword" value="">
        <br>
        
        Website: <span class="error"><?php echo $websiteErr;?></span>
        <input type="text" name="uwebsite" value="">
        <br>
        
        <input type="submit" name="submitbtn" value="Submit">  
        <input type="reset" name="resetbtn" value="Reset">  
    </form>

    <a href="login.php" class="login-link">Already have an account? Login</a>
</body>
</html>