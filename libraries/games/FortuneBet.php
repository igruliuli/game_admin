<?php

namespace app\libraries\games;

class FortuneBet extends Fortune
{
    const NAME = 'fortuneBet';

    public function getAbbr()
    {
        return self::GAME_FORTUNE_BET_ABBR;
    }

    public function getName()
    {
        return 'Fortune Bet';
    }
}