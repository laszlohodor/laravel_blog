<?php


namespace Tests\Unit\ViewFacade;

use App\Http\ViewModel\MainPageModel;
use App\Http\ViewModel\Menu;
use App\Http\ViewModel\Provider\MenuProvider;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\HttpFoundation\Request;
use App\Http\ViewFacade\DefaultBlogFrontendFacade;
use PHPUnit\Framework\TestCase as PHPUnit;

class DefaultBlogFrontendFacadeTest extends PHPUnit
{
    /**
     * @var DefaultBlogFrontendFacade
     */
    private $underTest;

    /**
     * @var MockObject
     */
    private $request;

    /**
     * @var MockObject
     */
    private $menuProvider;

    public function setUp(): void
    {
        $this->request = $this->getMockBuilder(Request::class)
            ->getMock();
        $this->menuProvider = $this->getMockBuilder(MenuProvider::class)
            ->setMethods(['provide'])
            ->getMock();
        $this->underTest = new DefaultBlogFrontendFacade($this->menuProvider);
    }

    /**
     * @test
     */
    public function assembleMainPageModel_should_return_model()
    {
        //GIVEN
        //WHEN
        $actual = $this->underTest->assembleMainPageModel($this->request);
        //THEN
        $this->assertInstanceOf(MainPageModel::class, $actual);
    }

    /**
     * @test
     */
    public function assembleMainPageModel_should_return_menu_field()
    {
        //GIVEN
        $menu = $this->getMockBuilder(Menu::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->menuProvider->expects($this->once())
            ->method('provide')
            ->willReturn($menu);
        //WHEN
        $actual = $this->underTest->assembleMainPageModel($this->request);
        //THEN
        $this->assertEquals($menu, $actual->getMenu());
    }

}
