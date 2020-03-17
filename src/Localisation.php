<?php


namespace ADcreatif\Localisation;


use DomainException;

class Localisation
{
    /**
     * @var string The language you will store your translations ('EN', 'FR', 'SP'...)
     */
    private $defaultLangage = "EN";

    /**
     * @var string The user tranlated language  ('EN', 'FR', 'SP'...)
     */
    private $currentLangage = "EN";

    /**
     * @var Storage the persistence system
     */
    private $storage;

    private $dirname;

    public function __construct()
    {
        $this->storage = new Storage();
    }

    public function setDirname(string $dirname): Localisation
    {
        echo "$dirname<br>";
        $this->dirname = $dirname;
        return $this;
    }

    public function getDirname(): String
    {
        return $this->dirname;
    }

    function getLangagesFiles(): array
    {
        $languages = [];
        try {
            $dirname = $this->getDirname();

            if (!file_exists($dirname)) {
                throw new DomainException("file $dirname can not be found.");
            }

            $languages = array_filter(scandir($dirname), function ($a) {
                return strlen($a) === 6 && !in_array($a, ['..', '.']);
            });

        } catch (DomainException $exception) {
            echo $exception->getMessage();
        }

        return $languages;
    }

    function getAvailableLanguages()
    {
        return array_map(
            function ($a) { return substr($a, 0, 2); },
            $this->getLangagesFiles()
        );
    }

    /**
     * @return string
     */
    public function getDefaultLangage(): string
    {
        return $this->defaultLangage;
    }

    /**
     * @param string $defaultLangage
     * @return Localisation
     */
    public function setDefaultLangage(string $defaultLangage): Localisation
    {
        $this->defaultLangage = $defaultLangage;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrentLangage(): string
    {
        return $this->currentLangage;
    }

    /**
     * @param string $currentLangage
     * @return Localisation
     */
    public function setCurrentLangage(string $currentLangage): Localisation
    {
        $this->currentLangage = $currentLangage;
        return $this;
    }

    function getHashFromSentence(string $sentence, string $lang)
    {
        $loc_from = $this->getLocalisation($lang);
        return array_search($sentence, $loc_from);
    }


    function getTranslation(string $sentence, string $lang_to = 'EN', string $lang_from = null): string
    {

        $lang_from = $lang_from ? $lang_from : $this->getDefaultLangage();
        $hash = $this->getHashFromSentence($sentence, $lang_from);

        $lang_to = $lang_to ? $lang_to : $this->getCurrentLangage();
        $loc_to = $this->getLocalisation($lang_to);

        if (!$hash && $lang_to === $this->getDefaultLangage()) {
            // this sentence unknown, adding it to default language
            $hash = $this->addTranslation($sentence, $this->getDefaultLangage());

        }

        if ($hash && array_key_exists($hash, $loc_to)) {
            // translation found.
            return $loc_to[$hash];
        }

        // sentence hadn't been found returning original one
        return $sentence;
    }

    function getFromTo(string $from, string $to): array
    {
        $translations_from = $this->storage->read_file($from, $this->getDirname());
        $translations_to = $this->storage->read_file($to, $this->getDirname());
        $translation = [];

        foreach ($translations_from as $hash => $from) {
            $to = array_key_exists($hash, $translations_to) ? $translations_to[$hash] : '';
            $translation[$hash] = ['from' => $from, 'to' => $to];
        }

        return $translation;
    }

    function getLocalisation(string $lang = null): array
    {
        $lang = $lang ? $lang : $this->getCurrentLangage();
        return $this->storage->read_file($lang, $this->getDirname());
    }

    // bonjour , hello, FR, EN

    function hashSentence(string $sentence): string
    {
        return hash('md5', $sentence);
    }

    /**
     * @param string $from_sentence
     * @param string $from_lang
     * @param string|null $to_sencence
     * @param string|null $to_lang
     * @return string the new Hashkey
     */
    function addTranslation(string $from_sentence, string $from_lang, string $to_sencence = null, string $to_lang = null)
    {

        // saving final versions
        $from_localisation = $this->getLocalisation($from_lang);
        $hash = $this->hashSentence($from_sentence);
        $from_localisation[$hash] = $from_sentence;

        $storage = new Storage();
        $storage
            ->setLocalisations($from_localisation)
            ->write_file($from_lang, $this->getDirname());

        if ($to_sencence && $to_lang) {
            $to_localisation = $this->getLocalisation($from_lang);
            $to_localisation[$hash] = $from_sentence;
            $storage
                ->setLocalisations($to_localisation)
                ->write_file($to_lang, $this->getDirname());
        }
        return $hash;
    }

}