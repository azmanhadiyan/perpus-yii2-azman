<?php

namespace app\controllers;

use Yii;
use app\models\Buku;
use app\models\BukuSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Mpdf\Mpdf;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Converter;

/**
 * BukuController implements the CRUD actions for Buku model.
 */
class BukuController extends Controller
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
     * Lists all Buku models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BukuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Buku model.
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

    /**
     * Creates a new Buku model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id_penulis=null,$id_penerbit=null,$id_kategori=null)
    {
        $model = new Buku();

        $model->id_penulis = $id_penulis;
        $model->id_penerbit = $id_penerbit;
        $model->id_kategori = $id_kategori;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $sampul = UploadedFile::getInstance($model,'sampul');
            $berkas = UploadedFile::getInstance($model,'berkas');

            $model->sampul = time() . '_' . $sampul->name;
            $model->berkas = time() . '_' . $berkas->name;

            $model->save(false);

            $sampul->saveAs(Yii::$app->basePath . '/web/sampul/' . $model->sampul);
            $berkas->saveAs(Yii::$app->basePath . '/web/berkas/' . $model->berkas);
            

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Buku model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $sampul_lama = $model->sampul;
        $berkas_lama = $model->berkas;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $sampul = UploadedFile::getInstance($model, 'sampul');
            $berkas = UploadedFile::getInstance($model, 'berkas');

            if ($sampul !== null) {
                unlink(Yii::$app->basePath . '/web/sampul/' . $sampul_lama);
                $model->sampul = time() . '_' . $sampul->name;
                $sampul->saveAs(Yii::$app->basePath . '/web/sampul/' . $model->sampul);
            }else {
                $model->sampul =$sampul_lama;;
            }

            if ($berkas !== null) {
                unlink(Yii::$app->basePath . '/web/berkas/' . $berkas_lama);
                $model->berkas = time() . '_' . $berkas->name;
                $berkas->saveAs(Yii::$app->basePath . '/web/berkas/' . $model->berkas);
            }else {
                $model->berkas =$berkas_lama;;
            }

            $model->save(false);


            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Buku model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        unlink(Yii::$app->basePath . '/web/sampul/' . $model->sampul);
        unlink(Yii::$app->basePath . '/web/berkas/' . $model->berkas);

        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Buku model based on its primary key value.
     * Ifata the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Buku the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Buku::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionExportExcel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $filename = time() . '_Excel.xlsx';
        $path = 'exports/' . $filename;

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'ID');
        $sheet->setCellValue('C1', 'Nama');
        $sheet->setCellValue('D1', 'Tahun Terbit');
        $sheet->setCellValue('E1', 'Penulis');
        $sheet->setCellValue('F1', 'Penerbit');
        $semuaBuku = Buku::find()->all();
        $nomor     = 1;
        $row1      = 2;
        $row2      = $row1;
        $row3      = $row2;
        $row4      = $row3;
        $row5      = $row4;
        $row6      = $row5;

        foreach ($semuaBuku as $buku) {
           $sheet->setCellValue('A' . $row1++, $nomor++);
           $sheet->setCellValue('B' . $row2++, $buku->id);
           $sheet->setCellValue('C' . $row3++, $buku->nama);
           $sheet->setCellValue('D' . $row4++, $buku->tahun_terbit);
           $sheet->setCellValue('E' . $row5++, $buku->id_penulis);
           $sheet->setCellValue('F' . $row6++, $buku->id_penerbit);

       }

       $spreadsheet->getActiveSheet()
       ->getStyle('A1:F' . $row6)
       ->getAlignment()
       ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

       $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
       $writer = new Xlsx($spreadsheet);
       $writer->save($path);
       return $this->redirect($path);
   }

   public function actionExportMpdf() {
       $mpdf     = new \Mpdf\Mpdf();
       $filename = time() . '_Mpdf.pdf';
       $path     = 'exports/' . $filename; // Lokasi penyimpanan File

       $mpdf->WriteHTML('<h1>Hello world!</h1>');

       $mpdf->Output($path);
       return $this->redirect($path); // Redirect menuju halaman buku/index.
   }


   // public function actionExportMpdf() {
   //     $mpdf     = new \Mpdf\Mpdf();
   //     $filename = time() . '_Mpdf.pdf';
   //     $path     = 'exports/' . $filename; // Lokasi penyimpanan File

   //     $section = $mpdf->addSection([

   //         // Margin kertas, convert dari cm ke Twip(satuan jarak phpword)
   //         'marginTop'    => Converter::cmToTwip(1.80),
   //         'marginBottom' => Converter::cmToTwip(1.30),
   //         'marginLeft'   => Converter::cmToTwip(1.2),
   //         'marginRight'  => Converter::cmToTwip(1.6),
   //     ]);

   //     $table = $section->addTable([
   //         'alignment'  => 'center',
   //         'bgColor'    => '000000',
   //         'borderSize' => 6,
   //     ]);

   //     // addRow berfungsi seperti <tr> dan addCell berfungsi seperti <td>
   //     $table->addRow(null);
   //     $table->addCell(500)->WriteHTML('#');
   //     $table->addCell(500)->WriteHTML('ID');
   //     $table->addCell(5000)->WriteHTML('Kegiatan');

   //  }

   public function actionExportWord()
   {
     $phpWord = new PhpWord();

       $phpWord->setDefaultFontSize(11); // Font size
       $phpWord->setDefaultFontName('Century Gothic'); // Font family
       $filename = time() . '_Word.doc';
       $path     = 'exports/' . $filename;
       $section = $phpWord->addSection([

           // Margin kertas, convert dari cm ke Twip(satuan jarak phpword)
           'marginTop'    => Converter::cmToTwip(1.80),
           'marginBottom' => Converter::cmToTwip(1.30),
           'marginLeft'   => Converter::cmToTwip(1.2),
           'marginRight'  => Converter::cmToTwip(1.6),
       ]);

       // Style didefinisikan oleh variable terlebih dahulu
       $headerStyle = [
           'bold' => true,
       ];
       $paragraphStyleAlignCenter = [
           'alignment'   => 'center',
           'spacing'     => 0,
           'spaceAfter'  => 10,
           'spaceBefore' => 0,
       ];

       $paragraphVerticalAlign = [
           'valign' => 'center',
       ];

       //
       //
       //
       //
       //
       // Menambahkan Text beserta dengan stylenya yang sudah di definisikan oleh variable sebelumnya
       $section->addText(
           'JADWAL PENGADAAN LANGSUNG',
           $headerStyle,
           $paragraphStyleAlignCenter
       );
       $section->addText(
           'PENGADAAN JASA KONSULTASI',
           $headerStyle,
           $paragraphStyleAlignCenter
       );

       // Barus baru dengan parameter 1 yang berarti 1 baris
       $section->addTextBreak(1);
       $section->addText(
           'LOREM IPSUM DOLOR SIT AMET',
           [
               'alignment' => 'left',
           ]
       );
       $section->addText(
           'LOREM IPSUM DOLOR SIT',
           [
               'alignment' => 'left',
           ]
       );

       // Barus baru dengan parameter 1 yang berarti 1 baris
       $section->addTextBreak(1);
       $section->addText(
           'LOREM IPSUM DOLOR SIT AMET, CONSECTETUR ADIPISICING ELIT, SED DO EIUSMOD
            TEMPOR INCIDIDUNT UT LABORE ET DOLORE MAGNA ALIQUA.',
           $paragraphStyleAlignCenter
       );

       // Barus baru dengan parameter 1 yang berarti 1 baris
       $section->addTextBreak(1);
       $section->addText(
           'Lorem ipsum dolor sit amet',
           [
               'alignment' => 'left',
           ]
       );
       $section->addText(
           'Lorem ipsum dolor sit amet',
           [
               'alignment' => 'left',
           ]
       );

       // Membuat Table dengan align center, warna border 000000(hitam), dan border size 6
       $table = $section->addTable([
           'alignment'  => 'center',
           'bgColor'    => '000000',
           'borderSize' => 6,
       ]);

       // addRow berfungsi seperti <tr> dan addCell berfungsi seperti <td>
       $table->addRow(null);
       $table->addCell(500, $paragraphVerticalAlign)->addText('#', $paragraphStyleAlignCenter);

       return $this->redirect($path);
    }
}
