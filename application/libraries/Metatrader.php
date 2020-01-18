<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CodeIgniter Metatrader Class
 *
 * Work with remote servers via cURL much easier than using the native PHP bindings.
 *
 * @package        	CodeIgniter
 * @subpackage    	Libraries
 * @category    	Libraries
 */
define('T_HOST','162.13.103.154');  // MetaTrader Server Address
define('T_PORT',443);                   // MetaTrader Server Port
define('T_TIMEOUT',5);                  // MetaTrader Server Connection Timeout, in sec
define('T_CACHEDIR','public/cache/');         // cache files directory
define('T_CACHETIME',5);               // cache expiration time, in sec
define('T_CLEAR_DELNUMBER',15);        // limit of deleted files, after which process of cache clearing should be stopped


class Metatrader {

	public $MQ_CLEAR_STARTTIME = 0; // time
	public $MQ_CLEAR_NUMBER = 0;    // deleted files counter
	
	function MQ_Query($query,$cacheDir=T_CACHEDIR,$cacheTime=T_CACHETIME,$cacheDirPrefix='')
	{
		$ret = '';
		$fName = $cacheDir.$cacheDirPrefix.crc32($query); // cache file name
		
		//--- Is there a cache? Has its time not expired yet?
		if(file_exists($fName) && (time()-filemtime($fName))<$cacheTime) 
		 {
		  $ret = file_get_contents($fName);
		 }
		else
		 {
		  $ptr=@fsockopen(T_HOST,T_PORT,$errno,$errstr,T_TIMEOUT); 
		  if($ptr)
			{
		//--- If having connected, request and collect the result
			 if(fputs($ptr,"WQUOTES-$query,\nQUIT\n")!=FALSE)
			   while(!feof($ptr)) 
				 {
				  if(($line=fgets($ptr,128))=="end\r\n") break; 
				  $ret .= $line;
				 } 
			 fclose($ptr);
			 if ($cacheTime>0)
			   {
		//--- If there is a prefix (login, for example), create a nonpresent directory for storing the cache
				if ($cacheDirPrefix!='' && !file_exists($cacheDir.$cacheDirPrefix))
				  {
				   foreach(explode('/',$cacheDirPrefix) as $tmp)
					 {
					  if ($tmp=='' || $tmp[0]=='.') continue;
					  $cacheDir .= $tmp.'/';
					  if (!file_exists($cacheDir)) @mkdir($cacheDir);
					 }
				  }
		//--- save result into cache
				$fp=@fopen($fName,'w');
				if($fp) { fputs($fp,$ret); fclose($fp); }
			   }
			}
		  else
			{
		//--- if connection fails, show the old cache (if there is one) or return with the error 
			  if(file_exists($fName))
				{
				 touch($fName);
				 $ret = file_get_contents($fName);
				}
			  else
				{
				 $ret = '!!!CAN\'T CONNECT!!!';
				}
			}
		 }
		//--- clear cache every 3 sec (for such frequency of calls)
		if(!file_exists(T_CACHEDIR.'.clearCache') || (time()-filemtime(T_CACHEDIR.'.clearCache'))>=3)
		 {
		  ignore_user_abort(true);
		  touch(T_CACHEDIR.'.clearCache');
		
		  global $MQ_CLEAR_STARTTIME;
		  $MQ_CLEAR_STARTTIME = time();
		  $this->MQ_ClearCache(realpath(T_CACHEDIR));
		
		  ignore_user_abort(false);
		 }
		return $ret;
	}
	
	//+------------------------------------------------------------------+
	//| Clear cache                                                      |
	//+------------------------------------------------------------------+
	function MQ_ClearCache($dirName)
	{
		if(empty($dirName) || ($list=glob($dirName.'/*'))===false || empty($list)) return;
		//---
		global $MQ_CLEAR_NUMBER,$MQ_CLEAR_STARTTIME;
		$size = sizeof($list);
		foreach($list as $fileName)
		 {
		  $baseName = basename($fileName);
		  if ($baseName[0]=='.') continue;
		  if (is_dir($fileName))
			{
		//--- go through all cache directories recursively
			 $this->MQ_ClearCache($fileName);
			 if ($MQ_CLEAR_NUMBER>=T_CLEAR_DELNUMBER) return; // by recursion check condition for function exit 
			}
		  elseif(($MQ_CLEAR_STARTTIME-filemtime($fileName))>T_CACHETIME)
			{
		//--- if the file time is expired, delete it and, if the limit of deleted files has been exceeded, exit
			 @unlink($fileName);
			 if (++$MQ_CLEAR_NUMBER>=T_CLEAR_DELNUMBER) return;
			 --$size;
			}
		 }
		//--- delete empty directory
		$tmp = realpath(T_CACHEDIR);
		if (!empty($tmp) && $size<=0 && strlen($dirName)>strlen($tmp) && $dirName!=$tmp) @rmdir($dirName);
	}

	
}

/* End of file Metatrader.php */
/* Location: ./application/libraries/Metatrader.php */