<?php
namespace backend\modules\importadorCSV\models;

use yii;
use yii\base\Model;
use yii\web\UploadedFile;

class importForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $modeloImport;
    public $csvFile;
    public $NameSpace;

    public function rules()
    {
        return [
            [['csvFile','NameSpace','modeloImport'], 'required'],
            [['NameSpace','modeloImport'], 'string'],
            [['NameSpace','modeloImport'], 'safe'],
            [['csvFile'], 'file', 'skipOnEmpty' => false],//, 'extensions' => 'csv'
        ];
    }
    
    public function import()
    {
        if ($this->validate()) {
            $this->csvFile->saveAs('uploads/' . $this->csvFile->baseName . '.' . $this->csvFile->extension);
            return true;
        } else {
            return false;
        }
    }
}