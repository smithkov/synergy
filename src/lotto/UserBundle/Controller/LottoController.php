<?php

namespace lotto\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use lotto\UserBundle\Entity\Lotto;
use lotto\UserBundle\Entity\Play_record;
use Symfony\Component\HttpFoundation\Request;

class LottoController extends Controller {

    private function findOne($entity) {
        return $this->getDoctrine()->getRepository("lottoUserBundle:$entity")->findOneBy(array('isActive' => TRUE));
    }

    public function createAction(Request $request) {

        $session = $request->getSession();

        if (!$session->has('usersInfo')) {
            return $this->redirect($this->generateUrl("lotto_login"));
        }
        $user = $session->get('usersInfo');
        $lotto = new Lotto();
        $em = $this->getDoctrine()->getManager();
        $error = null;

        $hasFailedValidation = FALSE;
        $form = $this->createFormBuilder($lotto)
                        ->add("name", TextType::class, array(
                            'constraints' => new NotBlank(),
                            'error_bubbling' => true
                        ))
                        ->add("price", TextType::class, array(
                            'constraints' => new NotBlank(),
                            'error_bubbling' => true
                        ))
                        ->add("startDate", DateTimeType::class, array(
                            'constraints' => new NotBlank(),
                            'error_bubbling' => true
                        ))
                        ->add("endDate", DateTimeType::class, array(
                            'constraints' => new NotBlank(),
                            'error_bubbling' => true
                        ))->getForm();

        $form->handleRequest($request);
        if ($request->getMethod() == "POST") {
            if ($form->isValid()) {
                $currentDate = new \DateTime();
                $lotto = $form->getData();
                if ($lotto->getStartDate() > $lotto->getEndDate()) {
                    $error = "End date should be later than start date";
                } elseif ($currentDate > $lotto->getEndDate() || $currentDate > $lotto->getStartDate()) {
                    $error = "Both Start Date and End date should be recent.";
                } else {
                    $lotto->setDateOfCreation(new \DateTime());
                    $lotto->setIsActive(TRUE);
                    $lotto->setCode(rand(1111111111, 9999999999));
                    $em->persist($lotto);
                    $em->flush();
                    return $this->redirect($this->generateUrl("lotto_list"));
                }
            }
        }

        return $this->render('lottoUserBundle:Lotto:create.html.twig', array('form' => $form->createView(), 'error' => $error, 'user' => $user));
    }

    public function listAction(Request $request) {
        $session = $request->getSession();
        if (!$session->has('usersInfo')) {
            return $this->redirect($this->generateUrl("lotto_login"));
        }
        $user = $session->get('usersInfo');
        $getLotto = $this->getDoctrine()->getRepository("lottoUserBundle:Lotto")->findAll();
        $error = null;
        return $this->render('lottoUserBundle:Lotto:list.html.twig', array('error' => $error, 'user' => $user, 'lotto' => $getLotto));
    }

    function randLetter() {
        $int = rand(0, 20);
        $a_z = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $rand_letter = $a_z[$int];
        return $rand_letter;
    }

    public function errorAction(Request $request) {
        $session = $request->getSession();
        if (!$session->has('usersInfo')) {
            return $this->redirect($this->generateUrl("lotto_login"));
        }
        $user = $session->get('usersInfo');

        return $this->render('lottoUserBundle:Lotto:error.html.twig', array('user' => $user));
    }

    public function playAction(Request $request) {
        $session = $request->getSession();
        if (!$session->has('usersInfo')) {
            return $this->redirect($this->generateUrl("lotto_login"));
        }
        $user = $session->get('usersInfo');
        $lotto = $this->findOne("Lotto");
        $status = null;
        $currentDate = new \DateTime();

        if (!$lotto) {
            $status = 0;
        } elseif ($lotto->getEndDate()->format('Y-m-d') < $currentDate->format('Y-m-d')) {
            $status = 1;
        }
        if ($status != 0) {
            $checkIfUserHasPlayed = $this->getDoctrine()->getRepository("lottoUserBundle:Play_record")->findOneBy(array('register' => $user->getId(), 'lotto' => $lotto->getId()));
            if ($checkIfUserHasPlayed) {
                return $this->redirect($this->generateUrl("lotto_error"));
            }
        }

        $account = $this->findOne("AccountInfo");
        $error = null;
        if ($request->getMethod() == "POST") {

            return $this->redirect($this->generateUrl("lotto_confirm_payment"));
        }
        return $this->render('lottoUserBundle:Lotto:play.html.twig', array('lotto' => $lotto, 'user' => $user, 'account' => $account, 'status' => $status));
    }

    public function confirmPaymentAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        if (!$session->has('usersInfo')) {
            return $this->redirect($this->generateUrl("lotto_login"));
        }
        $user = $session->get('usersInfo');
        $error = null;
        $lotto = $this->findOne("Lotto");

        $hasPlayed = null;
        $checkIfUserHasPlayed = $this->getDoctrine()->getRepository("lottoUserBundle:Play_record")->findOneBy(array('register' => $user->getId(), 'lotto' => $lotto->getId()));
        if ($checkIfUserHasPlayed) {
            return $this->redirect($this->generateUrl("lotto_error"));
        }

        $play = new Play_record();
        $form = $this->createFormBuilder(array())
                ->add("transactionId", TextType::class, array(
                    'constraints' => new NotBlank(),
                    'error_bubbling' => true
                ))
                ->getForm();
        $form->handleRequest($request);
        if ($request->getMethod() == "POST") {
            if ($form->isValid() && $form->isSubmitted()) {
                $play->setDor(new \DateTime());
                $play->setTransactionId($form->get('transactionId')->getData());
                $play->setRegister($this->getDoctrine()->getRepository("lottoUserBundle:Register")->find($user->getId()));
                $play->setReferenceNo($this->randLetter() + $this->randLetter() + rand(1111111111, 9999999999));
                $play->setLotto($this->findOne("Lotto"));
                $play->setStatus(FALSE);
                $em->persist($play);
                $em->flush();
                return $this->redirect($this->generateUrl("lotto_ack_payment"));
            }
        }
        return $this->render('lottoUserBundle:Lotto:confirmation.html.twig', array('form' => $form->createView(), 'user' => $user, 'error' => $error));
        //throw new NotFoundHttpException("Page not found");
    }

    public function acknowledgementAction(Request $request) {

        $session = $request->getSession();
        if (!$session->has('usersInfo')) {
            return $this->redirect($this->generateUrl("lotto_login"));
        }
        $user = $session->get('usersInfo');
//        $lotto = $this->findOne("Lotto");
//        $hasPlayed = null;
//        $checkIfUserHasPlayed = $this->getDoctrine()->getRepository("lottoUserBundle:Play_record")->findOneBy(array('register' => $user->getId(), 'lotto' => $lotto->getId()));
//        if ($checkIfUserHasPlayed) {
//            return $this->redirect($this->generateUrl("lotto_error"));
//        }
        return $this->render('lottoUserBundle:Lotto:acknowledgement.html.twig', array('user' => $user));
    }

}
