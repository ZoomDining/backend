<?php
use frontend\assets\AppAsset;
use frontend\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
    <?php $this->beginBody() ?>
    <header class="header clearfix">
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
            <a class="logo-site-ag" href="<?= Yii::$app->homeUrl ?>">
                <img src="<?= Yii::$app->homeUrl . "img/logo.png" ?>" alt="<?= Yii::$app->name ?>"/>
            </a>
        </div>
        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-10">
            <?php echo $this->render("navbar"); ?>
        </div>
    </header>
    <div class="wrap">

        <div class="container-fluid">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
        <p class="pull-right">&copy; <?= Yii::t('frontend', Yii::$app->name) ?> <?= date('Y') ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
