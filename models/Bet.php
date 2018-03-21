<?php

namespace app\models;

use app\libraries\games\Game;
use app\libraries\games\Keno;
use app\libraries\helpers\DateTimeHelper;
use app\modules\user\models\User;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\db\Query;

/**
 * @property integer $id
 * @property integer $user_id
 * @property string $created_at
 * @property string $updated_at
 * @property float $amount
 * @property float $win_amount
 * @property integer $result
 * @property array $user_bet - json object with user choice (e.g. array of number)
 * @property integer $round_id - reference to the bet's game round
 * @property integer $game_id - unique game ID
 * @property integer $status - bet status
 * @property integer $user_paid_id - user who paid bet
 * @property string $paid_date
 *
 * @property User $user
 * @property BetOperation[] $operations
 */
class Bet extends ActiveRecord
{
    const RESULT_WIN = 1;
    const RESULT_LOSS = 2;
    const RESULT_CANCELED = 3;
    const RESULT_NOT_READY = 0;

    const STATUS_UNPAID = 0;
    const STATUS_PAID = 1;

    public static function tableName()
    {
        return '{{bets}}';
    }

    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);

        foreach($this->operations as $operation) {
            // задаём членам id команды
            $operation->bet_id = $this->id;
            $operation->save();
        }
    }

    public static function getStatusStr($status)
    {
        $statuses = [
            self::RESULT_NOT_READY => 'not_ready',
            self::RESULT_WIN => 'win',
            self::RESULT_LOSS => 'loss',
            self::RESULT_CANCELED => 'cancel',
        ];

        return $statuses[$status];
    }

    public function beforeSave($insert)
    {
        $this->updated_at = (new \DateTime())->format('Y-m-d H:i:s');

        return parent::beforeSave($insert);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getOperations()
    {
        return $this->hasMany(BetOperation::className(), ['bet_id' => 'id']);
    }

    public function getRound()
    {
        $round = GameRound::findOne(['id' => $this->round_id]);

        return $round;
    }

    /**
     * Get data for reports
     */
    public function getReportData($timezone)
    {
        $cssClass = '';

        if ($this->result == self::RESULT_LOSS) {
            $cssClass = 'blue';
        }

        if ($this->result == self::RESULT_WIN) {
            if ($this->status == self::STATUS_PAID) {
                $cssClass = 'green';
            } else {
                $cssClass = 'red';
            }
        }

        $createdAt = new \DateTime($this->created_at);

        $createdAt = DateTimeHelper::applyDateTimeOffset($createdAt, $timezone);

        $paidDate = '';

        if ($this->status == self::STATUS_PAID) {
            $paidDate = new \DateTime($this->paid_date);
            $paidDate = DateTimeHelper::applyDateTimeOffset($paidDate, $timezone);
            $paidDate = $paidDate->format('Y-m-d H:i:s');
        }

        return [
            'id' => $this->id,
            'stamp' => $createdAt->format('Y-m-d H:i:s'),
            'class' => $cssClass,
            'uid' => $this->user_id,
            'betAmount' => $this->amount,
            'realWin' => self::getStatusStr($this->result),
            'acc_id' => $this->user->account_id,
            'possibleWin' => $this->win_amount,
            'pay_stamp' => $paidDate,
            'pay_amount' => $this->win_amount

            // "id":786292336,
            // "stamp":"2016-12-20 13:40:17",
            // "pay_amount":"",
            // "pay_stamp":"",
            // "cid":0,
            // "uid":30247,
            // "puid":"",
            // "client_id":0,
            // "acc_id":21568,
            // "betAmount":200,
            // "possibleWin":0,
            // "realWin":"not_ready"
        ];
    }

    public function getKassaInfoData()
    {
        $createdAt = new \DateTime($this->created_at);

        // выигрыш, не выплачено
        // {"lp":"","jp":0,"lgt":0,"code":1508564745774,"tir":577445,"dact":"02.02.17  11:06:40","nm":"38", "cf":"300","sm":"500","wn":"1500", "st":"4","id":"150856475","dp":"-"}
        // выигрыш, выплачено
        // {"lp":"t1740k01","jp":0,"lgt":1,"code":1436960545691,"tir":569148,"dact":"17.01.17  17:09:30","nm":"47", "cf":"200","sm":"500","wn":"1000", "st":"3","id":"143696054","dp":"23.01.17  16:12:46"}

        $st = 3;

        if ($this->result == self::RESULT_NOT_READY) {
            $st = 1;
        }

        if ($this->result == self::RESULT_WIN && $this->status == self::STATUS_UNPAID) {
            $st = 4;
        }

        $paidDate = '-';

        if ($this->status == self::STATUS_PAID) {
            $paidDate = (new \DateTime($this->paid_date))->format('d.m.y  H:i:s');
        }

        return [
            'lp' => '',
            //'lp' => 'test',
            'jp' => 0,
            'lgt' => 0,
            'code' => $this->getFormattedCode(),
            'tir' => $this->round_id,
            'dact' => $createdAt->format('d.m.y  H:i:s'),
            "nm" => "1",
            "cf" => "3600",
            'sm' => $this->amount * 100,
            'wn' => $this->win_amount * 100,
            "st" => $st,
            "id" => $this->id,
            "dp" => $paidDate
        ];
    }

    public function getCheckData()
    {
        $game = Game::getGameById($this->game_id);

        return [
            "lp" => 0,
            "jp" => 0,
            "lgt" => 0,
            "tir" => $this->round_id,
            "dact" => (new \DateTime($this->created_at))->format('d.m.y  H:i:s'),
            'nm' => implode('_', $this->getBets()),
            'cf' => ($game->getFactor($this->getBets(), $this->round_id) * 100),
            'sm' => ($this->amount * 100),
            // TODO: ?
            'wn' => 0,
            // TODO: ?
            'st' => 1,
            'id' => $this->getFormattedCode(),
            // TODO: ?
            'dp' => '-'
        ];
    }

    public function getOperationsInfo()
    {
        $result = [];

        foreach ($this->operations as $operation) {
            $result[] = $operation->getInfo();
        }

        return $result;
    }

    public function getFormattedCode()
    {
        return sprintf('%013d', $this->id);
    }

    /**
     * Calculate profit and update Bet status
     */
    public function processResults()
    {
        $round = $this->getRound();

        $results = json_decode($round->results);

        $game = Game::getGameById($this->game_id);

        $profit = 0;

        foreach ($this->operations as $operation) {
            $operationProfit = $game->getResult($operation, $results);
            if ($operationProfit > 0) {
                $operation->result = BetOperation::RESULT_WIN;
                $operation->win_amount = $operationProfit;
            } else {
                $operation->result = BetOperation::RESULT_LOSS;
            }

            $operation->save();

            $profit += $operationProfit;
        }

        if ($profit > 0) {
            $this->result = Bet::RESULT_WIN;
            $this->win_amount = $profit;
            //$this->user->account->addBalance($profit);
        } else {
            $this->result = Bet::RESULT_LOSS;
        }

        $this->save();
    }

    public function getBets()
    {
        return json_decode($this->user_bet);
    }

    /**
     * @param BetOperation[] $operations
     */
    public function getAmountFromOperations($operations)
    {
        $amount = 0;

        foreach ($operations as $operation) {
            $amount += $operation->amount;
        }

        return $amount;
    }

    /**
     * @param BetOperation[] $operations
     */
    public function saveOperations($operations)
    {
        foreach ($operations as $operation) {
            $operation->bet_id = $this->id;
            $operation->save();
        }
    }

    /**
     * @return array
     */
    public static function getReport($accounts, $start, $end)
    {
        $endDate = (new \DateTime($end))->add(new \DateInterval('P1D'));

        $query = new Query();
        $records = $query
            ->select([
                new Expression("to_char(created_at, 'YYYY-MM-DD') as date"),
                new Expression("SUM(amount) as bet_sum"),
                new Expression("COUNT(bets.id) as bet_count"),
                // paid bets count
                new Expression(
                    "COUNT(CASE WHEN status = :status THEN 1 ELSE NULL END) as paid_count",
                    [':status' => self::STATUS_PAID]
                ),
                // paid sum
                new Expression(
                    "SUM(CASE WHEN status = :status THEN (0 - win_amount) ELSE 0 END) as paid_sum",
                    [':status' => self::STATUS_PAID]
                )
            ])
            ->from('bets')
            ->innerJoin('users', 'bets.user_id = users.id')
            ->where(['in', 'users.account_id', $accounts])
            ->andWhere(['between', 'created_at', $start, $endDate->format('Y-m-d')])
            ->groupBy('date')
            ->orderBy(['date' => SORT_DESC])
            ->all();

        return $records;
    }

    public static function getExtendedReport($accounts, $start, $end)
    {
        $query = new Query();
        $records = $query
            ->select([
                'game_id as source',
                'accounts.currency',
                // total sum
                new Expression('SUM(bets.amount) as total_in'),
                // paid sum
                new Expression(
                    "SUM(CASE WHEN bets.status = :status THEN win_amount ELSE 0 END) as total_out",
                    [':status' => self::STATUS_PAID]
                ),
                new Expression("COUNT(bets.id) as cnt"),
            ])
            ->from('bets')
            ->innerJoin('users', 'bets.user_id = users.id')
            ->innerJoin('accounts', 'accounts.id = users.account_id')
            ->where(['in', 'users.account_id', $accounts])
            ->andWhere(['between', 'bets.created_at', $start, $end])
            ->groupBy(['game_id', 'currency'])
            ->all();

        $records = array_map(function ($item) {
            $item['name'] = Game::getGameById($item['source'])->getName();
            $item['perc'] = 0;
            $item['total_in'] = (float)$item['total_in'];
            $item['delta'] = (float)($item['total_in'] - $item['total_out']);
            return $item;
        }, $records);

        return $records;
    }

    public static function getExtendedChartData($accounts, $start, $end)
    {
        $query = new Query();
        $records = $query
            ->select([
                new Expression("to_char(bets.created_at, 'YYYY-MM-DD') as date"),
                new Expression("SUM(bets.amount) as total_in"),
                'game_id',
                'accounts.currency',
                // paid sum
                new Expression(
                    "SUM(CASE WHEN bets.status = :status THEN win_amount ELSE 0 END) as total_out",
                    [':status' => self::STATUS_PAID]
                )
            ])
            ->from('bets')
            ->innerJoin('users', 'bets.user_id = users.id')
            ->innerJoin('accounts', 'accounts.id = users.account_id')
            ->where(['in', 'users.account_id', $accounts])
            ->andWhere(['between', 'bets.created_at', $start, $end])
            ->groupBy(['bets.game_id', 'currency', 'date'])
            ->orderBy(['date' => SORT_DESC])
            ->all();

        $records = array_map(function ($item) {
            $item['name'] = Game::getGameById($item['game_id'])->getName();
            unset($item['game_id']);
            $item['total_in'] = (float)$item['total_in'];
            $item['delta'] = (float)($item['total_in'] - $item['total_out']);
            return $item;
        }, $records);

        return $records;
    }

    public static function getAccountsReport($accounts, $start, $end)
    {
        $query = new Query();
        $records = $query
            ->select([
                'users.account_id as acc_id',
                new Expression("SUM(bets.amount) as total_in"),
                new Expression("COUNT(bets.id) as cnt"),
                'game_id as source',
                // paid sum
                new Expression(
                    "SUM(CASE WHEN bets.status = :status THEN win_amount ELSE 0 END) as total_out",
                    [':status' => self::STATUS_PAID]
                )
            ])
            ->from('bets')
            ->innerJoin('users', 'bets.user_id = users.id')
            ->where(['in', 'users.account_id', $accounts])
            ->andWhere(['between', 'bets.created_at', $start, $end])
            ->groupBy(['acc_id', 'bets.game_id'])
            ->all();

        $records = array_map(function ($item) {
            $item['total_in'] = (float)$item['total_in'];
            $item['total_out'] = (float)$item['total_out'];
            $item['delta'] = (float)($item['total_in'] - $item['total_out']);
            return $item;
        }, $records);

        return $records;
    }

    public static function getKassirReport($accounts, $start, $end)
    {
        $query = new Query();
        $records = $query
            ->select([
                'users.account_id as acc_id',
                new Expression("SUM(bets.amount) as total_in"),
                new Expression("COUNT(bets.id) as cnt"),
                // paid sum
                new Expression(
                    "SUM(CASE WHEN bets.status = :status THEN win_amount ELSE 0 END) as total_out",
                    [':status' => self::STATUS_PAID]
                )
            ])
            ->from('bets')
            ->innerJoin('users', 'bets.user_id = users.id')
            ->where(['in', 'users.id', $accounts])
            ->andWhere(['between', 'bets.created_at', $start, $end])
            ->groupBy(['acc_id'])
            ->all();

        $records = array_map(function ($item) {
            $item['total_in'] = $item['total_in']*100;
            $item['total_out'] = $item['total_out']*100;
            $item['delta'] = ($item['total_in'] - $item['total_out']);
            return $item;
        }, $records);

        return $records;
    }
    /**
     * @param User $user
     */
    public function pay($user)
    {
        if ($this->win_amount > 0){
            $user->account->addBalance($this->win_amount);
        }else{
            $user->account->addBalance($this->amount);
        }


        $this->status = Bet::STATUS_PAID;
        $this->paid_date = (new \DateTime())->format('Y-m-d H:i:s');
        $this->user_paid_id = $user->id;
        $this->save();
    }

    public function cancel()
    {

    }
}