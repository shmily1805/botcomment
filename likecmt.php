﻿<?php
set_time_limit(0);
error_reporting(0);
$token = 'EAAAAUaZA8jlABALZAvDzuHM0Vr1NJbYN0aW9YOSrCNCmghOt0iU1xpEicKWrF7WMZC4sKcZCJzt9rHkbWI6Yoo6a0MV8xhNcTreBhDWfOcuiL8H2TjReq72AcZA62dosiPNZBtRJ5UetjvDKbabquK5hrAaBS8iXAZD'; /*̉Bỏ Token Full Quyền Vào*/
$camsuc = 'LOVE';  /* icon cần thả nếu bạn muốn cảm súc là haha thì sửa lại lại : vd> $camsuc = 'LIKE'; thành $camsuc = 'HAHA' ( các cảm xúc cần chọn 'LIKE','WOW','LOVE','ANGRY','HAHA','SAD','PRIDE'*/
$limit = '10';  /* sô bài cần like & CMT*/
$post = json_decode(request('https://graph.facebook.com/me/home?fields=id,message,created_time,from&limit=' . $limit . '&access_token=' . $token), true); /* Get Data Post*/
$timelocpost = date('Y-m-d');
$logpost     = file_get_contents("log.txt");
for ($i = 0; $i < 100; $i++) {
    $idpost      = $post['data'][$i]['id'];
	#nếu bạn không thích bot vào ai đó, bỏ id người ta vào, tìm id ở https://findmyfbid.com/ có id rồi bỏ vào 
	if ($idpost != '100003880469096' && $idpost != '' && $idpost != '' && $idpost != '' && $idpost != '' && $idpost != '' && $idpost != '' && $idpost != '' && $idpost != '' && $idpost != '' ) { 
    $messagepost = $post['data'][$i]['message'];
    $time        = $post['data'][$i]['created_time'];
    $getinfo_user = json_decode(request('https://graph.facebook.com/' . $idpost . '?access_token=' . $token), true);
    $name = $getinfo_user["from"]["name"];
	/* Check time Post */
    if (strpos($time, $timelocpost) !== false) {
			/* Check trùng  */
            if (strpos($logpost, $idpost) === FALSE) {
				/* Send Comment  */
                $comment = 'Mời bạn qua wall tham khảo mỹ phẩm cao cấp Natural spa makeup Sala. ' . "\n\n" . 'Tuyển đại lý, sỉ, ctv toàn quốc 😚😚😚';
				request('https://graph.fb.me/' . urlencode($idpost) . '/reactions?type=' . $camsuc . '&method=post&access_token=' . $token);
                $luulog = fopen("log.txt", "a");
                fwrite($luulog, $idpost . "\n");
                fclose($luulog);
            } else {
                echo 'CMT Thành Công';
            }
        }
        
    }
}
//đây là like bài viết
for ($i = 0; $i < 100; $i++) {
    $idpost      = $post['data'][$i]['id'];
    $time        = $post['data'][$i]['created_time'];
	/* Check time Post */
    if (strpos($time, $timelocpost) !== false) {
		/* Check hashtag */
			/* Check trùng  */
            if (strpos($logpost, $idpost) === FALSE) {
				/* Send Comment  */
				request('https://graph.facebook.com/' . urlencode($idpost) . '/comments?method=post&message=' . urlencode($comment) . '&access_token=' . $token);
                $luulog = fopen("log.txt", "a");
                fwrite($luulog, $idpost . "\n");
                fclose($luulog);
            } else {
                echo 'like thành công';
            }
    }
}
exec("php test.php"); /* Chạy lại file  */
function request($url)
{
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        return FALSE;
    }
    
    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_HEADER => FALSE,
        CURLOPT_FOLLOWLOCATION => TRUE,
        CURLOPT_ENCODING => '',
        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.87 Safari/537.36',
        CURLOPT_AUTOREFERER => TRUE,
        CURLOPT_CONNECTTIMEOUT => 15,
        CURLOPT_TIMEOUT => 15,
        CURLOPT_MAXREDIRS => 5,
        CURLOPT_SSL_VERIFYHOST => 2,
        CURLOPT_SSL_VERIFYPEER => 0
    );
    
    $ch = curl_init();
    curl_setopt_array($ch, $options);
    $response  = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    unset($options);
    return $http_code === 200 ? $response : FALSE;
}
?>