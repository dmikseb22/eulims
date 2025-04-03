<?php
use dosamigos\gallery\Carousel;
use common\models\help\TopicsDetails;
use common\models\help\Topics;

$topic= Topics::find()->where(['topic_id'=>$id])->one();
$this->title = 'FAQs';
$this->params['breadcrumbs'][] = ['label' => 'FAQs', 'url' => ['/help/faqs']];
$this->params['breadcrumbs'][] = $topic->details;
?>
<?php 
 $list = TopicsDetails::find()->where(['topic_id'=>$id])->all();
 $item=[];
  foreach ($list as $i => $lists) {
      $arr_val=[
        'title' => $lists->title,
        'href' => $lists->href,
        'type' => $lists->type,

      ];
      
      array_push($item, $arr_val);
  }

$items = [
    
];?>
<?= dosamigos\gallery\Carousel::widget([
    'items' => $item, 
    'json' => true,
    'options'=>[
        'disableScroll'=>true,
    ],
    'clientEvents' => [
        'onslide' => 'function(index, slide) {
            console.log(slide);
        }'
]]);
