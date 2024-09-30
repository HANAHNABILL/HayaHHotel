<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $room_id = $_POST['room_id'];
    $checkin_date = $_POST['checkin_date'];
    $checkout_date = $_POST['checkout_date'];
    $adults = $_POST['adults'];
    $children = isset($_POST['children']) ? $_POST['children'] : 0; // Check if 'children' key exists
    $customer_name = $_POST['customer_name'];
    $customer_email = $_POST['customer_email'];
    $customer_phone = $_POST['customer_phone'];
    $preferences = $_POST['preferences'];

    // Create connection
    $conn = new mysqli('localhost', 'root', '', 'hoteldb');
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert booking into database
    $sql = "INSERT INTO bookings (room_id, checkin_date, checkout_date, adults, children, customer_name, customer_email, customer_phone, preferences) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssssss", $room_id, $checkin_date, $checkout_date, $adults, $children, $customer_name, $customer_email, $customer_phone, $preferences);
    if ($stmt->execute()) {
        echo "<script>alert('Booking successful!');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connections
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="booking.css">
    <script>
        function validateForm() {
            const adults = document.getElementById('adults').value;
            const children = document.getElementById('children').value;
            const errorDiv = document.getElementById('error-message');
            errorDiv.innerHTML = ''; // Clear any previous errors

            if (adults < 0 || children < 0) {
                errorDiv.innerHTML = '<div class="alert alert-danger">Number of adults and children cannot be less than 0.</div>';
                return false;
            }

            if (adults == 0 && children == 0) {
                errorDiv.innerHTML = '<div class="alert alert-danger">At least one adult or one child must be specified.</div>';
                return false;
            }

            return true;
        }
    </script>
</head>
<body>

<section class="booking"> 
<div class="container">
    <h2 class="my-4">Book Your Room</h2>
    <div id="error-message"></div> <!-- Div to show error messages -->
    <form action="booking_page.php" method="post" onsubmit="return validateForm()">
        <input type="hidden" name="room_id" value="<?php echo isset($_GET['room_id']) ? htmlspecialchars($_GET['room_id']) : ''; ?>">

        <div class="form-group">
            <label for="checkin_date">Check-in Date:</label>
            <input type="date" class="form-control" id="checkin_date" name="checkin_date" required>
        </div>
        <div class="form-group">
            <label for="checkout_date">Check-out Date:</label>
            <input type="date" class="form-control" id="checkout_date" name="checkout_date" required>
        </div>
        <div class="form-group">
            <label for="adults">Number of Adults:</label>
            <input type="number" class="form-control" id="adults" name="adults" required>
        </div>
        <div class="form-group">
            <label for="children">Number of Children:</label>
            <input type="number" class="form-control" id="children" name="children">
        </div>
        <div class="form-group">
            <label for="customer_name">Name:</label>
            <input type="text" class="form-control" id="customer_name" name="customer_name" required>
        </div>
        <div class="form-group">
            <label for="customer_email">Email:</label>
            <input type="email" class="form-control" id="customer_email" name="customer_email" required>
        </div>
        <div class="form-group">
            <label for="customer_phone">Phone:</label>
            <input type="tel" class="form-control" id="customer_phone" name="customer_phone" required>
        </div>
        <div class="form-group">
            <label for="preferences">Preferences:</label>
            <textarea class="form-control" id="preferences" name="preferences"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit Booking</button>
    </form>
</div>
</section>
</body>
</html>
