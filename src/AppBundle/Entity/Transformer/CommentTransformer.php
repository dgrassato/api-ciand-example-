<?php

namespace AppBundle\Entity\Transformer;

use AppBundle\Entity\Comment;
use BaseBundle\Transformers\Transformer;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CommentTransformer extends Transformer
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
    public function transform(Comment $comment)
    {
        $data = [
            'id' => $comment->getId(),
            'comment' => $comment->getContent(),
            'links' => [

                    'rel' => 'self',
                    'href' => $this->generateUrl('get_dtux', ['id' =>  $comment->getId()], UrlGeneratorInterface::ABSOLUTE_URL),
                    'rel' => $this->generateUrl('get_dtux', ['id' =>  $comment->getPost()->getId()], UrlGeneratorInterface::ABSOLUTE_URL),
            ],
        ];

        return $data;
    }
}
