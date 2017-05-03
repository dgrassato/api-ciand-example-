<?php

namespace AppBundle\Rest\V1;

use AppBundle\Entity\Post;
use BaseBundle\Controller\AbstractResource;
use BaseBundle\Controller\FractalResponseTrait;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DemoController
 * @package AppBundle\Controller
 */
class DemoResource extends AbstractResource
{

    use FractalResponseTrait;

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
   * @FOSRest\Get("/dtux", name="_dtuxs")
   */
    public function cgetAction(Request $request)
    {
      if ($this->get('security.token_storage')->getToken()->getUser()->hasRole('ROLE_USER') === FALSE) {
        throw new AccessDeniedException();
      }

        $time = $this->getParameter('api_base.entity_user_namespace');
        $post = $this->getDoctrine()->getRepository(Post::class)->fetchOneById(1);

        $posts = $this->getDoctrine()->getRepository(Post::class)->findAll();

        $postsQb = $this->getDoctrine()->getRepository(Post::class)->paginate($request,false);


        //$postTransform = $this->get('appbundle.controller.appbundle.entity.transformer.post');
        $postTransform = $this->getDefaultTransformer();

       $comment = $this->response($post, $postTransform, ['comment','test']);


        return $comment;

        $paginate = $this->get('api_base.pagination');

        $post_paginate = $paginate->getFractalPaginator($postsQb, 'get_dtuxs', $request);

        $post_blas = $this->response($post_paginate, $postTransform, ['test','comment'],'data', ['blah' => 'tesssssttttteeeee','blehh' => 'Uoll']);

        return $post_blas;
    }


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
     * @FOSRest\Get("/dtux/{id}", name="_dtux")
     */
    public function getAction($id)
    {
//      if ($this->get('security.token_storage')->getToken()->getUser()->hasRole('ROLE_USER') === FALSE) {
//        throw new AccessDeniedException();
//      }

        $time = $this->getParameter('api_base.entity_user_namespace');
        $user = $this->getUser();


        return $user;
    }


    /**
     * This method should return default manager.
     *
     *
     * @return ObjectManager
     */
    protected function getManager() {
        // TODO: Implement getManager() method.
    }

    /**
     * This method should return the entity.
     *
     *
     * @return getEntiyClass
     */
    protected function getEntityClass()
    {

        return Post::class;
    }

}

