<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
    public function newStudentAction(Request $request, ValidatorInterface $validator)
    {
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $form->submit(json_decode($request->getContent(), true));

        $errors = $validator->validate($student);
        if (count($errors) > 0) {
            return $this->view($errors, Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($student);
        $em->flush();
        return $this->view($student, Response::HTTP_CREATED);
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