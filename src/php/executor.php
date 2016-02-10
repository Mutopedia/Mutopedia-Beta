<?php
	session_start();

	require("class/bdd.php");
	require("class/Engine.php");
	require("class/User.php");
	require('class/Tool.php');

	$dataArray = array();

	if(isset($_POST['action']) AND !empty($_POST['action']))
	{
		$action = htmlspecialchars($_POST['action']);

		if($action == "isUserLogged")
		{
			$dataArray['result'] = User::isLogged();
		}

		if($action == "logOut")
		{
			$returnLog = array();
			$dataArray['result'] = $returnLog = User::logOut();
		}

		if($action == "loadModel")
		{
			if(isset($_POST['modelName']))
			{
				$modelName = htmlspecialchars($_POST['modelName']);

				if(isset($_POST['argPage']) AND !empty($_POST['argPage'])){
					$argPage = htmlspecialchars($_POST['argPage']);
				}else {
					$argPage = null;
				}

				$returnModel = array();
				$returnModel = Engine::loadModel($modelName, $argPage);

				$dataArray['error'] = $returnModel['error'];
				$dataArray['reply'] = $returnModel['reply'];
				$dataArray['result'] = $returnModel['result'];
			}
			else
			{
				$dataArray['result'] = false;
				$dataArray['error'] = "! modelName: not set !";
				$dataArray['reply'] = null;
			}
		}

		if($action == "loadHeader")
		{
			$returnModel = array();
			$returnModel = Engine::loadModel('header', null);

			$dataArray['error'] = $returnModel['error'];
			$dataArray['reply'] = $returnModel['reply'];
			$dataArray['modelName'] = $returnModel['modelName'];
			$dataArray['result'] = $returnModel['result'];
		}

		if($action == "searchSpecimen")
		{
			if(isset($_POST['specimenName']))
			{
				$specimenName = htmlspecialchars($_POST['specimenName']);

				$returnSearch = array();
				$returnSearch = Tool::searchSpecimen($specimenName);

				$dataArray['error'] = $returnSearch['error'];
				$dataArray['result'] = $returnSearch['result'];
				$dataArray['reply'] = $returnSearch['reply'];
			}
			else
			{
				$dataArray['result'] = false;
				$dataArray['error'] = "! specimenName: not set !";
				$dataArray['reply'] = null;
			}
		}

		if($action == "startBreeding")
		{
			if(isset($_POST['specimenNameCode_1']) AND isset($_POST['specimenNameCode_2']))
			{
				$specimenNameCode_1 = htmlspecialchars($_POST['specimenNameCode_1']);
				$specimenNameCode_2 = htmlspecialchars($_POST['specimenNameCode_2']);

				$returnBreeding = array();
				$returnBreeding = Tool::startBreeding($specimenNameCode_1, $specimenNameCode_2);

				$dataArray['result'] = $returnBreeding['result'];
				$dataArray['error'] = $returnBreeding['error'];
				$dataArray['reply'] = $returnBreeding['reply'];
			}
			else
			{
				$dataArray['result'] = false;
				$dataArray['error'] = "! specimenNameCode_1, specimenNameCode_2: not set !";
				$dataArray['reply'] = null;
			}
		}

		if($action == "logUser")
		{
			if(isset($_POST['userid']) AND isset($_POST['userfirstname']) AND isset($_POST['userlastname']) AND isset($_POST['userpic']))
			{
				$userId = htmlspecialchars($_POST['userid']);
				$userFirstName = htmlspecialchars($_POST['userfirstname']);
				$userLastName = htmlspecialchars($_POST['userlastname']);
				$userPic = htmlspecialchars($_POST['userpic']);

				$returnLog = array();
				$returnLog = User::logUser($userId, $userFirstName, $userLastName, $userPic);

				$dataArray['result'] = $returnLog['result'];
				$dataArray['error'] = $returnLog['error'];
				$dataArray['reply'] = $returnLog['reply'];
			}
			else
			{
				$dataArray['result'] = false;
				$dataArray['error'] = "! userid, userfirstname, userlastname, userpic: not set !";
				$dataArray['reply'] = null;
			}
		}

		if($action == "searchUsers")
		{
			if(isset($_POST['searchContent']))
			{
				$searchContent = htmlspecialchars($_POST['searchContent']);
			}
			else
			{
				$searchContent = "";
			}

			if(isset($_POST['sortByValue']) AND !empty($_POST['sortByValue']))
			{
				$sortByValue = htmlspecialchars($_POST['sortByValue']);

				$returnReg = array();
				$returnReg = Engine::searchUsers($searchContent, $sortByValue);

				$dataArray['result'] = $returnReg['result'];
				$dataArray['error'] = $returnReg['error'];
				$dataArray['reply'] = $returnReg['reply'];
			}
			else
			{
				$dataArray['result'] = false;
				$dataArray['error'] = "sortByValue is empty !";
				$dataArray['reply'] = null;
			}
		}

		if($action == "getReleaseDate")
		{
			if(isset($_POST['releaseName']) AND !empty($_POST['releaseName']))
			{
				$releaseName = htmlspecialchars($_POST['releaseName']);

				$returnDate = array();
				$returnDate = Engine::getReleaseDate($releaseName);

				$dataArray['result'] = $returnDate['result'];
				$dataArray['error'] = $returnDate['error'];
				$dataArray['reply'] = $returnDate['reply'];
			}
			else
			{
				$dataArray['result'] = false;
				$dataArray['error'] = "! releaseName: not set !";
				$dataArray['reply'] = null;
			}
		}

		if($action == "changeFbPermission")
		{
			if(isset($_POST['state']) AND !empty($_POST['state']))
			{
				$state = htmlspecialchars($_POST['state']);

				$returnPermission = array();
				$returnPermission = User::changeFbPermission($state);

				$dataArray['result'] = $returnPermission['result'];
				$dataArray['error'] = $returnPermission['error'];
				$dataArray['reply'] = $returnPermission['reply'];
			}
			else
			{
				$dataArray['result'] = false;
				$dataArray['error'] = "! state: not set !";
				$dataArray['reply'] = null;
			}
		}

		if($action == "changeCharterAcceptance")
		{
			if(isset($_POST['state']) AND !empty($_POST['state']))
			{
				$state = htmlspecialchars($_POST['state']);

				$returnPermission = array();
				$returnPermission = User::changeCharterAcceptance($state);

				$dataArray['result'] = $returnPermission['result'];
				$dataArray['return'] = $returnPermission['return'];
				$dataArray['error'] = $returnPermission['error'];
				$dataArray['reply'] = $returnPermission['reply'];
			}
			else
			{
				$dataArray['result'] = false;
				$dataArray['return'] = null;
				$dataArray['error'] = "! state: not set !";
				$dataArray['reply'] = null;
			}
		}

		if($action == "changeUserMutant")
		{
			if(isset($_POST['mutantNameCode']) AND !empty($_POST['mutantNameCode']))
			{
				$mutantNameCode = htmlspecialchars($_POST['mutantNameCode']);

				$returnUserMutant = array();
				$returnUserMutant = User::changeUserMutant($mutantNameCode);

				$dataArray['result'] = $returnUserMutant['result'];
				$dataArray['error'] = $returnUserMutant['error'];
				$dataArray['reply'] = $returnUserMutant['reply'];
			}
			else
			{
				$dataArray['result'] = false;
				$dataArray['error'] = "! mutantNameCode: not set !";
				$dataArray['reply'] = null;
			}
		}

		if($action == "changeUserCenterLevel")
		{
			if(isset($_POST['centerLevel']) AND !empty($_POST['centerLevel']))
			{
				$centerLevel = htmlspecialchars($_POST['centerLevel']);

				$returnUserMutant = array();
				$returnUserMutant = User::changeUserCenterLevel($centerLevel);

				$dataArray['result'] = $returnUserMutant['result'];
				$dataArray['error'] = $returnUserMutant['error'];
				$dataArray['reply'] = $returnUserMutant['reply'];
			}
			else
			{
				$dataArray['result'] = false;
				$dataArray['error'] = "! centerLevel: not set !";
				$dataArray['reply'] = null;
			}
		}

		if($action == "changeUserFameLevel")
		{
			if(isset($_POST['fameLevel']) AND !empty($_POST['fameLevel']))
			{
				$fameLevel = htmlspecialchars($_POST['fameLevel']);

				$returnUserMutant = array();
				$returnUserMutant = User::changeUserFameLevel($fameLevel);

				$dataArray['result'] = $returnUserMutant['result'];
				$dataArray['error'] = $returnUserMutant['error'];
				$dataArray['reply'] = $returnUserMutant['reply'];
			}
			else
			{
				$dataArray['result'] = false;
				$dataArray['error'] = "! fameLevel: not set !";
				$dataArray['reply'] = null;
			}
		}

		if($action == "reportPlayer")
		{
			if((isset($_POST['reported_player']) AND !empty($_POST['reported_player'])) AND (isset($_POST['report_message']) AND !empty($_POST['report_message'])))
			{
				$reportedPlayer = htmlspecialchars($_POST['reported_player']);
				$reportMessage = htmlspecialchars($_POST['report_message']);

				$returnUserMutant = array();
				$returnUserMutant = User::reportPlayer($reportedPlayer, $reportMessage);

				$dataArray['result'] = $returnUserMutant['result'];
				$dataArray['error'] = $returnUserMutant['error'];
				$dataArray['reply'] = $returnUserMutant['reply'];
			}
			else
			{
				$dataArray['result'] = false;
				$dataArray['error'] = "The message of the report is empty !";
				$dataArray['reply'] = null;
			}
		}
	}
	else
	{
		$dataArray['result'] = "executor.php: ! action: not set !";
	}

	echo json_encode($dataArray);

	session_write_close();
?>
