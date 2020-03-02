<?php

namespace Tests\Unit;

use App\Persistence\Repository\CachingPostRepositoryDecorator;
use App\Persistence\Repository\PostRepository;
use Illuminate\Cache\Repository;
use Illuminate\Cache\TaggedCache;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class CachingPostRepositoryDecoratorTest extends TestCase
{
    /**
     * @var PostRepository
     */
    private $underTest;

    /**
     * @var MockObject
     */
    private $mockRepository;

    /**
     * @var MockObject
     */
    private $mockCache;

    /**
     * @var TaggedCache
     */
    private $taggedCache;

    public function setUp(): void{

        $this->mockCache = $this->getMockBuilder(Repository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->taggedCache = $this->getMockBuilder(TaggedCache::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->mockRepository = $this->getMockBuilder(PostRepository::class)
            ->getMock();
        $this->underTest = new CachingPostRepositoryDecorator($this->mockRepository, $this->mockCache);
    }

    /**
     * @test
     */
    public function findAllPublic_should_return_cache_results()
    {
        //GIVEN
        $expectedResults = 'cacheValue';
        $key = 'page_1:20';
        $tagName = 'allPublicPosts';
        $this->mockCache->expects($this->once())
            ->method('tags')
            ->with($tagName)
            ->willReturn($this->taggedCache);
        $this->taggedCache->expects($this->never())
            ->method('has')
            ->with($key)
            ->willReturn(true);
        $this->taggedCache->expects($this->once())
            ->method('get')
            ->with($key)
            ->willReturn($expectedResults);
        //WHEN
        $actual = $this->underTest->findAllPublic(1, 20);
        //THEN
        $this->assertEquals($expectedResults, $actual);
    }

    /**
     * @test
     */
    public function findAllPublic_should_put_results_cache()
    {
        //GIVEN
        $expectedResults = 'fromDB';
        $key = 'page_1:20';
        $tagName = 'allPublicPosts';
        $this->mockCache->expects($this->once())
            ->method('tags')
            ->with($tagName)
            ->willReturn($this->taggedCache);
        $this->taggedCache->expects($this->once())
            ->method('get')
            ->with($key)
            ->willReturn(null);
        $this->mockRepository->expects($this->once())
            ->method('findAllPublic')
            ->with(1, 20)
            ->willReturn($expectedResults);
        $this->taggedCache->expects($this->once())
            ->method('put')
            ->with($key, $expectedResults)
            ->willReturn(null);
        //WHEN
        $actual = $this->underTest->findAllPublic(1, 20);
        //THEN
        $this->assertEquals($expectedResults, $actual);
    }
}
