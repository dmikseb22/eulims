

 <?php   
 use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Testcategory */

$this->title = $model->testcategory_id;
$this->params['breadcrumbs'][] = ['label' => 'Testcategories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="testcategory-view">

   
 

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
          
            'category',
        ],
    ]) ?>

</div>


