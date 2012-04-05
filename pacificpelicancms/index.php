<?php
	//  powered by pacificpelican.us/cms	 
	//  This program is a free software web application written in PHP.  It is designed to upload files, show links to uploaded files, shortern URLs, & list the previous shortened URLs.
	//  Be sure to put your setup data into the CONFIGURATION section below before uploading this file to your server.
	//    info links:
	//  http://pacificarchives.sf3am.com/cms   /   pacificpelicancms@lovebirdsconsulting.com
	//  Copyright 2010-2011 Daniel J. McKeown   /  Oct. 26, 2011 /   http://danieljmckeown.com 
	//		   http://pacificpelican.us  /   http://lovebirdsconsulting.com  /  http://djmblog.com
	//					      __
	//	Check out the Neener band site for free downloads of our music and band news:
	//	http://blogs.sf3am.com/neener
	//				//
	//	The version 0.0.9 series of pacificpelican.us/cms is in memory of Striker and Ava the parakeets:	
	//	http://updates.sf3am.com/dan/status/142/
					//	
					//
		//    LICENSE SECTION
					//
			//		pacificpelican.us/cms is free software; you may freely modify it and distribute it
			//		pacificpelican.us/cms is offered in the hope that it will be useful but without warranty or guarantee
		//
			//		pacificpelican.us/cms is licensed under the GNU General Public License (GPL) version 2, or later:
			//		http://www.gnu.org/licenses/gpl.html
				//	
				//
		//    end of LICENSE SECTION
//	
//
//	--------> -------------------------------------------------------------------
	//	This is the CONFIGURATION section
							//
		$passcode00 = "ghana2014goal";	//		Change this password to what you want--you will use it when you use the "upload photo," create post, and "shortern URL" tools
							//
		$subdir = "";          //     $subdir should be assigned as subdirectory (if any) of your server that this index.php is installed on 
										//	(w/ trailing slash:e.g. "files/pacificpelican/")
							//		
					//     Leave $subdir empty if this index.php sits at the root of your domain
							//
			//      You also want to make sure that you have a directory called "libary" in the same directory this index.php file is in
			//	Also, the "library" directory should have a subdirectory called "images" for the program to upload into
			// 	In addition, the "library" directory should have a subdirectory called "links" for the program to store data
			// 	In addition, the "library" directory should have a subdirectory called "posts" for the program to store text files
			//	Also required is a blank file named "urls.txt" in the "library/links/" directory		
							//
			//      Optionally you may add a "style.css" CSS file to this directory to specify a style for your site 
			//	This program outputs a page with divs w/ classes and IDs
							//   
	//	end of CONFIGURATION section   
	//	-------------------------------------------------------------------
//
	// 		This $version0 variable indicates the version of pacificpelican CMS (formerly known as Corvisart photo manager)
			$version0 = "0.0.9.9.3";           
		//			**dev version**
		// 	Automatically find out what the site's base URL is and assign it to $sitebase
			$sitebase = ($_SERVER['SERVER_NAME']);
//
//			The URL redirection script (only runs for page requests with the parameter r [e.g. /?r=ID])
	if ($_GET["r"])   	{
		$querynumber = ($_GET["r"]);
		if (!($fl = fopen("library/links/urls.txt", "r"))) 	{
   					die();
									}
				$counter = 0;
			while ($line = fgets($fl, 4096)) 			{  				
  			 $line = trim($line); 
			$urlarray[$counter] = $line;
			$counter++;
				if (strrpos("$line", "##$querynumber")) 		{
					$xth = "##$querynumber";
					$line1 = str_replace("$xth", "", "$line");
						//      use a 301 signal (moved permanently) to redirect the URL
					header("HTTP/1.1 301 Moved Permanently");
					header("Location: $line1");
					exit();
													}				
										}
			fclose($linkdata);
				} 
		//	end of The URL redirection script (for requests via the parameter r)
	if ($_GET["p"]) {
		$postfilename = ($_GET["p"]); 
		$fileid = "library/posts/$postfilename";
		$handler = fopen($fileid, "r");
			$myfile = $fileid;
		$lines = file($myfile);    
				$countplus = 3;
			for($i=count($lines);$i>0;$i--){
   				//	 echo $lines[$i];
				$filecontentsp[$countplus] = $lines[$i];
				$countplus--;
						}
					$maintext = "$filecontentsp[3]";
				$i = 0;
				$countplus = 0;
				$thelimit = 6;
				$thelimit = count($filecontentsp);
			while ($i < $thelimit) {
				$filecontentsp[$i] = $lines[$i];
				$countplus++;
				$i++;
						}
		fclose($handler);
			$quotetitle = $filecontentsp[1];
			$quotelesstitle = str_replace("\"" , "", $quotetitle);
			}
?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
echo "<head>";
			echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
	$kingofpain = "$sitebase" . "$subdir";
		if ($subdir == "")	{
			$titlename = $kingofpain;
					}
			else 	{
				$titlename = "$sitebase/$subdir";
				}
	if ($_GET["photo"]) 	{
		$photoname1 = ($_GET["photo"]);
		echo "<title>$photoname1 | $sitebase photo sharing</title>";
		$canonical = "http://$sitebase/$subdir?photo=$photoname1";
		echo "<link rel='canonical' href='http://$sitebase/$subdir?photo=$photoname1' />";
				}
	else
		{	
			if ($_GET["links"]) 	{
				echo "<title>$titlename link list</title>";
						}
			if ($_GET["library"]) 	{
				echo "<title>$titlename file list</title>";
						}
			if ($_GET["urlshortener"]) 	{
				echo "<title>$titlename URL shortener</title>";
						}
			if ($_GET["uploadtool"]) 	{
				echo "<title>$titlename upload page</title>";
						}
			if ($_GET["writer"]) 	{
				echo "<title>$titlename post writing page</title>";
						}
			if ($_GET["textfiles"]) 	{
				echo "<title>$titlename posts list</title>";
						}
			if ($_GET["p"]) {
				echo "<title>$quotelesstitle | $titlename</title>";
					}
	else 		{
		echo "<title>$titlename</title>";
			}
		}
	echo "<link href='style.css' rel='stylesheet' type='text/css'>";        
echo "</head>";
echo "<body>";
	echo "<div class='globalcontent' id='megalayer'>";
		echo "<div class='menus' id='titlebar'>";
			echo "<h1><a href='http://$sitebase'>$sitebase</a> <a href='.'>content</a></h1>";
		echo "</div>";
				//		This assignment finds out the current URL and names it $url0
		$url0 = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];		
   				//	This section initializes several key variables
			$urldir = "library/images/";				//     This assumes that a directory ./library/images/ exists already
			$sky = $sitebase;
			$url1 = $url0 . $urldir;
			$url1b = $urldir;
			$imagedir = "library/images/";			
			$imagedir01 = "/library/images/";
			$imagedir00 = "";
			$baselocation = ".";
			$infofile = "library/links/urls.txt";
		//	End of the variable initialization section	
	echo "<div class='top1' id='menu1'>";
		echo "<li id='mainpage'><a href='$baselocation'>Main Page</a></li>";
				if (!($_GET["photo"])) {
					if (!($_GET["p"])) 	{
		echo "<li id='uploadphoto'><a href='index.php?uploadtool=on'>Upload a Photo</a></li>";
				//	echo "<li id='photolibrary'><a href='index.php?library=on'>Old Photo Library</a></li>";
		echo "<li id='photolibrary2'><a href='index.php?filelist=on'>Photo Library</a></li>";
		echo "<li id='urlshortener'><a href='index.php?urlshortener=on'>URL shortener</a></li>";
		echo "<li id='linklist'><a href='index.php?links=on'>Link List</a></li>";
		echo "<li id='textcreatorlink'><a href='index.php?writer=on'>Create Post</a></li>";
		echo "<li id='textcreatorlink0'><a href='index.php?textfiles=list'>Posts List</a></li>";
								}
							}
		echo "<br />";
	echo "</div>";
	echo "<div class='corecontent' id='corelayer'>";
	//	photo perma-link section; called only if there is a photo paramter
	if ($_GET["photo"]) 
			{
   			$photoname = $_GET["photo"];
		if ((strpos($photoname, "jpg") !== false) || (strpos($photoname, "JPG") !== false)) {
			$photoplace = $urldir . $photoname;
		if ($photoplace)				 {
	if (strpos($_GET["photo"], '..') !== false) 	{
   			 echo "ARBITRARY FILE VIEWING NOT AVAILABLE";
							} 
				else 	{
			echo "<img src='$photoplace' width='864' /><br /><a href='$photoplace' title='view the image directly'>view full size</a>";
					} 
								}
													}      //    end of if ((strpos($photoname, "jpg") !== false) 
		else		{
					$filename = $_GET["photo"];
					$photoplace = $urldir . $filename;
						echo "<a href='$photoplace' title='view the file directly'>link to the file</a>";
				}
			}
			//      end of photo perma-link section	
		//	upload section; called only if there is an uploadtool paramter
	if ($_GET["uploadtool"]) 			{
		echo "<div class='mainfocus' id='uploadfile1'>";
		echo "<h2>Upload a photo to library</h2>";	
			echo "<form enctype='multipart/form-data' action='$url0' method='POST'>";
					//		echo "<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"3000000\" />";
				echo "file to upload: <input name='userfile' type='file' />";
				echo "password: <input name='pcode' type='password' />";
				echo "<input name='sky' type='hidden' value='$sky' />";
   				echo" <input type='submit' value='Upload' />";
			echo "</form>";
	echo "</div>";
			$uploadfile1 = $url0 . $imagedir . basename($_FILES['userfile']['name']);	
			$uploadfile01 = $imagedir . basename($_FILES['userfile']['name']);
		if (($_POST["pcode"] == $passcode00) && ($_POST["sky"] == $sky))     {
	echo "<div class='ulresult' id='eerrorornot'>";
		echo "<br />UL place: $uploadfile01";
			$tmpp = ($_FILES["userfile"]["tmp_name"]);
		echo "<br /><br />";	
		echo "tmp name: "; 
		echo $tmpp;
			$fs0 = ($_FILES['userfile']['tmp_name']);
		echo $fs0;
		echo "<br /><br />";	
			if (move_uploaded_file($fs0, "$uploadfile01")) 
						{
   			 echo "File uploaded.\n";
						} 
				else	 {
   			 echo "ERROR\n";
						}
		     echo "<br /><br />";			
	echo "</div>";
											}
			}
			//	end of upload section
		if ($_POST["pcode"]) {
			if ($_POST["pcode"] != $passcode00) {
			echo "<div class='errordata' id='pwerror'>";
					echo "<br /><br />";	
					echo "PASSWORD ERROR";	
					echo "<br /><br />";	
			echo "</div>";
											}
		}
	//						This is the library section
		$sdf = "on";
		if (!($_GET["photo"]))   { 
			if (($_GET["library"]) == $sdf)  {
				echo "<h2>File List</h2>";			
			$fpile = array();
			$xc = 2;
			$xc--;
			$xc--;	
				if ($flh = (opendir("$urldir"))) {
  				  while (false !== ($file = readdir($flh))) {
      				  if ($file != "." && $file != "..") {
          				  $fpile[$xc] = $file;
						  $xc++;
     												   }
   															 }
    			closedir($flh);
											}			
				$limiter = 10;		
			if ($_GET["count"])   {
					$limiter = ($_GET["count"]);
									}
				$filetotal = count($fpile);		
			if ($limiter > $filetotal)  {
					$limiter = $filetotal + 1;
										}
				$xc = 2;
				$enufcheck = 1;
			while ($limiter >= 0) {
				$currentphoto = $fpile[$limiter];		
				$linkfront = "$url0&photo=$currentphoto";		
					if ($enufcheck > 2) {
						echo "<a href='$linkfront'>$currentphoto</a>";
						echo "<br />";	
								}			
									$limiter = $limiter - 1;
									$enufcheck = $enufcheck + 1;
						}
			echo "<br /><a href='?library=on&count=10'>last 10</a> | <a href='?library=on&count=50'>last 50</a> | ";
			echo "<a href='?library=on&count=100'>last 100</a> | <a href='?library=on&count=500'>last 500</a><br />";
										}    //   end of if (($_GET["library"]) == $sdf)
								}
	//							End of the library section
	//						Start of the URL shortener form
			if ($_GET["urlshortener"]) 
					{
				//		Use a form to check password and take in the URL that the user wants to shorten
				echo "<h2>Shorten a link</h2>";	
			$url04 = "?urlshortener=on";
				echo "<form enctype='multipart/form-data' action='$url04' method='POST'>";
				echo "URL: <input name='userurl' type='text' size='90' />";
				echo "password: <input name='pcode' type='password' />";
				echo "<input name='sky' type='hidden' value='$sky' />";
   				echo "<input type='submit' value='Upload' />";
			echo "</form>";
		if (($_POST["pcode"] == $passcode00) && (($_POST["sky"]) == $sky))    {
			if (!($fl = fopen("$infofile", "r"))) {
 				  die("Cannot open file");
								}
					$counter = 0;
				while ($line = fgets($fl, 4096)) {  				
  					 $line = trim($line); 
					$urlarray[$counter] = $line;
					$counter++;
								}
				$goodcount = $counter;	
			echo "<div class='ulresult' id='eerrorornot2'>";
			echo "<br />uploading.....";	
				$urllist = fopen("library/links/urls.txt", "a") or die("can't open file");
				$newurl0 = ($_POST["userurl"]);
				$newurl = "$newurl0" . "##" . "$goodcount" . "\n";
				echo "adding URL";
					if ($subdir == "") {
						$destination = "$sitebase" . "/" . "?r=$goodcount";
						}
				else	{
				$destination = "$sitebase" . "/" . "$subdir" . "?r=$goodcount";
					}	
					echo "<br /><p><a href='http://$destination'>Your shortened URL:</a> http://$destination</p>";
				fwrite($urllist, $newurl);
			fclose($urllist);
		     echo "<br /><br />";	
			echo "</div>";
											}
					}
	//			end of the URL shortener form
	//		Start of the URL redirector (the other, semi-deprecated on that uses the u parameter instead of the default r parameter and JavaScript instead of http 301)
			if ($_GET["u"]) 
					{
			$querynumber = ($_GET["u"]);
			$linkdata = fopen("library/links/urls.txt", "r");
		if (!($fl = fopen("$infofile", "r"))) {
   					die("Cannot open file");
						}
				$counter = 0;
			while ($line = fgets($fl, 4096)) {
  			 $line = trim($line); 
			$urlarray[$counter] = $line;
			$counter++;
				if (strrpos("$line", "##$querynumber")) {
					echo "found the url....redirecting.....";
						$xth = "##$querynumber";
						$line1 = str_replace("$xth", "", "$line");
						echo "<script>";
							echo "location.replace('$line1');";
						echo "</script>";
					exit();
						}
				//		Look up the u parameter to find the full URL link
				}
			fclose($linkdata);
					}
	if ($_GET["t"]) {      			//    The old text file perma-link viewer
		$postfilename = ($_GET["t"]); 
		$fileid = "library/posts/$postfilename";
		$handler = fopen($fileid, "r");
		$filecontents = fread($handler, filesize($fileid));
			fclose($handler);
				echo "<p>$filecontents</p>";
			}
	if ($_GET["p"]) {		//    The new text file perma-link viewer
			//	echo "<p>$filecontentsp[0]</p>";
		echo "<div class='postdata' id='posttitle'><p>$filecontentsp[1]</p></div>";	
		echo "<div class='postdata' id='postauthor'><p>$filecontentsp[2]</p></div>";
		echo "<div class='postdata' id='postdate'><p>$filecontentsp[3]</p></div>";
		echo "<div class='postdata' id='postcontent'><p>$filecontentsp[4]</p>";
			$result = count($filecontentsp);
			$left = $result - 4;
			$wherenow = 5 - $result;
			$highcount = 5;
				//	while ($left > 0)
					while ($wherenow < 0) 
						{
				echo "<p>$filecontentsp[$highcount]</p>";
			$left--;
			$highcount++;
			$wherenow++;
						}
		echo "</div>";
			}
	if ($_GET["textfiles"]) {         //       This section lists the text files
		// open the text library directory 
		$postdirectory = opendir("library/posts");
		$postdirectoryloc = "library/posts";
		$postarray[] = scandir("$postdirectoryloc");
	// close the directory
	closedir($postdirectory);
	//	count posts in directory array
	$postcount = count($postarray);
	// sort function
	sort($postarray);
	$pieces = scandir($postdirectoryloc);
	echo "<br /><h2>Text file list</h2><br />";
	foreach($pieces as $currentpost) {
		if  (!($currentpost == ".")) 	{
			if  (!($currentpost == "..")) 	{
		echo "<a href='?p=$currentpost'>$currentpost</a> | (<a href='library/posts/$currentpost'>raw text file</a>)<br />";
						//		$countpostlist++;
						}
							}
					}
			}		//      end of section that lists the text files
	if ($_GET["filelist"]) {         //       new photo/file list section
		// open the text library directory 
	$postdirectory = opendir("library/images");
	$postdirectoryloc = "library/images";
		$postarray[] = scandir("$postdirectoryloc");
	// close the directory
	closedir($postdirectory);
	//	count posts in directory array
	$postcount = count($postarray);
	// sort function
	sort($postarray);
		$pieces = scandir($postdirectoryloc);
			echo "<h2>Photo/File list</h2><br />";
	foreach($pieces as $currentpost) {
		if  (!($currentpost == ".")) 	{
			if  (!($currentpost == "..")) 	{
		echo "<a href='?photo=$currentpost'>$currentpost</a> | (<a href='library/images/$currentpost'>direct link to file</a>)<br />";
						//		$countpostlist++;
						}
							}
					}
			}  		//     end of new photo/file list section
	if ($_GET["writer"]) {			//   The form that creates a new text file
		echo "<div class='composer' id='writelayer'>";    
		echo "<h2>Create a text file</h2>";
		echo "<p>";
			echo "<form name='textinput' action='index.php' method='post' id='textinputform'>";
			echo "title: <input type='text' name='texttitle' id='titleinput' />";
			echo "author: <input type='text' name='writername' id='writerinput' />";
			echo "<br />";
			echo "<textarea cols='100' rows='40' name='textcontent' id='textcontentinput'>";
			echo "</textarea>";
			echo "<br />";		
			echo "password: <input name='pcode' type='password' />";
			echo "<br />";	
			echo "<input type='submit' value='Post' id='postbutton' />";
			echo "</form>";
		echo "</p>";
		echo "</div>";
			echo "<br />";
			}
	if ($_POST["textcontent"]) 		{
		echo "Text submitted.";
		if ($_POST["pcode"]) 					{
			if ($_POST["pcode"] != $passcode00) 				{
				echo "<div class='errordata' id='pwerror'>";
					echo "<br /><br />";	
					echo "PASSWORD ERROR";	
					echo "<br /><br />";	
				echo "</div>";
											}
		if ($_POST["pcode"] == $passcode00) 		{
			$postcontents = ($_POST["textcontent"]);
		$post = ($_POST["textcontent"]);
			if ($_POST["texttitle"])					 {
						$postname = ($_POST["texttitle"]);
						$author = ($_POST["writername"]);
											}
			else 	{
						$postname = substr($postcontents, 0, 33) . "...";
					//	$postname = the 1st 20 characters of $postcontents + "...";
						$author = ($_POST["writername"]);
							echo "<br /><br />";
				}
					if (!($_POST["writername"])) {
							$author = "Anonymous";
									}
						//   GET a timestamp
						$timestmp = date("F j, Y, g:i a");	
						//	$nowstamp = date("YmdHiS");
						$nowstamp = date("YmdHi") . "sa" . rand(1, 7772727);
						//	$newfilename = "library/posts/year-month-day-hour-minute-second-random" . ".txt";	
						$newfilename = "library/posts/" . "$nowstamp" . ".txt";
						$totalfilecontents = "$postname<br />author:$author<br />created:$timestmp<br />$postcontents";	
						$namebanner = "$sitebase\n";
							$nameline = "\"$postname\"\n";
						//	$nameline = "$postname\n";
						$authorline = "by $author\n";
						$timeline = "$timestmp\n";
						$contentsline = "$postcontents\n";	
						//   OPEN/CREATE a new text file in library/posts/
						$fl = fopen($newfilename, 'w') or die("can't open file");
						//   WRITE to the text file
						fwrite($fl, $namebanner);
						fwrite($fl, $nameline);
						fwrite($fl, $authorline);
						fwrite($fl, $timeline);
						fwrite($fl, $contentsline);
						//   CLOSE the text file
						fclose($fl);
						$permalinkpiece = "$nowstamp" . ".txt";
					echo "Your text file has been created.  <br /><a href='?p=$permalinkpiece'>Link to the post</a>.<br />";
							echo "<br /><br />";
						echo "title: $postname<br />";
						echo "author: $author<br />";
						echo "created: $timestmp<br />";
						echo "contents: $postcontents<br />";
								}		
									}
						}
	if ($_GET["links"]) {
		$querynumber = ($_GET["u"]);
			$linkdata = fopen("library/links/urls.txt", "r");
				$totaldata = fread($linkdata, filesize($infofile));
				$items = count(totaldata);
			fclose($linkdata);
	if (!($fl = fopen("$infofile", "r"))) {
 	  die("Cannot open file");
	}
		$counter = 0;
	while ($line = fgets($fl, 4096)) {
   			$line = trim($line); 
			$urlarray[$counter] = $line;
			$counter++;
					}
			echo "<div class='linkzone' id='listing'>";
			echo "<h2>Links</h2>";
		$totalup = count($urlarray);
		$counter2 = 0;
	if ($_GET["count"]) {
			$limiter = ($_GET["count"]);
		while ($limiter > 0) {
	$current = $urlarray[$counter2];
	$xth = "##$counter2";
		$current1 = str_replace("$xth", "", "$current");
			echo "<p><a href='$current1'>$current1</a></p>";
	$limiter--;
	$counter2++;
					}	
				}
		else {
	while ($counter > $counter2) {
		$current = $urlarray[$counter2];
		$xth = "##$counter2";
		$current1 = str_replace("$xth", "", "$current");
	if ($subdir == "") 		{
					$oklink = "http://$kingofpain/?r=$counter2";
					}
				else	{
				$oklink = "http://$sitebase/$subdir" . "?r=$counter2";
					}	
		echo "<p><a href='$current1'>$current1</a> : $oklink</p>";
	$counter2++;
					}
			}
	echo "</div>";
			echo "<br /><br /> ";
			}
	//		end of the URL redirector
	echo "<div class='credits0' id='corvisartlink'>";
		$photoname2 = $photoname1;
		$cleanname = str_replace("-", " ", "$photoname2");
		$cleanname1 = str_replace("_", " ", "$cleanname");
		$cleanname2 = str_replace(".jpg", " ", "$cleanname1");
		$cleanname3 = str_replace(".png", " ", "$cleanname2");
			echo "<br />";
	if ($_GET["photo"]) {
		echo "<h2>$cleanname3 </h2>";
		echo "<p><a href='$canonical'>perma-link</a></p>";
				}
	echo "</div>";
	echo "</div>"; 	//    end of div id='corelayer'
	echo "<div class='credits1' id='lovebirdslink2'>";
		echo "powered by <a href='http://pacificpelican.us/cms'>pacificpelican.us/cms</a> $version0 from <a href='http://lovebirdsconsulting.com/'>lovebirdsconsulting.com</a>";
	echo "</div>";
	echo "</div>";     //   end of megalayer
?>
</body>
</html>