<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Post;
use BaseBundle\Manager\AbstractManager;
use Doctrine\Common\Persistence\ObjectManager;

class PostManager extends AbstractManager
{
    public function __construct(ObjectManager $om)
    {
        parent::__construct($om, Post::class);
    }

    public function main()
    {
        $this->getLogger()->info('ola');
        $this->getLogger()->debug('ola 2');
        return [1, 2, 3 ,4 ,5 ,6];
    }
}
