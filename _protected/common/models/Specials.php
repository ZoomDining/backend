<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "specials".
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $menu_id
 * @property integer $discount
 * @property string $description
 * @property string $price_before
 * @property string $price_after
 * @property integer $available_online
 *
 * @property Menu $menu
 */
class Specials extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'specials';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_id', 'discount', 'price_after'], 'required'],
            [['menu_id', 'available_online','discount'], 'integer'],
            [['available_online'], 'boolean'],
            [['description'], 'string'],
            [['price_before','price_after'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'               => 'ID',
            'menu_id'          => 'Item',
            'menu'             => 'Item',
            'discount'         => 'Discount',
            'description'      => 'Description',
            'available_online' => 'Available Online',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['id' => 'menu_id']);
    }

    public static function find()
    {
        if(Yii::$app->user->can("manager")){
            // manager see items form related to him restaurant
            return parent::find()->where("specials.restaurant_id=".Yii::$app->user->identity->restaurant_id);
        }else{
            // user can see only their items
            return parent::find();
        }
    }

    public function beforeSave($insert)
    {
        $this->restaurant_id = Yii::$app->user->identity->restaurant_id;
        return parent::beforeSave($insert);
    }

    /**
     * @return string
     */
    public function getMenuName()
    {
        return $this->menu->name;
    }

    /**
     * @return array
     */
    public function fields()
    {
        $fields = parent::fields();

        $fields["image"] = function () {
            $menuModel = Menu::findOne($this->menu_id);
            if ($menuModel !== null) {
                $image_path = $menuModel->getFileUrl("image");
            }
            return Yii::$app->urlManager->hostInfo . $image_path;
        };

        $fields["menu_name"] = function(){
            return $this->menu->name;
        };
        return $fields;
    }

}
