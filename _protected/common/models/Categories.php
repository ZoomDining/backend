<?php

namespace common\models;

use common\components\UploadFileBehavior;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "categories".
 *
 * @property integer $id
 * @property integer $restaurant_id
 * @property string $name
 * @property integer $available_online
 * @property integer $item_numbers
 *
 * @property Menu[] $menus
 */
class Categories extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['available_online'], 'integer'],
            [['name'], 'string', 'max' => 512],

            ['items', 'safe']

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name Category',
            'available_online' => 'Available Online',
            'item_numbers' => 'Total number of items',
        ];
    }

    public function getMenus()
    {
        return $this->hasMany(Menu::className(), ['category_id' => 'id']);
    }


    public static function find()
    {
        if(Yii::$app->user->can("manager")){
            // manager see items form related to him restaurant
            return parent::find()->where("categories.restaurant_id=".Yii::$app->user->identity->restaurant_id);
        }else{
            // user can see only their items
            return parent::find();
        }
    }


    public function beforeSave($insert)
    {
        $this->restaurant_id = Yii::$app->user->identity->restaurant_id;
        $this->available_online = 1;
        return parent::beforeSave($insert);
    }


    public function getAvailable_onlinePretty(){
        return $this->available_online==1?"True":"False";
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return ArrayHelper::map($this->menus, "id", "id");
    }

    /**
     * @param mixed $items
     */
    public function setItems($items)
    {

        if(!empty($items)){
            foreach ((array)$items as $itemId) {
                Yii::$app->db->createCommand()
                    ->update(Menu::tableName(), ['category_id' => $this->id], 'id = '.$itemId)
                    ->execute();
            }
        }
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields["menu"] = "menus";
        return $fields;
    }
}
