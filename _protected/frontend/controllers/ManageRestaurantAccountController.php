<?php

namespace frontend\controllers;

use common\models\Restaurant;
use common\models\search\RestaurantSearch;

class ManageRestaurantAccountController extends ManagerController
{

    public function getModelName(){
        return Restaurant::className();
    }
    public function getModelSearchName(){
        return RestaurantSearch::className();
    }

}
