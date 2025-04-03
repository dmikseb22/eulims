<?php
// _list_item.php
use yii\helpers\Html;
?>

<?php if($count_notice > 0) : ?>
	<?= "<a href='/referrals/bid/viewnotice?referral_id=".$model['referral_id']."&notice_id=".$model['notice_id']."&seen=1'>" ?>
		<div <?= $model['seen'] == 0 ? 'class="unresponded-notice"' : 'class="responded-notice"'; ?>>
			<?= $model['notice_sent'] ?><br>
			<span class="notification-date"><?= date("d-M-Y g:i A", strtotime($model['notification_date'])) ?></span>
		</div>
		</a>
<?php else: ?>
	<div>No notifications to be displayed.</div>
<?php endif; ?>