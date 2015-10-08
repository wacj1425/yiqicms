<?php
class Cache
{    
	function GetFileCache($file) {
		$source = "";
		$err = $this->chkFile($file);
		if( $err==1 ) {
			$fp=fopen($file,"r");
			$source=fread($fp, filesize($file) );
		} else {
			$source = '';
		}
		return $source;
	}
	
	function WriteFileCache( $file, $source, $override = 0 ) {
		$stat=1;		
		$path = pathinfo($file, PATHINFO_DIRNAME);
		if( !is_dir( $path ) ) {
			mkdir($path, 0777,true);
		}
		if ( ( $this->chkFile($file) && $override ) || !$this->chkFile($file) ) {
			if( ( $f=fopen($file,"w")) ) {				
				fputs($f,$source);
				fclose($f);
				$stat=1;
			} else {
				$stat = 0;
			}
		}
		return $stat;
	}
	
	function DeleteFile($file) {
		if ( file_exists($file)) {
			$delete = chmod( $file,0777);
			$delete = unlink($file);
			if(file_exists($file)) {
				$filesys = eregi_replace("/","\\",$file);
				$delete = system("del $filesys");
				if(file_exists($file)) {
					$delete = chmod ($file, 0777);
					$delete = unlink($file);
					$delete = system("del $filesys");
				}
			}
		}
	}
	
	function chkFile($file){
		return file_exists($file);
	}
}

?>