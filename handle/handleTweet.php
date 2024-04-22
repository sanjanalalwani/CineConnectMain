<?php 
include '../core/init.php';
require_once '../core/classes/validation/Validator.php';
require_once '../core/classes/image.php';

use validation\Validator;

if (User::checkLogIn() === false) {
    header('location: index.php'); 
    exit(); // Make sure to exit after redirection
}

if (isset($_POST['tweet'])) {
    $status = User::checkInput($_POST['status']);
    $img = $_FILES['tweet_img'];
    
    // Check if status is empty or does not contain a hashtag
    if (empty($status) || !preg_match("/#(\w+)/", $status)) {
        $_SESSION['errors_tweet'] = ['Status must contain at least one "#" followed by alphanumeric characters.'];
        header('location: ../home.php'); 
        exit(); // Make sure to exit after redirection
    }

    $v = new Validator;
    $v->rules('status', $status, ['string', 'max:140']);
    if ($img['name'] != '') {
        $v->rules('image', $img, ['image']);
    }

    $errors = $v->errors;
    
    if (empty($errors)) { 
        if ($img['name'] != '') {
            $image = new Image($img, "tweet"); 
            $tweetImg = $image->new_name;
        } else {
            $tweetImg = null;
        }
        
        date_default_timezone_set("Africa/Cairo");
        $data = [
            'user_id' => $_SESSION['user_id'], 
            'post_on' => date("Y-m-d H:i:s"),
        ];
        $post_id = User::create('posts', $data);
        
        $data_tweet = [
            'post_id' => $post_id,
            'status' => $status, 
            'img' => $tweetImg
        ];
        User::create('tweets', $data_tweet);
        if ($img['name'] != '') {
            $image->upload();
        }
        
        preg_match_all("/@+([a-zA-Z0-9_]+)/i", $status, $mention);
        $user_id = $_SESSION['user_id'];
        foreach ($mention[1] as $men) {
            $id = User::getIdByUsername($men);
            if ($id != $user_id) {
                $data_notify = [
                    'notify_for' => $id,
                    'notify_from' => $user_id,
                    'target' => $post_id, 
                    'type' => 'mention',
                    'time' => date("Y-m-d H:i:s"),
                    'count' => '0', 
                    'status' => '0'
                ];
          
                Tweet::create('notifications', $data_notify);
            } 
        }
        
        preg_match_all("/#+([a-zA-Z0-9_]+)/i", $status, $hashtag);
        if (!empty($hashtag)) { 
            Tweet::addTrend($status);
        }
       
        header('location: ../home.php');
        exit(); // Make sure to exit after redirection
    } else {
        $_SESSION['errors_tweet'] = $errors;
        header('location: ../home.php');
        exit(); // Make sure to exit after redirection
    }   
} else {
    header('location: ../home.php');
    exit(); // Make sure to exit after redirection
}
?>
