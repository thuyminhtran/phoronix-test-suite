<?php

/*
	Phoronix Test Suite
	URLs: http://www.phoronix.com, http://www.phoronix-test-suite.com/
	Copyright (C) 2009 - 2010, Phoronix Media
	Copyright (C) 2009 - 2010, Michael Larabel

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

class dump_system_sensors implements pts_option_interface
{
	public static function run($r)
	{
		echo pts_string_header("Phoronix Test Suite Sensors");
		foreach(phodevi::supported_sensors() as $sensor)
		{
			echo phodevi::sensor_name($sensor) . ": " . phodevi::read_sensor($sensor) . ' ' . phodevi::read_sensor_unit($sensor) . "\n";
		}

		echo "\nUnsupported Sensors:\n\n";
		foreach(phodevi::unsupported_sensors() as $sensor)
		{
			echo "- " . phodevi::sensor_name($sensor) . "\n";
		}
		echo "\n";
	}
}

?>
