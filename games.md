## Keno ##

### Operation Bet ###

**Request**

`http://d228.default-host.net/srvloto.ashx?ul=&up=&oper=bet&stp=1&stv=12%3B41%3B68&coe=0&sum=500&itr=372610&tri=1&sid=7&che=&key=964983141`

`ul:
up:
oper:bet
stp:1
stv:12;41;68
coe:0
sum:500
itr:372610
tri:1
sid:7
che:
key:964983141`

## Fortune Live (3 min) ##

### Round results ###

**Request**

`http://91.192.116.108:3303/clnt.ashx?ida=1&idh=0&ps=qww`

**Response**

`
    {
        "tir":569141, // round number
        "ball":9,
        "t2":139, // time to finish
        "fb":9, // this is result
        "v1":1,"fs":1,"bf":0, "m1n":"14", "m2n":"13", "m3n":"11", "m4n":"11", "m5n":"11", "m6n":"11", "m1c":"20", "m2c":"9", "m3c":"17", "m4c":"23", "m5c":"25","m6c":"29","mn1n":"3", "mn2n":"4", "mn3n":"4", "mn4n":"5", "mn5n":"5","mn6n":"5","mn1c":"16", "mn2c":"13", "mn3c":"19", "mn4c":"4", "mn5c":"6","mn6c":"27","b120":{"0":8,"1":8,"2":9,"3":8,"4":5,"5":8,"6":5,"7":7,"8":9,"9":13,"10":6,"11":8,"12":10,"13":4,"14":9,"15":9,"16":3,"17":11,"18":8,"19":4,"20":14,"21":10,"22":10,"23":11,"24":10,"25":11,"26":9,"27":5,"28":5,"29":11,"30":7,"31":6,"32":9,"33":6,"34":8,"35":7,"36":9},
        "jp1":"-",
        "jp2":"-"
    }
`


### Bet (3 red) ###

**Request**
 
`http://91.192.116.108:3301/srvloto.ashx?ida=1&idh=0&ps=qww&ul=&up=&oper=bet&stp=1&stv=3&coe=3600&sum=500&itr=569140&tri=1&sid=6&che=&key=9270518`

`ida:1
idh:0
ps:qww
ul:
up:
oper:bet
stp:1
stv:3
coe:3600
sum:500
itr:569140
tri:1
sid:6 // game number?
che:
key:927051858`

**Response**

`{
    "status":"success",
    "key":158471944,
    "st":"Ставки приняты",
    "fiscalsum":0,
    "code":"1436845805691",
    "bt":"0",
    "da":"17.01.2017 16:49:08",
    "sicbo":{"max":"0"},
    "rulinbet":{"max":"0"},
    "kenoinbet":{"max":"0"},
    "keno2inbet":{"max":"0"},
    "kenoblue":{"max":"0"},
    "kenoem3":{"max":"0"},"dog6":{"max":"0"},"rulem":{"max":"0"},"rulem2":{"max":"0"},"rul":{"bet":{"0":{"lp":0,"jp":0,"lgt":0,"tir":569140,"dact":"17.01.2017 16:49:08",
    "nm":"3", "cf":"3600","sm":"500","wn":"0", "st":"1","id":"143684580","dp":"-"}},"max":"1"},
    "poker1":{"max":"0"},"poker2":{"max":"0"},"poker3":{"max":"0"},"keno":{"max":"0"},"kenoem2":{"max":"0"},"kenoem":{"max":"0"},"kenog":{"max":"0"},
    "cltbal":0,"limit":"12000","cassir":"131769","user":"-","bw":"0","as":"500","aw":"0","trslt":"Не окончен","inf":"-","tb":"1","mb":"1"
}`

### Bet (all red) ###

`http://91.192.116.108:3301/srvloto.ashx?ida=1&idh=0&ps=qww&ul=&up=&oper=bet&stp=1&stv=47&coe=200&sum=500&itr=569148&tri=1&sid=6&che=&key=1584719`

`ida:1
idh:0
ps:qww
ul:
up:
oper:bet
stp:1
stv:47
coe:200
sum:500
itr:569148
tri:1
sid:6
che:
key:158471944`

**Response**

`
{
    "status":"success",
    "key":149977863,
    "st":"Ставки приняты",
    "fiscalsum":0,
    "code":"1436960545691",
    "bt":"0",
    "da":"17.01.2017 17:09:30",
    "sicbo":{"max":"0"},
    "rulinbet":{"max":"0"},"kenoinbet":{"max":"0"},"keno2inbet":{"max":"0"},"kenoblue":{"max":"0"},"kenoem3":{"max":"0"},"dog6":{"max":"0"},"rulem":{"max":"0"},"rulem2":{"max":"0"},"rul":{"bet":{"0":{"lp":0,"jp":0,"lgt":0,"tir":569148,"dact":"17.01.2017 17:09:30","nm":"47", "cf":"200","sm":"500","wn":"0", "st":"1","id":"143696054","dp":"-"}},"max":"1"},"poker1":{"max":"0"},"poker2":{"max":"0"},"poker3":{"max":"0"},"keno":{"max":"0"},"kenoem2":{"max":"0"},"kenoem":{"max":"0"},"kenog":{"max":"0"},"cltbal":0,"limit":"11500","cassir":"131769","user":"-","bw":"0","as":"500","aw":"0","trslt":"Не окончен","inf":"-","tb":"1","mb":"1"}
`

### Bet (all black) ###

**Request**

`http://91.192.116.108:3301/srvloto.ashx?ida=1&idh=0&ps=qww&ul=&up=&oper=bet&stp=1&stv=48&coe=200&sum=500&itr=569149&tri=1&sid=6&che=&key=149977863`

`ida:1
 idh:0
 ps:qww
 ul:
 up:
 oper:bet
 stp:1
 stv:48
 coe:200
 sum:500
 itr:569149
 tri:1
 sid:6
 che:
 key:149977863`
 
 **Response**
 
`{"status":"success","key":12092194,"st":"Ставки приняты","fiscalsum":0,"code":"1436986915691","bt":"0","da":"17.01.2017 17:13:47","sicbo":{"max":"0"},"rulinbet":{"max":"0"},"kenoinbet":{"max":"0"},"keno2inbet":{"max":"0"},"kenoblue":{"max":"0"},"kenoem3":{"max":"0"},"dog6":{"max":"0"},"rulem":{"max":"0"},"rulem2":{"max":"0"},"rul":{"bet":{"0":{"lp":0,"jp":0,"lgt":0,"tir":569149,"dact":"17.01.2017 17:13:47","nm":"48", "cf":"200","sm":"500","wn":"0", "st":"1","id":"143698691","dp":"-"}},"max":"1"},"poker1":{"max":"0"},"poker2":{"max":"0"},"poker3":{"max":"0"},"keno":{"max":"0"},"kenoem2":{"max":"0"},"kenoem":{"max":"0"},"kenog":{"max":"0"},"cltbal":0,"limit":"11000","cassir":"131769","user":"-","bw":"0","as":"500","aw":"0","trslt":"Не окончен","inf":"-","tb":"1","mb":"1"}`
 
### Bet (Sector #1) ###
 
**Request**

`http://91.192.116.108:3301/srvloto.ashx?ida=1&idh=0&ps=qww&ul=&up=&oper=bet&stp=1&stv=100_104_123_26&coe=1800_1800_1800_3600&sum=625_625_625_625&itr=569151_569151_569151_569151&tri=1&sid=6_6_6_6&che=&key=12092194`

`ida:1
 idh:0
 ps:qww
 ul:
 up:
 oper:bet
 stp:1
 stv:100_104_123_26
 coe:1800_1800_1800_3600
 sum:625_625_625_625
 itr:569151_569151_569151_569151
 tri:1
 sid:6_6_6_6
 che:
 key:12092194`

**Response**
`{"status":"success","key":164120205,"st":"Ставки приняты","fiscalsum":0,"code":"1437014625691","bt":"0","da":"17.01.2017 17:17:44","sicbo":{"max":"0"},"rulinbet":{"max":"0"},"kenoinbet":{"max":"0"},"keno2inbet":{"max":"0"},"kenoblue":{"max":"0"},"kenoem3":{"max":"0"},"dog6":{"max":"0"},"rulem":{"max":"0"},"rulem2":{"max":"0"},"rul":{"bet":{"0":{"lp":0,"jp":0,"lgt":0,"tir":569151,"dact":"17.01.2017 17:17:44","nm":"100", "cf":"1800","sm":"625","wn":"0", "st":"1","id":"143701462","dp":"-"},"1":{"lp":0,"jp":0,"lgt":0,"tir":569151,"dact":"17.01.2017 17:17:44","nm":"104", "cf":"1800","sm":"625","wn":"0", "st":"1","id":"143701463","dp":"-"},"2":{"lp":0,"jp":0,"lgt":0,"tir":569151,"dact":"17.01.2017 17:17:44","nm":"123", "cf":"1800","sm":"625","wn":"0", "st":"1","id":"143701464","dp":"-"},"3":{"lp":0,"jp":0,"lgt":0,"tir":569151,"dact":"17.01.2017 17:17:44","nm":"26", "cf":"3600","sm":"625","wn":"0", "st":"1","id":"143701465","dp":"-"}},"max":"4"},"poker1":{"max":"0"},"poker2":{"max":"0"},"poker3":{"max":"0"},"keno":{"max":"0"},"kenoem2":{"max":"0"},"kenoem":{"max":"0"},"kenog":{"max":"0"},"cltbal":0,"limit":"8500","cassir":"131769","user":"-","bw":"0","as":"2500","aw":"0","trslt":"Не окончен","inf":"-","tb":"4","mb":"4"}`

### History ###

`http://91.192.116.108:3303/history.ashx?ida=1&idh=0&ps=qww`

`{"b0":4,"b1":36,"b2":11,"b3":22,"b4":0,"b5":2,"b6":9,"b7":5,"b8":27,"b9":22,"b10":26,"b11":0,"b12":8,"b13":7,"b14":19,"b15":1,"b16":8,"b17":24,"b18":19,"b19":34,"b20":17,"b21":34,"b22":1}`

## History ##

`http://91.192.116.108:3301/srvloto.ashx?ul=&up=&key=120292134&dt1=2017-01-22+08%3A00%3A00&dt2=2017-01-22+23%3A59%3A00&che=-`

`ul:
 up:
 key:120292134
 dt1:2017-01-22 08:00:00
 dt2:2017-01-22 23:59:00
 che:-
 oper:info
 payel:allwin
 isnon:1`
 
`{
    "status":"success",
    "key":0,
    "code":"-",
    "bt":"1",
    "da":"01.01.-10  00:00:00",
    "sicbo":{"max":"0"},
    "kenoblue":{"max":"0"},
    "rulinbet":{"max":"0"},
    "kenoinbet":{"max":"0"},
    "keno2inbet":{"max":"0"},
    "dog6":{"max":"0"},
    "rulem":{"max":"0"},
    "rulem2":{"max":"0"},
    "rul":{
        "bet":{
            "0":{"lp":"","jp":0,"lgt":0,"code":1455740475716,"tir":571675,"dact":"22.01.17  12:16:11","nm":"39", "cf":"300","sm":"500","wn":"0", "st":"1","id":"145574047","dp":"-"},
            "1":{"lp":"","jp":0,"lgt":0,"code":1455734285716,"tir":571674,"dact":"22.01.17  12:14:07","nm":"21", "cf":"3600","sm":"500","wn":"0", "st":"2","id":"145573428","dp":"-"}
            },
        "max":"2"
        },
    "poker1":{"max":"0"},
    "poker2":{"max":"0"},
    "poker3":{"max":"0"},
    "kenoem3":{"max":"0"},
    "kenoem":{"max":"0"},
    "kenoem2":{"max":"0"},
    "keno":{"max":"0"},
    "kenog":{"max":"0"},
    "fiscaltyp":0,
    "fiscalsum":0,
    "cltbal":0,
    "limit":"7500",
    "cassir":"131769",
    "user":"-",
    "faststate":1,
    "bw":"0",
    "as":"1000",
    "np":0,
    "aw":"0",
    "trslt":"0",
    "inf":"",
    "st":"Info",
    "tb":"2",
    "mb":"2"
}`