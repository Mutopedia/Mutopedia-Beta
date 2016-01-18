<?php

class User
{
	private $id;
	private $username;
	private $password;
	private $token;

	public function __construct()
	{
		$dataArray = array();
	}

	public static function randomSalt($nbChar) 
	{
		$randString = "";
		$chars = "abcdefghijklmnpqrstuvwxy0123456789";
		srand((double)microtime()*1000000);
		for($i=0; $i < $nbChar; $i++) 
		{
			$randString .= $chars[rand()%strlen($chars)];
		}

		return $randString;
	}

	public static function isLogged()
	{
		if(isset($_SESSION["SID_ID"]) AND !empty($_SESSION["SID_ID"]))
		{
			$newStaticBdd = new BDD();
			$UserInfo = $newStaticBdd->select("isLoggedFB", "users", "WHERE token LIKE '".self::getToken()."'");
			$getUserInfo = $newStaticBdd->fetch_array($UserInfo);

			if($getUserInfo['isLoggedFB'] == 1)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	public static function logOut()
	{
		$newStaticBdd = new BDD();
		$newStaticBdd->update("users", "isLoggedFB = '0'", "WHERE token = '".self::getToken()."'");

		$_COOKIE = array();
		$_SESSION = array();

		return true;
	}

	public static function getToken()
	{
		if(isset($_COOKIE['token']) AND !empty($_COOKIE['token']))
		{
			return $_COOKIE["token"];
		}
		else
		{
			return "null";
		}
	}

	public static function getUserToken($user)
	{
		if(self::isLogged())
		{
			$newStaticBdd = new BDD();
			$IdToken = $newStaticBdd->select("token", "users", "WHERE userlink LIKE '".$user."'");
			$getIdToken = $newStaticBdd->fetch_array($IdToken);

			return $getIdToken['token'];
		}
	}

	public static function setTime()
	{
		if(self::isLogged())
		{
			$newStaticBdd = new BDD();
			$newStaticBdd->update("users", "time = '".time()."'", "WHERE token = '".self::getToken()."'");

			return true;
		}
		else
		{
			return false;
		}
	}

	public static function checkToken()
	{
		$return = array();

		if(self::isLogged())
		{
			$newStaticBdd = new BDD();
			$UserInfo = $newStaticBdd->select("token", "users", "WHERE id LIKE '".self::getId()."'");
			$getUserInfo = $newStaticBdd->fetch_array($UserInfo);

			if(self::getToken() == $getUserInfo['token'])
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}
		else
		{
			return -1;
		}
	}

	public static function getId()
	{
		if(self::isLogged())
		{
			$newStaticBdd = new BDD();
			$IdToken = $newStaticBdd->select("id", "users", "WHERE token LIKE '".self::getToken()."'");
			$getIdToken = $newStaticBdd->fetch_array($IdToken);

			return $getIdToken['id'];
		}
	}

	public static function getPicture()
	{
		if(self::isLogged())
		{
			$newStaticBdd = new BDD();
			$IdToken = $newStaticBdd->select("fb_picture", "users", "WHERE token LIKE '".self::getToken()."'");
			$getIdToken = $newStaticBdd->fetch_array($IdToken);

			return $getIdToken['fb_picture'];
		}
	}

	public static function getUserPicture($user)
	{
		if(isset($user) AND !empty($user))
		{
			$newStaticBdd = new BDD();
			$user = $newStaticBdd->real_escape_string(htmlspecialchars($user));

			$IdToken = $newStaticBdd->select("fb_picture", "users", "WHERE userlink LIKE '".$user."'");
			$getIdToken = $newStaticBdd->fetch_array($IdToken);

			return $getIdToken['fb_picture'];
		}
		else
		{
			return null;
		}
	}

	public static function getUsername()
	{
		if(self::isLogged())
		{
			$newStaticBdd = new BDD();
			$UsernameToken = $newStaticBdd->select("fb_firstname, fb_lastname", "users", "WHERE token LIKE '".self::getToken()."'");
			$getUsernameToken = $newStaticBdd->fetch_array($UsernameToken);

			return $getUsernameToken['fb_firstname'].' '.$getUsernameToken['fb_lastname'];
		}
	}

	public static function getUserLink()
	{
		if(self::isLogged())
		{
			$newStaticBdd = new BDD();
			$UsernameToken = $newStaticBdd->select("userlink", "users", "WHERE token LIKE '".self::getToken()."'");
			$getUsernameToken = $newStaticBdd->fetch_array($UsernameToken);

			return $getUsernameToken['userlink'];
		}
	}
	
	public static function getUserUsername($user)
	{
		if(isset($user) AND !empty($user))
		{
			$newStaticBdd = new BDD();
			$user = $newStaticBdd->real_escape_string(htmlspecialchars($user));

			$Username = $newStaticBdd->select("fb_firstname, fb_lastname", "users", "WHERE userlink LIKE '".$user."'");
			$getUsername = $newStaticBdd->fetch_array($Username);

			return $getUsername['fb_firstname'].' '.$getUsername['fb_lastname'];
		}
	}

	public static function getUserMutant($user)
	{
		if(isset($user) AND !empty($user))
		{
			$newStaticBdd = new BDD();
			$user = $newStaticBdd->real_escape_string(htmlspecialchars($user));

			$UserMutant = $newStaticBdd->select("user_mutant_namecode", "users", "WHERE userlink LIKE '".$user."'");
			$getUserMutant = $newStaticBdd->fetch_array($UserMutant);

			return $getUserMutant['user_mutant_namecode'];
		}
	}

	public static function getUserCenterLevel($user)
	{
		if(isset($user) AND !empty($user))
		{
			$newStaticBdd = new BDD();
			$user = $newStaticBdd->real_escape_string(htmlspecialchars($user));

			$UserMutant = $newStaticBdd->select("center_level", "users", "WHERE userlink LIKE '".$user."'");
			$getUserMutant = $newStaticBdd->fetch_array($UserMutant);

			return $getUserMutant['center_level'];
		}
	}

	public static function getUserFameLevel($user)
	{
		if(isset($user) AND !empty($user))
		{
			$newStaticBdd = new BDD();
			$user = $newStaticBdd->real_escape_string(htmlspecialchars($user));

			$UserMutant = $newStaticBdd->select("fame_level", "users", "WHERE userlink LIKE '".$user."'");
			$getUserMutant = $newStaticBdd->fetch_array($UserMutant);

			return $getUserMutant['fame_level'];
		}
	}

	public static function getUserFbId($user)
	{
		if(isset($user) AND !empty($user))
		{
			$newStaticBdd = new BDD();
			$user = $newStaticBdd->real_escape_string(htmlspecialchars($user));

			$FbId = $newStaticBdd->select("fb_id", "users", "WHERE userlink LIKE '".$user."'");
			$getFbId = $newStaticBdd->fetch_array($FbId);

			return $getFbId['fb_id'];
		}
	}

	public static function getFbPermission($user)
	{
		if(isset($user) AND !empty($user))
		{
			$newStaticBdd = new BDD();
			$user = $newStaticBdd->real_escape_string(htmlspecialchars($user));

			$FbPermission = $newStaticBdd->select("showFbAccount", "users", "WHERE userlink LIKE '".$user."'");
			$getFbPermission = $newStaticBdd->fetch_array($FbPermission);

			if($getFbPermission['showFbAccount'] == 0)
			{
				return false;
			}
			else
			{
				return true;
			}
		}
	}

	public static function changeFbPermission($state)
	{
		if(User::isLogged())
		{
			$newStaticBdd = new BDD();
			if(isset($state) AND !empty($state))
			{
				$state = $newStaticBdd->real_escape_string(htmlspecialchars($state));

				$newStaticBdd->update("users", "showFbAccount = ".$state."", "WHERE token = '".self::getToken()."'");

				$dataArray['result'] = true;
				$dataArray['error'] = null;
				$dataArray['reply'] = "Permission changed !";
			}
		}
		else
		{
			$dataArray['result'] = false;
			$dataArray['error'] = "User not logged !";
			$dataArray['reply'] = null;
		}

		return $dataArray;
	}

	public static function getCharterAcceptance($user)
	{
		if(isset($user) AND !empty($user))
		{
			$newStaticBdd = new BDD();
			$user = $newStaticBdd->real_escape_string(htmlspecialchars($user));

			$FbPermission = $newStaticBdd->select("charterAcceptance", "users", "WHERE userlink LIKE '".$user."'");
			$getFbPermission = $newStaticBdd->fetch_array($FbPermission);

			if($getFbPermission['charterAcceptance'] == 0)
			{
				return false;
			}
			else
			{
				return true;
			}
		}
	}

	public static function changeCharterAcceptance($state)
	{
		if(User::isLogged())
		{
			$newStaticBdd = new BDD();
			if(isset($state) AND !empty($state))
			{
				$state = $newStaticBdd->real_escape_string(htmlspecialchars($state));

				$newStaticBdd->update("users", "charterAcceptance = ".$state."", "WHERE token = '".self::getToken()."'");

				$dataArray['result'] = true;
				$dataArray['return'] = $state;
				$dataArray['error'] = null;
				$dataArray['reply'] = "charterAcceptance changed !";
			}
		}
		else
		{
			$dataArray['result'] = false;
			$dataArray['return'] = $state;
			$dataArray['error'] = "User not logged !";
			$dataArray['reply'] = null;
		}

		return $dataArray;
	}

	public static function changeUserMutant($mutantNameCode)
	{
		if(User::isLogged())
		{
			if(User::getCharterAcceptance(self::getUserLink()))
			{
				$newStaticBdd = new BDD();
				if(isset($mutantNameCode) AND !empty($mutantNameCode))
				{
					$mutantNameCode = $newStaticBdd->real_escape_string(htmlspecialchars($mutantNameCode));

					$newStaticBdd->update("users", "user_mutant_namecode = '".$mutantNameCode."'", "WHERE token = '".self::getToken()."'");

					$dataArray['result'] = true;
					$dataArray['error'] = null;
					$dataArray['reply'] = "Mutant changed !";
				}
			}
			else
			{
				$dataArray['result'] = false;
				$dataArray['error'] = "Non-acceptance of the charter !";
				$dataArray['reply'] = null;
			}
		}
		else
		{
			$dataArray['result'] = false;
			$dataArray['error'] = "User not logged !";
			$dataArray['reply'] = null;
		}

		return $dataArray;
	}

	public static function changeUserCenterLevel($centerLevel)
	{
		if(User::isLogged())
		{
			if(User::getCharterAcceptance(self::getUserLink()))
			{
				$newStaticBdd = new BDD();
				if(isset($centerLevel) AND !empty($centerLevel))
				{
					$centerLevel = $newStaticBdd->real_escape_string(htmlspecialchars($centerLevel));

					$newStaticBdd->update("users", "center_level = '".$centerLevel."'", "WHERE token = '".self::getToken()."'");

					$dataArray['result'] = true;
					$dataArray['error'] = null;
					$dataArray['reply'] = "Center Level changed !";
				}
			}
			else
			{
				$dataArray['result'] = false;
				$dataArray['error'] = "Non-acceptance of the charter !";
				$dataArray['reply'] = null;
			}
		}
		else
		{
			$dataArray['result'] = false;
			$dataArray['error'] = "User not logged !";
			$dataArray['reply'] = null;
		}

		return $dataArray;
	}

	public static function changeUserFameLevel($fameLevel)
	{
		if(User::isLogged())
		{
			if(User::getCharterAcceptance(self::getUserLink()))
			{
				$newStaticBdd = new BDD();
				if(isset($fameLevel) AND !empty($fameLevel))
				{
					$fameLevel = $newStaticBdd->real_escape_string(htmlspecialchars($fameLevel));

					$newStaticBdd->update("users", "fame_level = '".$fameLevel."'", "WHERE token = '".self::getToken()."'");

					$dataArray['result'] = true;
					$dataArray['error'] = null;
					$dataArray['reply'] = "Fame Level changed !";
				}
			}
			else
			{
				$dataArray['result'] = false;
				$dataArray['error'] = "Non-acceptance of the charter !";
				$dataArray['reply'] = null;
			}
		}
		else
		{
			$dataArray['result'] = false;
			$dataArray['error'] = "User not logged !";
			$dataArray['reply'] = null;
		}

		return $dataArray;
	}

	public static function logUser($userId, $userFirstName, $userLastName, $userPicSrc)
	{	
		$newStaticBdd = new BDD();

		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		$userId = $newStaticBdd->real_escape_string(htmlspecialchars($userId));
		$userFirstName = $newStaticBdd->real_escape_string(htmlspecialchars($userFirstName));
		$userLastName = $newStaticBdd->real_escape_string(htmlspecialchars($userLastName));
		$userPicSrc = $newStaticBdd->real_escape_string(htmlspecialchars($userPicSrc));

		$userLink = preg_replace("/[^A-Za-z0-9 ]/", '', strtolower($userFirstName)).".".preg_replace("/[^A-Za-z0-9 ]/", '', strtolower($userLastName));

		$userInfos = $newStaticBdd->select("fb_id, userlink, fb_firstname, fb_lastname, fb_picture, time_update", "users", "WHERE fb_id LIKE '".$userId."'");
		$getUserInfos = $newStaticBdd->fetch_array($userInfos);
		$getUserId = $newStaticBdd->num_rows($userInfos);

		setcookie("username", $userFirstName.' '.$userLastName, time() + 7200, "/");
		$_SESSION['SID_ID'] = session_id();

		if(self::setToken($userId))
		{
			if($getUserId != 1)
			{	
				$regUser = $newStaticBdd->insert("users", "fb_id, userlink, fb_firstname, fb_lastname, fb_picture, user_ip, isLoggedFB", "'".$userId."', '".$userLink."', '".$userFirstName."', '".$userLastName."', '".$userPicSrc."', '".$ip."', 1");

				$dataArray['result'] = true;
				$dataArray['error'] = null;
				$dataArray['reply'] = "User ".$userFirstName." ".$userLastName." registred !";
			}
			else
			{
				$regUser = $newStaticBdd->update("users", "fb_id = '".$userId."', userlink = '".$userLink."', fb_firstname = '".$userFirstName."', fb_lastname = '".$userLastName."', fb_picture = '".$userPicSrc."', user_ip = '".$ip."', isLoggedFB = 1", "WHERE fb_id LIKE '".$userId."'");

				$dataArray['result'] = true;
				$dataArray['error'] = null;
				$dataArray['reply'] = "User ".$userFirstName." ".$userLastName." updated and logged !";
			}
		}
		else
		{
			$dataArray['result'] = false;
			$dataArray['error'] = "Token not set !";
			$dataArray['reply'] = "User not logged !";
		}

		return $dataArray;
	}

	public static function setToken($userId)
	{
		if(isset($userId) AND !empty($userId))
		{
			$newStaticBdd = new BDD();
			$newStaticBdd->real_escape_string(htmlspecialchars($userId));

			$token = md5(uniqid(mt_rand(), true));

			unset($_COOKIE['token']);

			setcookie("token", $token, time()+7200, "/");

			if($newStaticBdd->update("users", "token = '".$token."', time_update = '".time()."'", "WHERE fb_id = '".$userId."'") == true)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
}

?>