<?php

if (isset($_REQUEST['watch'])) {
?><html>
<body>
<video width="100%" height="100%" controls>
  <source src="Videos/<?=$_REQUEST['file']?>" type="video/mp4">
Your browser does not support the video tag.
</video>
</body>
</html>
<?php
exit;
}

?>
<html>
<head>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-theme.min.css">
</head>
<body>

<div class="container">

<a href="?watch&file=<?=$entry?>"><?=$entry?></a><br/><?php

getDirContents("");

function getDirContents($dir = "") {

	if ($dir == "") {
		$openDir = "Videos";
		$title = $openDir;
	} else {
		$openDir = "Videos/".$dir;
		$title = substr($dir,1);
	}


	?><div class="panel panel-default"><div class="panel-heading"><?=$title?></div><ul class="list-group"><?

	$folders = $files = array();
	if ($handle = opendir($openDir)) {
	    while (false !== ($entry = readdir($handle))) {
	        if ($entry != "." && $entry != "..") {
	        	
	        	if (is_file($openDir."/".$entry)) {
	        		if (substr($entry,-4) == ".txt") { continue; }
	        		if (substr($entry,-4) == ".nfo") { continue; }
	        		if (substr($entry,-4) == ".srt") { continue; }
	        		$files[] = $entry;
	        	}
	        	else if (is_dir($openDir."/".$entry)) { $folders[] = $entry; }
	        }
	    }
	    closedir($handle);

	    sort($folders);
	    sort($files);

	    foreach ($folders as $folder) {
	    	?><li class="list-group-item"><?

	    	getDirContents($dir."/".$folder);
	    	print "</li>";
	    }

	    foreach ($files as $file) {
	    	?><a href="?watch&file=<?=$dir?>/<?=$file?>"><li class="list-group-item"><span class="glyphicon glyphicon-file"></span> <?=$file?></li></a> <a href="/Videos/<?=$dir?>/<?=$file?>">Download</a><?php
	    }

	}

	?></ul></div><?

}
?>
</div>
</body>
</html>
