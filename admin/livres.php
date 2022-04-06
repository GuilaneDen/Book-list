<?php
    session_start();
?>
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
                <?php
                    if(isset($_SESSION["message"])){
                        if(isset($_SESSION["message"]["success"])){
                            echo '<div class="alert alert-success my-3">'.$_SESSION["message"]["success"].'</div>';
                        }
                        unset($_SESSION["message"]);
                    }
                ?>
                <div class="d-flex justify-content-between align-items-center">
                    <h1>Books</h1>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Add
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="../core/liveManager.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="action" value="add">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" id="title" name="title" class="form-control"></input>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea cols="30" rows="10" id="description" name="description" class="form-control"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="author">Author</label>
                                            <input type="text" id="author" name="author" class="form-control"></input>
                                        </div>
                                        <div class="form-group">
                                            <label for="visuel">Visuel</label>
                                            <input type="file" id="visuel" name="visuel" class="form-control"></input>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-responsive">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // 1 Connexion
                            require_once('../core/connexion.php');
                            // 2 Write the query
                            $sql = 'SELECT * FROM Livres';
                            // 3 Exec the query
                            $query = mysqli_query($connexion, $sql) or die(mysqli_error($connexion));
                            // 4 Data processing
                            if(mysqli_num_rows($query) == 0){
                                echo '<tr><td colspan="5">No book</td></tr>';
                            }else{
                                // With a while loop we create the row table
                                while($livre = mysqli_fetch_array($query)){
                        ?>

                        <tr>
                            <td><?php echo $livre["liv_id"];?></td>
                            <td><img src="../images/<?php echo $livre["liv_visuel"];?>" alt="" class="img-list"></td>
                            <td><?php echo $livre["liv_title"];?></td>
                            <td><?php echo $livre["liv_author"];?></td>
                            <td class="d-inline-block">
                                <a href="../core/liveManager.php?action=delete&id=<?php echo $livre["liv_id"] ?>" class="btn btn-danger" >
                                    <i class="align-middle" data-feather="trash"></i>
                                </a>
                                <a href="update-livre.php?id=<?php echo $livre["liv_id"] ?>" class="btn btn-primary ms-3" >
                                    <i class="align-middle " data-feather="edit-2"></i>
                                </a>
                            </td>
                        </tr>

                        <?php
                                }
                            }
                        ?>
                    </tbody>
                </table>
			</main>

            <?php if (file_exists('./inc/_footer.php')) include './inc/_footer.php'; ?>
		</div>
	</div>
    <?php
        if (file_exists('./inc/_js.php')) include './inc/_js.php';
    ?>
</body>
</html>