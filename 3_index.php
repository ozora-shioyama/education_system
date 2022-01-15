<?php
require_once("1_functions.php");
require_once("3_functions.php");
$item =main();
?>

<html>
    <head>
        <meta charset="UTF-8">
        
       <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
        
        <script src="3_interface.js"></script>
        <script>
            window.onload=function(){
                let item =<?php echo json_encode($item);?>;
                kaitouSeisei(item);
            }
        </script>
    </head>
    <body>
 
      
       <form method="post" class="container">
              <div id="number_area"></div>
            <div id="question_area" class="bg-light p-5 my-4 rounded border border-secondary"></div>
            <div id="choice_area" class="mb-2"></div>
            <button id="answer" type="submit" class="btn btn-secondary">解答</button>
        </form>
        <!--<code class="language-text">isset()</code> !-->
    </body>
</html>

<?php 
/*echo "<pre>";
var_dump($_SESSION);
echo "</pre>";*/
?>