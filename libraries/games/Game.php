<?php

namespace app\libraries\games;

use app\models\BetOperation;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\base\Object;

abstract class Game extends Object
{
    const GAME_KENO_LIVE_ID = 7;
    const GAME_KENO_BET_ID = 9;
    const GAME_KENO_GOLD_ID = 10;
    const GAME_KENO_FAST_ID = 11;
    const GAME_KENO_JX_ID = 19;

    const GAME_FORTUNE_LIVE_ID = 6;
    const GAME_FORTUNE_BET_ID = 8;
    const GAME_FORTUNE_FAST_ID = 13;

    const GAME_KENO_LIVE_ABBR = "keno";
    const GAME_KENO_JX_ABBR = "kenoem3";
    const GAME_KENO_GOLD_ABBR = "kenog";
    const GAME_KENO_FAST_ABBR = "kenoem2";
    const GAME_KENO_BET_ABBR = "kenoem";
    const GAME_KENOEM2_ABBR = "noname";

    const GAME_KENO_LIVE_NAME = "keno4min";
    const GAME_KENO_JX_NAME = "JxKeno";
    const GAME_KENO_GOLD_NAME = "kenoGold";
    const GAME_KENO_FAST_NAME = "keno2min";
    const GAME_KENO_BET_NAME = "KenoBet";

    const GAME_FORTUNE_LIVE_ABBR = "rul";
    const GAME_FORTUNE_BET_ABBR = "rulem";
    const GAME_FORTUNE_FAST_ABBR = "rulem2";

    // not implemented
    const GAME_KENO_BLUE_ABBR = "kenoblue";
    const GAME_SICBO_ABBR = "sicbo";
    const GAME_RULINBET_ABBR = "rulinbet";
    const GAME_KENOINBET_ABBR = "kenoinbet";
    const GAME_KENO2INBET_ABBR = "keno2inbet";
    const GAME_DOG6_ABBR = "dog6";

    const GAME_POKER1_ABBR = "poker1";
    const GAME_POKER2_ABBR = "poker2";
    const GAME_POKER3_ABBR = "poker3";


    /**
     * Check whether bet wins or loses
     * @return boolean
     */
    public function getResult($bet, $results) {
        throw new Exception();
    }

    public function getAbbr() {
        throw new Exception('Implement in child');
    }

    public function getName() {
        throw new Exception('Implement in child');
    }

    /** @return array */
    abstract function prepareBet($rawData);

    /** @return BetOperation[] */
    abstract function createBetOperations($rawData);

    /** @param array $bet */
    abstract function getFactor($bet, $getFactor);

    /**
     * @return Game
     */
    public static function getGameById($id)
    {
        $games = self::getGames();

        if (!array_key_exists($id, $games)) {
            throw new InvalidParamException('Game not found');
        }


        $gameClassName = $games[$id];
        $game = new $gameClassName;
        return $game;
    }

    public static function getGames()
    {
        return [
            self::GAME_FORTUNE_LIVE_ID =>  FortuneLive::class,
            self::GAME_FORTUNE_BET_ID =>  FortuneBet::class,
            self::GAME_FORTUNE_FAST_ID =>  FortuneFast::class,
            self::GAME_KENO_LIVE_ID => KenoLive::class,
            self::GAME_KENO_FAST_ID => KenoFast::class,
            self::GAME_KENO_GOLD_ID => KenoGold::class,
            self::GAME_KENO_BET_ID => KenoBet::class,
            self::GAME_KENO_JX_ID => KenoJX::class,
        ];
    }

    /**
     * @return array
     */
    public static function getGamesAbbrs()
    {
        return [
            self::GAME_FORTUNE_LIVE_ABBR,
            self::GAME_FORTUNE_BET_ABBR,
            self::GAME_FORTUNE_FAST_ABBR,
            self::GAME_KENO_LIVE_ABBR,
            self::GAME_KENO_BLUE_ABBR,
            self::GAME_SICBO_ABBR,
            self::GAME_RULINBET_ABBR,
            self::GAME_KENOINBET_ABBR,
            self::GAME_KENO2INBET_ABBR,
            self::GAME_DOG6_ABBR,
            self::GAME_POKER1_ABBR,
            self::GAME_POKER2_ABBR,
            self::GAME_POKER3_ABBR,
            self::GAME_KENO_BET_ABBR,
            self::GAME_KENOEM2_ABBR,
            self::GAME_KENO_JX_ABBR,
            self::GAME_KENO_GOLD_ABBR,
            self::GAME_KENO_FAST_ABBR,
        ];
    }
}