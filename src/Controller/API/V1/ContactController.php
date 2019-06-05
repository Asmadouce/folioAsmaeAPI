<?php

namespace App\Controller\API\V1;

use App\Entity\Contact;
use App\Form\ContactType;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use phpDocumentor\Reflection\Types\String_;




class ContactController extends AbstractController
{
    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/contacts" , name="_app_api_v1_contacts")
     * @SWG\Response(
     *     response=200,
     *     description="Return contacts for",
     * )
     * @SWG\Tag(name="Contact")
     */
    public function indexAction(Request $request, \Swift_Mailer $mailer,ValidatorInterface $validator)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact, [
            'csrf_protection' => false
        ]);

        $form->setData($contact);
        $form->handleRequest($request);
        $form->submit($request->request->all());

        $errors = $validator->validate($contact);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            return new JsonResponse(array(
                "code" => 500,
                "Message" => $errorsString
            ),500);
        }

        if ($form->isValid()) {
            $infoContact = $form->getData();//on récupère toutes les données du formulaire contact

            $firstname = $infoContact->getFirstname();
            $name = $infoContact->getName();
            $email = $infoContact->getEmail();
            $commentaire = $infoContact->getCommentaire();
            $body = "Object : $firstname, Message : $name, Email : $email Commentaires  :  $commentaire";
            $mail = (new \Swift_Message('Folio'))
                ->setSubject('Folio Asmae')
                ->setFrom(array('noreply@host.com'))
                ->setTo('asmae.elgueddari@gmail.com')
                ->setBody($body);
            $mailer->send($mail);

            return new JsonResponse(array(
                "code" => 200,
                "Message" => "success"
            ),200);
        }
    }
}
