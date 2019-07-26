<?php

    if(isset($_POST["total_ques"]) && isset($_POST["rollno"]) && isset($_POST["quizID"]))
    {
        if($_POST["total_ques"] != "" && $_POST["rollno"] != "" && $_POST["quizID"] != "")
        {
            require_once("scripts/connect_db.php");

         //initializing the variables
            $marks = 0;
            $total_questions = $_POST["total_ques"];
            $roll_no = $_POST["rollno"];
            $quiz_ID = $_POST["quizID"];

            if($total_questions>0){

	         //calculating %age
	            for($i=1 ; $i <= $total_questions ; $i++){
	                @$fetch_ID = "rads".$i;
	                @$php_id = $_POST[$fetch_ID];

	                $check_sql = mysql_query("SELECT correct FROM answers 
	                                            WHERE id='$php_id'") or die(mysql_error());
	                $q_answer = mysql_fetch_array($check_sql);
	                $marks += $q_answer[0];
	            }
	            $percent = ($marks/$total_questions)*100;

	         //getting total time taken by the user to complete the quiz
	            $get_time_query = mysql_query("SELECT now() - date_time FROM quiz_takers 
	                                            WHERE username = '$roll_no' ") or die(mysql_error());
	            $get_time = mysql_fetch_array($get_time_query);
	            $time_taken = $get_time[0];

	            $check_time_query = mysql_query("SELECT duration FROM quiz_takers 
	                                            WHERE username = '$roll_no' 
	                                            AND quiz_id = '$quiz_ID' ") or die(mysql_error());
	            $check_time = mysql_fetch_array($check_time_query);
	            $duration = $check_time[0];

	            if($duration==0){
		         //updating the %age and time taken by the user in the DB
	            	mysql_query("UPDATE quiz_takers 
	                	         SET marks='$marks', percentage= '$percent', duration= '$time_taken', quiz_id= '$quiz_ID'
	                    	     WHERE username = '$roll_no' ")or die(mysql_error());
	            }else{
	            	$user_msg = 'Sorry, but re-submission of the quiz isn\'t allowed!';
	        		header('location: index.php?user_msg='.$user_msg.'');
	            }
	        }else{
	        	$user_msg = 'Hey, Weird, but it seems the quiz had no questions!';
        		header('location: index.php?user_msg='.$user_msg.'');
            	exit();
	        }
        }else{
            $user_msg = 'Hey, Something went wrong! Tell the Admin!!';
        header('location: index.php?user_msg='.$user_msg.'');
            exit();
        }
    }else{
        $user_msg = 'Hey, This is the start Page!, So enter your username here first';
        header('location: index.php?user_msg='.$user_msg.'');
            exit();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Result</title>

        <meta charset="utf-8">

        <link rel="stylesheet" type="text/css" href="css/master.css">
        <script type="text/javascript" src="scripts/overlay.js"></script>

        <!-- ****** favicons ****** -->
            <!-- Basic favicons -->
                <link rel="shortcut icon" sizes="16x16 32x32 48x48 64x64" href="img/faviconit/favicon.ico">
                <link rel="shortcut icon" type="image/x-icon" href="img/faviconit/favicon.ico">

            <!--[if IE]><link rel="shortcut icon" href="/favicon.ico"><![endif]-->

            <!-- For Opera Speed Dial -->
                <link rel="icon" type="image/png" sizes="195x195" href="img/faviconit/favicon-195.png">
            <!-- For iPad with high-resolution Retina Display running iOS ≥ 7 -->
                <link rel="apple-touch-icon" sizes="152x152" href="img/faviconit/favicon-152.png">
            <!-- For iPad with high-resolution Retina Display running iOS ≤ 6 -->
                <link rel="apple-touch-icon" sizes="144x144" href="img/faviconit/favicon-144.png">
            <!-- For iPhone with high-resolution Retina Display running iOS ≥ 7 -->
                <link rel="apple-touch-icon" sizes="120x120" href="img/faviconit/favicon-120.png">
            <!-- For iPhone with high-resolution Retina Display running iOS ≤ 6 -->
                <link rel="apple-touch-icon" sizes="114x114" href="img/faviconit/favicon-114.png">
            <!-- For Google TV devices -->
                <link rel="icon" type="image/png" sizes="96x96" href="img/faviconit/favicon-96.png">
            <!-- For iPad Mini -->
                <link rel="apple-touch-icon" sizes="76x76" href="img/faviconit/favicon-76.png">
            <!-- For first- and second-generation iPad -->
                <link rel="apple-touch-icon" sizes="72x72" href="img/faviconit/favicon-72.png">
            <!-- For non-Retina iPhone, iPod Touch and Android 2.1+ devices -->
                <link rel="apple-touch-icon" href="img/faviconit/favicon-57.png">
            <!-- Windows 8 Tiles -->
                <meta name="msapplication-TileColor" content="#FFFFFF">
                <meta name="msapplication-TileImage" content="img/faviconit/favicon-144.png">
        <!-- ****** favicons ****** -->

        <script language="javascript">
            document.addEventListener("contextmenu", function(e){
                e.preventDefault();
            }, false);
        </script>
		<link rel="stylesheet" type="text/css" href="Quiz.css">
    </head>
	<body background="b3.jpg" style="font-family: Arial;">
		<br>
		<a href="Home.html">
			<img src="iwt.png" alt="" class="iwt"/>
		</a>
		<br>
		<br>
		<ul>
			<li><a href="WXC.html">Web, XHTML, CSS</a></li>
			<li><a href="JS.html">JavaScript</a></li>
			<li><a href="XML.html">XML</a></li>
			<li><a href="PHP.html">PHP</a></li>
			<li><a href="RR.html">Ruby, Rails</a></li>
			<li><a href="index.php">Quiz</a></li>
		</ul>
    

        <div id="head" align="center">
            <img src="res.png" alt="Results" width="15%" />
        </div>
		<br><br><br><br>
        <div id="score" align="center">
            <?php echo $roll_no; ?>, You scored 
            <?php echo $marks; ?>/<?php echo $total_questions; ?>
        </div>

     

        <div id="fade_overlay">
            <a href="javascript:close_overlay();" style="cursor: default;">
                <div id="fade" class="black_overlay">
                </div>
            </a>
        </div>
    </body>
</html