<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use DMS\Filter\Rules as Filter;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;
use BaseBundle\Entity\Traits\ArrayTrait;
use BaseBundle\Entity\Traits\IdTrait;
use BaseBundle\Entity\Traits\SoftDeleteTrait;
use BaseBundle\Entity\Traits\TimestampTrait;
use BaseBundle\Entity\Traits\UiidTrait;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\PostRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="symfony_demo_post")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Post
{
    use IdTrait, TimestampTrait, SoftDeleteTrait;


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
    protected $title;

    /**
     * @Gedmo\Slug(fields={"slug"}, updatable=true, separator="_")
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
    private $slug;

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
     * @Serializer\Groups({"post", "post-write"})
     */
    protected $content;

    /**
     * @ORM\OneToMany(
     *      targetEntity="AppBundle\Entity\Comment",
     *      mappedBy="post",
     *      orphanRemoval=true,
     *      cascade={"persist"}
     * )
     * @ORM\OrderBy({"createdAt" = "DESC"})
     * @Serializer\Groups({"post", "post-read"})
     */
    protected $comments;

    /**
     * @ORM\ManyToMany(
     *      targetEntity="AppBundle\Entity\Tag",
     *      mappedBy="post",
     *      orphanRemoval=true,
     *      cascade={"persist"}
     * )
     * @Serializer\Groups({"post", "post-read"})
     * @Serializer\Type("ArrayCollection<AppBundle\Entity\Tag>")
     */
    protected $tags;

    public function __construct() {

        $this->comments = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Post
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Post
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Add comment
     *
     * @param \AppBundle\Entity\Comment $comment
     *
     * @return Post
     */
    public function addComment(\AppBundle\Entity\Comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Add comment
     *
     * @param \AppBundle\Entity\Comment $comment
     *
     * @return Post
     */
    public function addComments($comments)
    {
        foreach ($comments as $comment){

            $this->addComment($comment);
        }

        return $this;
    }

    /**
     * Add comment
     *
     * @param \AppBundle\Entity\Comment $comments
     *
     * @return Post
     */
    public function setComments($comments = null)
    {
        $this->comments[] = $comments;

        return $this;
    }
    /**
     * Remove comment
     *
     * @param \AppBundle\Entity\Comment $comment
     */
    public function removeComment(\AppBundle\Entity\Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Add tag
     *
     * @param \AppBundle\Entity\Tag $tag
     *
     * @return Post
     */
    public function addTag(\AppBundle\Entity\Tag $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Add comment
     *
     * @param (\AppBundle\Entity\Tag $tags
     *
     * @return Post
     */
    public function addTags($tags)
    {
        foreach ($tags as $tag){

            $this->addTag($tag);
        }

        return $this;
    }
    /**
     * Remove tag
     *
     * @param \AppBundle\Entity\Tag $tag
     */
    public function removeTag(\AppBundle\Entity\Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function setTags($tags = null)
    {
        $this->tags = $tags;

        return $this;
    }
}
