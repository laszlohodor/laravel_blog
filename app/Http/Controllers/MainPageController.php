<?php

namespace App\Http\Controllers;

use App\Http\ViewFacade\BlogFrontendFacade;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\View\Factory;

class MainPageController extends Controller
{
    /**
     * @var Factory
     */
    private $factory;

    /**
     * @var BlogFrontendFacade
     */
    private $frontendFacade;


    public function __construct(Factory $factory, BlogFrontendFacade $frontendFacade)
    {
        $this->factory = $factory;
        $this->frontendFacade = $frontendFacade;
    }

    public function index(Request $request)
    {
        return $this->factory->make('index', [
           'model' => $this->frontendFacade->assembleMainPageModel($request)
        ]);
    }
}
