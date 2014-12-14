<?php
namespace freedimension\hue;

use freedimension\rest\rest;

require_once "light.php";

/**
 * Class hue
 * @package freedimension\hue
 */
class hue
{
	protected $sHost       = "";
	protected $sUsername   = "";
	protected $sDeviceType = "";
	protected $oRest       = null;
	protected $hLights     = [];

	public function __construct (
		rest $oRest,
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

	/**
	 * @param $iLightID
	 * @return light
	 */
	public function light ($iLightID)
	{
		if ( !isset( $this->hLights[$iLightID] ) )
		{
			$this->hLights[$iLightID] = new light($iLightID, $this->oRest);
		}
		return $this->hLights[$iLightID];
	}
}

