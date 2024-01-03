<?php
// Retrieve form data
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// Perform validation (example checks, adjust as needed)
if (empty($username) || empty($email) || empty($password)) {
    header('Location: index.html?error=emptyfields');
    exit();
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: index.html?error=invalidemail');
    exit();
}
// Add more validation rules as needed (password strength, etc.)

// Sanitize inputs to prevent injection attacks
$username = mysqli_real_escape_string($conn, $username);
$email = mysqli_real_escape_string($conn, $email);

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Connect to your database (replace placeholders)
$conn = mysqli_connect('hostname', 'username', 'password', 'database_name');

// Check for connection errors
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Prepare SQL query to insert user data
$sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";

// Execute the query
if (mysqli_query($conn, $sql)) {
    header('Location: success.php'); // Redirect to success page
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn); // Display error message
}

// Close the database connection
mysqli_close($conn);
?>

