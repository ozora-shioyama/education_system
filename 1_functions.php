<?php
function practice0(){
$start=-3.0;
$end=3.0;
$step=1.0;
foreach(range($start,$end,$step)as $theta)
    print($theta . ", ");
}
/*
practice0();
print("\n");
echo "<br>";
*/
function seiki($theta){
    return exp(-$theta*$theta/2)/sqrt(2*M_PI);
}
function seikiBunpu($start,$end,$step){
    $dist=[];
    foreach (range($start,$end,$step)as $theta)
    $dist[]=seiki($theta)*$step;
    return $dist;
}
function practice1(){
    foreach(seikiBunpu(-3,3,1)as $i)
    print($i.",\n");
}
/*
practice1();
*/
function seitouKakuritsu($theta,$a,$b){
    return 1.0/(1.0+exp(-1.7*$a*($theta-$b)));
}
function hannouKakuritsu($x,$theta,$a,$b){
    $p=seitouKakuritsu($theta,$a,$b);
    return pow($p,$x)*pow(1.0-$p,1-$x);
}
function icc($x,$a,$b,$start,$end,$step){
    $iccDist=[];
    foreach(range($start,$end,$step)as $theta)
     $iccDist[]=hannouKakuritsu($x,$theta,$a,$b);
    return $iccDist;     
}
/*
echo"<pre>";
print("hannouKakuritsu(1,0,1,0)=".hannouKakuritsu(1,0,1,0));
echo"</pre>";
*/
/*
echo"<pre>";
print("icc(1,1,0,-3,3,1)\n");
var_dump(icc(1,1,0,-3,3,1));
echo"</pre>";
*/
   
$itemBank=[
    array("a"=>1,"b"=>0),
    array("a=>0.5","b"=>0,3)
];
function bayes($x,$itemBank,$start,$end,$step){
 $n=count($x);
 $thetaDist=range($start,$end,$step);
 $length=count($thetaDist);
 
 $dist=seikiBunpu($start,$end,$step); //p(θ)
 for($i=0;$i<$n;$i++){
     $item =$itemBank[$i];
     $yuudoDist=icc($x[$i],$item["a"],$item["b"]
     ,$start,$end,$step);
     for($t=0;$t<$length;$t++)
        $dist[$t]*=$yuudoDist[$t];
 }
 
 $shuhen=array_sum($dist);
 for($t=0;$t<$length;$t++)
    $dist[$t]/=$shuhen;
  return $dist;
}
function argmax($v){
    return array_search(max($v),$v);
}
function estimation($x,$itemBank,$start,$end,$step){
 $probability=bayes($x,$itemBank,$start,$end,$step);
 $thetaDist=range($start,$end,$step);
 $theta=$thetaDist[argmax($probability)];
 return $theta;
}

/*
echo"<pre>";
print("bayes([1],[array(\"a\"=>1,\"b\"=>0)],-2,2,1)\n");
var_dump(bayes([1],[array("a"=>1,"b"=>0)],-2,2,1));
echo"</pre>";
echo"<pre>";
print("estimation([1],[array(\"a\"=>1,\"b\"=>0)],-2,2,1)=".estimation([1],[array("a"=>1,"b"=>0)],-2,2,1));
echo"</pre>";
*/
/*
function information($theta,$itemBank){
    $info=0.0;
    foreach($itemBank as $item){
        $p=seitouKakuritsu($theta,$item["a"]
        ,$item["b"]);
        $info+=1.7*1.7*$item["a"]*$item["a"]*$p*(1-$p);
    }
    return $info;
}
function error($theta,$itemBank){
    return 1.0/sqrt(information($theta,$itemBank));
}
function testInformation($itemBank,$start,$end,$step){
 $thetaDist=range($start,$end,$step);
 $infoDist=array_pad([],count($thetaDist),0);
 for($t=0;$t<count($thetaDist);$t++)
    $infoDist[$t]=information($thetaDist[$t],$itemBank);
    return $infoDist;
}

function tekiouTest($theta,$itemBank){
    $infoDist=[];
    foreach ($itemBank as $item)
    $infoDist[]=information($theta,[array("a"
    =>$item["a"],"b"=>$item["b"])]);
    return argmax($infoDist);
}


echo"<pre>";
print("information(0,[array(\"a\"=>1,\"b\"=>0)])=".information(0,[array("a"=>1,"b"=>0)]));
echo"</pre>";

function simulation($N, $J) {
    $itemBank = [];
    for($i=0 ; $i < $N ; $i++)//アイテムバンク生成
        $itemBank[] = array("a" => rand(1, 200)/ 100, "b" => rand(-300, 300)/ 100);

    $examinee = [];
    for($j=0 ; $j < $J ; $j++)//受験者生成
        $examinee[] = rand(-300, 300) / 100;

    $error=[];// 各受験者ごとの誤差
    foreach ($examinee as $theta){
        $x=[];// 正誤
        foreach ($itemBank as $test)
            $x[] = seitoukakuritsu($theta, $test["a"], $test["b"]) > rand(0, 100) / 100 ? 1 : 0;
        $error[] = abs($theta - estimation($x, $itemBank, -3, 3, 0.1));
    }
    return array_sum($error) / count($examinee);

}
/*
print("平均誤差:" . simulation(50,100) ."\n");
echo '<br>';
$accuracy=1/simulation(50,100);
print("推定精度:" .$accuracy."\n");
echo'<br>';
*/
#課題1-1 start
/*
function simulation_n($N,$J,$n){
    $x=[];
    $y=[];
    $x[]=$N;
    $x[]=$J;
    for($i=0;$i<$n;$i++){
        $x[]=simulation($N,$J);
        $y[]=simulation($N,$J);
    }
    $average=array_sum($y)/$n;
    $x[]=$average;
    foreach ($x as $xi){
        print($xi. " ,");
    }
}
/*
simulation_n(20,30,5);
echo "<br>";
simulation_n(40,30,5);
echo "<br>";
simulation_n(60,30,5);
echo "<br>";
simulation_n(80,30,5);
echo "<br>";
simulation_n(100,30,5);
echo "<br>";
simulation_n(40,10,5);
echo "<br>";
simulation_n(40,20,5);
echo "<br>";
simulation_n(40,30,5);
echo "<br>";
simulation_n(40,40,5);
echo "<br>";
simulation_n(40,50,5);
echo "<br>";
simulation_n(40,300,5);
echo "<br>";
#課題1-1 end
*/

/*
#課題1-2 start
function weibull($m,$eta){
   return $eta*pow((-log(1-rand(0,99)/100)),1/$m); 
}
function simulation_weibull($N, $J,$m,$eta) {
    $itemBank = [];
    for($i=0 ; $i < $N ; $i++)//アイテムバンク生成
        $itemBank[] = array("a" => weibull($m,$eta), "b" => rand(-300, 300)/ 100);

    $examinee = [];
    for($j=0 ; $j < $J ; $j++)//受験者生成
        $examinee[] = rand(-300, 300) / 100;

    $error=[];// 各受験者ごとの誤差
    foreach ($examinee as $theta){
        $x=[];// 正誤
        foreach ($itemBank as $test)
            $x[] = seitoukakuritsu($theta, $test["a"], $test["b"]) > rand(0, 100) / 100 ? 1 : 0;
        $error[] = abs($theta - estimation($x, $itemBank, -3, 3, 0.1));
    }
    return array_sum($error) / count($examinee);

}
function simulation_weibull_n($N,$J,$n,$m,$eta){
    $x=[];
    $y=[];
    $x[]=$N;
    $x[]=$J;
    $x[]=$m;
    $x[]=$eta;
    for($i=0;$i<$n;$i++){
        $x[]=simulation_weibull($N,$J,$m,$eta);
        $y[]=simulation_weibull($N,$J,$m,$eta);
    }
    $average=array_sum($y)/$n;
    $x[]=$average;
    foreach ($x as $xi){
        print($xi. " ,");
    }
}
simulation_weibull_n(100,30,5,3,1);
echo '<br>';
simulation_weibull_n(100,30,5,3,3);
echo '<br>';
simulation_weibull_n(100,30,5,3,5);
echo '<br>';

#課題1-2 end

#課題1-3 start
function simulation_information($N, $J) {
    $itemBank = [];
    for($i=0 ; $i < $N ; $i++)//アイテムバンク生成
        $itemBank[] = array("a" => rand(1, 200)/ 100, "b" => rand(-300, 300)/ 100);

    $examinee = [];
    for($j=0 ; $j < $J ; $j++)//受験者生成
        $examinee[] = rand(-300, 300) / 100;

    $error=[];// 各受験者ごとの誤差
    $information=[]; //各受験者ごとの情報量
    foreach ($examinee as $theta){
        $x=[];// 正誤
        foreach ($itemBank as $test)
            $x[] = seitoukakuritsu($theta, $test["a"], $test["b"]) > rand(0, 100) / 100 ? 1 : 0;
        $error[] = abs($theta - estimation($x, $itemBank, -3, 3, 0.1));
        $information[]=information($theta,$itemBank);
        $s_error[]=error($theta,$itemBank);
    }
    $average_error=array_sum($error) / count($examinee);
    $average_information=array_sum($information)/count($examinee);
    $average_s_error=array_sum($s_error)/count($examinee);
    print($average_error." ".$average_information." ".$average_s_error);
}
simulation_information(10,30);
simulation_information(50,30);
simulation_information(100,30);
echo "<br>";
function simulation_information_weibull($N, $J,$m,$eta) {
    $itemBank = [];
    for($i=0 ; $i < $N ; $i++)//アイテムバンク生成
        $itemBank[] = array("a" => rand(1, 200)/ 100, "b" => rand(-300, 300)/ 100);

    $examinee = [];
    for($j=0 ; $j < $J ; $j++)//受験者生成
        $examinee[] = weibull($m,$eta);

    $error=[];// 各受験者ごとの誤差
    $information=[]; //各受験者ごとの情報量
    foreach ($examinee as $theta){
        $x=[];// 正誤
        foreach ($itemBank as $test)
            $x[] = seitoukakuritsu($theta, $test["a"], $test["b"]) > rand(0, 100) / 100 ? 1 : 0;
        $error[] = abs($theta - estimation($x, $itemBank, -3, 3, 0.1));
        $information[]=information($theta,$itemBank);
        $s_error[]=error($theta,$itemBank);
    }
    $average_error=array_sum($error) / count($examinee);
    $average_information=array_sum($information)/count($examinee);
    $average_s_error=array_sum($s_error)/count($examinee);
    print($average_error." ".$average_information." ".$average_s_error);
}
simulation_information_weibull(50,30,3,3);
#課題1-3 end
*/











