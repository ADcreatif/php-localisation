<?php


namespace ADcreatif\Localisation;


use DomainException;

class Storage
{
    private $localisations = [];

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


    function read_file(string $lang, string $dirname): array
    {
        try {
            $fileName = $dirname . $lang . '.txt';
            $content = [];

            if (!file_exists($dirname))
                throw new DomainException("Can't find directory : \"" . $dirname . '"');

            if (!file_exists($fileName)) {
                file_put_contents($fileName, '');
                throw new DomainException("file \"$fileName\" can not be found creating it.");
            }

            if ($content)
                $content = unserialize(file_get_contents($fileName));

        } catch (DomainException $exception) {
            echo $exception->getMessage();
        }

        return $content;

    }

    function write_file(string $lang, string $dirname): array
    {
        try {
            $fileName = $dirname . $lang . '.txt';

            if (!file_exists($dirname))
                throw new DomainException("<br>Can't find directory : " . $dirname);

            if (!is_writable($dirname))
                throw new DomainException("<br>Can not write in directory : " . $dirname);

            file_put_contents($fileName, serialize($this->getLocalisations()));

            return $this->localisations;
        } catch (DomainException $exception) {
            die($exception->getMessage());
        }
    }
}