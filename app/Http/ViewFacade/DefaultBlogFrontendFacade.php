<?php


namespace App\Http\ViewFacade;


use App\Http\ViewModel\MainPageModel;
use App\Http\ViewModel\Provider\MenuProvider;
use Symfony\Component\HttpFoundation\Request;

class DefaultBlogFrontendFacade implements BlogFrontendFacade
{
    /**
     * @var MenuProvider
     */
    private $menuProvider;

    /**
     * DefaultBlogFrontendFacade constructor.
     * @param $menuProvider
     */
    public function __construct($menuProvider)
    {
        $this->menuProvider = $menuProvider;
    }


    public function assembleMainPageModel(Request $request)
    {
        return MainPageModel::builder()
            ->setMenu($this->menuProvider->provide())
            ->build();
    }
}
