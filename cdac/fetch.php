<?php
session_start();
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
 

.container {
    width: 800px;
    height:auto;
    margin: 0 0;
    padding: 20px;
}
.container h2{
    margin: 50px 0px 0px 30px;
}
.out{
    margin: 50px 0px 0px 30px;
    font-size:18px;
    font-weight:bold;
}
.out a{
    text-decoration:none;
    color:black;

}

table {
    width: 100%;
    height:auto;
    border-collapse: collapse;
    margin: 50px 0px 0px 30px;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 10px;
    text-align: left;
}

th {
    background-color: #f2f2f2;
}

.butn {
    display: inline-block;
    padding: 5px 5px;
    margin-right: 5px;
    text-decoration: none;
    color: #fff;
    background-color: #007bff;
    border: 1px solid #007bff;
    border-radius: 4px;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

.btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
}

button {
    display: block;
    margin-top: 20px;
    padding: 10px;
    background-color: #28a745;
    border: 1px solid #28a745;
    color: #fff;
    text-decoration: none;
    cursor: pointer;
}
.textboxx h1{
    position: absolute;
    top: 80px;
    left:36% ;
    letter-spacing: 2px;
    color: red;
}
.textboxx h1:hover {
    color: red;
    animation: rubberBand;
    animation-duration: 3s;
    transition: all linear 5s;
    animation-iteration-count: infinite;
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
            <a href="fetch.php">
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

<div class="container">
        <h2 class="text-center mb-4">Students Details</h2>

        <?php
        include "connection.php";

        $sql = "SELECT * FROM students";
        $result = $conn->query($sql);

        // Check for delete request
        
        if (isset($_GET['delete_id'])) {
            $delete_id = $conn->real_escape_string($_GET['delete_id']);
            $delete_sql = "DELETE FROM students WHERE id=?";
            $delete_stmt = $conn->prepare($delete_sql);
            $delete_stmt->bind_param("i", $delete_id);
            $delete_stmt->execute();
            $delete_stmt->close();
            // echo "Data deleted";
            // header("Location: " . $_SERVER['PHP_SELF']);
            // exit;
        }

        if ($result->num_rows > 0) {
            echo "<table class='table table-bordered table-striped'>
                    <thead class='thead-dark'>
                        <tr>
                            <th>ID</th>
                            <th>Did</th>
                            <th>Cid</th>
                            <th>Pid</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Gender</th>
                            <th>Role</th>
                            <th>Address</th>
                            <th>State</th>
                            <th>DoB</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>";

            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["id"] . "</td>
                        <td>" . $row["Did"] . "</td>
                        <td>" . $row["Cid"] . "</td>
                        <td>" . $row["Pid"] . "</td>
                        <td>" . htmlspecialchars($row["Name"]) . "</td>
                        <td>" . htmlspecialchars($row["Username"]) . "</td>
                        <td>" . htmlspecialchars($row["Email"]) . "</td>
                        <td>" . $row["Phone"] . "</td>
                        <td>" . htmlspecialchars($row["Gender"]) . "</td>
                        <td>" . $row["Role"] . "</td>
                        <td>" . htmlspecialchars($row["Address"]) . "</td>
                        <td>" . htmlspecialchars($row["State"]) . "</td>
                        <td>" . $row["Dob"] . "</td>
                        <td>
                            <a href='edit.php?id=" . $row["id"] . "' class='butn btn-primary btn-sm'>Edit</a>
                            <a href='" . $_SERVER['PHP_SELF'] . "?delete_id=" . $row["id"] . "' class='butn btn-danger btn-sm'>Delete</a>
                        </td>
                    </tr>";

            }

            echo "</tbody>
                </table>";
        } else {
            echo "0 results";
        }

        // Close connection
        $conn->close();
        ?>
                <button class="out"> <a  href="http://localhost/mohit/cdac/login.php">Logout</a> </button>

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