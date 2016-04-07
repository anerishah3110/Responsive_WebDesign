<?php

if (isset($_GET['q']))
{
$user=$_GET['q'];



     $urllink = "http://dev.markitondemand.com/MODApis/Api/v2/Quote/json?symbol=".$user;
        $str=file_get_contents($urllink);

echo ($str);

}
if (isset($_GET['hc']))
{
          $symbol1 = $_GET['hc'];

  $url_detail = "http://dev.markitondemand.com/MODApis/Api/v2/InteractiveChart/json?parameters={'Normalized':false,'NumberOfDays':1095,'DataPeriod':'Day','Elements':[{'Symbol':'".$symbol1."','Type':'price','Params':['ohlc']}]}";
            $json_info = file_get_contents($url_detail);
            //$json_content = json_decode($json_info, true);


echo json_encode($json_info);
}

if (isset($_GET['term']))
{
$user=$_GET['term'];



     $urllink = "http://dev.markitondemand.com/MODApis/Api/v2/Lookup/json?input=".$user;
        $str=file_get_contents($urllink);
     $parsejsondata = json_decode($str, true);
$lookup=array();
foreach($parsejsondata as $item)
{

$sy1=$item["Symbol"];
$name1=$item["Name"];
        $exchange1=$item["Exchange"];
$lookup[]=array(
        'value'=>$sy1,
        'label'=>$sy1.'-'.$name1.'('.$exchange1.')',
);
}

echo json_encode($lookup);


}





if(isset($_GET['symbol_newsfeed'])) {
   $symbol = $_GET['symbol_newsfeed'];
   $accountKey = 'jURMMu8kmEz/8nhRfx8vGhusF/NBvXUPdehc589uNdI';
   $url_detail = "https://api.datamarket.azure.com/Bing/Search/v1/News?Query=";
       //%27.$symbol.'%27&$format=json';
   $request = $url_detail . urlencode( '\'' .$symbol. '\'');
   $request .= '&$format=json';

   $context = stream_context_create(array('http' => array(
                   'request_fulluri' => true,
                   'header'  => "Authorization: Basic " . base64_encode($accountKey . ":" . $accountKey)
                   )
                   ));
   
   $response = file_get_contents($request, 0, $context);
   if ( $response === false )
{
  echo "failed";
}
   $jsonobj = json_decode($response);
   $html_news = "";
   foreach($jsonobj->d->results as $value)
   {  
     $html_news .= "<div class='container-fluid'>";
     $html_news .= "<div class='jumbotron'>";
     $html_news .= "<a target='_blank' href=";
     $html_news .= $value->Url;
     $html_news .=">";
     $html_news .= $value->Title;
     $html_news .= "</a><p>";
     $html_news .= $value->Description;
     $html_news .= "</p><br>";
     $html_news .= "<b>Publisher: ";
     $html_news .= $value->Source;
     $html_news .= "<br><br>";
     $html_news .= "Date: ";
     $timestamp=strtotime($value->Date);
  
     $html_news .= date("j M Y G:i:s",$timestamp);    
     $html_news .= "</b><br><br>";
     $html_news .="</div>";
       $html_news .="</div>";
   }
   echo $html_news;
           
}


?>