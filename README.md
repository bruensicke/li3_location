# li3_location

Lithium library to retrieve information about geo locations

## Installation

Add a submodule to your li3 libraries:

	git submodule add git@github.com:bruensicke/li3_location.git libraries/li3_location

and activate it in you app (config/bootstrap/libraries.php), of course:

	Libraries::add('li3_location');

## Setup

You must register for a Yahoo application [here](http://developer.yahoo.com/dashboard/createKey.html).

Then, you need to setup your app_id like this:

	Location::$app_id = 'foo';

Now you can do something like that:

	Location::find('Hannover,Germany');

and get something back, that may look like:

	Array
	(
	    [quality] => 40
	    [latitude] => 52.372278
	    [longitude] => 9.738157
	    [offsetlat] => 52.372278
	    [offsetlon] => 9.738157
	    [radius] => 17500
	    [boundingbox] => Array
	        (
	            [north] => 52.454731
	            [south] => 52.305531
	            [east] => 9.920940
	            [west] => 9.606850
	        )

	    [name] => 
	    [line1] => 
	    [line2] => Hannover
	    [line3] => 
	    [line4] => Deutschland
	    [house] => 
	    [street] => 
	    [xstreet] => 
	    [unittype] => 
	    [unit] => 
	    [postal] => 
	    [neighborhood] => 
	    [city] => Hannover
	    [county] => Region Hannover
	    [state] => Niedersachsen
	    [country] => Deutschland
	    [countrycode] => DE
	    [statecode] => NI
	    [countycode] => 
	    [timezone] => Europe/Berlin
	    [areacode] => 511
	    [uzip] => 30159
	    [hash] => 
	    [woeid] => 657169
	    [woetype] => 7
	)

And hopefully, you have a smile in your face. Have fun.

## Credits

* [li3](http://www.lithify.me)

