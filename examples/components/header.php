<h1><?php echo $title; ?></h1>
<p><?php echo $desc; ?></p>
<p><?php echo $view->escape($htmlval); ?></p>

<p><?php echo $view->escape($desc, 'uppercase|randomize'); ?></p>

<?php
    echo $view->render('title');
?>