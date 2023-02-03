<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Dosya Yükle</title>
</head>
<body>
	<form action="yukle.php" method="post" enctype="multipart/form-data">
		<input type="file" name="dosya[]" multiple />
		<button name="dosyayukle" type="submit">Yükle</button>
	</form>

</body>
</html>