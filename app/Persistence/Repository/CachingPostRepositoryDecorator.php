<?php


namespace App\Persistence\Repository;

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
