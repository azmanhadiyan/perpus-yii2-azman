<?php
use app\models\Anggota;
use app\models\Buku;
use app\models\Peminjaman;
use app\models\Penulis;
use app\models\Penerbit;
use app\models\Kategori;
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Perpustakaan';
?>
<div class="site-index">
    <div class="col-lg-2 col-xs-4">
      <!-- small box -->
        <div class="small-box bg-aqua">
           <div class="inner">
              <h3><?=Yii::$app->formatter->asInteger(Anggota::getCount());?></h3>
 
              <p>Anggota</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-2 col-xs-4">
    <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3><?=Yii::$app->formatter->asInteger(Buku::getCount());?></h3>

                <p>Buku</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-2 col-xs-4">
    <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3><?=Yii::$app->formatter->asInteger(Penulis::getCount());?></h3>

                <p>Penulis</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-2 col-xs-4">
    <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3><?=Yii::$app->formatter->asInteger(Penerbit::getCount());?></h3>

                <p>Penerbit</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-2 col-xs-4">
    <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3><?=Yii::$app->formatter->asInteger(Kategori::getCount());?></h3>

                <p>Kategori</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <div class="x_panel">
                <div class="x_title">
                    <h3 class="box-title">Buku Berdasarkan Penulis</h3>
                </div>
                <div class="box-body">
                    <?=Highcharts::widget([
                        'options' => [
                            'credits'     => false,
                            'title'       => ['text' => 'PENULIS BUKU'],
                            'exporting'   => ['enabled' => true],
                            'plotOptions' => [
                                'pie' => [
                                    'cursor' => 'pointer',
                                ],
                            ],

                            'series'      => [
                                [
                                'type' => 'pie',
                                'name' => 'Penulis',
                                'data' => Penulis::getGrafikList(),
                                ],
                            ],
                        ],
                    ]);?>
                </div>
            </div>
        </div>
    
        <div class="col-sm-4">
            <div class="x_panel">
                <div class="x_title">
                    <h3 class="box-title">Buku Berdasarkan Penerbit</h3>
                </div>
                <div class="box-body">
                    <?=Highcharts::widget([
                        'options' => [
                            'credits'     => false,
                            'title'       => ['text' => 'PENERBIT BUKU'],
                            'exporting'   => ['enabled' => true],
                            'plotOptions' => [
                                'pie' => [
                                    'cursor' => 'pointer',
                                ],
                            ],

                            'series'      => [
                                [
                                'type' => 'pie',
                                'name' => 'Penerbit',
                                'data' => Penerbit::getGrafikList(),
                                ],
                            ],
                        ],
                    ]);?>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="x_panel">
                <div class="x_title">
                    <h3 class="box-title">Buku Berdasarkan Kategori</h3>
                </div>
                <div class="box-body">
                    <?=Highcharts::widget([
                        'options' => [
                            'credits'     => false,
                            'title'       => ['text' => 'KATEGORI BUKU'],
                            'exporting'   => ['enabled' => true],
                            'plotOptions' => [
                                'pie' => [
                                    'cursor' => 'pointer',
                                ],
                            ],

                            'series'      => [
                                [
                                'type' => 'pie',
                                'name' => 'Kategori',
                                'data' => Kategori::getGrafikList(),
                                ],
                            ],
                        ],
                    ]);?>
                </div>
            </div>
        </div>
    </div>
</div>

