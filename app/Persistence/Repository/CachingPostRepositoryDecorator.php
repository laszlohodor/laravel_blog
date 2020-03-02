<?php


namespace App\Persistence\Repository;


class CachingPostRepositoryDecorator extends abstractPostRepositoryDecorator
{
    private $cacheRepository;

    const ALL_PUBLIC_POSTS = 'allPublicPosts';
    const PAGE_KEY_TEMPLATE = 'page_%s:%s';

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
        $cachedValue = $taggedCache->get($key);
        if (is_null($cachedValue)) {
            $cachedValue = $this->postRepository->findAllPublic($page, $size);
            $taggedCache->put($key, $cachedValue);
        }
        return $cachedValue;
    }
}
