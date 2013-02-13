<?

echo 'WHY NOT <Br><Br>';
$lmFlag='true';
   $continuousFlag='true';
   $doEndpointing='true';
   $CmnBatchFlag='true';
   $fullfilepath = 'obama_short.mp3';
   $upload_url = 'http://spokentech.net/speechcloud/SpeechUploadServlet';
   $params = array(
     'lmFlag'=>$lmFlag,
     'continuousFlag'=>$continuousFlag ,
     'doEndpointing'=>$doEndpointing ,
     'CmnBatchFlag'=>$CmnBatchFlag ,
     'audio'=>"@$fullfilepath"
   );       
   set_time_limit(0); 
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_VERBOSE, 1);
   curl_setopt($ch, CURLOPT_TIMEOUT, 300);
   curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
   curl_setopt($ch, CURLOPT_URL, $upload_url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
   $response = curl_exec($ch);
   echo "$response";
   curl_close($ch);
   
?>