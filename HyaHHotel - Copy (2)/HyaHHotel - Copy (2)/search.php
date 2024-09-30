<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Rooms</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="search.css">
</head>
<body>
<header>
    <a href="index.html" class="logo"> <img src="Elogo.png" alt=""> </a>
    <nav class="navigation">
        <a href="index.html">Home</a>
        <a href="AbouT.html">About</a>
        <a href="#contact">Rooms</a>
        <a href="AbouT.html">Restaurant</a>
        <a href="#contact">Gallery</a>
        <a href="contact.html">Contact</a>
    </nav>
</header>

<section class="swiper rooms" id="srooms">
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide"><img src="443743448.jpg" alt=""></div>
            <div class="swiper-slide"><img src="435800343.jpg" alt=""></div>
            <div class="swiper-slide"><img src="room3.jpg" alt=""></div>
            <div class="swiper-slide"><img src="room4.jpg" alt=""></div>
            <div class="swiper-slide"><img src="room2.jpg" alt=""></div>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper(".mySwiper", {
        pagination: {
            el: ".swiper-pagination",
            dynamicBullets: true,
        },
        autoplay: {
            delay: 2000,
            disableOnInteraction: false,
        },
    });
</script>

<img class="Frame2"src="devider2.png" />
<section class="res" id="res">
    <div class="container">
        <h2 class="my-4">Available Rooms:</h2>
        <div class="row">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $checkin_date = $_POST['checkin_date'];
            $checkout_date = $_POST['checkout_date'];
            $adults = $_POST['adults'];
            $children = $_POST['children'];

            // Create connection
            $conn = new mysqli('localhost', 'root', '', 'hoteldb');
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Prepare the SQL query using prepared statements
            $sql = "SELECT room_id, room_type, COUNT(room_id) AS available_rooms, price FROM rooms 
        WHERE capacity >= ? AND room_type IN ('Single', 'Double', 'Family', 'Suite') 
        AND room_id NOT IN (
            SELECT room_id FROM bookings 
            WHERE checkin_date < ? AND checkout_date > ?
        )
        GROUP BY room_type";

            
            $stmt = $conn->prepare($sql);
            // Calculate total guests (adults + children)
            $total_guests = $adults + $children;
            // Bind parameters and execute query
            $stmt->bind_param("iss", $total_guests, $checkout_date, $checkin_date);
            $stmt->execute();
            $result = $stmt->get_result();

            // Check if any rooms are available
            if ($result->num_rows > 0) {
                // Display available room types
                while($row = $result->fetch_assoc()) {
                    ?>
                    <div class="col-md-4">
                        <div class="card mb-4 room-card-shadow">
                            <div class="card-body">
                                <p class="card-text">Room Type: <?php echo htmlspecialchars($row["room_type"]); ?> (<?php echo $row["available_rooms"]; ?> left)</p>
                                <p class="card-text">Price: $<?php echo htmlspecialchars($row["price"]); ?></p>
                                <a href="booking_page.php?room_id=<?php echo htmlspecialchars($row["room_id"]); ?>" class="btn btn-primary">Book Now !</a>
                                <a href="<?php echo strtolower($row["room_type"]); ?>Room.html" class="btn btn-primary">View Room</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<div class='alert alert-danger'>No rooms available for the selected number of guests and dates.</div>";
            }

            // Close connections
            $stmt->close();
            $conn->close();
        }
        ?>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<footer>
  <div class="container grid top">
    <div class="box">
      <img src="Elogo.png" />

      <p>Accepted payment methods</p>
      <div class="payment grid">
        <img src="https://img.icons8.com/color/48/000000/visa.png" />
        <img src="https://img.icons8.com/color/48/000000/mastercard.png" />
        <img src="https://img.icons8.com/color-glass/48/000000/paypal.png" />
        <img src="https://img.icons8.com/fluency/48/000000/amex.png" />
      </div>
    </div>

    <div class="box">
      <h3>Recent News</h3>

      <ul>
        <li>Our Secret Island Boat Tour Is Just for You</li>
        <li>Art class</li>
        <li>Live Music Concerts at Luviana</li>
      </ul>
    </div>
    <div class="box">
      <h3>Contact Us</h3>

      <ul>
        <li>3015 Grand Ave, Cocount Grove, Merrick Way FL 123456</li>
        <li><i class="far fa-envelope"></i>demoexample@gmail.com </li>
        <li><i class="far fa-phone-alt"></i>123 456 7898 </li>
        <li><i class="far fa-phone-alt"></i>123 456 7898 </li>
        <li><i class="far fa-comments"></i>24/ 7 Customer Services </li>
      </ul>
    </div>
  </div>
</footer>
</body>
</html>
