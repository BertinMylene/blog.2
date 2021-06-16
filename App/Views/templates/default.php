<!DOCTYPE html>
<html lang="Fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="../../favicon.ico">

	<title><?= \App::getInstance()->getTitle(); ?></title>

	<!-- Bootstrap core CSS -->
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="index.php">Mon super Blog</a>
			</div>

			<ul class="nav navbar-nav">
				<li class="nav-link active"><a class="navbar-brand" href="index.php?p=posts.index">Accueil <span class="sr-only">(current)</span></a></li>
				<li class="nav-link"><a class="navbar-brand" href="index.php?p=admin.posts.index">Admin Posts</a></li>
				<li class="nav-link"><a class="navbar-brand" href="index.php?p=admin.categories.index">Admin Categories</a></li>
			</ul>
		</div>
	</nav>

	<div class="container">
		<?= $content; ?>
	</div>
</body>
</html>