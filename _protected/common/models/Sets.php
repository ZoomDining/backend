<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use common\components\UploadFileBehavior;

/**
 * This is the model class for table "sets".
 *
 * @property integer $id
 * @property string $name
 * @property string $price
 * @property string $description
 * @property integer $available_online
 * @property integer $pick_up
 * @property integer $take_away
 * @property integer $dine_in
 * @property integer $modifier
 */
class Sets extends ActiveRecord
{
    public $image;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sets';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'price', 'category_id'], 'required'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 512],
            [['price'], 'string', 'max' => 64],
            [['available_online','pick_up','take_away','dine_in'], 'boolean'],
            [['modifier'], 'integer'],
            ['image', 'image', 'extensions' => 'jpg, jpeg, gif, png', 'skipOnEmpty' => true],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }

    public static function find()
    {
        if(Yii::$app->user->can("manager")){
            // manager see items form related to him restaurant
            return parent::find()->where("sets.restaurant_id=".Yii::$app->user->identity->restaurant_id);
        }else{
            // user can see only their items
            return parent::find();
        }
    }

    public function beforeSave($insert)
    {
        $this->modifier = intval($this->modifier);
        $this->restaurant_id = Yii::$app->user->identity->restaurant_id;
        return parent::beforeSave($insert);
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name Sets',
            'price' => 'Price',
            'description' => 'Description',
            'modifier' => 'Apply modifiers',
            'category_id' => 'Category',
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'imageUpload' => [
                'class'         => UploadFileBehavior::className(),
                'attributeName' => 'image',
                'savePath'      => "@root/uploads/sets",
                'url'           => "/uploads/sets",
                "baseUrl"       => Yii::$app == "app-frontend"?Yii::$app->urlManager->baseUrl:"",
                'thumbnails' => [
                    "small"  => [60, 60],
                ]
            ],
        ];
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields["image"] = function(){
            return Yii::$app->urlManager->hostInfo.$this->getFileUrl("image");
        };
        return $fields;
    }


}
