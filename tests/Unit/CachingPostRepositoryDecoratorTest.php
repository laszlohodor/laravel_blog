<?php

namespace Tests\Unit;

use App\Persistence\Model\Post;
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
            ->with($key, $expectedResults, 60)
            ->willReturn(null);
        //WHEN
        $actual = $this->underTest->findAllPublic(1, 20);
        //THEN
        $this->assertEquals($expectedResults, $actual);
    }

    /**
     * @test
     */
    public function findMostViewed_should_return_cache_value()
    {
        //GIVEN
        $expectedResults = 'cacheValue';
        $key = 'post:20';
        $tagName = 'mostViewed';
        $this->mockCache->expects($this->once())
            ->method('tags')
            ->with($tagName)
            ->willReturn($this->taggedCache);
        $this->taggedCache->expects($this->once())
            ->method('get')
            ->with($key)
            ->willReturn($expectedResults);
        //WHEN
        $actual = $this->underTest->findMostViewed(20);
        //THEN
        $this->assertEquals($expectedResults, $actual);
    }

    /**
     * @test
     */
    public function findMostViewed_should_store_in_cache()
    {
        //GIVEN
        $expectedResults = 'fromDB';
        $key = 'post:20';
        $tagName = 'mostViewed';
        $this->mockCache->expects($this->once())
            ->method('tags')
            ->with($tagName)
            ->willReturn($this->taggedCache);
        $this->taggedCache->expects($this->once())
            ->method('get')
            ->with($key)
            ->willReturn(null);
        $this->mockRepository->expects($this->once())
            ->method('findMostViewed')
            ->with(20)
            ->willReturn($expectedResults);
        $this->taggedCache->expects($this->once())
            ->method('put')
            ->with($key, $expectedResults, 60);
        //WHEN
        $actual = $this->underTest->findMostViewed(20);
        //THEN
        $this->assertEquals($expectedResults, $actual);
    }

    /**
     * @test
     */
    public function findByCategory_should_return_cache_value()
    {
        //GIVEN
        $expectedResults = 'cacheValue';
        $category = 'Ezekiel';
        $page = 25;
        $size = 17;
        $key = 'Ezekiel:25:17';
        $tagName = 'category';
        $this->mockCache->expects($this->once())
            ->method('tags')
            ->with($tagName)
            ->willReturn($this->taggedCache);
        $this->taggedCache->expects($this->once())
            ->method('get')
            ->with($key)
            ->willReturn($expectedResults);
        //WHEN
        $actual = $this->underTest->findByCategory($category, $page, $size);
        //THEN
        $this->assertEquals($expectedResults, $actual);
    }

    /**
     * @test
     */
    public function findByCategory_should_should_store_in_cache()
    {
        //GIVEN
        $expectedResults = 'fromDB';
        $category = 'Ezekiel';
        $page = 25;
        $size = 17;
        $key = 'Ezekiel:25:17';
        $tagName = 'category';
        $this->mockCache->expects($this->once())
            ->method('tags')
            ->with($tagName)
            ->willReturn($this->taggedCache);
        $this->taggedCache->expects($this->once())
            ->method('get')
            ->with($key)
            ->willReturn(null);
        $this->mockRepository->expects($this->once())
            ->method('findByCategory')
            ->with($category, $page, $size)
            ->willReturn($expectedResults);
        $this->taggedCache->expects($this->once())
            ->method('put')
            ->with($key, $expectedResults, 60);
        //WHEN
        $actual = $this->underTest->findByCategory($category, $page, $size);
        //THEN
        $this->assertEquals($expectedResults, $actual);
    }

    /**
     * @test
     */
    public function findByTag_should_return_cache_value()
    {
        //GIVEN
        $expectedResults = 'cacheValue';
        $tag = 'Ezekiel';
        $page = 25;
        $size = 17;
        $key = 'Ezekiel:25:17';
        $tagName = 'tag';
        $this->mockCache->expects($this->once())
            ->method('tags')
            ->with($tagName)
            ->willReturn($this->taggedCache);
        $this->taggedCache->expects($this->once())
            ->method('get')
            ->with($key)
            ->willReturn($expectedResults);
        //WHEN
        $actual = $this->underTest->findByTag($tag, $page, $size);
        //THEN
        $this->assertEquals($expectedResults, $actual);
    }

    /**
     * @test
     */
    public function findByTag_should_should_store_in_cache()
    {
        //GIVEN
        $expectedResults = 'fromDB';
        $tag = 'Ezekiel';
        $page = 25;
        $size = 17;
        $key = 'Ezekiel:25:17';
        $tagName = 'tag';
        $this->mockCache->expects($this->once())
            ->method('tags')
            ->with($tagName)
            ->willReturn($this->taggedCache);
        $this->taggedCache->expects($this->once())
            ->method('get')
            ->with($key)
            ->willReturn(null);
        $this->mockRepository->expects($this->once())
            ->method('findByTag')
            ->with($tag, $page, $size)
            ->willReturn($expectedResults);
        $this->taggedCache->expects($this->once())
            ->method('put')
            ->with($key, $expectedResults, 60);
        //WHEN
        $actual = $this->underTest->findByTag($tag, $page, $size);
        //THEN
        $this->assertEquals($expectedResults, $actual);
    }

    /**
     * @test
     */
    public function findByAuthor_should_return_cache_value()
    {
        //GIVEN
        $expectedResults = 'cacheValue';
        $author = 'Ezekiel';
        $page = 25;
        $size = 17;
        $key = 'Ezekiel:25:17';
        $tagName = 'author';
        $this->mockCache->expects($this->once())
            ->method('tags')
            ->with($tagName)
            ->willReturn($this->taggedCache);
        $this->taggedCache->expects($this->once())
            ->method('get')
            ->with($key)
            ->willReturn($expectedResults);
        //WHEN
        $actual = $this->underTest->findByAuthor($author, $page, $size);
        //THEN
        $this->assertEquals($expectedResults, $actual);
    }

    /**
     * @test
     */
    public function findByAuthor_should_should_store_in_cache()
    {
        //GIVEN
        $expectedResults = 'fromDB';
        $author = 'Ezekiel';
        $page = 25;
        $size = 17;
        $key = 'Ezekiel:25:17';
        $tagName = 'author';
        $this->mockCache->expects($this->once())
            ->method('tags')
            ->with($tagName)
            ->willReturn($this->taggedCache);
        $this->taggedCache->expects($this->once())
            ->method('get')
            ->with($key)
            ->willReturn(null);
        $this->mockRepository->expects($this->once())
            ->method('findByAuthor')
            ->with($author, $page, $size)
            ->willReturn($expectedResults);
        $this->taggedCache->expects($this->once())
            ->method('put')
            ->with($key, $expectedResults, 60);
        //WHEN
        $actual = $this->underTest->findByAuthor($author, $page, $size);
        //THEN
        $this->assertEquals($expectedResults, $actual);
    }

    /**
     * @test
     */
    public function findBySlugAndPublishedDate_should_return_cache_value()
    {
        //GIVEN
        $expectedResults = 'cacheValue';
        $date = '2020-01-01';
        $slug = 'what-is-love';
        $key = 'what-is-love:2020-01-01';
        $tagName = 'individualPost';
        $this->mockCache->expects($this->once())
            ->method('tags')
            ->with($tagName)
            ->willReturn($this->taggedCache);
        $this->taggedCache->expects($this->once())
            ->method('get')
            ->with($key)
            ->willReturn($expectedResults);
        //WHEN
        $actual = $this->underTest->findBySlugAndPublishedDate($slug, $date);
        //THEN
        $this->assertEquals($expectedResults, $actual);
    }

    /**
     * @test
     */
    public function findBySlugAndPublishedDate_should_should_store_in_cache()
    {
        //GIVEN
        $expectedResults = 'fromDB';
        $date = '2020-01-01';
        $slug = 'ezekiel';
        $key = 'ezekiel:2020-01-01';
        $tagName = 'individualPost';
        $this->mockCache->expects($this->once())
            ->method('tags')
            ->with($tagName)
            ->willReturn($this->taggedCache);
        $this->taggedCache->expects($this->once())
            ->method('get')
            ->with($key)
            ->willReturn(null);
        $this->mockRepository->expects($this->once())
            ->method('findBySlugAndPublishedDate')
            ->with($slug, $date)
            ->willReturn($expectedResults);
        $this->taggedCache->expects($this->once())
            ->method('put')
            ->with($key, $expectedResults, 60);
        //WHEN
        $actual = $this->underTest->findBySlugAndPublishedDate($slug, $date);
        //THEN
        $this->assertEquals($expectedResults, $actual);
    }

    /**
     * @test
     */
    public function deleteById_should_empty_cache()
    {
        //GIVEN
        $id = 1;
        $this->mockCache->expects($this->once())
            ->method('tags')
            ->with(['category', 'mostViewed', 'tag', 'author', 'allPublicPosts', 'individualPost'])
            ->willReturn($this->taggedCache);
        $this->mockRepository->expects($this->once())
            ->method('deleteById')
            ->with($id);
        $this->taggedCache->expects($this->once())
            ->method('flush');
        //WHEN
        $this->underTest->deleteById($id);
        //THEN
    }

    /**
     * @test
     */
    public function save_should_empty_cache()
    {
        //GIVEN
        $post = $this->createMock(Post::class);
        $this->mockCache->expects($this->once())
            ->method('tags')
            ->with(['category', 'mostViewed', 'tag', 'author', 'allPublicPosts', 'individualPost'])
            ->willReturn($this->taggedCache);
        $this->taggedCache->expects($this->once())
            ->method('flush');
        $this->mockRepository->expects($this->once())
            ->method('save')
            ->with($post);
        //WHEN
        $this->underTest->save($post);
        //THEN
    }
}
