<?php
/*
* Sau đây là danh sách mã lỗi
*
* 100 | error | Thiếu thông tin gửi lên
* 101 | error | Chưa nhập APIKey
* 102 | error | Chưa nhập số điện thoại người nhận
* 103 | error | APIKey không tồn tại
* 104 | error | Tài khoản không có quyền dùng API
* 105 | error | Chưa liên kết tài khoản
* 109 | error | Hệ thống quá tải
*
* 200 | success | Thành công
*/
require_once("CSM/function.php"); // function gọi là chức năng nhé =))
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$arr = array(
  "APIKey" => '28882d1fb9cdccac9e6d076fb422581e', //lấy apikey tại momo.doicardnhanh.com
  "time" => '24', //lấy dữ liệu trong 24h
);

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://momo.doicardnhanh.com/api/v1/lich-su-giao-dich.asp",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode($arr),
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
  ),
));

$response = json_decode(curl_exec($curl));
curl_close($curl);

$statusId = $response->statusId; //mã lỗi
$status = $response->status; //trạng thái
$msg = $response->msg; //nội dung lỗi
if ($response->status == "success") {
  $transactions = $response->transactions; //thông tin tất cả giao dịch
  $total = $response->total; //tổng số giao dịch lấy được
  if (!empty($transactions)) {
    foreach ($transactions as $k => $value) {
      $transactionId = $value->TransactionId; //mã giao dịch
      $type = $value->type; // 1 = cộng tiền, -1 = trừ tiền
      $partnerId = $value->partnerId; //Id người gửi|người nhận
      $partner = $value->partner; //Tên người gửi|người nhận
      $amount = $value->amount; //số tiền gửi|nhận
      $content = $value->content; //nội dung giao dịch
      $time = $value->time; //thời gian
      if (!empty($partnerId)) {
        if (!empty($content)) {
          $row = db_row("SELECT * FROM momo_history_bank WHERE tranId = '{$transactionId}'");
          if ($row == NULL) {
            $content_db = db_row("SELECT * FROM `setting_mini` WHERE note = '{$content}'");
            if (!empty($content) && $content_db['min'] <= $amount && $content_db['max'] >= $amount) {
              // Thực Hiện Check Nội Dung
              $tach_noidung = explode(' ', strtoupper($content_db['comment']));
              $lenh = $tach_noidung[0];
              db_insert("momo_history_bank", array('kq' => 1, 'NumberPhone' => $partnerId, 'FULL_NAME' => $partner, 'status' => 1, 'partnerId' => $partnerId, 'partnerName' => $partner, 'amount' => $amount, 'comment' => $content, 'tranId' => $transactionId, 'time' => $time, 'game' => $content_db['type']));
              if (!empty($content_db)) {

                $list_array_game01 = array(
                  00 => array('00', $content_db['chietkhau']),
                  01 => array('01', $content_db['chietkhau']),
                  12 => array('12', $content_db['chietkhau']),
                  22 => array('22', $content_db['chietkhau']),
                  33 => array('33', $content_db['chietkhau']),
                  44 => array('44', $content_db['chietkhau']),
                  55 => array('55', $content_db['chietkhau']),
                  66 => array('66', $content_db['chietkhau']),
                  88 => array('88', $content_db['chietkhau']),
                  17 => array('17', $content_db['chietkhau']),
                  27 => array('27', $content_db['chietkhau']),
                  37 => array('37', $content_db['chietkhau']),
                  47 => array('47', $content_db['chietkhau']),
                  57 => array('57', $content_db['chietkhau']),
                  67 => array('67', $content_db['chietkhau']),
                  77 => array('77', $content_db['chietkhau']),
                  87 => array('87', $content_db['chietkhau']),
                  24 => array('24', 3.5),
                  94 => array('94', 3.5),
                );




                $number_one = substr($transactionId, - $content_db['number']);
                if ($content_db['type'] == 'MINI 01') {

                  if (!array_key_exists($number_one, $list_array_game01)) {
                    echo 'Lỗi xảy ra: not array_key_exists';
                  } else {

                    /// THỰC HIỆN CHUYỂN TIỀN KHI TRÚNG
                    $amount = $amount*$content_db['chietkhau'];
                    $bill = array('phone' => $partnerId, 'token' => $transactionId, 'name' => $partner, 'note' => 'Thắng '.$content_db['type'].'', 'amount' => $amount, 'game' => $content_db['type'], 'tranId' => $transactionId);




                  }


                } else if ($content_db['type'] == 'MINI 02') {

                  $list_array_game02 = array(
                    0 => array('0', 2),
                    6 => array('0', 2),
                    7 => array('0', 2),
                    8 => array('0', 2),
                    9 => array('0', 2),
                  );


                  // $slen = count($transactionId);
                  $a = substr($transactionId, -1);
                  $b = substr($transactionId, -2, -1);
                  $c = substr($transactionId, -3, -2);
                  $tong = substr($a+$b+$c, -1);
                  if ($tong == 0 || $tong == 6 || $tong == 7 || $tong == 8 || $tong == 9) {

                    // THỰC HIỆN CHUYỂN TIỀN

                    /// THỰC HIỆN CHUYỂN TIỀN KHI TRÚNG
                    $amount = $amount*$list_array_game02[$tong]['1'];
                    $bill = array('phone' => $partnerId, 'token' => $transactionId, 'name' => $partner, 'note' => 'Thắng '.$content_db['type'].'', 'amount' => $amount, 'game' => $content_db['type'], 'tranId' => $transactionId);



                  } else {}




                } else if ($content_db['type'] == 'MINI 03') {
                  $number_one = substr($transactionId, -1);

                  if ($content == 'T' || $content == 't' || $content == 'x' || $content == 'X') {

                    if (($content) == 'X' || ($content) == 'x') {
                      if ($number_one < '5') {
                        // THỰC HIỆN CHUYỂN TIỀN
                        $amount = $amount*$content_db['chietkhau'];
                        $bill = array('phone' => $partnerId, 'token' => $transactionId, 'name' => $partner, 'note' => 'Thắng '.$content_db['type'].'', 'amount' => $amount, 'game' => $content_db['type'], 'tranId' => $transactionId);

                      }

                    } else if (($content) == 'T' || ($content) == 't') {
                      if ($number_one >= '5') {
                        // THỰC HIỆN CHUYỂN TIỀN
                        $amount = $amount*$content_db['chietkhau'];
                        $bill = array('phone' => $partnerId, 'token' => $transactionId, 'name' => $partner, 'note' => 'Thắng '.$content_db['type'].'', 'amount' => $amount, 'game' => $content_db['type'], 'tranId' => $transactionId);

                      }
                    }

                    //print_R($bill);exit;

                  } else if ($content == 'C' || $content == 'c' || $content == 'l' || $content == 'L') {


                    if ($content == 'C' || $content == 'c') {

                      if ($number_one %2 == 0) {
                        // THỰC HIỆN CHUYỂN TIỀN
                        $amount = $amount*$content_db['chietkhau'];
                        $bill = array('phone' => $partnerId, 'token' => $transactionId, 'name' => $partner, 'note' => 'Thắng '.$content_db['type'].'', 'amount' => $amount, 'game' => $content_db['type'], 'tranId' => $transactionId);

                      }
                    }



                    if ($content == 'l' || $content == 'L') {
                      if ($number_one %2 != 0) {
                        // THỰC HIỆN CHUYỂN TIỀN
                        $amount = $amount*$content_db['chietkhau'];
                        $bill = array('phone' => $partnerId, 'token' => $transactionId, 'name' => $partner, 'note' => 'Thắng '.$content_db['type'].'', 'amount' => $amount, 'game' => $content_db['type'], 'tranId' => $transactionId);

                      }
                    }
                  }
                }
                if ($bill != null) {
                  $receiver = $bill['phone'];
                  $amount = intval($bill['amount']);
                  $content = 'Trả thưởng phiên '.$transactionId.' cho '.$bill['phone'];

                  $arr_1 = array(
                    "APIKey" => $arr['APIKey'],
                    "receiver" => $receiver,
                    "amount" => $amount,
                    "content" => $content,
                  );

                  $curl_1 = curl_init();

                  curl_setopt_array($curl_1, array(
                    CURLOPT_URL => "https://momo.doicardnhanh.com/api/v1/chuyen-tien.asp",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => json_encode($arr_1),
                    CURLOPT_HTTPHEADER => array(
                      "Content-Type: application/json",
                    ),
                  ));

                  $response_1 = json_decode(curl_exec($curl_1));
                  curl_close($curl_1);

                  $statusId_1 = $response->statusId; //mã lỗi
                  $status_1 = $response->status; //trạng thái
                  $msg_1 = $response->msg;
                  if ($response_1->status == "success") {
                    db_update('momo_history_bank', array('status' => 1, 'kq' => 2, 'real_amount' => $bill['amount']), 'tranId = "'.$bill['tranId'].'"');
                    echo 'Đã trả thưởng cho '.$bill['phone'];
                  } else {
                    db_update('momo_history_bank', array('status' => 0, 'kq' => 2, 'real_amount' => $bill['amount']), 'tranId = "'.$bill['tranId'].'"');
                    echo 'Lỗi: Không thể chuyển khoản <br> <br>';
                    //chuyển tiền thất bại
                  }
                } else {
                  echo 'Lỗi xảy ra: Billing';
                }
              }
            }
          }
        }
      }
    }
  } else {
    echo 'Lỗi xảy ra: transactions';
  }
  //lấy thông tin giao dịch thành công
} else {
  print_r('Lỗi: '.$response->msg);
  //lấy thông tin giao dịch thất bại
}