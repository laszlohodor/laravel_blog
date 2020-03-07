<?php


namespace App\Http\ViewModel;

/**
 * Hold the information needed te render a link
 *
 * @package App\Http\ViewModel
 */
class Link
{
    protected $url;
    protected $title;

    public function __construct($url, $title)
    {
        $this->url = $url;
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }
}
