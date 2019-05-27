<?php
/**
 * Created by PhpStorm.
 * User: jeandraud
 * Date: 27/03/19
 * Time: 09:39
 */

namespace App\Controller\API\V1;

use Symfony\Component\HttpFoundation\Request;

interface ControllerInterface
{
    public function createAction(Request $request);
    public function removeAction(Request $request);
    public function editAction(Request $request);
    public function getAction(Request $request);
    public function indexAction();
}