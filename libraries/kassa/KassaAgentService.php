<?php

namespace app\libraries\kassa;

use app\models\FortuneFastRound;
use app\models\FortuneBetRound;
use yii\httpclient\Client;
use yii\web\CookieCollection;
use yii\web\Session;

class KassaAgentService
{
    const LOGIN = 't1740k01';
    const PASSWORD = 'a2214';

    public $port = '3301';

    private $sessionCookieKey = 'agent-cookie';
    private $authRequired = false;

    /** @var  string Remote server address */
    private $remoteAddress = '91.192.116.108';

    protected function _request($url, $method, $data)
    {
        $client = new Client();
        $request = $client->createRequest()
            ->setMethod($method)
            ->setUrl('http://' . $this->remoteAddress . ':' . $this->port . '/' . $url)
            ->setData($data);

        if ($this->isLoggedIn())  {
            $request->setCookies($this->_getCookies());
        }

        $response = $request->send();

        return $response;
    }

    protected function _getCookies()
    {
        //return \Yii::$app->session->get($this->sessionCookieKey, null);
        $cache = \Yii::$app->cache->get($this->sessionCookieKey);
        if (!$cache) {
            return null;
        }
        $collection = new CookieCollection($cache);
        return $collection;
    }

    /**
     * Authentication method to remote server
     */
    public function login()
    {
        /** @var Session $session */
//        $session = \Yii::$app->session;
//
//        if (!$session->isActive) {
//            $session->open();
//        }

        $response = $this->_request('srvloto.ashx', 'get', [
            'mode' => 0,
            'login' => self::LOGIN,
            'password' => self::PASSWORD,
            'oper' => 'autz'
        ]);

        //$session->set($this->sessionCookieKey, $response->cookies);
        \Yii::$app->cache->set($this->sessionCookieKey, $response->cookies->toArray());

        \Yii::info(var_export($response, 1), 'debug');

        //$data = $response->getData();

        \Yii::info('Login attempt', 'debug');
        //\Yii::info(var_export($data, 1), 'debug');

        //var_dump($data);
    }

    public function isLoggedIn()
    {
        return $this->_getCookies() != null;
    }

    public function sendRequest($url, $method, $data)
    {
        if (!$this->isLoggedIn()) {
            \Yii::info('Try login', 'debug');
            $this->login();
        }

        return $this->_request($url, $method, $data);
    }

    public function sendSecureRequest($url, $method, $data)
    {
        $response = $this->_request($url, $method, $data);
        $content = $response->getContent();
        $decoded = json_decode($content);

        if (is_object($decoded) && property_exists($decoded, 'st') && $decoded->st == 'critical') {
            $this->login();
        }

        return $this->_request($url, $method, $data);
    }

    public function getRoundResults($server)
    {
        $this->port = $server;

        // wft? не совпадает с результатами из истории
        // Keno Live (4 min)
        // http://91.192.116.108:3302/clnt.ashx?ida=1740&idh=0&ps=qwert&trans=1
        // {"tir":361025,"b1":51,"b2":27,"b3":8,"b4":16,"b5":62,"b6":32,"b7":9,"b8":12,"b9":5,"b10":31,"b11":54,"b12":20,"b13":1,"b14":72,"b15":23,"b16":42,"b17":50,"b18":14,"b19":11,"b20":10,"t2":26,"v1":0,"betoff":0,"tk":-1482407725,"str":0,"idv":0,"jp1sw":0,"jp1":30015,"jps1":3}

        // Keno Gold
        // http://91.192.116.108:3309/clnt.ashx?ida=1740&idh=0&ps=qwert&trans=1

        $response = $this->_request('clnt.ashx?ida=1&idh=0&ps=qww', 'get', []);

        return $response->getContent();
    }

    /** Per game methods for round results */


    public function getKenoLiveHistory($startDate, $endDate)
    {
        $this->port = 3301;

        // srv - server number (unique for each game)
        // dt1 - 2016-12-20 15:00:00
        // dt2 - 2016-12-20 23:59
        // r1 - -1
        // r2 - -2
        // lst - 0
        // http://91.192.116.108:3301/srvloto.ashx?oper=grh&srv=10&lst=0&r1=-1&r2=-1&dt1=2016-12-20+00%3A00&dt2=2016-12-20+23%3A59

        // Keno live
        $params = [
            'oper' => 'grh',
            'srv' => 7,
            'lst' => 1,
            'r1' => -1,
            'r2' => -1,
            'dt1' => $startDate,
            'dt2' => $endDate
        ];

        $response = $this->sendSecureRequest('srvloto.ashx?' . http_build_query($params), 'get', []);

        $responseContent = $response->getContent();

        $decoded = json_decode($responseContent);

        //    ["10"]=>
        //    object(stdClass)#46 (3) {
        //    results
        //    ["ball"]=>
        //      string(57) "5,6,10,17,19,22,29,31,34,39,44,45,49,51,53,57,66,72,74,80"
        //    round number
        //    ["tir"]=>
        //      int(360670)
        //      round start date
        //      ["data"]=>
        //      string(19) "21.12.2016 16:44:20"
        //    }


        return $decoded;
    }

    public function getKenoGoldHistory($startDate, $endDate)
    {
        $this->port = 3301;

        // srv - server number (unique for each game)
        // dt1 - 2016-12-20 15:00:00
        // dt2 - 2016-12-20 23:59
        // r1 - -1
        // r2 - -2
        // lst - 0
        // http://91.192.116.108:3301/srvloto.ashx?oper=grh&srv=10&lst=0&r1=-1&r2=-1&dt1=2016-12-20+00%3A00&dt2=2016-12-20+23%3A59

        // Keno gold
        $params = [
            'oper' => 'grh',
            'srv' => 10,
            'lst' => 1,
            'r1' => -1,
            'r2' => -1,
            'dt1' => $startDate,
            'dt2' => $endDate
        ];

        $response = $this->sendSecureRequest('srvloto.ashx?' . http_build_query($params), 'get', []);

        $responseContent = $response->getContent();

        $decoded = json_decode($responseContent);

        //    ["10"]=>
        //    object(stdClass)#46 (3) {
        //    results
        //    ["ball"]=>
        //      string(57) "5,6,10,17,19,22,29,31,34,39,44,45,49,51,53,57,66,72,74,80"
        //    round number
        //    ["tir"]=>
        //      int(360670)
        //      round start date
        //      ["data"]=>
        //      string(19) "21.12.2016 16:44:20"
        //    }


        return $decoded;
    }

    public function getKenoBetHistory()
    {
        // http://91.192.116.108:3308/clnt.ashx?ida=1&idh=0&ps=qwert
        // not ready {"tir":736975,"b1":6,"b2":13,"b3":99,"b4":99,"b5":99,"b6":99,"b7":99,"b8":99,"b9":99,"b10":99,"b11":99,"b12":99,"b13":99,"b14":99,"b15":99,"b16":99,"b17":99,"b18":99,"b19":99,"b20":99,"t2":119,"v1":1,"betoff":1,"tk":239,"str":736975}
        // ready {"tir":736976,"b1":77,"b2":18,"b3":21,"b4":74,"b5":76,"b6":3,"b7":43,"b8":35,"b9":55,"b10":5,"b11":8,"b12":34,"b13":1,"b14":59,"b15":44,"b16":23,"b17":54,"b18":42,"b19":48,"b20":39,"t2":84,"v1":1,"betoff":0,"tk":204,"str":736977}

        $this->port = 3308;

        $params = [
            'ida' => 1,
            'idh' => 0,
            'ps' => 'qwert'
        ];

        $response = $this->sendRequest('clnt.ashx?' . http_build_query($params), 'get', []);

        $responseContent = $response->getContent();

        $decoded = json_decode($responseContent);

        return $decoded;
    }

    public function getFortuneLiveHistory()
    {
        $this->port = 3303;

        $params = [
            'ida' => 1,
            'idh' => 0,
            'ps' => 'qww'
        ];

        $response = $this->sendRequest('clnt.ashx?' . http_build_query($params), 'get', []);

        $responseContent = $response->getContent();

        $decoded = json_decode($responseContent);

        return $decoded;
    }

    public function getFortuneFastHistory()
    {
        $this->port = FortuneFastRound::SERVER_PORT;

        $params = [
            'ida' => 1,
            'idh' => 0,
            'ps' => 'qww'
        ];

        $response = $this->sendRequest('clnt.ashx?' . http_build_query($params), 'get', []);

        $responseContent = $response->getContent();

        $decoded = json_decode($responseContent);

        return $decoded;
    }

    public function getFortuneBetHistory()
    {
        $this->port = FortuneBetRound::SERVER_PORT;

        $params = [
            'ida' => 1,
            'idh' => 0,
            'ps' => 'qww'
        ];

        $response = $this->sendRequest('clnt.ashx?' . http_build_query($params), 'get', []);

        $responseContent = $response->getContent();

        $decoded = json_decode($responseContent);

        return $decoded;
    }
}