
<?php
session_start();

include "connection.php"; // Include your database connection file

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];

    $sql = "SELECT 
        students.*, 
        uimage.filename AS filename,  
        departments.Department AS Department, 
        courses.Course AS Course
    FROM students 
    LEFT JOIN uimage ON students.Pid = uimage.id  
    LEFT JOIN departments ON students.Did = departments.id 
    LEFT JOIN courses ON students.Cid = courses.id 
    WHERE students.Username = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
 } else {
        echo "<div class='container mt-5'><p>User profile not found.</p></div>";
    }
} 
else {
    echo "<div class='container mt-5'><p>Please log in to view this page.</p></div>";
}

$conn->close();
?>
<?php

include "connection.php";

$errorMsg = "";
$formSubmitted = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $formSubmitted = true;

    $username = $conn->real_escape_string($_POST['username']);
    $userPassword = $conn->real_escape_string($_POST['password']);

    // Fetch the user's data from the database
    $sql = "SELECT Username, Password, Role, Name FROM students WHERE Username = ? OR Email = ?";
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

        if (password_verify($userPassword, $hashedPassword)) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;
            $_SESSION['name'] = $fullName;

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
        /* Add your custom styles here */
        
        .profile-image {
            width: 200px;
            max-height: 200px;
            border-radius: 15%;
            margin-right: 10px;
          
           
        }

        .profile-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 600px; /* Adjust the height as needed */
    margin:auto;
    width:700px;
    margin-top: 20px;


}
.textboxx h1{
    position: absolute;
    top: 80px;
    left:36% ;
    letter-spacing: 2px;
    color: black;
}
.profile-box {
    width: 600px; /* Adjust the width as needed */
    border: 1px solid #ccc;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.profile-header {
    /* background-color: #007bff; */
    color: #fff;
    padding: 10px;
    text-align: end;
}

.profile-body {
    padding: 20px;
    text-align: justify; /* Justify the text within the profile body */
}

.profile-title {
    background:grey;
    text-align: center;

}

.btn-primary26{
    color:white;
    background:blue;
    margin-left:380px;
    border-radius: 4px;
    padding:4px;
    cursor:pointer;

}

a{
    text-decoration:none;
}

:root {
  --primary: #eeeeee;
  --secondary: #227c70;
  --green: #82cd47;
  --secondary-light: rgb(34, 124, 112, 0.2);
  --secondary-light-2: rgb(127, 183, 126, 0.1);
  --white: #fff;
  --black: #393e46;

  --shadow: 0px 2px 8px 0px var(--secondary-light);
}


.profile-dropdown-btn {
  width: auto;
  border-radius: 5px;
  cursor: pointer;
  transition: box-shadow 0.2s ease-in, background-color 0.2s ease-in,
    border 0.3s;
}

.profile-dropdown-list {
  position: absolute;
  top: 60px;
  width: 250px;
  right: 0;
  background-color: white;
  border-radius: 10px;
  max-height: 0;
  overflow: hidden;
  box-shadow: var(--shadow);
  z-index:1;
  
}


.profile-dropdown-list hr {
  border: 0.5px solid var(--green);
}

.profile-dropdown-list.active {
  max-height: 500px;
}

.profile-dropdown-list-item {
  padding: 0.5rem 0rem 0.5rem 1rem;
  transition: background-color 0.2s ease-in, padding-left 0.2s;
}

.profile-dropdown-list-item a {
  display: flex;
  align-items: center;
  text-decoration: none;
  font-size: 0.9rem;
  font-weight: 500;
  color: var(--black);
}

.profile-dropdown-list-item a i {
  margin-right: 0.8rem;
  font-size: 1.1rem;
  width: 2.3rem;
  height: 2.3rem;
  background-color: var(--secondary);
  color: var(--white);
  line-height: 2.3rem;
  text-align: center;
  margin-right: 1rem;
  border-radius: 50%;
  transition: margin-right 0.3s;
}

.profile-dropdown-list-item:hover {
  padding-left: 1.5rem;
  background-color: var(--secondary-light);
}
.img26 {
    position:absolute;
    left:-40px;
    top:-3px;
}



@media print{
    body *{
        visibility:hidden;

    }
    #print, #print *{
        visibility:visible;
    }

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
            <li class ="profile-dropdown-btn" >  <a href="">  <img  onclick="toggle()" class=" img26" src="<?php echo $row["filename"]; ?>" alt="Profile Picture" onclick="toggleDropdown()" class="profie-picture" style="width: 30px; height: 30px; border-radius: 50%;">
            Login as <?php 
            echo isset($_SESSION['name']) ? $_SESSION['name'] : ''; ?>
            
            <i class="fa-solid fa-angle-down "></i>
        
        </a> </li>
        

       <ul class="profile-dropdown-list">

          <li class="profile-dropdown-list-item">
            <a href="">
              Edit Profile
              <i class="fa-regular fa-user"></i>

            </a>
          </li>


          <li class="profile-dropdown-list-item">
            <a href="#">
              Help & Support
              <i class="fa-regular fa-circle-question"></i>

            </a>
          </li>
          <hr />

          <li class="profile-dropdown-list-item">
            <a href="logout.php">
              Log out
              <i class="fa-solid fa-arrow-right-from-bracket"></i>

            </a>
          </li>

 
      </ul>
     

</ul>
    </div>
</nav>
<div class="textboxx ">
    <h1 > C-DAC Center @ Mohali </h1>
 
</div>
    <div class="container26 mt-5">
        <?php
        if ($role == 2) {
            
            echo "<div class='profile-container ' id='print'>
            <div class='profile-box'>
            <h3 class='profile-title'>" . htmlspecialchars($row["Name"]) . "</h3>
            <div class='profile-header'>
                    <img src='" . $row["filename"] . "' alt='Profile Image' class='profile-image'>
                    
                </div>
                <div class='profile-body'>
                    <p class='profile-text'>
                        <strong>Username:</strong> " . htmlspecialchars($row["Username"]) . "<br>
                        <strong>Email:</strong> " . htmlspecialchars($row["Email"]) . "<br>
                        <strong>Department Name:</strong> " . htmlspecialchars($row["Department"]) . "<br>
                        <strong>Course Name:</strong> " . htmlspecialchars($row["Course"]) . "<br>
                        <strong>Phone Number:</strong> " . $row["Phone"] . "<br>
                        <strong>Gender:</strong> " . htmlspecialchars($row["Gender"]) . "<br>
                        <strong>Address:</strong> " . htmlspecialchars($row["Address"]) . "<br>
                        <strong>State:</strong> " . htmlspecialchars($row["State"]) . "<br>
                        <strong>Date of Birth:</strong> " . $row["Dob"] . "<br>
                        
                    </p>
                </div>
            </div>
          </div>";
        } else {
            echo "<div class='card'>
                    <div class='card-header'>
                        Admin Profile
                    </div>
                </div>";
        }
        ?>
        <button  onclick="printForm()" class=' btn-primary26'>Print</button>
                                <a href='studentedit.php' class=' btn-primary26'>Edit Details</a>
<br/>
<br/>

        <div><a class=' btn-primary26' href='login.php'>Logout</a></div>
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

function printForm(){
    window.print();
}


</script>
<script>
//first js

let profileDropdownList = document.querySelector(".profile-dropdown-list");
let btn = document.querySelector(".profile-dropdown-btn");

let classList = profileDropdownList.classList;

btn.addEventListener("mouseenter", function () {
  classList.add("active");
});

window.addEventListener("click", function () {
  classList.remove("active");
});





//2nd js for dropdown

// let profileDropdownList = document.querySelector(".profile-dropdown-list");
// let btn = document.querySelector(".profile-dropdown-btn");

// let classList = profileDropdownList.classList;

// btn.addEventListener("click", function (event) {
//   event.stopPropagation(); // Stop the click event from reaching the window listener
//   classList.toggle("active"); // Use toggle to handle both adding and removing
// });

// window.addEventListener("click", function () {
//   classList.remove("active");
// });





</script>
</html>

