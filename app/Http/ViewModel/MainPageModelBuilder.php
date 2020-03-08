<?php


namespace App\Http\ViewModel;

use Illuminate\Contracts\Pagination\Paginator;

/**
 *  Builder class for MainPageModel
 *
 * @package App\Http\ViewModel
 */
class MainPageModelBuilder
{
    /**
     * @var Paginator
     */
    private $content;

    /**
     * @var Menu
     */
    private $menu;

    /**
     * @var string
     */
    private $analyticsKey;

    /**
     * @var Link[]
     */
    private $trending;

    /**
     * @var TagCloud
     */
    private $tagCloud;

    /**
     * @var string
     */
    private $facebookUrl;

    /**
     * @var string
     */
    private $twitterUrl;

    /**
     * @var string
     */
    private $feedsUrl;

    /**
     * @return Paginator
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param Paginator $content
     * @return MainPageModelBuilder
     */
    public function setContent(Paginator $content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return Menu
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * @param Menu $menu
     * @return MainPageModelBuilder
     */
    public function setMenu(Menu $menu)
    {
        $this->menu = $menu;
        return $this;
    }

    /**
     * @return string
     */
    public function getAnalyticsKey()
    {
        return $this->analyticsKey;
    }

    /**
     * @param string $analyticsKey
     * @return MainPageModelBuilder
     */
    public function setAnalyticsKey(string $analyticsKey)
    {
        $this->analyticsKey = $analyticsKey;
        return $this;
    }

    /**
     * @return Link[]
     */
    public function getTrending()
    {
        return $this->trending;
    }

    /**
     * @param Link[] $trending
     * @return MainPageModelBuilder
     */
    public function setTrending(array $trending)
    {
        $this->trending = $trending;
        return $this;
    }

    /**
     * @return TagCloud
     */
    public function getTagCloud()
    {
        return $this->tagCloud;
    }

    /**
     * @param TagCloud $tagCloud
     * @return MainPageModelBuilder
     */
    public function setTagCloud(TagCloud $tagCloud)
    {
        $this->tagCloud = $tagCloud;
        return $this;
    }

    /**
     * @return string
     */
    public function getFacebookUrl()
    {
        return $this->facebookUrl;
    }

    /**
     * @param string $facebookUrl
     * @return MainPageModelBuilder
     */
    public function setFacebookUrl(string $facebookUrl)
    {
        $this->facebookUrl = $facebookUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getTwitterUrl()
    {
        return $this->twitterUrl;
    }

    /**
     * @param string $twitterUrl
     * @return MainPageModelBuilder
     */
    public function setTwitterUrl(string $twitterUrl)
    {
        $this->twitterUrl = $twitterUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getFeedsUrl()
    {
        return $this->feedsUrl;
    }

    /**
     * @param string $feedsUrl
     * @return MainPageModelBuilder
     */
    public function setFeedsUrl(string $feedsUrl)
    {
        $this->feedsUrl = $feedsUrl;
        return $this;
    }

    /**
     *  Creates the actual MainPageModel
     */
    public function build()
    {
        return new MainPageModel($this);
    }
}
