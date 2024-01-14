
<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jookebox";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$registrationMessage = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $address = $_POST["Address"];
    $mobile = $_POST["mobile"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
    
    $sql = "INSERT INTO users (name, email, address, mobile, password) VALUES ('$name', '$email', '$address', '$mobile', '$password')";

    if ($conn->query($sql) === TRUE) {
        $registrationMessage = "Registration successful!";

        setcookie("user_email", $email, time() + (86400 * 30), "/"); // Cookie will expire in 30 days
    } else {
        $registrationMessage = "Error: " . $sql . "<br>" . $conn->error;
    }
}
    
$conn->close();


if ($_SERVER["REQUEST_METHOD"] == "POST" && $registrationMessage === "Registration successful!") {
    
    $_SESSION["user_email"] = $email;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration page</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    

</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <a class="logo-text" href="index.html">JOOKEBOX</a>
            </div>
            <div class="login">
             <form action="" method="post">
                <table class="login-controls">
                    <tr>
                        <td><label class="login-label">Email or Mobile</label></td>
                        <td><label class="login-label">Password</label></td>
                    </tr>
                    <tr>
                        <td><input type="text"></td>
                        <td><input type="text"></td>
                        <td><input class="sub-btn" type="submit" value="Login"></td>
                    </tr>
                   <tr>
                    <td></td>
                    <td><a class="forgetten" href="forgetten.html">Forget your password?</a></td>
                   </tr>
                </table>
                </form>
            </div>
        </div>

        <div class="main-body">
            <div class="body-container">
                <h1>Create an account</h1>
            <p>it`s quick and easy:</p>
            <form action="register.php" method="post"  onsubmit="return validateForm()" id="registration-form" >
                <input  class="text" type="text"  name="name" placeholder="Enter your Name" required><br><br>
                <input  class="text" type="email" id="email" name="email" placeholder="Enter your Email ID" required><br><br>
                <input  class="text" type="text" name="Address" placeholder="Enter your Address" required><br><br>
                <input  class="text" type="text" id="mobile" name="mobile" placeholder="Enter your Mobile number" required><br><br>
                <div class="pass">
                    <input class="text" type="password"   name="password" id="password" placeholder="Enter your Password" required>
                    <span class="toggle-password" onclick="togglePasswordVisibility()"><i class="fa fa-eye"></i></span>
                </div>
                <br><br>
                <p>By clicking Register,you agree to the <a class="policy" href="">Terms,Data policy<br> and Cookie policy.</a>You may recieve SMS notifications<br></p><br>
                <button id="register"><b>Register</b></button> 
            </div>
            </form>
            
        </div>
    </div>

    <script src="script.js"></script>

    <script>
        $(document).ready(function() {
            $("#register").click(function(e) {
                e.preventDefault();
                
                var formData = $("#registration-form").serialize();

                $.ajax({
                    type: "POST",
                    url: "register.php",
                    data: formData,
                    success: function(data) {
                        alert(data);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            });
        });
    </script>
  
    <script>
        var registrationMessage = "<?php echo $registrationMessage; ?>";
        if (registrationMessage !== "") {
            alert(registrationMessage);
        }
    </script>

</body>
</html> 