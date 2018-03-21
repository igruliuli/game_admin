<?php

namespace app\libraries\games;

class KenoJX extends Keno
{
    const NAME = 'JxKeno';

    public function getAbbr()
    {
        return self::GAME_KENO_JX_ABBR;
    }

    public function getName()
    {
        return 'JX Keno';
    }
}