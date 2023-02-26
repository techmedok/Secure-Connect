<?php
session_start();
// check if user is logged in
if (!isset($_SESSION['username'])) {
  header('Location: ../signin'); // redirect to login page if user is not logged in
  exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $servername = "";
    $user = "";
    $password = "";
    $dbname = "";
    $username = $_SESSION['username'];
    // Create connection
    $conn = new mysqli($servername, $user, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Loop through each file input field and process the uploaded file
    $field_names = array('aadhar', 'license', 'photo');
    foreach ($field_names as $i => $field_name) {
        if (isset($_FILES[$field_name]) && $_FILES[$field_name]['error'] == UPLOAD_ERR_OK) {
            // Generate random filename
            $filename = uniqid() . '.' . pathinfo($_FILES[$field_name]['name'], PATHINFO_EXTENSION);

            // Move uploaded file to desired location
            move_uploaded_file($_FILES[$field_name]['tmp_name'], '../storage/'.$filename);

            // Update file location in database
            $sql = "UPDATE users SET $field_name='https://secureconnect.techmedok.com/storage/$filename' WHERE username='$username'";
            $conn->query($sql);
        }
    }

    $conn->close();
    header('Location: ../document-upload'); // redirect to login page if user is not logged in
    exit();

}

