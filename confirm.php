<?php session_start();?>
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>MentorMeet</title>
	<meta name="author" content="Zhane Alvites">
	<meta name="description" content="Website for transperson to have a mentor in their transition">
	<link rel="stylesheet" href="styles/style.css">
	
	<script>
	 
	function printDate() {
	    var d = new Date();
	    var day = d.getDate();
	    var month = d.getMonth() + 1;
	    var year = d.getFullYear();
	    var hours = d.getHours();
	    var minutes = d.getMinutes();
	     
	    if (minutes < 10) {
	        minutes = "0" + minutes;
	    }
	 
	    var suffix = "AM";
	    if (hours >= 12) {
	        suffix = "PM";
	        hours = hours - 12;
	    }
	     
	    if (hours == 0) {
	        hours = 12;
	    }
	   document.write("It is " + hours + ":" + minutes + " " + suffix + " on " + month + "/" + day + "/" + year);
	}
	 
	</script>

</head>

<body>
	<header>
		<span class="head-title-become">Become A Mentor</span>
		<img src="images/james2.jpg" alt="james">


	</header>

	<nav class="navigation">
        <ul>
            <li><a href="final.php">How It Works</a></li>
            <li><a href="ourstory.php">Our Story</a></li>
            <li><a href="oursiblings.php">Our Brothers</a></li>
            <li><a href="index.php">Become a Brother</a></li>
        </ul>
    </nav>

	<?php echo $_SESSION['statusMessage'];?>
			 
	<?php echo $_SESSION['htmlOutput'];?>

	<main class="main-mentor">
		<script> printDate(); </script>
	</main>


<aside class="sidebar-mentor">

</aside>
	<footer>
		<footer class="site-footer">

		<a href="https://twitter.com/zhanealvites">
			
			<img src = "images/twitter.jpg" alt="Twitter Logo" class="social-icon">

		</a>

		<a href="https://www.facebook.com/z.alvites">
			
			<img src = "images/facebook.jpg" alt="Facebook Logo" class="social-icon">

		</a> 

		<a href="https://www.youtube.com/channel/UCD2ZJ0ub7lVFWXMV-QHxR9w">
			
			<img src = "images/tube.jpg" alt="YouTube Logo" class="social-icon">

		<a href="https://www.instagram.com/el_zhane/">
			
			<img src = "images/insta.jpg" alt="YouTube Logo" class="social-icon">

		</a> 
	</footer>

</body>

</html>