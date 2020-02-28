<?php


namespace App\Persistence\Repository;


use App\Persistence\Model\Post;
use Illuminate\Contracts\Pagination\Paginator;

class EloquentPostRepository implements PostRepository
{
    /**
     * @var Post
     */
    private $model;

    public function __construct(Post $model) {
        $this->model = $model;
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
        return
            $this->model->query()
            ->where(['enabled' => true])
            ->paginate($size, ['*'], 'page', $page);
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
        // TODO: Implement findAll() method.
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
        // TODO: Implement findBySlugAndPublishedDate() method.
    }

    /**
     * Return a post by its ID
     *
     * @param $id int the post id
     * @return Post
     */
    public function findById($id)
    {
        return $this->model->find($id);
    }

    /**
     * Return the post viewed post in descending order
     *
     * @param $limit int the number of posts
     * @return Post[]
     */
    public function findMostViewed($limit)
    {
        // TODO: Implement findMostViewed() method.
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
        // TODO: Implement findBySearch() method.
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
        // TODO: Implement findByCategory() method.
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
        // TODO: Implement findByTag() method.
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
        // TODO: Implement findByAuthor() method.
    }

    /**
     * Save a post instance. If it is already persisted then it performs an update.
     *
     * @param Post $post
     * @return mixed
     */
    public function save(Post $post)
    {
        // TODO: Implement save() method.
    }

    /**
     * Hard deletes a post given by its ID
     *
     * @param $id int the post ID
     * @return void
     */
    public function deleteById($id)
    {
        // TODO: Implement deleteById() method.
    }
}
