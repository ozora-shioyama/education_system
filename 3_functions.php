<?php
function questions($i){
  $itemBank=json_decode(file_get_contents("ItemBank.json"),true);
if(isset($itemBank[$i]))return $itemBank[$i];
else return -1;
}

/*
echo"<pre>";
var_dump(questions(0));
echo"</pre>";
*/
session_start();
function kaishi(){//Yは自分の解答,xはわからない:0 誤答: 1としたもの,Sは誤謬率
    $_SESSION["IR"]=array("N"=>0,"I"=>[0],"X"=>[],"Y"=>[],"x"=>[],"T"=>0,"S"=>0,"Jishin"=>[]);
    $_SESSION["IR"]["Mybank"]=[];
    return questions(0);
}
function keizoku($choice){
    $i=$_SESSION["IR"]["I"][$_SESSION["IR"]["N"]];
    $item = array();
    $item =questions($i);
    if($item["id"]==5){
        $_SESSION["IR"]["Jishin"][]=$item["choices"][$choice-1];
    }
    else{
    $_SESSION["IR"]["X"][]=($choice==$item["correct"])?1:0;
    $_SESSION["IR"]["Y"][]=$choice;
    $_SESSION["IR"]["N"]++;
    $_SESSION["IR"]["Mybank"][]=$item;
    $_SESSION["IR"]["T"]=estimation(
        $_SESSION["IR"]["X"],
        $_SESSION["IR"]["Mybank"],-3,3,0.1);
    
    if($choice==5){
        $_SESSION["IR"]["x"][]=0;
    }
    else if($choice==$item["correct"]){
      $_SESSION["IR"]["x"][]=1;   
    }
    else{
      $_SESSION["IR"]["x"][]=2; 
    }
    $count=array_count_values($_SESSION["IR"]["x"]);

    /*
   if($count[2]+$count[1]!=0){ 
    $_SESSION["IR"]["S"]=$count[2]/($count[2]+$count[1]);    
   }
   else
   {
       $_SESSION["IR"]["S"]=-1;
   }*/
   
   }
    $item=questions($i+1);
    if(questions($i)!=-1){ 
      $_SESSION["IR"]["I"][]=$item["id"];
    } 
    return $item;  
}
function owari(){
    
    echo "<table border='1'> ";
    echo   "<tr>";
    echo   "<th>ID</th>";
    echo   "<th colspan='2'>あなたの解答</th>";
    echo    "<th> 正誤</th>";
    echo    "</tr>";
          
     for($i=0;$i<$_SESSION["IR"]["N"];$i++){
     echo "<tr>";
      echo   "<td>".htmlspecialchars($i)."</td>";
      echo "<td>".htmlspecialchars($_SESSION["IR"]["Y"][$i])."</td>";
      $q=questions($i); 
      echo "<td>".htmlspecialchars($q["choices"][$_SESSION["IR"]["Y"][$i]-1])."</td>";
      if($_SESSION["IR"]["X"][$i]==1)
      {$seigo="○";}
      else
      {$seigo="×";}
      echo     "<td>".htmlspecialchars($seigo)."</td>";
      echo     "</tr>";
     }  

     
    echo "<h1>試験は終了です.</h1>";
    echo "あなたの能力値は".$_SESSION["IR"]["T"]."です.<br>";
    echo "正答率".array_sum($_SESSION["IR"]["X"])/$_SESSION["IR"]["N"]."<br>";
    
    /*if($_SESSION["IR"]["S"]!=-1){
    $_SESSION["IR"]["S"]=floor($_SESSION["IR"]["S"]*1000)/1000;
    echo "あなたの誤謬率は".$_SESSION["IR"]["S"]."です<br>";
    }
    else{
      echo "あなたの誤謬率は測定不能です.<br>"; 
    }
    */
    echo " あなたの試験の自信は「".$_SESSION["IR"]["Jishin"][0]."」です<br>";
    unset($_SESSION["IR"]);
    exit;
}
function main(){
    if(isset($_SESSION["IR"]) && isset($_POST["choices"]))
    $item=keizoku($_POST["choices"]);
    else
      $item =kaishi();
    if($item==-1)
       owari();
    return $item;
}


/*
echo "<pre>";
var_dump(main());
echo"</pre>";
*/
?>