<?php
namespace freedimension\hue;

use freedimension\rest\rest;

class light
{
	protected $iLightID    = null;
	protected $oRest       = null;
	protected $hStash      = [];
	protected $hProperties = [];
	protected $hState      = [];
	protected $hChanged    = [];

	public function __construct (
		$iLightID,
		rest $oRest
	){
		$this->iLightID = $iLightID;
		$this->oRest = $oRest;
		$this->sync();
	}

	public function __get ($sKey)
	{
		if ( isset( $this->hChanged[$sKey] ) )
		{
			return $this->hChanged[$sKey];
		}
		else
		{
			return $this->hState[$sKey];
		}
	}

	public function __set (
		$sKey,
		$mValue
	){
		$this->hChanged[$sKey] = $mValue;
	}

	public function apply (
		$sSlot = "default"
	){
		$this->state($this->hStash[$sSlot]);
	}

	public function blink ()
	{
		$this->hChanged['alert'] = "select";
		$this->write();
	}

	public function color ($sColor)
	{
		if ( '#' === substr($sColor, 0, 1) )
		{
			$hHsl = $this->hex2hsl(substr($sColor, 1));
		}
		$this->hChanged['hue'] = $hHsl['hue'];
		$this->hChanged['sat'] = $hHsl['sat'];
		$this->hChanged['bri'] = $hHsl['bri'];
		return $this;
	}

	public function hex2hsl ($sHex)
	{
		if ( 3 === strlen($sHex) )
		{
			$hHex = str_split($sHex);
			$sHex = array_reduce($hHex,
				function (
					$sHex,
					$sChar
				){
					return $sHex . str_repeat($sChar, 2);
				}
			);
		}
		list( $mRed, $mGreen, $mBlue ) = str_split($sHex, 2);

		$mRed = hexdec($mRed) / 255;
		$mGreen = hexdec($mGreen) / 255;
		$mBlue = hexdec($mBlue) / 255;

		$fMax = max($mRed, $mGreen, $mBlue);
		$fMin = min($mRed, $mGreen, $mBlue);
		$fBri = ( $fMax + $fMin ) / 2;
		$fDiff = $fMax - $fMin;
		$fHue = 0;
		if ( 0 === $fDiff )
		{
			$fHue = $fSat = 0;
		}
		else
		{
			$fSat = $fDiff / ( 1 - abs(2 * $fBri - 1) );

			switch ($fMax)
			{
				case $mRed:
					$fHue = 60 * fmod(( ( $mGreen - $mBlue ) / $fDiff ), 6);
					if ( $mBlue > $mGreen )
					{
						$fHue += 360;
					}
					break;
				case $mGreen:
					$fHue = 60 * ( ( $mBlue - $mRed ) / $fDiff + 2 );
					break;
				case $mBlue:
					$fHue = 60 * ( ( $mRed - $mGreen ) / $fDiff + 4 );
					break;
			}
		}
		return [
			'hue' => (int)( ( $fHue / 360 ) * 65535 ),
			'sat' => (int)( $fSat * 255 ),
			'bri' => (int)( $fBri * 255 ),
		];
	}

	public function name ($sName = null)
	{
		if ( null === $sName )
		{
			return $this->hProperties['name'];
		}
		else
		{
			# Todo: Sicher stellen, dass Name zwischen 0 und 32 Zeichen lang ist.
			$this->hProperties['name'] = $sName;
			$sPath = "lights/{$this->iLightID}";
			$hData = ['name' => $sName];
			$sResponse = $this->oRest->put($sPath, $hData);
			return $sResponse;
		}
	}

	public function off ()
	{
		$this->hChanged['on'] = false;
		$this->write();
	}

	public function on ()
	{
		$this->hChanged['on'] = true;
		$this->write();
	}

	public function pop (
		$sSlot = "default"
	){
		$this->apply($sSlot);
		unset ( $this->hStash[$sSlot] );
	}

	public function stash (
		$sSlot = "default"
	){
		$this->hStash[$sSlot] = $this->hState;
	}

	public function state (
		$sKey = null,
		$mValue = null
	){
		if ( null === $sKey )
		{
			return array_merge($this->hState, $this->hChanged);
		}
		elseif ( null === $mValue )
		{
			return $this->{$sKey};
		}
		else
		{
			$this->hChanged[$sKey] = $mValue;
			return $this;
		}
	}

	public function sync ()
	{
		$sPath = "lights/{$this->iLightID}";
		$hResponse = json_decode($this->oRest->get($sPath), true);
		foreach ($hResponse as $sKey => $mValue)
		{
			switch ($sKey)
			{
				case "state":
					$this->hState = $mValue;
					break;
				default;
					$this->hProperties[$sKey] = $mValue;
			}
		}
	}

	public function toggle ()
	{
		$this->hChanged['on'] = !$this->state('on');
		$this->write();
	}

	public function write ()
	{
		$sPath = "lights/{$this->iLightID}/state";
		$this->oRest->put($sPath, $this->hChanged);
		$this->hState = array_merge($this->hState, $this->hChanged);
	}
}