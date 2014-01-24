<?php

class prReverseQueryBuilder extends prSearchQueryBuilder
{
    protected function getFunctions()
    {
        $memberAnswers = MemberDescAnswerPeer::getAnswersAssoc($this->member->getId());
        $functions = array();

        foreach ($memberAnswers as $idx => $answer) {
            if (1 === $idx) { //age
                $functions[] = $this->getRangeFunction($idx, $this->member->getAge());
                continue;
            }

            if (12 === $idx || 13 === $idx) { //range searches (Weight & Height)
                $functions[] = $this->getRangeFunction($idx, $answer->getDescAnswerId());
                continue;
            }

            if (16 === $idx && $answer->getCustom()) { //native lang
                $functions[] = $this->getTermFunction($idx, $answer->getCustom());
                continue;
            }

            if (17 === $idx) { //other langs
                $functions[] = $this->getTermFunction($idx, (bool) $answer->getOtherLangs());
                continue;
            }

            if ($answer->getDescAnswerId()) {
                $functions[] = $this->getTermFunction($idx, $answer->getDescAnswerId());
            }
        }

        return $functions;
    }

    protected function getRangeFunction($idx, $value)
    {
        $questionKey = 'search_criteria.q' . $idx;
        $key1 = $questionKey . '.answer1';
        $key2 = $questionKey . '.answer2';

        return array(
            'filter' => array(
                'and' => array(
                    array(
                        'numeric_range' => array(
                            $key1 => array(
                                'lte' => $value,
                            ),
                        ),
                    ),
                    array(
                        'numeric_range' => array(
                            $key2 => array(
                                'gte' => $value,
                            ),
                        ),
                    ),
                ),
            ),
            'script_score' => array(
                'script' => "_score + doc['" . $questionKey . ".weight'].value",
            ),
        );
    }

    protected function getTermFunction($idx, $value)
    {
        $questionKey = 'search_criteria.q' . $idx;
        $answersKey = $questionKey . '.answers';

        return array(
            'filter' => array(
                'term' => array(
                    $answersKey => $value,
                ),
            ),
            'script_score' => array(
                'script' => "_score + doc['" . $questionKey . ".weight'].value",
            ),
        );
    }
}
