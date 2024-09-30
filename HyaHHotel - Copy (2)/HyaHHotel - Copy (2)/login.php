<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="design.css">
    <style>
        body {
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
            color: white; /* Change link color to white */
        }

        .message {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="registration-form-container">
        <?php
        include("php/config.php");

        $emailError = $passwordError = "";
        $email = $password = "";

        if (isset($_POST['submit'])) {
            if (empty($_POST['email'])) {
                $emailError = "Email is required";
            } else {
                $email = mysqli_real_escape_string($con, $_POST['email']);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailError = "Invalid email format";
                }
            }

            if (empty($_POST['password'])) {
                $passwordError = "Password is required";
            } else {
                $password = mysqli_real_escape_string($con, $_POST['password']);
            }

            if (empty($emailError) && empty($passwordError)) {
                $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
                $result = mysqli_query($con, $query) or die("Query failed: " . mysqli_error($con));

                $row = mysqli_fetch_assoc($result);

                if (is_array($row) && !empty($row)) {
                    $_SESSION['valid'] = $row['email'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['fullname'] = $row['fullname'];
                    $_SESSION['age'] = $row['age'];
                    $_SESSION['phonenumber'] = $row['phonenumber'];
                    header("Location: index.html");
                    exit();
                } else {
                    echo "<div class='message'>Wrong Email or Password</div>";
                    echo "<br><a href='ttheproject.php'><button class='btn'>Go Back</button></a>";
                }
            }
        }
        ?>
        <form action="" method="post">
            <h3>Sign In</h3>
            <span>Email</span>
            <input type="text" name="email" id="email" class="box" placeholder="Enter your email" value="<?php echo htmlspecialchars($email); ?>" required>
            <div class="message"><?php echo $emailError; ?></div>
            <span>Password</span>
            <input type="password" name="password" id="password" class="box" placeholder="Enter your password" required>
            <div class="message"><?php echo $passwordError; ?></div>
            <input type="submit" value="Sign In" name="submit" class="btn">
            <p>Don't have an account? <a href="signup.php">Register here</a></p>
        </form>
    </div>

    <script>
        // Array of image URLs
        const images = ["logintest3.jpg", "su.jpg", "w1.jpg"]; // Add more images as needed
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
