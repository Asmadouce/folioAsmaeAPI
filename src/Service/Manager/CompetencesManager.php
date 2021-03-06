<?php

namespace App\Service\Manager;

use App\Entity\Competence;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CompetencesManager extends AbstractManager implements ContainerAwareInterface
{
    private $container;

    /**
     * CompetencesManager constructor.
     *
     * @param EntityManager                $entityManager
     * @param Translator                   $translator
     */
    public function __construct(EntityManager $entityManager, Translator $translator)
    {
        $this->em = $entityManager;
        $this->repository = $this->em->getRepository(Competence::class);
        $this->translator = $translator;
    }

    /**
     * @param null|ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param $id
     * @return object|null
     */
    public function getOne($id)
    {
        return $this->repository->find($id);
    }

    /**
     * @return mixed
     */
    public function create(Array $options = [])
    {
        parent::create($options);
    }

    public function update(Array $options = []){

        if ($this->form->isValid()) {

            /** @var Competence $response */
            $response = $this->form->getData();

            $this->flush($response);

            return $response;
        }
    }

    public function remove(Array $options = [])
    {
        parent::remove($options);
    }
}
