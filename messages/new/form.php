<<<<<<< HEAD
<form id="newmsg" name="mewmsg" method="post" action="newmessage.php">
To: <input name="to" type="text" id="to" value="" size="42" />
=======
<?php loadAutoCompleteUser(); ?>
<form id="newmsg" name="mewmsg" method="post" action="newmessage.php">
To: <input name="to" class="userfield" type="text" id="to" value="" size="42" />
>>>>>>> 980121d2575feff76c7cb95b4eba7b6459894ef5
Message: <textarea name="msg" id="msg" value="" cols="25" rows="5" ></textarea>
<input name="sendmsg" type="submit" id="sendmsg" value="Send" />
</form>