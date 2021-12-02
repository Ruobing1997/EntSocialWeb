<?php

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


if(isset($_GET['8829988P'])){
    include 'auth/auth.php';

    if(isset($_POST['post_message'])){
        $sqlQuery = "INSERT INTO comments (userId, postId, comment, datetime) 
        VALUES ('".$_SESSION["Userid"]."', '".$_GET['8829988P']."', '".$_POST['message']."', now() )";
     
        $isUpdated = $data->setData($sqlQuery);	
    }
    if(isset($_SESSION["Userid"])){

    if(isset($_POST['vote'])){
        $sqlQuery = "INSERT INTO votes (userId, postId, vote) 
        VALUES ('".$_SESSION["Userid"]."', '".$_GET['8829988P']."', '1' )";
     
        $isUpdated = $data->setData($sqlQuery);	
    }

    // if(isset($_POST['devote'])){
    //     $sqlQuery = "INSERT INTO votes (userId, postId, vote) 
    //     VALUES ('".$_SESSION["Userid"]."', '".$_GET['8829988P']."', '1' )";
     
    //     $isUpdated = $data->setData($sqlQuery);	
    // }


    if(isset($_POST['devote'])){
        $data->setData("DELETE FROM votes WHERE userId = '".$_SESSION["Userid"]."' AND postId = '".$_GET['8829988P']."'");
      }


      if(isset($_POST['favorite'])){
        $sqlQuery = "INSERT INTO favorites (userId, postId) 
        VALUES ('".$_SESSION["Userid"]."', '".$_GET['8829988P']."')";
     
        $isUpdated = $data->setData($sqlQuery);	
    }


    if(isset($_POST['defavorite'])){
        $data->setData("DELETE FROM favorites WHERE userId = '".$_SESSION["Userid"]."' AND postId = '".$_GET['8829988P']."'");
      }

    }
    
    $posts = $data->getData("SELECT * FROM posts WHERE id = '".$_GET['8829988P']."' ");
    
    if($posts == NULL) {
        header("Location: index.php");
    } else {
    
    foreach ($posts as $posts) 
include 'includes/header.php';
?>
<!--======================================
        START HERO AREA
======================================-->
<section class="hero-area pattern-bg-2 bg-white shadow-sm overflow-hidden pt-40px pb-40px">
    <span class="stroke-shape stroke-shape-1"></span>
    <span class="stroke-shape stroke-shape-2"></span>
    <span class="stroke-shape stroke-shape-3"></span>
    <span class="stroke-shape stroke-shape-4"></span>
    <span class="stroke-shape stroke-shape-5"></span>
    <span class="stroke-shape stroke-shape-6"></span>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="hero-content">
                    <h2 class="section-title pb-2 fs-24 lh-34">Find the best answer to your technical question, <br>
                        help others answer theirs
                    </h2>
                    <p class="lh-26">If you are going to use a passage of Lorem Ipsum, you need to be sure there
                        <br> isn't anything embarrassing hidden in the middle of text.
                    </p>
                    <ul class="generic-list-item pt-3">
                        <li><span class="icon-element icon-element-xs shadow-sm d-inline-block mr-2"><svg
                                    xmlns="http://www.w3.org/2000/svg" height="20px" viewbox="0 0 24 24" width="20px"
                                    fill="#6c727c">
                                    <path d="M0 0h24v24H0V0z" fill="none"></path>
                                    <path
                                        d="M11 18h2v-2h-2v2zm1-16C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm0-14c-2.21 0-4 1.79-4 4h2c0-1.1.9-2 2-2s2 .9 2 2c0 2-3 1.75-3 5h2c0-2.25 3-2.5 3-5 0-2.21-1.79-4-4-4z">
                                    </path>
                                </svg></span> Anybody can posts a question</li>
                        <li><span class="icon-element icon-element-xs shadow-sm d-inline-block mr-2"><svg
                                    xmlns="http://www.w3.org/2000/svg" height="20px" viewbox="0 0 24 24" width="20px"
                                    fill="#6c727c">
                                    <path d="M0 0h24v24H0V0z" fill="none"></path>
                                    <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"></path>
                                </svg></span> Anybody can answer</li>
                        <li><span class="icon-element icon-element-xs shadow-sm d-inline-block mr-2"><svg
                                    xmlns="http://www.w3.org/2000/svg" height="20px" viewbox="0 0 320 512" width="20px">
                                    <path fill="#6c727c"
                                        d="M41 288h238c21.4 0 32.1 25.9 17 41L177 448c-9.4 9.4-24.6 9.4-33.9 0L24 329c-15.1-15.1-4.4-41 17-41zm255-105L177 64c-9.4-9.4-24.6-9.4-33.9 0L24 183c-15.1 15.1-4.4 41 17 41h238c21.4 0 32.1-25.9 17-41z">
                                    </path>
                                </svg></span> The best answers are voted up and rise to the top</li>
                    </ul>
                </div><!-- end hero-content -->
            </div><!-- end col-lg-9 -->
         
        </div><!-- end row -->
    </div><!-- end container -->
</section>
<!--======================================
        END HERO AREA
======================================-->

<!-- ================================
         START QUESTION AREA
================================= -->
<section class="question-area pt-40px pb-40px">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="question-main-bar mb-50px">
                    <div class="question-highlight">
                        <div class="media media-card shadow-none rounded-0 mb-0 bg-transparent p-0">
                            <div class="media-body">
                                <h5 class="fs-20"><a href="question-details.php"><?= $posts['title'] ?></a></h5>
                                <div class="meta d-flex flex-wrap align-items-center fs-13 lh-20 py-1">
                                    <div class="pr-3">
                                        <span>postsed</span>
                                        <span class="text-black"><?= time_elapsed_string($posts['date']); ?></span>
                                    </div>

                                </div>
                                <div class="tags">
                                    <?php $tags =  explode(",",$posts['tags']); 
                                                                    foreach($tags as $tags){
                                                                   
                                                                ?>
                                    <a href="posts.php?tags=<?= $key ?>" class="tag-link"><?= $tags; ?></a>

                                    <?php 
                                                                    }
                                                                ?>
                                </div>
                            </div>
                        </div><!-- end media -->
                    </div><!-- end question-highlight -->
                    <div class="question d-flex">
                    <form <?php if(isset($_SESSION["Userid"])){ ?> action=""  method="post" <?php }else{ ?> action="login.php" method="post"<?php } ?> >

                        <div class="votes votes-styled w-auto">
                            <div id="vote" class="upvotejs">

                            <?php     $votes = $data->getData("SELECT * FROM votes WHERE postId = '".$_GET['8829988P']."' ");
                                        if($votes == NULL){
                             ?>

                                <button type="submit" name="vote" data-toggle="tooltip" data-placement="right" style=" border: none; background: Transparent;"
                                    title="This post is useful"><i class="fad fa-thumbs-up fa-1x"></i></button>

                                    <?php } else { ?>

                                    <button type="submit" name="devote" data-toggle="tooltip" data-placement="right" style=" border: none; background: Transparent;"
                                    title="This post is not useful"><i class="fa fa-thumbs-up fa-1x"></i></button>

                                    <?php } ?>


                                <span class="count" >

                                <?php echo  $votes = $data->getNumRows("SELECT * FROM votes WHERE postId = '".$_GET['8829988P']."' "); ?>
                                </span>
<!--                         
                                <a class="star" data-toggle="tooltip" data-placement="right"
                                    title="Bookmark this question."></a> -->
                            </div>
                        </div><!-- end votes -->

                        <div class="votes votes-styled w-auto">
                            <div id="vote" class="upvotejs">

                            <?php     $favorites = $data->getData("SELECT * FROM favorites WHERE postId = '".$_GET['8829988P']."' ");
                                        if($favorites == NULL){
                             ?>

                                <button type="submit" name="favorite" data-toggle="tooltip" data-placement="right" style=" border: none; background: Transparent;"
                                title="Favorite"><i class="far fa-heart"></i></button>

                                    <?php } else { ?>

                                    <button type="submit" name="defavorite" data-toggle="tooltip" data-placement="right" style=" border: none; background: Transparent;"
                                    title="Not favorite"><i class="fas fa-heart"></i></button>

                                    <?php } ?>


                            </div>
                        </div><!-- end votes -->
                        </form>
                        <div class="question-post-body-wrap flex-grow-1">
                            <div class="question-post-body">

                                <p><?= $posts['details'] ?></p>
                                <?php
                                if($posts['file'] != NULL ){
                                    ?>
                                <a href="attachments/<?= $posts['file'] ?>">See Attachment</a>
                                <?php
                                }
                                ?>
                            </div><!-- end question-post-body -->
                            <div class="question-post-user-action">
                                <div class="post-menu">

                                    <span class="btn">Comments</span>

                                </div><!-- end post-menu -->

                                <?php

   
                                $comments = $data->getData("SELECT * FROM comments   
                                LEFT JOIN users ON comments.userId = users.id  
                                WHERE comments.postId = '".$_GET['8829988P']."' ");
                                
                                foreach ($comments as $comments) {

                                ?>  



                                <div class="media media-card user-media align-items-center">
                                    <a href="#" class="media-img d-block">
                                        <img src="userProfiles\<?= $comments['profilePhoto'] ?>" alt="avatar">
                                    </a>
                                    <div class="media-body d-flex flex-wrap align-items-center justify-content-between">
                                        <div>
                                            <h5 class="pb-1"><a href="#"><?= $comments['fullName'] ?></a></h5>
                                            <div class="stats fs-12 d-flex align-items-center lh-18">
                                                <span class="text-black pr-2">User</span>
                                            </div>
                                        </div>
                                        <small class="meta d-block text-right">
                                            <span class="text-black d-block lh-18">postsed</span>
                                            <span class="d-block lh-18 fs-12"><?= time_elapsed_string($comments['datetime']); ?></span>
                                        </small>
                                    </div>

                                </div><!-- end media -->

                                <div class="comment-body">
                                    <span class="comment-copy"><?= $comments['comment'] ?></span>
                                </div>

                                <?php } ?>




                            </div><!-- end question-post-user-action -->
                            <div class="comments-wrap">

                                <div class="comment-form">
                                    <div class="comment-link-wrap text-center">
                                        <a class="collapse-btn comment-link" data-toggle="collapse"
                                            href="#addCommentCollapse" role="button" aria-expanded="false"
                                            aria-controls="addCommentCollapse"
                                            title="Use comments to posts for more information or suggest improvements. Avoid answering questions in comments.">Add
                                            a comment</a>
                                    </div>
                                    <div class="collapse border-top border-top-gray mt-2 pt-3" id="addCommentCollapse">
                                        <form action="" method="post" class="row pb-3">
                                            <div class="col-lg-12">
                                                <h4 class="fs-16 pb-2">Leave a Comment</h4>
                                                <div class="divider mb-2"><span></span></div>
                                            </div><!-- end col-lg-12 -->

                                            <div class="col-lg-12">
                                                <div class="input-box">
                                                    <label class="fs-13 text-black lh-20">Message</label>
                                                    <div class="form-group">
                                                        <textarea
                                                            class="form-control form--control form-control-sm fs-13"
                                                            name="message" rows="5"
                                                            placeholder="Your comment here..."></textarea>

                                                    </div>
                                                </div>
                                            </div><!-- end col-lg-12 -->
                                            <div class="col-lg-12">
                                                <span style="display: none;" class="text-danger" id="lgoinPleaseText">Please login</span>

                                                <?php
                                                if(isset($_SESSION["UserName"])){
                                                ?>

                                                <div
                                                    class="input-box d-flex flex-wrap align-items-center justify-content-between">
                                                    <button
                                                        class="btn theme-btn theme-btn-sm theme-btn-outline theme-btn-outline-gray"
                                                        type="submit" name="post_message">Post Comment</button>
                                                </div>
                                                <?php } ?>
                                            </div><!-- end col-lg-12 -->
                                        </form>


                                        <?php
                                               if(!isset($_SESSION["UserName"])){
                                                ?>

                                        <div
                                            class="input-box d-flex flex-wrap align-items-center justify-content-between">
                                            <a href="login.php"
                                                class="btn theme-btn theme-btn-sm theme-btn-outline theme-btn-outline-gray"
                                                >Post Comment</a>
                                        </div>
                                        <?php } ?>
                                    </div><!-- end collapse -->
                                </div>
                            </div><!-- end comments-wrap -->
                        </div><!-- end question-post-body-wrap -->
                    </div><!-- end question -->

                </div><!-- end question-main-bar -->
            </div><!-- end col-lg-9 -->

            <div class="col-lg-3">
                <div class="sidebar">

                <div class="card card-item p-4">
                        <h3 class="fs-17 pb-3">Tranding Post</h3>
                        <div class="divider"><span></span></div>
                        <div class="sidebar-questions pt-3">

                        <?php

                            $posts = $data->getData("SELECT *, (SELECT COUNT(id) AS count FROM votes WHERE postId = posts.id) AS rank, posts.id as postId FROM votes 
                            LEFT JOIN posts
                            ON votes.postId = posts.id ORDER BY rank desc LIMIT 5");
                            foreach($posts as $posts){


                        ?>

                            <div class="media media-card media--card media--card-2">
                                <div class="media-body">
                                    <h5><a href="question-details.php?8829988P=<?= $posts['postId'] ?>"><?= $posts['title'] ?></a></h5>
                                    <small class="meta">
                                        <span class="pr-1"><?= time_elapsed_string($posts['date']); ?></span>
                                        
                                    </small>
                                </div>
                            </div><!-- end media -->

                            <?php } ?>
                      
                        </div><!-- end sidebar-questions -->
                    </div><!-- end card -->


                    <div class="card card-item p-4">
                        <h3 class="fs-17 pb-3">Related Posts</h3>
                        <div class="divider"><span></span></div>
                        <div class="sidebar-questions pt-3">

                        <?php

                    
                            $queried = $data->dbConnect->con->real_escape_string($posts['title']);

                            $keys = explode(" ",$queried);

                            $sql = "SELECT * FROM posts WHERE title LIKE '%$queried%' ";

                            foreach($keys as $k){
                                if (in_array($k, array('can','could','may','might','will','would','shall','should','must','ought to','i','am','me','mine','me','he','is','his','she','her','thay','them','there','than','was','ware','be','been','have','has','had','do','does','did'))) {
                                    continue;
                                }
                                $sql .= " OR title LIKE '%$k%' ";
                            }

                            $posts = $data->getData($sql);


                            // $result = mysql_query($sql);

                            foreach($posts as $posts){


                        ?>



                            <div class="media media-card media--card media--card-2">
                                <div class="media-body">
                                    <h5><a href="question-details.php?8829988P=<?= $posts['id'] ?>"><?= $posts['title'] ?></a></h5>
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
                                $tagsingle =  explode(",",$posts['tags']); 
                                foreach($tags as $tags){   
                                    $tagitems[] =  $tags;
                                    }
                                }
                                $tagitems =  implode(",",$tagitems);
                                $tagsingle =  explode(",",$tagitems); 

                                $tagsingle = (array_count_values($tagsingle));

                                arsort($tagsingle);

                                $tagsingle = array_slice($tagsingle, 0, 5);

                                foreach($tagsingle as $key => $tagsingle){
                           
                            ?>

                            <div class="tag-item">
                                <a href="#" class="tag-link tag-link-md"><?= $key ?></a>
                                <span class="item-multiplier fs-13">
                                    <span>×</span>
                                    <span><?= $tagsingle ?></span>
                                </span>
                            </div><!-- end tag-item -->
                            <?php } ?>
                            
                            </div><!-- end collapse -->
         
                        </div>
                    </div><!-- end card -->
                    <div class="ad-card">
                        <h4 class="text-gray text-uppercase fs-13 pb-3 text-center">Advertisements</h4>
                        <div class="ad-banner mb-4 mx-auto">
                            <span class="ad-text">290x500</span>
                        </div>
                    </div><!-- end ad-card -->
                </div><!-- end sidebar -->
            </div><!-- end col-lg-3 -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end question-area -->
<!-- ================================
         END QUESTION AREA
================================= -->


<?php
include 'includes/footer.php';
    }

} else {
    header("Location: index.php");
}

?>