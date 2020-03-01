<?php


namespace Tests\Integration;

use App\Persistence\Model\Author;
use App\Persistence\Model\Category;
use App\Persistence\Model\Post;
use App\Persistence\Model\Tag;
use App\Persistence\Repository\EloquentPostRepository;
use App\Persistence\Repository\PostRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EloquentPostRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var PostRepository
     */
    private $underTest;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->underTest = new EloquentPostRepository(new Post());
    }

    /**
     * @test
     */
    public function findById_should_return_post_by_id()
    {
        //GIVEN
        $id = 5;
        $title = "test";
        $enabled = true;
        $this->createPost($id, $title, $enabled);
        //WHEN
        $actual = $this->underTest->findById($id);
        //THEN
        $this->assertEquals($actual->title, $title);
    }

    /**
     * @test
     */
    public function findById_should_return_post_by_id_regardless_enabled()
    {
        //GIVEN
        $id = 5;
        $title = "test";
        $enabled = false;
        $this->createPost($id, $title, $enabled);
        //WHEN
        $actual = $this->underTest->findById($id);
        //THEN
        $this->assertEquals($actual->title, $title);
    }

    /**
     * @test
     */
    public function findAllPublic_should_return_filled_paginator_when_got_no_enabled_posts()
    {
        //GIVEN
        $number = 5;
        $enabled = false;
        $this->createPosts($number, $enabled);
        //WHEN
        $actual = $this->underTest->findAllPublic(1, 2);
        //THEN
        $this->assertEquals($actual->isEmpty(), true);
        $this->assertEquals($actual->hasPages(), false);
        $this->assertEquals($actual->currentPage(), 1);
        $this->assertEquals(count($actual->items()), null);
    }

    /**
     * @test
     */
    public function findAllPublic_should_return_filled_paginator_when_got_enabled_posts()
    {
        //GIVEN
        $number = 5;
        $enabled = true;
        $this->createPosts($number, $enabled);
        //WHEN
        $actual = $this->underTest->findAllPublic(1, 2);
        //THEN
        $this->assertEquals($actual->isEmpty(), false);
        $this->assertEquals($actual->hasPages(), true);
        $this->assertEquals($actual->currentPage(), 1);
        $this->assertEquals(count($actual->items()), 2);
    }

    /**
     * @test
     */
    public function findAll_should_return_filled_paginator_regardless_enabled_state()
    {
        //GIVEN
        $number = 3;
        $this->createPosts($number, false);
        $this->createPosts($number, true);
        //WHEN
        $actual = $this->underTest->findAll(1, 6);
        //THEN
        $this->assertEquals($actual->isEmpty(), false);
        $this->assertEquals($actual->hasPages(), false);
        $this->assertEquals($actual->currentPage(), 1);
        $this->assertEquals(count($actual->items()), 6);
    }

    /**
     * @test
     */
    public function findByAuthor_should_return_enabled_posts_for_the_author()
    {
        //GIVEN
        $displayName = 'test';
        $author = factory(Author::class)->create(['display_name' => $displayName]);
        $this->createPosts(5, true, $author);
        //WHEN
        $actual = $this->underTest->findByAuthor($displayName, 1, 10);
        //THEN
        $this->assertEquals($actual->isEmpty(), false);
        $this->assertEquals($actual->hasPages(), false);
        $this->assertEquals($actual->currentPage(), 1);
        $this->assertEquals(count($actual->items()), 5);
    }

    /**
     * @test
     */
    public function findByAuthor_should_not_return_disabled_posts_for_the_author()
    {
        //GIVEN
        $displayName = 'test';
        $author = factory(Author::class)->create(['display_name' => $displayName]);
        $this->createPosts(5, false, $author);
        //WHEN
        $actual = $this->underTest->findByAuthor($displayName, 1, 10);
        //THEN
        $this->assertEquals($actual->isEmpty(), true);
        $this->assertEquals($actual->hasPages(), false);
        $this->assertEquals($actual->currentPage(), 1);
        $this->assertEquals(count($actual->items()), null);
    }

    /**
     * @test
     */
    public function findByAuthor_should_not_return_other_author_posts()
    {
        //GIVEN
        $displayName = 'test';
        $author = factory(Author::class)->create(['display_name' => $displayName]);
        $this->createPosts(5, false, $author);
        //WHEN
        $actual = $this->underTest->findByAuthor('other', 1, 10);
        //THEN
        $this->assertEquals($actual->isEmpty(), true);
        $this->assertEquals($actual->hasPages(), false);
        $this->assertEquals($actual->currentPage(), 1);
        $this->assertEquals(count($actual->items()), null);
    }

    /**
     * @test
     */
    public function findByCategory_should_return_enabled_posts_for_the_category()
    {
        //GIVEN
        $nameClean = 'included';
        $category = factory(Category::class)->create(['name_clean' => $nameClean]);
        $this->createPostsForCategories(5, true, [$category]);
        //WHEN
        $actual = $this->underTest->findByCategory($nameClean, 1, 5);
        //THEN
        $this->assertEquals($actual->isEmpty(), false);
        $this->assertEquals($actual->hasPages(), false);
        $this->assertEquals($actual->currentPage(), 1);
        $this->assertEquals(count($actual->items()), 5);
    }

    /**
     * @test
     */
    public function findByCategory_should_return_disabled_posts_for_the_category()
    {
        //GIVEN
        $nameClean = 'included';
        $category = factory(Category::class)->create(['name_clean' => $nameClean]);
        $this->createPostsForCategories(5, false, [$category]);
        //WHEN
        $actual = $this->underTest->findByCategory($nameClean, 1, 5);
        //THEN
        $this->assertEquals($actual->isEmpty(), true);
        $this->assertEquals($actual->hasPages(), false);
        $this->assertEquals($actual->currentPage(), 1);
        $this->assertEquals(count($actual->items()), null);
    }

    /**
     * @test
     */
    public function findByCategory_should_not_return_other_categories_posts()
    {
        //GIVEN
        $category = factory(Category::class)->create(['name_clean' => 'not included']);
        $this->createPostsForCategories(5, true, [$category]);
        //WHEN
        $actual = $this->underTest->findByCategory('included', 1, 5);
        //THEN
        $this->assertEquals($actual->isEmpty(), true);
        $this->assertEquals($actual->hasPages(), false);
        $this->assertEquals($actual->currentPage(), 1);
        $this->assertEquals(count($actual->items()), null);
    }

    /**
     * @test
     */
    public function findByCategory_should_not_interfere_with_other_categories()
    {
        //GIVEN
        $category = factory(Category::class)->create(['name_clean' => 'included']);
        $otherCategory = factory(Category::class)->create(['name_clean' => 'not included']);
        $this->createPostsForCategories(5, true, [$category, $otherCategory]);
        //WHEN
        $actual = $this->underTest->findByCategory('included', 1, 5);
        //THEN
        $this->assertEquals($actual->isEmpty(), false);
        $this->assertEquals($actual->hasPages(), false);
        $this->assertEquals($actual->currentPage(), 1);
        $this->assertEquals(count($actual->items()), 5);
    }

    /**
     * @test
     */
    public function findByTag_should_return_enabled_post_for_tag()
    {
        //GIVEN
        $tag = factory(Tag::class)->create(['tag_clean' => 'included']);
        $this->createPostsForTags(5, true, [$tag]);
        //WHEN
        $actual = $this->underTest->findByTag('included', 1, 5);
        //THEN
        $this->assertEquals($actual->isEmpty(), false);
        $this->assertEquals($actual->hasPages(), false);
        $this->assertEquals($actual->currentPage(), 1);
        $this->assertEquals(count($actual->items()), 5);
    }

    /**
     * @test
     */
    public function findByTag_should_return_disabled_post_for_tag()
    {
        //GIVEN
        $tag = factory(Tag::class)->create(['tag_clean' => 'included']);
        $this->createPostsForTags(5, false, [$tag]);
        //WHEN
        $actual = $this->underTest->findByTag('included', 1, 5);
        //THEN
        $this->assertEquals($actual->isEmpty(), true);
        $this->assertEquals($actual->hasPages(), false);
        $this->assertEquals($actual->currentPage(), 1);
        $this->assertEquals(count($actual->items()), null);
    }

    /**
     * @test
     */
    public function findByTag_should_not_return_other_tags_post()
    {
        //GIVEN
        $tag = factory(Tag::class)->create(['tag_clean' => 'not included']);
        $this->createPostsForTags(5, true, [$tag]);
        //WHEN
        $actual = $this->underTest->findByTag('included', 1, 5);
        //THEN
        $this->assertEquals($actual->isEmpty(), true);
        $this->assertEquals($actual->hasPages(), false);
        $this->assertEquals($actual->currentPage(), 1);
        $this->assertEquals(count($actual->items()), null);
    }

    /**
     * @test
     */
    public function findByTag_should_not_interfere_with_other_tags()
    {
        //GIVEN
        $tag = factory(Tag::class)->create(['tag_clean' => 'included']);
        $notIncludedTag = factory(Tag::class)->create(['tag_clean' => 'not included']);
        $this->createPostsForTags(5, true, [$tag, $notIncludedTag]);
        //WHEN
        $actual = $this->underTest->findByTag('included', 1, 5);
        //THEN
        $this->assertEquals($actual->isEmpty(), false);
        $this->assertEquals($actual->hasPages(), false);
        $this->assertEquals($actual->currentPage(), 1);
        $this->assertEquals(count($actual->items()), 5);
    }

    /**
     * @test
     */
    public function findBySlugAndPublishedDate_should_return_enabled_post_by_date_and_slug()
    {
        //GIVEN
        $post = factory(Post::class)->make(['title_clean' => 'test', 'enabled' => true, 'date_published' => '2020-01-01']);
        $author = factory(Author::class)->create();
        $post->author()->associate($author);
        $post->save();
        //WHEN
        $actual = $this->underTest->findBySlugAndPublishedDate('test', '2020-01-01');
        //THEN
        $this->assertEquals('test', $actual->title_clean);
    }

    /**
     * @test
     */
    public function findBySlugAndPublishedDate_should_not_return_disabled_post_by_date_and_slug()
    {
        //GIVEN
        $post = factory(Post::class)->make(['title_clean' => 'test', 'enabled' => false, 'date_published' => '2020-01-01']);
        $author = factory(Author::class)->create();
        $post->author()->associate($author);
        $post->save();
        //WHEN
        $actual = $this->underTest->findBySlugAndPublishedDate('test', '2020-01-01');
        //THEN
        $this->assertNull($actual);
    }

    /**
     * @test
     */
    public function findMostViewed_should_return_most_viewed_enabled_posts_in_an_array()
    {
        //GIVEN
        $this->createPost(1, 'last', true, 1);
        $this->createPost(2, 'middle', true, 5);
        $this->createPost(3, 'desabled', false, 5);
        $this->createPost(4, 'first', true, 10);
        //WHEN
        $actual = $this->underTest->findMostViewed(3);
        //THEN
        $this->assertEquals(10, $actual[0]->views);
        $this->assertEquals(5, $actual[1]->views);
        $this->assertEquals('middle', $actual[1]->title);
        $this->assertEquals(1, $actual[2]->views);
    }

    /**
     * @param int $id
     * @param string $title
     * @param bool $enabled
     * @param int $views
     */
    private function createPost(int $id, string $title, bool $enabled, $views = 1): void
    {
        $post = factory(Post::class)->make(["id" => $id, "title" => $title, "enabled" => $enabled, 'views' => $views]);
        $author = factory(Author::class)->create();
        $post->author()->associate($author);
        $post->save();
    }

    /**
     * @param int $number
     * @param bool $enabled
     * @param $author
     */
    private function createPosts(int $number, bool $enabled, $author = null)
    {
        if ($author == null) {
            $author = factory(Author::class)->create();
        }
        factory(Post::class, $number)->make(["enabled" => $enabled])->each(function (Post $post) use ($author) {
            $post->author()->associate($author);
            $post->save();
        });
    }

    /**
     * @param array $categories
     */
    private function createPostsForCategories($count, $enabled, array $categories): void
    {
        $author = factory(Author::class)->create();
        factory(Post::class, $count)->make(['enabled' => $enabled])->each(function (Post $post) use ($author, $categories) {
            $post->author()->associate($author);
            $post->save();
            $post->category()->saveMany($categories);
        });
    }

    private function createPostsForTags($count, $enabled, array $tags)
    {
        $author = factory(Author::class)->create();
        factory(Post::class, $count)->make(['enabled' => $enabled])->each(function (Post $post) use ($author, $tags) {
            $post->author()->associate($author);
            $post->save();
            $post->tags()->saveMany($tags);
        });
    }
}
