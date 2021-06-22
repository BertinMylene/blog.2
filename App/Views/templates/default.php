<!DOCTYPE html>
<html lang="Fr">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="../../favicon.ico">

	<title><?= \App::getInstance()->getTitle(); ?></title>

	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">
</head>

<body>

	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container-fluid">
			<ul class="nav navbar-nav">
				<li class="nav-link active"><a class="navbar-brand" href="index.php?p=post.index">Accueil <span class="sr-only"></span></a></li>
				<li class="nav-link"><a class="navbar-brand" href="index.php?p=admin.post.index">Admin Posts</a></li>
				<li class="nav-link"><a class="navbar-brand" href="index.php?p=admin.category.index">Admin Categories</a></li>
			</ul>
		</div>
	</nav>

	<div class="container">
		<?= $content; ?>
	</div>
</body>

</html>