<?php
include 'includes/auth.php';
checkAuth();
include 'includes/functions.php';

// Get counts for dashboard
$books_count = count(getAllBooks());
$members_count = count(getAllMembers());
$transactions = getAllTransactions();
$active_loans = array_filter($transactions, function($t) { return $t['status'] == 'borrowed'; });
$active_loans_count = count($active_loans);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Library Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="container">
        <h2>Dashboard</h2>
        
        <div class="stats">
            <div class="stat-card">
                <h3><?php echo $books_count; ?></h3>
                <p>Total Books</p>
            </div>
            
            <div class="stat-card">
                <h3><?php echo $members_count; ?></h3>
                <p>Total Members</p>
            </div>
            
            <div class="stat-card">
                <h3><?php echo $active_loans_count; ?></h3>
                <p>Active Loans</p>
            </div>
        </div>
        
        <div class="recent-activity">
            <h3>Recent Transactions</h3>
            <table>
                <thead>
                    <tr>
                        <th>Book</th>
                        <th>Member</th>
                        <th>Borrow Date</th>
                        <th>Due Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (array_slice($transactions, 0, 5) as $transaction): ?>
                    <tr>
                        <td><?php echo $transaction['book_title']; ?></td>
                        <td><?php echo $transaction['member_name']; ?></td>
                        <td><?php echo $transaction['borrow_date']; ?></td>
                        <td><?php echo $transaction['due_date']; ?></td>
                        <td><?php echo $transaction['status']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <script src="js/script.js"></script>
</body>
</html>