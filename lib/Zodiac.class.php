<?php
/*
			id	signs			date start			date end
			1	aquarius		from 21 Gennaio 	to 18 Febbraio
			2	aries			from 21 Marzo 		to 20 Aprile
			3	cancer			from 22 Giugno 		to 22 luglio
			4	capricon		from 22 Dicembre 	to 20 gennaio
			5	gemini			from 22 Maggio 		to 22 giugno
			6	leo			    from 22 Luglio 		to 21 agosto
			7	libra			from 24 Settembre 	to 23 ottobre
			8	pisces			from 19 Febbraio 	to 20 marzo
			9	Sagittarius		from 22 Novembre 	to 22 dicembre
			10	scorpio		    from 24 Ottobre 	to 21 novembre
			11	taurus			from 21 Aprile 		to 21 Maggio
			12	virgo			from 24 Agosto 		to 23 settembre

*/
class Zodiac
{
    private $error = '';
    private $sign = '';
    
    
    public function __construct($day, $month)
    {
        $this->parseDate($day, $month);
    }
    
    public function parseDate($day, $month)
    {
        $this->error = (($day > 31) || ($day < 0)) ? "not valid day" : "";
        $this->error = (($month > 12) || ($month < 0)) ? "not valid month" : "";
        switch ($month) {
            case 1:
                $this->sign = ($day <= 20) ? "Capricorn" : "Aquarius";
                break;
            case 2:
                $this->error = ($day > 29) ? "February has less than " . $day . " days" : "";
                $this->sign = ($day <= 18) ? "Aquarius" : "Pisces";
                break;
            case 3:
                $this->sign = ($day <= 20) ? "Pisces" : "Aries";
                break;
            case 4:
                $this->error = ($day > 30) ? "April has less than " . $day . " days" : "";
                $this->sign = ($day <= 20) ? "Aries" : "Taurus";
                break;
            case 5:
                $this->sign = ($day <= 21) ? "Taurus" : "Gemini";
                break;
            case 6:
                $this->error = ($day > 30) ? "June has less than " . $day . " days" : "";
                $this->sign = ($day <= 22) ? "Gemini" : "Cancer";
                break;
            case 7:
                $this->sign = ($day <= 22) ? "Cancer" : "Leo";
                break;
            case 8:
                $this->sign = ($day <= 21) ? "Leo" : "Virgo";
                break;
            case 9:
                $this->error = ($day > 30) ? "September has less than " . $day . " days" : "";
                $this->sign = ($day <= 23) ? "Virgo" : "Libra";
                break;
            case 10:
                $this->sign = ($day <= 23) ? "Libra" : "Scorpio";
                break;
            case 11:
                $this->error = ($day > 30) ? "November has less than " . $day . " days" : "";
                $this->sign = ($day <= 21) ? "Scorpio" : "Sagittarius";
                break;
            case 12:
                $this->sign = ($day <= 22) ? "Sagittarius" : "Capricorn";
                break;
        }
    }
    
    public function getSign()
    {
        return $this->sign;
    }
    
    public function hasError()
    {
        return (isset($this->error) && $this->error != "") ? true : false;
    }

    public function getError()
    {
        return $this->error;
    }
}
