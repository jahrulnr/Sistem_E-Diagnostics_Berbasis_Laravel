<?php

namespace App\Helpers;

class customConfig{
	public const student_host_mail = "student.uir.ac.id"; 
	public const npm_pattern = "/([0-9]{2})3510([0-9]{3})/i";

	public static function studentmail_validation($email){
		return explode("@", $email)[1] == self::student_host_mail;
	}

	public static function npm_validation($npm){
		return preg_match(self::npm_pattern, $npm, $h) ? 
			$h[0] : false;
	}
}