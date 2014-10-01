<?php
/**
 * @author Vasil Stoychev (ludesign.bg@gmail.com)
 * @author Dincho Todorov
 * @version 1.0
 * @created Jan 24, 2009 8:45:01 PM
 *
 */

class prHomePageEffect
{
    private $_sourceImage = null, $_newImage = null, $_rgb = array(), $_hsl = array();

    protected $_imageHeight = 0, $_imageWidth = 0, $_newHueValue = 25, $_newSaturationValue = 27;

    public function __construct($im)
    {
        $this->_sourceImage = $im;
        $this->_imageHeight = imagesy($this->_sourceImage);
        $this->_imageWidth = imagesx($this->_sourceImage);
        $this->_newImage = imagecreatetruecolor($this->_imageWidth, $this->_imageHeight);

        return $this;
    }

    public function setHue($hue)
    {
        $this->_newHueValue = intval($hue);

        return $this;
    }

    public function setSaturation($saturation)
    {
        $this->_newSaturationValue = intval($saturation);

        return $this;
    }

    /**
     * Set both hue and saturation values
     *
     * @param  integer          $hue
     * @param  integer          $saturation
     * @return prHomepageEffect
     */
    public function setHueSaturation($hue, $saturation)
    {
        $this->setHue($hue);
        $this->setSaturation($saturation);

        return $this;
    }

    /**
     * Proccess the effect
     *
     * @return prHomepageEffect
     */
    public function process()
    {
        for ($x = 0; $x < $this->_imageWidth; $x ++) {
            for ($y = 0; $y < $this->_imageHeight; $y ++) {
                $rgb = imagecolorat($this->_sourceImage, $x, $y);

                /**
                 * Extract R G B values!
                 */
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;

                $this->rgb2hsl($r, $g, $b);
                $this->hsl2rgb();

                $color = imagecolorallocate($this->_newImage, $this->_rgb[0], $this->_rgb[1], $this->_rgb[2]);

                imagesetpixel($this->_newImage, $x, $y, $color);
            }
        }

        return $this;
    }

    public function getImg()
    {
        return $this->_newImage;
    }

    public function rgb2hsl($r, $g, $b)
    {
        $r = $r / 255;
        $g = $g / 255;
        $b = $b / 255;

        $max = max($r, max($g, $b));
        $min = min($r, min($g, $b));

        $delta = $max - $min;
        $sum = $max + $min;

        $h = 0;
        $s = 0;

        $l = ($max + $min) / 2;

        if ($delta != 0) {
            if ($l < 0.5) {
                $s = $delta / $sum;
            } elseif ($l >= 0.5) {
                $s = $delta / (2 - $delta);
            }

            $dr = ((($max - $r) / 6) + ($delta / 2)) / $delta;
            $dg = ((($max - $g) / 6) + ($delta / 2)) / $delta;
            $db = ((($max - $b) / 6) + ($delta / 2)) / $delta;

            if ($max == $r) {
                $h = $db - $dg;
            } elseif ($max == $g) {
                $h = (1 / 3) + $dr - $db;
            } elseif ($max == $b) {
                $h = (2 / 3) + $dg - $dr;
            }

            if ($h < 0)
                $h += 1;
            if ($h > 1)
                $h -= 1;
        }

        $h *= 360;

        $this->_hsl = array($h, $s, $l);
    }

    public function hsl2rgb()
    {
        $h = !is_null($this->_newHueValue) ? $this->_newHueValue : $this->_hsl[0] ;
        //$h = ! is_null($this->_newHueValue) ? ((180 + $this->_newHueValue) / 360) : $this->_hsl[0];
        $s = ! is_null($this->_newSaturationValue) ? ($this->_newSaturationValue / 100) : $this->_hsl[1];
        $l = $this->_hsl[2];

        if ($s == 0) {
            $r_c = $g_c = $b_c = $l;
        } else {

            if ($l < 0.5) {
                $temp2 = $l * (1.0 + $s);
            } elseif ($l >= 0.5) {
                $temp2 = $l + $s - $l * $s;
            }

            $temp1 = 2.0 * $l - $temp2;

            $h /= 360;

            $r_temp = $h + (1.0 / 3.0);
            $g_temp = $h;
            $b_temp = $h - (1.0 / 3.0);

            $r_temp = $this->normalizeColor($r_temp);
            $g_temp = $this->normalizeColor($g_temp);
            $b_temp = $this->normalizeColor($b_temp);

            $r_c = $this->calculateColor($r_temp, $temp1, $temp2);
            $g_c = $this->calculateColor($g_temp, $temp1, $temp2);
            $b_c = $this->calculateColor($b_temp, $temp1, $temp2);
        }

        $red = $r_c * 255;
        $green = $g_c * 255;
        $blue = $b_c * 255;

        $this->_rgb = array($red, $green, $blue);
    }

    protected function normalizeColor($temp)
    {
        if ($temp < 0) {
            $temp += 1.0;
        } elseif ($temp > 1) {
            $temp -= 1.0;
        }

        return $temp;
    }

    protected function calculateColor($temp, $temp1, $temp2)
    {
        if ((6.0 * $temp) < 1) {
            $color = $temp1 + ($temp2 - $temp1) * 6.0 * $temp;
        } elseif ((2.0 * $temp) < 1) {
            $color = $temp2;
        } elseif ((3.0 * $temp) < 2) {
            $color = $temp1 + ($temp2 - $temp1) * ((2.0 / 3.0) - $temp) * 6.0;
        } else {
            $color = $temp1;
        }

        return $color;
    }
}
