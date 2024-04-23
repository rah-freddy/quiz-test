<?php

namespace App\Controller;

use App\Entity\Questions;
use App\Form\QuestionsType;
use App\Repository\QuestionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionsController extends AbstractController
{
    private $questionsRepository;
    private $em;
    public function __construct(QuestionsRepository $questionsRepository, EntityManagerInterface $em)
    {
        $this->questionsRepository = $questionsRepository;
        $this->em = $em;
    }
    #[Route('/questions', name: 'list_questions')]
    public function questionAction(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $allQuestions = $this->questionsRepository->findAll();

        return $this->render('questions/index.html.twig', [
            'questions' => $allQuestions,
        ]);
    }

    #[Route('/create-question', name: 'question_create')]
    public function createQuestionAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $question = new Questions();
        $form = $this->createForm(QuestionsType::class, $question);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $questionGroup = $form['questionGroupLevel']->getData();
            $text = $form['text']->getData();

            $question->setQuestionGroupLevel($questionGroup);
            $question->setText($text);

            $this->em->persist($question);
            $this->em->flush();

            return $this->redirectToRoute('list_questions');
        }

        return $this->render('questions/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete-question/{id}', name: 'question_delete')]
    public function deleteQuestionAction(int $id)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $questionId = $this->questionsRepository->find($id);
        $this->em->remove($questionId);
        $this->em->flush();

        return $this->redirectToRoute('list_questions');
    }

    #[Route('/update-question/{id}', name: 'question_update')]
    public function updateQuestionAction(Request $request, int $id)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $questionId = $this->questionsRepository->find($id);
        $form = $this->createForm(QuestionsType::class, $questionId);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $questionGroup = $form['questionGroupLevel']->getData();
            $text = $form['text']->getData();

            $questionId->setQuestionGroupLevel($questionGroup);
            $questionId->setText($text);

            $this->em->persist($questionId);
            $this->em->flush();

            return $this->redirectToRoute('list_questions');
        }

        return $this->render('questions/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
