<?php
session_start();
require "./config.php";

$id = (int)$_GET["id"];
$err_message = null;

if(!isset($id) || !filter_var($id, FILTER_VALIDATE_INT)){
  $_SESSION["err_message"] = "The requested item couldn't be found.";
  header("Location: index.php");
  exit;
}

try{
  $sql = "SELECT username, email, phone, address
        FROM users WHERE id = ?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "i", $id);
  mysqli_stmt_execute($stmt);

  $result = mysqli_stmt_get_result($stmt);
  $user = mysqli_fetch_assoc($result);
}
catch(mysqli_sql_exception $e){
  error_log($e->getMessage());
  $err_message = "Something went wrong.";
}

if(isset($_SESSION["err_message"])){
  $err_message = $_SESSION["err_message"];
  unset($_SESSION["err_message"]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit User</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="wrapper form-wrapper">
    <h1>Edit User</h1>

    <?php if(isset($err_message)): ?>
      <p class="err-display"><?= htmlspecialchars($err_message) ?></p>
    <?php endif; ?>

    <form action="./actions.php?id=<?= $id ?>" method="POST">
      <div class="input-box">
        <input type="text" name="username" id="username" value="<?= $user['username'] ?>" placeholder=" ">
        <label for="username">Username</label>
      </div>
      <div class="input-box">
        <input type="email" name="email" id="email" value="<?= $user['email'] ?>" placeholder=" ">
        <label for="email">Email</label>
      </div>
      <div class="input-box">
        <input type="text" name="phone" id="phone" value="<?= $user['phone'] ?>" placeholder=" ">
        <label for="phone">Phone</label>
      </div>
      <div class="input-box">
        <textarea name="address" id="address" placeholder=" "><?= $user['address'] ?></textarea>
        <label for="address">Address</label>
      </div>

      <div class="btn-wrapper">
        <button type="submit" name="btn-edit">Edit</button>
        <a href="./index.php">Cancel</a>
      </div>
    </form>
  </div>
</body>
</html>