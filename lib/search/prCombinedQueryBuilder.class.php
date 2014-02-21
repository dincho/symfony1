<?php

class prCombinedQueryBuilder extends prScoreQueryBuilder
{
    public function __construct(Member $member)
    {
        parent::__construct($member);

        $this->straightBuilder = new prStraightQueryBuilder($member);
        $this->reverseBuilder = new prReverseQueryBuilder($member);
    }

    protected function getFunctions()
    {
        return array_merge(
            $this->straightBuilder->getFunctions(),
            $this->reverseBuilder->getFunctions()
        );
    }
}
