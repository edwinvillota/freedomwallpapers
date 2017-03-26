<?php
	if($_POST){

		require('core/core.php');

		switch (isset($_POST['mode']) ? $_POST['mode'] : null) {
			case 'login':
				require('core/bin/ajax/login.php');
				break;

			case 'register':
				require('core/bin/ajax/register.php');
				break;

			case 'logout':
				require('core/bin/ajax/logout.php');
				break;

			case 'loadCategories':
				require('core/bin/ajax/loadCategories.php');
				break;

			case 'uploadWallpaper':
				require('core/bin/ajax/uploadWallpaper.php');
				break;

			case 'getRecent':
				require('core/bin/ajax/getRecent.php');
				break;

			case 'downloadWall':
				require('core/bin/ajax/downloadWall.php');
				break;

			case 'addFavorite':
				require('core/bin/ajax/addFavorite.php');
				break;

			case 'addVote':
				require('core/bin/ajax/addVote.php');
				break;

			case 'getStatistics':
				require('core/bin/ajax/getStatistics.php');
				break;
			case 'getUserWallStates':
				require('core/bin/ajax/getUserWallStates.php');
				break;

			default:
				header('location: index.php');
				break;
		}
	} else {
		header('location: index.php');
	}

?>
