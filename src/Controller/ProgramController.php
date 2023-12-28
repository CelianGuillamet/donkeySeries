<?php

namespace App\Controller;

use App\Entity\Program;
use App\Repository\ProgramRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProgramController extends AbstractController
{
    #[Route('/program', name: 'program_index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();
        return $this->render(
            'program/index.html.twig',
            ['programs' => $programs]
        );
    }

    #[Route("/show/{id<^[0-9]+$>}", name: 'program_show', methods: ['GET'])]
    public function show(int $id, EntityManagerInterface $em): Response
    {
        $program = $em->getRepository(Program::class);
        $program = $program->findOneBy(['id' => $id]);

        if (!$program) {
            throw $this->createNotFoundException(
                'Aucun programme trouvé avec l\'id : ' . $id
            );
        }

        return $this->render('program/show.html.twig', [
            'program' => $program,
        ]);
    }
}
