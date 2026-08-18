<?php
session_start();
require_once 'db/config.php'; // Matches your config connection

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $admin = $result->fetch_assoc();
        $stmt->close();

        // Updated to plain-text direct comparison
        if ($admin && $password === $admin['password']) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $admin['username'];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Style N Shine</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --gold: #d4af37;
            --gold-light: #f3e5ab;
            --dark-bg: #070707;
            --card-bg: rgba(18, 18, 18, 0.9);
            --text-main: #d4d4d4;
            --border-color: rgba(212, 175, 55, 0.25);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            background-color: var(--dark-bg);
            color: var(--text-main);
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: radial-gradient(circle at center, #141414 0%, #050505 100%);
        }
        .login-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.8), 0 0 20px rgba(212, 175, 55, 0.1);
        }
        .login-header { text-align: center; margin-bottom: 30px; }
        .login-header h1 { font-family: "Playfair Display", serif; color: var(--gold); font-size: 28px; margin-bottom: 8px; }
        .login-header p { font-size: 13px; color: #888; text-transform: uppercase; letter-spacing: 1px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 13px; color: #aaa; margin-bottom: 8px; }
        .input-with-icon { position: relative; }
        .input-with-icon i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--gold); }
        .input-with-icon input {
            width: 100%; background: rgba(10, 10, 10, 0.8); border: 1px solid var(--border-color);
            padding: 12px 15px 12px 45px; border-radius: 10px; color: #fff; font-size: 14px;
            font-family: 'Poppins', sans-serif;
        }
        .input-with-icon input:focus { outline: none; border-color: var(--gold); }
        .error-msg { background: rgba(255, 77, 77, 0.1); border: 1px solid rgba(255, 77, 77, 0.3); color: #ff4d4d; padding: 10px; border-radius: 8px; font-size: 13px; margin-bottom: 20px; text-align: center; }
        .btn-login { width: 100%; background: var(--gold); color: #000; border: none; padding: 13px; border-radius: 10px; font-weight: 600; font-size: 15px; cursor: pointer; transition: background 0.3s; }
        .btn-login:hover { background: var(--gold-light); }
        .back-link { text-align: center; margin-top: 20px; }
        .back-link a { color: #888; font-size: 13px; text-decoration: none; }
        .back-link a:hover { color: var(--gold); }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <h1>Style N Shine</h1>
            <p>Admin Login Portal</p>
        </div>
        <?php if (!empty($error)): ?>
            <div class="error-msg"><i class="fa-solid fa-triangle-exclamation"></i> <?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label>Username</label>
                <div class="input-with-icon">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="username" required placeholder="Enter username">
                </div>
            </div>
            <div class="form-group">
                <label>Password</label>
                <div class="input-with-icon">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" required placeholder="Enter password">
                </div>
            </div>
            <button type="submit" class="btn-login">Login to Dashboard</button>
        </form>
        <div class="back-link">
            <a href="index.html"><i class="fa-solid fa-arrow-left"></i> Back to Website</a>
        </div>
    </div>
</body>
</html>