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
    public function getContent(): Paginator
    {
        return $this->content;
    }

    /**
     * @param Paginator $content
     * @return MainPageModelBuilder
     */
    public function setContent(Paginator $content): MainPageModelBuilder
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return Menu
     */
    public function getMenu(): Menu
    {
        return $this->menu;
    }

    /**
     * @param Menu $menu
     * @return MainPageModelBuilder
     */
    public function setMenu(Menu $menu): MainPageModelBuilder
    {
        $this->menu = $menu;
        return $this;
    }

    /**
     * @return string
     */
    public function getAnalyticsKey(): string
    {
        return $this->analyticsKey;
    }

    /**
     * @param string $analyticsKey
     * @return MainPageModelBuilder
     */
    public function setAnalyticsKey(string $analyticsKey): MainPageModelBuilder
    {
        $this->analyticsKey = $analyticsKey;
        return $this;
    }

    /**
     * @return Link[]
     */
    public function getTrending(): array
    {
        return $this->trending;
    }

    /**
     * @param Link[] $trending
     * @return MainPageModelBuilder
     */
    public function setTrending(array $trending): MainPageModelBuilder
    {
        $this->trending = $trending;
        return $this;
    }

    /**
     * @return TagCloud
     */
    public function getTagCloud(): TagCloud
    {
        return $this->tagCloud;
    }

    /**
     * @param TagCloud $tagCloud
     * @return MainPageModelBuilder
     */
    public function setTagCloud(TagCloud $tagCloud): MainPageModelBuilder
    {
        $this->tagCloud = $tagCloud;
        return $this;
    }

    /**
     * @return string
     */
    public function getFacebookUrl(): string
    {
        return $this->facebookUrl;
    }

    /**
     * @param string $facebookUrl
     * @return MainPageModelBuilder
     */
    public function setFacebookUrl(string $facebookUrl): MainPageModelBuilder
    {
        $this->facebookUrl = $facebookUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getTwitterUrl(): string
    {
        return $this->twitterUrl;
    }

    /**
     * @param string $twitterUrl
     * @return MainPageModelBuilder
     */
    public function setTwitterUrl(string $twitterUrl): MainPageModelBuilder
    {
        $this->twitterUrl = $twitterUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getFeedsUrl(): string
    {
        return $this->feedsUrl;
    }

    /**
     * @param string $feedsUrl
     * @return MainPageModelBuilder
     */
    public function setFeedsUrl(string $feedsUrl): MainPageModelBuilder
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
