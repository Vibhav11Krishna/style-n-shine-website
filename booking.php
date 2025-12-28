<?php
session_start();
include 'db/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name    = trim($_POST['name']);
    $email   = trim($_POST['email']);
    $mobile  = trim($_POST['mobile']);
    $service = trim($_POST['service']);
    $date    = trim($_POST['date']);

    // Insert booking into DB
    $stmt = $conn->prepare("
        INSERT INTO bookings (name, email, mobile, service, date)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("sssss", $name, $email, $mobile, $service, $date);
    $stmt->execute();
    $stmt->close();

    // WhatsApp Business Number (no + sign)
    $adminNumber = "919199825858";

    // WhatsApp message text
    $message = urlencode(
        " New Parlour Booking \n\n".
        " Name: $name\n".
        " Mobile: $mobile\n".
        " Service: $service\n".
        " Date: $date\n\n".
        " Booking Confirmed"
    );
?>
<!DOCTYPE html>
<html>
<head>
<title>Booking Confirmed</title>

<!-- Auto Redirect to WhatsApp after page load -->
<script>
  window.onload = function () {
    setTimeout(function () {
      window.location.href =
        "https://wa.me/<?php echo $adminNumber; ?>?text=<?php echo $message; ?>";
    }, 800); // delay improves reliability on InfinityFree
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
  }

  h2 {
    color: #FFD700;
    margin-bottom: 10px;
  }

  .btn {
    margin-top: 18px;
    padding: 12px 20px;
    border-radius: 12px;
    border: 2px solid #FFD700;
    background: transparent;
    color: #FFD700;
    font-weight: bold;
    text-decoration: none;
    display: inline-block;
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

  <p>Thank you <b><?php echo $name; ?></b>.</p>
  <p>Your booking has been saved in our system.</p>

  <p><b>Redirecting to WhatsApp…</b></p>

  <!-- Fallback button (if auto redirect blocked) -->
  <a class="btn"
     href="https://wa.me/<?php echo $adminNumber; ?>?text=<?php echo $message; ?>">
     Send Booking on WhatsApp
  </a>
</div>

</body>
</html>

<?php } ?>
