<?php

/**
 * @file
 * Contains \Drupal\custom_services\Controller\HelloController.
 */
namespace Drupal\map_integration\Controller;
use Drupal\user\Entity\Role;
use Drupal\user\Entity\User;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityManager;
use Drupal\map_integration\Entity\Drupal;

class CityController extends ControllerBase {
  public function getcity() {

   $value = '[
{
  "_id": "01001",
  "city": "AGAWAM",
  "loc": [
    -72.622738999999995713,
    42.07020599999999888
  ],
  "pop": 15338,
  "state": "MA"
},
{
  "_id": "01001",
  "city": "AGAWAM",
  "loc": [
    -72.622738999999995713,
    42.07020599999999888
  ],
  "pop": 15338,
  "state": "MA"
},
{
  "_id": "01001",
  "city": "AGAWAM",
  "loc": [
    -72.622738999999995713,
    42.07020599999999888
  ],
  "pop": 15338,
  "state": "MA"
},
{
  "_id": "01001",
  "city": "AGAWAM",
  "loc": [
    -72.622738999999995713,
    42.07020599999999888
  ],
  "pop": 15338,
  "state": "MA"
},
{
  "_id": "01001",
  "city": "AGAWAM",
  "loc": [
    -72.622738999999995713,
    42.07020599999999888
  ],
  "pop": 15338,
  "state": "MA"
},
{
  "_id": "01001",
  "city": "AGAWAM",
  "loc": [
    -72.622738999999995713,
    42.07020599999999888
  ],
  "pop": 15338,
  "state": "MA"
},
{
  "_id": "01001",
  "city": "AGAWAM",
  "loc": [
    -72.622738999999995713,
    42.07020599999999888
  ],
  "pop": 15338,
  "state": "MA"
},
{
  "_id": "01001",
  "city": "AGAWAM",
  "loc": [
    -72.622738999999995713,
    42.07020599999999888
  ],
  "pop": 15338,
  "state": "MA"
},
{
  "_id": "01002",
  "city": "CUSHMAN",
  "loc": [
    -72.515649999999993724,
    42.377017000000002156
  ],
  "pop": 36963,
  "state": "MA"
},
{
  "_id": "01002",
  "city": "CUSHMAN",
  "loc": [
    -72.515649999999993724,
    42.377017000000002156
  ],
  "pop": 36963,
  "state": "MA"
},
{
  "_id": "01002",
  "city": "CUSHMAN",
  "loc": [
    -72.515649999999993724,
    42.377017000000002156
  ],
  "pop": 36963,
  "state": "MA"
},
{
  "_id": "01002",
  "city": "CUSHMAN",
  "loc": [
    -72.515649999999993724,
    42.377017000000002156
  ],
  "pop": 36963,
  "state": "MA"
},
{
  "_id": "01002",
  "city": "CUSHMAN",
  "loc": [
    -72.515649999999993724,
    42.377017000000002156
  ],
  "pop": 36963,
  "state": "MA"
},
{
  "_id": "01002",
  "city": "CUSHMAN",
  "loc": [
    -72.515649999999993724,
    42.377017000000002156
  ],
  "pop": 36963,
  "state": "MA"
},
{
  "_id": "01002",
  "city": "CUSHMAN",
  "loc": [
    -72.515649999999993724,
    42.377017000000002156
  ],
  "pop": 36963,
  "state": "MA"
},
{
  "_id": "01002",
  "city": "CUSHMAN",
  "loc": [
    -72.515649999999993724,
    42.377017000000002156
  ],
  "pop": 36963,
  "state": "MA"
},
{
  "_id": "01005",
  "city": "BARRE",
  "loc": [
    -72.108354000000005612,
    42.409697999999998785
  ],
  "pop": 4546,
  "state": "MA"
},
{
  "_id": "01007",
  "city": "BELCHERTOWN",
  "loc": [
    -72.410953000000006341,
    42.27510300000000143
  ],
  "pop": 10579,
  "state": "MA"
},
{
  "_id": "01008",
  "city": "BLANDFORD",
  "loc": [
    -72.936114000000003443,
    42.182949000000000694
  ],
  "pop": 1240,
  "state": "MA"
},
{
  "_id": "01010",
  "city": "BRIMFIELD",
  "loc": [
    -72.188455000000004702,
    42.116543000000000063
  ],
  "pop": 3706,
  "state": "MA"
},
{
  "_id": "01011",
  "city": "CHESTER",
  "loc": [
    -72.98876099999999667,
    42.279420999999999253
  ],
  "pop": 1688,
  "state": "MA"
}
]
';

echo $value; exit;

	 }

function addcity(){

  $data = file_get_contents('http://localhost/drupal-test/drupal-test/modules/map_integration/cities.json');
  $citydatas = json_decode($data);
  foreach ($citydatas as $citydata) {
    $data = [
      'type' => 'city',
      'name' => $citydata->city,
      'field_id' => $citydata->_id,
      'field_pop'  => $citydata->pop,
      'field_state'  => $citydata->state,
      'field_latitude'  => $citydata->loc[0],
      'field_longtitude'  => $citydata->loc[1],
    ];
    $citydata = \Drupal::service('entity_type.manager')
      ->getStorage('map_entity')
      ->create($data);
    $citydata->save();

  }

  return  array(
    '#items' => $items,
    '#theme' => 'map_integration',
    '#markup' => "Cities are created" ,
  );

}
}

