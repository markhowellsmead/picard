<?php

namespace SayHello\Theme\Package;

class Location
{

	public function DMStoDEC($deg, $min, $sec)
	{
		// Converts DMS ( Degrees / minutes / seconds )
		// to decimal format longitude / latitude
		return $deg + ((($min * 60) + ($sec)) / 3600);
	}

	public function DECtoDMS($dec)
	{
		// Converts decimal longitude / latitude to DMS
		// ( Degrees / minutes / seconds )

		// This is the piece of code which may appear to
		// be inefficient, but to avoid issues with floating
		// point math we extract the integer part and the float
		// part by using a string function.

		$vars = explode('.', $dec);
		$deg = $vars[0];
		$tempma = '0.'.$vars[1];

		$tempma = $tempma * 3600;
		$min = floor($tempma / 60);
		$sec = $tempma - ($min * 60);

		return ['deg' => $deg, 'min' => $min, 'sec' => $sec];
	}

	/**
	 *
	 * 		[lat] => Array
	 * 			(
	 * 				[0] => 46/1
	 *				[1] => 435608178/10000000
	 *				[2] => 0/1
	 *			)
	 *
	 *		[lng] => Array
	 *			(
	 *				[0] => 7/1
	 *				[1] => 359825370/10000000
	 *				[2] => 0/1
	 *			)
	 *
	 *		[address] => ''
	 **/
	public function gpsToLatLng($location)
	{

		$lat['deg'] = explode('/', $location['lat'][0]);
		$lat['deg'] = $lat['deg'][0] / $lat['deg'][1];
		$lat['min'] = explode('/', $location['lat'][1]);
		$lat['min'] = $lat['min'][0] / $lat['min'][1];
		$lat['sec'] = explode('/', $location['lat'][2]);
		$lat['sec'] = floatval($lat['sec'][0]) / floatval($lat['sec'][1]);
		$lat['decimal'] = $this->DMStoDEC($lat['deg'], $lat['min'], $lat['sec']);

		$lng['deg'] = explode('/', $location['lng'][0]);
		$lng['deg'] = $lng['deg'][0] / $lng['deg'][1];
		$lng['min'] = explode('/', $location['lng'][1]);
		$lng['min'] = $lng['min'][0] / $lng['min'][1];
		$lng['sec'] = explode('/', $location['lng'][2]);
		$lng['sec'] = floatval($lng['sec'][0]) / floatval($lng['sec'][1]);
		$lng['decimal'] = $this->DMStoDEC($lng['deg'], $lng['min'], $lng['sec']);

		return implode(',', [$lat['decimal'], $lng['decimal']]);
	}
}
