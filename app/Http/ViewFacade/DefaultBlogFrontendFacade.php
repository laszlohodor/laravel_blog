<?php


namespace App\Http\ViewFacade;


use App\Http\ViewModel\MainPageModel;
use Symfony\Component\HttpFoundation\Request;

class DefaultBlogFrontendFacade implements BlogFrontendFacade
{
    public function assembleMainPageModel(Request $request)
    {
        return MainPageModel::builder()
            ->setMenu()
            ->build();
    }
}