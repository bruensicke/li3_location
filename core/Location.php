<?php

namespace li3_location\core;


use lithium\util\Set;
use lithium\net\http\Service;

/**
 * Location allows retrieval of geo-location data via YAHOO API
 *
 */
class Location extends \lithium\core\StaticObject {

	/**
	 * host of remote endpoint
	 *
	 * @var string
	 */
	public static $host = 'where.yahooapis.com';

	/**
	 * Controls how long to wait for remote endpoint
	 *
	 * @var integer
	 */
	public static $timeout = 2;

	/**
	 * Finds lat/lon for locations
	 *
	 * @see li3_location\core\Location::geocode()
	 * @param string|array $name a string or an array of strings with
	 *        location names
	 * @param array $options additional options, currently none 
	 * @return array|boolean lat/lon of given $name, an array of these or
	 *         false on failure
	 */
	public static function find($name, array $options = array()) {
		$defaults = array(
			'all' => false,
			'params' => array(
				'locale' => 'de_DE',
				'flags' => 'JXTR',
				'gflags' => 'L',
				'appid' => '[yourappidhere]',
			),
		);
		$options = Set::merge($defaults, $options);
		return static::geocode($name, $options);
	}

	/**
	 * Get information about a location, given by lat+lon
	 *
	 * @see li3_location\core\Location::geocode()
	 * @param string|array $name lat/lon coordinates
	 * @param array $options additional options, currently none 
	 * @return array|boolean lat/lon of given $name, an array of these or
	 *         false on failure
	 */
	public static function lookup($lat, $lon, array $options = array()) {
		$defaults = array(
			'all' => false,
			'params' => array(
				'locale' => 'de_DE',
				'flags' => 'JXTR',
				'gflags' => 'LR',
				'appid' => '[yourappidhere]',
			),
		);
		$options = Set::merge($defaults, $options);
		$location = implode(',', array(
			'Latitude' => $lat,
			'Longitude' => $lon,
		));
		return static::geocode($location, $options);
	}

	/**
	 * Finds lat/lon for locations
	 *
	 * @see http://developer.yahoo.com/geo/placefinder/guide/requests.html
	 * @param string|array $name a string or an array of strings with
	 *        location names
	 * @param array $options additional options, currently none 
	 * @return array|boolean lat/lon of given $name, an array of these or
	 *         false on failure
	 */
	public static function geocode($location, array $options = array()) {
		$defaults = array(
			'all' => false,
			'params' => array(
				'locale' => 'de_DE',
				'flags' => 'JXTR',
				'gflags' => 'L',
				'appid' => '[yourappidhere]',
			),
		);
		$options = Set::merge($defaults, $options);
		$socket = new Service(array('host' => self::$host, 'timeout' => self::$timeout));
		$response = $socket->get('/geocode', Set::merge($options['params'], compact('location')));
		if (empty($response)) {
			return false;
		}
		$response = json_decode($response, true);
		$result = Set::extract($response, '/ResultSet/Results[quality]/.');

		$result = (!$options['all'])
			? current($result)
			: $result;

		return $result;
	}

	//function to find country and city from IP address
	//Developed by Roshan Bhattarai http://roshanbh.com.np
	public static function byIp($ipAddr) {

		//verify the IP address for the
		ip2long($ipAddr)== -1 || ip2long($ipAddr) === false ? trigger_error("Invalid IP", E_USER_ERROR) : "";
		$ipDetail=array(); //initialize a blank array

		//get the XML result from hostip.info
		$xml = file_get_contents("http://api.hostip.info/?ip=".$ipAddr);

		//get the city name inside the node <gml:name> and </gml:name>
		preg_match("@<Hostip>(\s)*<gml:name>(.*?)</gml:name>@si",$xml,$match);

		//assing the city name to the array
		$ipDetail['city']=$match[2]; 

		//get the country name inside the node <countryName> and </countryName>
		preg_match("@<countryName>(.*?)</countryName>@si",$xml,$matches);

		//assign the country name to the $ipDetail array
		$ipDetail['country']=$matches[1];

		//get the country name inside the node <countryName> and </countryName>
		preg_match("@<countryAbbrev>(.*?)</countryAbbrev>@si",$xml,$cc_match);
		$ipDetail['country_code']=$cc_match[1]; //assing the country code to array

		//return the array containing city, country and country code
		return $ipDetail;
	}

}