<?php

if(isset($_GET['search'])){

    if($_GET['search'] == ''){
        $search = '';
    }else{
        $search =  $_GET['search'] ;
    }

}else{
    $search = '';
}

if(isset($_GET['tags'])){

    if($_GET['tags'] == ''){
        $tags = '';
    }else{
        $tags =  $_GET['tags'] ;
    }

}else{
    $tags = '';
}

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

include 'auth/auth.php';

include 'includes/header.php';
?>

<!--======================================
        START HERO AREA
======================================-->
<section class="hero-area pt-80px pb-80px hero-bg-1">
    <div class="overlay"></div>
    <span class="stroke-shape stroke-shape-1"></span>
    <span class="stroke-shape stroke-shape-2"></span>
    <span class="stroke-shape stroke-shape-3"></span>
    <span class="stroke-shape stroke-shape-4"></span>
    <span class="stroke-shape stroke-shape-5"></span>
    <span class="stroke-shape stroke-shape-6"></span>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-9">
                <div class="hero-content">
                    <h2 class="section-title pb-3 text-white">Share & grow knowledge with us!</h2>
                    <p class="section-desc text-white">If you are going to use a passage of Lorem Ipsum, you need to be sure there
                        <br> isn't anything embarrassing hidden in the middle of text.
                    </p>
                </div><!-- end hero-content -->
            </div><!-- end col-lg-9 -->
            <div class="col-lg-3">
                <div class="hero-list hero-list-bg">
                    <div class="d-flex align-items-center pb-30px">
                        <img src="images\anonymousHeroQuestions.svg" alt="question icon" class="mr-3">
                        <p class="fs-15 text-white lh-20">Anyone can make suggestions</p>
                    </div>
                    <div class="d-flex align-items-center pb-30px">
                        <img src="images\anonymousHeroAnswers.svg" alt="question answer icon" class="mr-3">
                        <p class="fs-15 text-white lh-20">Anyone can discuss the suggestions</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <img src="images\anonymousHeroUpvote.svg" alt="vote icon" class="mr-3">
                        <p class="fs-15 text-white lh-20">Vote if they are interested in the suggestions</p>
                    </div>
                </div>
            </div>
        </div><!-- end row -->
    </div><!-- end container -->
</section>
<!--======================================
        END HERO AREA
======================================-->

<!-- ================================
         START QUESTION AREA
================================= -->
<section class="question-area pt-80px pb-40px">
    <div class="container">
        <div class="row">
        
            <div class="col-md-8">
                <div class="question-tabs mb-50px">
                    
                    <div class="tab-content pt-40px" id="myTabContent">
                        <div class="tab-pane fade show active">
                            <div class="question-main-bar">
                                <div class="filters d-flex align-items-center justify-content-between pb-4">
                                    <h3 class="fs-17 fw-medium">All Posts</h3>
                                  
                                </div><!-- end filters -->
                                <div class="questions-snippet">

                                

                                <?php 

// find out how many rows are in the table 
           
$numrows = $data->getNumRows("SELECT * FROM posts WHERE title LIKE '%".$search."%' OR details LIKE '%".$search."%'  OR tags LIKE '%".$search."%'  OR tags LIKE '%".$tags."%' "); 
if(isset($_GET['perpage'])){
    $perpage = $_GET['perpage'];
}else{
    $perpage = '10';
}


// number of rows to show per page
$rowsperpage = $perpage ;
// find out total pages
$totalpages = ceil($numrows / $rowsperpage);
                                
// get the current page or set a default
if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {
   // cast var as int
   $currentpage = (int) $_GET['currentpage'];
} else {
   // default page num
   $currentpage = 1;
} // end if

// if current page is greater than total pages...
if ($currentpage > $totalpages) {
   // set current page to last page
   $currentpage = $totalpages;
} // end if
// if current page is less than first page...
if ($currentpage < 1) {
   // set current page to first page
   $currentpage = 1;
} // end if

// the offset of the list, based on current page 
$offset = ($currentpage - 1) * $rowsperpage;

// // get the info from the db 
// $sql = "SELECT id, number FROM numbers LIMIT $offset, $rowsperpage";
// $result = mysql_query($sql, $conn) or trigger_error("SQL", E_USER_ERROR);



$posts = $data->getData("SELECT *, (SELECT COUNT(id) AS count FROM votes WHERE postId = posts.id) AS rank, 
(SELECT COUNT(id) AS comments_count FROM comments WHERE postId = posts.id) AS comments_rank, posts.id as postId FROM posts WHERE posts.title LIKE '%".$search."%' OR posts.details LIKE '%".$search."%'  OR posts.tags LIKE '%".$search."%'
 ORDER BY posts.id DESC LIMIT $offset, $rowsperpage");


foreach($posts as $row) {

    if(isset($_GET['tags'])){

    $tagsArray = explode(",",$row['tags']);

    if (in_array("$tags", $tagsArray)){




?>




                                        <div class="postss-snippet">

                                        


                                            <div class="media media-card media--card align-items-center">
                                            <div class="votes answered-accepted">
                                    <div class="vote-block d-flex align-items-center justify-content-between" title="Votes">
                                        <span class="vote-counts"><?= $row['rank'] ?></span>
                                        <i class="ml-2 fad fa-thumbs-up"></i>
                                    </div>
                                    <div class="answer-block d-flex align-items-center justify-content-between" title="Answers">
                                        <span class="vote-counts"><?= $row['comments_rank'] ?></span>
                                        <i class="ml-2 fad fa-comments"></i>
                                    </div>
                                </div>
                                           
                                                <div class="media-body">
                                                    <h5><a href="posts-details.php?8829988P=<?= $row['postId'] ?>"><?= $row['title'] ?></a></h5>
                                                    <small class="meta">
                                                        <span class="pr-1"><?= time_elapsed_string($row['date']); ?></span>
                                                    </small>
                                                    <div class="tags">
                                                        <?php $tags =  explode(",",$row['tags']); 
                                                            foreach($tags as $tags){
                                                           
                                                        ?>
                                                        <a href="posts.php?tags=<?= $tags ?>" class="tag-link"><?= $tags; ?></a>

                                                        <?php 
                                                            }
                                                        ?>
                                                       
                                                    </div>
                                                </div>
                                            </div><!-- end media -->
                            
                                        </div><!-- end postss-snippet -->

                                        <?php
}
}  else {

    ?>
                <div class="postss-snippet">

                                        


<div class="media media-card media--card align-items-center">
<div class="votes answered-accepted">
<div class="vote-block d-flex align-items-center justify-content-between" title="Votes">
<span class="vote-counts"><?= $row['rank'] ?></span>
<i class="ml-2 fad fa-thumbs-up"></i>
</div>
<div class="answer-block d-flex align-items-center justify-content-between" title="Answers">
<span class="vote-counts"><?= $row['comments_rank'] ?></span>
<i class="ml-2 fad fa-comments"></i>
</div>
</div>

    <div class="media-body">
        <h5><a href="posts-details.php?8829988P=<?= $row['postId'] ?>"><?= $row['title'] ?></a></h5>
        <small class="meta">
            <span class="pr-1"><?= time_elapsed_string($row['date']); ?></span>
        </small>
        <div class="tags">
            <?php $tags =  explode(",",$row['tags']); 
                foreach($tags as $tags){
               
            ?>
            <a href="posts.php?tags=<?= $tags ?>" class="tag-link"><?= $tags; ?></a>

            <?php 
                }
            ?>
           
        </div>
    </div>
</div><!-- end media -->

</div><!-- end postss-snippet -->
    <?php

}     
}                     
                                        ?>







                                        <div
                                            class="pager d-flex flex-wrap align-items-center justify-content-between pt-30px">
                                            <div>

                                            

    <nav class="pt-4">
        <ul class="pagination generic-pagination pr-1">
        <?php

if(isset($_GET['sortby'])) {


/******  build the pagination links ******/
// range of num links to show
$range = 3;

// if not on page 1, don't show back links
if ($currentpage > 1) {
// show << link to go back to page 1
?>
<li class="page-item"><a class="page-link" href="<?php $_SERVER['PHP_SELF']?>?sortby=<?php echo $_GET['sortby'] ?>&currentpage=1"><i
    class="far fa-angle-double-left"></i></a></li>

<?php
// get previous page num
$prevpage = $currentpage - 1;
// show < link to go back to 1 page
?>
<li class="page-item"><a class="page-link"
href="<?php $_SERVER['PHP_SELF']?>?sortby=<?php echo $_GET['sortby'] ?>&currentpage=<?php echo $prevpage ?>"><i
    class="far fa-angle-left"></i></a></li>
<?php
} // end if 

// loop to show links to range of pages around current page
for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
// if it's a valid page number...
if (($x > 0) && ($x <= $totalpages)) {
// if we're on current page...
if ($x == $currentpage) {
// 'highlight' it but don't make a link

?>
<li class="page-item active"><a class="page-link"><?php echo $x ?></a></li>
<?php
// if not current page...
} else {
// make it a link
?>
<li class="page-item"><a class="page-link"
href="<?php $_SERVER['PHP_SELF']?>?sortby=<?php echo $_GET['sortby'] ?>&currentpage=<?php echo $x ?>"><?php echo $x ?></a></li>
<?php
} // end else
} // end if 
} // end for

// if not on last page, show forward and last page links        
if ($currentpage != $totalpages) {
// get next page
$nextpage = $currentpage + 1;
// echo forward link for next page 
?>
<li class="page-item"><a class="page-link"
href="<?php $_SERVER['PHP_SELF']?>?sortby=<?php echo $_GET['sortby'] ?>&currentpage=<?php echo $nextpage ?>"><i
    class="far fa-angle-double-right"></i></a></li>
<?php
// echo forward link for lastpage
?>
<li class="page-item"><a class="page-link"
href="<?php $_SERVER['PHP_SELF']?>?sortby=<?php echo $_GET['sortby'] ?>&currentpage=<?php echo $totalpages ?>"><i
    class="far fa-angle-right"></i></a></li>
<?php
} // end if
/****** end build pagination links ******/



} else {

/******  build the pagination links ******/
// range of num links to show
$range = 3;

// if not on page 1, don't show back links
if ($currentpage > 1) {
// show << link to go back to page 1
?>
<li class="page-item"><a class="page-link" href="<?php $_SERVER['PHP_SELF']?>?currentpage=1"><i
    class="far fa-angle-double-left"></i></a></li>

<?php
// get previous page num
$prevpage = $currentpage - 1;
// show < link to go back to 1 page
?>
<li class="page-item"><a class="page-link"
href="<?php $_SERVER['PHP_SELF']?>?currentpage=<?php echo $prevpage ?>"><i
    class="far fa-angle-left"></i></a></li>
<?php
} // end if 

// loop to show links to range of pages around current page
for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
// if it's a valid page number...
if (($x > 0) && ($x <= $totalpages)) {
// if we're on current page...
if ($x == $currentpage) {
// 'highlight' it but don't make a link

?>
<li class="page-item active"><a class="page-link"><?php echo $x ?></a></li>
<?php
// if not current page...
} else {
// make it a link
?>
<li class="page-item"><a class="page-link"
href="<?php $_SERVER['PHP_SELF']?>?currentpage=<?php echo $x ?>"><?php echo $x ?></a></li>
<?php
} // end else
} // end if 
} // end for

// if not on last page, show forward and last page links        
if ($currentpage != $totalpages) {
// get next page
$nextpage = $currentpage + 1;
// echo forward link for next page 
?>
<li class="page-item"><a class="page-link"
href="<?php $_SERVER['PHP_SELF']?>?currentpage=<?php echo $nextpage ?>"><i
    class="far fa-angle-double-right"></i></a></li>
<?php
// echo forward link for lastpage
?>
<li class="page-item"><a class="page-link"
href="<?php $_SERVER['PHP_SELF']?>?currentpage=<?php echo $totalpages ?>"><i
    class="far fa-angle-right"></i></a></li>
<?php
} // end if
/****** end build pagination links ******/




}
    
    ?>

        </ul>
    </nav>
                                    

                                            </div>
                                          
                                                                                                   
                                        
                                        </div>
                                
                                </div><!-- end questions-snippet -->
                             
                            </div><!-- end question-main-bar -->
                        </div><!-- end tab-pane -->
                    </div><!-- end tab-content -->
                </div><!-- end question-tabs -->
            </div><!-- end col-lg-7 -->
            <div class="col-md-4">
                <div class="sidebar">

                <?php 
                    if(isset($_SESSION["Userid"])){
                ?>

                <div class="card card-item p-4">
                        <h3 class="fs-17 pb-3">Posts Suggested</h3>
                        <div class="divider"><span></span></div>
                        <div class="sidebar-questions pt-3">

                        <?php
                        $tagesArray =   array();
                        $favorites = $data->getData("SELECT * FROM favorites 
                        LEFT JOIN posts ON favorites.postId = posts.id 
                        WHERE favorites.userId = '".$_SESSION["Userid"]."'");
                                                    foreach($favorites as $favorites){
                                                        $tagesArray[] =  $favorites['tags'];
                                                    }

                              $in = implode(',', $tagesArray);

                              $in = explode(",",$in);

                            $posts = $data->getData("SELECT *, (SELECT COUNT(id) FROM votes WHERE postId = posts.id) AS `rank`, posts.id as postId FROM votes 
                            LEFT JOIN posts ON votes.postId = posts.id  GROUP by votes.postId ORDER BY `rank` DESC LIMIT 5");
                            foreach($posts as $posts){
                               
                               
                                $tagsArray = explode(",",$posts['tags']);

                                if (array_intersect($tagsArray, $in)) { 



                        ?>

                            <div class="media media-card media--card media--card-2">
                                <div class="media-body">
                                    <h5><a href="posts-details.php?8829988P=<?= $posts['postId'] ?>"><?= $posts['title'] ?></a></h5>
                                    <small class="meta">
                                        <span class="pr-1"><?= time_elapsed_string($posts['date']); ?></span>
                                        
                                    </small>
                                </div>
                            </div><!-- end media -->

                            <?php } } ?>
                      
                        </div><!-- end sidebar-questions -->
                    </div><!-- end card -->

                    <?php 
                    }
                ?>

                <div class="card card-item p-4">
                        <h3 class="fs-17 pb-3">Tranding Posts</h3>
                        <div class="divider"><span></span></div>
                        <div class="sidebar-questions pt-3">

                        <?php

                            $posts = $data->getData("SELECT *, (SELECT COUNT(id) FROM votes WHERE postId = posts.id) AS `rank`, posts.id as postId FROM votes 
                            LEFT JOIN posts ON votes.postId = posts.id  GROUP by votes.postId ORDER BY `rank` DESC LIMIT 5");
                            foreach($posts as $posts){


                        ?>

                            <div class="media media-card media--card media--card-2">
                                <div class="media-body">
                                    <h5><a href="posts-details.php?8829988P=<?= $posts['postId'] ?>"><?= $posts['title'] ?></a></h5>
                                    <small class="meta">
                                        <span class="pr-1"><?= time_elapsed_string($posts['date']); ?></span>
                                        
                                    </small>
                                </div>
                            </div><!-- end media -->

                            <?php } ?>
                      
                        </div><!-- end sidebar-questions -->
                    </div><!-- end card -->


                    <div class="card card-item p-4">
                        <h3 class="fs-17 pb-3">Trending Tags</h3>
                        <div class="divider"><span></span></div>
                        <div class="tags pt-4">
                            <?php

                              $tags = $data->getData("SELECT tags FROM posts ");

    
                              foreach($tags as $tags) {
                                $tagsingle =  explode(",",$tags['tags']); 
                                foreach($tags as $tags){   
                                    $tagitems3[] =  $tags;
                                    }
                                }
                                $tagitems3 =  implode(",",$tagitems3);
                                $tagsingle =  explode(",",$tagitems3); 

                                $tagsingle = (array_count_values($tagsingle));

                                arsort($tagsingle);

                                $tagsingle = array_slice($tagsingle, 0, 5);

                                foreach($tagsingle as $key => $tagsingle){
                           
                            ?>

                            <div class="tag-item">
                                <a href="posts.php?tags=<?= $key ?>" class="tag-link tag-link-md"><?= $key ?></a>
                                <span class="item-multiplier fs-13">
                                    <span>×</span>
                                    <span><?= $tagsingle ?></span>
                                </span>
                            </div><!-- end tag-item -->
                            <?php } ?>
                            
                            </div><!-- end collapse -->
         
                        </div>
                    </div><!-- end card -->
            
                </div><!-- end sidebar -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end question-area -->
<!-- ================================
         END QUESTION AREA
================================= -->

<!-- ================================
         START CTA AREA
================================= -->
<section class="get-started-area pt-80px pb-50px pattern-bg bg-gray">
    <div class="container">
        <div class="text-center">
            <h2 class="section-title">AskMyBrand Q&A communities are different. <br> Here's how</h2>
        </div>
        <div class="row pt-50px">
            <div class="col-lg-4 responsive-column-half">
                <div class="card card-item hover-y text-center">
                    <div class="card-body">
                        <img src="images\bubble.png" alt="bubble">
                        <h5 class="card-title pt-4 pb-2">Expert communities.</h5>
                        <p class="card-text">This is just a simple text made for this unique and awesome template, you can easily edit it as you want.</p>
                    </div><!-- end card-body -->
                </div><!-- end card -->
            </div><!-- end col-lg-4 -->
            <div class="col-lg-4 responsive-column-half">
                <div class="card card-item hover-y text-center">
                    <div class="card-body">
                        <img src="images\vote.png" alt="vote">
                        <h5 class="card-title pt-4 pb-2">The right answer. Right on top.</h5>
                        <p class="card-text">This is just a simple text made for this unique and awesome template, you can easily edit it as you want.</p>
                    </div><!-- end card-body -->
                </div><!-- end card -->
            </div><!-- end col-lg-4 -->
            <div class="col-lg-4 responsive-column-half">
                <div class="card card-item hover-y text-center">
                    <div class="card-body">
                        <img src="images\check.png" alt="check">
                        <h5 class="card-title pt-4 pb-2">Share knowledge. Earn trust.</h5>
                        <p class="card-text">This is just a simple text made for this unique and awesome template, you can easily edit it as you want.</p>
                    </div><!-- end card-body -->
                </div><!-- end card -->
            </div><!-- end col-lg-4 -->
        </div><!-- end row -->
    </div><!-- end container -->
</section>
<!-- ================================
         END CTA AREA
================================= -->

<?php
include 'includes/footer.php';
?>