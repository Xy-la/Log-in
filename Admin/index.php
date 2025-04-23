<?php
session_start();
include 'db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = trim($_POST["username"]);
  $password = trim($_POST["password"]);

  $sql = "SELECT * FROM users WHERE username = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $username);

  if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
      $user = $result->fetch_assoc();

      if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header("Location: dashboard.php");
        exit;
      } else {
        $error = "Invalid password.";
      }
    } else {
      $error = "User not found.";
    }
  } else {
    $error = "Something went wrong.";
  }
}
?>


<!DOCTYPE html>
<html>

<head>
  <title>Admin Login</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(45deg, #3498db, #2ecc71);
      color: #333;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .container {
      background-color: #fff;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
      text-align: center;
    }

    h1 {
      font-size: 32px;
      color: #2c3e50;
      margin-bottom: 10px;
    }

    p.subtitle {
      font-size: 14px;
      color: #555;
      margin-bottom: 25px;
    }

    form {
      width: 100%;
    }

    label {
      display: block;
      margin-bottom: 6px;
      font-weight: bold;
      font-size: 14px;
      text-align: left;
    }

    input[type='text'],
    input[type='password'] {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 14px;
      transition: border-color 0.3s ease;
    }

    input[type='text']:focus,
    input[type='password']:focus {
      border-color: #2ecc71;
      outline: none;
    }

    a {
      display: block;
      text-align: right;
      font-size: 13px;
      color: #3498db;
      text-decoration: none;
      margin-bottom: 16px;
    }

    a:hover {
      text-decoration: underline;
    }

    button {
      width: 100%;
      background-color: #2ecc71;
      color: white;
      border: none;
      padding: 12px;
      font-size: 16px;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #27ae60;
    }

    @media (max-width: 480px) {
      .container {
        padding: 30px;
        width: 90%;
      }

      h1 {
        font-size: 28px;
      }

      button {
        font-size: 14px;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>Admin</h1>
    <p class="subtitle">Access your Barangay management system</p>
    <?php if ($error): ?>
      <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST">
      <label for="username">Enter your username</label>
      <input type="text" id="username" name="username" required />
      <label for="password">Enter your password</label>
      <input type="password" id="password" name="password" required />
      <a href="#">Forgot Password?</a>
      <button type="submit">Login</button>
    </form>
  </div>
</body>

</html>