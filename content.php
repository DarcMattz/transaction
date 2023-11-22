<?php require "config.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .container {
            margin-top: 20px;
        }

        img {
            width: 100%;
            max-width: 300px;
            height: auto;
        }

        .comment-container {
            width: 100%;
            margin-top: 20px;
        }

        .comment-box {
            width: 100%;
            min-height: 100px;
        }

        .comment-submit {
            margin-top: 10px;
        }
    </style>
    <title>Document</title>
</head>

<body>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="home.php" class="btn btn-secondary">Back</a>
        </div>
    </div>
    <br><br>
    <form method="post">
        <div class="container">
            <?php
            $id = $_GET['num'];
            $user = $_GET['user'];
            $sql = "SELECT * FROM post";
            $con = $conn->query($sql) or die("error running query $sql");
            while ($data = $con->fetch_assoc()) {
                if ($data['blogID'] == $id) {
                    echo "
                        <div class='card mb-3'>
                            <div class='card-header'>
                                <h2 class='card-title'>$data[blog_title]</h2>
                            </div>
                            <div class='card-body'>
                                <img src='$data[blog_pic]' alt='$data[blog_title]'>
                                <p class='card-text'>$data[blog_content]</p>
                                <p>Filed under: $data[blog_cat] | Date: $data[dateTime_created]</p>
                            </div>
                        </div>
                        ";
                }
            }
            ?>
        </div>
        <div class="container">
            <div class="form-group">
                <label for="comment" class="form-label">Comment</label>
                <textarea name='comment' class='form-control comment-box' cols='30' rows='5'></textarea>
            </div>
            <div class="text-end">
                <input type="submit" class="btn btn-primary" name="post" value="Post Comment">
            </div>
        </div>

        <div class="container">
            <?php
            $sql1 = "SELECT * FROM comment";
            $con1 = $conn->query($sql1) or die("error running query $sql1");
            while ($data = $con1->fetch_assoc()) {
                if ($data['blogID'] == $id) {
                    echo "
                            <div class='card mb-2'>
                                <div class='card-body'>
                                    <p class='card-text'>$data[UserNAME] says:</p>
                                    <p class='card-text'>$data[Comment]</p>
                                    -----------------------------
                                    <p class='card-text'>$data[DateTime]</p>
                                </div>
                            </div>
                            ";
                }
            }
            ?>
        </div>
    </form>
</body>

</html>

<?php
if (isset($_POST['post'])) {
    $comment = $_POST['comment'];
    $add = "INSERT INTO comment (blogID, Comment, UserNAME) VALUES ('$id', '$comment', '$user')";
    $conn->query($add) or die("error running query $add");
    echo "<script> 
        Swal.fire('Commented!')
        </script>";
    header("Refresh:1;url=content.php?num=$id & user=$user");
}
?>