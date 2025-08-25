<?php
include 'includes/auth.php';
checkAuth();
include 'includes/functions.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_member'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $membership_date = $_POST['membership_date'];
    
    if (addMember($name, $email, $phone, $address, $membership_date)) {
        $message = 'Member added successfully!';
    } else {
        $message = 'Error adding member. Please try again.';
    }
}

$members = getAllMembers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Management - Library Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="container">
        <h2>Member Management</h2>
        
        <?php if ($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <div class="form-section">
            <h3>Add New Member</h3>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="text" id="phone" name="phone">
                </div>
                
                <div class="form-group">
                    <label for="address">Address:</label>
                    <textarea id="address" name="address"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="membership_date">Membership Date:</label>
                    <input type="date" id="membership_date" name="membership_date" value="<?php echo date('Y-m-d'); ?>">
                </div>
                
                <button type="submit" name="add_member">Add Member</button>
            </form>
        </div>
        
        <div class="list-section">
            <h3>All Members</h3>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Membership Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($members as $member): ?>
                    <tr>
                        <td><?php echo $member['name']; ?></td>
                        <td><?php echo $member['email']; ?></td>
                        <td><?php echo $member['phone']; ?></td>
                        <td><?php echo $member['membership_date']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <script src="js/script.js"></script>
</body>
</html>