<div class="messenger-users">
  <div class="user-container" onclick="Interface.loadModel('profile', '<?php echo $getMessagesUsers['to_player'];?>')">
    <div class="user-picture">
      <img src="<?php echo User::getUserPicture($getMessagesUsers['to_player']);?>">
    </div>
    <h3><?php echo User::getUserUsername($getMessagesUsers['to_player']);?></h3>
    <h3><?php echo '('.$getMessagesUsers['to_player'].')';?></h3>
  </div>

  <div class="message_content">
    <p><?php echo User::getUserUsername($getMessagesUsers['from_player']).': '.$getMessagesUsers['message_content'];?></p>
  </div>
</div>
