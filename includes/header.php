<?php
// This file is included in all pages after login
?>
<header>
    <nav>
        <div class="nav-brand">
            <h2>Library Management System</h2>
        </div>
        <div class="nav-links">
            <a href="dashboard.php">Dashboard</a>
            <a href="books.php">Books</a>
            <a href="members.php">Members</a>
            <a href="transactions.php">Transactions</a>
            <a href="logout.php" class="logout-btn">Logout (<?php echo $_SESSION['full_name']; ?>)</a>
        </div>
    </nav>
</header>