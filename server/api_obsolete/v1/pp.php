<?php

use \Jacwright\RestServer\RestException;



class pp
{

	/**
			* Sets Achievements
			*
			* @url GET /users/$uid/achievements/set/$achname/$achstatus
		*/
	public function setUserAchievement($uid = null, $achname = null, $achstatus = null)
	{
	//require 'mysql.php';
		$host = "127.0.0.1";
		$user = "root";
		$pass = "";
		$database = "pp_achievements";
	//require_once 'achievements.php';
	require 'functions.php';

	$id = sanitize($uid);
	$achievement_name = sanitize($achname);
	$achievement_status = sanitize($achstatus);

	$mysqli = mysqli_connect($host, $user, $pass, $database);
	//var_dump($mysqli);
	//$stmt = $mysqli->prepare("UPDATE `achievements` SET ? = ? WHERE `nick` = ?");
	if ($stmt = $mysqli->prepare("INSERT IGNORE INTO achievements(nick) VALUES ('".$id."');
	UPDATE `achievements` SET `".$achievement_name."` = ".$achievement_status." WHERE `nick` = '".$id."'")){

	//$stmt->bind_param('sis', $achievement_name, $achievement_status, $id);  // Bind parameters.
		$stmt->execute();    // Execute the prepared query.
		$stmt->store_result();
		$stmt->close();

		echo 'true';
	}
	else
		echo 'false';
	//echo $id;
	//echo $achievement_name;
	//echo $achievement_status;
	}

	/**
     * Gets the user achievements by id
     *
     * @url GET /users/$uid/achievements
	 */
	public function getUserAchievements($uid = null)
	{
require 'mysql.php';
require 'achievements.php';
require 'functions.php';

	$id = sanitize($uid);

	 $path = 'http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/';
		$html = '<html>
				 <head>
				 <title>'.$id.'\'s Achievements - ProjectPonyville</title>
				 <link rel="Stylesheet" type="text/css" href="'.$path.'style.css" />
				 </head>
				 <body>';
		echo $html;



		$mysqli = mysqli_connect($host, $user, $pass, $database) or die (mysqli_error($mysqli));

		if ($stmt = $mysqli->prepare("SELECT level5, level10, level15
        FROM `achievements`
       WHERE nick = ?
        LIMIT 1")) {
		$stmt->bind_param('s', $id);  // Bind "$uid" to parameter.
		$stmt->execute();    // Execute the prepared query.
		$stmt->store_result();

		// get variables from result.
		$stmt->bind_result($level5, $level10, $level15);
		$stmt->fetch();
		$stmt->close();

		//echo $level5;
		//															[0]				[1]			[2]
		$achievement_unlocked = array($level5, $level10, $level15);
	}
	//															[0]					[1]					[2]
	$achievement_image = array('level5.png','level10.png','level15.png');


		echo '<h1>'.$id.'\'s Achievements</h1>';

		echo '<table border="1" frame="box" rules="rows">
		';
		for ($i = 0; $i <= count($achievement_desc)-1; $i++){
		echo '<tr><td id="achievement_image"><img id="achievement_image" src="';
		if($achievement_unlocked[$i] == 1){echo $path.$achievement_image[$i];}
		else {
		echo $path.'locked.png';
		}
		echo '" /></td><td id="achievement_desc_name">
		<p id="achievement_name">'.$achievement_name[$i].'</p>
		<p id="achievement_desc">'.$achievement_desc[$i].'</p>
		</td></tr>';}
		echo'
		</table>';
	}


	/**
     * Returns LOL
     *
     * @url GET /quack
     */
	public function quack()
	{
		return "LOL";
	}


    /**
     * Returns a JSON string object to the browser when hitting the root of the domain
     *
     * @url GET /
     */
    public function test()
    {
        return "Hello World";
    }

    /**
     * Logs in a user with the given username and password POSTed. Though true
     * REST doesn't believe in sessions, it is often desirable for an AJAX server.
     *
     * @url POST /login
     */
    public function login()
    {
        $username = $_POST['username'];
        $password = $_POST['password']; //@todo remove since it is not needed anywhere
        return array("success" => "Logged in " . $username);
    }

    /**
     * Gets the user by id or current user
     *
     * @url GET /users/$id
     * @url GET /users/current
     */
    public function getUser($id = null)
    {
        // if ($id) {
        //     $user = User::load($id); // possible user loading method
        // } else {
        //     $user = $_SESSION['user'];
        // }

        return array("id" => $id, "name" => null); // serializes object into JSON
    }

    /**
     * Saves a user to the database
     *
     * @url POST /users
     * @url PUT /users/$id
     */
    public function saveUser($id = null, $data)
    {
        // ... validate $data properties such as $data->username, $data->firstName, etc.
        // $data->id = $id;
        // $user = User::saveUser($data); // saving the user to the database
        $user = array("id" => $id, "name" => null);
        return $user; // returning the updated or newly created user object
    }

    /**
     * Get Charts
     *
     * @url GET /charts
     * @url GET /charts/$id
     * @url GET /charts/$id/$date
     * @url GET /charts/$id/$date/$interval/
     * @url GET /charts/$id/$date/$interval/$interval_months
     */
    public function getCharts($id=null, $date=null, $interval = 30, $interval_months = 12)
    {
        echo "$id, $date, $interval, $interval_months";
    }

    /**
     * Throws an error
     *
     * @url GET /error
     */
    public function throwError() {
        throw new RestException(401, "Empty password not allowed");
    }

	/**
     * Throws a 404
     *
     * @url GET /404
     */
    public function e404() {
        echo '404';
    }
	
	/**
     * POST Saves in Pastebin
     * Gets data
	 *
     * @url POST /save/pastebin
     */
    public function pastebin_save()
    {
		require 'private_keys.php';
        require 'functions.php';

		$data = sanitize($_POST['data']);
		
		$draft = new Draft(); // drafts represent unsent pastes
		$draft->setContent($data); // set the paste content

		// the Developer class encapsulates a developer API key; an instance
		// needs to be provided whenever Brush might interact with Pastebin
		$developer = new Developer($PastebinDeveloperKey);

		try {
			// send the draft to Pastebin; turn it into a full blown Paste object
			$paste = $draft->paste($developer);

			// print out the URL of the new paste
			echo $paste->getUrl(); // e.g. http://pastebin.com/JYvbS0fC
		}
		catch (BrushException $e) {
			// some sort of error occurred; check the message for the cause
			echo $e->getMessage();
		}
	}

}