<?php


namespace Tests\Integration;

use App\Persistence\Model\Author;
use App\Persistence\Model\Post;
use App\Persistence\Repository\EloquentPostRepository;
use App\Persistence\Repository\PostRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
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
     * @param int $id
     * @param string $title
     * @param bool $enabled
     */
    private function createPost(int $id, string $title, bool $enabled): void
    {
        $post = factory(Post::class)->make(["id" => $id, "title" => $title, "enabled" => $enabled]);
        $author = factory(Author::class)->create();
        $post->author()->associate($author);
        $post->save();
    }

    /**
     * @param int $number
     * @param bool $enabled
     * @param $author
     */
    private function createPosts(int $number, bool $enabled)
    {
        $author = factory(Author::class)->create();
        factory(Post::class, $number)->make(["enabled" => $enabled])->each(function (Post $post) use ($author) {
            $post->author()->associate($author);
            $post->save();
        });
    }
}
