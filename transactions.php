<?php
include 'includes/auth.php';
checkAuth();
include 'includes/functions.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['borrow_book'])) {
        $book_id = $_POST['book_id'];
        $member_id = $_POST['member_id'];
        $borrow_date = $_POST['borrow_date'];
        $due_date = $_POST['due_date'];
        
        if (borrowBook($book_id, $member_id, $borrow_date, $due_date)) {
            $message = 'Book borrowed successfully!';
        } else {
            $message = 'Error borrowing book. Please check availability.';
        }
    } elseif (isset($_POST['return_book'])) {
        $transaction_id = $_POST['transaction_id'];
        
        if (returnBook($transaction_id)) {
            $message = 'Book returned successfully!';
        } else {
            $message = 'Error returning book.';
        }
    }
}

$books = getAllBooks();
$members = getAllMembers();
$transactions = getAllTransactions();
$active_loans = array_filter($transactions, function($t) { return $t['status'] == 'borrowed'; });
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Management - Library Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="container">
        <h2>Transaction Management</h2>
        
        <?php if ($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <div class="form-section">
            <h3>Borrow a Book</h3>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="book_id">Book:</label>
                    <select id="book_id" name="book_id" required>
                        <option value="">Select a book</option>
                        <?php foreach ($books as $book): ?>
                            <?php if ($book['available_copies'] > 0): ?>
                                <option value="<?php echo $book['id']; ?>">
                                    <?php echo $book['title']; ?> by <?php echo $book['author']; ?> (Available: <?php echo $book['available_copies']; ?>)
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="member_id">Member:</label>
                    <select id="member_id" name="member_id" required>
                        <option value="">Select a member</option>
                        <?php foreach ($members as $member): ?>
                            <option value="<?php echo $member['id']; ?>"><?php echo $member['name']; ?> (<?php echo $member['email']; ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="borrow_date">Borrow Date:</label>
                    <input type="date" id="borrow_date" name="borrow_date" value="<?php echo date('Y-m-d'); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="due_date">Due Date:</label>
                    <input type="date" id="due_date" name="due_date" value="<?php echo date('Y-m-d', strtotime('+14 days')); ?>" required>
                </div>
                
                <button type="submit" name="borrow_book">Borrow Book</button>
            </form>
        </div>
        
        <div class="list-section">
            <h3>Active Loans</h3>
            <table>
                <thead>
                    <tr>
                        <th>Book</th>
                        <th>Member</th>
                        <th>Borrow Date</th>
                        <th>Due Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($active_loans as $loan): ?>
                    <tr>
                        <td><?php echo $loan['book_title']; ?></td>
                        <td><?php echo $loan['member_name']; ?></td>
                        <td><?php echo $loan['borrow_date']; ?></td>
                        <td><?php echo $loan['due_date']; ?></td>
                        <td>
                            <form method="POST" action="" style="display:inline;">
                                <input type="hidden" name="transaction_id" value="<?php echo $loan['id']; ?>">
                                <button type="submit" name="return_book" class="return-btn">Return</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="list-section">
            <h3>Transaction History</h3>
            <table>
                <thead>
                    <tr>
                        <th>Book</th>
                        <th>Member</th>
                        <th>Borrow Date</th>
                        <th>Due Date</th>
                        <th>Return Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transactions as $transaction): ?>
                    <tr>
                        <td><?php echo $transaction['book_title']; ?></td>
                        <td><?php echo $transaction['member_name']; ?></td>
                        <td><?php echo $transaction['borrow_date']; ?></td>
                        <td><?php echo $transaction['due_date']; ?></td>
                        <td><?php echo $transaction['return_date'] ?: 'Not returned'; ?></td>
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