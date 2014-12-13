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
	protected $hWebColor   = [
		'aliceblue'            => "f0f8ff",
		'antiquewhite'         => "faebd7",
		'aqua'                 => "00ffff",
		'aquamarine'           => "7fffd4",
		'azure'                => "f0ffff",
		'beige'                => "f5f5dc",
		'bisque'               => "ffe4c4",
		'black'                => "000000",
		'blanchedalmond'       => "ffebcd",
		'blue'                 => "0000ff",
		'blueviolet'           => "8a2be2",
		'brown'                => "a52a2a",
		'burlywood'            => "deb887",
		'cadetblue'            => "5f9ea0",
		'chartreuse'           => "7fff00",
		'chocolate'            => "d2691e",
		'coral'                => "ff7f50",
		'cornflowerblue'       => "6495ed",
		'cornsilk'             => "fff8dc",
		'crimson'              => "dc143c",
		'cyan'                 => "00ffff",
		'darkblue'             => "00008b",
		'darkcyan'             => "008b8b",
		'darkgoldenrod'        => "b8860b",
		'darkgray'             => "a9a9a9",
		'darkgreen'            => "006400",
		'darkkhaki'            => "bdb76b",
		'darkmagenta'          => "8b008b",
		'darkolivegreen'       => "556b2f",
		'darkorange'           => "ff8c00",
		'darkorchid'           => "9932cc",
		'darkred'              => "8b0000",
		'darksalmon'           => "e9967a",
		'darkseagreen'         => "8fbc8f",
		'darkslateblue'        => "483d8b",
		'darkslategray'        => "2f4f4f",
		'darkturquoise'        => "00ced1",
		'darkviolet'           => "9400d3",
		'deeppink'             => "ff1493",
		'deepskyblue'          => "00bfff",
		'dimgray'              => "696969",
		'dodgerblue'           => "1e90ff",
		'firebrick'            => "b22222",
		'floralwhite'          => "fffaf0",
		'forestgreen'          => "228b22",
		'fuchsia'              => "ff00ff",
		'gainsboro'            => "dcdcdc",
		'ghostwhite'           => "f8f8ff",
		'gold'                 => "ffd700",
		'goldenrod'            => "daa520",
		'gray'                 => "808080",
		'green'                => "008000",
		'greenyellow'          => "adff2f",
		'honeydew'             => "f0fff0",
		'hotpink'              => "ff69b4",
		'indianred'            => "cd5c5c",
		'indigo'               => "4b0082",
		'ivory'                => "fffff0",
		'khaki'                => "f0e68c",
		'lavender'             => "e6e6fa",
		'lavenderblush'        => "fff0f5",
		'lawngreen'            => "7cfc00",
		'lemonchiffon'         => "fffacd",
		'lightblue'            => "add8e6",
		'lightcoral'           => "f08080",
		'lightcyan'            => "e0ffff",
		'lightgoldenrodyellow' => "fafad2",
		'lightgray'            => "d3d3d3",
		'lightgreen'           => "90ee90",
		'lightpink'            => "ffb6c1",
		'lightsalmon'          => "ffa07a",
		'lightseagreen'        => "20b2aa",
		'lightskyblue'         => "87cefa",
		'lightslategray'       => "778899",
		'lightsteelblue'       => "b0c4de",
		'lightyellow'          => "ffffe0",
		'lime'                 => "00ff00",
		'limegreen'            => "32cd32",
		'linen'                => "faf0e6",
		'magenta'              => "ff00ff",
		'maroon'               => "800000",
		'mediumaquamarine'     => "66cdaa",
		'mediumblue'           => "0000cd",
		'mediumorchid'         => "ba55d3",
		'mediumpurple'         => "9370db",
		'mediumseagreen'       => "3cb371",
		'mediumslateblue'      => "7b68ee",
		'mediumspringgreen'    => "00fa9a",
		'mediumturquoise'      => "48d1cc",
		'mediumvioletred'      => "c71585",
		'midnightblue'         => "191970",
		'mintcream'            => "f5fffa",
		'mistyrose'            => "ffe4e1",
		'moccasin'             => "ffe4b5",
		'navajowhite'          => "ffdead",
		'navy'                 => "000080",
		'oldlace'              => "fdf5e6",
		'olive'                => "808000",
		'olivedrab'            => "6b8e23",
		'orange'               => "ffa500",
		'orangered'            => "ff4500",
		'orchid'               => "da70d6",
		'palegoldenrod'        => "eee8aa",
		'palegreen'            => "98fb98",
		'paleturquoise'        => "afeeee",
		'palevioletred'        => "db7093",
		'papayawhip'           => "ffefd5",
		'peachpuff'            => "ffdab9",
		'peru'                 => "cd853f",
		'pink'                 => "ffc0cb",
		'plum'                 => "dda0dd",
		'powderblue'           => "b0e0e6",
		'purple'               => "800080",
		'red'                  => "ff0000",
		'rosybrown'            => "bc8f8f",
		'royalblue'            => "4169e1",
		'saddlebrown'          => "8b4513",
		'salmon'               => "fa8072",
		'sandybrown'           => "f4a460",
		'seagreen'             => "2e8b57",
		'seashell'             => "fff5ee",
		'sienna'               => "a0522d",
		'silver'               => "c0c0c0",
		'skyblue'              => "87ceeb",
		'slateblue'            => "6a5acd",
		'slategray'            => "708090",
		'snow'                 => "fffafa",
		'springgreen'          => "00ff7f",
		'steelblue'            => "4682b4",
		'tan'                  => "d2b48c",
		'teal'                 => "008080",
		'thistle'              => "d8bfd8",
		'tomato'               => "ff6347",
		'turquoise'            => "40e0d0",
		'violet'               => "ee82ee",
		'wheat'                => "f5deb3",
		'white'                => "ffffff",
		'whitesmoke'           => "f5f5f5",
		'yellow'               => "ffff00",
		'yellowgreen'          => "9acd32",
	];
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
		$hHsl = [
			'hue' => 0,
			'sat' => 0,
			'bri' => 0,
		];
		$sColor = strtolower($sColor);
		if ( isset( $this->hWebColor[$sColor] ) )
		{
			$sColor = '#' . $this->hWebColor[$sColor];
		}
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
		# Todo: Sicherstellen, dass Hex-String 6 Zeichen lang ist
		list( $mRed, $mGreen, $mBlue ) = str_split($sHex, 2);
		$mRed = hexdec($mRed) / 255;
		$mGreen = hexdec($mGreen) / 255;
		$mBlue = hexdec($mBlue) / 255;

		$fMax = max($mRed, $mGreen, $mBlue);
		$fMin = min($mRed, $mGreen, $mBlue);

		$fBri = ( $fMax + $fMin ) / 2;
		$fDiff = $fMax - $fMin;
		$fHue = 0;
		if ( 0 == $fDiff )
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

	public function transition ($iTime = null)
	{
		if ( null === $iTime )
		{
			return $this->hState['transitiontime'];
		}
		else
		{
			$iOldTime = $this->hState['transitiontime'];
			$this->hState['transitiontime'] = $iTime;
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