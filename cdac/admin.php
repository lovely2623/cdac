

<?php
session_start();




 if (!isset($_SESSION['username']) || $_SESSION['role'] != 1) {
    header("Location: login.php");
     exit();
 }

include "connection.php"; 
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



// Fetch total number of students
$sqlStudents = "SELECT COUNT(*) as total_students FROM students WHERE role = 2";
$resultStudents = $conn->query($sqlStudents);
$rowStudents = $resultStudents->fetch_assoc();
$totalStudents = $rowStudents['total_students'];

// Fetch total number of teachers from student_course table
$sqlcourses = "SELECT COUNT(DISTINCT Course) as total_courses FROM courses";
$resultcourses = $conn->query($sqlcourses);
$rowcourses = $resultcourses->fetch_assoc();
$totalcourses = $rowcourses['total_courses'];

// Fetch total number of courses
$sqldept = "SELECT COUNT(*) as total_Department FROM departments";
$resultdept = $conn->query($sqldept);
$rowdept = $resultdept->fetch_assoc();
$totaldept = $rowdept['total_Department'];
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
<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background:white;
        }


        .contain{
            width: 400px;
            height:600px;
            padding: 20px;
            background-color: whitesmoke;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            margin-left:20px;
        }
     
        .container {
            
            width: 800px;
            margin-right:18px;
            padding: 10px;
            background-color: whitesmoke;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            float:right;
        }

        h2 {
            color: #333;
        }

        p {
            color: #666;
        }

        .row {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }

        .col-md-4 {
            width: 30%;
        }

        .dashboard-box {
            background-color: white;
            /* background-color: #1E90FF; */
            color: black;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 20px;
        }
       

        .total-count {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
            color:blue;
        }
        .total-countt {
           color:black;
            font-weight: bold;
        }

        .btnnn {
            padding: 12px 22px;
            margin: 4px 25px;
            text-decoration: none;
            color: black;
            border-radius: 5px;
        }
        .contain ul li{
            list-style: none;

        }

        .btn-primary {
            background-color: white;
          
        }

        .btn-danger {
            background-color: #e74c3c;
        }
.aside{
    width: 350px;
    height: 300px;
    background: wheat;
    padding:20px;
}
.aside a{
    display:block;
    width: 200px;
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

 

    </style>
    
</head>

<body>
<section class="header">
<nav>
    <a href="C-DAC Centre @ Mohali.html" > 
        <img src="cdac-logo.png" class="logo">
    </a>
    <div class="nav-links list26">
        <ul>
    
            <li> <a href="http://localhost/mohit/cdac/cdac.php"> Home </a> </li>
            <li> <a href=""> About Us </a> </li>
            <li> <a href=""> Contact Us </a> </li>
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

<div class="textbox">
    <h1> C-DAC Center @ Mohali </h1>
 
</div> 



   
<div class="container">
   

    <div class="row">
        <div class="col-md-4">
            <div class="dashboard-box">
                <p class="total-count"><?php echo $totalStudents; ?></p>
                <p class="total-countt">   <i class="fas fa-users"></i>  Total Number of Students</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dashboard-box">
                <p class="total-count"><?php echo $totalcourses; ?></p>
                <p class="total-countt"> <i class="fas fa-book"></i> Total Number of Courses</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dashboard-box">
                <p class="total-count"><?php echo $totaldept; ?></p>
                <p class="total-countt"> <i class="fas fa-building"></i> Total Number of Departments</p>
            </div>
        </div>
    </div>

</div>


<div class="contain">
<h2>Welcome! <br/><br/> <?php echo isset($_SESSION['name']) ? $_SESSION['name'] : ''; ?> (Admin !)</h2>
    <p>This is the admin dashboard.</p>
    <br/><br/><br/>

    <div class="aside">
  <a href="fetch.php" class="btnnn btn-primary">Manage Students</a>
       <a href="coursedetails.php" class="btnnn btn-primary">Manage Courses</a>
  <a href="deptdetails.php" class="btnnn btn-primary">Manage Departments</a>
  <a href="login.php" class="btnnn btn-danger">Logout</a>
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
    <a  href="#" id="back-button"><p style="text-align: end; color:black; " >Back to Top</p></a>

</div>



    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
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