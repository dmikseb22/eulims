<?php



namespace common\components;
use kartik\mpdf\Pdf;
use Yii;
use yii\helpers\ReplaceArrayValue;

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
class MyPDF implements PDFEnum{
    
    static $pdf;
/**
     * 
     * @param string $content The generated Views that to be converted to PDF 
     */
    public function __construct($opt=null) {
       
    }
    /**
     * 
     * @param string $Content
     * @param string $Header
     * @param string $Footer
     * @param array $options
     */
    public function renderPDF($Content,$Header=NULL,$Footer=NULL,$options=[]){
        // Default Options values

        //if(!array_key_exists('orientation',$options)){
        //    $options['orientation']=Pdf::ORIENT_LANDSCAPE;
        //}


        if(!array_key_exists('orientation',$options)){
            $options['orientation']=Pdf::ORIENT_PORTRAIT;
        }

        if(!array_key_exists('marginLeft',$options)){
            $options['marginLeft']=2.0;
        }
        if(!array_key_exists('marginRight',$options)){
            $options['marginRight']=2.0;
        }
        if(!array_key_exists('marginTop',$options)){
            $options['marginTop']=0.0;
        }
        if(!array_key_exists('marginBottom',$options)){
            $options['marginBottom']=0.5;
        }
        if(!array_key_exists('defaultFontSize',$options)){
            $options['defaultFontSize']=9;
        }
        if(!array_key_exists('defaultFont',$options)){
            $options['defaultFont']='Verdana';
        }
        if(!array_key_exists('format',$options)){
            $options['format']=Pdf::FORMAT_A4;
        }

      
        if(!array_key_exists('destination',$options)){
            $options['destination']=Pdf::DEST_BROWSER;
        }
        
        $mPDF = new Pdf();
        $mPDF->orientation=Pdf::ORIENT_LANDSCAPE;//$options['orientation'];
        $mPDF->destination=$options['destination'];
        $mPDF->defaultFont=$options['defaultFont'];
        $mPDF->format=$options['format'];
        $mPDF->marginBottom=$options['marginBottom'];
        $mPDF->marginLeft=$options['marginLeft'];
        $mPDF->marginRight=$options['marginRight'];
        $mPDF->marginTop=$options['marginTop'];
        
        $mPDF->content=$Content;
        $mPDF->methods=[ 
            'SetHeader'=>[$Header], 
            'SetFooter'=>[$Footer]
        ];
        
        $mPDF->render();
        exit;
    } 
}
