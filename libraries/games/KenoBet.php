<?php

namespace app\libraries\games;

class KenoBet extends Keno
{
    const NAME = 'KenoBet';

    public function getAbbr()
    {
        return self::GAME_KENO_BET_ABBR;
    }

    public function getName()
    {
        return 'KENOBET';
    }
}