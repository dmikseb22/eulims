<?php

namespace frontend\modules\reports\modules\models;

use Yii;

/**
 * This is the model class for table "tbl_accomplishment_rstl".
 *
 * @property int $accomplishment_id
 * @property int $yeardata
 * @property string $type
 * @property string $resulttype
 * @property string $indicator
 * @property int $rstl_id
 * @property string $region
 * @property string $regioncode
 * @property string $regioncolor
 * @property int $displayorder
 * @property string $chem_all
 * @property string $micro_all
 * @property string $metro_all
 * @property string $halal_all
 * @property string $chemmicro_all
 * @property string $all
 * @property string $janchem
 * @property string $janmicro
 * @property string $janmetro
 * @property string $janhalal
 * @property string $febchem
 * @property string $febmicro
 * @property string $febmetro
 * @property string $febhalal
 * @property string $marchem
 * @property string $marmicro
 * @property string $marmetro
 * @property string $aprchem
 * @property string $aprmicro
 * @property string $aprmetro
 * @property string $maychem
 * @property string $maymicro
 * @property string $maymetro
 * @property string $junchem
 * @property string $junmicro
 * @property string $junmetro
 * @property string $julchem
 * @property string $julmicro
 * @property string $julmetro
 * @property string $augchem
 * @property string $augmicro
 * @property string $augmetro
 * @property string $sepchem
 * @property string $sepmicro
 * @property string $sepmetro
 * @property string $octchem
 * @property string $octmicro
 * @property string $octmetro
 * @property string $novchem
 * @property string $novmicro
 * @property string $novmetro
 * @property string $decchem
 * @property string $decmicro
 * @property string $decmetro
 */
class AccomplishmentRstl extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_accomplishment_rstl';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('labdb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['yeardata', 'rstl_id', 'displayorder'], 'integer'],
            [['type', 'resulttype'], 'string', 'max' => 50],
            [['indicator', 'regioncolor'], 'string', 'max' => 30],
            [['region', 'chem_all', 'micro_all', 'metro_all', 'halal_all', 'chemmicro_all', 'all', 'janchem', 'janmicro', 'janmetro', 'janhalal', 'febchem', 'febmicro', 'febmetro', 'febhalal', 'marchem', 'marmicro', 'marmetro', 'aprchem', 'aprmicro', 'aprmetro', 'maychem', 'maymicro', 'maymetro', 'junchem', 'junmicro', 'junmetro', 'julchem', 'julmicro', 'julmetro', 'augchem', 'augmicro', 'augmetro', 'sepchem', 'sepmicro', 'sepmetro', 'octchem', 'octmicro', 'octmetro', 'novchem', 'novmicro', 'novmetro', 'decchem', 'decmicro', 'decmetro'], 'string', 'max' => 20],
            [['regioncode'], 'string', 'max' => 10],
        ];
    }
    
     public static function primaryKey()
    {
        return ['accomplishment_id'];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'accomplishment_id' => 'Accomplishment ID',
            'yeardata' => 'Yeardata',
            'type' => 'Type',
            'resulttype' => 'Resulttype',
            'indicator' => 'Indicator',
            'rstl_id' => 'Rstl ID',
            'region' => 'Region',
            'regioncode' => 'Regioncode',
            'regioncolor' => 'Regioncolor',
            'displayorder' => 'Displayorder',
            'chem_all' => 'Chem All',
            'micro_all' => 'Micro All',
            'metro_all' => 'Metro All',
            'halal_all' => 'Halal All',
            'chemmicro_all' => 'Chemmicro All',
            'all' => 'All',
            'janchem' => 'Janchem',
            'janmicro' => 'Janmicro',
            'janmetro' => 'Janmetro',
            'janhalal' => 'Janhalal',
            'febchem' => 'Febchem',
            'febmicro' => 'Febmicro',
            'febmetro' => 'Febmetro',
            'febhalal' => 'Febhalal',
            'marchem' => 'Marchem',
            'marmicro' => 'Marmicro',
            'marmetro' => 'Marmetro',
            'aprchem' => 'Aprchem',
            'aprmicro' => 'Aprmicro',
            'aprmetro' => 'Aprmetro',
            'maychem' => 'Maychem',
            'maymicro' => 'Maymicro',
            'maymetro' => 'Maymetro',
            'junchem' => 'Junchem',
            'junmicro' => 'Junmicro',
            'junmetro' => 'Junmetro',
            'julchem' => 'Julchem',
            'julmicro' => 'Julmicro',
            'julmetro' => 'Julmetro',
            'augchem' => 'Augchem',
            'augmicro' => 'Augmicro',
            'augmetro' => 'Augmetro',
            'sepchem' => 'Sepchem',
            'sepmicro' => 'Sepmicro',
            'sepmetro' => 'Sepmetro',
            'octchem' => 'Octchem',
            'octmicro' => 'Octmicro',
            'octmetro' => 'Octmetro',
            'novchem' => 'Novchem',
            'novmicro' => 'Novmicro',
            'novmetro' => 'Novmetro',
            'decchem' => 'Decchem',
            'decmicro' => 'Decmicro',
            'decmetro' => 'Decmetro',
        ];
    }
}
