<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create a Blog</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            padding-top: 56px;
            background-image: url('bg1.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            padding: 50px;
        }

        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <?php
    require('config.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $blogTitle = $_POST['blogTitle'];
        $blogContent = $_POST['blogContent'];
        $blogCategory = $_POST['blogCategory'];

        $imageDir = "c:\\xampp\\htdocs\\transaction\\img\\";
        $imageName = $_FILES['blogPic']['name'];
        $imageTmp = $_FILES['blogPic']['tmp_name'];
        $imagePath = $imageDir . $imageName;
        move_uploaded_file($imageTmp, $imagePath);

        $pic = "img/" . $imageName;

        $sql = "INSERT INTO POST (blog_title, blog_content, blog_cat, blog_pic, dateTime_created) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $blogTitle, $blogContent, $blogCategory, $pic);

        if ($stmt->execute()) {
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Successfully Added!'
                    }).then(() => {
                        window.location.href = 'home.php';
                    });
                </script>";
        } else {
            echo "Blog entry creation failed.";
        }


        $stmt->close();
        $conn->close();
    }
    ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="form-container">
                    <h2 class="text-center mb-4">Post a Blog</h2>

                    <form method="post" action="create.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <input class="form-control" type="text" name="blogTitle" placeholder="Blog Title" required>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="blogContent" placeholder="Blog Content" rows="6" required></textarea>
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="blogCategory" required>
                                <option value="Travel Blog">Travel Blog</option>
                                <option value="Food Blog">Food Blog</option>
                                <option value="Fashion Blog">Fashion Blog</option>
                                <option value="Fitness Blog">Fitness Blog</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input class="form-control-file" type="file" name="blogPic" accept="image/*" required>
                        </div>
                        <div class="form-group text-center">
                            <input type="submit" class="btn btn-primary" value="Post Blog">
                        </div>
                    </form>

                    <p class="error-message"></p>
                </div>
            </div>
        </div>
    </div>

</body>

</html>