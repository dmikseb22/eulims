<?php

use yii\web\JsExpression;
use yii\helpers\Url;
use edofre\fullcalendar\Fullcalendar;
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\HighchartsAsset;
use common\models\system\LoginForm;
use rmrevin\yii\fontawesome\FA;
use kartik\select2\Select2;
use kartik\grid\GridView;
use yii\widgets\Pjax;

use kartik\widgets\ActiveForm;
/* @var $this yii\web\View */

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>

<style type="text/css">
    .carousel-indicators {
        bottom:-30px;
    }

    .carousel-indicators li {
        border-color:#999;
        background-color:#ccc;
    }

    .carousel-inner {
        margin-bottom:20px;
    }

    .carousel-control.left .glyphicon {
        left: 0;
        margin-left: 0;
        display: none;
    }
    .carousel-control.right .glyphicon {
        right: 0;
        margin-right: 0;
        display: none;
    }


</style>

<?php
//$yrSelect = '2015';
//var_dump($dashDetails);





$listLab = $data['listlab'];  // array("Chemical", "Microbiology", "Metrology", "Rubber", "TestLab", "TestLab2", "TestLab3");
$listLabCode = $data['listlabcode'];
$listLabCount = $data['listlabcount']; //array(400, 500, 600, 700, 800, 900, 1000);
$listLabColor = $data['listlabcolor']; // array("red", "green", "blue", "orange", "aqua", "purple", "orange");
$listLabIcons = $data['listlabicons']; //array("fa fa-comments-o", "fa fa-thumbs-o-up", "fa fa-bookmark-o", "fa fa-comments-o", "fa fa-bookmark-o", "fa fa-comments-o", "fa fa-bookmark-o");

$labCount = count($listLab);


$tmpValue = $labCount % 4;
$slideCount = ($labCount - $tmpValue) / 4;


if ($tmpValue >= 1) {
    $slideCount++;
}

$listYear = $data['listyear']; //array("2015","2016","2017");
$listColumn = $data['listcolumn']; // array("Rank", "Test Name", "No. of Tests");
$dataTop10 = $data['datatop10'];

$now = new DateTime();

$currentyear= $now->format('Y');
$currentyear =2018;




$js=<<<JS

   
$("#dropdownYear").change(function(){   
        var year = $("#dropdownYear").val();
        $.ajax({
            url: "/site/topsample",
            type: 'POST',
            dataType: "JSON",
            data: {
                year: year
            },
            success: function(response) {
                console.log(response);
                $('#sampleTop').html(response.data);
            },
            error: function(xhr, status, error) {
                alert(error);
            }
        });
       
    });

JS;

$this->registerJs($js,\yii\web\View::POS_READY);

?>



<script type="text/javascript">

    $('body').on('click', '.option li', function () {
        var i = $(this).parents('.select').attr('id');
        var v = $(this).children().text();
        var o = $(this).attr('id');
        $('#' + i + ' .selected').attr('id', o);
        $('#' + i + ' .selected').text(v);
        $('#selectedOption').val(v);


    });

    $(function () {
        $('ul.nav li').on('click', function () {
            $(this).parent().find('li.active').removeClass('active');
            $(this).addClass('active');
        });
    });

    function showDropYear(obj, graphType) {

        var x = document.getElementById("dropYearTwo");
      

        if (obj == 1) {
            x.style.display = "block";
        }
        if (obj == 0)
        {
            x.style.display = "none";
            
            switch (graphType) {
            case 'firms':
                graphTitle = 'FIRMS ASSISTED';
                yAxisLabel = 'No. of Firms Assisted';
                spParam ='1';
                break;
            case 'income':
                graphTitle = 'INCOME GENERATED';
                yAxisLabel = 'No. of Income Generated';
                spParam ='2';
                break;
            case 'assistance':
                graphTitle = 'VALUE OF ASSISTANCE RENDERED';
                yAxisLabel = 'No. of Value of Assistance Rendered';
                spParam ='3';
                break;
            case 'calibration':
                graphTitle = 'TESTING/CALIBRATION SERVICES RENDERED';
                yAxisLabel = 'No. of Testing/Calibration Services Rendered';
                spParam ='4';
                break;
            case 'customer':
                graphTitle = 'CUSTOMERS SERVED';
                yAxisLabel = 'No. of Customers Served';
                spParam ='0';
                break;

        }

        $.ajax({
            type: "POST",
            url: "<?php echo Yii::$app->getUrlManager()->createUrl('site/retrievecolumn'); ?>",
            data: {columnType: graphType,paramSP: spParam},
            success: function (data) {

                var chartColumn = $('#labColumnChart').highcharts();
                //alert(data);
              //  chartColumn.series[0].setData([]);
             //   chartColumn.series[1].setData([]);
             //   chartColumn.series[2].setData([]);
              //  chartColumn.series[3].setData([]);
              
             //  var chart = $('#yearlyPieChart').highcharts();
                chartColumn.setTitle({text: graphTitle + obj});
                chartColumn.series[0].setData([]);
                chartColumn.series[0].setData(data);
                chartColumn.series[0].redraw();

                chartColumn.setTitle({text: graphTitle});
                chartColumn.yAxis[0].update({
                    title: {
                        text: yAxisLabel
                    }
                });
                var dataNew = data;
                   
                for (i = 0; i < chartColumn.series.length; i++)
                {
                    chartColumn.series[i].update({
                        name: dataNew[i].name,
                        data: dataNew[i].data,
                        color: dataNew[i].color
                    });
                } 
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
        
        }

    }
    
    function updateColumn(obj) {

        $.ajax({
            type: "POST",
            url: "<?php echo Yii::$app->getUrlManager()->createUrl('site/graphdata'); ?>",
            data: {yearParam: obj},
            success: function (data) {
                //   alert(data);
               // alert(data.test);
                var chart = $('#yearlyPieChart').highcharts();
                chart.setTitle({text: 'Testing/Calibration Services Rendered by Lab - ' + obj});
                chart.series[0].setData([]);
                chart.series[0].setData(data);
                chart.series[0].redraw();

            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });


    }

    function updateRecord(obj) {

        $.ajax({
            type: "POST",
            url: "<?php echo Yii::$app->getUrlManager()->createUrl('site/retrievechart'); ?>",
            data: {yearParam: obj},
            success: function (data) {
                //   alert(data);

                var chart = $('#yearlyPieChart').highcharts();
                chart.setTitle({text: 'Testing/Calibration Services Rendered by Lab - ' + obj});
                chart.series[0].setData([]);
                chart.series[0].setData(data);
                chart.series[0].redraw();

            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });


    }
</script>


<div class="site-index">
    <input type="hidden" id="selectedOption" name="selectedOption" />

<?php if (!Yii::$app->user->isGuest) { ?>
        <div class="body-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header with-border" style="background-color: #3c8dbc;color:white">
                            <h3 class="box-title">Laboratory Request</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">


                            <div id="carousel-lab" class="carousel slide" data-ride="carousel" data-interval="false">
                                <ol class="carousel-indicators">

    <?php
    for ($x = 0; $x < $slideCount; $x++) {
        if ($x == 0) {
            echo '<li data-target="#carousel-lab" data-slide-to="' . $x . '" class="active"></li>';
        } else {
            echo '<li data-target="#carousel-lab" data-slide-to="' . $x . '" class=""></li>';
        }
    }
    ?>
                                </ol>


                                <div class="carousel-inner">

    <?php
   $listofgraph =['Firms Assisted','Customer Served','Income Generated','Value of Assistance','Testing/Calibration','Yearly Report'];
          
  
    //$labCount = 2;
    $iCounter = $labCount;
    if ($labCount > 4) {
        $iCounter = 4;
    } else {
        $iCounter = $labCount;
    }

    echo ' <div class="item active">';
    for ($i = 0; $i < $iCounter; $i++) {

        if ($labCount >= 4) {
            echo '<div class="col-md-3 col-sm-6 col-xs-12"><div class="info-box bg-' . $listLabColor[$i] . '">';
        }

        if ($labCount == 3) {
            echo '<div class="col-md-3 col-md-offset-1 col-sm-6 col-xs-12"><div class="info-box bg-' . $listLabColor[$i] . '">';
        }
        if ($labCount == 2) {
            echo '<div class="col-md-3 col-md-offset-2 col-sm-6 col-xs-12"><div class="info-box bg-' . $listLabColor[$i] . '">';
        }
        if ($labCount == 1) {
            echo '<div class="col-md-3 col-md-offset-4 col-sm-6 col-xs-12"><div class="info-box bg-' . $listLabColor[$i] . '">';
        }

        echo '<span class="info-box-icon"><i class="' . $listLabIcons[$i] . '"></i></span>';
        echo '<div class="info-box-content"><span class="info-box-text">' . $listLab[$i] . '</span>';
        echo '<span class="info-box-number"><a href="#" style="color:white">' . $listLabCount[$i] . '</a></span></div></div></div>';
    }
    echo '</div>';
    ?>
                                    <?php
                                    // $labCount =7;
                                    
                                         
                                    if ($slideCount > 1) {

                                        for ($i = 1; $i < $slideCount; $i++) {


                                            $startCounter = 4 * $i;
                                            $newCounter = $labCount - $startCounter;

                                            //mmecho $slideCount . '-' . $startCounter  . '-' . $newCounter.'-'. $labCount;

                                            echo ' <div class="item">';
                                            $enCount = $startCounter + 4;
                                            if ($enCount > $labCount) {
                                                $enCount = $labCount;
                                            }

                                            //if ($enCount > $labCount) {
                                            //    $enCount = $labCount;
                                            //}
                                            for ($j = $startCounter; $j < $enCount; $j++) {

                                                if ($newCounter >= 4) {
                                                    echo '<div class="col-md-3 col-sm-6 col-xs-12"><div class="info-box bg-' . $listLabColor[$j] . '">';
                                                }

                                                if ($newCounter == 3) {
                                                    echo '<div class="col-md-3 col-md-offset-0 col-sm-6 col-xs-12"><div class="info-box bg-' . $listLabColor[$j] . '">';
                                                }
                                                if ($newCounter == 2) {
                                                    echo '<div class="col-md-3  col-sm-6 col-xs-12"><div class="info-box bg-' . $listLabColor[$j] . '">';
                                                }
                                                if ($newCounter == 1) {
                                                    echo '<div class="col-md-3  col-sm-6 col-xs-12"><div class="info-box bg-' . $listLabColor[$j] . '">';
                                                }

                                                echo '<span class="info-box-icon"><i class="' . $listLabIcons[$j] . '"></i></span>';
                                                echo '<div class="info-box-content"><span class="info-box-text">' . $listLab[$j] . '</span>';
                                                echo '<span class="info-box-number"><a href="/maintenance/" style="color:white">' . $listLabCount[$j] . '</a></span></div></div></div>';
                                            }
                                            echo '</div>';

                                            //  $startCounter = $startCounter + 4;
                                        }
                                    }
                                    ?>

                                </div>


                            </div>
                           
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>

            <div class ="row" name="secondRow">
                <div class="col-md-3">
                    <div class="box box-default">
                        <div class="box-header with-border" style="background-color: #3c8dbc;color:white">
                            <img src="/images/icons/top10.png" style="width:25px">

                            <h3 class="box-title">Top 10 Tests/Analysis</h3>
                        </div>
                        <div class="box-body"  >
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <?php
                                        echo Select2::widget([
                                            'name' => 'dropYearTop10',
                                            'id'=>'dropYearTop10',
                                            'data' => $listYear,
                                            'value'=>$curYearValue,
                                            'options' => ['placeholder' => 'Year'],
                                            'pluginOptions' => [
                                                'allowClear' => true,
                                                ],
                                            'pluginEvents' => [
                                                            "change" => "function() {
                                                             var strYear = $('#dropYearTop10 :selected').text();
                                                             var strLab = $('#dropLabTop10 :selected').val();
                                                        
                                                                $.ajax({
                                                                    url: '".Url::toRoute("/site/datatop")."',
                                                                 //   dataType: 'json',
                                                                    method: 'GET',
                                                                   data: {syear:strYear,slab:strLab},
                                                                  
                                                                    success: function (data, textStatus, jqXHR) {
                                                                      $('#gridTop').html(data);
                                                                   },
                                                                    beforeSend: function (xhr) {
                                                                        //alert('Please wait...');
                                                                        $('.image-loader').addClass( \"img-loader\" );
                                                                    },
                                                                    
                                                                });
                                                            }",
                                                        ],
                                        ]);
                                        ?>
                                </div>
                                <div class="col-md-8">
                                     <?php
                                        echo Select2::widget([
                                            'name' => 'dropLabTop10',
                                            'id' => 'dropLabTop10',
                                            'value'=>0,
                                            'data' => $listLab,
                                            'options' => ['placeholder' => 'Select Laboratory'],
                                            'pluginOptions' => [
                                                //     'templateResult' => new JsExpression('format'),
                                                //      'templateSelection' => new JsExpression('format'),
                                                //       'escapeMarkup' => $escape,
                                                'allowClear' => true
                                            ],
                                            
                                            'pluginEvents' => [
                                                            "change" => "function() {
                                                             var strYear = $('#dropYearTop10 :selected').text();
                                                             var strLab = $('#dropLabTop10 :selected').val();
                                                           //    alert(strYear);
                                                           //    alert(strLab);
                                                                $.ajax({
                                                                    url: '".Url::toRoute("/site/datatop")."',
                                                                 //   dataType: 'json',
                                                                    method: 'GET',
                                                                   data: {syear:strYear,slab:strLab},
                                                                  
                                                                    success: function (data, textStatus, jqXHR) {
                                                                      $('#gridTop').html(data);
                                                                   },
                                                                    beforeSend: function (xhr) {
                                                                        //alert('Please wait...');
                                                                        $('.image-loader').addClass( \"img-loader\" );
                                                                    },
                                                                    
                                                                });
                                                            }",
                                                        ],
                                        ]);
                                        ?>
                                </div>
                            </div>
                            <div class="row">
                                 <div class="col-md-12" style="margin-top: 10px">
                                    <?php
                                        echo $this->render('_gridtop10', [ 'dataTop10' => $dataTop10]);
                                    ?>
                                </div>
                            </div>
                           
                        </div>

                    </div>
                </div>

                <div class="col-md-3">
                    <div class="box box-default">
                        <div class="box-header with-border" style="background-color: #3c8dbc;color:white">
                            <img src="/images/icons/top10.png" style="width:25px">

                            <h3 class="box-title">Top 10 Samples</h3>
                        </div>
                        <div class="box-body"  >
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?php
                                        echo Select2::widget([
                                            'name' => 'sampleyear',
                                            'id'=>'sampleyear',
                                            'data' => $listYear,
                                            'value'=>$curYearValue,
                                            'options' => ['placeholder' => 'Year'],
                                            'pluginOptions' => [
                                                'allowClear' => true,
                                                ],
                                            'pluginEvents' => [
                                                            "change" => "function() {
                                                             var strYear = $('#sampleyear :selected').text();
                                                             var strLab = $('#samplelab :selected').val();

                                                                $.ajax({
                                                                    url: '".Url::toRoute("/site/topsample")."',
                                                                 //   dataType: 'json',
                                                                    method: 'GET',
                                                                   data: {year:strYear,lab:strLab},
                                                                  
                                                                    success: function (data, textStatus, jqXHR) {
                                                                      $('#sampleTop').html(data);
                                                                   },
                                                                    beforeSend: function (xhr) {
                                                                        //alert('Please wait...');
                                                                        $('.image-loader').addClass( \"img-loader\" );
                                                                    },
                                                                    
                                                                });
                                                            }",
                                                        ],
                                        ]);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                     <?php
                                        echo Select2::widget([
                                            'name' => 'samplelab',
                                            'id' => 'samplelab',
                                            'value'=>0,
                                            'data' => $listLab,
                                            'options' => ['placeholder' => 'Select Laboratory'],
                                            'pluginOptions' => [
                                                //     'templateResult' => new JsExpression('format'),
                                                //      'templateSelection' => new JsExpression('format'),
                                                //       'escapeMarkup' => $escape,
                                                'allowClear' => true
                                            ],
                                            
                                            'pluginEvents' => [
                                                            "change" => "function() {
                                                             var strYear = $('#sampleyear :selected').text();
                                                             var strLab = $('#samplelab :selected').val();
                                                           //    alert(strYear);
                                                           //    alert(strLab);
                                                                $.ajax({
                                                                    url: '".Url::toRoute("/site/topsample")."',
                                                                 //   dataType: 'json',
                                                                    method: 'GET',
                                                                   data: {year:strYear,lab:strLab},
                                                                  
                                                                    success: function (data, textStatus, jqXHR) {
                                                                      $('#sampleTop').html(data);
                                                                   },
                                                                    beforeSend: function (xhr) {
                                                                        //alert('Please wait...');
                                                                        $('.image-loader').addClass( \"img-loader\" );
                                                                    },
                                                                    
                                                                });
                                                            }",
                                                        ],
                                        ]);
                                        ?>
                                </div>
                            </div>
                            <div class="row">
                                 <div class="col-md-12" style="margin-top: -5px">

                                <?php
                                    echo $this->render('_sample10', [ 'dataProvider' => $dataProvider]);
                                ?>
                                
                                </div>
                            </div>
                           
                        </div>

                    </div>
                </div>

                

                <div class="col-md-6">
                     <div class="box box-default">
                        <div class="box-header with-border" style="background-color: #3c8dbc;color:white">
                           <img src="/images/icons/graphdata.png" style="width:25px">

                            <h3 class="box-title">Statistical Data</h3>
                        </div>
                          <div class="box-body"  >
                            <div class="row justify-content-start">
                                <div class="col-md-4">           
                                        <?php
                                                echo Select2::widget([
                                                    'name' => 'dropGraphType',
                                                    'id'=>'dropGraphType',
                                                    'data' =>    $listofgraph,
                                                    'value'=>0,
                                                    'options' => ['placeholder' => 'Select Graph'],
                                                    'pluginOptions' => [
                                                        'allowClear' => true,
                                                        ],
                                                    'pluginEvents' => [
                                                                    "change" => "function() {
                                                                     var obj=0;
                                                                     // var strYear = $('#dropGraphType :selected').text();
                                                                     var strSel = $('#dropGraphType :selected').val();  
                                                                     if(strSel == '5')
                                                                     {obj=1;}

                                                                     var x = document.getElementById('divdropGraphYear');
                                                                     var graphdivPie = document.getElementById('divPieChart');
                                                                     var graphdivColumn = document.getElementById('divColumnChart');

                                                                                            if (obj == 1) 
                                                                                            {
                                                                                                x.style.display = 'block';
                                                                                                $('#dropGraphYear').show();
                                                                                                $('#graphYearly').show();

                                                                                                graphdivPie.style.display = 'block';
                                                                                                graphdivColumn.style.display = 'none';


                                                                                           }
                                                                                            if (obj == 0)
                                                                                            {
                                                                                           // alert('none');
                                                                                                x.style.display = 'none';
                                                                                                graphdivPie.style.display = 'none';
                                                                                                graphdivColumn.style.display = 'block';
                                                                                                $('#dropGraphYear').hide();
                                                                                                $('#graphYearly').hide();
                                                                                                //graphType='income';
                                                                                                switch (strSel) {
                                                                                                case '0':
                                                                                                    graphTitle = 'FIRMS ASSISTED';
                                                                                                    yAxisLabel = 'No. of Firms Assisted';
                                                                                                    spParam ='1';
                                                                                                    graphType='firms';
                                                                                                    break;
                                                                                                case '1':
                                                                                                    graphTitle = 'CUSTOMERS SERVED';
                                                                                                    yAxisLabel = 'No. of Customers Served';
                                                                                                    spParam ='0';
                                                                                                    graphType='customer';
                                                                                                    break;
                                                                                                case '2':
                                                                                                    graphTitle = 'INCOME GENERATED';
                                                                                                    yAxisLabel = 'No. of Income Generated';
                                                                                                    spParam ='2';
                                                                                                    graphType='income';
                                                                                                    break;
                                                                                                case '3':
                                                                                                    graphTitle = 'VALUE OF ASSISTANCE RENDERED';
                                                                                                    yAxisLabel = 'No. of Value of Assistance Rendered';
                                                                                                    spParam ='3';
                                                                                                    graphType='assistance';
                                                                                                    break;
                                                                                                case '4':
                                                                                                    graphTitle = 'TESTING/CALIBRATION SERVICES RENDERED';
                                                                                                    yAxisLabel = 'No. of Testing/Calibration Services Rendered';
                                                                                                    spParam ='4';
                                                                                                    graphType='calibration';
                                                                                                    break;


                                                                                            }

                                                                                            $.ajax({
                                                                                                type: 'POST',
                                                                                                url: '".Url::toRoute("/site/retrievecolumn")."',

                                                                                                data: {columnType: graphType,paramSP: spParam},
                                                                                                success: function (data) {

                                                                                                    var chartColumn = $('#labColumnChart').highcharts();

                                                                                                    chartColumn.setTitle({text: graphTitle + obj});
                                                                                                    chartColumn.series[0].setData([]);
                                                                                                    chartColumn.series[0].setData(data);
                                                                                                    chartColumn.series[0].redraw();

                                                                                                    chartColumn.setTitle({text: graphTitle});
                                                                                                    chartColumn.yAxis[0].update({
                                                                                                        title: {
                                                                                                            text: yAxisLabel
                                                                                                        }
                                                                                                    });
                                                                                                    var dataNew = data;

                                                                                                    for (i = 0; i < chartColumn.series.length; i++)
                                                                                                    {
                                                                                                        chartColumn.series[i].update({
                                                                                                            name: dataNew[i].name,
                                                                                                            data: dataNew[i].data,
                                                                                                            color: dataNew[i].color
                                                                                                        });
                                                                                                    } 
                                                                                                },
                                                                                                error: function (xhr, ajaxOptions, thrownError) {
                                                                                                    alert(xhr.status);
                                                                                                    alert(thrownError);
                                                                                                }
                                                                                            });

                                                                                            }
                                                                    }",
                                                                ],
                                                ]);
                                                ?>
                                                    </div>
                                <div class="col-md-2">
                                        <div  id="divdropGraphYear" style="display:none">
                                                <?php
                                                echo Select2::widget([
                                                    'name' => 'dropGraphYear',
                                                    'id' => 'dropGraphYear',
                                                    'value'=>$curYearValue,
                                                    'data' => $listYear,
                                                    'options' => ['placeholder' => 'Select Year'],
                                                    'pluginOptions' => [
                                                        //     'templateResult' => new JsExpression('format'),
                                                        //      'templateSelection' => new JsExpression('format'),
                                                        //       'escapeMarkup' => $escape,
                                                        'allowClear' => true,

                                                    ],

                                                    'pluginEvents' => [
                                                                    "change" => "function() {

                                                                            var strYear = $('#dropGraphYear :selected').text();

                                                                            $.ajax({
                                                                                        type: 'POST',

                                                                                        url: '".Url::toRoute("/site/retrievechart")."',
                                                                                        data: {yearParam: strYear},
                                                                                        success: function (data) {
                                                                                            //   alert(data);

                                                                                            var chart = $('#yearlyPieChart').highcharts();
                                                                                            chart.setTitle({text: 'Testing/Calibration Services Rendered by Lab - ' + strYear});
                                                                                            chart.series[0].setData([]);
                                                                                            chart.series[0].setData(data);
                                                                                            chart.series[0].redraw();

                                                                                        },
                                                                                        error: function (xhr, ajaxOptions, thrownError) {
                                                                                            alert(xhr.status);
                                                                                            alert(thrownError);
                                                                                        }
                                                                                    });


                                                                    }",
                                                                ],
                                                ]);
                                                ?></div>
                                </div>
                            </div>
                            <div class="row">
                                <br/><br/>
                                <div id="divColumnChart" style="display: block">
                                                        <?php
                                                        echo Highcharts::widget([
                                                            'id' => 'labColumnChart',
                                                            'scripts' => [
                                                                'modules/exporting',
                                                                'themes/grid-light',
                                                            ],
                                                            'options' => [
                                                                'title' => [
                                                                    'text' => 'Firms Assisted',
                                                                ],
                                                                'xAxis' => [
                                                                    'title' => [
                                                                        'text' => 'Year'
                                                                    ],
                                                                    'categories' => $listYear,
                                                                ],
                                                                'yAxis' => [
                                                                    'title' => [
                                                                        'text' => 'No of Firms'
                                                                    ]
                                                                ],
                                                                'labels' => [
                                                                    'items' => [
                                                                        [
                                                                            'style' => [
                                                                                'left' => '50px',
                                                                                'top' => '18px',
                                                                                'color' => new JsExpression('(Highcharts.theme && Highcharts.theme.textColor) || "black"'),
                                                                            ],
                                                                        ],
                                                                    ],
                                                                ],
                                                                'series' => $data['column']
                                                            ]
                                                        ]);
                                                        ?>
                                                        </div>
                                <div id="divPieChart" style="display: none">        
                                                            <?php
                                                            echo Highcharts::widget([
                                                                'id' => 'yearlyPieChart',
                                                                'scripts' => [
                                                                    'modules/exporting',
                                                                    'themes/grid-light',
                                                                ],
                                                                'options' => [
                                                                    'chart' => [
                                                                        'type' => 'pie',
                                                                    ],
                                                                    'title' => [
                                                                        'text' => 'Testing/Calibration Services Rendered by Lab - ' . $currentyear,
                                                                    ],
                                                                    'credits' => false,
                                                                    'labels' => [
                                                                        'items' => [
                                                                            [
                                                                                'html' => '',
                                                                                'style' => [
                                                                                    'left' => '50px',
                                                                                    'top' => '18px',
                                                                                    'color' => new JsExpression('(Highcharts.theme && Highcharts.theme.textColor) || "black"'),
                                                                                ],
                                                                            ],
                                                                        ],
                                                                    ],
                                                                    'series' => [
                                                                        [
                                                                            'name' => 'Total consumption',
                                                                            'data' => $data['pie'],
                                                                            'size' => '100%',
                                                                            'showInLegend' => true,
                                                                            'dataLabels' => [
                                                                                'enabled' => true,
                                                                            ],
                                                                        ],
                                                                    ],
                                                                ]
                                                            ]);
                                                            ?>  
                                                            </div>
                            </div>
                          </div>
                     </div>
                </div>
               
            </div>
            
          

        </div>

       

    </div>
    </div>

<?php } else { ?>
    <?php
    $model = new LoginForm();
    echo $this->render('..\admin-lte\site\userdashboard.php', [
        'model' => $model,
    ]);
    ?>
<?php } ?>
