<?php

namespace frontend\modules\reports\modules\lab\templates;

use yii2tech\spreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use common\models\lab\Lab;

 /**
* Bergel Cutara SRS-II
*/
class Testreportspreadsheet extends Spreadsheet
{

	/**
     * @var location the data provider for the view. This property is required.
     */
	public $location="";
    public $model; // model used for targeting specific cell for data placements
    public $template; //templates to be used
     //public $LOCATION =\Yii::$app->basePath.'\\modules\\reports\\modules\\lab\\templates\\';
    /**

	/**
     * @param \PhpOffice\PhpSpreadsheet\Spreadsheet|null $document spreadsheet document representation instance.
     */

	public function init(){
		$this->location = \Yii::$app->basePath.'/modules/reports/modules/lab/templates/';
	}

    public function loaddoc()
    {
        $labprefix = ""; //used to store string variable for lab use

    	 // $location = \Yii::$app->basePath.'\\modules\\reports\\modules\\lab\\templates\\';
    	// echo $this->location; exit;
        //$this->_document = $document;
        // $this->_document = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
        //cehck on what lab the testreport will be generated
        $lab = Lab::findOne($this->model->lab_id);
        if($lab->labcode=="CHE"){
            $labprefix="CHEM";
        }elseif($lab->labcode=="MIC"){
            $labprefix="MICRO";
        }
        //choose what template to use
        switch($this->template){
            case 1:
                $this->setDocument(IOFactory::load($this->location.$labprefix."_ISO.xlsx"));
                break;
            case 2:
                $this->setDocument(IOFactory::load($this->location.$labprefix."_NONISO.xlsx"));
                break;
            case 3:
                $this->setDocument(IOFactory::load($this->location.$labprefix."_DENR.xlsx"));
        }       


        // Set cell A2 with a numeric value
        // $this->getDocument()->getActiveSheet()->setCellValue('A2', $this->template);

        $this->getDocument()->getActiveSheet()->setCellValue('C8', $this->model->request->request_ref_num);
        $this->getDocument()->getActiveSheet()->setCellValue('C9', $this->model->request->samples[0]->sampling_date);//date submitted //shud get the first sample record only if not many
   //     $this->getDocument()->getActiveSheet()->setCellValue('C10', $this->model->request->samples[0]->analyses[0]->date_analysis); //date analyzed //shud get the earliest sample record only if not many
        $this->getDocument()->getActiveSheet()->setCellValue('C11', $this->listsamples($this->model->request->samples)); //sample submitted //just concat every sample there is in a request
        $this->getDocument()->getActiveSheet()->setCellValue('C12', $this->model->request->samples[0]->description); //sample description

        $this->getDocument()->getActiveSheet()->setCellValue('C15', $this->model->request->customer->customer_name); //customer name
        $row = 21;
        //loop each of each sample
        foreach ($this->model->request->samples as $sample) {
             # loop each of the anlyses
            foreach ($sample->analyses as $analysis) {
                
                #displaying the analysis on a row in a table
                
                $this->getDocument()->getActiveSheet()->setCellValue('B'.$row, $analysis->testname); //testname or parameter
                $this->getDocument()->getActiveSheet()->setCellValue('C'.$row, $analysis->method); //method

                $this->getDocument()->getActiveSheet()->insertNewRowBefore($row+1, 1);
                $row++; 
            }
         } 
         $this->getDocument()->getActiveSheet()->removeRow($row);

         #set password
         $this->getDocument()->getActiveSheet()->getProtection()->setSheet(true);
         $this->getDocument()->getSecurity()->setLockWindows(true);
         $this->getDocument()->getSecurity()->setLockStructure(true);
         $this->getDocument()->getSecurity()->setWorkbookPassword("PhpSpreadsheet");

        // Parent::setDocument($document);
    }

     public function render()
    {
        //overrides the render so that it would do nothing with cdataactiveprovider
        return $this;
    }

    public function listsamples($mdata){
        $myvar = "";
        foreach ($mdata as $datum) {
            $myvar= $myvar.$datum->samplename.",";

        }
        return $myvar=substr($myvar, 0,-1);
    }

}

?>