<?php
	$CC="gcc";
	$out="timeout 5s ./a.out";//kill the utility ./a.out after 5sec
	$code=$_POST['code'];
	$code=str_replace('\"','"',$code);//escape characters
	$code=str_replace("\'","'",$code);
	$code=str_replace('\n',"\n",$code);
	$input=$_POST['input'];//echo $input;
	$filename_code="main.c";
	$filename_in="input.txt";
	$filename_error="error.txt";
	$executable="a.out";
	$command=$CC." -lm ".$filename_code;//to link math library
	$command_error=$command." 2>".$filename_error;//'2>' to dump error (STDERR) output in a file
	$check=0;

	if(trim($code)=="") die("the code is empty");//to remove whitespaces

	$file_code=fopen("/var/www/html/pro/main.c","a+");//fopen-to open file, w+ to read and write
	fwrite($file_code,$code);
	fclose($file_code);
	$file_in=fopen($filename_in,"w+");
	fwrite($file_in,$input);
	fclose($file_in);
	exec("chmod 777 $executable"); //exec to execute a given command, 777 to read, write and execute permissions
	exec("chmod 777 $filename_error");
	
	shell_exec($command_error);//store the output after executing
	$error=file_get_contents($filename_error);//reads a file to a string
	$executionStartTime = microtime(true);//unix timestamp with microsecond precision

	if(trim($error)=="")//no error
	{
		if(trim($input)=="")//no input
		{
			$output=shell_exec($out);
		}
		else//some input
		{
			$out=$out." < ".$filename_in;//'<' to dump (STDIN) input in a file
			$output=shell_exec($out);
		}
		//echo "<pre>$output</pre>";
		echo "<textarea  name=\"output\" rows=\"10\" cols=\"50\">$output</textarea><br /><br />";
	}
	else if(!strpos($error,"error"))//to check if no 'error' present in a output
	{
		echo "<pre>$error</pre>";
		if(trim($input)=="")
		{
			$output=shell_exec($out);
		}
		else
		{
			$out=$out." < ".$filename_in;
			$output=shell_exec($out);
		}
		//echo "<pre>$output</pre>";
                echo "<textarea name=\"output\" rows=\"10\" cols=\"50\">$output</textarea><br><br>";
	}
	else
	{
		echo "<pre>$error</pre>";
		$check=1;
	}
	$executionEndTime = microtime(true);
	$seconds = $executionEndTime - $executionStartTime;
	$seconds = sprintf('%0.2f', $seconds);//to write variables like 'c' % replaced by variable
 	echo "<pre>Compiled And Executed In: $seconds s</pre>";
	if($check==1)
	{
		echo "<pre>Verdict : CE</pre>";//compilation error
	}
	else if($check==0 && $seconds>3)
	{
		echo "<pre>Verdict : TLE</pre>";//time limit exceeded
	}
	else if(trim($output)=="")
	{
		echo "<pre>Verdict : WA</pre>";//wrong answer
	}
	else if($check==0)
	{
		echo "<pre>Verdict : AC</pre>";//answer is correct
	}
	echo"</br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br>";
	echo "<pre>CE:Compilation Error		TLE:Time Limit Exceeded		WA:Wrong Answer		AC:Correct Answer</pre>";
	//exec("cp $filename_code a.html");
	exec("rm $filename_code");
	exec("rm *.o");
	exec("rm *.txt");
	exec("rm $executable");

?>
