<?php

namespace app\libraries\games;

class FortuneLive extends Fortune
{
    const NAME = 'fortuna15min';

    public function getAbbr()
    {
        return self::GAME_FORTUNE_LIVE_ABBR;
    }

    public function getName()
    {
        return 'Fortune Live';
    }
}