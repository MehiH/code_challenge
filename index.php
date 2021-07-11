<?php 
// require_once('includes/autoloader.php');

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <!-- <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script> -->
		<title>Coding Challenge</title>
        <script src="js/assert.js"></script>
        <script src="js/calculator-parser_v2.js"></script>
        <script src="js/calculator-backends_v2.js"></script>
        <script src="js/menage.js"></script>
	</head>
	<body onload="init()">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-5">

                    <p>Coding Challenge !</p>
                    <textarea id="query_input" name="query_input" rows="4" cols="50"></textarea>
                    <br>
                    <button type="submit" id="execute" name="submit" onclick="makeQuery()">Execute</button>
            </div>
            <div class="col-md-5">
                <div id="output"></div>
            </div>
        </div>
		
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	</body>

</html>