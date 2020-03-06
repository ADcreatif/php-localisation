<?php


namespace ADcreatif\Localisation;


use DomainException;

class Storage
{
    private $dirname = "_lang/";
    private $cur_lang = "EN";
    private $localisations = [];
    private $errors = [];

    public function __construct(string $dirname = "_lang/")
    {
        $this->dirname = $dirname;
    }

    function read_file(): array
    {

        try {
            $fileName = $this->getDirname() . $this->getCurLang() . '.txt';

            if (!file_exists($fileName)) {
                $this->errors[] = "file $fileName can not be found creating it.";
                $this->write_file();
            }

            $localisations = unserialize(file_get_contents($fileName));

            //if($localisations === false || !is_array($localisations))
            //    return [];

            return $localisations;

        } catch (DomainException $exception) {
            die($exception->getMessage());
        }
    }

    /**
     * @return string
     */
    public function getDirname(): string
    {
        return $this->dirname;
    }

    /**
     * @param string $dirname
     * @return Storage
     */
    public function setDirname(string $dirname): Storage
    {
        $this->dirname = $dirname;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurLang(): string
    {
        return $this->cur_lang;
    }

    /**
     * @param string $cur_lang
     * @return Storage
     */
    public function setCurLang(string $cur_lang): Storage
    {
        $this->cur_lang = $cur_lang;
        return $this;
    }

    function write_file(): array
    {
        try {
            $fileName = $this->getDirname() . $this->getCurLang() . '.txt';

            if (!file_exists($this->getDirname()))
                throw new DomainException("Can't find directory : " . $this->getDirname());

            if (!is_writable($this->getDirname()))
                throw new DomainException("Can not write in directory : " . $this->getDirname());

//            if(!is_writable($fileName))
//                throw new \DomainException("Can not write file : ".$fileName);る

//           var_dump($this->getDirname(), $this->getCurLang(), $this->getLocalisations());
            file_put_contents($fileName, serialize($this->getLocalisations()));

            return $this->localisations;
        } catch (DomainException $exception) {
            die($exception->getMessage());
        }
    }

    /**
     * @return array
     */
    public function getLocalisations(): array
    {
        return $this->localisations;
    }

    /**
     * @param array $localisations
     * @return Storage
     */
    public function setLocalisations(array $localisations): Storage
    {
        $this->localisations = $localisations;
        return $this;
    }
}