<?php

namespace App\Controller;

use App\Entity\JobType;
use App\Form\JobTypeType;
use App\Repository\JobTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/job/type")
 */
class JobTypeController extends AbstractController
{
    /**
     * @Route("/", name="job_type_index", methods={"GET"})
     * @param JobTypeRepository $jobTypeRepository
     *
     * @return Response
     */
    public function index(JobTypeRepository $jobTypeRepository): Response
    {
        return $this->render('job_type/index.html.twig', [
            'job_types' => $jobTypeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="job_type_new", methods={"GET","POST"})
     * @param Request $request
     *
     * @return Response
     */
    public function new(Request $request): Response
    {
        $jobType = new JobType();
        $form = $this->createForm(JobTypeType::class, $jobType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($jobType);
            $entityManager->flush();

            return $this->redirectToRoute('job_type_index');
        }

        return $this->render('job_type/new.html.twig', [
            'job_type' => $jobType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="job_type_show", methods={"GET"})
     * @param JobType $jobType
     *
     * @return Response
     */
    public function show(JobType $jobType): Response
    {
        return $this->render('job_type/show.html.twig', [
            'job_type' => $jobType,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="job_type_edit", methods={"GET","POST"})
     * @param Request $request
     * @param JobType $jobType
     *
     * @return Response
     */
    public function edit(Request $request, JobType $jobType): Response
    {
        $form = $this->createForm(JobTypeType::class, $jobType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('job_type_index');
        }

        return $this->render('job_type/edit.html.twig', [
            'job_type' => $jobType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="job_type_delete", methods={"DELETE"})
     * @param Request $request
     * @param JobType $jobType
     *
     * @return Response
     */
    public function delete(Request $request, JobType $jobType): Response
    {
        if ($this->isCsrfTokenValid('delete'.$jobType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($jobType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('job_type_index');
    }
}
