<?php
namespace freedimension\hue;

use freedimension\rest\rest;

/**
 * Class hue
 * @package freedimension\hue
 */
class hue
{
	protected $sHost       = "";
	protected $sUsername   = "";
	protected $sDeviceType = "";
	protected $hStash      = [];
	protected $hHash       = [];
	protected $oRest       = null;

	public function __construct (
		$oRest,
		$sHost,
		$sUsername,
		$sDeviceType
	){
		$oRest->setBaseUri("http://{$sHost}/api/{$sUsername}");
		$this->oRest = $oRest;
		$this->sHost = $sHost;
		$this->sUsername = $sUsername;
		$this->sDeviceType = $sDeviceType;
	}

	public function stash (
		$iLight = 1,
		$sSlot = "default"
	){
		$this->hStash["light"][$iLight][$sSlot] = $this->getLight($iLight);
		$sHash = "#" . md5($iLight . "|" . $sSlot);
		$this->hHash[$sHash] = [
			"type" => "light",
			"id"   => $iLight,
			"slot" => $sSlot
		];
	}

	public function stashPop (
		$mId = 1,
		$sKey = "default"
	){
		$sType = "light";
		if ( "#" === substr($mId, 0, 1) )
		{
		}
	}

	public function blink ($iLight = 1)
	{
		$this->Light($iLight, ["alert" => "select"]);
	}

	public function Light (
		$iLight,
		$mState = null
	){
		if ( null === $mState )
		{
			$sPath = "lights/{$iLight}";
			return $this->oRest->get($sPath);
		}
		else
		{
			if ( is_array($mState) )
			{
				$mState = json_encode($mState);
			}
			$sPath = "lights/{$iLight}/state";
			return $this->oRest->put($mState, $sPath);
		}
	}
}

