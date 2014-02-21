<?php

class prStraightQueryBuilder extends prScoreQueryBuilder
{
    protected function getFunctions()
    {
        $searchCriteriaDescriptions = $this->member->getSearchCritDescsArray();
        $functions = array();

        foreach ($searchCriteriaDescriptions as $idx => $answer) {
            $answers = $answer->getDescAnswersArray();
            
            if (1 === $idx) { //age
                $dateFrom = new DateTime();
                $dateFrom->sub(new DateInterval(sprintf('P%sY', $answers[1] - 1)));
                $dateTo = new DateTime();
                $dateTo->sub(new DateInterval(sprintf('P%sY', $answers[0])));

                $func = $this->getRangeFunction(
                    $idx,
                    $dateFrom->format('Y-m-d'),
                    $dateTo->format('Y-m-d'),
                    $answer->getMatchWeight() - 1
                );
                $functions[] = $func;
                continue;
            }

            if (12 === $idx || 13 === $idx) { //weight, height
                $func = $this->getRangeFunction(
                    $idx,
                    $answers[0],
                    $answers[1],
                    $answer->getMatchWeight() - 1
                );
                $functions[] = $func;
                continue;
            }

            if (16 === $idx) { //lang -> exact match
                $func = $this->getTermFunction(
                    $idx,
                    $this->member->getLanguage(),
                    $answer->getMatchWeight() - 1
                );
                $functions[] = $func;
                continue;
            }

            if (17 === $idx) { //other lang -> boolean exact match
                $func = $this->getTermFunction(
                    $idx,
                    !empty($answers),
                    $answer->getMatchWeight() - 1
                );
                $functions[] = $func;
                continue;
            }

            //other questions
            $func = $this->getTermFunction(
                $idx,
                $answers,
                $answer->getMatchWeight() - 1
            );
            $functions[] = $func;
        }

        return $functions;
    }

    protected function getRangeFunction($idx, $from, $to, $weight)
    {
        $key = 'self_description.q' . $idx;

        return array(
            'filter' => array(
                'range' => array(
                    $key => array(
                        'gte' => $from,
                        'lte' => $to,
                    ),
                ),
            ),
            'script_score' => array(
                'params' => array(
                    'weight' => $weight
                ),
                'script' => '_score + weight',
            ),
        );
    }

    protected function getTermFunction($idx, $value, $weight)
    {
        $key = 'self_description.q' . $idx;
        $termKey = is_array($value) ? 'terms' : 'term';

        return array(
            'filter' => array(
                $termKey => array(
                    $key => $value,
                ),
            ),
            'script_score' => array(
                'params' => array(
                    'weight' => $weight
                ),
                'script' => '_score + weight',
            ),
        );
    }
}
