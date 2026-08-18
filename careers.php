<?php
require_once 'db/config.php';

$message = "";
$status = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['apply_career'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $mobile = htmlspecialchars($_POST['mobile']);
    $role = htmlspecialchars($_POST['role']);
    $experience = htmlspecialchars($_POST['experience']);

    // Handle PDF Resume Upload
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] == 0) {
        $fileExt = strtolower(pathinfo($_FILES['resume']['name'], PATHINFO_EXTENSION));
        
        if ($fileExt == 'pdf') {
            $uploadDir = 'uploads/resumes/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $newFileName = time() . '_' . preg_replace("/[^a-zA-Z0-9]/", "_", $name) . '.pdf';
            $uploadPath = $uploadDir . $newFileName;

            if (move_uploaded_file($_FILES['resume']['tmp_name'], $uploadPath)) {
                $stmt = $conn->prepare("INSERT INTO careers (name, email, phone, role, experience, resume) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssss", $name, $email, $mobile, $role, $experience, $newFileName);
                $stmt->execute();
                $stmt->close();

                $status = "success";
                $message = "Application submitted! We will review it and call you shortly.";
            }
        }
    }

    if ($status !== "success") {
        $status = "error";
        $message = "Submission failed. Please ensure your resume is in PDF format and try again.";
    }
} else {
    // If someone accesses careers.php directly without submitting, send them home
    header("Location: index.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Status | Style N Shine</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #070707;
            color: #d4d4d4;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .card {
            background: rgba(18, 18, 18, 0.9);
            border: 1px solid rgba(212, 175, 55, 0.25);
            border-radius: 16px;
            padding: 40px;
            max-width: 450px;
            width: 90%;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .icon {
            font-size: 45px;
            color: <?php echo ($status === 'success') ? '#25d366' : '#ff4d4d'; ?>;
            margin-bottom: 20px;
        }
        p {
            font-size: 16px;
            line-height: 1.5;
            color: #fff;
            margin-bottom: 30px;
        }
        .btn {
            background: #d4af37;
            color: #000;
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            display: inline-block;
            transition: 0.3s;
        }
        .btn:hover {
            background: #e6c547;
        }
    </style>
</head>
<body>

    <div class="card">
        <div class="icon">
            <?php if ($status === 'success'): ?>
                <i class="fa-solid fa-circle-check"></i>
            <?php else: ?>
                <i class="fa-solid fa-circle-xmark"></i>
            <?php endif; ?>
        </div>
        <p><?php echo $message; ?></p>
        <a href="index.html" class="btn">Return to Home</a>
    </div>

</body>
</html>