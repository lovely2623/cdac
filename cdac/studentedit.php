<?php
session_start();

include "connection.php"; // Include your database connection file

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Fetch user data from the database
    $sql = "SELECT * FROM students WHERE Username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newName = $_POST['new_name'];
            $newEmail = $_POST['new_email'];
            $newPhone = $_POST['new_phone'];
            $newAddress = $_POST['new_address'];

            $updateSql = "UPDATE students SET Name=?, Email=?, Phone=?, Address=? WHERE Username=?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("sssss", $newName, $newEmail, $newPhone, $newAddress, $username);
            $updateStmt->execute();

            header("Location: welcome.php");
            exit();
        }
    } else {
        echo "<div class='container mt-5'><p>User profile not found.</p></div>";
        exit();
    }
} else {
    header("Location: login.php");
    exit();
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
        .textboxx h1{
    position: absolute;
    top: 80px;
    left:36% ;
    letter-spacing: 2px;
    color: black;
}
   .container {
            max-width: 600px;
            height:500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin-top: 50px;
        }

        h2 {
            text-align: center;
            color:blue;
        }

        form {
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn26 {
            background-color: blue;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
        .prev{
    background-color: blue;
    color: white;
    padding: 10px;
    border-radius: 5px;
    cursor: pointer; 
    width: 130px;
    letter-spacing: 2px;
    

}

.prev a {
    color:white;
    text-decoration:none;
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
            <li> <a href="http://localhost/mohit/cdac/cdac.php"> Home </a> </li>
            <li> <a href="aboutus.php"> About Us </a> </li>
            <li> <a href="contactus.php"> Contact Us </a> </li>
            <li> <a href="http://localhost/mohit/cdac/register.php">Register  </a> </li>
            <li> <a href="http://localhost/mohit/cdac/login.php"> Login </a> </li>

        </ul>
    </div>
</nav>
<div class="textboxx ">
    <h1 > C-DAC Center @ Mohali </h1>
 
</div>
   

    <div class="container mt-5">
        <h2>Edit Your Profile</h2>
        <form method="post" action="">
            <div class="form-group">
                <label for="new_name">Name:</label>
                <input type="text" class="form-control" id="new_name" name="new_name" value="<?= htmlspecialchars($row['Name']) ?>">
            </div>
            <div class="form-group">
                <label for="new_email">Email:</label>
                <input type="email" class="form-control" id="new_email" name="new_email" value="<?= htmlspecialchars($row['Email']) ?>">
            </div>
            <div class="form-group">
                <label for="new_phone">Phone Number:</label>
                <input type="text" class="form-control" id="new_phone" name="new_phone" value="<?= $row['Phone'] ?>">
            </div>
            <div class="form-group">
                <label for="new_address">Address:</label>
                <input type="text" class="form-control" id="new_address" name="new_address" value="<?= htmlspecialchars($row['Address']) ?>">
            </div>
            <button type="submit" class="btn26 btn-primary">Save Changes</button>
            <button type="submit" class="buton prev btn-primary"> <a href= "welcome.php">Previous</a></button>
        </form>
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