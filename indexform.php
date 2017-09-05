<?php

?>
<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
</head>
<script type="text/javascript">
    $(document).ready(function() {
        $("#datepicker").datepicker({
             dateFormat: 'MM yy',
             constrainInput: true,
             showOn: 'button',
             buttonText: 'Select...'             
        });

        $("#boo").submit( function(event) {
          $("#datepicker").removeAttr('disabled');
        }
        );
    });


</script>
<body>
    <form id="boo" method="post" action="/calendarmelbpc/indexcalendar.php">
        <label for="monthyear">Date</label>
        <input id="datepicker" name="monthyear" disabled="disabled" />
        <div style="padding-top: 20px;padding-left: 20px;">
        <button type="submit" name="submit">Submit...</button>
        </div>
    </form>
</body>
</html>