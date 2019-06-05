<?php
namespace App\Controller\API\V1;

use App\Entity\Competence;
use App\Form\CompetencesType;
use App\Form\ResponseType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\Model;

class CompetenceController extends Controller implements ControllerInterface{
//---------------------------------------IndexAction-----------------------------------------------------------------

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Get("/competences" , name="_app_api_v1_competences")
     * @return Competence
     * @SWG\Response(
     *     response=200,
     *     description="Returns competences list",
     *     @SWG\Schema(
     *          type="array",
     *          @SWG\Items(ref=@Model(type="App\Entity\Competence"))
     *      )
     * )
     * @SWG\Tag(name="Competence")
     */
    public function indexAction()
    {
        $responses = $this->get('competence_manager')->findAll();
        return $responses;
    }
//--------------------------------------------Get Action-------------------------------------------------------------
    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Get("/competences/{id}" , name="_app_api_v1_competences")
     * @return Competence
     * @SWG\Response(
     *     response=200,
     *     description="Return competence",
     *     @SWG\Schema(
     *          type="array",
     *          @SWG\Items(ref=@Model(type="App\Entity\Competence", groups={"competence"}))
     *      )
     * )
     * @SWG\Tag(name="Competence")
     */
    public function getAction(Request $request)
    {
        $competenceManager = $this->get('competence_manager');
        $competence = $competenceManager->find($request->get('id'));
        if (empty($competence)) {
            return $this->notFound();
        }

        return $competence;
    }
//--------------------------------------------Create Action-------------------------------------------------------------
    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/competences" , name="_app_api_v1_competences")
     * @param Request $request
     * @return \Symfony\Component\Form\FormInterface
     *
     * @SWG\Response(
     *     response=200,
     *     description="Competence created successfully",
     *     @SWG\Schema(
     *         type="array",
     *         @Model(type="\App\Entity\Competence", groups={"competence"})
     *     )
     * )
     * @SWG\Parameter(
     *     parameter="response_in_body",
     *     in="body",
     *     name="Competence to create",
     *     @SWG\Schema(
     *         @SWG\Property(
     *             property="name",
     *             type="string"
     *         ),
     *     )
     * )
     * @SWG\Tag(name="Competence")
     */
    public function createAction(Request $request)
    {
        $competenceManager = $this->get('competence_manager');

        $competence = new Competence();

        $form = $this->createForm(CompetencesType::class, $competence,[
            'csrf_protection' => false //Dans une API, il faut obligatoirement désactiver la protection CSRF (Cross-Site Request Forgery).
        ]);
        $form->setData($competence);
        $form->handleRequest($request);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $competenceManager->setForm($form)->create();

            return $competence;
        } else {
            return $form;
        }
    }
//--------------------------------------------Edit Action-------------------------------------------------------------
    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Put("/competences/{id}" , name="_app_api_v1_competences")
     * @param Request $request
     * @return \Symfony\Component\Form\FormInterface
     *
     * @SWG\Response(
     *     response=200,
     *     description="Competence updated successfully",
     *     @SWG\Schema(
     *         type="array",
     *         @Model(type="\App\Entity\Competence", groups={"competence"})
     *     )
     * )
     * @SWG\Parameter(
     *     parameter="response_in_body",
     *     in="body",
     *     name="Competence to create",
     *     @SWG\Schema(
     *         @SWG\Property(
     *             property="name",
     *             type="string"
     *         ),
     *     )
     * )
     * @SWG\Tag(name="Competence")
     */
    public function editAction(Request $request)
    {
        $competenceManager = $this->get('competence_manager');
        $competence= $competenceManager->getOne($request->get('id'));

        if (empty($competence)) {
            return $this->notFound();
        }

        $form = $this->createForm(CompetencesType::class, $competence, [
            'csrf_protection' => false //Dans une API, il faut obligatoirement désactiver la protection CSRF (Cross-Site Request Forgery).
        ]);

        $form->setData($competence);
        $form->handleRequest($request);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $competenceManager->setForm($form)->update();

            return $competence;

        } else {
            return $form;
        }
    }
//--------------------------------------------Remove Action-------------------------------------------------------------
    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/competences/{id}" , name="_app_api_v1_competences")
     * @param Request $request
     * @SWG\Response(
     *     response=Response::HTTP_NO_CONTENT,
     *     description="Delete a competence",
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="string",
     *     description="The competence Id",
     *     required=true,
     * )
     * @SWG\Tag(name="Competence")
     * @return \FOS\RestBundle\View\View
     */
    public function removeAction(Request $request)
    {
        $competenceManager = $this->get('competence_manager');
        $competence = $competenceManager->getOne($request->get('id'));
        $tab = ['object' => $competence];

        if (empty($competence)) {
            return $this->NotFound();
        }
        $competenceManager->remove($tab);
    }

    //---------------------------------------------------Notfound Message----------------------------------------------------------
    private function notFound()
    {
        return \FOS\RestBundle\View\View::create(['message' => 'Document not found'], Response::HTTP_NOT_FOUND);
    }

}