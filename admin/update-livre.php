<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    if (file_exists('./inc/_head.php')) include './inc/_head.php';
    ?>
    <title>Document</title>
</head>

<body>
    <div class="wrapper">
        <?php if (file_exists('./inc/_left-menu.php')) include './inc/_left-menu.php'; ?>

        <div class="main">
            <?php if (file_exists('./inc/_top-menu.php')) include './inc/_top-menu.php'; ?>

            <main class="content">
                <div class="d-flex flex-column justify-content-between align-items-center">
                    <h1>Books</h1>

                    <?php
                    // 1 Connexion
                    require_once('../core/connexion.php');
                    // 2 Write the query
                    $sql = 'SELECT * FROM Livres WHERE liv_id='.$_GET["id"];
                    // 3 Exec the query
                    $query = mysqli_query($connexion, $sql) or die(mysqli_error($connexion));
                    if (mysqli_num_rows($query) == 0) header("Location:error.php");
                    // 4 Data processing
                    $book = mysqli_fetch_assoc($query);
                    ?>

                    <form action="../core/liveManager.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="modify">
                        <input type="hidden" name="id" value="<?php echo $book["liv_id"]; ?>">
                        <input type="hidden" name="old_visuel" value="<?php echo $book["liv_visuel"]; ?>">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" id="title" name="title" class="form-control" value="<?php echo $book["liv_title"]; ?>"></input>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" cols="30" rows="10" id="description" class="form-control" value="<?php echo $book["liv_description"]; ?>"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="author">Author</label>
                            <input type="text" id="author" name="author" class="form-control" value="<?php echo $book["liv_author"]; ?>"></input>
                        </div>

                        <div class="row">
                            <div class="col-12 col-md">
                                <img src="../images/<?php echo $book["liv_visuel"]; ?>" alt="" class="img-fluid"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12 col-md">
                                <label for="visuel">Visuel</label>
                                <input type="file" id="visuel" name="visuel" class="form-control"></input>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3 mx-auto"> Save </button>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>

</html>