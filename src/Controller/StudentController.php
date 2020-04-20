<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Test\Constraint\ResponseStatusCodeSame;

class StudentController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/students")
     */
    public function getcStudentAction()
    {
        $studentRepository = $this->getDoctrine()->getRepository(Student::class);
        return $this->view($studentRepository->findAll());
    }

    /**
     * @Rest\Get("/students/{id}")
     */
    public function getStudentAction(Student $student)
    {
        return $this->view($student);
    }

    /**
     * @Rest\Post("/students")
     */
    public function newStudentAction(Request $request)
    {
        //TODO Errorr not catched when sidi_code is alredy existant
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($student);
            $em->flush();
            return $this->view($student, Response::HTTP_CREATED);
        }
        return $this->view($form->getErrors());
    }

    /**
     * @Rest\Delete("/students/{id}")
     */
    public function deleteStudentAction(Student $student)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($student);
        $em->flush();
        return $this->view($student, Response::HTTP_OK);
    }
}