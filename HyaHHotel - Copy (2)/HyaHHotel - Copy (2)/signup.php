<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="design.css">
    <style>
        body {
            background-image: url("su.jpg");
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
        }

        .registration-form-container {
            background-color: #2873a585;
            padding: 30px;
            border-radius: 3px;
            text-align: center;
            max-width: 410px;
            width: 100%;
            padding-right: 50px;
        }

        .box {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }


        .btn {
            width: 100%;
            padding: 8px; 
            font-size: 14px; 
            background-color:  rgb(245, 76, 110);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            
        }

        .btn:hover {
            background-color:rgb(192, 39, 75);
        }

        h3, span {
            color: #05374d; 
            
        }

        h3{
            font-size: 30px;

        }

        p {
            color: #ffffff; 
        }

        a {
            color: rgb(0, 0, 0);
        }

        .message {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="registration-form-container">
        <div id="close-registration-btn" class="fas fa-times"></div>
        <?php
        include("php/config.php");

        $usernameError = $emailError = $passwordError = $ageError = "";
        $username = $email = $password = $age = $phonenumber = $fullname = "";

        if (isset($_POST['submit'])) {
            $isValid = true;

            if (empty($_POST['username'])) {
                $usernameError = "Username is required";
                $isValid = false;
            } else {
                $username = $_POST['username'];
            }

            if (empty($_POST['email'])) {
                $emailError = "Email is required";
                $isValid = false;
            } else {
                $email = $_POST['email'];
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailError = "Invalid email format";
                    $isValid = false;
                } else {
                    // Check for unique email
                    $verify_query = mysqli_query($con, "SELECT email FROM users WHERE email='$email'");
                    if (mysqli_num_rows($verify_query) != 0) {
                        $emailError = "This email is used, Try another One Please!";
                        $isValid = false;
                    }
                }
            }

            if (empty($_POST['password'])) {
                $passwordError = "Password is required";
                $isValid = false;
            } else {
                $password = $_POST['password'];
            }

            if (empty($_POST['age'])) {
                $ageError = "Age is required";
                $isValid = false;
            } else {
                $age = $_POST['age'];
                if ($age <= 18) {
                    $ageError = "You must be older than 18";
                    $isValid = false;
                }
            }

            $phonenumber = $_POST['phonenumber'];
            $fullname = $_POST['fullname'];

            if ($isValid) {
                mysqli_query($con, "INSERT INTO users (username, email, phonenumber, password, fullname, age) VALUES ('$username', '$email', '$phonenumber', '$password', '$fullname', '$age')") or die("Error Occurred");
                echo "<div class='message'>
                          <p>Registration successfully!</p>
                      </div> <br>";
                echo "<a href='login.php'><button class='btn'>Login Now</button></a>";
            }
        }
        ?>

        <?php if (!isset($_POST['submit']) || !$isValid): ?>
        <form action="" method="post">
            <h3>Create New Account</h3>
            <span>Full Name</span>
            <input type="text" name="fullname" class="box" placeholder="Enter your full name" id="fullname" value="<?php echo htmlspecialchars($fullname); ?>">
            <span>Username</span>
            <input type="text" name="username" class="box" placeholder="Enter your username" id="username" value="<?php echo htmlspecialchars($username); ?>">
            <div class="message"><?php echo $usernameError; ?></div>
            <span>Email</span>
            <input type="text" name="email" class="box" placeholder="Enter your email" id="email" value="<?php echo htmlspecialchars($email); ?>">
            <div class="message"><?php echo $emailError; ?></div>
            <span>Age</span>
            <input type="number" name="age" class="box" placeholder="Enter your age" id="age" value="<?php echo htmlspecialchars($age); ?>">
            <div class="message"><?php echo $ageError; ?></div>
            <span>Phone Number</span>
            <input type="text" name="phonenumber" class="box" placeholder="Enter your phone number" id="phonenumber" value="<?php echo htmlspecialchars($phonenumber); ?>">
            <span>Password</span>
            <input type="password" name="password" class="box" placeholder="Enter your password" id="password">
            <div class="message"><?php echo $passwordError; ?></div>
            <input type="submit" value="Create Account" name="submit" class="btn">
            <p>Already have an account? <a href="login.php">login !</a></p>
        </form>
        <?php endif; ?>
    </div>

    <script>
        // Array of image URLs
        const images = ["su.jpg","logintest3.jpg", "w1.jpg"]; // Add more images as needed
        let currentIndex = 0;

        function changeBackgroundImage() {
            // Change the background image of the body
            document.body.style.backgroundImage = `url(${images[currentIndex]})`;
            // Update the index for the next image
            currentIndex = (currentIndex + 1) % images.length;
        }

        // Change the background image every 5 seconds (5000 milliseconds)
        setInterval(changeBackgroundImage, 2000);

        // Initial call to set the first background image
        changeBackgroundImage();
    </script>


</body>
</html>
