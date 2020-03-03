<?php

namespace App\Persistence\Repository;

use App\Persistence\Model\Post;
use Illuminate\Contracts\Pagination\Paginator;

/**
 * Repository for accessing Post entities
 * @package App\Persistence\Repository
 */
interface PostRepository
{
    /**
     * Return all public post paginated
     *
     * @param $page int page number
     * @param $size int the size of the page
     * @return Paginator
     */
    public function findAllPublic($page, $size);

    /**
     * Return all posts using a paginator
     *
     * @param $page int page a paginator
     * @param $size int the size of the page
     * @return Paginator
     */
    public function findAll($page, $size);

    /**
     * Return a Post given by the slug and published date
     *
     * @param $slug string the slugified post title
     * @param $date string the date of the publish
     * @return Post
     */
    public function findBySlugAndPublishedDate($slug, $date);

    /**
     * Return a post by its ID
     *
     * @param $id int the post id
     * @return Post
     */
    public function findById($id);

    /**
     * Return the post viewed post in descending order
     *
     * @param $limit int the number of posts
     * @return Post[]
     */
    public function findMostViewed($limit);

    /**
     * Return the post which contains the search term in their title,
     * category/tag name, or content
     *
     * @param $search string the term to be searched
     * @param $page int the number of the page
     * @param $limit int the size of the page
     * @return Paginator
     */
    public function findBySearch($search, $page, $limit);

    /**
     * Return posts given by the category name
     *
     * @param $slug string the name of the category
     * @param $page int current page number
     * @param $size int size of the page
     * @return Paginator
     */
    public function findByCategory($slug, $page, $size);

    /**
     * Return posts given by the tag name
     *
     * @param $slug string the name of the tag
     * @param $page int current page number
     * @param $size int size of the page
     * @return Paginator
     */
    public function findByTag($slug, $page, $size);

    /**
     * Return posts given by the author name
     *
     * @param $slug string the name of the author
     * @param $page int current page number
     * @param $size int size of the page
     * @return Paginator
     */
    public function findByAuthor($slug, $page, $size);

    /**
     * Save a post instance. If it is already persisted then it performs an update.
     *
     * @param Post $post
     * @return mixed
     */
    public function save(Post $post);

    /**
     * Hard deletes a post given by its ID
     *
     * @param $id int the post ID
     * @return void
     */
    public function deleteById($id);
}
