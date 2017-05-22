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
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller {

    public function registeredUserAction(Request $request) {
        $session = $request->getSession();
        if (!$session->has('usersInfo')) {
            return $this->redirect($this->generateUrl("lotto_login"));
        }
        $user = $session->get('usersInfo');
        $getRegisteredUsers = $this->getDoctrine()->getRepository("lottoUserBundle:Register")->findAll();

        return $this->render('lottoUserBundle:Admin:userList.html.twig', array('user' => $user, 'users' => $getRegisteredUsers));
    }
    
    public function participantsAction(Request $request) {
        $session = $request->getSession();
        if (!$session->has('usersInfo')) {
            return $this->redirect($this->generateUrl("lotto_login"));
        }
        
        $user = $session->get('usersInfo');
        $getParticipants = $this->getDoctrine()->getRepository("lottoUserBundle:Play_record")->findAll();
        return $this->render('lottoUserBundle:Admin:participant.html.twig', array('user' => $user, 'participants' => $getParticipants));
    }

    public function toggleLottoAction(Request $request, $id) {
        $session = $request->getSession();
        if (!$session->has('usersInfo')) {
            return $this->redirect($this->generateUrl("lotto_login"));
        }
        $em = $this->getDoctrine()->getManager();
        $em->createQuery('UPDATE lottoUserBundle:Lotto l SET l.isActive = FALSE WHERE  l.isActive = TRUE')->getResult();
        $query = $em->createQuery('UPDATE lottoUserBundle:Lotto l SET l.isActive = TRUE WHERE  l.id =:id');
        $query->setParameters(array('id' => $id))->getResult();

        //$getRegisteredUsers = $this->getDoctrine()->getRepository("lottoUserBundle:Register")->findAll();

        return $this->redirect($this->generateUrl("lotto_list"));
    }
    //This action handles payment of participants, this is where the admin verifies payments
    public function togglePaymentAction(Request $request, $id) {
        $session = $request->getSession();
        $status = TRUE;
        if (!$session->has('usersInfo')) {
            return $this->redirect($this->generateUrl("lotto_login"));
        }
        $getPlayId = $this->getDoctrine()->getManager()->getRepository("lottoUserBundle:Play_record")->find($id);
        if($getPlayId->getStatus())
        {
            $status = FALSE;
        }
        $em = $this->getDoctrine()->getManager();
        //$em->createQuery('UPDATE lottoUserBundle:Lotto l SET l.isActive = FALSE WHERE  l.isActive = TRUE')->getResult();
        $query = $em->createQuery('UPDATE lottoUserBundle:Play_record p SET p.status =:status WHERE  p.id =:id');
        $query->setParameters(array('id' => $id,'status'=>$status))->getResult();

        //$getRegisteredUsers = $this->getDoctrine()->getRepository("lottoUserBundle:Register")->findAll();

        return $this->redirect($this->generateUrl("lotto_view_participants"));
    }

}
