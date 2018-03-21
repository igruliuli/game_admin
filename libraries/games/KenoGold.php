<?php

namespace app\libraries\games;

class KenoGold extends Keno
{
    const NAME = 'kenoGold';

    public function getAbbr()
    {
        return self::GAME_KENO_GOLD_ABBR;
    }

    public function getName()
    {
        return 'KENO GOLD';
    }
}