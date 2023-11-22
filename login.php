<?php
require 'config.php';
session_start();

if (isset($_GET['logout']) || isset($_SESSION['username'])) {
    session_destroy();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #2B3499;
            text-align: center;
            padding: 50px;
        }

        h1 {
            margin-top: 100px;
            color: white;
        }

        form {
            max-width: 500px;
            margin: 0 auto;
            background-color: #FF6C22;
            padding: 20px;
            border-radius: 8px;
        }

        label {
            color: white;
            margin-bottom: 0.5rem;
            display: block;
            text-align: left;
        }

        input {
            width: 100%;
            padding: 0.375rem 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #2B3499;
            border-radius: 0.25rem;
            box-sizing: border-box;
        }

        p {
            color: white;
            margin-top: 1rem;
        }

        a {

            color: white;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <h1>Welcome back!</h1>

    <form action="" method="post">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" class="form-control">

        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control">
        <input type="submit" value="Login" name="submit" class="btn btn-primary fw-bold">
        <p>Don't have an account? <a href="register.php">Sign Up</a></p>
    </form>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['username']) || empty($_POST['password'])) {
        echo "<script>Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Input username and password!',
                    showConfirmButton: false,
                });</script>";
    } else {

        $username = $_POST['username'];
        $password = $_POST['password'];

        $result = $conn->query("SELECT * FROM user WHERE Username = '$username'");
        if ($result->num_rows > 0) {
            $userdetails = $result->fetch_assoc();
            $storedPassword = $userdetails['Password'];

            if ($password === $storedPassword) {
                echo 'match';
                session_start();
                $_SESSION['username'] = $username;
                $_SESSION['password'] = $username;
                header('Location: home.php');
            } else {
                echo "<script>Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Invalid password!',
                        showConfirmButton: false,
                    });</script>";
            }
        } else {
            echo "<script>Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Invalid username!',
                    showConfirmButton: false,
                });</script>";
        }
    }
}
?>