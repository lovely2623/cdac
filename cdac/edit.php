
<?php
session_start();
include "connection.php";

// $row = []; // Initialize $row as an empty array



if (isset($_GET['id'])) {
    $edit_id = $conn->real_escape_string($_GET['id']);
    $sql = "SELECT * FROM students WHERE id = ?";
 
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Now $row contains the data of the record to be edited
    } else {
        echo "No record found";
        // Redirect or handle the error
    }
   
} else {
    echo "No ID provided";
    // Redirect or handle the error
}

if (isset($_POST['update'])) {
    // Get the updated data from the form

    $updatedName = $conn->real_escape_string($_POST['name']);
    $updatedUser = $conn->real_escape_string($_POST['username']);
    $updatedEmail = $conn->real_escape_string($_POST['email']);
    $updatedPhone = $conn->real_escape_string($_POST['phone']);
    $updatedGender = $conn->real_escape_string($_POST['gender']);
    $updatedAddress = $conn->real_escape_string($_POST['address']);
    $updatedState = $conn->real_escape_string($_POST['state']);
    $updatedDob = $conn->real_escape_string($_POST['dob']);

    // Update SQL query
    $updateSql = "UPDATE students SET Name = ?, Username = ?, Email = ?, Phone=?, Gender = ?, Address = ?, State=?,Dob = ? WHERE id = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("ssssssssi", $updatedName, $updatedUser, $updatedEmail, $updatedPhone, $updatedGender,  $updatedAddress, $updatedState, $updatedDob, $edit_id);
    $updateStmt->execute();



    if ($updateStmt->affected_rows > 0) {
        echo "Record updated successfully";
        // Redirect to student_fetch.php
        header("Location: fetch.php");
        exit();
    } else {
        if ($updateStmt->error) {
            echo "Error updating record: " . $updateStmt->error;
        } else {
            echo "No changes were made to the record.";
        }
    }
    $updateStmt->close();
}
$conn->close();
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
body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
}

.containeredit {
    max-width: 600px;
    height:auto;
    margin: 0 auto;
    padding: 20px;
    margin-top:70px;
    background-color: #ffffff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
    color: #007bff;
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

input {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
    border: 1px solid #ced4da;
    border-radius: 4px;
}

.buttoon {
    padding: 10px;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.btn-primary {
    background-color: #007bff;
}

.btn-danger {
    background-color: #dc3545;
}
.endd{
    height:24%;
    margin-top: 10px;
    background-color: #7F7D9C;

}
.textboxx h1{
    position: absolute;
    top: 80px;
    left:36% ;
    letter-spacing: 2px;
    color: black;
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
 

</ul>
    </div>
</nav>




<div class="textboxx ">
    <h1 > C-DAC Center @ Mohali </h1>
 
</div>
    <div class="containeredit mt-5">
        <h2>Edit Profile</h2>
        <form method="post" action="edit.php?id=<?php echo $edit_id;?>">
        <div class="form-group">
                <label>Name:</label>
                <input type="text" name="name" value="<?php echo isset($row['Name']) ? htmlspecialchars($row['Name']) : ''; ?>" class="form-control">
            </div>
            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="username" value="<?php echo isset($row['Username']) ? htmlspecialchars($row['Username']) : ''; ?>" class="form-control">
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="text" name="email" value="<?php echo isset($row['Email']) ? htmlspecialchars($row['Email']) : ''; ?>" class="form-control">
            </div>
            <div class="form-group">
                <label>Phone Number:</label>
                <input type="text" name="phone" value="<?php echo isset($row['Phone']) ? htmlspecialchars($row['Phone']) : ''; ?>" class="form-control">
            </div>
            <div class="form-group">
                <label>gender:</label>
                <input type="text" name="gender" value="<?php echo isset($row['Gender']) ? htmlspecialchars($row['Gender']) : ''; ?>" class="form-control">
            </div>
            <div class="form-group">
                <label>Address:</label>
                <input type="text" name="address" value="<?php echo isset($row['Address']) ? htmlspecialchars($row['Address']) : ''; ?>" class="form-control">
            </div>
            <div class="form-group">
                <label>State:</label>
                <input type="text" name="state" value="<?php echo isset($row['State']) ? htmlspecialchars($row['State']) : ''; ?>" class="form-control">
            </div>
            <div class="form-group">
                <label>Date of Birth:</label>
                <input type="date" name="dob" value="<?php echo isset($row['Dob']) ? htmlspecialchars($row['Dob']) : ''; ?>" class="form-control">
            </div>
            <button  type="submit" name="update" class="buttoon btn-primary">Save Changes</button>

        </form>
    </div>

    <div class="endd">
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


    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>


</html>