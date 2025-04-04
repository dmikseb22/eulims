<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ListView;
use yii\widgets\Pjax;
?>

<div class="notification-view notification-display">
<div class="alert alert-info" style="border-bottom: 2px solid #555;margin-bottom:2px;">
  <strong style="color:#000;">List of Notifications</strong>
</div>
<?php
echo ListView::widget([
    'dataProvider' => $notificationProvider,
    'itemOptions' => ['class' => 'item'],
    'itemView' => '_list_item',
    //'viewParams' => ['notifications' => $notifications,'count_notice'=>$count_notice],
    'viewParams' => ['count_notice'=>$count_notice],
    'summary' => false,
    'emptyText' => '<div style="padding:5px;font-size:12px;background-color:#bbb;">No notifications to be displayed.</div>',
    'pager' => [
    	'class' => \kop\y2sp\ScrollPager::className(),
    	'spinnerSrc' => '/images/img-png-loader-24.png',
    	'triggerText' => 'Load more',
    	'triggerTemplate' => '<button type="button" class="btn btn-primary btn-xs btn-block" style="font-size:13px;">{text}</button>',
    	'noneLeftText' => 'No more notifications left to load.',
    	'noneLeftTemplate' => '<button type="button" class="btn btn-default btn-xs btn-block" style="font-size:12px;">{text}</button>',
    	'enabledExtensions' => [
    		\kop\y2sp\ScrollPager::EXTENSION_TRIGGER,
    		\kop\y2sp\ScrollPager::EXTENSION_SPINNER,
    		\kop\y2sp\ScrollPager::EXTENSION_NONE_LEFT,
    		\kop\y2sp\ScrollPager::EXTENSION_PAGING,
    	],
    ]
]);
?>

</div>

<style type="text/css">
.notification-display ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
}

.notification-display li {
  border-bottom: 1px solid #888;
  padding: 4px 15px 4px 15px;
  background: #ebf7e6;
  font-size: 12px;
  color: #444;
}

.notification-display li:hover {
  background: #fff5d4;
  cursor: pointer;
}

.notification-display li.see-all {
	text-align: center;
	padding: 5px;
	background: #3c8dbc;
	color: #ffffff;
}
.notification-display li.label-action {
	padding: 2px 20px 2px 20px;
	background: #eee;
	font-size:12px;
	text-transform: uppercase;
	font-weight: bold;
	color: #555;
}
.notification-display .notification-date {
	color: #777;
	font-size: 11px;
}
.notification-display a:link, a:hover, a:active {
	text-decoration: none;
	display: block;
	background-color:none;
	color: #444;
}
</style>

