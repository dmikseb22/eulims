<?php

namespace frontend\modules\finance\components\_class;
use Yii;
use yii\helpers\ReplaceArrayValue;
use kartik\mpdf\Pdf;
use frontend\modules\finance\components\models\Ext_Receipt as Receipt;
use yii\db\Query;
use common\models\finance\Accountingcode;
use common\models\finance\Paymentitem;
use common\models\collection\Collection;
use common\components\NumbersToWords;
use common\models\system\Rstl;
use common\models\system\Profile;
interface PDFEnum{
    const PDF_Browser="I";
    const PDF_Download="D";
    const PDF_File="F";
    const PDF_String="S";
}
/**
 * This PDF Class will generate PDF from YII2 Views
 * and can choose to where will the PDF be send[Browser, Download, File, String
 *
 * @author OneLab
 */
class OfficialReceipt implements PDFEnum{
    
    static $pdf;
    /**
     * 
     * @param string $content The generated Views that to be converted to PDF 
     */
    public function __construct($opt=null) {
       
    }
    private function ORTemplate($ORNumber,$ORTitle){
        $numbertowords=new NumbersToWords();
        $Collection= Receipt::find()->where(['or_number'=>$ORNumber])->one();
        $rstl= Rstl::find()->where(['rstl_id'=>$Collection->rstl_id])->one();
       // var_dump($rstl);
       // exit;
       // $modeofpayment=$Collection->mode
        $space="";
        for($x=1;$x<30;$x++){
            $space.="&nbsp;";
        }
        $space1="";
        for($x=1;$x<18;$x++){
            $space1.="&nbsp;";
        }
        $space3="";
        for($x=1;$x<25;$x++){
            $space3.="&nbsp;";
        }
        $ORHeader="<table border='0' width=100% cellpadding='0' cellspacing='0'>";
        $ORHeader.="<thead>";
        
        $ORHeader.="<tr>";
        $ORHeader.="<td colspan='8' style='height:107px'>&nbsp;</td>";
        $ORHeader.="</tr>";
        
        $ORHeader.="<tr>";
        $ORHeader.="<td colspan='3' style='height:29px'></td>";
        $datetime=$Collection->receiptDate;
        $ORHeader.="<td colspan='5' style='text-align:left;padding-right: 15px'>".date("m/d/Y ", strtotime($datetime))."&nbsp;</td>";
        $ORHeader.="</tr>";
        $ORHeader.="</thead>";
        $ORHeader.="<tbody>";
       
        /*$ORHeader.="<tr>";
        $ORHeader.="<td colspan='8'>&nbsp;</td>";
        $ORHeader.="</tr>";*/
        
        
        $ORHeader.="<tr>";
        //$ORHeader.="<td colspan='1' ></td>";
        $ORHeader.="<td colspan='8' style='height:30px'>".$space1."".$rstl->name."</td>";
       
        $ORHeader.="</tr>";
        
        $ORHeader.="<tr>";
        //$ORHeader.="<td colspan='1' style='height:35px'></td>";
        $ORHeader.="<td colspan='8' style='height:35px'>".$space1."".$Collection->payor."</td>";
        $ORHeader.="</tr>";
        
        $ORHeader.="<tr>";
        $ORHeader.="<td colspan='8' style='height:38px'>&nbsp;</td>";
        $ORHeader.="</tr>";
       // echo $Collection->receipt_id;
      //  exit;
        $paymentitem_Query = Paymentitem::find()->where(['receipt_id' => $Collection->receipt_id])->all();
        //$count = $paymentitem_Query->count();
        //echo $count;
       // exit;
        $count=0;
        
        //$accountcodeid=$Collection->accountingcodemap->accountingcode_id;
        //$accountcode=Accountingcode::find()->where(['accountingcode_id' => $accountcodeid])->one();
        
        //$accountcodeid=$Collection->accountingcodemap->accountingcode_id;
        $accountcode="";
        
        
        $ORHeader.="<tr>";
        $ORHeader.="<td colspan='2' style='height:22px;width:166px;font-size:11px;'>&nbsp;&nbsp;&nbsp;".$Collection->collectiontype->natureofcollection."</td>";
        $ORHeader.="<td colspan='3' style='text-align:left;'>&nbsp;".$accountcode."</td>";
        $ORHeader.="<td colspan='3'>&nbsp;</td>";
        $ORHeader.="</tr>";
        
        $paymentmode=$Collection->paymentMode->payment_mode;
        $cash='';
        $check='';
        $mo='';
        if($paymentmode == 'Cash'){
            $cash='/';
        }
        else if($paymentmode == 'Check'){
            $check='/';
        }
        else if($paymentmode == 'Money Order'){
            $mo='/';
        }
       // echo $accountcode->accountcode;
       // exit;
        foreach ($paymentitem_Query as $i => $or) {
           // echo $Collection->receipt_id;
            $ORHeader.="<tr>";
            $ORHeader.="<td colspan='2' style='height:22px;width:166px;font-size:11px;'>&nbsp;&nbsp;".$or['details']."</td>";
            $ORHeader.="<td colspan='3'>&nbsp;</td>";
            $ORHeader.="<td colspan='3' style='text-align:right;padding-right: 20px;font-size:11px;'>&nbsp;".number_format($or['amount'],2)."</td>";
            $ORHeader.="</tr>";
            $count++;
        }
        $num= 7-$count;
        
       // exit;
        for($i=1;$i<$num;$i++){
            $ORHeader.="<tr>";
            $ORHeader.="<td colspan='2' style='height:22px;width:166px;'>&nbsp;</td>";
            $ORHeader.="<td colspan='3'>&nbsp;</td>";
            $ORHeader.="<td colspan='3'>&nbsp;</td>";
            $ORHeader.="</tr>";
        }
        $ORHeader.="<tr>";
        $ORHeader.="<td colspan='8' style='height:2px'>&nbsp;</td>";
        $ORHeader.="</tr>";
        
        $ORHeader.="<tr>";
        $ORHeader.="<td colspan='6' style='height:24px'>&nbsp;</td>";
        $ORHeader.="<td colspan='2' style='text-align:right;padding-right: 20px;font-size:12px;'>&nbsp;".number_format($Collection->total,2)."</td>";
        $ORHeader.="</tr>";
        
        $ORHeader.="<tr>";
        $ORHeader.="<td colspan='8' style='height:4px'></td>";
        $ORHeader.="</tr>";
        
        $amountinwords=$numbertowords->convert($Collection->total);
        $whole_number=(int)$Collection->total;
        $remainder=$Collection->total - $whole_number;
        if (!$remainder){
            $amountinwords.=" And 00/100";
        }
        
        $ORHeader.="<tr>";
        //$ORHeader.="<td colspan='8' style='height:22px'>&nbsp;</td>";
        $ORHeader.="<td colspan='8' style='vertical-align:top;word-wrap:break-word;height:52px;padding-left: 10px;font-size:11px;'>&nbsp;&nbsp;&nbsp;".$space." ".$amountinwords."</td>";
        $ORHeader.="</tr>";
        
        
        $ORHeader.="<tr>";//Cash
        $ORHeader.="<td colspan='8' style='word-wrap:break-word;height:24px;'>&nbsp;&nbsp;&nbsp;&nbsp;".$cash."</td>";
        $ORHeader.="</tr>";
        
        if ($check <> ''){
            $ORHeader.="<tr>";//Check
            $ORHeader.="<td colspan='2' style='height:24px;font-size:12px;'>&nbsp;&nbsp;&nbsp;&nbsp;".$check."".$space3."Metrobank</td>";
            $ORHeader.="<td colspan='4' style='height:24px;text-align:right;padding-right: 10px;font-size:12px;'>107661</td>";
            $ORHeader.="<td colspan='2' style='word-wrap:break-word;height:24px;font-size:12px;padding-right: 10px'>&nbsp;&nbsp;".date("m/d/Y", strtotime($datetime))."</td>";
            $ORHeader.="</tr>";
        }else{
           $ORHeader.="<tr>";//Check
           $ORHeader.="<td colspan='8' style='word-wrap:break-word;height:24px;'>&nbsp;&nbsp;&nbsp;&nbsp;".$check."</td>";
           $ORHeader.="</tr>";
        }
        
//        $ORHeader.="<tr>";//Check
//        $ORHeader.="<td colspan='8' style='word-wrap:break-word;height:24px;'>&nbsp;&nbsp;&nbsp;&nbsp;".$check."</td>";
//        $ORHeader.="</tr>";
        
        $ORHeader.="<tr>";//Money Order
        $ORHeader.="<td colspan='8' style='word-wrap:break-word;height:24px;'>&nbsp;&nbsp;&nbsp;&nbsp;".$mo."</td>";
        $ORHeader.="</tr>";
        
        $Profile= Profile::find()->where(['user_id'=> Yii::$app->user->id])->one();
        $user_name=$Profile->fullname;
        
        $ORHeader.="<tr>";
        //$ORHeader.="<td colspan='1' style='height:107px;'>&nbsp;</td>";
        $ORHeader.="<td colspan='8' style='height:94px;text-align:left;padding-left: 10px'>&nbsp;&nbsp;&nbsp;&nbsp;".$space." ".$user_name."</td>";
        $ORHeader.="</tr>";
        
        $ORHeader.="</tbody>";
        $ORHeader.="</table>";
      
     //   $footer="<table border='0' width=100%>";
       
      //  $footer.="</table>";
        $ORTemplate=[
           0=> $ORHeader,
          // 1=> $footer
        ];
        return $ORTemplate;
    }
    /**
     * 
     * @param type $dest
     */
    public function PrintPDF(){
        $get= \Yii::$app->request->get();
       // $Request_id=$get['req'];
        $ORNumber=$get['or_number'];
        $mORTemplate= $this->ORTemplate($ORNumber, "");
        $mPDF = new Pdf();
        $mPDF->content=$mORTemplate[0];
        $mPDF->orientation=Pdf::ORIENT_PORTRAIT;
        $mPDF->marginLeft=7.0;
        $mPDF->marginRight=7.0;
        $mPDF->marginTop=13.0;
        $mPDF->marginBottom=0.5;
        $mPDF->defaultFontSize=9;
       // $mPDF->cssFile="/assets/251be39e/css/bootstrap.min.css";
        $mPDF->defaultFont='Verdana';
        $mPDF->format=[102,203]; //Customed Sizes
        $mPDF->destination= Pdf::DEST_BROWSER;
        //$Footer="<barcode code='$ORNumber' type='C39' size='1.5' height='0.5'/>";
        $mPDF->methods=[ 
            //'SetHeader'=>['Z.C. INTEGRATED PORT SERVICES, INC.'], 
           // 'SetFooter'=>[$mORTemplate[1]]
        ];
        $mPDF->render();
        exit;
    } 
}
