<?php
if($_SESSION['username'] == "" || empty($_SESSION['username']))
	{ header( "location: /" );
        exit(0);}
	?>