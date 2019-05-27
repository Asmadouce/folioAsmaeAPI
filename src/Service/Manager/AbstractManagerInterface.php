<?php
/**
 * Created by PhpStorm.
 * UserFixtures: jonathan trinh
 * Date: 01/03/2019
 * Time: 11:52
 */

namespace App\Service\Manager;

use Symfony\Component\Form\Form;

interface AbstractManagerInterface{
    public function create(Array $options);
    public function update(Array $options);
    public function remove(Array $options);
    public function setForm(Form $form);
    public function findAll();
    public function find($id);
    public function flush($item);
}