<?php
session_start();

// Security Guard: Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Connect to database
require_once 'db/config.php';

$admin_user = htmlspecialchars($_SESSION['admin_username'] ?? 'Admin');

// Fetch total booking count
$countResult = $conn->query("SELECT COUNT(*) as total FROM bookings");
$totalBookings = $countResult ? $countResult->fetch_assoc()['total'] : 0;

// Fetch total careers application count
$careerCountResult = $conn->query("SELECT COUNT(*) as total FROM careers");
$totalCareers = $careerCountResult ? $careerCountResult->fetch_assoc()['total'] : 0;

// Fetch all bookings sorted by newest first
$bookingsResult = $conn->query("SELECT * FROM bookings ORDER BY id DESC");

// Fetch all career applications sorted by newest first
$careersResult = $conn->query("SELECT * FROM careers ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Style N Shine</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --gold: #d4af37;
            --gold-light: #f3e5ab;
            --dark-bg: #070707;
            --card-bg: rgba(18, 18, 18, 0.85);
            --text-main: #d4d4d4;
            --text-muted: #999999;
            --border-color: rgba(212, 175, 55, 0.25);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            background-color: var(--dark-bg);
            color: var(--text-main);
            font-family: 'Poppins', sans-serif;
            display: flex;
            min-height: 100vh;
        }
        /* Sidebar */
        .sidebar {
            width: 260px; background: #0b0b0b; border-right: 1px solid var(--border-color);
            display: flex; flex-direction: column; position: fixed; height: 100vh; z-index: 100;
        }
        .sidebar-brand { padding: 25px 20px; font-family: "Playfair Display", serif; font-size: 22px; color: var(--gold); border-bottom: 1px solid var(--border-color); text-align: center; }
        .sidebar-menu { list-style: none; padding: 20px 0; flex: 1; }
        .sidebar-menu li a { display: flex; align-items: center; gap: 12px; padding: 14px 25px; color: var(--text-muted); text-decoration: none; font-size: 14.5px; transition: all 0.3s; }
        .sidebar-menu li.active a, .sidebar-menu li a:hover { background: rgba(212, 175, 55, 0.1); color: var(--gold); border-left: 4px solid var(--gold); }
        
        /* Main Content */
        .main-content { margin-left: 260px; flex: 1; padding: 40px; }
        .dashboard-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; border-bottom: 1px solid var(--border-color); padding-bottom: 20px; }
        .dashboard-header h1 { font-family: "Playfair Display", serif; color: var(--gold); font-size: 32px; }
        .user-profile { display: flex; align-items: center; gap: 15px; }
        .btn-logout { background: rgba(255, 77, 77, 0.15); border: 1px solid rgba(255, 77, 77, 0.4); color: #ff4d4d; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-size: 13px; transition: all 0.3s; }
        .btn-logout:hover { background: #ff4d4d; color: #fff; }

        /* Stats */
        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 25px; margin-bottom: 40px; }
        .stat-card { background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 16px; padding: 25px; }
        .stat-card h3 { font-size: 13px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; }
        .stat-card .number { font-size: 28px; font-family: "Playfair Display", serif; color: var(--gold); font-weight: 700; }

        /* Table */
        .table-container { background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 16px; padding: 25px; overflow-x: auto; margin-bottom: 40px; }
        .table-container h2 { font-family: "Playfair Display", serif; color: var(--gold); font-size: 20px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; text-align: left; font-size: 14px; }
        th, td { padding: 12px 15px; border-bottom: 1px solid rgba(255, 255, 255, 0.05); }
        th { color: var(--gold); font-weight: 600; text-transform: uppercase; font-size: 12px; letter-spacing: 1px; }
        td { color: var(--text-main); }
        tr:hover td { background: rgba(212, 175, 55, 0.03); }
        
        /* Buttons */
        .btn-whatsapp {
            background: rgba(37, 211, 102, 0.15);
            border: 1px solid #25d366;
            color: #25d366;
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 12.5px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s;
        }
        .btn-whatsapp:hover {
            background: #25d366;
            color: #000;
        }
        .btn-resume {
            background: rgba(212, 175, 55, 0.15);
            border: 1px solid var(--gold);
            color: var(--gold);
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 12.5px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s;
        }
        .btn-resume:hover {
            background: var(--gold);
            color: #000;
        }
        .no-data { text-align: center; padding: 30px; color: var(--text-muted); }

        @media (max-width: 900px) {
            .sidebar { width: 70px; }
            .sidebar-brand, .sidebar-menu span { display: none; }
            .main-content { margin-left: 70px; }
            .stats-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">Style N Shine</div>
        <ul class="sidebar-menu">
            <li class="active"><a href="dashboard.php"><i class="fa-solid fa-chart-pie"></i> <span>Overview</span></a></li>
            <li><a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> <span>Logout</span></a></li>
        </ul>
    </div>

    <!-- Content -->
    <div class="main-content">
        <div class="dashboard-header">
            <h1>Admin Dashboard</h1>
            <div class="user-profile">
                <span><i class="fa-solid fa-user-shield" style="color: var(--gold);"></i> Welcome, <?php echo $admin_user; ?></span>
                <a href="logout.php" class="btn-logout"><i class="fa-solid fa-power-off"></i> Logout</a>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Bookings</h3>
                <div class="number"><?php echo $totalBookings; ?></div>
            </div>
            <div class="stat-card">
                <h3>Job Applications</h3>
                <div class="number"><?php echo $totalCareers; ?></div>
            </div>
            <div class="stat-card">
                <h3>Location</h3>
                <div class="number" style="font-size: 20px;">Boring Road, Patna</div>
            </div>
        </div>

        <!-- Bookings Table -->
        <div class="table-container">
            <h2>Client Booking Records</h2>
            <table>
                <thead>
                    <tr>
                        <th>Slot ID</th>
                        <th>Client Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Service</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($bookingsResult && $bookingsResult->num_rows > 0): ?>
                        <?php while($row = $bookingsResult->fetch_assoc()): 
                            $clientPhone = preg_replace('/[^0-9]/', '', $row['mobile']);
                            if (strlen($clientPhone) == 10) {
                                $clientPhone = "91" . $clientPhone;
                            }
                            
                            $waText = urlencode(
                                "Hello " . $row['name'] . ",\n\n" .
                                "Thank you for booking with Style N Shine Studio! \n" .
                                "Your slot has been successfully confirmed.\n\n" .
                                " *Booking Details:*\n" .
                                "• Slot ID: #" . $row['id'] . "\n" .
                                "• Service: " . $row['service'] . "\n" .
                                "• Date: " . $row['date'] . "\n\n" .
                                "We look forward to serving you!"
                            );
                        ?>
                            <tr>
                                <td><strong>#<?php echo $row['id']; ?></strong></td>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['mobile']); ?></td>
                                <td><span style="color: var(--gold);"><?php echo htmlspecialchars($row['service']); ?></span></td>
                                <td><?php echo htmlspecialchars($row['date']); ?></td>
                                <td>
                                    <a href="https://wa.me/<?php echo $clientPhone; ?>?text=<?php echo $waText; ?>" target="_blank" class="btn-whatsapp">
                                        <i class="fa-brands fa-whatsapp"></i> Reply on WhatsApp
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="no-data">No bookings recorded in database yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Career Applications Table -->
        <div class="table-container">
            <h2>Staff & Career Applications</h2>
            <table>
                <thead>
                    <tr>
                        <th>App ID</th>
                        <th>Applicant Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Position</th>
                        <th>Experience</th>
                        <th>Resume</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($careersResult && $careersResult->num_rows > 0): ?>
                        <?php while($c_row = $careersResult->fetch_assoc()): ?>
                            <tr>
                                <td><strong>#<?php echo $c_row['id']; ?></strong></td>
                                <td><?php echo htmlspecialchars($c_row['name']); ?></td>
                                <td><?php echo htmlspecialchars($c_row['email']); ?></td>
                                <td><?php echo htmlspecialchars($c_row['phone']); ?></td>
                                <td><span style="color: var(--gold);"><?php echo htmlspecialchars($c_row['role']); ?></span></td>
                                <td><?php echo htmlspecialchars($c_row['experience']); ?></td>
                                <td>
                                    <a href="uploads/resumes/<?php echo htmlspecialchars($c_row['resume']); ?>" target="_blank" class="btn-resume">
                                        <i class="fa-solid fa-file-pdf"></i> View PDF
                                    </a>
                                </td>
                                <td><?php echo htmlspecialchars($c_row['applied_at']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="no-data">No job applications received yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>