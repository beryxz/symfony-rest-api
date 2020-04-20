<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Form\ClassroomType;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ClassroomController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/classrooms")
     */
    public function getcClassroomAction()
    {
        $repository = $this->getDoctrine()->getRepository(Classroom::class);
        $classrooms = $repository->findall();
        return $this->view($classrooms);
    }

    /**
     * @Rest\Get("/classrooms/{id}")
     */
    public function getClassroomAction(Classroom $classroom)
    {
        return $this->view($classroom);
    }

    /**
     * @Rest\Post("/classrooms")
     */
    public function newClassroomAction(Request $request)
    {
        $classroom = new Classroom();
        $form = $this->createForm(ClassroomType::class, $classroom);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($classroom);
            $em->flush();
            return $this->view($classroom, Response::HTTP_CREATED);
        }
        return $this->view($form->getErrors());
    }

    /**
     * @Rest\Delete("/classrooms/{id}")
     */
    public function deleteClassroomAction(Classroom $classroom) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($classroom);
        $em->flush();
        return $this->view($classroom, Response::HTTP_OK);
    }
}