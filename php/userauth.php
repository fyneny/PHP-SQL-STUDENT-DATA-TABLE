<?php session_start ()?>
<?php

require_once "../config.php";

//register users
function registerUser($fullnames, $email, $password, $gender, $country){
    //create a connection variable using the db function in config.php
    $conn = db();
    if(mysqli_num_rows(mysqli_query($conn,"SELECT * FROM students WHERE email='$email'"))>=1){
        echo "<script> alert('User Email Already Taken')</script>";
        header ("refresh: 0.5; url=../forms/register.php");
    }
   //check if user with this email already exist in the database
   
   else{
        $sql = "INSERT INTO `Students` (`full_names`, `country`, `email`, `gender`,`password`) VALUES ('$fullnames', '$country', '$email', '$gender', 'password')";
        if(mysqli_query($conn,$sql)){
           echo "<script>alert('User Successfully Created !!')</script>";
          header("refresh: 2; url=../forms/login.php");
        }
       else{
          echo "<script> alert('An Error Occured Please Try Again')</script>";
        }
    }
}

//login users
function loginUser($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();
    $query ="SELECT * FROM students WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) >= 1){ 
        session_start(); 
        $_SESSION['username'] =$email;
        header("Location: ../dashboard.php");
        }
    else{
        header("Location: ../forms/login.php?meassage=invalid");
    }
    echo "<h1 style='color: red'> LOG ME IN (IMPLEMENT ME) </h1>";
    //open connection to the database and check if username exist in the database
    //if it does, check if the password is the same with what is given
    //if true then set user session for the user and redirect to the dasbboard
}


function resetPassword($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();
    if(mysqli_num_rows(mysqli_query($conn,"SELECT * FROM students WHERE email='$email'"))>=1){
        //if it does, replace the password with $password given
        $sql = "UPDATE table students set password='$password' where email='$email'";
        if(mysqli_query($conn, $sql)){
            echo "<script> alert('PASSWORD UPDATE SUCCESSFUL!!')</script>";
        }
        else{
            echo "<h1 style='color: red'>USER DOES NOT EXIST</h1>";
        }
    }
    else{
        echo "An error has Occured";
    }
    //open connection to the database and check if username exist in the database
    
}

function getusers(){
    $conn = db();
    $sql = "SELECT * FROM Students";
    $result = mysqli_query($conn, $sql);
    echo"<html>
    <head></head>
    <body>
    <center><h1><u> ZURI PHP STUDENTS </u> </h1> 
    <table border='1' style='width: 700px; background-color: magenta; border-style: none'; >
    <tr style='height: 40px'><th>ID</th><th>Full Names</th> <th>Email</th> <th>Gender</th> <th>Country</th> <th>Action</th></tr>";
    if(mysqli_num_rows($result) > 0){
        while($data = mysqli_fetch_assoc($result)){
            //show data
            echo "<tr style='height: 30px'>".
                "<td style='width: 50px; background: blue'>" . $data['id'] . "</td>
                <td style='width: 150px'>" . $data['full_names'] .
                "</td> <td style='width: 150px'>" . $data['email'] .
                "</td> <td style='width: 150px'>" . $data['gender'] . 
                "</td> <td style='width: 150px'>" . $data['country'] . 
                "</td>
                <form action='action.php' method='post'>
                <input type='hidden' name='id'" .
                 "value=" . $data['id'] . ">".
                "<td style='width: 150px'> <button type='submit', name='delete'> DELETE </button>".
                "</tr>";
        }
        echo "</table></table></center></body></html>";
    }
    //return users from the database
    //loop through the users and display them on a table
}

function deleteaccount($id){
    $conn = db();
    //delete user with the given id from the database
    if(mysqli_num_rows(mysqli_query($conn,"SELECT * FROM students WHERE id=$id"))){
        $sql = "DELETE FROM students WHERE id=$id";
        if(mysqli_query($conn, $sql)){
            echo "<script> alert ('DELETED')</script>";
            header("refresh: 0.5; url=action.php?all=");
        }
    }
}
