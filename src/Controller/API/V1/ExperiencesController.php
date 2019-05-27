<?php
namespace App\Controller\API\V1;

use App\Entity\Experiences;
use App\Form\ExperiencesType;
use App\Form\ResponseType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\Model;


class ExperiencesController extends Controller implements ControllerInterface{
//---------------------------------------IndexAction-----------------------------------------------------------------

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Get("/experiences" , name="_app_api_v1_experiences")
     * @return Experiences
     * @SWG\Response(
     *     response=200,
     *     description="Returns experiences list",
     *     @SWG\Schema(
     *          type="array",
     *          @SWG\Items(ref=@Model(type="App\Entity\Experiences", groups={"experiences"}))
     *      )
     * )
     * @SWG\Tag(name="Experience")
     */
    public function indexAction()
    {
        $experienceManager = $this->get('experiences_manager');
        $experiences = $experienceManager->findAll();
        return $experiences;
    }
//---------------------------------------Get Action-----------------------------------------------------------------
    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Get("/experiences/{id}" , name="_app_api_v1_experiences")
     * @return Experiences
     * @SWG\Response(
     *     response=200,
     *     description="Returns experiences",
     *     @SWG\Schema(
     *          type="array",
     *          @SWG\Items(ref=@Model(type="App\Entity\Experiences", groups={"experiences"}))
     *      )
     * )
     * @SWG\Tag(name="Experience")
     */
    public function getAction(Request $request)
    {
        $experienceManager = $this->get('experiences_manager');
        $experiences = $experienceManager->find($request->get('id'));

        if (empty($experiences)) {
            return $this->notFound();
        }

        return $experiences;
    }
//--------------------------------------------Create Action-------------------------------------------------------------
    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/experiences" , name="_app_api_v1_experiences")
     * @param Request $request
     * @return \Symfony\Component\Form\FormInterface
     *
     * @SWG\Response(
     *     response=200,
     *     description="Experience created successfully",
     *     @SWG\Schema(
     *         type="array",
     *         @Model(type="\App\Entity\Experiences", groups={"experiences"})
     *     )
     * )
     * @SWG\Parameter(
     *     parameter="response_in_body",
     *     in="body",
     *     name="Experience to create",
     *     @SWG\Schema(
     *         @SWG\Property(
     *             property="name",
     *             type="string"
     *         ),
     *     )
     * )
     * @SWG\Tag(name="Experience")
     */
    public function createAction(Request $request)
    {
        $experienceManager = $this->get('experiences_manager');

        $experiences = new Experiences();

        $form = $this->createForm(ExperiencesType::class, $experiences,[
            'csrf_protection' => false //Dans une API, il faut obligatoirement désactiver la protection CSRF (Cross-Site Request Forgery).
        ]);
        $form->setData($experiences);
        $form->handleRequest($request);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $experienceManager->setForm($form)->create();

            return $experiences;
        } else {
            return $form;
        }
    }

//--------------------------------------------Edit Action-------------------------------------------------------------
    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Put("/experiences/{id}" , name="_app_api_v1_experiences")
     * @param Request $request
     * @return \Symfony\Component\Form\FormInterface
     *
     * @SWG\Response(
     *     response=200,
     *     description="Experiences updated successfully",
     *     @SWG\Schema(
     *         type="array",
     *         @Model(type="\App\Entity\Experiences", groups={"experiences"})
     *     )
     * )
     * @SWG\Parameter(
     *     parameter="response_in_body",
     *     in="body",
     *     name="Experiences to create",
     *     @SWG\Schema(
     *         @SWG\Property(
     *             property="name",
     *             type="string"
     *         ),
     *     )
     * )
     * @SWG\Tag(name="Experience")
     */
    public function editAction(Request $request)
    {
        $experienceManager = $this->get('experiences_manager');
        $experiences= $experienceManager->getOne($request->get('id'));

        if (empty($experiences)) {
            return $this->notFound();
        }

        $form = $this->createForm(ExperiencesType::class, $experiences, [
            'csrf_protection' => false //Dans une API, il faut obligatoirement désactiver la protection CSRF (Cross-Site Request Forgery).
        ]);
        //dd($experiences);
        $form->setData($experiences);
        $form->handleRequest($request);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $experienceManager->setForm($form)->update();

            return $experiences;

        } else {
            return $form;
        }
    }
//--------------------------------------------Remove Action-------------------------------------------------------------
    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/experiences/{id}")
     * @param Request $request
     * @SWG\Response(
     *     response=Response::HTTP_NO_CONTENT,
     *     description="Delete an experience",
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="string",
     *     description="The experience Id",
     *     required=true,
     * )
     * @SWG\Tag(name="Experience")
     * @return \FOS\RestBundle\View\View
     */
    public function removeAction(Request $request)
    {
        $experienceManager = $this->get('experiences_manager');

        $experiences = $experienceManager->getOne($request->get('id'));
        $tab = ['object' => $experiences];

        if (empty($experiences)) {
            return $this->NotFound();
        }
        $experienceManager->remove($tab);
    }




}