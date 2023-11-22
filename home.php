    <?php

    require('config.php');
    session_start();

    if (isset($_GET['logout'])) {
        session_destroy();
        header("Location: login.php");
    }

    ?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>Home</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <style>
            body {
                font-family: 'Arial', sans-serif;
                background-color: #2B3499;
                text-align: center;
                padding: 50px;
            }

            .navbar {
                margin-bottom: 20px;
                background-color: #FF6C22;
            }

            .navbar-nav a {
                color: white !important;
                transition: color 0.3s ease;
            }

            .navbar-nav a:hover {
                color: gray !important;
            }

            .blog-entry {
                margin-top: 20px;
                margin-bottom: 20px;
                padding: 20px;
                color: white;
                border: 1px solid #FF6C22;
            }

            .comment-section {
                margin-top: 10px;
            }

            .comment-form {
                margin-top: 10px;
            }

            a {
                text-decoration: none;
            }
        </style>
    </head>

    <body>

        <?php

        if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
            echo "<script>Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Login ka muna Kaibigan',
            showConfirmButton: false,
            timer: 1500
            })
            </script>";
            header("Refresh:1;url=login.php");
            die();
        }

        ?>

        <div class="container">

            <nav class="navbar navbar-expand-lg fixed-top justify-content-end">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item mx-3">
                            <a class="nav-link" href="home.php">Home</a>
                        </li>
                        <li class="nav-item mx-3">
                            <a class='nav-link' href='create.php?user=$name'>Create Blog</a>
                        </li>
                        <li class="nav-item mx-3">
                            <a class="nav-link" href="login.php" value="logout">Logout</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="blog-entries">

                <?php
                $sql = "SELECT post.*, comment.Comment, comment.DateTime, comment.UserNAME FROM post LEFT JOIN comment ON post.blogID = comment.blogID";
                $result = $conn->query($sql);

                $name = $_SESSION['username'];

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<a href='content.php?num=$row[blogID]&user=$name'>";
                        echo "<div class='blog-entry'>";
                        echo "<h2>" . $row['blog_title'] . "</h2>";
                        echo "<img src='" . $row['blog_pic'] . "' alt='" . $row['blog_title'] . "' height='300px'>";
                        echo "<p>" . $row['blog_content'] . "</p>";
                        echo "<p><br>" . $row['blog_cat'] . "<br> Date: " . $row['dateTime_created'] . "</p>";

                        if ($row['Comment']) {
                            echo "<div class='comment-section'>";
                            echo "<h4>Comments:</h4>";
                            echo "<p><strong>" . $row['UserNAME'] . ":</strong> " . $row['Comment'] . " - " . $row['DateTime'] . "</p>";
                            echo "</div>";
                        }

                        echo "</div>";
                        echo "</a>";
                    }
                } else {
                    echo "<p>No blog entries found.</p>";
                }

                $conn->close();
                ?>
            </div>
    </body>

    </html>