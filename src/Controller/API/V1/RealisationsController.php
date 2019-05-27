<?php
namespace App\Controller\API\V1;

use App\Entity\Realisations;
use App\Form\RealisationsType;
use App\Form\ResponseType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\Model;

class RealisationsController extends Controller implements ControllerInterface{
//---------------------------------------IndexAction-----------------------------------------------------------------

    /**
    * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"realisations"})
    * @Rest\Get("/realisations" , name="_app_api_v1_realisations")
    * @return Realisations
    * @SWG\Response(
    *     response=200,
    *     description="Returns realisations list",
    *     @SWG\Schema(
    *          type="array",
    *          @SWG\Items(ref=@Model(type="App\Entity\Realisations", groups={"realisations"}))
    *      )
    * )
    * @SWG\Tag(name="Realisation")
    */
    public function indexAction()
    {
        $realisations = $this->get('realisations_manager')->findAll();
        return $realisations;
    }
//---------------------------------------GetAction-----------------------------------------------------------------

/**
* @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"realisations"})
* @Rest\Get("/realisations/{id}" , name="_app_api_v1_realisations")
* @return Realisations
* @SWG\Response(
*     response=200,
*     description="Realisations updated successfully",
*     @SWG\Schema(
*          type="array",
*          @SWG\Items(ref=@Model(type="App\Entity\Realisations", groups={"realisations"}))
*      )
* )
* @SWG\Tag(name="Realisation")
*/
public function getAction(Request $request)
{
$realisationsManager = $this->get('realisations_manager');
$realisations = $realisationsManager->find($request->get('id'));
if (empty($realisations)) {
return $this->notFound();
}

return $realisations;
}
//--------------------------------------CreateAction-----------------------------------------------------------------
    /**
    * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"realisations"})
    * @Rest\Post("/realisations" , name="_app_api_v1_realisations")
    * @param Request $request
    * @return \Symfony\Component\Form\FormInterface
    *
    * @SWG\Response(
    *     response=200,
    *     description="Realisation created successfully",
    *     @SWG\Schema(
    *         type="array",
    *         @Model(type="\App\Entity\Realisations", groups={"realisations"})
    *     )
    * )
    * @SWG\Parameter(
    *     parameter="response_in_body",
    *     in="body",
    *     name="Realisation to create",
    *     @SWG\Schema(
    *         @SWG\Property(
    *             property="name",
    *             type="string"
    *         ),
    *     )
    * )
    * @SWG\Tag(name="Realisation")
    */
    public function createAction(Request $request)
    {
        $realisationsManager = $this->get('realisations_manager');

        $realisations = new Realisations();

        $form = $this->createForm(RealisationsType::class, $realisations,[
        'csrf_protection' => false //Dans une API, il faut obligatoirement désactiver la protection CSRF (Cross-Site Request Forgery).
        ]);
        $form->setData($realisations);
        $form->handleRequest($request);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $realisationsManager->setForm($form)->create();

        return $realisations;
        } else {
        return $form;
        }
    }
//--------------------------------------EditAction-----------------------------------------------------------------
/**
* @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"realisations"})
* @Rest\Put("/realisations/{id}" , name="_app_api_v1_realisations")
* @param Request $request
* @return \Symfony\Component\Form\FormInterface
*
* @SWG\Response(
*     response=200,
*     description="Realisations created successfully",
*     @SWG\Schema(
*         type="array",
*         @Model(type="\App\Entity\Realisations", groups={"realisations"})
*     )
* )
* @SWG\Parameter(
*     parameter="response_in_body",
*     in="body",
*     name="Realisations to update",
*     @SWG\Schema(
*         @SWG\Property(
*             property="name",
*             type="string"
*         ),
*     )
* )
* @SWG\Tag(name="Realisation")
*/
public function editAction(Request $request)
{
    $realisationsManager = $this->get('realisations_manager');
    $realisations= $realisationsManager->getOne($request->get('id'));

    if (empty($realisations)) {
    return $this->notFound();
    }

    $form = $this->createForm(RealisationsType::class, $realisations, [
    'csrf_protection' => false //Dans une API, il faut obligatoirement désactiver la protection CSRF (Cross-Site Request Forgery).
    ]);

    $form->setData($realisations);
    $form->handleRequest($request);
    $form->submit($request->request->all());

    if ($form->isValid()) {
        $realisationsManager->setForm($form)->update();

    return $realisations;

    } else {
    return $form;
    }
}
//--------------------------------------RemoveAction-----------------------------------------------------------------
/**
* @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
* @Rest\Delete("/realisations/{id}" , name="_app_api_v1_realisations")
* @param Request $request
* @SWG\Response(
*     response=Response::HTTP_NO_CONTENT,
*     description="Delete a realisation",
* )
* @SWG\Parameter(
*     name="id",
*     in="path",
*     type="string",
*     description="The realisations Id",
*     required=true,
* )
* @SWG\Tag(name="Realisation")
* @return \FOS\RestBundle\View\View
*/
public function removeAction(Request $request)
{
    $realisationsManager = $this->get('realisations_manager');
    $realisations = $realisationsManager->getOne($request->get('id'));
    $tab = ['object' => $realisations];

    if (empty($realisations)) {
    return $this->NotFound();
    }
    $realisationsManager->remove($tab);
}
//---------------------------------------------------Notfound Message----------------------------------------------------------
    private function notFound()
    {
        return \FOS\RestBundle\View\View::create(['message' => 'Document not found'], Response::HTTP_NOT_FOUND);
    }
}