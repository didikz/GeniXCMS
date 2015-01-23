<?php
/*
*    GeniXCMS - Content Management System
*    ============================================================
*    Build          : 20140925
*    Version        : 0.0.1 pre
*    Developed By   : Puguh Wijayanto (www.metalgenix.com)
*    License        : Private
*    ------------------------------------------------------------
*    filename : index.php
*    version : 0.0.1 pre
*    build : 20140928
*/

define('GX_PATH', realpath(__DIR__ . '/'));
define('GX_LIB', GX_PATH.'/inc/lib/');
define('GX_MOD', GX_PATH.'/inc/mod/');
define('GX_THEME', GX_PATH.'/inc/themes/');
define('GX_ASSET', GX_PATH.'/assets/');

function __autoload($f) {
    require GX_LIB. $f . '.class.php';
}


try {
    $sys = new System();
    $sess = new Session();
    $thm = new Theme();
    $db = new Db();
    $u = new User();
    Session::start();
    System::gZip();
    $thm->theme('header');
} catch (Exception $e) {
    echo $e->getMessage();
}


if(isset($_POST['login']))
{
	/*check if username is exist or not */
	$username = Typo::cleanX($_POST['username']);
	$sql = sprintf("SELECT `userid` FROM `user` WHERE `userid` = '%s'", $username);
	$db->result($sql);
	$c = Db::$num_rows;
	//echo $c;
	if($c == "1"){
		//$alertgreen = "";
		/* get user password */
		$pass = User::randpass(Typo::cleanX($_POST['password']));
		$sql = "SELECT `pass`,`group` FROM `user` WHERE `userid` = '{$username}'";
		//$q = mysql_query($sql);
		//$p = mysql_result($q, 0, 'password');
		//$group = mysql_result($q, 0, 'group');

		$l = $db->result($sql);
		$c = Db::$num_rows;

		foreach ($l as $v) {
			# code...
			//print_r($v);
			$p = $v->pass;
			$g = $v->group;
		}
		//echo $p;
		if($p == $pass)
		{
			$vars = array(
						'username'	=> $username,
						'loggedin'	=> true,
						'group'		=> $g
					);
			$sess->set_session($vars);
			/*
			$_SESSION['username'] = $_POST['username'];
			$_SESSION['login'] = "true";
			$_SESSION['group'] = $group;
			*/
			print_r($_SESSION);
			$alertgreen = "You are logged in now.";
		}elseif($p != $pass){
			$alertred[] = PASS_NOT_MATCH;
		}
	}elseif($c == "0"){
		$alertred[] = NO_USER;
	}
}

	if(isset($alertred)) {
		echo "
		<div class=\"alert alert-danger\">
			";
			foreach($alertred as $alert)
			{
				echo $alert;
			}
		echo"
		</div>";
	}
	if(isset($alertgreen)) {
		echo "
		<div class=\"alert alert-success\">
			{$alertgreen}
		</div>";
	}
	if(!User::is_loggedin()){

?>
	<form class="form-signin" role="form" method="post">
		<h2 class="form-signin-heading"><?=LOGIN_TITLE;?></h2>
		<input type="text" name="username" class="form-control" placeholder="<?=USERNAME;?>" required autofocus>
		<input type="password" name="password" class="form-control" placeholder="<?=PASSWORD;?>" required>
        <input type="hidden" name="postads" value="<?php echo $postads; ?>" />
		<label class="checkbox">
			<a href="forgotpassword.php"><?=FORGOT_PASS;?></a>
		</label>
		<button class="btn btn-lg btn-success btn-block" name="login" type="submit">Sign in</button>
	</form>


<?php
}elseif(isset($_SESSION['username'])){
	//echo"You're already Logged In. <br /><a href=\"logout.php\">Logout</a>".$_REQUEST["postads"]."__";
	if($_SESSION['username']=="admin")
	{
		if($_REQUEST["postads"]=="1")
		{
			header("location: submit.php");
		}
		else
		{
			header("location:admin/index.php");
		}
	}
	else
	{
		if($_REQUEST["postads"]=="1")
		{
			header('location: submit.php');
		}
		else
		{
			header('location: index.php');
		}
	}
}
//Session::destroy();
$thm->theme('footer');
System::Zipped();
?>