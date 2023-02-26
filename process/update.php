<?php
// establish a database connection
$host = '';
$user = '';
$pass = '';
$database = '';
$conn = mysqli_connect($host, $user, $pass, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();
// check if user is logged in
if (!isset($_SESSION['username'])) {
  header('Location: ../signin'); // redirect to login page if user is not logged in
  exit();
}

// get username from session
$username = $_SESSION['username'];

// get the updated user data from the form submission
$name = $_POST['name'];
$email = $_POST['email'];
$dob = $_POST['dob'];
$cc = $_POST['cc'];
$phone = $_POST['phone'];
$dno = $_POST['dno'];
$street = $_POST['street'];
$city = $_POST['city'];
$state = $_POST['state'];
$country = $_POST['country'];
$cardno = $_POST['cardno'];
$cvv = $_POST['cvv'];
$expdate = $_POST['expdate'];

// update the user data in the MySQL database
$query = "UPDATE users SET name='$name', email='$email', dob='$dob', cc ='$cc', phone ='$phone', dno ='$dno', street ='$street', city ='$city', state ='$state', country ='$country', cardno ='$cardno', cvv ='$cvv', expdate ='$expdate' WHERE username='$username'";
$result = mysqli_query($conn, $query);

// redirect the user to the dashboard page
header('Location: ../edit-data/');
exit();

// close the database connection
mysqli_close($conn);
?>