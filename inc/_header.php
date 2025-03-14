<?php debug('<!-- header.php -->');?>
<!DOCTYPE html>
<html lang="<?=LANG?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><? titulo() ?></title>
    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-pQB4xAT4gW4OKtf/6l3HkZtWwCQkBYV54D+z9KVz5JAlF6oAv5KyBqzrP1Je7Zt3K7zO+FqZk5zlBrF7FZ0xug==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?=URL?>/assets/css/style.css?v=<?=time()?>">
</head>
    
<body>
  <header>
      <div class="logo"><?=SITENAME?></div>
      <?php echo construirMenu(); ?>
  </header>
  <main>
    <h1><? titulo(false) ?></h1>