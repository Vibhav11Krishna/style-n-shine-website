<?php
session_start();
include 'db/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name    = trim($_POST['name']);
    $email   = trim($_POST['email']);
    $mobile  = trim($_POST['mobile']);
    $service = trim($_POST['service']);
    $date    = trim($_POST['date']);

    // Check if any field is empty. If so, stop execution and do NOT insert into database.
    if (empty($name) || empty($email) || empty($mobile) || empty($service) || empty($date)) {
        header("Location: index.html?error=empty_fields");
        exit;
    }

    // Insert booking into DB using prepared statements to prevent SQL injection
    $stmt = $conn->prepare("
        INSERT INTO bookings (name, email, mobile, service, date)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("sssss", $name, $email, $mobile, $service, $date);
    $stmt->execute();
    $stmt->close();
?>
<!DOCTYPE html>
<html>
<head>
<title>Booking Confirmed</title>

<!-- Auto Redirect back to website after 4 seconds -->
<script>
  window.onload = function () {
    setTimeout(function () {
      window.location.href = "index.html";
    }, 4000); // 4 seconds delay
  };
</script>

<style>
  body {
    font-family: Arial, sans-serif;
    text-align: center;
    background: #000000;
    color: #FFD700;
    padding: 60px;
  }

  .box {
    background: #0f0f0f;
    border: 2px solid #FFD700;
    padding: 35px;
    border-radius: 18px;
    display: inline-block;
    box-shadow: 0 0 18px rgba(255,215,0,0.3);
    max-width: 450px;
  }

  h2 {
    color: #FFD700;
    margin-bottom: 15px;
  }

  p {
    margin: 10px 0;
    color: #d4d4d4;
    font-size: 15px;
  }

  .btn {
    margin-top: 20px;
    padding: 12px 20px;
    border-radius: 12px;
    border: 2px solid #FFD700;
    background: transparent;
    color: #FFD700;
    font-weight: bold;
    text-decoration: none;
    display: inline-block;
    transition: 0.3s;
  }

  .btn:hover {
    background: #FFD700;
    color: #000000;
  }
</style>
</head>

<body>

<div class="box">
  <h2>Booking Successful 🎉</h2>

  <p>Thank you, <b><?php echo htmlspecialchars($name); ?></b>.</p>
  <p>Your booking has been successfully saved in our system.</p>
  <p><b>You will be notified shortly regarding your slot confirmation.</b></p>

  <p style="font-size: 12px; color: #888; margin-top: 15px;">Redirecting back to the website...</p>

  <!-- Fallback button -->
  <a class="btn" href="index.html">
    Back to Website Now
  </a>
</div>

</body>
</html>

<?php } else {
    // If someone accesses booking.php directly without submitting the form, redirect home
    header("Location: index.html");
    exit;
} ?>