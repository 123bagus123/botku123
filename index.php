<?php
/*
copyright @ medantechno.com
Modified by Ilyasa
2017
*/
require_once('./line_class.php');

$channelAccessToken = 'G2hldU7hJe9r2LlUMxG/8FWD0DBzEVJ2hXqvOJTPLb4xE95SfsydamF7gtnLNTSl4NKSv8wFOmo33HWe+dhubnkcp7pSC83v/FppZET/tMAdTSrJM5Xp1AerX0KwB6THWHqMa4zYDwTkwBf/FA3NhAdB04t89/1O/w1cDnyilFU='; //Your Channel Access Token
$channelSecret = '9fe539004edb9bce756f6cbc71441289';//your Channel Secret

$client = new LINEBotTiny($channelAccessToken, $channelSecret);

$userId 	= $client->parseEvents()[0]['source']['userId'];
$replyToken = $client->parseEvents()[0]['replyToken'];
$message 	= $client->parseEvents()[0]['message'];
$profil = $client->profil($userId);
$pesan_datang = $message['text'];

if($message['type']=='sticker')
{	
	$balas = array(
							'UserID' => $profil->userId,	
                                                        'replyToken' => $replyToken,							
							'messages' => array(
								array(
										'type' => 'text',									
										'text' => 'Ahh 4p4nchin 4la41 134nget deg ngirim stiker ya gak bos@degus'										
									
									)
							)
						);
						
}

if($message['type']=='voice')
{	
	$balas = array(
							'UserID' => $profil->userId,	
                                                        'replyToken' => $replyToken,							
							'messages' => array(
								array(
										'type' => 'voice',									
										'voice' => 'https://www.youtube.com/watch?v=ZMsvwwp6S7Q'										
									
									)
							)
						);
						
}

else
$pesan=str_replace(" ", "%20", $pesan_datang);
$key = '31f5dd09-49fe-4508-8c36-715d5d23bdc9';//API SimSimi
$url = 'http://sandbox.api.simsimi.com/request.p?key='.$key.'&lc=id&ft=1.0&text='.$pesan;
$json_data = file_get_contents($url);
$url=json_decode($json_data,1);
$diterima = $url['response'];
if($message['type']=='text')
{
if($url['result'] == 404)
	{
		$balas = array(
							'UserID' => $profil->userId,	
                                                        'replyToken' => $replyToken,													
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => 'Ehh anjing... gak maukan kalau creator gua marah ?? @degus'
									)
							)
						);
				
	}
else
if($url['result'] != 100)
	{
		
		
		$balas = array(
							'UserID' => $profil->userId,
                                                        'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => 'Maaf '.$profil->displayName.' Maaf semuanya ane butuh donasi ni... server lagi down so.. donate ya.'
									)
							)
						);
				
	}
	else{
		$balas = array(
							'UserID' => $profil->userId,
                                                        'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => ''.$diterima.''
									)
							)
						);
						
	}
}
 
$result =  json_encode($balas);

file_put_contents('./reply.json',$result);


$client->replyMessage($balas);
