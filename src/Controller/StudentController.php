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
    public function cgetAction()
    {
        $studentRepository = $this->getDoctrine()->getRepository(Student::class);
        return $this->view($studentRepository->findAll());
    }

    /**
     * @Rest\Get("/students/{id}")
     */
    public function getAction(Student $student)
    {
        return $this->view($student);
    }

    /**
     * @Rest\Post("/students")
     */
    public function postAction(Request $request, ValidatorInterface $validator)
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
    public function deleteAction(Student $student)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($student);
        $em->flush();
        return $this->view($student, Response::HTTP_OK);
    }

    /**
     * @Rest\Patch("/students/{id}")
     */
    public function patchAction(Student $student, Request $request, ValidatorInterface $validator) {
        $data = json_decode($request->getContent(), true);
        if (isset($data['name'])) {
            $student->setName($data['name']);
        }
        if (isset($data['surname'])) {
            $student->setSurname($data['surname']);
        }
        if (isset($data['sidi_code'])) {
            $student->setSidiCode($data['sidi_code']);
        }
        if (isset($data['tax_code'])) {
            $student->setTaxCode($data['tax_code']);
        }

        $errors = $validator->validate($student);
        if (count($errors) > 0) {
            return $this->view($errors, Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $em->flush();
        return $this->view($student, Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/students/{id}")
     */
    public function putAction(Student $student, Request $request, ValidatorInterface $validator) {
        $data = json_decode($request->getContent(), true);
        $student->setName(isset($data['name']) ? $data['name'] : null);
        $student->setSurname(isset($data['surname']) ? $data['surname'] : null);
        if (isset($data['sidi_code'])) {
            $student->setSidiCode($data['sidi_code']);
        }
        $student->setTaxCode(isset($data['tax_code']) ? $data['tax_code'] : null);

        $errors = $validator->validate($student);
        if (count($errors) > 0) {
            return $this->view($errors, Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $em->flush();
        return $this->view($student, Response::HTTP_OK);
    }
}