<?php

namespace AppBundle\Entity\Oauth2;

use FOS\OAuthServerBundle\Entity\Client as BaseClient;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Client extends BaseClient
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

  /**
   * @ORM\Column(type="string")
   */
    protected $name;

    public function __construct()
    {
        parent::__construct();
    }

  /**
   * @return mixed
   */
  public function getName() {
    return $this->name;
  }

  /**
   * @param mixed $name
   *
   * @return Client
   */
  public function setName($name) {
    $this->name = $name;
    return $this;
  }


}
