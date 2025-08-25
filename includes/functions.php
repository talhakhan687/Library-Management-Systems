<?php
include 'config.php';

// Book functions
function getAllBooks() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM books ORDER BY title");
    return $stmt->fetchAll();
}

function addBook($title, $author, $isbn, $publication_year, $category, $total_copies) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO books (title, author, isbn, publication_year, category, total_copies, available_copies) 
                          VALUES (?, ?, ?, ?, ?, ?, ?)");
    return $stmt->execute([$title, $author, $isbn, $publication_year, $category, $total_copies, $total_copies]);
}

// Member functions
function getAllMembers() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM members ORDER BY name");
    return $stmt->fetchAll();
}

function addMember($name, $email, $phone, $address, $membership_date) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO members (name, email, phone, address, membership_date) 
                          VALUES (?, ?, ?, ?, ?)");
    return $stmt->execute([$name, $email, $phone, $address, $membership_date]);
}

// Transaction functions
function getAllTransactions() {
    global $pdo;
    $stmt = $pdo->query("
        SELECT t.*, b.title as book_title, m.name as member_name 
        FROM transactions t 
        JOIN books b ON t.book_id = b.id 
        JOIN members m ON t.member_id = m.id 
        ORDER BY t.created_at DESC
    ");
    return $stmt->fetchAll();
}

function borrowBook($book_id, $member_id, $borrow_date, $due_date) {
    global $pdo;
    
    // Check if book is available
    $stmt = $pdo->prepare("SELECT available_copies FROM books WHERE id = ?");
    $stmt->execute([$book_id]);
    $book = $stmt->fetch();
    
    if ($book && $book['available_copies'] > 0) {
        // Create transaction
        $stmt = $pdo->prepare("INSERT INTO transactions (book_id, member_id, borrow_date, due_date) 
                              VALUES (?, ?, ?, ?)");
        $result = $stmt->execute([$book_id, $member_id, $borrow_date, $due_date]);
        
        if ($result) {
            // Update available copies
            $stmt = $pdo->prepare("UPDATE books SET available_copies = available_copies - 1 WHERE id = ?");
            $stmt->execute([$book_id]);
            return true;
        }
    }
    
    return false;
}

function returnBook($transaction_id) {
    global $pdo;
    
    // Get transaction details
    $stmt = $pdo->prepare("SELECT * FROM transactions WHERE id = ?");
    $stmt->execute([$transaction_id]);
    $transaction = $stmt->fetch();
    
    if ($transaction && $transaction['status'] == 'borrowed') {
        // Update transaction
        $return_date = date('Y-m-d');
        $stmt = $pdo->prepare("UPDATE transactions SET return_date = ?, status = 'returned' WHERE id = ?");
        $result = $stmt->execute([$return_date, $transaction_id]);
        
        if ($result) {
            // Update available copies
            $stmt = $pdo->prepare("UPDATE books SET available_copies = available_copies + 1 WHERE id = ?");
            $stmt->execute([$transaction['book_id']]);
            return true;
        }
    }
    
    return false;
}
?>