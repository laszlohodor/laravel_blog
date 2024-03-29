<?php


namespace App\Persistence\Repository;

use App\Persistence\Model\Post;
use Illuminate\Cache\Repository;

class CachingPostRepositoryDecorator extends abstractPostRepositoryDecorator
{
    private $cacheRepository;

    const ALL_PUBLIC_POSTS = 'allPublicPosts';
    const PAGE_KEY_TEMPLATE = 'page_%s:%s';
    const DEFAULT_CACHE_TTL = 60;
    const MOST_VIEWED = 'mostViewed';
    const CATEGORY = 'category';
    const TAG = 'tag';
    const AUTHOR = 'author';
    const INDIVIDUAL_POST = 'individualPost';

    public function __construct($postRepository, $cacheRepository)
    {
        parent::__construct($postRepository);
        $this->cacheRepository = $cacheRepository;
    }

    public function findAllPublic($page, $size)
    {
        $key = sprintf(self::PAGE_KEY_TEMPLATE, $page, $size);
        /**
         * TaggedCache $taggedCache
         */
        $taggedCache = $this->cacheRepository->tags(self::ALL_PUBLIC_POSTS);
        return $this->cacheFuctionResult($taggedCache, $key,self::DEFAULT_CACHE_TTL, function()
            use ($page, $size) {
                return $this->postRepository->findAllPublic($page, $size);
            });
    }

    public function findMostViewed($limit)
    {
        $taggedCache = $this->cacheRepository->tags(self::MOST_VIEWED);
        $key = sprintf('post:%s', $limit);
        return $this->cacheFuctionResult($taggedCache, $key,self::DEFAULT_CACHE_TTL, function()
            use ($limit) {
                return $this->postRepository->findMostViewed($limit);
            });
    }

    public function findByCategory($slug, $page, $size)
    {
        $taggedCache = $this->cacheRepository->tags(self::CATEGORY);
        $key = sprintf('%s:%s:%s', $slug, $page, $size);
        return $this->cacheFuctionResult($taggedCache, $key,self::DEFAULT_CACHE_TTL, function()
            use ($slug, $page, $size) {
              return $this->postRepository->findByCategory($slug, $page, $size);
        });
    }

    public function findByTag($slug, $page, $size)
    {
        $taggedCache = $this->cacheRepository->tags(self::TAG);
        $key = sprintf('%s:%s:%s', $slug, $page, $size);
        return $this->cacheFuctionResult($taggedCache, $key,self::DEFAULT_CACHE_TTL, function()
            use ($slug, $page, $size) {
                return $this->postRepository->findByTag($slug, $page, $size);
            });
    }

    public function findByAuthor($slug, $page, $size)
    {
        $taggedCache = $this->cacheRepository->tags(self::AUTHOR);
        $key = sprintf('%s:%s:%s', $slug, $page, $size);
        return $this->cacheFuctionResult($taggedCache, $key,self::DEFAULT_CACHE_TTL, function()
            use ($slug, $page, $size) {
                return $this->postRepository->findByAuthor($slug, $page, $size);
            });
    }

    public function findBySlugAndPublishedDate($slug, $date)
    {
        $taggedCache = $this->cacheRepository->tags(self::INDIVIDUAL_POST);
        $key = sprintf('%s:%s', $slug, $date);
        return $this->cacheFuctionResult($taggedCache, $key,self::DEFAULT_CACHE_TTL, function()
            use ($slug, $date) {
                return $this->postRepository->findBySlugAndPublishedDate($slug, $date);
            });
    }

    public function deleteById($id)
    {
        $this->postRepository->deleteById($id);
        $this->cacheRepository->tags([
            'category',
            'mostViewed',
            'tag',
            'author',
            'allPublicPosts',
            'individualPost'
        ])->flush();
    }

    public function save(Post $post)
    {
        $this->postRepository->save($post);
        $this->cacheRepository->tags([
            'category',
            'mostViewed',
            'tag',
            'author',
            'allPublicPosts',
            'individualPost'
        ])->flush();
    }

    private function cacheFuctionResult(Repository $storage, $cacheKey, $ttl, callable $callable)
    {
        $cacheValue = $storage->get($cacheKey);
        if (is_null($cacheValue)) {
            $cacheValue = $callable();
            $storage->put($cacheKey, $cacheValue, $ttl);
        }
        return $cacheValue;
    }
}
