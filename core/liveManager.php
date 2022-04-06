<?php

session_start();

// We handle the action variable with a switch

$action="";

if(isset($_POST["action"])){
    $action = $_POST["action"];
}elseif(isset($_GET["action"])){
    $action = $_GET["action"];
}

switch($action){
    case "add":
        addBook($_POST, $_FILES);
        break;
    case "delete":
        deleteBook($_GET['id']);
        break;
    case "modify":
        modifyBook($_POST, $_FILES);
        break;
    default:
}

/**
 * Function which add a book in the database, and transfer the image from the tmp folder to the image folder in the server
 */

function manageImage($files){
    $images = $files["visuel"]["name"];
    $ext = pathinfo($images, PATHINFO_EXTENSION);
    $imageName = "image_".uniqid().".".$ext;
    move_uploaded_file($files["visuel"]["tmp_name"],"../images/".$imageName);

    return $imageName;
}

function addBook($post, $files){
    require_once("connexion.php");

    $title = htmlentities(htmlspecialchars($post["title"]));
    $description = htmlentities(htmlspecialchars($post["description"]));
    $author = htmlentities(htmlspecialchars($post["author"]));
    //
    $images = $files["visuel"]["name"];
    $ext = pathinfo($images, PATHINFO_EXTENSION);
    $imageName = "image_".uniqid().".".$ext;
    move_uploaded_file($files["visuel"]["tmp_name"],"../images/".$imageName);
    //
    $sql = 'INSERT INTO Livres (liv_title,liv_description,liv_author,liv_visuel) VALUES ("'.$title.'","'.$description.'","'.$author.'","'.$imageName.'")';
    //
    mysqli_query($connexion,$sql) or die(mysqli_error($connexion));
    //
    header("Location:".$_SERVER["HTTP_REFERER"]);
}

function deleteBook($id){
    require_once("connexion.php");

    $sql = "SELECT liv_visuel FROM Livres WHERE liv_id=".$id;
    $query =  mysqli_query($connexion, $sql) or die(mysqli_error($connexion));
    $image = mysqli_fetch_array($query);

    unlink("../images/".$image);

    $sql = "DELETE FROM Livres WHERE liv_id=".$id;
    $query =  mysqli_query($connexion, $sql) or die(mysqli_error($connexion));
    header("Location:".$_SERVER["HTTP_REFERER"]);
}

function modifyBook($post, $files){
    require_once("connexion.php");

    $image = $post["old_visuel"];

    if(!empty($_files["visuel"]["tmp_name"])){
        unlink("../images/".$post["old_visuel"]);
        $image = manageImage($files);
    }

    $title = htmlentities(htmlspecialchars($post["title"]));
    $description = htmlentities(htmlspecialchars($post["description"]));
    $author = htmlentities(htmlspecialchars($post["author"]));

    $sql = 'UPDATE Livres SET liv_title="'.$title.'",liv_description="'.$description.'",liv_author="'.$author.'",liv_visuel="'.$image.'" WHERE liv_id='.$post["id"];
    mysqli_query($connexion,$sql) or die(mysqli_error($connexion));
    //
    $_SESSION["message"]["success"] = "Book information updated";
    header("Location:../admin/livres.php");
}

?>