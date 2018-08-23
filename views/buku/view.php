<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Buku */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Bukus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="buku-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nama',
            'tahun_terbit',
            [
                'attribute' => 'id_penulis',
                'value'     => function($data)
                {
                    return $data->penulis->nama;
                },
            ],
            [
                'attribute' => 'id_penerbit',
                'value'     => function($data)
                {
                    return $data->penerbit->nama;
                },
            ],
            [
                'attribute' => 'id_kategori',
                'value'     => function($data)
                {
                    return $data->kategori->nama;
                },
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
            'sinopsis:ntext',
            [
                'attribute' => 'berkas',
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->berkas != '') {
                        return '<a class="btn btn-info img-responsive" style="width:200px; max-height:100px;" href="' . Yii::$app->homeUrl . '../../berkas/' . $model->berkas . '">Download</a>';
                    } else { 
                        return '<div align="center"><h1>File tidak tersedia</h1></div>';
                    }
                },
            ],
        ],
    ]) ?>

</div>
