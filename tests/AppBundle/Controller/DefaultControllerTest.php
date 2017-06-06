<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostControllerTest extends WebTestCase
{
    public function testShowPost()
    {
        $client = static::createClient();

        $userArray = [];

        array_push($userArray, array("Marion", "Battista", "1986-05-21", 0));
        array_push($userArray, array("christophe", "smekens", "1981-05-25", 1));
        array_push($userArray, array("Félicie", "Jeannet", "1920-05-21", 0));
        array_push($userArray, array("Enfant", "Enfant", "2012-05-21", 0));
        array_push($userArray, array("Bébé", "Bébé", "2017-01-21", 0));

        $crawler = $client->request('POST', '/getUsersPrice', array('users' => json_encode($userArray)));

        $userResponseArray = json_decode($client->getResponse()->getContent());

        $this->assertEquals($userResponseArray[0][4], 16);
        $this->assertEquals($userResponseArray[1][4], 10);
        $this->assertEquals($userResponseArray[2][4], 12);
        $this->assertEquals($userResponseArray[3][4], 8);
        $this->assertEquals($userResponseArray[4][4], 0);
    }
}