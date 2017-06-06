<?php

namespace Tests\AppBundle\Entity;

use PHPUnit\Framework\TestCase;
use AppBundle\Entity\MbUser;

class MbUserTest extends TestCase
{
    const firstname = "Marion";
    const lastname = "Battista";
    const birthday = "21/05/1986"; 
    const isReduced = true;
    const country = "France";

    public function testUserCreation()
    {
        $user = new MbUser();

        $user->setFirstname(self::firstname);
        $user->setLastname(self::lastname);
        $user->setBirthday(self::birthday);
        $user->setIsReduced(self::isReduced);
        $user->setCountry(self::country);

        $this->assertEquals($user->getFirstname(), self::firstname);
        $this->assertEquals($user->getLastname(), self::lastname);
        $this->assertEquals($user->getBirthday(), self::birthday);
        $this->assertEquals($user->getIsReduced(), self::isReduced);
        $this->assertEquals($user->getCountry(), self::country);
    }
}
