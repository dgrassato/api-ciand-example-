<?php

namespace AppBundle\Entity\Transformer;

use AppBundle\Entity\Comment;
use BaseBundle\Transformers\Transformer;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class TestTransformer extends Transformer
{
    /**
     * @var array
     */
    protected $availableIncludes = [
    ];

    /**
     * @var array
     */
    protected $defaultIncludes = [
    ];

    /**
     * @param Comment $comment
     *
     * @return array
     */
    public function transform($comment)
    {
        $data = [
            'id' => 50,
            'content' => 'Testandooooo',

        ];

        return $data;
    }
}
