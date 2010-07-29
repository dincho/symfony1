<?php
class RandomGenerator
{

    public static function getName($sex = 'm')
    {
        return self::getFirstname($sex) . ' ' . self::getSurname();
    }
    
    public static function getFirstname($sex = 'm')
    {
        $sex = strtolower($sex);
        $male_names = explode(' ', 'Jacob Michael Ethan Joshua Daniel Christopher Anthony William Matthew Andrew Aiden Jayden Caden Noah Jackson Jack Logan Justin Elijah Jaden Jordan Isaiah Brandon Ryan Jason Kevin Eric Vincent Angel David Joseph Nicholas Alexander Benjamin Santiago Sebastian Diego Samuel Nicolas Alejandro Mateo Pablo Gabriel Arjun Aditya Pranav Samir Nikhil Arnav Rishi Rahul');
        $female_names = explode(' ', 'Emily Isabella Emma Ava Madison Sophia Olivia Abigail Hannah Elizabeth Hailey Kaitlyn Addison Kayla Jada Brianna Nevaeh Jayla Taylor Ashley Destiny Gabrielle Chloe Tiffany Jessica Michelle Sarah Rachel Angela Mia Samantha Jennifer Melanie Angelina Kimberly Julia Esther Chaya Sofia Valentina Camila Mariana Valeria Daniela Nicole Paula Natalia Maya Tara Shreya');
        
        $names = ($sex == 'f') ? $female_names : $male_names;
        srand((float) microtime() * 10000000);
        return $names[rand(0, (count($names) - 1))];
    }
    
    public static function getSurname()
    {
        $surnames = explode(' ', 
                'Smith Johnson Williams Brown Jones Miller Davis Garcia Rodriguez Wilson Martinez Anderson Taylor Thomas Hernandez Moore Martin Jackson Thompson White Lopez Lee Gonzalez Harris Clark Lewis Robinson Walker Perez Hall Young Allen Sanchez Wright King Scott Green Baker Adams Nelson Hill Ramirez Campbell Mitchell Roberts Carter Phillips Evans Turner Torres Parker Collins Edwards Stewart Flores Morris Nguyen Murphy Rivera Cook Rogers Morgan Peterson Cooper Reed Bailey Bell Gomez Kelly Howard Ward Cox Diaz Richardson Wood Watson Brooks Bennett Gray James Reyes Cruz Hughes Price Myers Long Foster Sanders Ross Morales Powell Sullivan Russell Ortiz Jenkins Gutierrez Perry Butler Barnes Fisher');
        srand((float) microtime() * 10000000);
        return $surnames[rand(0, (count($surnames) - 1))];
    }
    
    public static function getCity($country = 'US', $state = null)
    {
        
        $cities['US']['AL'] = explode(' ', 'Dothan Decatur Bessemer Birmingham Huntsville Hoover Athens Enterprise');
        $cities['US']['FL'] = explode(' ', 'Jacksonville Miami Tampa St.Petersburg Orlando Hialeah Fort Lauderdale Tallahassee');
        $cities['PL'] = explode(' ', 'Warsaw Kraków Łódź Wrocław Poznań Gdańsk Szczecin Bydgoszcz Lublin Katowice Białystok Gdynia Częstochowa Radom Sosnowiec Toruń Kielce Gliwice Zabrze Bytom Olsztyn Bielsko-Biała Rzeszów Ruda Śląska Rybnik Tychy Dąbrowa Górnicza Płock Opole Elbląg Gorzów Wielkopolski Wałbrzych Włocławek Zielona Góra Tarnów Chorzów Kalisz Koszalin Legnica Grudziądz Słupsk Jastrzębie Zdrój');
        $cities['BG'] = explode(' ', 'City Sofia Plovdiv Varna Burgas Rousse Stara Zagora Pleven Dobrich Sliven Shumen Pernik Haskovo Veliko Tarnovo Yambol Kazanlak Pazardzhik Blagoevgrad Vidin Vratsa Kardzhali Gabrovo Asenovgrad Kyustendil Montana Dimitrovgrad Lovech Silistra Targovishte Dupnitsa Razgrad Gorna Oryahovitsa Petrich Samokov Sandanski Lom Smolyan Svishtov Karlovo Nova Zagora Velingrad Sevlievo Troyan Aytos Botevgrad Gotse Delchev Harmanli Panagyurishte Karnobat Pomorie Peshtera Chirpan Svilengrad');
        
        
        if( !array_key_exists($country, $cities)) throw new Exception('Selected country is not supported');
        if( !is_null($state) )
        {
            if( !array_key_exists($state, $cities[$country])) throw new Exception('Selected state is not supported');
            $fixtures = $cities[$country][$state];
        } else {
            $fixtures = $cities[$country];
        }
        
        srand((float) microtime() * 10000000);
        return $fixtures[rand(0, (count($fixtures) - 1))];
    }

    public static function generate($type = 'p', $num = 5, $maxWords = 20, $minWords = 8, $punctuation = true)
    {
        $string = '';
        switch ($type) {
            // Words
            case 'w':
            case 'words':
                $string = self::getSentence($num, $num, false);
                break;
            // Unordered list
            case 'l':
            case 'ul':
            case 'list':
            // ordered list too!
            case 'ol':
                for ($li = 0; $li < $num; $li ++)
                {
                    $string .= '<li>' . self::getSentence($maxWords, $minWords, $punctuation) . '</li>';
                }
                $string .= ($type == 'ol') ? '<ol>' : '<ul>' . $string . ($type == 'ol') ? '</ol>' : '</ul>';
                break;
            case 'br':
                for ($br = 0; $br < $num; $br ++)
                {
                    $string .= self::getSentence($maxWords, $minWords, $punctuation) . '<br />';
                }
                break;
            // everything else paragraphs
            default:
                for ($p = 0; $p < $num; $p ++)
                {
                    $string .= '<p>' . self::getSentence($maxWords, $minWords, $punctuation) . '</p>';
                }
                break;
        }
        return $string;
    }

    public static function getSentence($maxWords = 10, $minWords = 4, $punctuation = true)
    {
        $words = explode(' ', 
                'lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua ut enim ad minim veniam quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur excepteur sint occaecat cupidatat non proident sunt in culpa qui officia deserunt mollit anim id est laborum');
        $string = '';
        srand((float) microtime() * 10000000);
        $numWords = rand($minWords, $maxWords);
        for ($w = 0; $w < $numWords; $w ++)
        {
            $word = $words[rand(0, (count($words) - 1))];
            $string .= $word;
            // if not the last word, 
            if ($w != ($numWords - 1))
            {
                // 5% chance of a comma...
                if ($punctuation && rand(1, 100) <= 5)
                {
                    $string .= ', ';
                } else
                {
                    $string .= ' ';
                }
            }
        }
        if ($punctuation)
        {
            // 10% chance of a ?...
            if ($punctuation && rand(1, 100) <= 10)
            {
                $string .= '? ';
            } elseif ($punctuation && rand(1, 100) <= 10) // 10% chance of a !...
            {
                $string .= '! ';
            } else
            {
                $string .= '. ';
            }
            $string = ucfirst($string);
        }
        return $string;
    }
}
