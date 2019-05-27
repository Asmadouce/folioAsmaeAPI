<?php
namespace App\Controller\API\V1;

use App\Entity\Fullstack;
use App\Form\FullstackType;
use App\Form\ResponseType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\Model;

class FullstackController extends Controller implements ControllerInterface{
//---------------------------------------IndexAction-----------------------------------------------------------------

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Get("/fullstacks" , name="_app_api_v1_fullstack")
     * @return Fullstack
     * @SWG\Response(
     *     response=200,
     *     description="Returns fullstacks list",
     *     @SWG\Schema(
     *          type="array",
     *          @SWG\Items(ref=@Model(type="App\Entity\Fullstack", groups={"fullstack"}))
     *      )
     * )
     * @SWG\Tag(name="Fullstack")
     */
    public function indexAction()
    {
        $fullstack = $this->get('fullstack_manager')->findAll();
        return $fullstack;
    }
//---------------------------------------GetAction-----------------------------------------------------------------

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Get("/fullstacks/{id}" , name="_app_api_v1_fullstack")
     * @return Fullstack
     * @SWG\Response(
     *     response=200,
     *     description="Returns fullstacks list",
     *     @SWG\Schema(
     *          type="array",
     *          @SWG\Items(ref=@Model(type="App\Entity\Fullstack", groups={"fullstack"}))
     *      )
     * )
     * @SWG\Tag(name="Fullstack")
     */
    public function getAction(Request $request)
    {
        $fullstackManager = $this->get('fullstack_manager');
        $fullstack = $fullstackManager->find($request->get('id'));
        if (empty($fullstack)) {
            return $this->notFound();
        }

        return $fullstack;
    }
//--------------------------------------CreateAction-----------------------------------------------------------------
    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/fullstacks" , name="_app_api_v1_fullstacks")
     * @param Request $request
     * @return \Symfony\Component\Form\FormInterface
     *
     * @SWG\Response(
     *     response=200,
     *     description="Fullstack created successfully",
     *     @SWG\Schema(
     *         type="array",
     *         @Model(type="\App\Entity\Fullstack", groups={"fullstack"})
     *     )
     * )
     * @SWG\Parameter(
     *     parameter="response_in_body",
     *     in="body",
     *     name="Fullstack to create",
     *     @SWG\Schema(
     *         @SWG\Property(
     *             property="name",
     *             type="string"
     *         ),
     *     )
     * )
     * @SWG\Tag(name="Fullstack")
     */
    public function createAction(Request $request)
    {
        $fullstackManager = $this->get('fullstack_manager');

        $fullstack = new Fullstack();

        $form = $this->createForm(FullstackType::class, $fullstack,[
            'csrf_protection' => false //Dans une API, il faut obligatoirement désactiver la protection CSRF (Cross-Site Request Forgery).
        ]);
        $form->setData($fullstack);
        $form->handleRequest($request);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $fullstackManager->setForm($form)->create();

            return $fullstack;
        } else {
            return $form;
        }
    }
//--------------------------------------EditAction-----------------------------------------------------------------
    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Put("/fullstacks/{id}" , name="_app_api_v1_fullstacks")
     * @param Request $request
     * @return \Symfony\Component\Form\FormInterface
     *
     * @SWG\Response(
     *     response=200,
     *     description="Fullstack updated successfully",
     *     @SWG\Schema(
     *         type="array",
     *         @Model(type="\App\Entity\Fullstack", groups={"fullstack"})
     *     )
     * )
     * @SWG\Parameter(
     *     parameter="response_in_body",
     *     in="body",
     *     name="Fullstack to update",
     *     @SWG\Schema(
     *         @SWG\Property(
     *             property="name",
     *             type="string"
     *         ),
     *     )
     * )
     * @SWG\Tag(name="Fullstack")
     */
    public function editAction(Request $request)
    {
        $fullstackManager = $this->get('fullstack_manager');
        $fullstack= $fullstackManager->getOne($request->get('id'));

        if (empty($fullstack)) {
            return $this->notFound();
        }

        $form = $this->createForm(FullstackType::class, $fullstack, [
            'csrf_protection' => false //Dans une API, il faut obligatoirement désactiver la protection CSRF (Cross-Site Request Forgery).
        ]);

        $form->setData($fullstack);
        $form->handleRequest($request);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $fullstackManager->setForm($form)->update();

            return $fullstack;

        } else {
            return $form;
        }
    }
//--------------------------------------RemoveAction-----------------------------------------------------------------
    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/fullstacks/{id}" , name="_app_api_v1_fullstacks")
     * @param Request $request
     * @SWG\Response(
     *     response=Response::HTTP_NO_CONTENT,
     *     description="Delete a fullstack",
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="string",
     *     description="The fullstack Id",
     *     required=true,
     * )
     * @SWG\Tag(name="Fullstack")
     * @return \FOS\RestBundle\View\View
     */
    public function removeAction(Request $request)
    {
        $fullstackManager = $this->get('fullstack_manager');
        $fullstack = $fullstackManager->getOne($request->get('id'));
        $tab = ['object' => $fullstack];

        if (empty($fullstack)) {
            return $this->NotFound();
        }
        $fullstackManager->remove($tab);
    }
    //---------------------------------------------------Notfound Message----------------------------------------------------------
    private function notFound()
    {
        return \FOS\RestBundle\View\View::create(['message' => 'Document not found'], Response::HTTP_NOT_FOUND);
    }
}