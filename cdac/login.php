<?php
session_start();
include "connection.php";

$errorMsg = "";
$formSubmitted = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $formSubmitted = true;

    $username = $conn->real_escape_string($_POST['username']);
    $userPassword = $conn->real_escape_string($_POST['password']);

    // Fetch the user's data from the database
    $sql = "SELECT Username, Password, Role, Name,Email,Phone FROM students WHERE Username = ? OR Email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['Password'];
        $username = $row['Username'];
        $role = $row['Role'];
        $fullName = $row['Name'];
        $email = $row['Email'];
        $phone = $row['Phone'];
        // $pid = $row['Pid'];

        if (password_verify($userPassword, $hashedPassword)) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;
            $_SESSION['name'] = $fullName;
            $_SESSION['email'] = $email;
            $_SESSION['up'] = $phone;
            // $_SESSION['pid'] = $pid;

            if ($role == 1) {
                // Redirect admin to admin.php
                header("Location: admin.php");
            } elseif ($role == 2) {
                // Redirect student to welcome.php
                header("Location: welcome.php");
            }
        } else {
            $errorMsg = "Your username or password is incorrect.";
        }
    } else {
        $errorMsg = "User not found";
    }
    
    // Close statement and connection
    $stmt->close();
    $conn->close();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> C-DAC Centre @ Mohali</title>
    <link rel="icon" href="favicon.png">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="cdaccsss.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Young+Serif&display=swap" rel="stylesheet">
<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
/>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>



.login-box {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    width: 400px;
    margin: 80px auto;
}



form {
    display: flex;
    flex-direction: column;
}

label {
    margin: 10px 0;
    font-weight: bold;
}

input, select {
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid black;
    border-radius: 4px;
}

button {
    background-color: blue;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
}
.log{
    text-align:center;
    letter-spacing:1px;
}

    </style>
</head>
<body>
    <section class="header">
<nav>
    <a href="C-DAC Centre @ Mohali.html" > 
        <img src="cdac-logo.png" class="logo">
    </a>
    <div class="nav-links">
        <ul>
        <li> <a href="">  </a> </li>

            <li> <a href="http://localhost/mohit/cdac/cdac.php"> Home </a> </li>
            <li> <a href="aboutus.php"> About Us </a> </li>
            <li> <a href="contactus.php"> Contact Us </a> </li>
            <li> <a href="http://localhost/mohit/cdac/register.php">Register  </a> </li>

        </ul>
    </div>
</nav>
<div class="textbox ">
    <h1 > C-DAC Center @ Mohali </h1>
 
</div>

<div class="login-container">
        <div class="login-box">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form/-data" method="post">
            <label for="userType" class="log"><i class="fas fa-user"></i> Login</label>
                

                <label for="username">Username:</label>
                <input type="text" name="username" required>

                <label for="password">Password:</label>
                <input type="password" name="password" required>

                <button type="submit">Login</button><br/>
                <p> Forgotten account? &nbsp;&nbsp;<a href="register.php">Sign up for Login</a></p>
            </form>
        </div>
    </div>


    <div class="end">
    <hr width="99%" color="silver" size="3" class="hr"/>
<div class="end1">
    <a>Help |</a>
    <a>Websites Policy |</a>
    <a>Copyright Policy |</a>
    <a>Terms & Condition |</a>
    <a>Reach us |</a>

</div> 


<div class="end2">
    <p style="text-align: center; color: black; padding-top: 20px;">Website owned & maintained by: Centre for Development of Advanced Computing (C-DAC)</p>
</div>
<div class="end3">
    <p style="text-align: center; color: black;">© 2023 C-DAC. All rights reserved, Last Updated: Tuesday, Nov. 28, 2023</p>
</div>
<a  href="#" id="back-button"><p style="text-align: end; " >Back to Top</p></a>

</div>

</body>
</html>