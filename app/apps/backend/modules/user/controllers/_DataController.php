<?php

class DataController extends Controller {

    public function actionCountry($term) {
        $matches = Yii::app()->db->createCommand()
            ->select("countries.name_ru as value, countries.id as id")
            ->from('tbl_geo_country countries')
            ->where('countries.name_ru LIKE :search', array(':search'=>'%'.$term.'%'))
            ->limit(10)
            ->queryAll();
        echo CJSON::encode($matches);
    }

    public function actionRegions($term) {
        $matches = Yii::app()->db->createCommand()
            ->select("regions.name_ru as value, regions.id as id")
            ->from('tbl_geo_region regions')
            ->where('regions.name_ru LIKE :search', array(':search'=>'%'.$term.'%'))
            ->limit(10)
            ->queryAll();
        echo CJSON::encode($matches);
    }

    public function actionSettlements($term) {
        $matches = Yii::app()->db->createCommand()
            ->select("settlements.name_ru as value, settlements.id as id")
            ->from('tbl_geo_city settlements')
            ->where('settlements.name_ru LIKE :search', array(':search'=>'%'.$term.'%'))
            ->limit(10)
            ->queryAll();
        echo CJSON::encode($matches);
    }

    public function actionCities() {
        $data = array();
        $search = Yii::app()->request->getQuery('term', false);

        if ($search) {
            $matches = Yii::app()->db->createCommand()
                ->select("CONCAT(countries.name_ru,',',regions.name_ru,',',settlements.name_ru) as value, settlements.id as id")
                ->from('tbl_geo_city settlements')
                ->join('tbl_geo_region regions', 'settlements.region_id=regions.id')
                ->join('tbl_geo_country countries', 'settlements.country_id=countries.id')
                ->where('settlements.name_ru LIKE :search', array(':search'=>'%'.$search.'%'))
                ->limit(15)
                ->queryAll();
            $data = $matches;
        }
        echo CJSON::encode($data);
    }
}
