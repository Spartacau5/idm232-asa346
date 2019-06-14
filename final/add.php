<?
include('includes/connect.php');
if (isset($_POST['action'])) {
    if ($_POST['action'] == "submit") {
        foreach ($_FILES["image"]["name"] as $key => $error) {
            if (basename($_FILES["image"]["name"][$key]) != "") {
                $imageFileType = pathinfo(basename($_FILES["image"]["name"][$key]), PATHINFO_EXTENSION);
                $imageFileType = strtolower($imageFileType);
                // Allow certain file formats
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                    $message  = 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.';
                    $uploadOk = 0;
                    $class    = "has-error";
                    break;
                }
                // Check if image file is a actual image or fake image
                $check = getimagesize($_FILES["image"]["tmp_name"][$key]);
                if ($check !== false) {
                    //$message = "File is an image - " . $check["mime"] . ".";
                } else {
                    $message  = 'File is not an image. Sorry, there was an error uploading your file.';
                    $uploadOk = 0;
                    $class    = "has-error";
                    break;
                }
            }
        }
        if ($uploadOk !== 0) {
            foreach ($_FILES["image"]["name"] as $key => $error) {
                if (basename($_FILES["image"]["name"][$key]) != "") {
                    $target_dir  = "images/";
                    $newfilename = time() . '_' . rand(100, 999) . '.' . pathinfo(basename($_FILES["image"]["name"][$key]), PATHINFO_EXTENSION);
                    $newfilename = strtolower($newfilename);
                    $target_file = $target_dir . $newfilename;
                    $filename[]  = $newfilename;
                    if (move_uploaded_file($_FILES["image"]["tmp_name"][$key], $target_file)) {
                        //$message = "The file ". basename( $_FILES["image"]["name"][$key]). " has been uploaded.";
                    }
                }
            }
            $title = mysqli_real_escape_string($link, $_POST['title']);
            $category = mysqli_real_escape_string($link, $_POST['category']);
            $description = mysqli_real_escape_string($link, $_POST['description']);
            $time = mysqli_real_escape_string($link, $_POST['time']);
            $servings = mysqli_real_escape_string($link, $_POST['servings']);
            $ingredients = mysqli_real_escape_string($link, $_POST['ingredients']);
            $steps = mysqli_real_escape_string($link, $_POST['steps']);
            $image = mysqli_real_escape_string($link, $filename[0]);
            $ingredientsimage = mysqli_real_escape_string($link, $filename[1]);
            mysqli_query($link, "INSERT INTO recipe (title, category, description, time, servings, ingredients, steps, image, ingredientsimage)
                VALUES ('$title', '$category', '$description', '$time', '$servings', '$ingredients', '$steps', '$image', '$ingredientsimage')");
            $recipe = mysqli_query($link, "SELECT id FROM recipe WHERE image='$image'");
            $recipe = mysqli_fetch_assoc($recipe);
            header('Location: recipe.php?id='.$recipe['id']);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Grandma's Pantry</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </head>
    <body>
    <center>
        <a href="index.php">
        <img src="logo.png" alt="Grandma's Kitchen">
        </a>
        <h2> Grandma's Pantry </h2>
        <form action="add.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
        <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="<?=$_POST['title']?>" style="width: 500px;" required autofocus>
        </div>
        <div class="form-group">
        <select class="form-control" id="category" name="category" style="width: 500px;" required>
            <option value="Breakfast" <? if($_POST['category']=='Breakfast') echo 'selected'; elseif($_POST['category']=='') echo 'selected';?>>Breakfast</option>
            <option value="Snack" <? if($_POST['category']=='Snack') echo 'selected';?>>Snack</option>
            <option value="Lunch" <? if($_POST['category']=='Lunch') echo 'selected';?>>Lunch</option>
            <option value="Dinner" <? if($_POST['category']=='Dinner') echo 'selected';?>>Dinner</option>
        </select>
        </div>
        <div class="form-group">
        <textarea class="form-control" id="description" name="description" rows="10" placeholder="Description" style="width: 500px;" required><?=$_POST['description']?></textarea>
        </div>
        <div class="form-group">
        <textarea class="form-control" id="ingredients" name="ingredients" rows="10" placeholder="Ingredients" style="width: 500px;" required><?=$_POST['ingredients']?></textarea>
        </div>
        <div class="form-group">
        <input type="number" class="form-control" id="time" name="time" placeholder="Time" value="<?=$_POST['time']?>" style="width: 500px;" required>
        </div>
        <div class="form-group">
        <input type="number" class="form-control" id="servings" name="servings" placeholder="Servings" value="<?=$_POST['servings']?>" style="width: 500px;" required>
        </div>
        <div class="form-group">
        <textarea class="form-control" id="steps" name="steps" rows="10" placeholder="Steps" style="width: 500px;" required><?=$_POST['steps']?></textarea>
        </div>
        <div class="form-group">
            <label>Recipe Image</label>
            <input type="file" class="form-control" id="image" name="image[]" style="width: 500px;" required>
        </div>
        <div class="form-group">
            <label>Ingredients Image</label>
            <input type="file" class="form-control" id="image" name="image[]" style="width: 500px;" required>
        </div>
        <?=$message?>
        <br>
        <br>
        <button type="submit" name="action" value="submit" class="btn btn-warning">Submit</button>
        <br>
        <br>
        </form>
    </center>
    </body>
</html>
