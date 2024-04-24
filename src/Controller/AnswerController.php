<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Form\AnswerType;
use App\Repository\AnswerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnswerController extends AbstractController
{
    private $answerRepository;
    private $em;
    public function __construct(AnswerRepository $answerRepository, EntityManagerInterface $em)
    {
        $this->answerRepository = $answerRepository;
        $this->em = $em;
    }
    #[Route('/answer', name: 'list_answer')]
    public function answerAction(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $allAnswer = $this->answerRepository->findAll();
        return $this->render('answer/index.html.twig', [
            'answers' => $allAnswer,
        ]);
    }

    #[Route('/create-answer', name: 'answer_create')]
    public function createAnswerAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $answer = new Answer();
        $form = $this->createForm(AnswerType::class, $answer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $question = $form['question']->getData();
            $text = $form['text']->getData();
            $isCorrect = $form['isCorrect']->getData();

            $answer->setQuestion($question);
            $answer->setText($text);
            $answer->setIsCorrect($isCorrect);

            $this->em->persist($answer);
            $this->em->flush();

            return $this->redirectToRoute('list_answer');
        }

        return $this->render('answer/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete-answer/{id}', name: 'answer_delete')]
    public function deleteAnswerAction(int $id)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $answerId = $this->answerRepository->find($id);
        $this->em->remove($answerId);
        $this->em->flush();

        return $this->redirectToRoute('list_answer');
    }

    #[Route('/edit-answer/{id}', name: 'answer_edit')]
    public function editAnswerAction(Request $request, int $id)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $idAnswer = $this->answerRepository->find($id);
        $form = $this->createForm(AnswerType::class, $idAnswer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $question = $form['question']->getData();
            $text = $form['text']->getData();
            $isCorrect = $form['isCorrect']->getData();

            $idAnswer->setQuestion($question);
            $idAnswer->setText($text);
            $idAnswer->setIsCorrect($isCorrect);

            $this->em->persist($idAnswer);
            $this->em->flush();

            return $this->redirectToRoute('list_answer');
        }

        return $this->render('answer/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/search-question-answer', name: 'search_question_answer_by_group', methods: ['GET'])]
    public function searchQuestionAnswerByGroupAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $idGroup = $request->query->get('groupe_id');
        $listAnswer = $this->answerRepository->findAnswerByGroup($idGroup);
        $listQuestion = $this->answerRepository->findQuestionByGroup($idGroup);

        return $this->render('answer/list.html.twig', [
            'allAnswer' => $listAnswer,
            'question' => $listQuestion,
        ]);
    }
}
