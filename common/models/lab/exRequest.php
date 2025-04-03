<?php

/*
 * Project Name: eulims_ * 
 * Copyright(C)2018 Department of Science & Technology -IX * 
 * 07 27, 18 , 12:01:47 PM * 
 * Module: exRequest * 
 */

namespace common\models\lab;
use Yii;
use common\models\lab\Request;
/**
 * @property int $hasop
 *
 * @author OneLab
 */
class exRequest extends Request{
    /**
     * Function that will check of request has an OP
     */
    public function IsRequestHasOP(){
        $Connection=Yii::$app->financedb;
        $SQL="SELECT COUNT(*)>0 AS HasOP FROM `tbl_paymentitem` WHERE `request_id`=:requestID";
        $Command=$Connection->createCommand($SQL);
        $Command->bindValue(':requestID', $this->request_id);
        $Row=$Command->queryOne();
        return $Row['HasOP']>0;
    }
    public function IsRequestHasReceipt(){
        $Connection=Yii::$app->labdb;
        $SQL="SELECT COUNT(*)>0 HasReceipt FROM `tbl_request` WHERE `request_id`=:requestID AND `payment_status_id`>1";
        $Command=$Connection->createCommand($SQL);
        $Command->bindValue(':requestID', $this->request_id);
        $Row=$Command->queryOne();
        return $Row['HasReceipt'];
    }
    public function getHasop(){
        $Connection=Yii::$app->financedb;
        $SQL="SELECT COUNT(*)>0 AS HasOP FROM `tbl_paymentitem` WHERE `request_id`=:requestID";
        $Command=$Connection->createCommand($SQL);
        $Command->bindValue(':requestID', $this->request_id);
        $Row=$Command->queryOne();
        return $Row['HasOP']>0;
    }
}
