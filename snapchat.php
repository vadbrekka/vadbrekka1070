<?php
require_once("src/snapchat.php");

$username = 'SNAPCHAT_USERNAME';
$password = 'SNAPCHAT_PASSWORD';
$snapchat = new Snapchat($username, $password); //create new instance of class Snapchat
$snaps = $snapchat->getSnaps(); //get feed
$snaps = json_decode(json_encode($snaps), true); //turn into php array
$i = 0;

foreach($snaps as $item) {
    if($item['status'] == 1) { //if unopened
      if($item['sender'] != $username) { //if not sent from yourself
        $snapchat->addFriend($item['sender']); //add sender as friend if not already
        if($item['media_type'] == 0) { //if still image
            $data = $snapchat->getMedia($item['id']); //get received snap
            file_put_contents('media/temp.jpg', $data); //create temp file with the received snap
            $id = $snapchat->upload(Snapchat::MEDIA_IMAGE, file_get_contents('media/temp.jpg')); //upload the temp to story
            $snapchat->setStory($id, Snapchat::MEDIA_IMAGE, 5); //set story 3 seconds long
            unlink("media/temp.jpg"); //delete temp
        } elseif($item['media_type'] == 1) { //if moving video
            $data = $snapchat->getMedia($item['id']); //get received snap
            file_put_contents('media/temp.mov', $data); //create temp file with the received sna
            $id = $snapchat->upload(Snapchat::MEDIA_VIDEO, file_get_contents('media/temp.mov')); //upload the temp to story
            $snapchat->setStory($id, Snapchat::MEDIA_VIDEO, 5); //set story
            unlink("media/temp.mov"); //delete temp
        }
        $snapchat->markSnapViewed($item['id']); //mark as viewed, just in case
        $id = $snapchat->upload(Snapchat::MEDIA_IMAGE, file_get_contents('media/thanks.jpg')); //send verification snap
        $snapchat->send($id, array($item['sender']), 10); //10 seconds long
        $i++; //keep going
      }
    }
}
$snapchat->clearFeed(); //clear feed (will become VERY long VERY soon and break program)
?>


