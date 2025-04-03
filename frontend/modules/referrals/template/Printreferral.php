<?php



namespace frontend\modules\referrals\template;
use Yii;
use kartik\mpdf\Pdf;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\VarDumper;
use common\components\OldreferralComponent;
use common\models\lab\Customer;
/**
 * Description of RequestPrinting
 *
 * @author OneLab - BTC
 */
class Printreferral {

    public $totalfinal = 0;

    public function Printing($id) {

        //get the info in the api
        $oldreferralcomp = new OldreferralComponent;
        $response = $oldreferralcomp->printreferral($id);
        // var_dump($response); exit;
        if(false){
            return "Wasn't able to connect to the API!, Pls close this tab and try again or Contact system administrator";
            exit;
        }
        $mTemplate = $this->RequestTemplate($response);

        $pdfFooter = [
            'L' => [
                'content' => '',
                'font-size' => 0,
                'font-style' => 'B',
                'color' => '#999999',
            ],
            'C' => [
                'content' => '{PAGENO}',
                'font-size' => 10,
                'font-style' => 'B',
                'font-family' => 'arial',
                'color' => '#333333',
            ],
            'R' => [
                'content' => '',
                'font-size' => 0,
                'font-style' => 'B',
                'font-family' => 'arial',
                'color' => '#333333',
            ],
            'line' => false,
        ];
        $mPDF = new Pdf(['cssFile' => 'css/pdf.css']);
        //$html = mb_convert_encoding($mTemplate, 'UTF-8', 'UTF-8');
        //$mPDF=$PDF->api;
        $mPDF->content = $mTemplate;
        $mPDF->orientation = Pdf::ORIENT_PORTRAIT;
        $mPDF->defaultFontSize = 9;
        $mPDF->defaultFont = 'freesans';
        $mPDF->format =Pdf::FORMAT_A4;
        $mPDF->destination = Pdf::DEST_BROWSER;
        $mPDF->methods =['SetFooter'=>['|{PAGENO}|']];
        $mPDF->footercontent = $this->RequestTemplateFooter($response);
        $mPDF->render();
        exit;
    }

    private function RequestTemplate($data) {
        $agency = $data->agency;
        $referral = $data->referral;

        $RequestTemplate = "<table border='0' style='border-collapse: collapse;font-size: 11px;table-layout:fixed' width=100%>";
        $RequestTemplate .= "<thead>";
        $RequestTemplate .= "<tr>";
        $RequestTemplate .= "<td colspan='10' style='text-align: center;font-size: 11px'>".$agency->name."</td>";
        $RequestTemplate .= "</tr>";
        $RequestTemplate .= "<tr>";
        $RequestTemplate .= "<td colspan='10' style='text-align: center;font-size: 11px;font-weight: bold'>REGIONAL STANDARDS AND TESTING LABORATORIES</td>";
        $RequestTemplate .= "</tr>";
        $RequestTemplate .= "<tr>";
        $RequestTemplate .= "<td colspan='10' style='width: 100%;text-align: center;font-size: 11px;word-wrap: break-word'><div style='width: 100px;'>".$agency->address."</div></td>";
        $RequestTemplate .= "</tr>";
        $RequestTemplate .= "<tr>";
        $RequestTemplate .= "<td colspan='10' style='text-align: center;font-size: 11px'><div style='width: 100px;'>".$agency->contacts."</div></td>";
        $RequestTemplate .= "</tr>";
        $RequestTemplate .= "<tr>";
        $RequestTemplate .= "<td colspan='10' style='text-align: center;font-size: 11px'>&nbsp;</td>";
        $RequestTemplate .= "</tr>";
        $RequestTemplate .= "<tr>";
        $RequestTemplate .= "<td colspan='10' style='text-align: center;font-weight: bold;font-size: 15px'>Request for " . strtoupper($agency->shortName) . " RSTL Services</td>";
        $RequestTemplate .= "</tr>";
        $RequestTemplate .= "<tr>";
        $RequestTemplate .= "<td colspan='10'>&nbsp;</td>";
        $RequestTemplate .= "</tr>";
        $RequestTemplate .= "<tr>";
        $RequestTemplate .= "</thead>";
        $RequestTemplate .= "<tbody>";
        $RequestTemplate .= "<tr>";
        $RequestTemplate .= "<td colspan='2' style='border-top: 1px solid black;border-left: 1px solid black;font-size:10px'>Request Reference No.:</td>";
            $RequestTemplate .= "<td colspan='3' style='border-top: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;text-align: left;color:#000;font-weight;margin-left-20px'>".$referral->referralCode."</td>";
            $RequestTemplate .= "<td colspan='5'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='2' style='border-left: 1px solid black;border-top: 1px solid black;font-size:11px'>Date :</td>";

            $RequestTemplate .= "<td colspan='3' style='border-top: 1px solid black;border-right: 1px solid black;text-align: left;color:#000'>" . date('F d, Y',strtotime($referral->referralDate)) . "</td>";
            $RequestTemplate .= "<td colspan='5'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='2' style='border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;font-size:11px'>Time :</td>";
            $RequestTemplate .= "<td colspan='3' style='border-top: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;text-align: left;color:#000'>" . date('h:i a',strtotime($referral->referralTime)) . "</td>";
            $RequestTemplate .= "<td colspan='5'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='10' style='height: 5px'></td>";
            $RequestTemplate .= "</tr>";

            //get the customer information, if the user has the same agency/rstl id as the receiving ID then we can display the customer , as the record is in the local server of the lab
            $customer = false;
            if(Yii::$app->user->identity->profile->rstl_id==$referral->receivingAgencyId){
                $customer = Customer::findOne($referral->customer_id);                
            }
            
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td style='border-top: 1px solid black;border-left: 1px solid black'>Customer:</td>";
            $RequestTemplate .= "<td colspan='6' style='color:#000;border-top: 1px solid black;font-weight:bold'>" .($customer?$customer->customer_name:"Customer from Referral networkz"). "</td>";
            $RequestTemplate .= "<td style='border-top: 1px solid black;border-top: 1px solid black;border-left: 1px solid black;'>Tel No.:</td>";
            $RequestTemplate .= "<td colspan='2' style='color:#000;border-top: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;'>".($customer?$customer->tel:"Hidden")."</td>";
            $RequestTemplate .= "</tr>";
            
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td style='border-bottom: 1px solid black;border-left: 1px solid black;'>Address:</td>";
            $RequestTemplate .= "<td colspan='6' style='color:#000;border-bottom: 1px solid black;border-bottom: 1px solid black;'>".($customer?$customer->completeaddress:"Hidden")."</td>";
            $RequestTemplate .= "<td style='border-bottom: 1px solid black;border-left: 1px solid black;'>Fax No.:</td>";
            $RequestTemplate .= "<td colspan='2' style='color:#000;border-bottom: 1px solid black;border-right: 1px solid black;'>".($customer?$customer->tel:"Hidden")."</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr ><td style='height:10px'></td></tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<th colspan='10' class='text-left border-bottom-line'>1.  TESTING OR CALIBRATION SERVICE</th>";
            $RequestTemplate .= "</tr>";
            
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<th colspan='2' class='text-center border-center-line border-left-line border-right-line padding-left-5'>Sample</th>";
            $RequestTemplate .= "<th class='text-center border-bottom-line border-right-line padding-left-5' style='width: 10%;'>Sample Code</th>";
            $RequestTemplate .= "<th colspan='2' class='text-center border-bottom-line border-right-line padding-left-5' style='width: 20%;'>Calibration or Test Requested</th>";
            $RequestTemplate .= "<th colspan='2' class='text-center border-bottom-line border-right-line padding-left-5' style='width: 15%;'>Calibration or Test Method</th>";
            $RequestTemplate .= "<th class='text-center border-bottom-line border-right-line padding-left-5' style='width: 9%;'>No. of Samples</th>";
            $RequestTemplate .= "<th class='text-center border-bottom-line border-right-line padding-right-5' style='width: 9%;'>Unit Cost</th>";
            $RequestTemplate .= "<th class='text-center border-bottom-line border-right-line border-right-line padding-right-5' style='width: 11%;'>Total</th>";
            $RequestTemplate .= "</tr>";
            
            $CurSampleCode = "";
            $PrevSampleCode = "";

            $i = 0;
            //loop for everysamples the request has
            foreach ($referral->samples as $sample) {
               
                $RequestTemplate .= "<tr>";
                    $RequestTemplate .= "<td style='color:#000' class='text-left border-left-line border-top-line border-bottom-line padding-left-5' colspan='2'><i>".$sample->sampleName."</i></td>";
                    $RequestTemplate .= "<td style='color:#000' class='text-left border-left-line border-top-line border-right-line border-bottom-line padding-left-5'>".$sample->sampleCode."</td>";
                $analysisfirst = 0;
                    $totalfee =0;
                foreach($sample->analyses as $analysis){
                    //get the fee
                    $totalfee += $analysis->fee;

                    if($analysisfirst==0){
                        $analysisfirst++; //increment so that it will just run on the first try
                    }else{
                        //put 2 empty td
                        $RequestTemplate .= "<tr>";
                        $RequestTemplate .= "<td class='text-left border-left-line border-top-line border-bottom-line' colspan='2'></td>";
                        $RequestTemplate .= "<td class='text-left border-right-line border-top-line border-left-line border-bottom-line'></td>";
                    }
                    $RequestTemplate .= "<td style='color:#000' class='text-left border-bottom-line border-top-line border-right-line padding-left-5' colspan='2'>".$analysis->testName."</td>";
                    $RequestTemplate .= "<td style='color:#000;word-wrap: break-word;' class='text-left border-bottom-line border-top-line border-right-line padding-left-5 padding-right-5' colspan='2'>".$analysis->method."</td>";
                    $RequestTemplate .= "<td style='color:#000' class='text-center border-bottom-line border-top-line border-right-line'>1</td>";
                    $RequestTemplate .= "<td style='color:#000' class='text-right border-bottom-line border-top-line border-right-line padding-right-5'>".$analysis->fee."</td>";
                    $RequestTemplate .= "<td style='color:#000' class='text-right border-bottom-line border-top-line border-right-line padding-right-5'>".$analysis->fee."</td>";
                    $RequestTemplate .= "</tr>";
                }
            }
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td style='color:#000' class='text-left border-left-line border-top-line border-bottom-line padding-left-5' colspan='2'></td>";
            $RequestTemplate .= "<td style='color:#000' class='text-left border-left-line border-top-line border-right-line border-bottom-line padding-left-5'></td>";
            $RequestTemplate .= "<td style='color:#000' class='text-left border-bottom-line border-top-line border-right-line padding-left-5' colspan='2'></td>";
            $RequestTemplate .= "<td style='color:#000;word-wrap: break-word;' class='text-left border-bottom-line border-top-line border-right-line padding-left-5 padding-right-5' colspan='2'></td>";
            
            $RequestTemplate .= "<td class='text-right border-left-line  border-bottom-line'></td>";
            $RequestTemplate .= "<td class='text-right border-left-line border-bottom-line padding-right-5'>Sub-Total</td>";
            $RequestTemplate .= "<td style='color:#000;font-weight:bold;font-size:10px' class='text-right border-left-line border-bottom-line border-right-line padding-right-5'>".number_format($totalfee,2)."</td>";
            $RequestTemplate .= "</tr>";
            // Discount
            $RequestTemplate .= "<tr>";
             $RequestTemplate .= "<td style='color:#000' class='text-left border-left-line border-top-line border-bottom-line padding-left-5' colspan='2'></td>";
            $RequestTemplate .= "<td style='color:#000' class='text-left border-left-line border-top-line border-right-line border-bottom-line padding-left-5'></td>";
            $RequestTemplate .= "<td style='color:#000' class='text-left border-bottom-line border-top-line border-right-line padding-left-5' colspan='2'></td>";
            $RequestTemplate .= "<td style='color:#000;word-wrap: break-word;' class='text-left border-bottom-line border-top-line border-right-line padding-left-5 padding-right-5' colspan='2'></td>";
            
            $RequestTemplate .= "<td class='text-right border-left-line border-bottom-line'></td>";
            $RequestTemplate .= "<td class='text-right border-left-line border-bottom-line padding-right-5'>Discount</td>";
            $RequestTemplate .= "<td style='color:#000;font-weight:bold;font-size:10px' class='text-right border-left-line border-bottom-line border-right-line padding-right-5'>".($referral->gratis?number_format($totalfee,2) :number_format(($totalfee * ($referral->discountrate * .01)),2))."</td>";
            $RequestTemplate .= "</tr>";

             $RequestTemplate .= "<tr>";
             $RequestTemplate .= "<td style='color:#000' class='text-left border-left-line border-top-line border-bottom-line padding-left-5' colspan='2'></td>";
            $RequestTemplate .= "<td style='color:#000' class='text-left border-left-line border-top-line border-right-line border-bottom-line padding-left-5'></td>";
            $RequestTemplate .= "<td style='color:#000' class='text-left border-bottom-line border-top-line border-right-line padding-left-5' colspan='2'></td>";
            $RequestTemplate .= "<td style='color:#000;word-wrap: break-word;' class='text-left border-bottom-line border-top-line border-right-line padding-left-5 padding-right-5' colspan='2'></td>";
            
            $RequestTemplate .= "<td class='text-right border-left-line border-bottom-line'></td>";
            $RequestTemplate .= "<td style='color:#000;font-weight:bold;font-size:10px' class='text-right border-left-line border-bottom-line border-right-line padding-right-5'>Total</td>";
            $this->totalfinal = ($referral->gratis?number_format(0,2) :number_format($totalfee - ($totalfee * ($referral->discountrate * .01)),2));
            $RequestTemplate .= "<td style='color:#000;font-weight:bold;font-size:10px' class='text-right border-left-line border-bottom-line border-right-line padding-right-5'>".$this->totalfinal."</td>";
            $RequestTemplate .= "</tr>";

            
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-right' colspan='8'></td>";
            $RequestTemplate .= "<th class='text-right padding-right-5'></th>";
            // $Total=$request->total-$request->;
            $RequestTemplate .= "<th style='color:#000' class='text-right padding-right-5'></th>";
            
            $RequestTemplate .= "</tr>";
            
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='10' class='text-left'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<th colspan='10' class='text-left border-bottom-line'>2. BRIEF DESCRIPTION OF THE SAMPLE/REMARKS</th>";
            $RequestTemplate .= "</tr>";
            //BRIEF DESCRIPTION
            $CurSampleCode2 = "";
            $PrevSampleCode2 = "";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-left border-left-line border-top-line border-right-line padding-right-5 padding-left-5' colspan='10'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            foreach ($referral->samples as $sample) {
                        $RequestTemplate .= "<tr>";
                        $RequestTemplate .= "<td style='color:#000;' class='text-left border-left-line border-right-line padding-left-5' colspan='10'> ".$sample->sampleName.":".$sample->sampleCode." : <i>".$sample->description."</i>";
            }
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-left border-bottom-line border-left-line border-right-line padding-right-5 padding-left-5' colspan='10'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "</table>";
            

        return $RequestTemplate;
        
    }

    private function RequestTemplateFooter($data){
        $referral = $data->referral;
            $totalfee = 0;
            foreach($referral->samples as $sample){
                foreach($sample->analyses as $analysis){
                    $totalfee += $analysis->fee;
                }
            }
            $RequestTemplate = "<table style='width: 100%;border-collapse:collapse;font-size: 11px'>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='7'></td>";
            $RequestTemplate .= "<td colspan='1' class='text-right text-bold border-bottom-line' style='font-size:10px'>TOTAL</td>";
            $RequestTemplate .= "<td  style='color:#000;font-size:10px' colspan='2' class='text-right text-bold border-bottom-line'>P ".$this->totalfinal."</td>";
            $RequestTemplate .= "</tr>";

            
             $RequestTemplate .= "<tr ><td style='height:10px'></td></tr>";

             //We need to get the OR details of this request
             
            //Footer
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='2' class='text-left border-left-line border-top-line padding-left-5'>Official Receipt No.:</td>";
            $RequestTemplate .= "<td  style='color:#000' class='text-left border-top-line padding-left-5' colspan='3'></td>";
            $RequestTemplate .= "<td style='border-left: 1px solid black' class='border-top-line padding-left-5' colspan='2'>Amount Received:</td>";
            $RequestTemplate .= "<td colspan='3' style='color:#000' class='text-right border-top-line padding-left-5 border-right-line padding-right-5'></td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='2' class='text-left border-bottom-line border-left-line padding-left-5'>Date:</td>";
            $RequestTemplate .= "<td style='color:#000;' class='text-left border-bottom-line padding-left-5' colspan='3'></td>";
            $RequestTemplate .= "<td style='border-left: 1px solid black;' class='border-bottom-line padding-left-5' colspan='2'>Unpaid Balance:</td>";

            $RequestTemplate .= "<td style='color:#000;' colspan='3' class='text-right border-bottom-line padding-left-5 border-right-line padding-right-5'></td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-left' colspan='10'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
             //Report Due
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-left border-bottom-line border-left-line border-top-line padding-left-5'>Report Due On:</td>";
            $RequestTemplate .= "<td style='color:#000' class='text-left border-bottom-line border-top-line padding-left-5' colspan='4'>".date('F j, Y h:i a',strtotime($referral->referralDate.$referral->referralTime))."</td>";

            $RequestTemplate .= "<td class='text-right border-bottom-line border-top-line padding-left-5' colspan='3'></td>";
            $RequestTemplate .= "<td colspan='2' class='text-right border-bottom-line border-top-line padding-left-5 border-right-line padding-right-5'></td>";
            $RequestTemplate .= "</tr>";
             //Divider
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-left' colspan='10'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";

            $RequestTemplate .= "</table>";
            

            
            $RequestTemplate .= "<table style='width: 100%;border-collapse:collapse;font-size: 11px'><tbody>";
            $RequestTemplate .= "<tr>";

            $RequestTemplate .= "<td class='text-left border-bottom-line padding-right-5' style='width: 33%;'>Discussed with Customer</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .="<tr>";
            $RequestTemplate .= "<td class='text-left border-left-line border-top-line padding-left-5 border-right-line padding-right-5' style='width: 34%;'>Conforme:</td>";
            $RequestTemplate .= "<td class='text-left border-left-line border-top-line padding-left-5 border-right-line padding-right-5' style='width: 33%;'></td>";
            $RequestTemplate .= "<td class='text-left border-left-line border-top-line padding-left-5 border-right-line padding-right-5' style='width: 33%;'></td>";     
            $RequestTemplate .="<tr>";
            
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-center valign-bottom border-left-line border-bottom-line padding-left-5 border-right-line padding-right-5' style='height:35px;color:#000;width: 34%; '>".$referral->conforme."</td>";
            $RequestTemplate .= "<td class='text-center valign-bottom border-left-line border-bottom-line padding-left-5 border-right-line padding-right-5' style='color:#000;width: 33%;'>".$referral->receivedBy."</td>";

            //get the lab manager
            $RequestTemplate .= "<td class='text-center valign-bottom border-left-line border-bottom-line padding-left-5 border-right-line padding-right-5' style='color:#000;width: 33%;'></td>";
            $RequestTemplate .= "</tr>";
            
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-center border-bottom-line border-left-line border-top-line padding-left-5 border-right-line padding-right-5' style='width: 34%;'>Customer/Authorized Representative</td>";
            $RequestTemplate .= "<td class='text-center border-bottom-line border-left-line border-top-line padding-left-5 border-right-line padding-right-5' style='width: 33%;'>Sample/s Received By:</td>";
            $RequestTemplate .= "<td class='text-center border-bottom-line border-left-line border-top-line padding-left-5 border-right-line padding-right-5' style='width: 33%;'>Sample/s Reviewed By:</td>";
            $RequestTemplate .= "</tr>";
            
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-left border-left-line border-bottom-line border-top-line padding-left-5 padding-right-5' style='width: 34%;'>Report No.:</td>";
            $RequestTemplate .= "<td class='text-left border-bottom-line border-top-line padding-left-5 padding-right-5' style='width: 33%;'></td>";
            $RequestTemplate .= "<td class='text-left border-bottom-line border-top-line padding-left-5 border-right-line padding-right-5' style='width: 33%;'></td>";
            $RequestTemplate .= "</tr></tbody>";
            
            $RequestTemplate .= "<tfoot>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='10' style='text-align: right;font-size: 10px'>".$referral->number."</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='10' style='text-align: right;font-size: 8px'>".$referral->revNum." ".$referral->revDate."</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "</tfoot>";
            
            
            
            $RequestTemplate .="</table>";

        return $RequestTemplate;
    }
}


