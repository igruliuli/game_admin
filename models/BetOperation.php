<?php

namespace app\models;

use app\libraries\games\Game;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property integer $bet_id
 * @property array $user_bet
 * @property float $amount
 * @property float $win_amount
 * @property integer $result
 *
 * @property Bet $bet
 */
class BetOperation extends ActiveRecord
{
    const RESULT_WIN = 1;
    const RESULT_LOSS = 2;
    const RESULT_CANCELED = 3;
    const RESULT_NOT_READY = 0;

    public static function tableName()
    {
        return '{{bet_operations}}';
    }

    public function getBet()
    {
        return $this->hasOne(Bet::className(), ['id' => 'bet_id']);
    }

    public function getBets()
    {
        return json_decode($this->user_bet);
    }

    public function getInfo()
    {
        $game = Game::getGameById($this->bet->game_id);
        $st = 3;

        if ($this->result == self::RESULT_NOT_READY) {
            $st = 1;
        }

        if ($this->result == self::RESULT_WIN && $this->bet->status == Bet::STATUS_UNPAID) {
            $st = 4;
        }

        $paidDate = '-';

        if ($this->bet->status == Bet::STATUS_PAID) {
            $paidDate = (new \DateTime($this->bet->paid_date))->format('d.m.y  H:i:s');
        }

        return [
            "lp" => 0,
            "jp" => 0,
            "lgt" => 0,
            'code' => $this->bet_id,
            "tir" => $this->bet->round_id,
            "dact" => (new \DateTime($this->bet->created_at))->format('d.m.y  H:i:s'),
            'nm' => implode(';', $this->getBets()),
            'cf' => ($game->getFactor($this->getBets(), $this->bet->round_id) * 100),
            'sm' => ($this->amount * 100),
            'wn' => $this->win_amount * 100,
            'st' => $st,
            'id' => $this->id,
            'dp' => $paidDate
        ];
    }
}