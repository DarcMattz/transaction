<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            padding-top: 56px;
            background-image: url('bg1.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-color: black;
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            padding: 50px;
        }

        .comment-form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .error-message {
            color: #ff0000;
        }
    </style>
</head>

<body>

    <div class="comment-form">
        <p class="error-message">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $blogID = $_POST['blogID'];
                $newComment = $_POST['newComment'];

                if (!empty(trim($newComment))) {
                    require('config.php');

                    $sql = "INSERT INTO comment (blogID, UserNAME, Comment, DateTime) VALUES (?, 'Anonymous', ?, NOW())";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("is", $blogID, $newComment);

                    if ($stmt->execute()) {
                        echo "<script>Swal.fire({icon: 'success',title:'Added',text: 'Comment Successfully Added'}).then(() => {
                        window.location.href = 'home.php?blogID=" . $blogID . "';
                    });</script>";
                    } else {
                        echo "<script>Swal.fire({icon: 'error',title: 'Failed',text: 'Failed to add comment'});</script>";
                    }
                    $stmt->close();
                    $conn->close();
                } else {
                    echo "<script>Swal.fire({icon: 'warning',title: 'Invalid',text: 'Comment cannot be empty'}).then(() => {
                    window.location.href = 'home.php';
                });</script>";
                }
            }
            ?>
        </p>
    </div>

</body>

</html>