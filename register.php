<?php require 'config.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- Bootstrap CSS -->
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

    <h1>Sign Up</h1>

    <form method="post" action="">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" class="form-control">

        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control">

        <input type="submit" value="Register" name="register" class="btn btn-primary fw-bold">

        <p>Already have an account? <a href="login.php">Sign In</a></p>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
require 'config.php';

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

        // Check if the username already exists
        $userCheck = $conn->prepare("SELECT Username FROM user WHERE Username = ?");
        $userCheck->bind_param("s", $username);
        $userCheck->execute();
        $userCount = $userCheck->get_result();

        if ($userCount->num_rows > 0) {
            echo "<script>Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Username $username already exists!',
            showConfirmButton: false
        });</script>";
        } else {
            // Insert new user if the username doesn't exist
            $insertQuery = $conn->prepare("INSERT INTO user (Username, Password) VALUES (?, ?)");
            $insertQuery->bind_param("ss", $username, $password);

            if ($insertQuery->execute()) {
                header("Location: login.php");
                exit();
            } else {
                echo "<script>Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Registration Failed!',
                showConfirmButton: false
            });</script>";
            }
        }

        $conn->close();
    }
}
?>