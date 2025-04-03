<?php

use yii\helpers\Html;

?>

<div class="notification-views-unresponded notification-display-unresponded">
  <ul>
	<?php if(count($notifications) > 0 ) : ?>
	<li class="label-action">Action is needed</li>
		<?php foreach($notifications as $notification): ?>
		<?= "<a href='/referrals/bid/viewnotice?referral_id=".$notification['referral_id']."&notice_id=".$notification['notice_id']."&seen=1'>" ?>
		<li>
			<?= $notification['notice_sent'] ?><br>
			<span class="notification-date"><?= date("d-M-Y g:i A", strtotime($notification['notification_date'])) ?></span>
		</li></a>
		<?php endforeach; ?>
	<?php else: ?>
		<li>No unseen notification.</li>
	<?php endif; ?>
	<button type="button" class="btn btn-primary btn-xs btn-block" id="btn_see_all" style="font-size:13px;">See All</button>
  </ul>


</div>

<style type="text/css">
.notification-display-unresponded ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
}

.notification-display-unresponded li {
  border-bottom: 1px solid #888;
  padding: 4px 20px 4px 20px;
  background: #e1e1e1;
  font-size: 12px;
  color: #444;
}

.notification-display-unresponded li:hover {
  background: #fff5d4;
  cursor: pointer;
}

.notification-display-unresponded li.see-all {
	text-align: center;
	padding: 5px;
	background: #3c8dbc;
	color: #ffffff;
}
.notification-display-unresponded li.label-action {
	padding: 2px 20px 2px 20px;
	background: #eee;
	font-size:12px;
	text-transform: uppercase;
	font-weight: bold;
	color: #555;
}
.notification-display-unresponded .notification-date {
	color: #777;
	font-size: 11px;
}
.notification-display-unresponded a:link, a:hover, a:active {
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
	window.open('/referrals/bidnotification','_self');
});
</script>

