<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Entity;

use BaseBundle\Entity\Traits\ArrayTrait;
use BaseBundle\Entity\Traits\IdTrait;
use BaseBundle\Entity\Traits\SoftDeleteTrait;
use BaseBundle\Entity\Traits\TimestampTrait;
use BaseBundle\Entity\Traits\UiidTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use DMS\Filter\Rules as Filter;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="symfony_demo_tag")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Tag
{
    use IdTrait, ArrayTrait, TimestampTrait, SoftDeleteTrait;

    /**
     * @ORM\ManyToMany(targetEntity="Post", inversedBy="tags", cascade={"persist"})
     */
    private $post;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Not null")
     * @Assert\Length(
     *     min = "5",
     *     minMessage = "post.too_short",
     *     max = "10000",
     *     maxMessage = "post.too_long"
     * )
     * @Filter\StripTags()
     * @Filter\Trim()
     * @Filter\StripNewlines()
     * @Serializer\Groups({"post", "post-read","post-write"})
     */
    protected $name;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->post = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Tag
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add post
     *
     * @param \AppBundle\Entity\Post $post
     *
     * @return Tag
     */
    public function addPost(\AppBundle\Entity\Post $post)
    {
        $this->post[] = $post;

        return $this;
    }

    /**
     * Remove post
     *
     * @param \AppBundle\Entity\Post $post
     */
    public function removePost(\AppBundle\Entity\Post $post)
    {
        $this->post->removeElement($post);
    }

    /**
     * Get post
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPost()
    {
        return $this->post;
    }
}
