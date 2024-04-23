<?php

namespace App\Controller;

use App\Entity\QuestionGroupLevel;
use App\Form\QuestionGroupLevelType;
use App\Repository\QuestionGroupLevelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionGroupLevelController extends AbstractController
{
    private $questionGroupLevelRepository;
    private $em;
    public function __construct(QuestionGroupLevelRepository $questionGroupLevelRepository, EntityManagerInterface $em)
    {
        $this->questionGroupLevelRepository = $questionGroupLevelRepository;
        $this->em = $em;
    }
    #[Route('/question_group', name: 'list_question_group')]
    public function questionGroupAction(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $questionGroupLevels = $this->questionGroupLevelRepository->findAll();

        return $this->render('question_group_level/index.html.twig', [
            'questionGroup' => $questionGroupLevels,
        ]);
    }

    #[Route('/create-question-group', name: 'question_group_create')]
    public function createQuestionGroupAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $questionGroup = new QuestionGroupLevel();
        $form = $this->createForm(QuestionGroupLevelType::class, $questionGroup);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $name = $form['name']->getData();
            $level = $form['level']->getData();

            $questionGroup->setName($name);
            $questionGroup->setLevel($level);

            $this->em->persist($questionGroup);
            $this->em->flush();

            return $this->redirectToRoute('list_question_group');
        }

        return $this->render('question_group_level/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete-question-group/{id}', name: 'question_group_delete')]
    public function deleteQuestionGroupAction(int $id)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $questionGroupLevelId = $this->questionGroupLevelRepository->find($id);
        $this->em->remove($questionGroupLevelId);
        $this->em->flush();

        return $this->redirectToRoute('list_question_group');
    }

    #[Route('/update-question-group/{id}', name: 'question_group_update')]
    public function updateQuestionGroupAction(Request $request, int $id)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $questionGroupLevelId = $this->questionGroupLevelRepository->find($id);
        $form = $this->createForm(QuestionGroupLevelType::class, $questionGroupLevelId);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $name = $form['name']->getData();
            $level = $form['level']->getData();

            $questionGroupLevelId->setName($name);
            $questionGroupLevelId->setLevel($level);

            $this->em->persist($questionGroupLevelId);
            $this->em->flush();

            return $this->redirectToRoute('list_question_group');
        }

        return $this->render('question_group_level/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
