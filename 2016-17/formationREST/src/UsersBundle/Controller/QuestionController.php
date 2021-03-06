<?php

namespace UsersBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use UsersBundle\Entity\Proposal;
use UsersBundle\Entity\Qcm;
use UsersBundle\Entity\Question;
use UsersBundle\Form\ProposalType;
use UsersBundle\Form\QuestionType;


/**
 * Question controller.
 *
 */
class QuestionController  extends FOSRestController
{

    /**
     * Create a new question
     * @var Request $request
     * @return View|array
     *
     * @View()
     * @Post("/addQuestion")
     */
    public function postQuestionsAction(Request $request)
    {


        $question = new Question();
        $form = $this->createForm(new QuestionType(), $question);
        $form->handleRequest($request);


        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($question);
            $em->flush();

            return array("question" => $question);
        }

        return array(
            'form' => $form,
        );
    }


    /**Get all the questions
     * @return array
     * @View()
     * @ParamConverter("qcm", class="UserBundle:Qcm")
     * @Get("/questions/{id}")
     */
    public function getQuestionsAction(Qcm $qcm)
    {

        $question = $this->getDoctrine()->getRepository("UsersBundle:Question")
            ->findBy(
                array("qcm" => $qcm)

            );

        return array('question' => $question);
    }

    /**Get one question
     * @param Question $question
     * @return array
     * @View()
     * @ParamConverter("question", class="UserBundle:Question")
     * @Get("/interrogation/{id}")
     */
    public function getInterrogationAction(Question $question)
    {
        return array('question' => $question);
    }



    /**
     * Create a new proposal
     * @var Request $request
     * @return View|array
     *
     * @View()
     * @Post("/addProposal")
     */
    public function postProposalsAction(Request $request)
    {


        $proposal = new Proposal();
        $form = $this->createForm(new ProposalType(), $proposal);

        $form->handleRequest($request);


        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($proposal);
            $em->flush();

            return array("proposal" => $proposal);
        }

        return array(
            'form' => $form,
        );
    }



}
