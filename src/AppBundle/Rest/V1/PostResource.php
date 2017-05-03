<?php

namespace AppBundle\Rest\V1;

use AppBundle\Entity\Post;
use BaseBundle\Controller\AbstractResource;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class PostResource
 * @package AppBundle\Rest\V1
 */
class PostResource extends AbstractResource
{
    /**
     * @throws ApiProblemException
     *
     * @return array
     * @ApiDoc(
     *  section="Api Demo",
     *  description="Update a resource.",
     *  authentication=true,
     *  parameters={
     *  },
     *  requirements={
     *  },
     * statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized to say hello",
     *         404={
     *           "Returned when the user is not found",
     *           "Returned when something else is not found"
     *         },
     *         401="Returned when the user is not authenticated",
     *         500="Returned when some internal server error"
     *   }
     * )
     * @FOSRest\Put("/post/{id}", name="_post")

     */
    public function putAction($id, Request $request)
    {
        $entityObjet = $this->unserializeClass($request->getContent());

        $this->objectFilter($entityObjet);
        $this->validate($entityObjet);

        /**
         * @var $entity Post
         */
        $entity = $this->getManager()->fetch($id);

//        $entity->setTitle($entityObjet->getTitle());
//        $entity->setContent($entityObjet->getContent());
//        $entity->setSlug($entityObjet->getSlug());

        $accessor = PropertyAccess::createPropertyAccessor();

        foreach ($entityObjet->toArray() as $key => $value) {
            if (!in_array($key, ['id', 'createdAt', 'updatedAt', 'comments', 'version'])) {
                $accessor->setValue($entity, $key, $value);
            }
        }

        $this->getManager()->merge($entity, $id);

        $post = $this->getFractalData($entity, $this->getDefaultTransformer(), 'comment');

        return $this->createApiResponse($post);
    }

    /**
     * @throws ApiProblemException
     * Create a resource.
     *
     * @return array
     * @ApiDoc(
     *  section="Api Demo",
     *  description="Create a resource",
     *  authentication=true,
     *  parameters={
     *  },
     *  requirements={
     *  },
     * statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized to say hello",
     *         404={
     *           "Returned when the user is not found",
     *           "Returned when something else is not found"
     *         },
     *         401="Returned when the user is not authenticated",
     *         500="Returned when some internal server error"
     *   }
     * )
     * @FOSRest\Post("/post", name="_post")
     */
    public function createAction(Request $request)
    {
        $entityObject = $this->unserializeClass($request);


        $this->filter($entityObject);
        $this->validate($entityObject);

        $this->getManager()->getAssociationTargetObject($entityObject);

        $post = $this->getManager()->save($entityObject);

        return $post;
    }

    /**
     * @throws ApiProblemException
     * @ApiDoc(
     *  section="Api Demo",
     *  description="Fetch a resource.",
     *  authentication=true,
     *  parameters={
     *  },
     *  requirements={
     *  },
     *  statusCodes={
     *    200="Successful"
     *  }
     * )
     * @FOSRest\Get("/post/{id}", name="_post")
     */
    public function getAction($id)
    {
        /**
         * @var $entity Post
         */
        $entity = $this->getManager()->fetch($id);
        return $entity;
    }

    /**
     * @throws ApiProblemException
     *
     * @return array
     * @ApiDoc(
     *  section="Api Demo",
     *  description="Fetch all or a subset of resources.",
     *  authentication=true,
     *  parameters={
     *  },
     *  requirements={
     *  },
     * statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized to say hello",
     *         404={
     *           "Returned when the user is not found",
     *           "Returned when something else is not found"
     *         },
     *         401="Returned when the user is not authenticated",
     *         500="Returned when some internal server error"
     *   }
     * )
     * @FOSRest\Get("/post", name="_posts")
     */
    public function cgetAction(Request $request)
    {
        $filtro['sort'] = $this->sanitizeDirectionFields($request->query->get('sort', ''));
        $qb = $this->getManager()->getRepo()->getQueryBuilder($filtro, false);

        $paginador = $this->get('api_pagination_factory');

        $collection = $paginador->createSimpleCollection($qb, $request);

        $response = $this->createApiResponse($collection);

        return $response;
    }

    /**
     * This method should return the manager.
     *
     * @abstract
     *
     * @return ObjectManager
     */
    protected function getTransformer()
    {
        return $this->get('appbundle.transformer.post');
    }


    /**
     * This method should return the manager.
     *
     * @abstract
     *
     * @return ObjectManager
     */
    public function getManager()
    {
        return $this->get('post.manager');
    }

    /**
     * This method should return the manager.
     *
     * @abstract
     *
     * @return ObjectManager
     */
    protected function getEntityClass()
    {
        return Post::class;
    }
}
