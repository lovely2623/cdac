<?php
session_start();
include "connection.php";
$successMsg = "";
$errorMsg = "";
$formSubmitted = false;

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $formSubmitted = true;

    $courseName = $conn->real_escape_string ($_POST['courseName']);
    // $courseTeacher = $conn-> real_escape_string($_POST['courseTeacher']);


// Check if the course already exist.
    $checkSql = $conn->prepare("SELECT * FROM courses WHERE Course = '$courseName'");
    $checkSql->execute();
    $result = $checkSql->get_result();

    if ($result->num_rows>0){
        //already exists
        $errorMsg = "Error: Course name already exists.";
    }else{
        //insert new records
        $insertSql = $conn->prepare("Insert Into courses(Course) VALUES ('$courseName')");

if($insertSql->execute()){
    $successMsg = "Course Added successfully";
}else{
    $errorMsg = "Error:" .$insertSql->error;

}

    }
$checkSql ->close();


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

.admin-box {
      width: 90%;
      height: 400px;
      border: 2px solid black;
      border-radius: 8px;
      background-color: white;
      padding: 20px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      margin: 70px 60px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      position: relative;
    }

    .crs{
        height:50px;
        background-color: white;
        display: flex;
      flex-direction: column;
      padding:4px;
    }
    .formcourse{
    width:300px;
    height: 200px;
  
    background:white;
    margin: 50px  auto;
    

}
.formcourse label,input{
font-weight:bold;
border-radius: 4px;

}


    h2 {
      text-align: center;
      color: #333;
    }
    .buton {
left:90%;
        position:absolute;
    background-color: blue;
    color: white;
    padding: 10px;
    width: 90px;
    letter-spacing: 2px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
.bttn1{
    background-color: blue;
    color: white;
    padding: 10px;
    width: 130px;
    letter-spacing: 2px;
    border: none;
    border-radius: 4px;
    cursor: pointer;   
    margin: 40px 0 0 25px;
}
.logout{
    text-decoration:none;
    color:white;
}
button:hover {
    background-color: #45a049;
}
.prev{
    background-color: blue;
    color: white;
    padding: 10px;
    border-radius: 5px;
    cursor: pointer; 
    width: 130px;
    letter-spacing: 2px;
    left:78%;
        position:absolute;

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
            <li> <a href=""> Login </a> </li>

        </ul>
    </div>
</nav>
<div class="textbox ">
    <h1 > C-DAC Center @ Mohali </h1>
 
</div>

<div class="admin-box">
<div class="crs">
<h2>Welcome! <br/><br/> <?php echo isset($_SESSION['name']) ? $_SESSION['name'] : ''; ?> (Admin !)</h2>
    <button type="submit" class="buton prev btn-primary"> <a href= "coursedetails.php">Previous</a></button>

    <button class="buton" > <a class="logout" href="http://localhost/mohit/cdac/login.php">Logout</a> </button>
</div>

<div class="containercourse">
        <?php
        // Display messages only if the form has been submitted
        if ($formSubmitted) {
            if (!empty($successMsg)) {
                echo "<p style='color: green;'>$successMsg</p>";
            } elseif (!empty($errorMsg)) {
                echo "<p style='color: red;'>$errorMsg</p>";
            }
        }
        ?>
        <div class="formcourse">
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
                <label for="courseName">Course Name:-</label><br/><br/>
                <input type="text" class="form-control" id="courseName" name="courseName" required>
                <br>

                <button type="submit" class="bttn1 btn-primary">ADD Course</button>
        </form>
    </div>
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


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>






