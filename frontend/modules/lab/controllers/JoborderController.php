<?php

namespace frontend\modules\lab\controllers;
use Yii;
use common\models\lab\Joborder;
use common\models\system\Profile;
use kartik\mpdf\Pdf;
use common\models\lab\Request;
use common\models\lab\Sample;
use common\models\lab\Analysis;
use common\models\lab\JoborderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * JoborderController implements the CRUD actions for Joborder model.
 */
class JoborderController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Joborder models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new JoborderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Joborder model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionMicro($id)
    {
        return $this->render('micro', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Joborder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Joborder();
        $post= Yii::$app->request->post();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        }

        if(Yii::$app->request->isAjax){

            //lsno
            //joborder_id
            $profile = Profile::find()->where(['user_id'=> Yii::$app->user->id])->one();
            $joborder = Joborder::find()->max('joborder_id');
            $model->lsono = 1;
            $model->joborder_id = $joborder + 1;
            $model->conforme = $profile->firstname.' '. strtoupper(substr($profile->middleinitial,0,1)).'. '.$profile->lastname;
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
       }
    }
       public function actionPrintjoborderone()
       {  
           
            $joborder = Joborder::find()->where(['joborder_id'=> $_GET['joborder_id']])->one();
     
            $mpdfConfig = array(
				'mode' => 'utf-8', 
				'format' => 'A4',    
				'default_font_size' => 0,     
				'default_font' => '',    
				'margin_left' => 15,    	
                'margin_right' => 15, 
                'margin_top' => 5,    	
				'margin_header' => 0,    
				'margin_footer' => 0,    
				'orientation' => 'P'  
			);
			$mpdf = new \Mpdf\Mpdf($mpdfConfig);	
            
               // $mpdf->AddPage('','','','','',0,0,0,0);
                $mpdf->img_dpi = 96;
                $header = '<div style="width: 100%; text-align: center; margin-top: 10 ; font face="Century Gothic"; font size="6""><br><B>NEGROS PRAWN PRODUCERS COOPERATIVE
                <BR>ANALYTICAL AND DIAGNOSTIC LABORATORY</B></div><center>';

                $header1 = '<div style="width: 100%; text-align: center;"><font size="1">DOOR 2, NOLKFI BLDG, 6TH STREET BACOLOD CITY 6100 PHILIPPINES<br>ELEFAX 433-2131; 700-7287 EMAIL ADDRESS: NPPC</font></div>';

                $joborder = '<div style="width: 100%; "><font size="70"><br><b>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                JOB ORDER</b>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                No. 19<br></font><div>';

                /* 
                
                joborder_id
                customer_id
                joborder_date
                sampling_date
                lsono
                sample_received
                lab
                conforme
                address
                telno

                */
                $header2 = '<div style="width: 100%; "><br>Client:_________________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date:__________________________________________
                <br><div style="width: 100%; ">Address:_______________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sampling Site:________________________________
                <br><div style="width: 100%; ">Tel No:________________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;L.S.O. No:_____________________________________';
                
                
                $mpdf->WriteHTML($header);
                $mpdf->WriteHTML($header1);
                
                $mpdf->WriteHTML($joborder);
                $mpdf->WriteHTML($header2);
               
                $mpdf->Image('/uploads/user/photo/logo.png', 15, 5, 28, 25, 'png', '', true, false);
               
    
                $RequestTemplate = "<br><br><br><br><br><br><br><table border='1' style='border-collapse: collapse;font-size: 12px' width=100% position: relative left: 30px >";
                
                $RequestTemplate .= "<tr>";
                $RequestTemplate .= "<td style='padding-left: 5px; text-align: center;'><b>Sample Description</b></td>";
                $RequestTemplate .= "<td style='padding-left: 5px; text-align: center;'><b>Control No.</b></td>";
                $RequestTemplate .= "<td style='padding-left: 5px; text-align: center;'><b>ANALYSIS REQUESTED</b></td>";
                $RequestTemplate .= "<td style='padding-left: 5px; text-align: center;'><b>Price Analysis</b></td>";
                $RequestTemplate .= "<td style='padding-left: 5px; text-align: center;'><b>Total Amount</b></td>";
                $RequestTemplate .= "</tr>";
                $RequestTemplate .= "<tr>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px;'><b>WASTEWATER ANALYSIS</b></td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                $RequestTemplate .= "</tr>";
                $RequestTemplate .= "<tr>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px;'>1.	pH</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                $RequestTemplate .= "</tr>";
                $RequestTemplate .= "<tr>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px;'>2.	Dissolved Oxygen</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                $RequestTemplate .= "</tr>";
                $RequestTemplate .= "<tr>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px;'>3.	Bio-chemical Oxygen Demand</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                $RequestTemplate .= "</tr>";
                $RequestTemplate .= "<tr>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px;'>4.	Total Dissolved Solids</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                $RequestTemplate .= "</tr>";
                $RequestTemplate .= "<tr>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px;'>5.	Total Suspended Solids</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                $RequestTemplate .= "</tr>";
                $RequestTemplate .= "<tr>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px;'>6.	Total Solids</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                $RequestTemplate .= "</tr>";

                $RequestTemplate .= "<tr>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px;'>7.	Settleable Solids</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                $RequestTemplate .= "</tr>";

                $RequestTemplate .= "<tr>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px;'>8.	Oil and Grease</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                $RequestTemplate .= "</tr>";

                $RequestTemplate .= "<tr>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px;'>9.	Orthophosphate</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                $RequestTemplate .= "</tr>";


                $RequestTemplate .= "<tr>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px;'>10.	Total Fecal Coliform</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                $RequestTemplate .= "</tr>";

                $RequestTemplate .= "<tr>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px;'><b>POTABILITY TEST</b></td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                $RequestTemplate .= "</tr>";

                $RequestTemplate .= "<tr>";
                $RequestTemplate .= "<td></td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>1.	pH</td>";
                $RequestTemplate .= "<td style='padding-left: 5px;'></td>";
                $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                
                $RequestTemplate .= "</tr>";

                $RequestTemplate .= "<tr>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px;'>2.	Total Aerobic Plate Count </td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                $RequestTemplate .= "</tr>";

                $RequestTemplate .= "<tr>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px;'>3.	Total Fecal Coliform</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                $RequestTemplate .= "</tr>";

                $RequestTemplate .= "<tr>";
                $RequestTemplate .= "<td></td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>4.	Total Dissolved Solids</td>";
                $RequestTemplate .= "<td style='padding-left: 5px;'></td>";
                $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                $RequestTemplate .= "</tr>";

                $RequestTemplate .= "<tr>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px;'>5.	Total Hardness (Calcium and Magnesium Hardness)</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                $RequestTemplate .= "</tr>";


                //////


                $RequestTemplate .= "<tr>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px;'>6.	Trace Elements (Fe)</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                $RequestTemplate .= "</tr>";


                $RequestTemplate .= "<tr>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px;'>7.	Color</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                $RequestTemplate .= "</tr>";

                $RequestTemplate .= "<tr>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px;'>8.	Nitrates</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                $RequestTemplate .= "</tr>";

                $RequestTemplate .= "<tr>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px;'>9.	Sulfates</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                $RequestTemplate .= "</tr>";

                $RequestTemplate .= "<tr>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px;'>10.	Chlorides</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                $RequestTemplate .= "</tr>";


                $RequestTemplate .= "<tr>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px;'>11.	Turbidity</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                $RequestTemplate .= "</tr>";


                $RequestTemplate .= "<tr>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px;'>12.	Electrical Conductivity</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                $RequestTemplate .= "</tr>";


                $RequestTemplate .= "<tr>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px;'><b>OTHER TESTS (Food Products)</b></td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                $RequestTemplate .= "</tr>";

                $RequestTemplate .= "<tr>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px;'>1.	Acidity</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                $RequestTemplate .= "</tr>";


                $RequestTemplate .= "<tr>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px;'>2.	pH</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                $RequestTemplate .= "</tr>";


                $RequestTemplate .= "<tr>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px;'>3.	Heterotrophic Plate Count</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                $RequestTemplate .= "</tr>";

                $RequestTemplate .= "<tr>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5px;'>4.	Moisture Content</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                $RequestTemplate .= "</tr>";

                $RequestTemplate .= "</tr></table>";

                $mpdf->WriteHTML($RequestTemplate);

                $footer = "<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    
                TOTAL CHARGES &nbsp;&nbsp;P&nbsp;&nbsp; _____________________";

                $mpdf->WriteHTML($footer);

                $footer1 = "<br><br><br>Sample Received by: ________________________ 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Conforme:____________________________ ";
                $mpdf->WriteHTML($footer1);

                $footer2 = "
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               
               
                <font size='1'>
                &nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                CLIENT (Signature over Printed Name)</font>";
                $mpdf->WriteHTML($footer2);

                $footer3 = "<font size='1'><br><br>NPPC-ADL  
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;
               

                Revision 00/Issue 1
                <br>LSP 4.6 FO2
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               
                Effectivity Date: 1/02/15
                 <br> MMM 051019: 55P 25251-2800</font>";
                $mpdf->WriteHTML($footer3);

          


                $mpdf->Output();
           }
       

           public function actionPrintjobordertwo()
           {  
               
              
                $mpdfConfig = array(
                    'mode' => 'utf-8', 
                    'format' => 'A4',    
                    'default_font_size' => 0,     
                    'default_font' => '',    
                    'margin_left' => 15,    	
                    'margin_right' => 15, 
                    'margin_top' => 5,    	
                    'margin_header' => 0,    
                    'margin_footer' => 0,    
                    'orientation' => 'P'  
                );
                $mpdf = new \Mpdf\Mpdf($mpdfConfig);	
                
                   // $mpdf->AddPage('','','','','',0,0,0,0);
                    $mpdf->img_dpi = 96;
                    $header = '<div style="width: 100%; text-align: center; margin-top: 10 ; font face="Century Gothic"; font size="6""><br><B>NEGROS PRAWN PRODUCERS COOPERATIVE
                    <BR>ANALYTICAL AND DIAGNOSTIC LABORATORY</B></div><center>';
    
                    $header1 = '<div style="width: 100%; text-align: center;"><font size="1">DOOR 2, NOLKFI BLDG, 6TH STREET BACOLOD CITY 6100 PHILIPPINES<br>ELEFAX 433-2131; 700-7287 EMAIL ADDRESS: NPPC</font></div>';
    
                    $joborder = '<div style="width: 100%; "><font size="70"><br><b>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    JOB ORDER</b>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    No. 19<br></font><div>';
    
                    $header2 = '<div style="width: 100%; "><br>Client:_________________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date:__________________________________________
                    <br><div style="width: 100%; ">Address:_______________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sampling Site:________________________________
                    <br><div style="width: 100%; ">Tel No:________________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;L.S.O. No:_____________________________________';
                    
                    
                    $mpdf->WriteHTML($header);
                    $mpdf->WriteHTML($header1);
                    
                    $mpdf->WriteHTML($joborder);
                    $mpdf->WriteHTML($header2);
                   
                    $mpdf->Image('/uploads/user/photo/logo.png', 15, 5, 28, 25, 'png', '', true, false);
                   
                      /* 
                
                joborder_id
                customer_id
                joborder_date
                sampling_date
                lsono
                sample_received
                lab
                conforme
                address
                telno

                */
                
                    $RequestTemplate = "<br><br><br><br><br><br><br><table border='1' style='border-collapse: collapse;font-size: 12px' width=100% position: relative left: 30px >";
                    
                    $RequestTemplate .= "<tr>";
                    $RequestTemplate .= "<td style='padding-left: 5px; text-align: center;'><b>Sample Description</b></td>";
                    $RequestTemplate .= "<td style='padding-left: 5px; text-align: center;'><b>Control No.</b></td>";
                    $RequestTemplate .= "<td style='padding-left: 5px; text-align: center;'><b>ANALYSIS REQUESTED</b></td>";
                    $RequestTemplate .= "<td style='padding-left: 5px; text-align: center;'><b>Price Analysis</b></td>";
                    $RequestTemplate .= "<td style='padding-left: 5px; text-align: center;'><b>Total Amount</b></td>";
                    $RequestTemplate .= "</tr>";
                    $RequestTemplate .= "<tr>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px;'><b>FRY ANALYSIS</b></td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                    $RequestTemplate .= "</tr>";
                    $RequestTemplate .= "<tr>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px;'>1.	Microscopic </td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                    $RequestTemplate .= "</tr>";
                    $RequestTemplate .= "<tr>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px;'>2.	Total Bacterial Count</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                    $RequestTemplate .= "</tr>";
                    $RequestTemplate .= "<tr>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px;'>3.	PCR</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                    $RequestTemplate .= "</tr>";
                    $RequestTemplate .= "<tr>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px;'>4.	EMS</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                    $RequestTemplate .= "</tr>";
                    $RequestTemplate .= "<tr>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px;'><b>ADULT ANALYSIS</b></td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                    $RequestTemplate .= "</tr>";
                    $RequestTemplate .= "<tr>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px;'>1.	Microscopic</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                    $RequestTemplate .= "</tr>";
    
                    $RequestTemplate .= "<tr>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px;'>2.	Total Bacterial Count</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                    $RequestTemplate .= "</tr>";
    
                    $RequestTemplate .= "<tr>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px;'>3.	PCR</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                    $RequestTemplate .= "</tr>";
    
                    $RequestTemplate .= "<tr>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px;'>4.	EMS</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                    $RequestTemplate .= "</tr>";
    
    
                    $RequestTemplate .= "<tr>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px;'><b>WATER ANALYSIS</b></td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                    $RequestTemplate .= "</tr>";
    
                    $RequestTemplate .= "<tr>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px;'>1.	Total Bacterial Count</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                    $RequestTemplate .= "</tr>";
    
                    $RequestTemplate .= "<tr>";
                    $RequestTemplate .= "<td></td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>2.	Plankton Count and Identification</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px;'></td>";
                    $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                    
                    $RequestTemplate .= "</tr>";
    
                    $RequestTemplate .= "<tr>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px;'>3.	Ammonia – Nitrogen </td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                    $RequestTemplate .= "</tr>";
    
                    $RequestTemplate .= "<tr>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px;'>4.	Nitrite – Nitrogen</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                    $RequestTemplate .= "</tr>";
    
                    $RequestTemplate .= "<tr>";
                    $RequestTemplate .= "<td></td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>5.	Orthophosphate</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px;'></td>";
                    $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                    $RequestTemplate .= "</tr>";
    
                    $RequestTemplate .= "<tr>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px;'>6.	Iron in Water</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                    $RequestTemplate .= "</tr>";
    
    
                    //////
    
    
                    $RequestTemplate .= "<tr>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px;'>7.	Total Alkalinity</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                    $RequestTemplate .= "</tr>";
    
    
                    $RequestTemplate .= "<tr>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px;'>8.	pH</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                    $RequestTemplate .= "</tr>";
    
                    $RequestTemplate .= "<tr>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px;'>9.	Salinity</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                    $RequestTemplate .= "</tr>";
    
                    $RequestTemplate .= "<tr>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px;'><b>SOIL ANALYSIS</b></td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                    $RequestTemplate .= "</tr>";
    
                    $RequestTemplate .= "<tr>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px;'>1.	pH</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                    $RequestTemplate .= "</tr>";
    
    
                    $RequestTemplate .= "<tr>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px;'>2.	Organic Matter Content</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                    $RequestTemplate .= "</tr>";
    
    
                    $RequestTemplate .= "<tr>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px;'>3.	Available Iron</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                    $RequestTemplate .= "</tr>";
    
    
                    $RequestTemplate .= "<tr>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px;'>4.	Available Phosphorus</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                    $RequestTemplate .= "</tr>";
    
                    $RequestTemplate .= "<tr>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px;'>5.	Acetate Soluble Sulfates</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                    $RequestTemplate .= "</tr>";
    
    
                    $RequestTemplate .= "<tr>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px;'>6.	Lime Requirements</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                    $RequestTemplate .= "</tr>";
    
    
                    $RequestTemplate .= "<tr>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px;'><b>LIME ANALYSIS</b></td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                    $RequestTemplate .= "</tr>";
    
                    $RequestTemplate .= "<tr>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px;'>1.	% Available Calcium Oxide</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                    $RequestTemplate .= "</tr>";

                    ////
                    $RequestTemplate .= "<tr>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px;'>2.	Neutralizing Value and Efficiency Rating</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                    $RequestTemplate .= "</tr>";


                    $RequestTemplate .= "<tr>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px;'><b>FISH ANALYSIS (TILAPIA)</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                    $RequestTemplate .= "</tr>";


                    $RequestTemplate .= "<tr>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px;'>1.	Microscopic Analysis</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                    $RequestTemplate .= "</tr>";


                    $RequestTemplate .= "<tr>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px;'>2.	Streptococus Bacteria (Todd Hewitt Media)</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                    $RequestTemplate .= "</tr>";

                    $RequestTemplate .= "<tr>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px;'>3.	Total Vibrio Count</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                    $RequestTemplate .= "</tr>";

                    $RequestTemplate .= "<tr>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px;'>4.	Total Bacterial Count</td>";
                    $RequestTemplate .= "<td style='padding-left: 5px'>&nbsp;</td>";
                    $RequestTemplate .= "<td style='padding-left: 5x'>&nbsp;</td>";
                    $RequestTemplate .= "</tr>";


                    $RequestTemplate .= "</tr></table>";
    
                    $mpdf->WriteHTML($RequestTemplate);


                    $footer = "<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    
                    TOTAL CHARGES &nbsp;&nbsp;P&nbsp;&nbsp; _____________________";
    
                    $mpdf->WriteHTML($footer);
    
                    $footer1 = "<br><br><br>Sample Received by: ________________________ 
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Conforme:____________________________ ";
                    $mpdf->WriteHTML($footer1);
    
                    $footer2 = "
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                   
                   
                    <font size='1'>
                    &nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    CLIENT (Signature over Printed Name)</font>";
                    $mpdf->WriteHTML($footer2);
                    $mpdf->Output();
               }
           
     

    /**
     * Updates an existing Joborder model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->joborder_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Joborder model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Joborder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Joborder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Joborder::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
} 