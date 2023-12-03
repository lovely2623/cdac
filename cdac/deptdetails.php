<?php
session_start();
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
    margin: 0 200px;
    padding: 10px;
    background:whites;
    border-radius:10px;
    height:500px;
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
            <li> <a href="http://localhost/mohit/cdac/login.php"> Login </a> </li>

        </ul>
    </div>
</nav>
<div class="textboxx ">
    <h1 > C-DAC Center @ Mohali </h1>
 
</div>



<div class="container">
        <h2 class="text-center mb-4">Department Details</h2>

        <?php
        include "connection.php";

        $sql = "SELECT * FROM departments";
        $result = $conn->query($sql);

        // Check for delete request
        
        if (isset($_GET['delete_id'])) {
            $delete_id = $conn->real_escape_string($_GET['delete_id']);
            $delete_sql = "DELETE FROM departments WHERE id=?";
            $delete_stmt = $conn->prepare($delete_sql);
            $delete_stmt->bind_param("i", $delete_id);
            $delete_stmt->execute();
            $delete_stmt->close();
            echo "Data deleted";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }

        if ($result->num_rows > 0) {
            echo "<table class='table table-bordered table-striped'>
                    <thead class='thead-dark'>
                        <tr>
                            <th>ID</th>
                            <th>Courses</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>";

            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["id"] . "</td>
                        <td>" . htmlspecialchars($row["Department"]) . "</td>
                        
                        <td>
                            <a href='deptedit.php?id=" . $row["id"] . "' class='butn btn-primary btn-sm'>Edit</a>
                            <a href='dept.php?id=" . $row["id"] . "' class='butn btn-primary btn-sm'>Add Course</a>
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
</html>