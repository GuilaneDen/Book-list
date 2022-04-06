<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        if (file_exists('./inc/_head.php')) include './inc/_head.php';
    ?>
    <title>Document</title>
</head>
<body>
	<div class="wrapper">
        <?php if (file_exists('./inc/_left-menu.php')) include './inc/_left-menu.php'; ?>

        <div class="main">
            <?php if (file_exists('./inc/_top-menu.php')) include './inc/_top-menu.php'; ?>

			<main class="content">

			</main>

            <?php if (file_exists('./inc/_footer.php')) include './inc/_footer.php'; ?>
		</div>
	</div>
    <?php
        if (file_exists('./inc/_js.php')) include './inc/_js.php';
    ?>
</body>
</html>