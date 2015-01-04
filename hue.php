<?php
namespace freedimension\hue;

use freedimension\rest\rest;

require_once "light.php";
require_once "color.php";

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
	protected $hUidMap     = [];
	protected $hNameMap    = [];

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

	public function getAllLights ()
	{
		$sPath = "lights";
		$hResponse = json_decode($this->oRest->get($sPath), true);
		foreach ($hResponse as $sKey => $hLight)
		{
			$hLight['_id'] = $sKey;
			$oLight = new light($hLight, $this->oRest);
			$this->hLights[$sKey] = $oLight;
			$this->hNameMap[$oLight->name] = $sKey;
			$this->hUidMap[$oLight->uid] = $sKey;
		}
	}

	/**
	 * @param $mLightId
	 * @return light
	 */
	public function light ($mLightId)
	{
		if ( filter_var($mLightId, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) )
		{
			if ( !isset( $this->hLights[$mLightId] ) )
			{
				$oLight = new light($mLightId, $this->oRest);
				$this->hNameMap[$oLight->name] = $mLightId;
				$this->hUidMap[$oLight->uid] = $mLightId;
				$this->hLights[$mLightId] = $oLight;
			}
		}
		elseif ( ( false !== strpos($mLightId, ':') ) &&
			( preg_match('/^([0-9a-f]{2}:){7}[0-9a-f]{2}-[0-9a-f]{2}/i', $mLightId) )
		)
		{
			if ( !isset( $this->hUidMap[$mLightId] ) )
			{
				$this->getAllLights();
			}
			$mLightId = $this->hUidMap[$mLightId];
		}
		else
		{ // last resort, must be a "search by name"
			if ( !isset( $this->hNameMap[$mLightId] ) )
			{
				$this->getAllLights();
			}
			$mLightId = $this->hNameMap[$mLightId];
		}
		return $this->hLights[$mLightId];
	}
}