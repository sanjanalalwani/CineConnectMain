<?php

   include 'core/init.php';
  
   $user_id = $_SESSION['user_id'];

   $user = User::getData($user_id);
   
   if (User::checkLogIn() === false) 
   header('location: index.php');


   $tweets = Tweet::tweets($user_id);
   $who_users = Follow::whoToFollow($user_id);
   $notify_count = User::CountNotification($user_id);
 
?>
    

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | CineConnect</title>
    
    <link rel="shortcut icon" type="image/png" href="assets/images/cineconnect.png"> 
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/all.min.css">
        <link rel="stylesheet" href="assets/css/home_style.css?v=<?php echo time(); ?>">
    
   
</head>
<body>



  <!-- This is a modal for welcome the new signup account! -->

  <script src="assets/js/jquery-3.5.1.min.js"></script>
     
    <?php  if (isset($_SESSION['welcome'])) { ?>
      <script>
       $(document).ready(function(){
        // Open modal on page load
        $("#welcome").modal('show');
      
 
       });
      </script>
    

      <!-- Modal -->
<div class="modal fade" id="welcome" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div  class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="">
        <div class="text-center">
         <span  class="modal-title font-weight-bold text-center" id="exampleModalLongTitle">
          <span style="font-size: 20px;">Welcome <span style="color:#207ce5"><?php echo $user->name; ?></span>  </span>  
         </span>
        </div>
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> -->
      </div>
      <div class="modal-body">
        <div class="text-center">
       
        <h4 style="font-weight: 600; " >Signup Successfuly!</h4>
 
        </div>
        <p>Welcom to CineConnect made by <span style="font-weight: 700;">Sanjana Lalwani , Akhilesh Kursija and Anvita Kumar</span></p>
        <p>This website helps you watch movies and communicate with your friends for having a conversation on the movies you watched.
        </p>
        <p>
          <a style="color:#207ce5;" href="amin"></a> 
           </p>
      </div>
    </div>
  </div>
</div>

      <?php unset($_SESSION['welcome']); } ?>

      <!-- End welcome -->

    <div id="mine">
 
    <div class="wrapper-left">
        <div class="sidebar-left">
          <div class="grid-sidebar" style="margin-top: 12px">
            <div class="icon-sidebar-align">
              <!-- <img src="assets/images/logomain.png" alt="" height="30px" width="30px" /> -->
            </div>
          </div>

          <a href="home.php">
          <div class="grid-sidebar bg-active" style="margin-top: 12px">
            <div class="icon-sidebar-align">
              <img src="assets/images/logomain.png" alt="" height="26.25px" width="26.25px" />
            </div>
            <div class="wrapper-left-elements">
              <a class="wrapper-left-active" href="home.php" style="margin-top: 4px;"><strong>Home</strong></a>
            </div>
          </div>
          </a>
  
           <a href="notification.php">
          <div class="grid-sidebar">
            <div class="icon-sidebar-align position-relative">
                <?php if ($notify_count > 0) { ?>
              <i class="notify-count"><?php echo $notify_count; ?></i> 
              <?php } ?>
              <img
                src="https://i.ibb.co/Gsr7qyX/notification.png"
                alt=""
                height="26.25px"
                width="26.25px"
              />
            </div>
  
            <div class="wrapper-left-elements">
              <a href="notification.php" style="margin-top: 4px"><strong>Notification</strong></a>
            </div>
          </div>
          </a>
        
            <a href="<?php echo BASE_URL . $user->username; ?>">
          <div class="grid-sidebar">
            <div class="icon-sidebar-align">
              <img src="https://i.ibb.co/znTXjv6/perfil.png" alt="" height="26.25px" width="26.25px" />
            </div>
  
            <div class="wrapper-left-elements">
              <!-- <a href="/twitter/<?php echo $user->username; ?>"  style="margin-top: 4px"><strong>Profile</strong></a> -->
              <a  href="<?php echo BASE_URL . $user->username; ?>"  style="margin-top: 4px"><strong>Profile</strong></a>
            
            </div>
          </div>
          </a>
          <a href="<?php echo BASE_URL . "account.php"; ?>">
          <div class="grid-sidebar ">
            <div class="icon-sidebar-align">
              <img src="https://i.ibb.co/znTXjv6/perfil.png" alt="" height="26.25px" width="26.25px" />
            </div>
  
            <div class="wrapper-left-elements">
              <a href="<?php echo BASE_URL . "account.php"; ?>" style="margin-top: 4px"><strong>Settings</strong></a>
            </div>
          
           
            
          </div>
          <div class="grid-sidebar ">
          <div class="icon-sidebar-align">
              <img src="https://png.pngtree.com/element_our/png/20181113/clapperboard-film-logo-icon-design-template-vector-isolated-png_236642.jpg" alt="" height="26.25px" width="26.25px" />
            </div>
            <div class="wrapper-left-elements">
              <a href="<?php echo BASE_URL . "movie.html"; ?>" style="margin-top: 4px"><strong>Watch Movie</strong></a>
            </div>
                </div>
          </a>
          <a href="includes/logout.php">
          <div class="grid-sidebar">
            <div class="icon-sidebar-align">
            <i style="font-size: 26px; color:red" class="fas fa-sign-out-alt"></i>
            </div>
  
            <div class="wrapper-left-elements">
    <a style="color:red" href="includes/logout.php" id="logoutBtn" style="margin-top: 4px"><strong>Logout</strong></a>
</div>
          </div>
          </a>
          <button class="button-twittear">
            <strong>Post</strong>
          </button>
  
          <div class="box-user">
            <div class="grid-user">
              <div>
                <img
                  src="assets/images/users/<?php echo $user->img ?>"
                  alt="user"
                  class="img-user"
                />
              </div>
              <div>
                <p class="name"><strong><?php if($user->name !== null) {
                echo $user->name; } ?></strong></p>
                <p class="username">@<?php echo $user->username; ?></p>
              </div>
              <div class="mt-arrow">
                <img
                  src="https://i.ibb.co/mRLLwdW/arrow-down.png"
                  alt=""
                  height="18.75px"
                  width="18.75px"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
          

      <div class="grid-posts">
        <div class="border-right">
          <div class="grid-toolbar-center">
            <div class="center-input-search">
              <div class="input-group-login" id="whathappen">
                
                <div class="container">
                  <div class="part-1">
                    <div class="header">
                      <div class="home">
                        <h2>Home</h2>
                      </div>
                      <!-- <div class="icon">
                        <button type="button" name="button">+</button>
                      </div> -->
                    </div>
            
                    <div class="text">
                      <form class="" action="handle/handleTweet.php" method="post" enctype="multipart/form-data" >
                        <div class="inner">
            
                            <img src="assets/images/users/<?php echo $user->img ?>" alt="profile photo">
                        
                          <label>
            
                            <textarea class="text-whathappen" name="status" rows="8" cols="80" placeholder="Uncover cinematic treasures with '#' for fresh insights!"></textarea>
                        
                        </label>
                        </div> 
                            
                         <!-- tmp image upload place -->
                        <div class="position-relative upload-photo"> 
                          <img class="img-upload-tmp" src="assets/images/tweets/tweet-60666d6b426a1.jpg" alt="">
                          <div class="icon-bg">
                          <i id="#upload-delete-tmp" class="fas fa-times position-absolute upload-delete"></i>  

                          </div>
                        </div>


                        <div class="bottom"> 
                          
                          <div class="bottom-container">
                              
                            
                              
                           
                            <label for="tweet_img" class="ml-3 mb-2 uni">

                              <i class="fa fa-image item1-pair"></i>
                            </label>
                            <input class="tweet_img" id="tweet_img" type="file" name="tweet_img">    
                                
                          </div>
                          <div class="hash-box">
                        
                              <ul style="margin-bottom: 0;">


                              </ul>
                          
                          </div>
                          <?php if (isset($_SESSION['errors_tweet'])) { 
                            
                            foreach($_SESSION['errors_tweet'] as $t) {?>
                            
                          <div class="alert alert-danger">
                          <span class="item2-pair"> <?php echo $t; ?> </span>
                          </div>
                         
                         <?php } } unset($_SESSION['errors_tweet']); ?>
                          <div>
                         
                            <span class="bioCount" id="count">140</span>
                            <input id="tweet-input" type="submit" name="tweet" value="Post" class="submit"
                            >
                          </div>
                      </div>
                      </form>
                    </div>
                  </div>
                  <div class="part-2">
            
                  </div>
            
                </div>
                
                
              </div>
            </div>
            <!-- <div class="mt-icon-settings">
              <img src="https://i.ibb.co/W5T9ycN/settings.png" alt="" />
            </div> -->
          </div>
          <div class="box-fixed" id="box-fixed"></div>
            
          <?php  include 'includes/tweets.php'; ?>

        </div>


        <div class="wrapper-right">
            <div style="width: 90%;" class="container">

          <div class="input-group py-2 m-auto pr-5 position-relative">

          <i id="icon-search" class="fas fa-search tryy"></i>
          <input type="text" class="form-control search-input"  placeholder="Search CineConnect">
          <div class="search-result">


          </div>
          </div>
          </div>


       

            
          <div class="box-share">
            <p class="txt-share"><strong>Who to follow</strong></p>
            <?php 
            foreach($who_users as $user) { 
              //  $u = User::getData($user->user_id);
               $user_follow = Follow::isUserFollow($user_id , $user->id) ;
               ?>
          <div class="grid-share">
          <a style="position: relative; z-index:5; color:black" href="<?php echo $user->username;  ?>">
                      <img
                        src="assets/images/users/<?php echo $user->img; ?>"
                        alt=""
                        class="img-share"
                      />
                    </a>
                    <div>
                      <p>
                      <a style="position: relative; z-index:5; color:black" href="<?php echo $user->username;  ?>">  
                      <strong><?php echo $user->name; ?></strong>
                      </a>
                    </p>
                      <p class="username">@<?php echo $user->username; ?>
                      <?php if (Follow::FollowsYou($user->id , $user_id)) { ?>
                  <span class="ml-1 follows-you">Follows You</span></p>
                  <?php } ?></p>
                    </div>
                    <div>
                      <button class="follow-btn follow-btn-m 
                      <?= $user_follow ? 'following' : 'follow' ?>"
                      data-follow="<?php echo $user->id; ?>"
                      data-user="<?php echo $user_id; ?>"
                      data-profile="<?php echo $u_id; ?>"
                      style="font-weight: 700;">
                      <?php if($user_follow) { ?>
                        Following 
                      <?php } else {  ?>  
                          Follow
                        <?php }  ?> 
                      </button>
                    </div>
                  </div>

                  <?php }?>
         
          
          </div>
  
  
        </div>
      </div>
      </div> 
      <!-- Modal -->
<div class="modal fade" id="welcomeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <h5 class="modal-title font-weight-bold" id="exampleModalLongTitle">Welcome to CineConnect</h5>
                </div>
                <p>
                    Welcome to CineConnect! This website helps you watch movies and communicate with your friends to have conversations about the movies you watched or are about to watch.
                </p>
                <p>
                    Watch Movie or Communicate?
                </p>
                <!-- Buttons  -->
                <div class="text-center">
                    <a href="movie.html" class="btn btn-primary">Watch Movie</a>
                    <a href="home.php" class="btn btn-primary">Communicate</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- JavaScript for managing modal visibility and local storage -->
<script>
// Function to show the welcome modal only once
$(document).ready(function(){
    // Check if the modal has been shown before
    if (!localStorage.getItem('modalShown')) {
        // Show the modal
        $('#welcomeModal').modal('show');
        // Set a flag in local storage to indicate that the modal has been shown
        localStorage.setItem('modalShown', 'true');
    }
    
    // Add event listener to the logout button
    document.getElementById('logoutBtn').addEventListener('click', function() {
        // Remove the item from local storage
        localStorage.removeItem('modalShown');
    });
});
</script>

      <script>
    document.getElementById('postForm').addEventListener('submit', function(event) {
        var postContent = document.getElementById('status').value;
        if (!/#\w+/.test(postContent)) {
            alert('Your post must contain at least one "#" followed by alphanumeric characters.');
            event.preventDefault(); // Prevent form submission
        }
    });
</script>
      <script src="assets/js/search.js"></script>
          <script src="assets/js/photo.js?v=<?php echo time(); ?>"></script>
          <script type="text/javascript" src="assets/js/hashtag.js"></script>
          <script type="text/javascript" src="assets/js/like.js"></script>
          <script type="text/javascript" src="assets/js/comment.js?v=<?php echo time(); ?>"></script>
          <script type="text/javascript" src="assets/js/retweet.js?v=<?php echo time(); ?>"></script>
          <script type="text/javascript" src="assets/js/follow.js?v=<?php echo time(); ?>"></script>
      <script src="https://kit.fontawesome.com/38e12cc51b.js" crossorigin="anonymous"></script>
      <!-- <script src="assets/js/jquery-3.4.1.slim.min.js"></script> -->
      <script src="assets/js/jquery-3.5.1.min.js"></script>

        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        
</body>
</html> 