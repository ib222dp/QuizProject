<?php

class HTMLView {
	
	public function echoHTML($header, $content) {
		
		echo "
			<!DOCTYPE html>
			<html lang='sv'>
			<head>
				<title>Quiz.se</title>
				<meta charset='utf-8' />
				<link rel='Stylesheet' media='screen and (min-width:481px)' type='text/css' href='css/quizmain.css' />
				<meta name='viewport' content='width:device-width, initial scale=1.0, user scalable=false' />
			</head>
			<body>
				<div id='container'>
					<header>
						<div id='nav'>
							$header
						</div>
					</header>
					<div id='categories'>
						<ul>
							<li><a href='slutuppgift/politik.html'>Politik</a></li>
							<li><a href='slutuppgift/musik.html'>Musik</a></li>
							<li><a href='#'>Film & TV</a></li>
							<li><a href='#'>Geografi</a></li>
							<li><a href='#'>Historia</a></li>
							<li><a href='#'>Biologi</a></li>
							<li><a href='#'>Litteratur</a></li>
						</ul>
					</div>
					$content
					<footer>
						&copy; 2014 Quiz.se
					</footer>
				</div>
			</body>
			</html>";	
	}
}
