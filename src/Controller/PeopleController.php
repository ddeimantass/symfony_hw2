<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PeopleController extends Controller
{
    /**
     * @Route("/people", name="people")
     */
    public function index()
    {
        return $this->render('people/index.html.twig', [
            'controller_name' => 'PeopleController',
        ]);
    }

    /**
     * @Route("/validate/{element}", name="validate")
     * @Method({"POST"})
     */
    public function validate(Request $request, $element)
    {
        try {
            $input = json_decode($request->getContent(), true)['input'];
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Invalid method'], Response::HTTP_BAD_REQUEST);
        }

        $students = $this->getStudents();
        $teams = $this->getTeams();
        switch ($element) {
            case 'name':
                return new JsonResponse(['valid' => in_array(strtolower($input), $students)]);
            case 'team':
                return new JsonResponse(['valid' => in_array(strtolower($input), $teams)]);
        }

        return new JsonResponse(['error' => 'Invalid method'], Response::HTTP_BAD_REQUEST);
    }

    private function getStorage()
    {
        return /** @lang json */
        '{
          "Po pamok\u0173": {
            "mentor": "Tomas",
            "members": [
              "Elena",
              "Just\u0117",
              "Deimantas"
            ]
          },
          "Tech Guide": {
            "mentor": "Sergej",
            "members": [
              "Matas",
              "Martynas"
            ]
          },
          "Kelion\u0117s draugas": {
            "mentor": "Rokas",
            "members": [
              "Zbignev",
              "Aist\u0117"
            ]
          },
          "Wish A Gift": {
            "mentor": "Aistis",
            "members": [
              "Nerijus",
              "Olga"
            ]
          },
          "Mums pakeliui": {
            "mentor": "Paulius",
            "members": [
              "Egl\u0117",
              "Svetlana"
            ]
          },
          "Motyvacin\u0117 platforma": {
            "mentor": "Audrius",
            "members": [
              "Viktoras",
              "Airidas"
            ]
          }
        }';
    }

    private function getStudents() {
        $students = [];
        $storage = json_decode($this->getStorage(), true);
        foreach ($storage as $teamData) {
            foreach ($teamData['members'] as $student) {
                $students[] = strtolower($student);
            }
        }
        return $students;
    }
    private function getTeams() {
        $storage = json_decode($this->getStorage(), true);
        $storage = array_change_key_case($storage);
        $teams = array_keys($storage);

        return $teams;
    }
}

