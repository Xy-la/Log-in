<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header('Location: index.php');
  exit();
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Admin Dashboard</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f0f2f5;
      color: #333;
    }

    .sidebar-container {
      display: flex;
      justify-content: flex-start;
      align-items: center;
    }

    .sidebar {
      display: flex;
      flex-direction: column;
      padding: 20px;
      background-color: #2c3e50;
      color: white;
      border-radius: 10px;
      margin-right: 20px;
      width: 220px;
    }

    .sidebar a {
      text-decoration: none;
      color: white;
      padding: 15px;
      font-size: 18px;
      margin-bottom: 10px;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }

    .table-container {
      background-color: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      margin: 30px auto;
      max-width: 950px;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 2px solid #ccc;
    }

    h1 {
      color: #2c3e50;
      font-size: 30px;
      margin: 0;
    }

    .logout-btn {
      background-color: #e67e22;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      font-size: 14px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .logout-btn:hover {
      background-color: #d35400;
    }

    p.subtitle {
      text-align: center;
      font-size: 16px;
      margin: 20px 0;
      color: #555;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    thead {
      background-color: #2ecc71;
      color: white;
    }

    th,
    td {
      padding: 12px 15px;
      border-bottom: 1px solid #ddd;
      text-align: left;
      font-size: 14px;
    }

    tr:hover {
      background-color: #f9f9f9;
    }

    .update-btn,
    .delete-btn {
      padding: 8px 15px;
      border: none;
      border-radius: 5px;
      color: white;
      font-size: 14px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .update-btn {
      background-color: #3498db;
    }

    .update-btn:hover {
      background-color: #2980b9;
    }

    .delete-btn {
      background-color: #e74c3c;
    }

    .delete-btn:hover {
      background-color: #c0392b;
    }

    @media (max-width: 768px) {
      .table-container {
        padding: 20px;
        max-width: 90%;
      }

      h1 {
        font-size: 24px;
      }

      .logout-btn {
        padding: 8px 15px;
        font-size: 12px;
      }

      table {
        font-size: 12px;
      }

      th,
      td {
        padding: 8px 10px;
      }
    }
  </style>
</head>

<body>
  <div class="table-container">
    <div class="header">
      <h1>Dashboard</h1>
      <button class="logout-btn" onclick="window.location.href='logout.php'">Logout</button>
    </div>
    <p class="subtitle">Welcome back, Admin!</p>
    <div class="sidebar-container">
      <div class="sidebar">
        <a href="dashboard.php">Dashboard</a>
        <a href="#">Residents</a>
        <a href="#">Settings</a>
      </div>
      <table>
        <thead>
          <tr>
            <th>Resident Name</th>
            <th>Age</th>
            <th>Address</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          include 'db.php';

          $sql = "SELECT id, resident_name, age, address FROM residents";
          $result = $conn->query($sql);

          if ($result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
          ?>
              <tr>
                <td><?= htmlspecialchars($row['resident_name']) ?></td>
                <td><?= htmlspecialchars($row['age']) ?></td>
                <td><?= htmlspecialchars($row['address']) ?></td>
                <td>
                  <button class="update-btn">
                    <a href="edit.php?edit=<?= $row['id'] ?>" style="color: white; text-decoration: none;">Update</a>
                  </button>
                  <button class="delete-btn" onclick="if(confirm('Are you sure you want to delete this resident?')) window.location.href='delete.php?id=<?= $row['id'] ?>'">Delete</button>
                </td>
              </tr>
            <?php
            endwhile;
          else:
            ?>
            <tr>
              <td colspan="4">No residents found</td>
            </tr>
          <?php endif; ?>
        </tbody>

      </table>
    </div>
  </div>
</body>

</html>