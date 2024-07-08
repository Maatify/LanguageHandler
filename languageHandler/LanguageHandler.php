<?php
/**
 * Created by Maatify.dev
 * User: Maatify.dev
 * Date: 2024-07-08
 * Time: 12:44 PM
 * https://www.Maatify.dev
 */

namespace Maatify\LanguageHandler;

abstract class LanguageHandler
{
    protected string $files_location = '';
    protected string $files_page_location = '';
    protected string $defaultLanguage = 'en';
    protected array $language_page = [];
    protected string $lang;
    protected array $all_lang;

    protected int $language_id = 0;

    protected array $language = [];
    protected string $page;

    public function __construct()
    {
        $this->all_lang = require $this->files_location . 'languages.php';
        $this->lang = $this->defaultLanguage;
        if(!empty($_GET['lang']) && preg_match('/^[A-Za-z]{2}$/', strtolower($_GET['lang']))){
            if(in_array(strtolower($_GET['lang']), $this->all_lang)){
                if(file_exists($this->files_location . strtolower($_GET['lang']) . '.php')){
                    $this->lang = strtolower($_GET['lang']);
                }
            }
        }
        $this->language = require $this->files_location . $this->lang . '.php';
    }

    public function Echo(string $index): string
    {
        if(!empty($this->language[$index])) {
            return $this->language[$index];
        }else{
            return '';
        }
    }

    public function Lang(): string
    {
        return $this->lang;
    }

    public function AllLang(): array
    {
        return $this->all_lang;
    }

    public function Direction(): string
    {
        if(!empty($this->language['is_rtl'])) {
            return 'rtl';
        }else{
            return 'ltr';
        }
    }

    public function LanguageArray(): array
    {
        return $this->language;
    }

    public function LanguageID(): int
    {
        if(empty($this->language_id)){
            $this->language_id = array_search($this->lang, $this->all_lang) + 1;
        }
        return $this->language_id;
    }

    public function SetPage(string $page): void
    {
        $page = strtolower($page);
        if(!empty($this->files_page_location)) {
            if (file_exists($this->files_page_location . $page . '/' . $this->lang . '.php')) {
                $this->language_page = require $this->files_page_location . $page . '/' . $this->lang . '.php';
            }
        }
    }

    public function LanguagePageArray(): array
    {
        return $this->language_page;
    }

    public function EchoPage(string $index): string
    {
        if(!empty($this->language_page[$index])) {
            return $this->language_page[$index];
        }else{
            return '';
        }
    }

    public function DirectionPage(): string
    {
        if(!empty($this->language_page['is_rtl'])) {
            return 'rtl';
        }else{
            return 'ltr';
        }
    }
}