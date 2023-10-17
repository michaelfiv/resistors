<!DOCTYPE html>
<html>

<style>
body {
  font-family: 'Courier New', monospace;
}
</style>

<body>

<h1>Resistor, Voltage Divider, Potentiometer Divider</h1>


<form action="?" method="post">
 
Vmax &nbsp&nbsp<input type="decimal" id="Vmaxin" name="Vmaxin"/> 
Vmin &nbsp&nbsp<input type="decimal" id="Vminin" name="Vminin"  /> 
<br>

Vrefmax<input type="decimal" id="Vrefmaxin" name="Vrefmaxin"/> 
Vrefmin<input type="decimal" id="Vrefminin" name="Vrefminin"/> 
<br>

Eseries<input type="text" id="Serin" name="Serin"/> 
<br>

Factor&nbsp<input type="decimal" id="FAC" id="FACin" name="FACin"/> 
<br>

<input type="submit" name="submit" value=">Display Resistors">;

</form>

<?php
$Rtop=$Rbot=$Rtot=$Rtest=$pot=$potest=$Rpar=$Rtopar=$tol=$Rntc=$fak=$fac=$pfac=1.0;
$x=$er=$w=$y=$ser=0;
$Rser="";

define("E12" , [10, 12, 15, 18, 22, 27, 33, 39, 47, 56, 68, 82]);
define("E24" , [10, 11, 12, 13, 15, 16, 18, 20, 22, 24, 27, 30, 33, 36, 39, 43, 47, 51, 56, 62, 68, 75, 82, 91]);
define("EPOT", [10, 20, 30, 50]);


function retRnumber(float $R)
{ $d = 0;
    $d_i = $r_i = $r__i = '';
    $d = floor( log($R,10));
    
    $d_i = number_format($d-1);
    $r__i = sprintf("%E",$R+1E-9);
    ;
    if ($d>0) {  
        $r_i =  substr($r__i,0,1) .  substr($r__i,2,1). $d_i;
    }

    if ($d==0) {  
        $r_i = substr($r__i,0,1) . "R" .   substr($r__i,2,1);
    }
    if ($d==-1) {  
        $r_i = "R" .  substr($r__i,0,1) .  substr($r__i,2,1);
    }

    if ($d < -1) {
        $r_i= "R" . substr("000000",1, abs($d)-1). substr($r__i,0,1) .  substr($r__i,2,1);
        
    }

    return ( $r_i);

}




if (($_SERVER["REQUEST_METHOD"] == "POST") &&
    isset($_POST['Vmaxin']) && 
    isset($_POST['Vminin']) && 
    isset($_POST['Vrefmaxin']) && 
    isset($_POST['Serin']) && 
    isset($_POST['FACin']))
{
    $Vmin = $_POST['Vminin'];
    $Vmax = $_POST['Vmaxin'];
    $Vrefmax = $_POST['Vrefmaxin'];
    $Vrefmin = $_POST['Vrefminin'];
    $Serin = "";
    $Serin=  $_POST['Serin'];   //12;

    if (strpos($Serin, '24') > 0) { $ser = 24;};
    if (strpos($Serin, "12") > 0) { $ser = 12;};
    if (strpos($Serin, "6") > 0) { $ser = 6;};


    $FACS=  $_POST['FACin'];  //10.0;


echo "vmin " . $Vmin ." vmax " . $Vmax . " vrefmax " . $Vrefmax . " vrefmin " . $Vrefmin . " series " . $ser . " factor " . $FACS . "<br>";

// Factor
$rtest = 1.0;
$tol = 1 / (2 * $ser);                          // Tolerance





function retE24(float $R, int $ser) {
    
    $fac_i = 1E-6;
    $w = 0;         // Resistor index
    
    $rtest = 1.0;
    $tol = 1 / (2 * $ser);                          // Tolerance
    do { $fac_i =   $fac_i * 10;}   while ($fac_i < $R);
    $fac_i /= 100;
    
    do 
    {
        $rtest = E24[$w] * $fac_i; // Calculate Rtest
        $w += 24 / $ser; // Increment resistor index

        if ($w > 23) {
            $fac_i *= 10; // Increment factor
            $w = 0; // Reset resistor index
        }
    } while ($rtest <= $R * (1 - $tol)); // Repeat until Rtest is greater than Rtop*(1-tol)
    return ($rtest);
}
function retparE24(float $R,float $rtest, int $ser) {

    $tol = 1 / (2 * $ser);                          //
    $rpar = 0;
    if ($rtest > $R * (1 + $tol)) 
    {
        $rpar = ($R * $rtest) / ($rtest - $R); // Calculate Rpar
    } 
    return ($rpar);
}

function Rformat (float $R, int $ext){
   
    
    if ($R < 0.0001) { 
        $strRtest = " ";} 
      
  
    if (($R > 0.0001) && ($R < 1)) {
        $strRtest =  number_format(($R * 1000) ,0) . "m";
    }
   
  
    if ($R >= 1) {
        $strRtest =  number_format(($R ) ,1) ;
        
        
    }

    if ($R >= 10) {
        $strRtest =  number_format($R ,0) ;
        //$strRtest =   "&nbsp  " . $strRtest;
    }

    if ($R >= 100) {
        $strRtest =  number_format($R ,0) ;
        //$strRtest =   "&nbsp " . $strRtest;
    }
    if ($R >= 1000) {
        $strRtest =  number_format(($R / 1000) ,1) . "k";
        
    }

    if ($R >= 10000) {
        $strRtest =  number_format(($R / 1000) ,$ext) . "k";
    }
    if ($R >= 100000) {
        $strRtest =  number_format(($R / 1000) ,0) . "k";
        
    } 
    if ($R >= 1E6) {
        $strRtest =  "&nbsp " . number_format(($R / 1E6) ,1) . "M";
    }
    if ($R >= 1E7) {
            $strRtest =  number_format(($R / 1E6) ,0) . "M";    
    }
    $l = strlen($strRtest);
    for ($z = $l; $z <= 5; $z++ )
      { $strRtest =   "&nbsp" . $strRtest; }
    //$strRtest = str_pad($strRtest, 7, " ", STR_PAD_LEFT);
    //$strRtest =   "&nbsp" . $strRtest;
    return ($strRtest);
}

function Iformat (float $I){
    $strRtest = number_format($I,3) ;

    if ($I < 1) {
        $strRtest = "&nbsp" . number_format(($I * 1000) ,0) . "mA";
        
    }
    if ($I < 0.1) {
        $strRtest =   number_format(($I * 1000) ,1) . "mA";
        
    }
    if ($I < 1E-3) {
        $strRtest =  number_format(($I * 1E6) ,0) . "uA";
       
    }
 
   // $strRtest = str_pad($strRtest, 8, " ", STR_PAD_LEFT);
    $strRtest =   "&nbsp " . $strRtest;
    return ($strRtest); 

}
function Wformat (float $watt){
    $z = $l = 0;
    $strRtest = number_format($watt,1) . "W" ;

    if ($watt < 1) {
        $strRtest =  number_format(($watt * 1000) ,0) . "mW";
        
    }
    if ($watt < 0.001) {
        $strRtest =   number_format(($watt * 1E6) ,1) . "uW";
        
    }
    if ($watt >= 1E3) {
        $strRtest =  number_format($watt / 1E3 ,1) . "kW";
       
        }
    $l = strlen($strRtest);
   for ($z = $l; $z <= 7; $z++ )
     { $strRtest =   "&nbsp" . $strRtest; }
    return ($strRtest); 

}
 echo " voltage divider <br>";
 echo "&nbsp   TOP &nbsp &nbsp &nbsp LOSS &nbsp &nbsp BOT E24BOT E24PAR <br>";
 
 $y = 0;
for ($x = 0; $x <= 11; $x++) 
    {
        $Rtop = E24[$y] * $FACS;
        $y = $y + (24 / $ser);
        $Rbot = $Vrefmax *$Rtop /($Vmax-$Vrefmax);
        $potest = retE24($Rbot,$ser);
        $pot = retparE24($Rbot,$potest,$ser);
        $pot = retE24($pot,$ser);
        echo Rformat($Rtop,0)  ."(". retRnumber($Rtop) . ")" . Wformat($Vmax * $Vmax / $Rtop) ;
        echo Rformat($Rbot,1) . Rformat($potest,0) . "(". retRnumber($potest) . ")";
        echo Rformat($pot,0) ;
        if (abs($pot) > 1E-6) { 
            echo "(". retRnumber($pot) . ")";
        }
        else {
            echo "&nbsp &nbsp &nbsp";
        }

        echo Iformat($Vmax/($Rtop+$Rbot)) . "<br>" ;
    }
    echo "potentiometer divider <br>  ";
    echo " &nbsp TOP &nbsp E24TOP &nbsp &nbsp E24PAR ";
    echo " &nbsp &nbsp &nbsp POT  &nbsp BOT &nbsp E24BOT &nbsp E24PAR <br>";

    for ($x = 0; $x <= 11; $x++) 
    {
      
       
 

        $potest = EPOT[$x % 4] * pow(10, $x >> 2); // Calculate potestial
        $potest = $potest * $FACS;
        $pot  = $potest;
        if ($Vmax == $Vmin) {
            $Rbot = $Vrefmin*$pot/($Vrefmax-$Vrefmin);
            $Rtop = $pot*($Vmax-$Vrefmax)/($Vrefmax-$Vrefmin);
        }
        else {

            $Rbot =  $Vmin * $potest /($Vmax-$Vmin);
            $Rtop =  ($Vmin-$Vrefmax)*($potest+$Rbot)/$Vrefmax;
        }    

        $Rtot  =   $Rbot+$pot+$Rtop;
        
        $Rtest = retE24($Rtop, $ser);
        $Rpar = retparE24($Rtop,$Rtest,$ser);
        $Rpar = retE24($Rpar,$ser);
 
        $Rbtest = retE24($Rbot, $ser );
        $Rbpar = retparE24($Rbot,$Rbtest,$ser);
        $Rbpar = retE24($Rbpar,$ser);

        echo Rformat($Rtop,1) . Rformat($Rtest,0) . "(". retRnumber($Rtest) . ")" . Rformat($Rpar,0);
        if (abs($Rpar) > 1E-6) { 
            echo "(". retRnumber($Rpar) . ")";
        }
        else {
            echo "&nbsp &nbsp &nbsp";
        }
        echo  "|";
        echo Rformat($potest,0) . Rformat($Rbot,1) . Rformat($Rbtest,0) . "(". retRnumber($Rbtest) . ")" ;
        echo Rformat ($Rbpar,0);
        if (abs($Rbpar) > 1E-6) { 
            echo "(". retRnumber($Rbpar) . ")";
        }
        else {
            echo "&nbsp &nbsp &nbsp";
        }
        echo  "| I: " . Iformat($Vmax / $Rtot) . " <br>" ;
    }
}
?>


</body>
</html>