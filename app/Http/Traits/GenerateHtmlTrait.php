<?php

namespace App\Http\Traits;

trait  GenerateHtmlTrait
{
    public function generateHtmlUniversityDescription(string $content): array|bool|string
    {
        $html = @file_get_contents(storage_path() . '/html/template-description-university.html');
        $html = str_replace('<!--CONTENT-->', $content, $html);

        if (!empty($thumbnail)){
            $stringImage = '<img src="' . asset($thumbnail) . '" alt="News thumbnail">';
            $html = str_replace('<!--IMAGE THUMBNAIL-->', $stringImage, $html);
        }

        if (!empty($content)) {
            $html = str_replace('<!--CONTENT-->', $content, $html);
        }

        $html = $this->__replaceDoubleQuote($html);
        return  $this->__replaceSlashN($html);
    }


    public function generateHtmlArticle($title, $thumbnail, $content): array|bool|string
    {
        $html = @file_get_contents(storage_path() . '/html/template-news.html');
        $html = str_replace('<!--TITLE-->', $title, $html);

        if (!empty($thumbnail)){
            $stringImage = '<img src="' . asset($thumbnail) . '" alt="News thumbnail">';
            $html = str_replace('<!--IMAGE THUMBNAIL-->', $stringImage, $html);
        }

        if (!empty($content)) {
            $html = str_replace('<!--CONTENT-->', $content, $html);
        }
        $html = $this->__replaceDoubleQuote($html);
        return  $this->__replaceSlashN($html);
    }

    public function generateHtmlInternationalAffair($title, $thumbnail, $content): array|bool|string
    {
        $html = @file_get_contents(storage_path() . '/html/template-internationalAffair.html');
        $html = str_replace('<!--TITLE-->', $title, $html);

        if (!empty($thumbnail)){
            $stringImage = '<img src="' . asset($thumbnail) . '" alt="News thumbnail">';
            $html = str_replace('<!--IMAGE THUMBNAIL-->', $stringImage, $html);
        }

        if (!empty($content)) {
            $html = str_replace('<!--CONTENT-->', $content, $html);
        }

        $html = $this->__replaceDoubleQuote($html);
        return  $this->__replaceSlashN($html);
    }

    public function generateHtmlSecretariat($title, $thumbnail, $content): array|bool|string
    {
        $html = @file_get_contents(storage_path() . '/html/template-secretariat.html');
        $html = str_replace('<!--TITLE-->', $title, $html);

        if (!empty($thumbnail)){
            $stringImage = '<img src="' . asset($thumbnail) . '" alt="News thumbnail">';
            $html = str_replace('<!--IMAGE THUMBNAIL-->', $stringImage, $html);
        }

        if (!empty($content)) {
            $html = str_replace('<!--CONTENT-->', $content, $html);
        }

        $html = $this->__replaceDoubleQuote($html);
        return  $this->__replaceSlashN($html);
    }
    private function __replaceDoubleQuote(string $string): string
    {
        return str_replace('"', "'", $string);
    }
    private function __replaceSlashN(string $string): string
    {
        return str_replace("\n", " ", $string);
    }

    private function __replaceSlashR(string $string): string
    {
        return str_replace("\r", " ", $string);
    }
}
