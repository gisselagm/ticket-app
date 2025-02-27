<?php
// index.php
require 'db.php';

// Process form submission to add a new ticket
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($title && $description) {
        $stmt = $pdo->prepare('INSERT INTO tickets (title, description) VALUES (?, ?)');
        $stmt->execute([$title, $description]);
        // Redirect to avoid form resubmission
        header('Location: index.php');
        exit;
    } else {
        $error = "Please fill in both the title and description.";
    }
}

// Retrieve all support tickets ordered chronologically (oldest first)
$stmt = $pdo->query('SELECT * FROM tickets ORDER BY created_at ASC');
$tickets = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Support Ticket Management</title>
    <style>
        /* Basic styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            text-align: center;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        textarea {
            resize: vertical;
        }
        button {
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        button:hover {
            background-color: #2980b9;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #3498db;
            color: #fff;
        }
        .status-open {
            color: green;
        }
        .status-in-progress {
            color: orange;
        }
        .status-closed {
            color: red;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Support Ticket Management</h1>

    <h2>Add New Ticket</h2>
    <?php if (isset($error)): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <form method="POST" action="index.php">
        <label for="title">Ticket Title:</label>
        <input type="text" id="title" name="title" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4" required></textarea>

        <button type="submit">Submit Ticket</button>
    </form>

    <h2>Existing Tickets</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tickets as $ticket): ?>
                <tr>
                    <td><?php echo htmlspecialchars($ticket['id']); ?></td>
                    <td><?php echo htmlspecialchars($ticket['title']); ?></td>
                    <td><?php echo htmlspecialchars($ticket['description']); ?></td>
                    <td class="status-<?php echo str_replace(' ', '-', strtolower($ticket['status'])); ?>">
                        <?php echo htmlspecialchars($ticket['status']); ?>
                    </td>
                    <td><?php echo htmlspecialchars($ticket['created_at']); ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($tickets)): ?>
                <tr>
                    <td colspan="5" style="text-align: center;">No tickets found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
