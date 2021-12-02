<?php


$tagitems1 = array();
$tagitems2 = array();



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
$data->UserLoginStatus();

include 'includes/header.php';

    $user = $data->getData("SELECT * FROM users WHERE id = '".$_SESSION["Userid"]."' LIMIT 1");
    foreach ($user as $user) 
?>
<!--======================================
        START HERO AREA
======================================-->
<style>
                .brands:hover {
    background-color: rgba(45, 134, 235, .2);
    color: #2d86eb
}
</style>


<section class="hero-area pattern-bg-2 bg-white shadow-sm overflow-hidden pt-60px">
    <span class="stroke-shape stroke-shape-1"></span>
    <span class="stroke-shape stroke-shape-2"></span>
    <span class="stroke-shape stroke-shape-3"></span>
    <div class="container">
    <?php 
                if(!empty($message)){
                    ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $message; ?>
                      </div>
                    <?php
                }
                ?>
        <div class="row">
            <div class="col-md-8">
                <div class="hero-content">
                    <div class="media media-card align-items-center shadow-none p-0 mb-0 rounded-0">
                        <a href="user-profile.html" class="media-img media--img d-block">
                            <?php if($user['profilePhoto'] != ''){
                                ?>
                                <img src="userProfiles\<?php echo $user['profilePhoto']; ?>" alt="avatar">
                                <?php
                            }else{
                                ?>
                                <img src="userProfiles\img_avatar.png" alt="avatar">
                                <?php
                            } ?>
                        </a>
                        <div class="media-body">
                            <h5><a href="user-profile.html"><?php echo $user['fullName']; ?></a></h5>
                            <small class="meta d-block lh-20 pb-2">
                                <span><?php echo $user['location']; ?>, member since <?php echo $data->time_elapsed_string($user['datetime']); ?></span>
                            </small>
                           
                        </div>
                    </div><!-- end media -->
                </div><!-- end hero-content -->
            </div>

            <div class="col-lg-4">
             <div class="hero-btn-box text-right py-3">
                    <a href="post.php" class="btn theme-btn theme-btn-sm mr-2" >
                         <i class="fad fa-plus-square"></i> Add Post
                        </a>
                   <a href="setting.php" class="btn theme-btn theme-btn-outline theme-btn-sm  theme-btn-outline-gray"><i class="la la-gear mr-1"></i> Edit Profile</a>
                </div>
            </div>

            <div class="col-lg-12">
                <ul class="nav nav-tabs generic-tabs generic--tabs generic--tabs-2 mt-4" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link"  href="user-profile.php">Profile</a>
                    </li>
                </ul>
            </div><!-- end col-lg-4 -->
        </div><!-- end row -->
    </div><!-- end container -->
</section>
<!--======================================
        END HERO AREA
======================================-->

<!-- ================================
         START USER DETAILS AREA
================================= -->
<section class="user-details-area pt-30px pb-60px">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="user-profile" role="tabpanel" aria-labelledby="user-profile-tab">
                    <div class="user-panel-main-bar">
                        <div class="user-panel mb-30px">
                                <div class="posts-tabs mb-50px">
                  
                                    <div class="tab-content pt-40px" id="myTabContent">
                                        <div class="tab-pane fade show active" id="postss" role="tabpanel"
                                            aria-labelledby="postss-tab">
                                            <div class="posts-main-bar">
                                             


                                                <?php 

        // find out how many rows are in the table 
                   
        $numrows = $data->getNumRows("SELECT * FROM favorites WHERE userId = '".$_SESSION["Userid"]."'"); 

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
        (SELECT COUNT(id) AS comments_count FROM comments WHERE postId = posts.id) AS comments_rank, posts.id as postId
        FROM votes 
        LEFT JOIN posts
        ON votes.postId = posts.id
        LEFT JOIN favorites
        ON posts.id = favorites.postId
        WHERE favorites.userId = '".$_SESSION["Userid"]."'  ORDER BY rank desc LIMIT 10");
    


        foreach($posts as $row) {
        

    
    
    
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
                                            </div><!-- end posts-main-bar -->
                                      
                                    </div><!-- end tab-content -->
                                </div><!-- end posts-tabs -->
                            </div><!-- end user-panel -->
                 
                        </div><!-- end user-panel-main-bar -->
                    </div><!-- end tab-pane -->
                    </div><!-- end tab-pane -->
                   
                </div>
            </div><!-- end col-lg-9 -->
   
            </div><!-- end col-lg-3 -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end user-details-area -->
<!-- ================================
         END USER DETAILS AREA
================================= -->



<?php
include 'includes/footer.php';
?>