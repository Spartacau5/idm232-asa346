<?php
include('includes/connect.php');
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
            <div class="filter-space"> 
                <?php
                $page = $_GET['page'];
                if ($page == '') { $page = 1; }
                $limit = 8;
                $offset = $limit * ($page-1);
                $result = mysqli_query($link, "SELECT * FROM recipe WHERE title like '%".strtolower(mysqli_real_escape_string($link, $_GET['q']))."%' OR description like '%".strtolower(mysqli_real_escape_string($link, $_GET['q']))."%' OR tags like '%".strtolower(mysqli_real_escape_string($link, $_GET['q']))."%' OR category like '%".strtolower(mysqli_real_escape_string($link, $_GET['q']))."%' ORDER BY id ASC LIMIT $offset, $limit");
                $result_count = mysqli_query($link, "COUNT(SELECT * FROM recipe WHERE title like '%".strtolower(mysqli_real_escape_string($link, $_GET['q']))."%' OR description like '%".strtolower(mysqli_real_escape_string($link, $_GET['q']))."%' OR tags like '%".strtolower(mysqli_real_escape_string($link, $_GET['q']))."%' OR category like '%".strtolower(mysqli_real_escape_string($link, $_GET['q']))."%' ORDER BY id ASC LIMIT $offset, $limit)");
                //$result = mysqli_query($link, "SELECT * FROM recipe ORDER BY id ASC LIMIT $offset, $limit");
                ?>
                <h3> Search results... <?php echo $result_count;?></h3>
                <form action="search.php" method="get" class="filter-form">
                    <select name="q" class="select" onchange="this.form.submit()">
                        <option value disabled selected> Types... </option>
                        <option value="Breakfast"> Breakfast </option>
                        <option value="Snack"> Snack </option>
                        <option value="Lunch"> Lunch </option>
                        <option value="Dinner"> Dinner </option>
                    </select>
                </form>
            </div>
        <div class="flexbox"> 
            <?php
            $i = 0;
            while ($row = mysqli_fetch_array($result))
            {
            $i ++;
            ?>
            <div class="card">
                <a href="recipe.php?id=<?php echo $row['id']?>" class="card-link">
                    <img src="images/<?php echo $row['folder']?>/<?php echo $row['image']?>" alt="<?php echo $row['name']?>" class="card-img"> 
                    <div class="container">
                        <h4><?php echo trim($row['title'], '"');?></h4>
                        <p> <?php echo trim($row['time'], '"');?> mins | <?php echo $row['category']?>
                        </div>
                </a>
            </div>
            <?php
            }
            ?>
        </div>
            <?php
            if ($i==0)
            {
            ?>
            <div class="filter-space">
            <h3>Sorry, no results found.</h3>
            </div>
            <?php
            }
            ?>
        <div class="footer-space">
            <nav aria-label="Page navigation">
            <ul class="pagination" style="text-align: center;">
            <?php
            $show_first = false;
            $current = $_GET['page'];
            if ($current == '') { $current = 1; }
            if ($page == '') { $page = 1; }
            $next = $current +1;
            $previous = $current -1;
            if ($previous <= 0)
            {
                $previous = 1;
            }
            $page = $current;
            $start = $page - 2;
            $end = $page + 1;
            if ($start <= 2)
            {
                $start = 1;
                $end = 5;
                $show_first = false;
            }
            if ($i < 8) {
                $end = $current;
            }
            ?>
            <?php
            if ($current > 1) {
                echo '
                    <a href="search.php?q='.$_GET['q'].'&page='.$previous.'" class="space">
                    <span aria-hidden="true">&laquo;</span>
                    </a>';
            }
            else {
                echo '
                    <a href="#" class="space">
                    <span aria-hidden="true">&laquo;</span>
                    </a>';
            }
            while ($start <= $end)
            {
                if ($start == $current)
                {
                    if ($start=="1")
                    {
                        echo '<b><a href="search.php?q='.$_GET['q'].'" class="space">1</a></b>';
                    }
                    else {
                        echo '<b><a href="search.php?q='.$_GET['q'].'&page='.$current.'" class="space">'.$current.'</a></b>';
                    }
                }
                else
                {
                    if ($start=="1")
                    {
                        echo '<a href="search.php?q='.$_GET['q'].'" class="space">1</a>';
                    }
                    else{
                        echo '<a href="search.php?q='.$_GET['q'].'&page='.$start.'" class="space">'.$start.'</a>';
                    }
                }
                $start ++;
            }
            if ($end != $current) {
                echo '
                    <a href="search.php?q='.$_GET['q'].'&page='.$next.'" class="space">
                    <span aria-hidden="true">&raquo;</span>
                    </a>';
            }
            ?>
            </ul>
        </nav>
        </div>
    </div>
    </body>
    <script src="" async defer></script>
</html>