<?php
session_start();

include "connection.php"; // Include your database connection file

$successMsg = "";
$errorMsg = "";
$formSubmitted = false;
$imageSubmitted = false;

// Check if the form was submitted
if (isset($_POST["submitProfile"])) {

    $formSubmitted = true;
    // echo $selectedCourseID = $_POST['cid'];
    // Sanitize and fetch form data
    $did = $conn->real_escape_string($_POST['did']);
    $cid = $conn->real_escape_string($_POST['cid']);
     $name = $conn->real_escape_string($_POST['name']);
     $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $role = $conn->real_escape_string($_POST['role']);
    $address = $conn->real_escape_string($_POST['address']);
    $state = $conn->real_escape_string($_POST['state']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $password = $conn->real_escape_string($_POST['password']);
    // die('submit');    

    // Form validations
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMsg = "Invalid email format";
        $formSubmitted = false;
    }

    if (!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
        $errorMsg = "Invalid username format. Only alphanumeric characters and underscores are allowed.";
        $formSubmitted = false;
    }

    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $password)) {
        $errorMsg = "Invalid password format. Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character.";
        $formSubmitted = false;
    }

    // Image upload logic
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["File"]["name"]);
    $uploadOk = true;

    // Image file upload logic here
    // Add your file type validation or other checks if needed

    // Disable foreign key checks
    $conn->query("SET foreign_key_checks = 0");

    if (!$uploadOk) {
        $errorMsg = "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["File"]["tmp_name"], $target_file)) {
            $sqlImage = "INSERT INTO uimage (filename) VALUES ('$target_file')";
            if ($conn->query($sqlImage) === TRUE) {
                $last_image_id = $conn->insert_id;  // Fetch the last inserted image ID

                // Encrypt the password
                $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
                
        // SQL query to insert data into your table
       echo $sql = "INSERT INTO students (Did, Cid, Pid, Name, Username, Email, Phone, Gender, Role, Address, State, Dob, Password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";


                // SQL query to insert data into your table
                $sql = "INSERT INTO students (Did, Cid, Pid, Name, Username, Email, Phone, Gender, Role, Address, State, Dob, Password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                // Prepare and bind
                $stmt = $conn->prepare($sql);

                // Check for a successful preparation
                if ($stmt !== false) {
                    $stmt->bind_param("iiissssssssss", $did, $cid, $last_image_id, $name, $username, $email, $phone, $gender, $role, $address, $state, $dob, $hashedPwd);

                    // Execute the statement
                    if ($stmt->execute()) {
                        $successMsg = "<br>Student Added successfully";

                        // Store user data in the session
                        $_SESSION['username'] = $username;
                        $_SESSION['role'] = $role;
                        $_SESSION['name'] = $name;
                        $_SESSION['image_id'] = $last_image_id;

                        // Redirect to login.php
                        header("Location: login.php");
                        exit();
                    } else {
                        $errorMsg = "Error: " . $stmt->error;
                    }
                } else {
                    $errorMsg = "Error in preparing the SQL statement: " . $conn->error;
                }
            } else {
                $errorMsg = "Error: " . $sqlImage . "<br>" . $conn->error;
            }
        } else {
            $errorMsg = "Sorry, there was an error uploading your file.";
        }
    }
}

// Fetch departments
$deptQuery = "SELECT id, Department FROM departments";
$deptResult = $conn->query($deptQuery);


// Fetch courses
$courseQuery = "SELECT id, Course FROM courses";
$courseResult = $conn->query($courseQuery);

// echo "<pre>";
// print_r($deptResult);die;
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
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> -->
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
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.container {
    width: 50%;
    height:auto;
    margin: 50px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
.showw{
    width:200px;
    height: 200px;
    border: 2px solid black;
    align-content: end;
}
.profile-form {
    display: inline;
    /* flex-wrap: wrap; */
}

.form-column {
    flex: 0 0 45%; /* Adjust the width as needed */
    margin-right: 5%; /* Adjust the margin between columns */
}

.form-group {
    margin: 15px;
    
}

label {
    font-weight: bold;
}

input,
select {
    width: 100%;
    padding: 8px;
    margin-top: 8px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
}

select {
    height: 34px;
}

.bttn {
    background-color: #4caf50;
    color: #fff;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.bttn:hover {
    background-color: #45a049;
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
            <li> <a href="reigster.php">Register  </a> </li>
            <li> <a href="http://localhost/mohit/cdac/login.php"> Login </a> </li>

        </ul>
    </div>
</nav>
<div class="textbox ">
    <h1> C-DAC Center @ Mohali </h1>
 
</div>


<div class="container">
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data" class="profile-form">
            <div class="form-group">
                <div id="Show" class="showw"> </div>
                <label for="File">Select Profile Image:</label>
                <br/>
                <input type="File" name="File" id="File" onchange="ImagePreview(event)">
                <br/>
            </div>

            <div class="form-group">
                <label for="did">Department Name</label>
                <select id="did" name="did" required>
                    <?php
                    // print_r($deptResult->num_rows);
                    // die();
if($deptResult->num_rows>0){
    while($row = $deptResult->fetch_assoc()){
        echo  "<option value='" .$row["id"] . "'>" .htmlspecialchars($row["Department"]) . "</option>";
    }
}else{
    echo "<option value=''> No Departments available </option>";
}

// die();

?>
                    <!-- ... (your PHP code for department dropdown options) -->
                </select>
            </div>

            <div class="form-group">
                <label for="cid">Course Name</label>
                <select id="cid" name="cid" required>
                    <!-- ... (your PHP code for course dropdown options) -->
                    <?php
if($courseResult->num_rows>0){
    while($row = $courseResult->fetch_assoc()){
        // echo  "<option value'" .$row["id"] . "'>" .htmlspecialchars($row["Course"]) . "</option>";
        echo "<option value='" . $row["id"] . "'>" . htmlspecialchars($row["Course"]) . "</option>";
    }
}else{
    echo "<option value=''> No Departments available </option>";
}


?>
                </select>
            </div>

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" required>
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>

            <div class="form-group">
                <label for="gender">Gender</label>
                <select name="gender" id="gender">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" name="address" id="address">
            </div>

            <div class="form-group">
                <label for="state">State</label>
                <input type="text" name="state" id="state">
            </div>

            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="tel" name="phone" id="phone">
            </div>

            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" name="dob" id="dob">
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <select name="role" id="role">
                    <option value="1">Admin</option>
                    <option value="2">Student</option>
                </select>
            </div>

            <input type="submit" name="submitProfile" value="Submit Profile" class="bttn">
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
<script>
function ImagePreview(event){

    var image1 = URL.createObjectURL(event.target.files[0]);
    var imagediv = document.getElementById('Show');
    var newimage = document.createElement('img');
    imagediv.innerHTML = "";
      newimage.src = image1;
      newimage.width="200";
      newimage.height="200";
    imagediv.appendChild(newimage);
}


    </script>
</html>