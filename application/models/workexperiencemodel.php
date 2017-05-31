<?php

/**
 * Created by PhpStorm.
 * User: RamS-NSET
 * Date: 9/6/2016
 * Time: 12:33 PM
 */
class workexperiencemodel extends CI_Model
{
	private $personmodel;
	private static $db;

	public function __construct()
	{
		parent::__construct();
		$this->personmodel = new personmodel();

		self::$db = &get_instance()->db;
	}

	/**
	 * @param $value
	 * @return string
	 * http://stackoverflow.com/questions/1162491/alternative-to-mysql-real-escape-string-without-connecting-to-db
	 */
	public static function escape($value)
	{
		$return = '';
		for ($i = 0; $i < strlen($value); ++$i) {
			$char = $value[$i];
			$ord = ord($char);
			if ($char !== "'" && $char !== "\"" && $char !== '\\' && $ord >= 32 && $ord <= 126)
				$return .= $char;
			else
				$return .= '\\x' . dechex($ord);
		}
		return $return;
	}


}