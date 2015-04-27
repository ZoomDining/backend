<?php

namespace common\models;

use common\components\UploadFileBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "images".
 *
 * @property integer $id
 * @property integer $title
 * @property integer $add_date
 * @method string getFileUrl() getFileUrl(string $attributeName, string $format = "")
 * @method string getFilePath() getFilePath(string $attributeName, string $format = "")
 */
class Images extends ActiveRecord
{

    public $image;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            ['title', 'string', 'min' => 2, 'max' => 128],
            ['image', 'image', 'extensions' => 'jpg, jpeg, gif, png', 'skipOnEmpty' => $this->isNewRecord?false:true],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'add_date' => 'Add Date',
        ];
    }


    public function behaviors()
    {

        return [
            "timestamp" => [
                'class'              => TimestampBehavior::className(),
                'createdAtAttribute' => 'add_date',
                'updatedAtAttribute' => false,
            ],

            'imageUpload' => [
                'class'         => UploadFileBehavior::className(),
                'attributeName' => 'image',
                'savePath'      => "@root/uploads",
                'url'           => "/uploads",
                "baseUrl"       => Yii::$app == "app-frontend"?Yii::$app->urlManager->baseUrl:"",
                'thumbnails' => [
                    "small"  => [60, 60],
                    "small2" => [35, 40],
                ]
            ],
        ];
    }

    public function getAddDate(){
        return Yii::$app->formatter->asDatetime($this->add_date);
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields["add_date_formatted"] = function($model){
            return $model->getAddDate();
        };

        return $fields;
    }


}
