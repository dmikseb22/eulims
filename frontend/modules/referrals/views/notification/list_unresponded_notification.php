<?php

use yii\helpers\Html;

?>

<div class="notification-view notification-display">
  <ul>
	<?php if(count($notifications) > 0 ) : ?>
	<li class="label-action">Action is needed</li>
		<?php foreach($notifications as $notification): ?>
		<?php if($notification['owner'] == 1): ?>
		<a href='<?= "/lab/request/view?id=".$notification['local_request_id']."&notice_id=".$notification['notice_id'] ?>'><li>
			<?= $notification['notice_sent'] ?><br>
			<span class="notification-date"><?= date("d-M-Y g:i A", strtotime($notification['notification_date'])) ?></span>
		</li></a>
		<?php else: ?>
		<a href='<?= "/referrals/referral/view?id=".$notification['referral_id']."&notice_id=".$notification['notice_id'] ?>'><li>
			<?= $notification['notice_sent'] ?><br>
			<span class="notification-date"><?= date("d-M-Y g:i A", strtotime($notification['notification_date'])) ?></span>
		</li></a>
		<?php endif; ?>
		<?php endforeach; ?>
	<?php else: ?>
		<li>No unresponded notification.</li>
	<?php endif; ?>
	<button type="button" class="btn btn-primary btn-xs btn-block" id="btn_see_all" style="font-size:13px;">See All</button>
  </ul>


</div>

<style type="text/css">
.notification-display ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
}

.notification-display li {
  border-bottom: 1px solid #888;
  padding: 4px 20px 4px 20px;
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
	/*display: inline-block;*/
	display: block;
	background-color:none;
	color: #444; 
}
</style>
<script type="text/javascript">
$("#btn_see_all").on('click', function(e) {
	e.preventDefault();
	window.open('/referrals/notification','_self');
});
</script>

