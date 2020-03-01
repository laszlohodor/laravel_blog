<?php


namespace App\Persistence\Repository;


use App\Persistence\Model\Post;
use Carbon\Carbon;
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
        return $this->model
            ->query()
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
        return $this->model
            ->query()
            ->paginate($size, ['*'], 'page', $page);
    }

    /**
     * Return a Post given by the slug and published date
     *
     * @param $slug string the slugified post title
     * @param $date string the date of the publish
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object
     */
    public function findBySlugAndPublishedDate($slug, $date)
    {
        return $this->model
                    ->query()
                    ->where([
                        'enabled' => true,
                        'title_clean' => $slug,
                        'date_published' => $date,
                    ])
                    ->first();
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
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function findMostViewed($limit)
    {
        return $this->model
                    ->query()
                    ->where(['enabled' => true])
                    ->orderBy('views', 'DESC')
                    ->limit($limit)
                    ->get();
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
        return $this->model
            ->query()
            ->where(function($query) use ($search) {
                $query
                    ->whereHas('tags', $this->filterForTags($search))
                    ->orWhereHas('category', $this->filterForCategories($search))
                    ->orWhere('title', 'like', '%' . $search . '%')
                    ->orWhere('article', 'like', '%' . $search . '%')
                    ->orWhere('title_clean', 'like', '%' . $search . '%');
            })
            ->where(['enabled' => true])
            ->paginate($limit, ['*'], 'page', $page);
    }

    /**
     * Return posts given by the category name
     *
     * @param $slug string the name of the category
     * @param $page int current page number
     * @param $size int size of the page
     * @return Paginator
     */
    public function findByCategory($slug, $page, $size)
    {
        return $this->model
            ->query()
            ->where(['enabled' => true])
            ->whereHas('category', function($query) use ($slug){
                return $query->where(['name_clean' => $slug]);
            })->paginate($size, ['*'], 'page', $page);
    }

    /**
     * Return posts given by the tag name
     *
     * @param $slug string the name of the tag
     * @param $page int current page number
     * @param $size int size of the page
     * @return Paginator
     */
    public function findByTag($slug, $page, $size)
    {
        return $this->model
            ->query()
            ->where(['enabled' => true])
            ->whereHas('tags', function($query) use ($slug) {
                return $query->where(['tag_clean' => $slug]);
            })->paginate($size, ['*'], 'page', $page);
    }

    /**
     * Return posts given by the author name
     *
     * @param $slug string the name of the author
     * @param $page int current page number
     * @param $size int size of the page
     * @return Paginator
     */
    public function findByAuthor($slug, $page, $size)
    {
        return $this->model
            ->query()
            ->where(['enabled' => true])
            ->whereHas('author', function($query) use ($slug){
                return $query->where(['display_name' => $slug]);
            })->paginate($size, ['*'], 'page', $page);
    }

    /**
     * Save a post instance. If it is already persisted then it performs an update.
     *
     * @param Post $post
     * @return Post
     */
    public function save(Post $post)
    {
        $post->save();
        return $post;
    }

    /**
     * Hard deletes a post given by its ID
     *
     * @param $id int the post ID
     * @return void
     */
    public function deleteById($id)
    {
        $post = $this->findById($id);
        if ($post != null) {
            $post->delete();
        }
    }

    /**
     * @param $search
     * @return \Closure
     */
    public function filterForTags($search): \Closure
    {
        return function ($query) use ($search) {
            $query->where('tag_clean', 'like', '%' . $search . '%')
                ->orwhere('tag', 'like', '%' . $search . '%');
        };
    }

    /**
     * @param $search
     * @return \Closure
     */
    public function filterForCategories($search): \Closure
    {
        return function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orwhere('name_clean', 'like', '%' . $search . '%');
        };
    }
}
