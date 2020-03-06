<?php


namespace ADcreatif\Localisation;


class Localisation
{
    private $dirname = __DIR__ . '/../lang/';


    function _(string $word, string $lang = 'EN'): string
    {
        return $this->getTranslation($word, $lang);
    }

    function getTranslation(string $sentence, string $lang = 'EN'): string
    {
        $localisation = $this->getLocalisation($lang);


        $hash = $this->hashSentence($sentence);

        if (array_key_exists($hash, $localisation)) {
            return $localisation[$hash];
        }
        return $sentence;
    }

    function getLocalisation(string $lang): array
    {
        $storage = new Storage();
        $storage
            ->setCurLang($lang)
            ->setDirname($this->dirname);

        return $storage->read_file();
    }

    // bonjour , hello, FR, EN

    function hashSentence(string $sentence): string
    {
        return hash('md5', $sentence);
    }

    function addTranslation(string $translation, string $source, string $translation_lang, string $source_lang)
    {
        // getting dictionaries
        $source_localisation = $this->getLocalisation($source_lang);
        $translation_localisation = $this->getLocalisation($translation_lang);

        // set identifier
        $hash = $this->hashSentence($source);

        // add to dictionaries
        $source_localisation[$hash] = $source;
        $translation_localisation[$hash] = $translation;

//        var_dump( $translation_localisation);

        // saving final versions
        $storage = new Storage($this->dirname);
        $storage
            ->setCurLang($translation_lang)
            ->setLocalisations($translation_localisation)
            ->write_file();

        $storage
            ->setCurLang($source_lang)
            ->setLocalisations($source_localisation)
            ->write_file();
    }

    function createLocalisation($lang)
    {
        $storage = new Storage();
        return $storage
            ->setCurLang($lang)
            ->setDirname($this->dirname)
            ->write_file();
    }
}