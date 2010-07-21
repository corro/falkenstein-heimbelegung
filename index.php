<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>

<div style="width:400px; background-color:wheat;padding:10px">
    <form action="#" method="post">
        Heim:
        <input type="radio" name="heim" value="buschi">B&uuml;schiheim</input>
        <input type="radio" name="heim" value="weiermatt">Weiermattheim</input>
        <input type="submit" value="Aktualisieren" style="float:right" /><br />
        <input type="submit" value="&lt;--" />
        <input type="submit" value="--&gt;" style="float:right;clear:both" />

    <?php
    include('calendar.php');

    $days = array(12, 14, 18, 19, 20, 21);

    echo generate_calendar(2010, 7, $days);
    ?>
    </form>
</div>
</body>

</html>