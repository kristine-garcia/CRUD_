<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header(header: "Location: login.php");
    exit();
}

require_once 'db.php';

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Task Tracker</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h7>Task Tracker</h7>
        <h3>Welcome, <?php echo htmlspecialchars(string: $_SESSION['username']); ?>!</h3>
        <table>
            <thead>
                <tr>
                    <th>To Do: School/Work</th>
                    <th>Assigned to:</th>
                    <th>Frequency:</th>
                    <th>Completion Rate:</th> 
                    <th>Submission Date:</th>
                   
                </tr>
            </thead>
            <tbody>
                
                <!-- Add a row for adding new tasks -->
                <tr>
                    <td><input type="text" name="new_task" placeholder="Task Name"></td>
                    <td><?php echo htmlspecialchars(string: $_SESSION['username']); ?></td>
                    <td>
                        <select name="new_frequency">
                            <option value="Select">-Select-</option>
                            <option value="Daily">Daily</option>
                            <option value="Weekly">Weekly</option>
                            <option value="Monthly">Monthly</option>
                            <option value="Once">Once</option>
                        </select>
                    </td>
                    <td><input type= varchar name="new_completion" min="0" max="100" value=" "></td>
                    <td>
                        <input type = date name = "submission_date">
                        
                    </td>

                    <td><colspan="5"><button onclick="addTask()">Add Task</button></td>
                </tr>
            </tbody>
        </table>
        <a href="logout.php" class="logout-btn">Logout</a>

    </div>
</body>
</html>
