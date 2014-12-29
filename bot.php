<?php
define("IN_STORYBOT", 1);
require_once("src/snapchat.php");
require_once("config/config.php");

$snapchat = new Snapchat($config['username'], $config['password']); //create new instance of class Snapchat
$snaps = $snapchat->getSnaps(); //get feed
$snaps = json_decode(json_encode($snaps), true); //turn into php array
$i = 0;

foreach($snaps as $item) {
    if($item['status'] == 1) { //if unopened
      if($item['sender'] != $config['username']) { //if not sent from yourself
        if(!is_banned($item['sender'])) {
            $snapchat->addFriend($item['sender']); //add sender as friend if not already
            if($item['media_type'] == 0) { //if still image
                if($config['picturesallowed']) {
                    $data = $snapchat->getMedia($item['id']); //get received snap
                    if ($data != "") {
                        $filename = time().'__'.$item['sender'].'.jpg';
                        file_put_contents('media/temp/'.$filename, $data); //create temp file with the received snap
                        if($config['moderation'] == false) {
                            postImageStory($filename, mod_id(), $config['username'], $config['password']);
                        }
                    }

                }   
            } elseif($item['media_type'] == 1) { //if moving video
                if($config['videosallowed']) {
                    $data = $snapchat->getMedia($item['id']); //get received snap
                    file_put_contents('media/temp.mov', $data); //create temp file with the received sna
                    $id = $snapchat->upload(Snapchat::MEDIA_VIDEO, file_get_contents('media/temp.mov')); //upload the temp to story
                    $snapchat->setStory($id, Snapchat::MEDIA_VIDEO, $config['videotime']); //set story
                    unlink("media/temp.mov"); //delete temp
                }
            }
            $snapchat->markSnapViewed($item['id']); //mark as viewed, just in case
            if($config['send_verify_snap']) {
                $id = $snapchat->upload(Snapchat::MEDIA_IMAGE, file_get_contents('media/thanks.jpg')); //send verification snap
                $snapchat->send($id, array($item['sender']), 10); //10 seconds long
            }
            $i++; //keep going
        }
      }
    }
}
$snapchat->clearFeed(); //clear feed (will become VERY long VERY soon and break program)
?>
