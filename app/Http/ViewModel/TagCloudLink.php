<?php


namespace App\Http\ViewModel;


class TagCloudLink extends Link
{
    private $fontSize;

    /**
     * TagCloudLink constructor.
     * @param $url
     * @param $title
     * @param $fontSize
     */
    public function __construct($url, $title, $fontSize)
    {
        parent::__construct($url, $title);
        $this->fontSize = $fontSize;
    }

    /**
     * @return mixed
     */
    public function getFontSize()
    {
        return $this->fontSize;
    }
}
