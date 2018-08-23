<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BukuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Buku';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="buku-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Buku', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Export to Excel', ['buku/export-excel'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Export to PDF', ['buku/export-mpdf'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Export to Word', ['buku/export-word'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nama',
            'tahun_terbit',
            [
                'attribute' => 'id_penulis','value' => function($data)
                {
                    return $data->penulis->nama;
                }
            ],
            
            [
                'attribute' => 'id_penerbit','value' => function($data)
                {
                    return $data->penerbit->nama;
                }
            ],
            
            [
                'attribute' => 'id_kategori','value' => function($data)
                {
                    return $data->kategori->nama;
                }
            ],
            
            [
                'attribute' => 'sampul','format' => 'raw', 'value' => function ($model) {
                if ($model->sampul != '') {
                    return Html::img('@web/sampul/' . $model->sampul, ['class' => 'img-responsive', 'style' => 'height:100px']);
                }else {
                    return '<div align="center"><h1>Foto tidak tersedia</h1></div>';
                }
            },
        ],
            
        [
                'attribute' => 'berkas',
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->berkas != '') {
                        return '<a class="btn btn-primary glyphicon glyphicon-download-alt"  style="width:100px; max-height:100px;" href="' . Yii::$app->homeUrl . '../../berkas/' . $model->berkas . '"></a>';
                    } else { 
                        return '<div align="center"><h1>File tidak tersedia</h1></div>';
                    }
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
