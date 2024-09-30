<?php
session_start();

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "hoteldb";
$port = 3306;
$conn = new mysqli($servername, $username, $password, $database, $port);


if ($conn->connect_error) {
    die("connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $Username = validate($_POST['username']);
        $password = validate($_POST['password']);

        if (empty($Username)) {
            header('Location: login.php?error=Username is required');
            exit();
        } else if (empty($password)) {
            header('Location: login.php?error=Password is required');
            exit();
        }

        $sql = "SELECT * FROM users WHERE Username = '$Username' AND Password = '$password'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);

            if ($row['Username'] === $Username && $row['Password'] === $password) {
                $_SESSION['Username'] = $row['Username'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['id'] = $row['id'];
                header("Location: index.html");
                exit();
            } else {
                header("Location: login.php?error=Incorrect User");
                exit();
            }
        } else {
            header("Location: login.php?error=Incorrect User");
            exit();
        }
    }

    if (isset($_POST['signup_username']) && isset($_POST['signup_password']) && isset($_POST['signup_email']) && isset($_POST['signup_name']) && isset($_POST['signup_age'])) {
        $Username = validate($_POST['signup_username']);
        $password = validate($_POST['signup_password']);
        $email = validate($_POST['signup_email']);
        $name = validate($_POST['signup_name']);
        $age = validate($_POST['signup_age']);

        if (empty($Username)) {
            header('Location: signup.php?error=Username is required');
            exit();
        } else if (empty($password)) {
            header('Location: signup.php?error=Password is required');
            exit();
        } else if (empty($email)) {
            header('Location: signup.php?error=Email is required');
            exit();
        } else if (empty($name)) {
            header('Location: signup.php?error=Name is required');
            exit();
        } else if (empty($age)) {
            header('Location: signup.php?error=Age is required');
            exit();
        } else if ($age < 20) {
            header('Location: signup.php?error=Age must be 20 or above');
            exit();
        }

        $sql2 = "INSERT INTO users (Username, Password, Email, Name, Age) VALUES ('$Username', '$password', '$email', '$name', '$age')";
        if (mysqli_query($conn, $sql2)) {
            header("Location: index.html");
            exit();
        } else {
            header("Location: signup.php?error=Could not sign up");
            exit();
        }
    }
} else {
    header("Location: login.php");
    exit();
}

function validate($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$conn->close();
?>