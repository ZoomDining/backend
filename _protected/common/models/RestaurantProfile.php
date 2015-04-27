<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use common\components\UploadFileBehavior;

/**
 * This is the model class for table "restaurant_profile".
 *
 * @property integer $user_id
 * @property string $name
 * @property string $description
 * @property string $email
 * @property string $phone
 * @property integer $show_location
 * @property string $address
 * @property string $city
 * @property string $postcode
 * @property string $website
 * @property integer $dine_in
 * @property integer $take_away
 * @property integer $delivery
 * @property integer $halal
 * @property integer $non_halal
 * @property integer $vegetarian
 * @property integer $pork_free
 * @property integer $vegan
 * @property string $cousine_type
 * @property string $hours_mo
 * @property string $hours_tu
 * @property string $hours_we
 * @property string $hours_th
 * @property string $hours_fr
 * @property string $hours_sa
 * @property string $hours_su
 * @property string $security_question
 * @property string $prefer_language
 * @property string $lat
 * @property string $lng
 * @property string $policy
 */


class RestaurantProfile extends ActiveRecord
{
    public $image;
    public $distance;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'restaurant_profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['show_location','dine_in','take_away','delivery','halal','non_halal','vegetarian','pork_free','vegan'], 'boolean'],
            [['description','phone','address','city','postcode','website','cousine_type',
                'hours_mo','hours_tu','hours_we','hours_th','hours_fr','hours_sa','hours_su',
                'security_question','prefer_language','lat','lng','policy'
            ], 'string'],
            [['email'], 'email'],
            ['image', 'image', 'extensions' => 'jpg, jpeg, gif, png', 'skipOnEmpty' => $this->isNewRecord?false:true],
            [['name'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                => 'ID',
            'user_id'           => 'User ID',
            'name'              => 'Name',
            'description'       => 'Description',
            'phone'             => 'Phone number',
            'show_location'     => 'Show this location online',
            'address'           => 'Street Address',
            'postcode'          => 'Post code',
            'website'			=> 'Website',
            'take_away'         => 'Take away',
            'non_halal'         => 'Non-Halal',
            'cousine_type'      => 'Type of cuisine',
            'hours_mo'          => 'Monday',
            'hours_tu'          => 'Tuesday',
            'hours_we'          => 'Wednesday',
            'hours_th'          => 'Thursday',
            'hours_fr'          => 'Friday',
            'hours_sa'          => 'Saturday',
            'hours_su'          => 'Sunday',
            'security_question' => 'Security question',
            'lat'               => 'Latitude',
            'lng'               => 'Longitude',
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
                'savePath'      => "@root/uploads/restaurant_profile",
                'url'           => "/uploads/restaurant_profile",
                "baseUrl"       => Yii::$app == "app-frontend"?Yii::$app->urlManager->baseUrl:"",
                'thumbnails' => [
                    "small"  => [60, 60],
                ]
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Categories::className(), ['restaurant_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasMany(Menu::className(), ['restaurant_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSets()
    {
        return $this->hasMany(Sets::className(), ['restaurant_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaxes()
    {
        return $this->hasOne(Taxes::className(), ['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpecials()
    {
        return $this->hasMany(Specials::className(), ['restaurant_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecommended()
    {
        return $this->hasMany(Recommended::className(), ['restaurant_id' => 'user_id']);
    }


    /**
     * For rest api
     * @return array
     */
    public function fields()
    {

        $fields = [
            "id" => "user_id",
            "name",
            "description",
            "email",
            "phone",
            "show_location",
            "address",
            "city",
            "postcode",
            "website",
            "dine_in",
            "take_away",
            "delivery",
            "halal",
            "non_halal",
            "vegetarian",
            "pork_free",
            "vegan",
            "cousine_type",
            "hours_mo",
            "hours_tu",
            "hours_we",
            "hours_th",
            "hours_fr",
            "hours_sa",
            "hours_su",
            "lat",
            "lng",
            "distance",
            "image" =>  function(){
                return Yii::$app->urlManager->hostInfo.$this->getFileUrl("image");
            },
            "taxes",
        ];

        return $fields;
    }

    /**
     * For rest api
     * @return array
     */


    public function extraFields()
    {
        return [
            'categories',
            //'menu',
            'sets',
            'specials',
            'recommended',
            'taxes',
        ];
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
       //get coordinates
        if(isset($changedAttributes["address"]) || isset($changedAttributes["city"]) || isset($changedAttributes["postcode"])){
            if(empty($this->lat) && empty($this->lat)){
                $coords = $this->getCoordsByAddress($this->postcode." ".$this->city." ".$this->address);
                static::updateAll($coords, "user_id=".$this->user_id);
            }
        }

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @param $address string
     * @return array
     */
    private function getCoordsByAddress($address){

        $address = trim($address);

        $result = array(
            "lat"	=> 0,
            "lng"	=> 0,
        );

        if(empty($address)){
            return $result;
        }

        $address = str_replace(" ", "+", $address);

        $link = "http://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($address)."&sensor=false";

        $content = file_get_contents($link);
        $content_arr = json_decode($content, true);

        if(isset($content_arr["results"][0]["geometry"]["location"]["lat"]) && isset($content_arr["results"][0]["geometry"]["location"]["lng"])){
            $result = array(
                "lat"			=> $content_arr["results"][0]["geometry"]["location"]["lat"],
                "lng"			=> $content_arr["results"][0]["geometry"]["location"]["lng"],
            );
        }

        if(isset($content_arr["error_message"])) {
            $result["error_message"] = $content_arr["error_message"];
        }

        return $result;
    }

    /*
     * Расстояние между двумя точками
     * $φA, $λA - широта, долгота 1-й точки,
     * $φB, $λB - широта, долгота 2-й точки
     * Написано по мотивам http://gis-lab.info/qa/great-circles.html
     * Михаил Кобзарев <kobzarev@inforos.ru>
     * $metric = ("km" || "miles")
     */
    private static function calculateTheDistance($φA, $λA, $φB, $λB, $metric = "km")
    {
        $EARTH_RADIUS = 6372795;
        // перевести координаты в радианы
        $lat1 = $φA * M_PI / 180;
        $lat2 = $φB * M_PI / 180;
        $long1 = $λA * M_PI / 180;
        $long2 = $λB * M_PI / 180;

        // косинусы и синусы широт и разницы долгот
        $cl1 = cos($lat1);
        $cl2 = cos($lat2);
        $sl1 = sin($lat1);
        $sl2 = sin($lat2);
        $delta = $long2 - $long1;
        $cdelta = cos($delta);
        $sdelta = sin($delta);

        // вычисления длины большого круга
        $y = sqrt(pow($cl2 * $sdelta, 2) + pow($cl1 * $sl2 - $sl1 * $cl2 * $cdelta, 2));
        $x = $sl1 * $sl2 + $cl1 * $cl2 * $cdelta;

        //
        $ad = atan2($y, $x);
        $dist = $ad * $EARTH_RADIUS;

        if($metric = "km"){
            return round($dist*0.001, 3);
        }
        if($metric = "miles"){
            return round($dist*0.001*0.6213711922, 3);
        }
        return $dist;
    }

    /**
     * @param $gpsLat
     * @param $gpsLng
     * @param $distance
     * @return array
     */
    public static function getRestaurantsDistance($gpsLat, $gpsLng, $distance = 1){

        $result = [];
        $data = RestaurantProfile::find()->all();

        foreach ((array)$data as $_info) {
            if(!empty($_info->lat) && !empty($_info->lng)){
                $calcDistance = RestaurantProfile::calculateTheDistance($gpsLat, $gpsLng, $_info->lat, $_info->lng);
                if($calcDistance < $distance){
                    $_info->distance = $calcDistance;
                    $result[] = $_info;
                }
            }
        }

        return $result;
    }

}
