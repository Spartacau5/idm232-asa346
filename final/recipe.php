<?php
include('includes/connect.php');
$id = mysqli_real_escape_string($link, $_GET['id']);
$recipe = mysqli_query($link,"SELECT * FROM recipe WHERE id = '$id' LIMIT 1");
$recipe = mysqli_fetch_array($recipe);

if ($_GET['action'] == "delete")
{
    unlink('images/'.$folder.'/'.$recipe['image']);
    unlink('images/'.$folder.'/'.$recipe['ingredientsimage']);
    mysqli_query($link, "DELETE FROM recipe WHERE id = '$id' LIMIT 1");
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Grandma's Pantry</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <link rel="stylesheet" type="text/css" href="main.css">
</head>

<body>
    <?php
    include('includes/header.php');
    ?>
    <div class="content">
            <div class="opencard">
                <a href="index.php">
                <img src="images/back.png" alt="back button" class="back">
                </a>
                    <img src="images/<?php echo $recipe['folder']?>/<?php echo $recipe['image']?>" alt="<?php echo $recipe['title']?>" class="opencard-img">
                    <div class="cardinfo">
                        <div class="ingheader">
                        <h4><?php echo trim($recipe['title'], '"');?></h4>
                        <p class="description"><?php echo trim($recipe['description'], '"');?></p>
                        </div>
                            <div class="ingredients">
                                <h3 class="inghead">Ingredients</h3>
                                <ul>
                                    <?php
                                    if ($recipe['ingredients'] !== '')
                                    {
                                        $i = 0;
                                        $ingredients = explode(';', nl2br(trim($recipe['ingredients'], '"')));
                                        foreach ($ingredients as $ingredient)
                                        {
                                            if ($ingredient !== '') {
                                                $i ++;
                                                echo '<li>'.$ingredient.'</li>';
                                            }
                                        }
                                    } 
                                    ?>
                                </ul>
                                <img src="images/<?php echo $recipe['folder']?>/<?php echo $recipe['ingredientsimage']?>" alt="ingredients" class="ingimg">
                            
                            </div>
                            <!-- <h3 class="inghead">
                                Prepare the ingredients:
                            </h3> -->
                            <?php
                                $steps = $recipe['steps'];
                                $steps = trim($steps, '"');
                                $steps = explode('\\', nl2br($steps));
                                $i = 0;
                                foreach ($steps as $key => $step)
                                {
                                    $step = ltrim($step, '[');
                                    $step = rtrim($step, ']');
                                    $step = explode('|', nl2br($step));
                                    $i++;
                                    foreach ($step as $key => $value)
                                    {
                                        if ($value !== '') {
                                            if ($key % 2 == 0) {
                                                echo '<h3 class="inghead">'.$value.'</h3>';
                                            }
                                            else
                                            {
                                                echo '<div class="steps">';
                                                echo '<img src="images/'.$recipe['folder'].'/'.$recipe['stepimage'.$i].'" alt="Step '.$i.'" class="ingsteps">';
                                                echo '<li>'.$value.'</li>';                             
                                                echo '</div>';
                                            }
                                        }
                                    }
                                }
                            ?>
                            <!-- <div class="steps">

                                    <img src="images/step1.jpg" alt="Step 1" class="ingsteps">
                                    1. Fill a medium pot with water; add a big pinch of salt and heat to boiling on high. Wash and dry the fresh
                                    produce. Cut out and discard the core of the cabbage; thinly slice the leaves. Peel and roughly chop the garlic.
                            </div>
                            <div class="steps">
                                <img src="images/step2.jpg" alt="Step 2" class="ingsteps">
                                    2. Pat the shrimp dry with paper towels; season with salt and pepper. In a medium pan, heat a drizzle of olive
                                    oil on medium-high until hot. Add the seasoned shrimp; cook, stirring occasionally, 3 to 4 minutes, or until
                                    opaque and cooked through. Leaving any browned bits (or fond) in the pan, transfer to a plate. Set aside in a
                                    warm place.
                            </div>
                            <div class="steps">
                                <img src="images/step3.jpg" alt="Step 3" class="ingsteps">

                                    3. Add the sliced cabbage to the pan of reserved fond; season with salt and pepper. (If the pan seems dry, add a
                                    drizzle of olive oil.) Cook on mediumhigh, stirring occasionally, 2 to 3 minutes, or until slightly softened.
                                    Add the verjus and 1/4 cup of water; season with salt and pepper. Cook, stirring occasionally and scraping up
                                    any fond, 3 to 5 minutes, or until the cabbage has softened and the water has cooked off. Transfer to the plate
                                    of cooked shrimp. Wipe out the pan.
                            
                            
                            </div>
                            <div class="steps">
                                <img src="images/step4.jpg" alt="Step 4" class="ingsteps">
                                
                                    4. While the cabbage cooks, add the pasta to the pot of boiling water. Cook, stirring occasionally, 9 to 11
                                    minutes, or until al dente (still slightly firm to the bite). Reserving 1/2 cup of the pasta cooking water,
                                    drain thoroughly.
                               
                            </div>
                            <div class="steps">
                                <img src="images/step5.jpg" alt="Step 5" class="ingsteps">
                                
                                    5. While the pasta cooks, in the same pan, heat 2 teaspoons of olive oil on medium-high until hot. Add the
                                    chopped garlic; season with salt and pepper. Cook, stirring constantly, 30 seconds to 1 minute, or until
                                    softened and fragrant. Add the tomato sauce, 1/3 cup of water, and as much of the chile paste as you’d like,
                                    depending on how spicy you’d like the dish to be; season with salt and pepper. Cook, stirring occasionally, 4 to
                                    5 minutes, or until thickened. Season with salt and pepper to taste.
                                
                            </div>
                            <h3 class="inghead">
                                Serve your dish:
                            </h3>
                            <div class="steps">
                                <img src="images/step6.jpg" alt="Step 6" class="ingsteps">
                            
                                
                                 
                                    6. Add the cooked pasta, cooked shrimp and cabbage, and half the reserved pasta cooking water to the pan. Cook,
                                    stirring vigorously, 1 to 2 minutes, or until coated. (If the sauce seems dry, gradually add the remaining pasta
                                    cooking water to achieve your desired consistency.) Turn off the heat; stir in the crème fraîche until
                                    thoroughly combined. Season with salt and pepper to taste. Top the finished pasta with the almonds and a drizzle
                                    of olive oil. Enjoy!
                                
                            </div> -->

                    </div>
            </div> 
    </div>
</body>
<script src="" async defer></script>
</html>