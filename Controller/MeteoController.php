<?php

namespace MeteoBundle\Controller;

use MeteoBundle\Entity\MeteoVille;
use MeteoBundle\Entity\MeteoInput;
use MeteoBundle\Entity\MeteoGPS;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;

class MeteoController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFormBuilder()
            ->add('ville', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Rechercher'))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $ville = $form->getData();
            $villeClean = $ville["ville"];
            $verif = $em->getRepository('MeteoBundle:MeteoInput')->findinput($villeClean);
            var_dump($verif);
            if (!empty($verif))
            {
                $dataBack = $verif[0]->getData();
                $data = json_decode($dataBack, true);
                $retour = array('nom' => $data['name'], 'humidite' => $data['main']['humidity'], 'type' => $data['weather'][0]['main'], 'temperature' => $data['main']['temp'], 'description' => $data['weather'][0]['description']);
                return $this->render('MeteoBundle:Meteo:render.html.twig', array('donnees' => $retour));
            }
            else
            {
                $sauvegarde = New MeteoInput();
                $json = file_get_contents('http://api.openweathermap.org/data/2.5/weather?q='.$villeClean.'&appid=d4bf3c3151421efaa9c3e18d97fd8dab&units=metric&lang=fr');
                $data = json_decode($json,true);
                $retour = array('nom' => $data['name'], 'humidite' => $data['main']['humidity'], 'type' => $data['weather'][0]['main'], 'temperature' => $data['main']['temp'], 'description' => $data['weather'][0]['description']);
                $sauvegarde->setData($json);
                $sauvegarde->setInput($villeClean);
                $em->persist($sauvegarde);
                $em->flush();
                return $this->render('MeteoBundle:Meteo:render.html.twig', array('donnees' => $retour));
            }
        }
        return $this->render('MeteoBundle:Meteo:meteo.html.twig', array('form' => $form->createView()));
    }
    public function renderidAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $verif = $em->getRepository('MeteoBundle:MeteoVille')->findcountryid($id);
        if (!empty($verif))
        {
            $dataBack = $verif[0]->getData();
            $data = json_decode($dataBack,true);
            $retour = array('nom' => $data['name'], 'humidite' => $data['main']['humidity'], 'type' => $data['weather'][0]['main'], 'temperature' => $data['main']['temp'], 'description' => $data['weather'][0]['description']);
            return $this->render('MeteoBundle:Meteo:render.html.twig', array('donnees' => $retour));
        }
        else
        {
            $sauvegarde = New MeteoVille();
            $json = file_get_contents('http://api.openweathermap.org/data/2.5/weather?id='.$id.'&appid=d4bf3c3151421efaa9c3e18d97fd8dab&units=metric&lang=fr');
            $data = json_decode($json,true);
            $retour = array('nom' => $data['name'], 'humidite' => $data['main']['humidity'], 'type' => $data['weather'][0]['main'], 'temperature' => $data['main']['temp'], 'description' => $data['weather'][0]['description']);
            $sauvegarde->setData($json);
            $sauvegarde->setIdCountry($id);
            $em->persist($sauvegarde);
            $em->flush();
            return $this->render('MeteoBundle:Meteo:render.html.twig', array('donnees' => $retour));
        }
    }
    public function rendergpsAction($latitude, $longitude)
    {
        $em = $this->getDoctrine()->getManager();
        $latitude_clean = floatval($latitude);
        $longitude_clean = floatval($longitude);
        $verif = $em->getRepository('MeteoBundle:MeteoGPS')->findgps($latitude_clean, $longitude_clean);
        if (!empty($verif))
        {
            $dataBack = $verif[0]->getData();
            $data = json_decode($dataBack,true);
            $retour = array('nom' => $data['name'], 'humidite' => $data['main']['humidity'], 'type' => $data['weather'][0]['main'], 'temperature' => $data['main']['temp'], 'description' => $data['weather'][0]['description']);
            return $this->render('MeteoBundle:Meteo:render.html.twig', array('donnees' => $retour));
        }
        else
        {
            $sauvegarde = New MeteoGPS();
            $json = file_get_contents('http://api.openweathermap.org/data/2.5/weather?lat=' . $latitude . '&lon=' . $longitude . '&appid=d4bf3c3151421efaa9c3e18d97fd8dab&units=metric&lang=fr');
            $data = json_decode($json, true);
            $retour = array('nom' => $data['name'], 'humidite' => $data['main']['humidity'], 'type' => $data['weather'][0]['main'], 'temperature' => $data['main']['temp'], 'description' => $data['weather'][0]['description']);
            $sauvegarde->setData($json);
            $sauvegarde->setLatitude($latitude_clean);
            $sauvegarde->setLongitude($longitude_clean);
            $em->persist($sauvegarde);
            $em->flush();
            return $this->render('MeteoBundle:Meteo:render.html.twig', array('donnees' => $retour));
        }
    }
}
