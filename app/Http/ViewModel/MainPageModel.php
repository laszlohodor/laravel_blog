<?php


namespace App\Http\ViewModel;


use Illuminate\Contracts\Pagination\Paginator;

class MainPageModel
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
     * MainPageModel constructor.
     *
     * @param MainPageModelBuilder $builder
     */
    public function __construct(MainPageModelBuilder $builder)
    {
        $this->content = $builder->getContent();
        $this->menu = $builder->getMenu();
        $this->analyticsKey = $builder->getAnalyticsKey();
        $this->trending = $builder->getTrending();
        $this->tagCloud = $builder->getTagCloud();
        $this->facebookUrl = $builder->getFacebookUrl();
        $this->twitterUrl = $builder->getTwitterUrl();
        $this->feedsUrl = $builder->getFeedsUrl();
    }


    /**
     * @return Paginator
     */
    public function getContent(): Paginator
    {
        return $this->content;
    }

    /**
     * @return Menu
     */
    public function getMenu(): Menu
    {
        return $this->menu;
    }

    /**
     * @return string
     */
    public function getAnalyticsKey(): string
    {
        return $this->analyticsKey;
    }

    /**
     * @return Link[]
     */
    public function getTrending(): array
    {
        return $this->trending;
    }

    /**
     * @return TagCloud
     */
    public function getTagCloud(): TagCloud
    {
        return $this->tagCloud;
    }

    /**
     * @return string
     */
    public function getFacebookUrl(): string
    {
        return $this->facebookUrl;
    }

    /**
     * @return string
     */
    public function getTwitterUrl(): string
    {
        return $this->twitterUrl;
    }

    /**
     * @return string
     */
    public function getFeedsUrl(): string
    {
        return $this->feedsUrl;
    }

    /**
     *  Return new MainPageModelBuilder instance
     */
    public static function builder()
    {
        return new MainPageModelBuilder();
    }

}
