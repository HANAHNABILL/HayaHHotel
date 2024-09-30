<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Booking Form</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-image: url('Gback.png');
      background-repeat: no-repeat;
      background-size: cover;
      color: #333;
    }

    .container {
      max-width: 500px;
      margin: 50px auto;
      background: rgba(255, 255, 255, 0.9);
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
      color: #f54c6e;
      text-align: center;
      margin-bottom: 30px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      display: block;
      font-weight: bold;
    }

    input[type="text"],
    input[type="email"],
    input[type="tel"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .checkbox-group {
      margin-top: 5px;
    }

    .checkbox-group label {
      display: inline-block;
      margin-right: 15px;
    }

    button[type="submit"] {
      background-color: #f54c6e;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    button[type="submit"]:hover {
      background-color: #d43f5e;
    }

    .message {
      text-align: center;
      margin-top: 20px;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Book Your Activities</h2>
    <div id="error-message"></div>
    <form action="book.php" method="post" onsubmit="return validateForm()">
      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" required>
      </div>
      <div class="form-group">
        <label>Select activities:</label><br>
        <div class="checkbox-group">
          <input type="checkbox" id="swimming" name="activities[]" value="Swimming Pool">
          <label for="swimming">Swimming Pool</label>
          <input type="checkbox" id="gym_yoga" name="activities[]" value="Gym & Yoga">
          <label for="gym_yoga">Gym & Yoga</label>
          <input type="checkbox" id="boat_tour" name="activities[]" value="Boat Tour">
          <label for="boat_tour">Boat Tour</label>
          <input type="checkbox" id="spa_massage" name="activities[]" value="Spa & Massage">
          <label for="spa_massage">Spa & Massage</label>
        </div>
      </div>
      <button type="submit">Submit Booking</button>
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Your PHP code for database connection and form submission here
        // ...
    }
    ?>
    <div class="message"><?php echo isset($_POST['name']) ? "Booking successful. Thank you!" : ""; ?></div>
  </div>
</body>
</html>
