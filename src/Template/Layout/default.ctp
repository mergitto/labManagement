<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$title = 'Labolatory Management System';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $title ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css('bootstrap.css') ?>
    <?= $this->Html->css('//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css') ?>
    <?= $this->Html->css('//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css') ?>
    <?= $this->Html->script('//ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js') ?>
    <?= $this->Html->script('bootstrap.min.js') ?>
    

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <head></head>
    <?= $this->Flash->render() ?>
    <div class="container clearfix">
        <?= $this->element('header'); ?>
        <?= $this->fetch('content') ?>
    </div>
    <footer>
    </footer>
</body>
</html>
