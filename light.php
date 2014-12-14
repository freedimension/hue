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
	protected $fLastWrite  = 0.0;
	protected $fTiming     = 0.1;

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
		$oColor = new color($sColor);
		$hHsb = $oColor->hsb();
		$this->hChanged['hue'] = $hHsb['hue'];
		$this->hChanged['sat'] = $hHsb['sat'];
		$this->hChanged['bri'] = $hHsb['bri'];
		return $this;
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
		# also list the default transitiontime
		if ( !isset( $this->hState['transitiontime'] ) )
		{
			$this->hState['transitiontime'] = 400;
		}
	}

	public function timing ($fTiming)
	{
		if ( null === $fTiming )
		{
			return $this->fTiming;
		}
		else
		{
			$fTiming = max(0.1, $fTiming);
			$fOldTiming = $this->fTiming;
			$this->fTiming = $fTiming;
			return $fOldTiming;
		}
	}

	public function toggle ()
	{
		$this->hChanged['on'] = !$this->state('on');
		$this->write();
	}

	public function transition ($iTransitiontime = null)
	{
		if ( null === $iTransitiontime )
		{
			return $this->hState['transitiontime'];
		}
		else
		{
			$iOldTime = $this->hState['transitiontime'];
			$this->hState['transitiontime'] = $iTransitiontime;
			return $iOldTime;
		}
	}

	public function write ()
	{
		$fNow = microtime(true);
		$fDiff = $fNow - $this->fLastWrite;
		if ( $this->fTiming > $fDiff )
		{
			usleep(( $this->fTiming - $fDiff ) * 1000000);
		}
		$this->fLastWrite = microtime(true);

		$sPath = "lights/{$this->iLightID}/state";
		$this->hChanged['transitiontime'] = $this->hState['transitiontime'];
		$this->oRest->put($sPath, $this->hChanged);
		$this->hState = array_merge($this->hState, $this->hChanged);
		$this->hChanged = [];
	}
}