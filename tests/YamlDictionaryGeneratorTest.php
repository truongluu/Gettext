<?php

include_once dirname(__DIR__).'/src/autoloader.php';

class YamlDictionaryGeneratorTest extends PHPUnit_Framework_TestCase
{
    public function testGeneration()
    {
        //Extract translations
        $translations = Gettext\Extractors\PhpCode::fromFile(__DIR__.'/files/phpcode.php');
        //verify existance of extracted translations
        $this->assertEquals(12, count($translations));
        $translation = $translations->find('', 'text 2');
        $this->assertInstanceOf('Gettext\\Translation', $translation);
        //set translation
        $translation->setTranslation('apple');
        //set plural
        $translation->setPlural('apples');
        //generate json dict - skips meta, empty translations and plurals
        $yaml = Gettext\Generators\YamlDictionary::toString($translations);
        file_put_contents(__DIR__.'/files/generated.yml', $yaml);
        $this->assertEquals(file_get_contents(__DIR__.'/files/generated.yml'), $yaml);
    }
}