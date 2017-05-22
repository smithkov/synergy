<?php

namespace lotto\UserBundle\Controller;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use lotto\UserBundle\Entity\Register;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    private function findOne($entity) {
        return $this->getDoctrine()->getRepository("lottoUserBundle:$entity")->findOneBy(array('isActive' => TRUE));
    }

    public function indexAction(Request $request) {
        $session = $request->getSession();
        if (!$session->has('usersInfo')) {
            return $this->redirect($this->generateUrl("lotto_login"));
        }
        $user = $session->get('usersInfo');
        $getAllAprovedUsers = $this->getDoctrine()->getRepository("lottoUserBundle:Play_record")->findBy(array('status' => TRUE));
        //Total bitcoin raised for current draw
      //  $curTotalBitcoin = $this->findOne("Lotto")->getPrice() * count($getAllAprovedUsers);
        //$firstWinner = 0.5 * $curTotalBitcoin;
        //$secondWinner = 0.2 * $curTotalBitcoin;
        //$jackpot = 0.1 * $curTotalBitcoin;
        //$charity = 0.0 * $curTotalBitcoin;
        $getUserLotto = $this->getDoctrine()->getRepository("lottoUserBundle:Play_record")->findBy(array('register' => $user->getId()));
        return $this->render('lottoUserBundle:Default:index.html.twig', array('user' => $user, 'lotto' => $getUserLotto));
    }

    public function homeAction() {

        return $this->render('lottoUserBundle:Default:home.html.twig');
    }

    public function logoutAction(Request $request) {

        $session = $request->getSession();
        $session->clear();
        return $this->redirect($this->generateUrl("lotto_login"));
    }

    public function sendMail($mailTo, $mailFrom, $viewName, $value, $name) {
        $message = \Swift_Message::newInstance()
                ->setSubject('Synergy Lotto Account Registration Confirmation')
                ->setFrom($mailFrom)
                ->setTo($mailTo)
                ->setBody(
                $this->renderView(
                        // app/Resources/views/Emails/registration.html.twig
                        'lottoUserBundle:Default:' . $viewName . '.html.twig', array('token' => $value, 'name' => $name)
                ), 'text/html'
        );
        $this->get('mailer')->send($message);
    }

    private function checkDataExist($field, $value) {
        return $this->getDoctrine()->getRepository("lottoUserBundle:Register")->findOneBy(array($field => $value));
    }

    private function getRole($value) {
        return $this->getDoctrine()->getRepository("lottoUserBundle:Role")->findOneBy(array('name' => $value));
    }

    public function registerAction(Request $request) {
        $register = new Register();
        $em = $this->getDoctrine()->getManager();
        $error = null;

        $hasFailedValidation = FALSE;
        $form = $this->createFormBuilder($register)
                ->add("username", TextType::class, array(
                    'constraints' => new NotBlank(),
                    'error_bubbling' => true
                ))
                ->add("password", RepeatedType::class, array(
                    'required' => true,
                    'error_bubbling' => true,
                    'invalid_message' => 'The password field must match',
                    'first_options' => array('label' => 'New password'),
                    'second_options' => array('label' => 'Confirm password'),
                    'constraints' => array(
                        new Assert\NotBlank(),
                        new Assert\Regex(array(
                            'pattern' => '/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/',
                            'message' => 'Paswword must contain a minimum 8 characters at least one lower case letter, one number and one upper case letter.'
                                )
                        ),
                        new Assert\Length(array('min' => 8))
                    ),
                    'type' => PasswordType::class
                ))
                ->add("email", EmailType::class, array(
                    'constraints' => new NotBlank(),
                    'error_bubbling' => true
                ))
                ->add("phone", TextType::class, array(
                    'constraints' => new NotBlank(),
                    'error_bubbling' => true
                ))
                ->add("wallet", TextType::class, array(
                    'constraints' => new NotBlank(),
                    'error_bubbling' => true,
                    'constraints' => array(
                        new Assert\NotBlank(),
                        new Assert\Regex(array(
                            'pattern' => '/^[13][a-km-zA-HJ-NP-Z1-9]{25,34}$/',
                            'message' => 'Enter a valid Bitcoin address.'
                                )
                        )
                    )
                ))
                ->add("fullName", TextType::class, array(
                    'constraints' => new NotBlank(),
                    'error_bubbling' => true,
                ))
                ->add('country', EntityType::class, array(
                    'class' => 'lottoUserBundle:Country',
                    'label' => 'Select user country',
                    'choice_label' => 'name'
                ))
                ->getForm();

        $form->handleRequest($request);
        if ($request->getMethod() == "POST") {
            if ($form->isValid()) {
                if ($this->checkDataExist('username', $form->get('username')->getData())) {

                    $hasFailedValidation = TRUE;
                    $error = "Username Already Exist!";
                } elseif ($this->checkDataExist('phone', $form->get('phone')->getData())) {
                    $hasFailedValidation = TRUE;
                    $error = "Phone Number Already Exist!";
                } elseif ($this->checkDataExist('email', $form->get('email')->getData())) {
                    $hasFailedValidation = TRUE;
                    $error = "Email Already Exist!";
                } elseif ($this->checkDataExist('wallet', $form->get('wallet')->getData())) {
                    $hasFailedValidation = TRUE;
                    $error = "Bitcoin Wallet Address Already Exist!";
                } else {
                    $register = $form->getData();
                    $hashedPassword = hash('sha512', $register->getPassword());

                    $register->setPassword($hashedPassword);
                    $register->setHasVerifyAccount(FALSE);
                    $register->setRole($this->getRole("user"));
                    $register->setDateOfReg(new \DateTime());
                    $token = hash('sha512', $register->getPassword() + $register->getUsername());
                    $register->setRegistrationToken($token);
                    $em->persist($register);
                    $em->flush();
                    $this->sendMail($form->get('email')->getData(), "no-reply@synergylotto.com", "mail", $token, $form->get('fullName')->getData());
                    return $this->redirect($this->generateUrl("lotto_account_registration_complete"));
                }
            }
        }

        return $this->render('lottoUserBundle:Default:register.html.twig', array('form' => $form->createView(), 'error' => $error));
    }

    public function loginAction(Request $request) {
        $error = null;
         $session = $request->getSession();
        if ($session->has('usersInfo')) {
            return $this->redirect($this->generateUrl("lotto_user_homepage"));
        }
        $register = new Register();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createFormBuilder($register)
                        ->add("username", TextType::class, array(
                            'constraints' => new NotBlank(),
                            'error_bubbling' => true
                        ))
                        ->add("password", PasswordType::class, array(
                            'constraints' => new NotBlank(),
                            'error_bubbling' => true
                        ))->getForm();

        $form->handleRequest($request);
        if ($request->getMethod() == "POST") {
            if ($form->isValid()) {
                $hashedPassword = hash('sha512', $form->get('password')->getData());
                //$query = $em->createQuery("SELECT u,r  user FROM ProjectAdminBundle:User u JOIN u.role r WHERE(u.username =:user AND u.password =:pass)");
                $query = $em->createQuery('SELECT u,r FROM lottoUserBundle:Register u JOIN u.role r WHERE u.username = :name AND u.password =:pass AND u.hasVerifyAccount =:hasVerify');
                $query->setParameters(array('name' => $form->get('username')->getData(), 'pass' => $hashedPassword, 'hasVerify' => TRUE));
                /* used get one or null result to retieve data as objects not array */

                $user = $query->getOneOrNullResult();

                if ($user) {
                    $session = $request->getSession();
                    $session->set("usersInfo", $user);
                    return $this->redirect($this->generateUrl("lotto_user_homepage"));
                } else {
                    $error = "Username or password is incorrect.";
                }
            }
        }
        return $this->render('lottoUserBundle:Default:login.html.twig', array('form' => $form->createView(), 'error' => $error));
    }

    public function profileAction(Request $request) {
        $register = new Register();
        $em = $this->getDoctrine()->getManager();
        $error = null;
        $success = null;
        $session = $request->getSession();
        if (!$session->has('usersInfo')) {
            return $this->redirect($this->generateUrl("lotto_login"));
        }
        $user = $session->get('usersInfo');

        $hasFailedValidation = FALSE;
        $getUser = $this->getDoctrine()->getRepository("lottoUserBundle:Register")->find($user->getId());
        $form = $this->createFormBuilder($getUser)
                ->add("username", TextType::class, array(
                    'constraints' => new NotBlank(),
                    'error_bubbling' => true
                ))
                ->add("email", EmailType::class, array(
                    'constraints' => new NotBlank(),
                    'error_bubbling' => true
                ))
                ->add("phone", TextType::class, array(
                    'constraints' => new NotBlank(),
                    'error_bubbling' => true
                ))
                ->add("wallet", TextType::class, array(
                    'constraints' => new NotBlank(),
                    'error_bubbling' => true,
                    'constraints' => array(
                        new Assert\NotBlank(),
                        new Assert\Regex(array(
                            'pattern' => '/^[13][a-km-zA-HJ-NP-Z1-9]{25,34}$/',
                            'message' => 'Enter a valid Bitcoin address.'
                                )
                        )
                    )
                ))
                ->add("fullName", TextType::class, array(
                    'constraints' => new NotBlank(),
                    'error_bubbling' => true,
                ))
                ->getForm();

        $form->handleRequest($request);
        if ($request->getMethod() == "POST") {
            if ($form->isValid()) {
                if ($form->get('phone')->getData() != $user->getPhone()) {
                    if ($this->checkDataExist('phone', $form->get('phone')->getData())) {
                        $hasFailedValidation = TRUE;
                        $error = "Phone Number Already Exist!";
                    }
                } elseif ($form->get('wallet')->getData() != $user->getWallet()) {
                    if ($this->checkDataExist('wallet', $form->get('wallet')->getData())) {
                        $hasFailedValidation = TRUE;
                        $error = "Bitcoin Wallet Address Already Exist!";
                    }
                } else {
                    $register = $form->getData();
                    $getUser->setWallet($register->getWallet());
                    $getUser->setPhone($register->getPhone());
                    $getUser->setFullName($register->getFullName());
                    $em->flush();
                    $success = "Updated Successfully.";
                    $session->set("usersInfo", $getUser);
                }
            }
        }

        return $this->render('lottoUserBundle:Default:profile.html.twig', array('form' => $form->createView(), 'error' => $error, 'user' => $user, 'success' => $success));
    }

    public function uploadAction(Request $request) {
        $register = new Register();
        $em = $this->getDoctrine()->getManager();
        $error = null;
        $success = null;
        $session = $request->getSession();
        if (!$session->has('usersInfo')) {
            return $this->redirect($this->generateUrl("lotto_login"));
        }
        $user = $session->get('usersInfo');
        $getUser = $this->getDoctrine()->getRepository("lottoUserBundle:Register")->find($user->getId());
        $form = $this->createFormBuilder($getUser)
                ->add("file", FileType::class, array(
                    'constraints' => new NotBlank(),
                    'error_bubbling' => true
                ))
                ->getForm();

        $form->handleRequest($request);
        if ($request->getMethod() == "POST") {
            if ($form->isValid()) {

                $register = $form->getData();
                $register->upload();
                $getUser->setPath($register->getPath());
                $em->flush();
                $session->set("usersInfo", $getUser);
            }
        }

        return $this->render('lottoUserBundle:Default:upload.html.twig', array('form' => $form->createView(), 'error' => $error, 'user' => $user, 'success' => $success));
    }

    public function accountVerificationAction(Request $request, $token) {

        $em = $this->getDoctrine()->getManager();
        $register = new Register();
        $register = $this->getDoctrine()->getRepository("lottoUserBundle:Register")->findOneBy(array('registrationToken' => $token));

        $status = null;
        if ($register) {
            if ($register->getHasVerifyAccount()) {
                $status = 0;
            } else {
                $status = 1;
                $register->setHasVerifyAccount(TRUE);
                $register->setDateOfVerify(new \DateTime());
                $register->setPhone($register->getPhone());
                $em->flush();
            }
        } else {
            $status = 2;
        }

        return $this->render('lottoUserBundle:Default:accountVerification.html.twig', array('user' => $register, 'status' => $status));
    }

    public function registerSuccessAction(Request $request) {


        return $this->render('lottoUserBundle:Default:registerSuccess.html.twig');
    }

    public function faqAction(Request $request) {


        return $this->render('lottoUserBundle:Default:faq.html.twig');
    }

}
