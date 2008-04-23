<?php

// Phoronix Test Suite - User Config Functions

function pts_user_config_init($UserName = NULL, $UploadKey = NULL)
{
	if(!is_dir(PTS_USER_DIR))
		mkdir(PTS_USER_DIR);

	if(is_file(PTS_USER_DIR . "user-config.xml"))
		$file = file_get_contents(PTS_USER_DIR . "user-config.xml");
	else
		$file = "";
	$read_config = new tandem_XmlReader($file);

	if($UserName == NULL)
		$UserName = pts_read_user_config("PhoronixTestSuite/GlobalDatabase/UserName", "Default User", $read_config);
	if($UploadKey == NULL)
		$UploadKey = pts_read_user_config("PhoronixTestSuite/GlobalDatabase/UploadKey", "", $read_config);

	$config = new tandem_XmlWriter();
	$config->addXmlObject("PhoronixTestSuite/GlobalDatabase/UserName", 0, $UserName);
	$config->addXmlObject("PhoronixTestSuite/GlobalDatabase/UploadKey", 0, $UploadKey);

	$config->addXmlObject("PhoronixTestSuite/Options/Results/Directory", 1, pts_read_user_config("PhoronixTestSuite/Options/Results/Directory", "~/.phoronix-test-suite/test-results/", $read_config));

	$config->addXmlObject("PhoronixTestSuite/Options/Benchmarking/EnvironmentDirectory", 2, pts_read_user_config("PhoronixTestSuite/Options/Benchmarking/EnvironmentDirectory", "~/.phoronix-test-suite/installed-tests/", $read_config));
	$config->addXmlObject("PhoronixTestSuite/Options/Benchmarking/SleepTimeBetweenTests", 2, pts_read_user_config("PhoronixTestSuite/Options/Benchmarking/SleepTimeBetweenTests", "5", $read_config));

	$config->addXmlObject("PhoronixTestSuite/Options/BatchMode/SaveResults", 3, pts_read_user_config("PhoronixTestSuite/Options/BatchMode/SaveResults", "TRUE", $read_config));
	$config->addXmlObject("PhoronixTestSuite/Options/BatchMode/OpenBrowser", 3, pts_read_user_config("PhoronixTestSuite/Options/BatchMode/OpenBrowser", "FALSE", $read_config));
	$config->addXmlObject("PhoronixTestSuite/Options/BatchMode/UploadResults", 3, pts_read_user_config("PhoronixTestSuite/Options/BatchMode/UploadResults", "TRUE", $read_config));
	$config->addXmlObject("PhoronixTestSuite/Options/BatchMode/PromptForTestIdentifier", 3, pts_read_user_config("PhoronixTestSuite/Options/BatchMode/PromptForTestIdentifier", "TRUE", $read_config));

	file_put_contents(PTS_USER_DIR . "user-config.xml", $config->getXML());
}

function pts_read_user_config($xml_pointer, $value = null, $tandem_xml = null)
{
	if($tandem_xml != null)
	{
		$temp_value = $tandem_xml->getXmlValue($xml_pointer);

		if(!empty($temp_value))
			$value = $temp_value;
	}
	else
	{
		if(is_file(PTS_USER_DIR . "user-config.xml"))
			if(($file = file_get_contents(PTS_USER_DIR . "user-config.xml")) != FALSE)
			{
				$xml_parser = new tandem_XmlReader($file);
				unset($file);
				$temp_value = $xml_parser->getXmlValue($xml_pointer);

				if(!empty($temp_value))
					$value = $temp_value;
			}
	}

	return $value;
}
function pts_find_home($path)
{
	if(strpos($path, "~/") !== FALSE)
	{
	/*	$whoami = trim(shell_exec("whoami"));

		if($whoami == "root")
			$home_path = "/root";
		else
			$home_path = "/home/$whoami"; */

		$home_path = pts_posix_userhome();
		$path = str_replace("~/", $home_path, $path);
	}
	return $path;
}
function pts_current_user()
{
	$pts_user = pts_read_user_config("PhoronixTestSuite/GlobalDatabase/UserName", "Default User");

	if($pts_user == "Default User")
		$pts_user = pts_posix_username();

	return $pts_user;
}

?>
