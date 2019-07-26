<?php 
       require_once("connect_db.php");


    $index_selecting_quiz = mysqli_query($link,"SELECT quiz_id, display_questions, time_allotted, quiz_name
                                    FROM quizes WHERE set_default=1");
    $index_selecting_quiz_row = mysqli_fetch_array($index_selecting_quiz);
    $index_selecting_quiz_num = mysqli_num_rows($index_selecting_quiz);



    $user_taken = "";
    if(isset($_POST['user_msg']) && $_POST['user_msg']!=""){
        $user_taken = $_POST['user_msg'];
    }
    if(isset($_GET['user_msg']) && $_GET['user_msg']!=""){
        $user_taken = $_GET['user_msg'];
    }

    $total_questions = preg_replace('/[^0-9]/', "", $index_selecting_quiz_row['display_questions']);
    $total_time = preg_replace('/[^0-9]/', "", $index_selecting_quiz_row['time_allotted']);
    $quizName = $index_selecting_quiz_row['quiz_name'];

    if($index_selecting_quiz_num>0)
    	$first_item = 'You\'ve got '.$total_time.' mins for attempting '.$total_questions.' questions.';
    else
    	$first_item = '<strong>Sorry, but it seems there are no quizzes Available right now!</strong>';
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="Quiz.css">
        <title>Instructions</title>

      
        <script type="text/javascript" src="scripts/overlay.js"></script>

        <script type="text/javascript">
            function submit(){
                var x=document.forms["onlyForm"]["rollno"].value;
                if (x==null || x==""){
                    document.getElementById("enter_rollno").innerHTML = "Please Enter Your Roll No.";
                    exit();
                }
                document.getElementById('myForm').submit(); 
                return false;
            }
        </script>

        <script language="javascript">
            document.addEventListener("contextmenu", function(e){
                e.preventDefault();
            }, false);
        </script>

    </head>

    	<body background="b3.jpg">
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
		<br>
        <div id="head" align="center">
            <img src="know.png" alt="Test Your Knowledge" class="hd"/>
        </div>

        <div id="main_body" align="center">
		<br>
			
			<br>
            <strong><img src="qname.png" width="10%"/>
			<br>
			<h4><?php echo $quizName; ?> </h4>          
            <br>
            <form id="myForm" name="onlyForm" action="quiz.php" method="POST">
                <table align="center">
                    <tr>
                        <td align="center">
                            <input type="text" name="rollno" placeholder="Enter Your USN" autofocus/>
                        </td>
                    </tr>
                   
                    <tr>
                        <td align="center">
							
                            <a href="javascript:submit();" ><img src="clik.png" width="20%"></a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div id = "enter_rollno" align="center"><?php echo $user_taken ?></div>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
		<hr>
		<div>
		<center><b><a href="login.php" class="a1"><img src="admins.png" width="10%"/> </a></b></center>
		</div>
        <div id="fade_overlay">
            <a href="javascript:close_overlay();" style="cursor: default;">
                <div id="fade" class="black_overlay">
                </div>
            </a>
        </div>

     
    </body>
</html>

