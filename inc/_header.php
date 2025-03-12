<?php debug('<!-- header.php -->');?>
<!DOCTYPE html>
<html lang="<?=LANG?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><? titulo() ?></title>
    <link rel="stylesheet" href="<?=URL?>/assets/css/style.css">
</head>
    
<body>
  <header>
      <div class="logo"><?=SITENAME?></div>
      <?php echo construirMenu(); ?>
  </header>
  <main>
    <h1><? titulo(false) ?></h1>