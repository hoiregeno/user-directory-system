<?php
session_start();

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
  <title>Add User</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="wrapper form-wrapper">
    <h1>Add User</h1>

    <?php if(isset($err_message)): ?>
    <p class="err-display"><?= htmlspecialchars($err_message) ?></p>
    <?php endif; ?>

    <form action="./actions.php" method="POST">
      <div class="input-box">
        <input type="text" name="username" id="username" placeholder=" ">
        <label for="username">Username</label>
      </div>
      <div class="input-box">
        <input type="email" name="email" id="email" placeholder=" ">
        <label for="email">Email</label>
      </div>
      <div class="input-box">
        <input type="text" name="phone" id="phone" placeholder=" ">
        <label for="phone">Phone</label>
      </div>
      <div class="input-box">
        <textarea name="address" id="address" placeholder=" "></textarea>
        <label for="address">Address</label>
      </div>

      <div class="btn-wrapper">
        <button type="submit" name="btn-add">Add</button>
        <a href="./index.php">Cancel</a>
      </div>
    </form>
  </div>
</body>
</html>