<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->request_no;
$this->params['breadcrumbs'][] = ['label' => 'Archives', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="archive-view">

    <section class="invoice">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-globe"></i> <?php echo $model->customer; ?>
                    <small class="pull-right">Request # : <?php echo $model->request_no; ?></small>
                </h2>
            </div>
        </div>

        <?php $request = json_decode($model->content,true)?>

        <div class="row invoice-info">

            <div class="col-sm-6 invoice-col">
                <address>
                    Name : <strong> <?= $request[0]['customer']['name'] ?></strong><br>
                    Address : <?= $request[0]['customer']['address'] ?><br>
                    Conforme : <?= ucwords(strtolower($request[0]['request']['conforme'])) ?><br>
                    Received By : <?= $request[0]['request']['received_by'] ?><br>
                </address>
            </div>
            <div class="col-sm-6 invoice-col">
                <address>
                    Ref # : <strong> <?= $request[0]['request']['reference_num'] ?></strong><br>
                    Labtype : <?= $request[0]['request']['labtype'] ?><br>
                    Purpose : <?= $request[0]['request']['purpose'] ?><br>
                    Date Requested : <?= $request[0]['request']['request_datetime'] ?><br>
                </address>
            </div>

        </div>

        <div class="row"><br>
            <div class="col-xs-12 table-responsive">
            <p class="lead" style="font-size: 14px; font-weight: bold;">Samples & Analysis :</p>
            <?php $sub = 0; ?>
                <?php foreach($request[0]['samples'] as $sample) {?>
                <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                    <span><?= $sample['code'] ?> </span>|
                    <?= $sample['name'] ?> |
                    <?= $sample['description'] ?>
                </p>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Reference</th>
                            <th>Method</th>
                            <th>Fee</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($sample['analysis'] as $analysis) {?>
                        <tr>
                            <td><?= $analysis['name'] ?></td>
                            <td><?= $analysis['references'] ?></td>
                            <td><?= $analysis['method'] ?></td>
                            <td><?= $analysis['fee'] ?></td>
                            <?php $sub = $sub +  $analysis['fee'] ?>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <br>
                <?php } ?>

            </div>
        </div>
        
        <hr>

        <?php  if(!empty($request[0]['payments']) && $request[0]['payments'] != 'Not Available'){ ?>
        <div class="row">
            <div class="col-xs-12">
                <p class="lead" style="font-size: 14px; font-weight: bold;">Payment History & Details :</p>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Payor</th>
                            <th>Transaction No.</th>
                            <th>Receipt ID</th>
                            <th>Purpose</th>
                            <th>Mode</th>
                            <th>Date</th>
                            <th>Amount</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($request[0]['payments'] as $pay) {?>
                        <tr>
                            <td><?= $pay['payor'] ?></td>
                            <td><?= $pay['transactionNum'] ?></td>
                            <td><?= $pay['receiptId'] ?></td>
                            <td><?= $pay['purpose'] ?></td>
                            <td><?= $pay['payment_mode'] ?></td>
                            <td><?= $pay['receipt_date'] ?></td>
                            <td><?= $pay['amount'] ?></td>
                        </tr>
                        <?php if($pay['payment_mode'] == 'Check'){ ?>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Bank</th>
                                        <th>Cheque No.</th>
                                        <th>Cheque Date</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($request[0]['payments'] as $pay) {?>
                                    <tr>
                                        <td><?= $pay['bank'] ?></td>
                                        <td><?= $pay['check'] ?></td>
                                        <td><?= $pay['check_date'] ?></td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        <?php } ?>
                        <?php }?>
                    </tbody>
                </table>
               
            </div>
        </div>
        <?php } ?>

        <div class="row">
            <div class="col-xs-6"></div>
            <div class="col-xs-6">
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th style="width:50%">Subtotal:</th>
                                <td>₱ <?= number_format($sub,2); ?></td>
                            </tr>
                            <tr>
                                <th>Discount :</th>
                                <td> <?= round($request[0]['request']['discount'],0);?>%</td>
                            </tr>
                            <tr>
                                <th>Total:</th>
                                <td>₱ <?= number_format($request[0]['request']['total'],2); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </section>

</div>