<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class DemoController extends FOSRestController
{

  /**
   * @throws
   *
   * @return array
   * @ApiDoc(
   *  section="Api DEMO",
   *  description="Fetch all or a subset of resources.",
   *  authentication=true,
   *  parameters={
   *  },
   *  requirements={
   *  }
   * )
   * @FOSRest\Get("/dtux", name="_dtux")
   */
    public function cgetAction()
    {
//      if ($this->get('security.token_storage')->getToken()->getUser()->hasRole('ROLE_USER') === FALSE) {
//        throw new AccessDeniedException();
//      }

      $time = $this->getParameter('api_base.entity_user_namespace');
      return $this->getUser();
    }

}
