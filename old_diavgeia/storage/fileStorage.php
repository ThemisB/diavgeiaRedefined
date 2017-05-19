<?php


class fileStorage
{
	public $storageRoot='';
	public $pathSeparator='';
	public $storageRootPrefix='';
	public $storageRootSuffix='';
	function fileStorage()
	{
			$this->storageRootPrefix='/var/www/drasi1/storage';
			$this->storageRootSuffix='/files/';
			$this->pathSeparator='/';
	}

	function getPathFromUID($uid)
	{

		$uidsha1=sha1($uid.'stavsalt');

		$ai=0;
		for($i = 0; $i < strlen($uidsha1); $i=$i+2) {
			$uidbase36array[$ai] = substr($uidsha1,$i,2);
			$ai++;
		}
		$uiddirroot = $this->storageRootPrefix.$this->storageRootSuffix;
		for($i = 0; $i < count($uidbase36array) ; $i++)	{
			$uiddirroot .= $uidbase36array[$i].$this->pathSeparator;
		}
		return  $uiddirroot;
	}


	function readFile($uid,$infilename)
	{	
	$old_track = ini_set('track_errors', '1');
		try {
		$filename = $this->getPathFromUID($uid).$infilename;
		if (file_exists($filename)) {
			if ($handle = fopen($filename, "r"))
			{$contents =
				fread($handle, filesize($filename));
				fclose($handle);
			}
			else
			{
				echo "Error while reading : Cannot open file<br>";
				exit;
			}
			return $contents;
				
		} 
		else {
			header('HTTP/1.0 404 Not Found');
			echo "<h1>404 Not Found</h1>";
			echo "The page that you have requested could not be found.";
			exit();
		}
} catch (Exception $e) {return '';        }
		ini_set('track_errors', $old_track);
	}
	function filepath($uid,$infilename)
	{	
		$filename = $this->getPathFromUID($uid).$infilename;
		
			return $filename;

		

	}
}

?>
