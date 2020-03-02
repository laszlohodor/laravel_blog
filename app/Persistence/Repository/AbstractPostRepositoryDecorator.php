<?php


namespace App\Persistence\Repository;


use App\Persistence\Model\Post;
use Illuminate\Contracts\Pagination\Paginator;

abstract class AbstractPostRepositoryDecorator implements PostRepository
{
    /**
     * @var PostRepository
     */
    protected $postRepository;

    function __construct($postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Return all public post paginated
     *
     * @param $page int page number
     * @param $size int the size of the page
     * @return Paginator
     */
    public function findAllPublic($page, $size)
    {
        return $this->postRepository->findAllPublic($page, $size);
    }

    /**
     * Return all posts using a paginator
     *
     * @param $page int page a paginator
     * @param $size int the size of the page
     * @return Paginator
     */
    public function findAll($page, $size)
    {
        return $this->postRepository->findAll($page, $size);
    }

    /**
     * Return a Post given by the slug and published date
     *
     * @param $slug string the slugified post title
     * @param $date string the date of the publish
     * @return Post
     */
    public function findBySlugAndPublishedDate($slug, $date)
    {
        return $this->postRepository->findBySlugAndPublishedDate($slug, $date);
    }

    /**
     * Return a post by its ID
     *
     * @param $id int the post id
     * @return Post
     */
    public function findById($id)
    {
        return $this->postRepository->findById($id);
    }

    /**
     * Return the post viewed post in descending order
     *
     * @param $limit int the number of posts
     * @return Post[]
     */
    public function findMostViewed($limit)
    {
        return $this->postRepository->findMostViewed($limit);
    }

    /**
     * Return the post which contains the search term in their title,
     * category/tag name, or content
     *
     * @param $search string the term to be searched
     * @param $page int the number of the page
     * @param $limit int the size of the page
     * @return Paginator
     */
    public function findBySearch($search, $page, $limit)
    {
        return $this->postRepository->findBySearch($search, $page, $limit);
    }

    /**
     * Return posts given by the category name
     *
     * @param $categoryName string the name of the category
     * @param $page int current page number
     * @param $size int size of the page
     * @return Paginator
     */
    public function findByCategory($categoryName, $page, $size)
    {
        return $this->postRepository->findByCategory($categoryName, $page, $size);
    }

    /**
     * Return posts given by the tag name
     *
     * @param $tagName string the name of the tag
     * @param $page int current page number
     * @param $size int size of the page
     * @return Paginator
     */
    public function findByTag($tagName, $page, $size)
    {
        return $this->postRepository->findByTag($tagName, $page, $size);
    }

    /**
     * Return posts given by the author name
     *
     * @param $authorName string the name of the author
     * @param $page int current page number
     * @param $size int size of the page
     * @return Paginator
     */
    public function findByAuthor($authorName, $page, $size)
    {
        return $this->postRepository->findByAuthor($authorName, $page, $size);
    }

    /**
     * Save a post instance. If it is already persisted then it performs an update.
     *
     * @param Post $post
     * @return mixed
     */
    public function save(Post $post)
    {
        return $this->postRepository->save($post);
    }

    /**
     * Hard deletes a post given by its ID
     *
     * @param $id int the post ID
     * @return void
     */
    public function deleteById($id)
    {
        return $this->postRepository->deleteById($id);
    }
}
