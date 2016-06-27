<?php

namespace MeteoBundle\Controller;

use MeteoBundle\Entity\Meteo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;

class MeteoController extends Controller
{
    public function indexAction(Request $request)
    {
        $apiId = $this->getParameter('api_keys');
        $units = $this->getParameter('units');
        $langs = $this->getParameter('langs');
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFormBuilder()
            ->add('ville', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Rechercher'))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $input = $form->getData();
            $ville = $input["ville"];
            $verif = $em->getRepository('MeteoBundle:Meteo')->findinput($ville);
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
                $sauvegarde = New Meteo();
                $json = file_get_contents('http://api.openweathermap.org/data/2.5/weather?q='.$ville.'&appid='.$apiId.'&units='.$units.'&lang='.$langs.'');
                $data = json_decode($json,true);
                $retour = array('nom' => $data['name'], 'humidite' => $data['main']['humidity'], 'type' => $data['weather'][0]['main'], 'temperature' => $data['main']['temp'], 'description' => $data['weather'][0]['description']);
                $sauvegarde->setData($json);
                $sauvegarde->setInput($ville);
                $em->persist($sauvegarde);
                $em->flush();
                return $this->render('MeteoBundle:Meteo:render.html.twig', array('donnees' => $retour));
            }
        }
        return $this->render('MeteoBundle:Meteo:meteo.html.twig', array('form' => $form->createView()));
    }
    public function renderidAction($id)
    {
        $apiId = $this->getParameter('api_keys');
        $units = $this->getParameter('units');
        $langs = $this->getParameter('langs');
        $em = $this->getDoctrine()->getManager();
        $verif = $em->getRepository('MeteoBundle:Meteo')->findcountryid($id);
        if (!empty($verif))
        {
            $dataBack = $verif[0]->getData();
            $data = json_decode($dataBack,true);
            $retour = array('nom' => $data['name'], 'humidite' => $data['main']['humidity'], 'type' => $data['weather'][0]['main'], 'temperature' => $data['main']['temp'], 'description' => $data['weather'][0]['description']);
            return $this->render('MeteoBundle:Meteo:render.html.twig', array('donnees' => $retour));
        }
        else
        {
            //$sauvegarde = New MeteoVille();
            $json_new = file_get_contents('http://api.openweathermap.org/data/2.5/forecast?id='.$id.'&appid='.$apiId.'&units='.$units.'&lang='.$langs.'');
            $data = json_decode($json_new, true);
            $info = $data['city']['name'];
            var_dump($json_new);
            $retour[0] = array('humidite' => $data['list'][0]['main']['humidity'], 'type' => $data['list'][0]['weather'][0]['main'], 'temperature' => $data['list'][0]['main']['temp'], 'description' => $data['list'][0]['weather'][0]['description']);
            $retour[1] = array('humidite' => $data['list'][8]['main']['humidity'], 'type' => $data['list'][8]['weather'][0]['main'], 'temperature' => $data['list'][8]['main']['temp'], 'description' => $data['list'][8]['weather'][0]['description']);
            $retour[2] = array('humidite' => $data['list'][16]['main']['humidity'], 'type' => $data['list'][16]['weather'][0]['main'], 'temperature' => $data['list'][16]['main']['temp'], 'description' => $data['list'][16]['weather'][0]['description']);
            $retour[3] = array('humidite' => $data['list'][24]['main']['humidity'], 'type' => $data['list'][24]['weather'][0]['main'], 'temperature' => $data['list'][24]['main']['temp'], 'description' => $data['list'][24]['weather'][0]['description']);
            $retour[4] = array('humidite' => $data['list'][32]['main']['humidity'], 'type' => $data['list'][32]['weather'][0]['main'], 'temperature' => $data['list'][32]['main']['temp'], 'description' => $data['list'][32]['weather'][0]['description']);
            //$retour[5] = array('humidite' => $data['list'][38]['main']['humidity'], 'type' => $data['list'][38]['weather'][0]['main'], 'temperature' => $data['list'][38]['main']['temp'], 'description' => $data['list'][38]['weather'][0]['description']);
            $donnees_json = json_encode($retour);
            return $this->render('MeteoBundle:Meteo:render.html.twig', array('info' => $info, 'donnees' => $retour, 'donnees_j' => $donnees_json));
        }
    }
    public function rendergpsAction($latitude, $longitude)
    {
        $apiId = $this->getParameter('api_keys');
        $units = $this->getParameter('units');
        $langs = $this->getParameter('langs');
        $em = $this->getDoctrine()->getManager();
        $latitude_clean = floatval($latitude);
        $longitude_clean = floatval($longitude);
        $verif = $em->getRepository('MeteoBundle:Meteo')->findgps($latitude_clean, $longitude_clean);
        if (!empty($verif))
        {
            $dataBack = $verif[0]->getData();
            $data = json_decode($dataBack,true);
            $retour = array('nom' => $data['name'], 'humidite' => $data['main']['humidity'], 'type' => $data['weather'][0]['main'], 'temperature' => $data['main']['temp'], 'description' => $data['weather'][0]['description']);
            return $this->render('MeteoBundle:Meteo:render.html.twig', array('donnees' => $retour));
        }
        else
        {
            $sauvegarde = New Meteo();
            $json = file_get_contents('http://api.openweathermap.org/data/2.5/weather?lat='.$latitude.'&lon='.$longitude.'&appid='.$apiId.'&units='.$units.'&lang='.$langs.'');
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
