<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

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
      $time = $this->getParameter('api_base.entity_user_namespace');
      return $this->getUser();
    }

}
