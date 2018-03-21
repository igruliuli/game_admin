<?php

namespace app\libraries\games;

class FortuneFast extends Fortune
{

    const NAME = 'fortuna3min';

    public function getAbbr()
    {
        return self::GAME_FORTUNE_FAST_ABBR;
    }

    public function getName()
    {
        return 'Fortune Fast';
    }
}