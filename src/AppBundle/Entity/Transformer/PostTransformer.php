<?php

namespace AppBundle\Entity\Transformer;

use AppBundle\Entity\Post;
use BaseBundle\Transformers\Transformer;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PostTransformer extends Transformer
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'comment',
        'test'
    ];

    /**
     * @var array
     */
    protected $defaultIncludes = [
    ];

    public $currentScope = "root";
    /**
     * @param Post $post
     *
     * @return array
     */
    public function transform(Post $post)
    {
        $data = [
            'id' => $post->getId(),
            'title' => $post->getTitle(),
            'content' => $post->getContent(),
            'slug' => $post->getSlug(),
            'links' => [
                    'rel' => 'self',
                    'href' => $this->generateUrl('get_dtux', ['id' =>  $post->getId()], UrlGeneratorInterface::ABSOLUTE_URL)
            ],
        ];


        return $data;
    }

    private $commentTransformer;
    private $testTransformer;

    /**
     * Include Author.
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeComment(Post $post)
    {

        if ($post->getComments()->count() >  0) {

            return $this->collection($post->getComments(), $this->commentTransformer, 'comentando');
        }

    }


    /**
     * Include Author.
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeTest($test)
    {

        return $this->item($test, $this->testTransformer, 'testando');

    }


    public function setCommentTransformer(CommentTransformer $transformer)
    {
        $this->commentTransformer = $transformer;
    }

    public function setTestTransformer(TestTransformer $transformer)
    {
        $this->testTransformer = $transformer;
    }
}
