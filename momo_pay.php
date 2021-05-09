<?php
/*$phonenhan = '01659302368';
$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJ1c2VyIjoiMDE2OTg4MDQxMTEiLCJpbWVpIjoiODBiNzA3OTMtY2Q3YS00ZDM3LWIyNWQtOGE5YTc2NGIzOTI2IiwiQkFOS19DT0RFIjoiMCIsIkJBTktfTkFNRSI6IiIsIlZBTElEX1dBTExFVF9DT05GSVJNIjozLCJNQVBfU0FDT01fQ0FSRCI6MSwiTkFNRSI6IkRBTkcgUVVPQyBCQUMiLCJJREVOVElGWSI6IkNPTkZJUk0iLCJERVZJQ0VfT1MiOiJBbmRyb2lkIiwiQVBQX1ZFUiI6MjEzNDEsImFnZW50X2lkIjo0ODE0MTY5Nywic2Vzc2lvbktleSI6Ilc3elgzVUZiNEYrcFVESVRSNDdkTzNybGdTZjVqYkJ4Witqb0tkcXkyRlNybW8vZHhaTEFidz09IiwiTkVXX0xPR0lOIjp0cnVlLCJwaW4iOiJmLzB5cWpjUERtST0iLCJwaW5fZW5jcnlwdCI6dHJ1ZSwibGV2ZWwiOjEwMSwiZXhwIjoxNjEyODY2OTI2fQ.XGWoNB09TZnbJnT2nB5J_MjxWgI6PqaOGsrOV9ZePMsQNA9okCPqeLae4LXZnmFn8b2Llx3RjFFklUcfrNZox5eujQyqcNeh5NLaN8qma2ZMv9MAO30IGmzi3Xrh5glv4IfNFHB0KhMhuqPst6iNQ2COkQ_7pRJ0pCgyWfVfLZRdd_9_g_PeXe4xBDm-iErqIibnsUGUvVN0eXf-ChpQmoVgbiulbT6F7bDzJca5cZCO3jJmAZggfFK11KT4tlnlyDEn_MTi7a-iG9moZ5iyPXJFuCaY2RHAmsDHQtmg_ylo7OB19yroPFEiXCrkO0WmhHeiSVVal2MHoR5SXU6NiA';
$sotien = '1000';
$name    = 'Pham Duc Tien';
$noidung = 'hihi';*/

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://owa.momo.vn/api/M2MU_INIT",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_SSL_VERIFYPEER => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",

 CURLOPT_POSTFIELDS =>'{
  "user": "0398804111",
  "msgType": "M2MU_INIT",
  "cmdId": "1612858553920000000",
  "lang": "vi",
  "channel": "APP",
  "time": 1612858553920,
  "appVer": 21511,
  "appCode": "2.1.51",
  "deviceOS": "ANDROID",
  "result": true,
  "errorCode": 0,
  "errorDesc": "",
  "extra": {
    "checkSum": "o/LyPLYEfB5kSpOijKqpd1xOp+kUNQYD51okl2D/LjBqXPNeHn8mji8jCfTfiJZO+gGh0ytjJ7hfUn4WDnzacg=="
  },
  "momoMsg": {
    "_class": "mservice.backend.entity.msg.M2MUInitMsg",
    "ref": "",
    "tranList": [
      {
        "_class": "mservice.backend.entity.msg.TranHisMsg",
        "tranType": 2018,
        "partnerId": "'.$phonenhan.'",
        "originalAmount": '.$sotien.',
        "comment": "'.$noidung.'",
        "moneySource": 1,
        "partnerCode": "momo",
        "partnerName": "'.$name.'",
        "rowCardId": null,
        "serviceMode": "transfer_p2p",
        "serviceId": "transfer_p2p",
        "extras": "{\"vpc_CardType\":\"SML\",\"vpc_TicketNo\":null,\"receiverMembers\":[{\"receiverNumber\":\"'.$phonenhan.'\",\"receiverName\":\"'.$name.'\",\"originalAmount\":'.$sotien.'}],\"loanId\":0,\"contact\":{}}",
        "transferSource": "normal"
      }
    ]
  }
}',
CURLOPT_HTTPHEADER => array(
    "Accept: */*",
    "authorization: Bearer ". $token,
    "Content-Type: application/json"
  ),
));
$response = curl_exec($curl);
$err = curl_error($curl);
print_R($response);
