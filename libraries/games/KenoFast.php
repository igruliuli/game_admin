<?php

namespace app\libraries\games;

class KenoFast extends Keno
{

    const NAME = 'keno2min';

    public function getAbbr()
    {
        return self::GAME_KENO_FAST_ABBR;
    }

    public function getName()
    {
        return 'KENO FAST';
    }
}