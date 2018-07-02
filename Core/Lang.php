<?php

namespace Core;

use DirectoryIterator;

class Lang {
    public $currentLanguage = '';
    public $languageArray = [];
    public $allLanguagesArray = [];

    public function __construct($lang = 'en') {
        $this->setLanguage($lang);
    }

    public function getTranslation($string) {
        if(array_key_exists($string, $this->languageArray['translations'])) {
            return $this->languageArray['translations'][$string];
        } else {
            return $string;
        }
    }

    public function setLanguage($lang) {
        if(file_exists(__DIR__ . './../resources/lang/' . $lang . '.json')) {
            $this->currentLanguage = $lang;
            $this->loadLanguage($lang);
        }
    }

    public function isLanguage($iso) {
        if($this->currentLanguage === $iso) {
            return true;
        }

        return false;
    }

    public function getAllTranslations() {
        return $this->languageArray['translations'];
    }

    public function getCurrentLanguage() {
        return $this->currentLanguage;
    }

    public function loadLanguage($lang) {
        $file = file_get_contents(__DIR__ . './../resources/lang/' . $lang . '.json');

        $this->languageArray = json_decode($file, true);
    }

    public function getAllLanguages() {
        foreach (new DirectoryIterator(__DIR__ . './../resources/lang') as $lang) {
            if($lang->isDot()) continue;
            $fileContent = json_decode(file_get_contents(__DIR__ . './../resources/lang/' . $lang->getBasename('.json') . '.json'), true);

            $this->allLanguagesArray[] = [
                'iso' => $lang->getBasename('.json'),
                'name' => $fileContent['settings']['name']
            ];
        }

        return $this->allLanguagesArray;
    }
}