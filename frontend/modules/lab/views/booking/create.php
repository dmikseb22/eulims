<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\lab\Booking */

$this->title = 'Create Booking';
$this->params['breadcrumbs'][] = ['label' => 'Bookings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="booking-create">

    <?= $this->render('_form', [
        'model' => $model,
		'sampletype' => $sampletype,
		'testname' => $testname,
		'customer'=>$customer
    ]) ?>

</div>
