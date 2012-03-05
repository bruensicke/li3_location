<?php

namespace li3_location\core;

class Location extends \lithium\core\StaticObject {

	/**
	 * Finds lat/lon for locations
	 *
	 * @param string|array $name a string or an array of strings with
	 *        location names
	 * @param array $options additional options, currently none 
	 * @return array|boolean lat/lon of given $name, an array of these or
	 *         false on failure
	 */
	public function find($name, array $options = array()) {
		
	}

}