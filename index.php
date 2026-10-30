<?php
session_start();
require "./config.php";

$sql = "SELECT * FROM users";
$query = mysqli_query($conn, $sql);

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
  <title>User Directory</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="wrapper">
    <div class="heading">
      <h1>Users</h1>
      <a href="./add.php" class="btn btn-add">Add</a>
    </div>
    
    <?php if(isset($err_message)): ?>
      <p class="err-display"><?= htmlspecialchars($err_message) ?></p>
    <?php endif; ?>

    <div class="table-wrapper">
      <table class="table-contents">
        <tr>
          <th>No.</th>
          <th>Username</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Address</th>
          <th>Actions</th>
        </tr>

        <?php
        $num = 1;
        while($user = mysqli_fetch_assoc($query)):
        ?>
          <tr>
            <td><?= htmlspecialchars($num++) ?></td>
            <td><?= htmlspecialchars($user["username"]) ?></td>
            <td><?= htmlspecialchars($user["email"]) ?></td>
            <td><?= htmlspecialchars($user["phone"]) ?></td>
            <td><?= htmlspecialchars($user["address"]) ?></td>
            <td>
              <div class="btn-wrapper">
                <a href="edit.php?id=<?= $user['id'] ?>" class="btn btn-edit">Edit</a>

                <form action="actions.php?id=<?= $user['id'] ?>" method="POST">
                  <button
                    type="submit"
                    name="btn-delete"
                    onclick="return confirm('Do you want to delete this user?')" class="btn btn-delete"
                  >
                    Delete
                  </button>
                </form>
              </div>
            </td>
          </tr>
        <?php endwhile; ?>
      </table>
    </div>
  </div>
</body>
</html>