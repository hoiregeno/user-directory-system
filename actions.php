<?php
session_start();
require "./config.php";

// Adds new user details
if(isset($_POST["btn-add"])){
  $username = trim($_POST["username"]) ?? "";
  $email = trim($_POST["email"]) ?? "";
  $phone = trim($_POST["phone"]) ?? "";
  $address = trim($_POST["address"]) ?? "";

  if($username === "" || $email === "" || $phone === "" || $address === ""){
    $_SESSION["err_message"] = "Please fill all fields.";
    header("Location: ./add.php");
    exit;
  }

  // Capitalize username and address (optional)
  $username = ucwords($username);
  $address = ucwords($address);

  // Add user details
  try{
    $sql = "INSERT INTO users (username, email, phone, address)
            VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $phone, $address);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
    header("Location: ./index.php");
    exit;
  }
  catch(mysqli_sql_exception $e){
    error_log($e->getMessage());

    if($e->getCode() === 1062){
      $_SESSION["err_message"] = "User already exists. Please try again.";
    }
    else{
      $_SESSION["err_message"] = "Something went wrong.";
    }

    header("Location: ./add.php");
    exit;
  }
}

// Edits existing user details
if(isset($_POST["btn-edit"])){
  if(!isset($_GET["id"])){
    $_SESSION["err_message"] = "The requested item couldn't be updated.";
    header("Location: index.php");
    exit;
  }  

  $id = (int)$_GET["id"]; // Existing user id
  $username = trim($_POST["username"]) ?? "";
  $email = trim($_POST["email"]) ?? "";
  $phone = trim($_POST["phone"]) ?? "";
  $address = trim($_POST["address"]) ?? "";

  if($username === "" || $email === "" || $phone === "" || $address === ""){
    $_SESSION["err_message"] = "Please fill all fields.";
    header("Location: edit.php");
    exit;
  }

  // Capitalize username and address (optional)
  $username = ucwords($username);
  $address = ucwords($address);

  // Update user details
  try{
    $sql = "UPDATE users
            SET username = ?, email = ?, phone = ?, address = ?
            WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssi", $username, $email, $phone, $address, $id);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
    header("Location: ./index.php");
    exit;
  }
  catch(mysqli_sql_exception $e){
    if($e->getCode() === 1062){
      $_SESSION["err_message"] = "User already exists. Please try again.";
    }
    else{
      $_SESSION["err_message"] = "Something went wrong.";
    }
        
    error_log($e->getMessage());
    header("Location: edit.php");
    exit;
  }
}

// Deletes existing user
if(isset($_POST["btn-delete"])){
  if(!isset($_GET["id"])){
    $_SESSION["err_message"] = "The requested item couldn't be updated.";
    header("Location: index.php");
    exit;
  }

  $id = (int)$_GET["id"];
  $err_message = null;

  if(!isset($id) || !filter_var($id, FILTER_VALIDATE_INT)){
    $_SESSION["err_message"] = "The requested item couldn't be found.";
    header("Location: index.php");
    exit;
  }

  try{
    $sql = "DELETE FROM users
            WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
    header("Location: index.php");
    exit;
  }
  catch(mysqli_sql_exception $e){
    error_log($e->getMessage());
    $_SESSION["err_message"] = "Something went wrong. Couldn't delete user.";
    header("Location: index.php");
    exit;
  }
}