<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<title>Tasks page</title>
		<link rel="stylesheet" href="../bower_components/split-pane/split-pane.css" />
		<link rel="stylesheet" href="../bower_components/split-pane/pretty-split-pane.css" />
		<script src="../bower_components/jquery/dist/jquery.min.js"></script>
		<script src="../bower_components/angular/angular.js"></script>
		<script src="../bower_components/split-pane/split-pane.js"></script>
		<script src="../angular-split-pane.js"></script>
		<style type="text/css">
			html, body {
				height: 100%;
				min-height: 100%;
				margin: 0;
				padding: 0;
			}
		</style>
	</head>
	<body data-ng-app="example">
		<div class="pretty-split-pane-frame">
			<div data-split-pane>
				<div data-split-pane-component>
					<div class="pretty-split-pane-component-inner" id="top"><p>
<h3>Mastery Learning</h3>
</p></div>
				</div>
				<div data-split-pane-divider data-height="5px"></div>
				<div data-split-pane-component data-height="25em">
					<div data-split-pane>
						<div data-split-pane-component data-width="30%">
							<div class="pretty-split-pane-component-inner" id="left"><p>
<h4>Task1</h4>
<h5 name="task_id" id="task_id">1</h5>
 <?php
$servername = "localhost";
$username = "root";
$password = "wzx4373176";
$dbname = "ml";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM tasks";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "" . $row["question"]. "<br>";
echo "aaa".$row["expectedOutput"]."aaa<br>";
	$expectedOutput = $row["expectedOutput"];
	$field1 = $row["field1"];
	$field2 = $row["field2"];
    }
} else {
    echo "0 results";
}
$conn->close();
?> 
</p></div>
						</div>
						<div data-split-pane-divider data-width="5px"></div>
						<div data-split-pane-component>
							<div data-split-pane>
								<div data-split-pane-component data-height="60%">
									<div class="pretty-split-pane-component-inner" id="rightTop"><p>
Student writes code here:
<form>
<textarea rows = 10 cols = 40 name="source" id="source"></textarea>
<input type="button" value="Run" onclick="post();">
</form>

</p></div>
								</div>
								<div data-split-pane-divider data-height="5px"></div>
								<div data-split-pane-component>
									<div class="pretty-split-pane-component-inner" id="rightBot"><p>
Console:
<div style="border: 1px solid #f00; padding: 20px; margin-bottom: 20px;"  id="result">  </div>


</p></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script>
			angular.module('example', ['shagstrom.angular-split-pane']);
		</script>
<script type="text/javascript">
	function post(){
		var source = document.getElementById("source").value;
		var expectedOutput = "<?php echo $expectedOutput ?>"; 
		var field1 = "<?php echo $field1 ?>";
		var field2 = "<?php echo $field2 ?>";
		$.post('testphp.php',{source:source, field1:field1, field2:field2},	
		function(data){
			$('#result').html(data);
			if (data == expectedOutput) {
				alert("Well Done!");
			} else {
				alert("Wrong Answer");			
			}
		});	
	}
//	window.onload = function(){
//		if (window.name) {
//			var sourceEl = document.getElementById('source');
//			var info = (new Function("return " + window.name))();
//			sourceEl.value = info.source;
//		}
//	}
//
//	window.onunload = function(){
//		var source = document.getElementById('source').value;
//		window.name = '{source:"' + source + '"}';
//	}
</script>
	</body>
</html>