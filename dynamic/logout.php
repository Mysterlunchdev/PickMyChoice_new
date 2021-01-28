<?php
$flag=$_GET['flag'];
session_start();
$_SESSION['user_id'] = '';
session_destroy();

setcookie("redirect_to", "");
unset($_COOKIE['redirect_to']);
?> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
location.href="index.php?flag=<?php echo $flag;?>";
</script>