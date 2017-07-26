<?php

// Set the language and filename to be used for compilation
$source = "";
$language = "java";
$filename = "main.java";

// If code has been submitted, contact the compilation engine
$source = $_POST['source'];
$field1 = $_POST['field1'];
$field2 = $_POST['field2'];

$result = remoteExecuteSource($source,  $field1, $field2, $language, $filename);
$result = FormSuccessfulResults($result);
print_r($result);

// This function is responsible for communicating with the compilation engine.  The response is packaged up into an
// associative array with the following keys:
//	   result - this is either COMPILE_ERROR, RUNTIME_ERROR or SUCCESS
//	   stdout - this is standard output, which is relevant if result is SUCCESS
//	   error_message - this is the compiler error message if result if COMPILE_ERROR
//	   stderr - this is standard error if result is RUNTIME_ERROR
function remoteExecuteSource($source, $field1, $field2, $language, $filename) {

	// This is a hard-coded IP address of the compilation engine service.  Yes, I know.
	$SERVER_HOST = "localhost";

	// Set URL
	$url = "http://".$SERVER_HOST."/jobe/index.php/restapi/runs";

	// Open connection
	$ch = curl_init();

	// Prepare the run_spec for submission
	$source = $field1."".$source."".$field2;
	$run_spec = array("run_spec" => array("sourcecode" => $source, "language_id" => $language, "sourcefilename" => $filename));
	$run_spec_json = json_encode($run_spec);

	// Set the url, number of POST vars, POST data
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // include the full server response in the return value
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json; charset=utf-8', 'Accept: application/json'));
	curl_setopt($ch, CURLOPT_POSTFIELDS, $run_spec_json);

	// Execute post
	$result = curl_exec($ch);
	$http_response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	// Close connection
	curl_close($ch);

	$evaluatedResult = "";
	// Successful evaluation with response included
	if ($http_response_code == 200) {
		$run_result = json_decode($result, true);
		$evaluatedResult = ProcessReturnResult($run_result);
	}
	// The job has not been evaluated, but is in a queue - attempt to get the status, otherwise give up
	else if ($http_response_code == 202) {
		$run_id = $result;
		$run_result = JobeGetRunStatusOfQueuedJob($run_id);
		if ($run_result == false) {
			return array("result" => "RUNTIME_ERROR", "error_message" => "", "stdout" => "", "stderr" => "The compilation engine is really busy right now - please try again later!");
		} else {
			$evaluatedResult = ProcessReturnResult($run_result);
		}
	}
	return $evaluatedResult;
}

// We have a run_id for a previous submission to the compilation engine which was queued.  We will attempt to view the status of this
function JobeGetRunStatusOfQueuedJob($run_id)
{
	// Not implemented in current version of compilation engine
	return false;
}

// Code has been evaluated and the result should be interpreted.
// $result stores an associate array with the fields: run_id, outcome, cmpinfo, stdout, stderr
function ProcessReturnResult($executionResult)
{
	$result = "";
	$error_message = "";
	$stdout = "";
	$stderr = "";

	if ($executionResult['outcome'] == 15) {
		$result = "SUCCESS";
		$stdout = $executionResult['stdout'];
	} else if ($executionResult['outcome'] == 11) {
		$result = "COMPILE_ERROR";
		$error_message = $executionResult['cmpinfo'];
	} else if ($executionResult['outcome'] == 12) {
		$result = "RUNTIME_ERROR";
		$stderr = $executionResult['stderr'];
	} else if ($executionResult['outcome'] == 13) {
		$result = "RUNTIME_ERROR";
		$stderr = "Your submission took too long to execute.";
	} else if ($executionResult['outcome'] == 17) {
		$result = "RUNTIME_ERROR";
		$stderr = $executionResult['stderr'];
	} else if ($executionResult['outcome'] == 19) {
		$result = "RUNTIME_ERROR";
		$stderr = $executionResult['stderr'];
	} else {
		$result = "RUNTIME_ERROR";
		$stderr = "Unfortunately the compilation engine is not working properly at the moment. Please contact an administrator.";
	}
	return array("result" => $result, "error_message" => $error_message, "stdout" => $stdout, "stderr" => $stderr);
}

function FormSuccessfulResults($result)
{
	if ($result['result']=="SUCCESS") {
		return $result['stdout'];	
	} else {
		if ($result['stderr']==""){
			return $result['error_message'];
		}
		return $result['stderr'];
	}
}

?>
