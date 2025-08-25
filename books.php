<?php
include 'includes/auth.php';
checkAuth();
include 'includes/functions.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_book'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $isbn = $_POST['isbn'];
    $publication_year = $_POST['publication_year'];
    $category = $_POST['category'];
    $total_copies = $_POST['total_copies'];
    
    if (addBook($title, $author, $isbn, $publication_year, $category, $total_copies)) {
        $message = 'Book added successfully!';
    } else {
        $message = 'Error adding book. Please try again.';
    }
}

$books = getAllBooks();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Management - Library Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="container">
        <h2>Book Management</h2>
        
        <?php if ($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <div class="form-section">
            <h3>Add New Book</h3>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" required>
                </div>
                
                <div class="form-group">
                    <label for="author">Author:</label>
                    <input type="text" id="author" name="author" required>
                </div>
                
                <div class="form-group">
                    <label for="isbn">ISBN:</label>
                    <input type="text" id="isbn" name="isbn" required>
                </div>
                
                <div class="form-group">
                    <label for="publication_year">Publication Year:</label>
                    <input type="number" id="publication_year" name="publication_year" min="1000" max="<?php echo date('Y'); ?>">
                </div>
                
                <div class="form-group">
                    <label for="category">Category:</label>
                    <input type="text" id="category" name="category">
                </div>
                
                <div class="form-group">
                    <label for="total_copies">Total Copies:</label>
                    <input type="number" id="total_copies" name="total_copies" min="1" value="1" required>
                </div>
                
                <button type="submit" name="add_book">Add Book</button>
            </form>
        </div>
        
        <div class="list-section">
            <h3>All Books</h3>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>ISBN</th>
                        <th>Year</th>
                        <th>Category</th>
                        <th>Available</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($books as $book): ?>
                    <tr>
                        <td><?php echo $book['title']; ?></td>
                        <td><?php echo $book['author']; ?></td>
                        <td><?php echo $book['isbn']; ?></td>
                        <td><?php echo $book['publication_year']; ?></td>
                        <td><?php echo $book['category']; ?></td>
                        <td><?php echo $book['available_copies']; ?></td>
                        <td><?php echo $book['total_copies']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <script src="js/script.js"></script>
</body>
</html>