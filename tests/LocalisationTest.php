<?php

namespace Tests\Localisation;


use ADcreatif\Localisation\Localisation;
use PHPUnit\Framework\TestCase;

class LocalisationTest extends TestCase
{

    private $l;

    function test_HashSentence()
    {
        $this->assertEquals('5df384941d1f13eee029d4426b311044', $this->l->hashSentence('I hate chocolate $4652'));
    }

    function test_basicTranslation()
    {
        //$this->l->addTranslation('J\'ai mangé du chocolat $4652', 'I hate chocolate $4652', 'FR', 'EN');

        $this->assertEquals('bonjour', $this->l->_('hello', 'FR'));
        $this->assertEquals('dog', $this->l->_('dog', 'EN'));
        $this->assertEquals("J'ai mangé du chocolat $4652", $this->l->_('I hate chocolate $4652', 'FR'));
    }

    function test_getLocalisation()
    {
        // check if we can properly get a dictionary
        $this->assertIsArray($this->l->getLocalisation('FR'));
        $this->assertIsArray($this->l->getLocalisation('EN'));
    }

    function test_newLang()
    {
        // I use this one to check the un existing fields
        $this->assertIsArray($this->l->getLocalisation('SP'));
        $this->assertEquals('hello', $this->l->_('hello', 'SP'));
    }

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->l = new Localisation();
    }
}
