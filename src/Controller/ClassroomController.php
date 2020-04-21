<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Form\ClassroomType;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ClassroomController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/classrooms")
     */
    public function cgetAction()
    {
        $repository = $this->getDoctrine()->getRepository(Classroom::class);
        $classrooms = $repository->findall();
        return $this->view($classrooms);
    }

    /**
     * @Rest\Get("/classrooms/{id}")
     */
    public function getAction(Classroom $classroom)
    {
        return $this->view($classroom);
    }

    /**
     * @Rest\Post("/classrooms")
     */
    public function postAction(Request $request, ValidatorInterface $validator)
    {
        $classroom = new Classroom();
        $form = $this->createForm(ClassroomType::class, $classroom);
        $form->submit(json_decode($request->getContent(), true));

        $errors = $validator->validate($classroom);
        if (count($errors) > 0) {
            return $this->view($errors, Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($classroom);
        $em->flush();
        return $this->view($classroom, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Delete("/classrooms/{id}")
     */
    public function deleteAction(Classroom $classroom) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($classroom);
        $em->flush();
        return $this->view($classroom, Response::HTTP_OK);
    }

    /**
     * @Rest\Patch("/classrooms/{id}")
     */
    public function patchAction(Classroom $classroom, Request $request, ValidatorInterface $validator) {
        $data = json_decode($request->getContent(), true);
        if (isset($data['year'])) {
            $classroom->setYear($data['year']);
        }
        if (isset($data['section'])) {
            $classroom->setSection($data['section']);
        }

        $errors = $validator->validate($classroom);
        if (count($errors) > 0) {
            return $this->view($errors, Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $em->flush();
        return $this->view($classroom, Response::HTTP_OK);
    }
}