<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "buku".
 *
 * @property int $id
 * @property string $nama
 * @property string $tahun_terbit
 * @property int $id_penulis
 * @property int $id_penerbit
 * @property int $id_kategori
 * @property string $sinopsis
 * @property string $sampul
 * @property string $berkas
 */
class Buku extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'buku';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           [['nama'], 'required'],
            [['tahun_terbit'], 'safe'],
            [['id_penulis', 'id_penerbit', 'id_kategori'], 'integer'],
            [['sinopsis'], 'string'],
            [['nama', 'sampul', 'berkas'], 'string', 'max' => 255],
            [['sampul'], 'file', 'extensions' => 'png, jpg, jpeg', 'maxSize' => 1024 * 1024 * 20],
            [['berkas'], 'file', 'extensions' => 'doc, docx, xls, xlsx, pdf, ppt'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
            'tahun_terbit' => 'Tahun Terbit',
            'id_penulis' => 'Id Penulis',
            'id_penerbit' => 'Id Penerbit',
            'id_kategori' => 'Id Kategori',
            'sinopsis' => 'Sinopsis',
            'sampul' => 'Sampul',
            'berkas' => 'Berkas',
        ];
    }

    public function getPenulis()
    {
         $model = Penulis::findOne($this->id_penulis);

        if ($model !== null) {
            return $model->nama;
        } else {
            return null;
        }
        // return $this->hasOne(Penulis::classname(),['id' => 'id_penulis']);
    }

    public function getPenerbit()
    {
        $model = Penerbit::findOne($this->id_penerbit);

        if ($model !== null) {
            return $model->nama;
        } else {
            return null;
        }
        // return $this->hasOne(Penerbit::classname(),['id' => 'id_penerbit']);
    }

    public function getKategori()
    {
        $model = Kategori::findOne($this->id_kategori);

        if ($model !== null) {
            return $model->nama;
        } else {
            return null;
        }
        // return $this->hasOne(Kategori::classname(),['id' => 'id_kategori']);
    }
}
