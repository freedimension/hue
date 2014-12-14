<?php
namespace freedimension\hue;

/**
 * Color conversions made easy
 *
 * @method array hsb() Get color as HSB
 * @method array web() Get color as a named webcolor (if available)
 * @method array rgb() Get color as RGB
 * @method array cie() Get color as CIE
 *
 * @package freedimension\hue
 */
class color
{
	const TYPE_HEX = 'hex';
	const TYPE_HSB = 'hsb';
	const TYPE_RGB = 'rgb';
	const TYPE_WEB = 'web';
	const TYPE_CIE = 'cie';
	protected $sType          = '';
	protected $mColor         = '';
	protected $hWebColor      = [
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
	protected $hDetour        = [
		'hex2cie' => 'rgb',
		'hex2hsb' => 'rgb',
		'hsb2cie' => 'rgb',
		'hsb2hex' => 'rgb',
		'hsb2web' => 'rgb',
		'rgb2web' => 'hex',
		'web2cie' => 'rgb',
		'web2hsb' => 'hex',
		'web2rgb' => 'hex',
	];
	protected $hColorFunction = [
		'hsb',
		'web',
		'rgb',
		'cie',
	];

	public function __construct ($mColor)
	{
		if ( is_string($mColor) )
		{
			$mColor = strtolower($mColor);
			if ( isset( $this->hWebColor[$mColor] ) )
			{
				$this->web($mColor);
			}
			elseif ( '#' === substr($mColor, 0, 1) )
			{
				$this->hex($mColor);
			}
		}
		elseif ( is_array($mColor) )
		{
			$hMap = [
				'rgb' => [
					'red',
					'green',
					'blue'
				],
				'hsb' => [
					'hue',
					'sat',
					'bri'
				],
				'cie' => [
					'x',
					'y'
				],
			];
			foreach ($hMap as $sType => $aKeys)
			{
				$hIntersect = array_intersect_key($mColor, array_flip($aKeys));
				if ( count($aKeys) === count($hIntersect) )
				{
					$this->{$sType}($hIntersect);
					break;
				}
			}
		}
	}

	public function __call (
		$sMethod,
		$aArguments
	){
		# Standard assignment for color spaces that need no further treatment.
		# Implement dedicated method for special treatments!
		if ( in_array($sMethod, $this->hColorFunction) )
		{
			if ( 0 === count($aArguments[0]) )
			{
				return $this->convert($sMethod);
			}
			else
			{
				$this->mColor = $aArguments[0];
				$this->sType = $sMethod;
			}
		}
		# Color conversions that can't be done directly,
		# i.e. the color has to be first translated into another form in order to be translated to the asked for
		elseif ( isset( $this->hDetour[$sMethod] ) )
		{
			$mValue = $aArguments[0];
			list ( $sSource, $sTarget ) = explode('2', $sMethod);
			$sDetourMethod = "{$sSource}2{$this->hDetour[$sMethod]}";
			$mCarry = $this->{$sDetourMethod}($mValue);

			$sDetourMethod = "{$this->hDetour[$sMethod]}2{$sTarget}";
			$mResult = $this->{$sDetourMethod}($mCarry);

			return $mResult;
		}
	}

	public function cie2rgb ($hCie)
	{
	}

	public function hex ($sHex = null)
	{
		if ( null === $sHex )
		{
			return '#' . $this->convert(self::TYPE_HEX);
		}
		else
		{
			$sHex = trim($sHex, '#');
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
			$this->sType = self::TYPE_HEX;
			$this->mColor = $sHex;
		}
	}

	public function hex2rgb ($sHex)
	{
		$sHex = trim($sHex, '#');
		list( $mRed, $mGreen, $mBlue ) = str_split($sHex, 2);
		$hRgb = [
			'red'   => hexdec($mRed),
			'green' => hexdec($mGreen),
			'blue'  => hexdec($mBlue)
		];
		return $hRgb;
	}

	public function hex2web ($sHex)
	{
		$sHex = trim($sHex, '#');
		$sMap = array_flip($this->hWebColor);
		return $sMap[$sHex];
	}

	public function hsb2rgb ($hHsb)
	{
		$fHue = ( $hHsb['hue'] / 65535 ) * 360;
		$fSat = $hHsb['sat'] / 255;
		$fBri = $hHsb['bri'] / 255;

		$fC = ( 1.0 - abs(2 * $fBri - 1.0) ) * $fSat;
		$fX = $fC * ( 1.0 - abs(fmod(( $fHue / 60.0 ), 2) - 1.0) );
		$fM = $fBri - ( $fC / 2.0 );

		if ( $fHue < 60 )
		{
			$fRed = $fC;
			$fGreen = $fX;
			$fBlue = 0;
		}
		else if ( $fHue < 120 )
		{
			$fRed = $fX;
			$fGreen = $fC;
			$fBlue = 0;
		}
		else if ( $fHue < 180 )
		{
			$fRed = 0;
			$fGreen = $fC;
			$fBlue = $fX;
		}
		else if ( $fHue < 240 )
		{
			$fRed = 0;
			$fGreen = $fX;
			$fBlue = $fC;
		}
		else if ( $fHue < 300 )
		{
			$fRed = $fX;
			$fGreen = 0;
			$fBlue = $fC;
		}
		else
		{
			$fRed = $fC;
			$fGreen = 0;
			$fBlue = $fX;
		}

		$fRed = ( $fRed + $fM ) * 255;
		$fGreen = ( $fGreen + $fM ) * 255;
		$fBlue = ( $fBlue + $fM ) * 255;

		return [
			'red'   => floor($fRed),
			'green' => floor($fGreen),
			'blue'  => floor($fBlue)
		];
	}

	public function rgb2cie ($hRgb)
	{
		$fRed = $hRgb['red'] / 255;
		$fGreen = $hRgb['green'] / 255;
		$fBlue = $hRgb['blue'] / 255;

		$fX = 0.4124 * $fRed + 0.3576 * $fGreen + 0.1805 * $fBlue;
		$fY = 0.2126 * $fRed + 0.7152 * $fGreen + 0.0722 * $fBlue;
		$fZ = 0.0193 * $fRed + 0.1192 * $fGreen + 0.9505 * $fBlue;

		return [
			'x' => $fX / ( $fX + $fY + $fZ ),
			'y' => $fY / ( $fX + $fY + $fZ )
		];
	}

	public function rgb2hex ($hRgb)
	{
		$sResult = "";
		foreach ([
			'red',
			'green',
			'blue'
		] as $sKey)
		{
			$sResult .= str_pad(dechex($hRgb[$sKey]), 2, "0", STR_PAD_LEFT);
		}
		return $sResult;
	}

	public function rgb2hsb ($hRgb)
	{
		$mRed = $hRgb['red'] / 255;
		$mGreen = $hRgb['green'] / 255;
		$mBlue = $hRgb['blue'] / 255;

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

	public function web2hex ($sWebColor)
	{
		return $this->hWebColor[$sWebColor];
	}

	protected function convert ($sType)
	{
		if ( $this->sType !== $sType )
		{
			$sMethod = "{$this->sType}2{$sType}";
			return $this->{$sMethod}($this->mColor);
		}
		else
		{
			return $this->mColor;
		}
	}
}