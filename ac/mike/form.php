<html>
<link rel="stylesheet" href="style.css" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<body>

<form method="POST">
    <?php if( $_SERVER['REQUEST_METHOD'] == 'POST' ) { ?>
        Invalid password
    <?php } ?>
    <p>Enter password for access:</p>
    <input type="password" name="password">
    <button type="submit">Submit</button>
</form>

</body>
</html>