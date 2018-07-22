<hr>
<SCRIPT LANGUAGE="JavaScript"> 
<!-- Begin 
    function getthedate(){ 
        var mydate=new Date(); 
        var hours=mydate.getHours(); 
        var minutes=mydate.getMinutes(); 
        var seconds=mydate.getSeconds(); 
        var dn="AM"; 
        if (hours>=12) dn="PM"; 
        if (hours>12) hours=hours-12;        
        if (hours==0) hours=12; 
        if (minutes<=9) minutes="0"+minutes; 
        if (seconds<=9)    seconds="0"+seconds; 
        

        var cdate="<span style=\"color:#994A1D\">Local Time:</span> &nbsp;&nbsp;&nbsp;<span style=\"color:#999\">"+hours+":"+minutes+":"+seconds+" "+dn+"</span><BR>";
        if (document.all) 
            document.all.clock.innerHTML=cdate; 
        else if (document.getElementById) 
            document.getElementById("clock").innerHTML=cdate; 
        else 
            document.write(cdate); 
    } 
    if (!document.all&&!document.getElementById) getthedate(); 

    function goforit(){ 
        if (document.all||document.getElementById) setInterval("getthedate()",1000); 
    } 
    window.onload=goforit; 
// End --> 
</SCRIPT>
<table cellspacing="2" cellpadding="2">
<tr>
<?php
if ($servername == "")
{
    $theservername = $_SERVER['SERVER_NAME'];
}
else
{
    $theservername = $servername;
}
if ($customos == "")
{
    $osname = checkos();
}
else
{
    $os = "nocpu";
    $osname = $customos;
}
if (php_sapi_name() == "apache2handler")
{
    $httpapp = "Apache";
}
else
{
    $httpapp = php_sapi_name();
}


if (PHP_OS == "WINNT")
{
    $os = "windows";
    $osbuild = php_uname('v');
} elseif (PHP_OS == "Linux")
{
    $os = "linux";
    $osbuild = php_uname('r');
}
else
{
    $os = "nocpu";
    $osbuild = php_uname('r');
}

$frei = disk_free_space("./");
$insgesamt = disk_total_space("./");
$belegt = $insgesamt - $frei;
$prozent_belegt = 100 * $belegt / $insgesamt;
?>
<td align="left" valign="top" style="color:ccc"><span style="color:#FF8700">Server Space:</span><br>
In Use = <b><?php echo ZahlenFormatieren($belegt); ?></b>(<?php echo round($prozent_belegt,"2"); ?> %)<br>
<img src="bar.php?rating=<?php echo round($prozent_belegt,"2"); ?>" border="0"><br>
Free Space = <b><?php echo ZahlenFormatieren($frei); ?></b><br>
Disk Space = <b><?php echo ZahlenFormatieren($insgesamt); ?></b></td>
<?php
{
    if ($os == "windows")
    {
        $wmi = new COM("Winmgmts://");
        $cpus = $wmi->execquery("SELECT * FROM Win32_Processor");
        echo '<td align="left" valign="top" style="color:ccc"><span style="color:#FF8700">CPU:</span><br>';
        echo 'CPU Load:';
        foreach ($cpus as $cpu)
        {
            echo "" . $cpu->loadpercentage . "%<br />";
        }
        echo '<img src="bar.php?rating=' . round($cpu->loadpercentage, "2") . '" border="0"><br>';
		echo '<span style="color:#FF8700">Server Time: </span>';
        $thetimeis = getdate(time()); 
        $thehour = $thetimeis['hours']; 
        $theminute = $thetimeis['minutes']; 
        $thesecond = $thetimeis['seconds']; 
        if($thehour > 12){ 
            $thehour = $thehour - 12; 
            $dn = "PM"; 
        }else{ 
            $dn = "AM"; 
        } 
		echo "$thehour: $theminute:$thesecond $dn <br>"; 
		echo '<span id="clock"></span>';
		echo '</td>';
    } elseif ($os == "linux")
    {
        
        $cpu = getCpuUsage();
        $cpulast = 100 - $cpu['idle'];
        echo '<td align="left" valign="top" style="color:ccc"><span style="color:#FF8700">CPU:</span><br>';
        echo "CPU Load: " . round($cpulast,"0") . "%<br>";
        echo '<img src="'.CLASS_DIR.'bar.php?rating=' . round($cpulast, "2") . '" border="0"><br>';
		echo '<span style="color:#FF8700">Server Time: </span>';
        $thetimeis = getdate(time()); 
        $thehour = $thetimeis['hours']; 
        $theminute = $thetimeis['minutes']; 
        $thesecond = $thetimeis['seconds']; 
        if($thehour > 12){ 
            $thehour = $thehour - 12; 
            $dn = "PM"; 
        }else{ 
            $dn = "AM"; 
        } 
		echo "$thehour: $theminute:$thesecond $dn <br>"; 
		echo '<span id="clock"></span>';
		echo '</td>';
    } elseif ($os == "nocpu")
    {
        echo "";
    }
    else
    {
        echo 'CPU Load<br>';
        echo "CPU Load: There Was An Error.<br>";
    }
}
?>
</tr>
</table>