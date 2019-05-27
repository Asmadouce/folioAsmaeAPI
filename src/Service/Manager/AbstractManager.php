<?php
/**
 * Created by PhpStorm.
 * User: jonathan trinh
 * Date: 01/03/2019
 * Time: 11:28
 */

namespace App\Service\Manager;

use Symfony\Component\Form\Form;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Translation\Translator;
use Symfony\Component\HttpFoundation\Session\Session;

abstract class AbstractManager implements AbstractManagerInterface {

    protected $em;
    protected $repository;
    protected $tokenStorage;
    protected $session;
    protected $user;
    protected $form;
    protected $translator;

    /**
     * CustomerManager constructor.
     *
     * @param EntityManager $entityManager
     * @param TokenStorage $tokenStorage
     * @param Translator $translator
     */
    public function __construct(EntityManager $entityManager, TokenStorage $tokenStorage, Translator $translator)
    {
        $this->em = $entityManager;
        $this->tokenStorage = $tokenStorage;
        $this->user = $this->tokenStorage->getToken()->getUser();
        $this->session = new Session();
        $this->translator = $translator;
    }

    /**
     * @param array $options
     * @return $object
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     */
    public function create(Array $options = []){
        if ($this->form->isSubmitted()) {
            if ($this->form->isValid()) {
                $object = $this->form->getData();
                $this->flush($object);

                return $object;
            }
        }
    }

    public function update(Array $options = []){
        if ($this->form->isSubmitted()) {
            if ($this->form->isValid()) {
                $object = $this->form->getData();
                $this->flush($object);
            }
        }
    }

    /**
     * @param array $options
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     */
    public function remove(Array $options = []){
        $this->em->remove($options['object']);
        $this->em->flush();
    }


    /**
     * @param Form $form
     * @return $this
     */
    public function setForm(Form $form)
    {
        $this->form = $form;

        return $this;
    }

    /**
     * @return $this
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @param $id
     * @return $this->repository
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }

    /**
     * @param $item
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     */
    public function flush($item)
    {
        $this->em->persist($item);
        $this->em->flush();
    }
}
