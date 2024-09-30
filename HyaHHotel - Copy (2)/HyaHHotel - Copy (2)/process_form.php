<?php

// Create connection
$conn = new mysqli('localhost', 'root', '', 'hoteldb');
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);
    $subscribe = isset($_POST['subscribe']) ? 1 : 0;
    $gender = $conn->real_escape_string($_POST['gender']);

    // Basic validation
    $errors = [];

    if (empty($name)) {
        $errors[] = "Please enter your name.";
    } elseif (!preg_match("/^[A-Za-z\s]+$/", $name)) {
        $errors[] = "Please enter a valid name.";
    }

    if (empty($email)) {
        $errors[] = "Please enter your email.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (empty($message)) {
        $errors[] = "Please enter your message.";
    }

    if (!isset($_POST['terms'])) {
        $errors[] = "Please accept the terms and conditions.";
    }

    if (count($errors) > 0) {
        http_response_code(400);
        echo implode("<br>", $errors);
    } else {
        $sql = "INSERT INTO contact (name, email, message, subscribe, gender)
                VALUES ('$name', '$email', '$message', '$subscribe', '$gender')";

        if ($conn->query($sql) === TRUE) {
            echo "Success";
        } else {
            http_response_code(500);
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
} else {
    http_response_code(405);
    echo "Invalid request method.";
}
?>