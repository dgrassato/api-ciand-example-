<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Entity\Transformer\HipermediaSerializer;
use BaseBundle\Transformer\CustomSerializer;
use Doctrine\ORM\QueryBuilder;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use JMS\Serializer\SerializationContext;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use League\Fractal;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use Pagerfanta\Adapter\MongoAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use League\Fractal\Pagination\PaginatorInterface;
use BaseBundle\Controller\FractalResponseTrait;
use Pagerfanta\Adapter\DoctrineCollectionAdapter;

/**
 * Class DemoController
 * @package AppBundle\Controller
 */
class DemoController extends FOSRestController
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


        $postTransform = $this->get('appbundle.controller.appbundle.entity.transformer.posttransformer');


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



}

