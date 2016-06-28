<?php

namespace MeteoBundle\Controller;

use MeteoBundle\Entity\Meteo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Constraints\DateTime;

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
            if (!empty($verif))
            {
                $dataBack = $verif[0]->getData();
                $previsionBack = $verif[0]->getPrevision();
                $data = json_decode($dataBack,true);
                $prevision = json_decode($previsionBack,true);
                $retour[0] = array('humidite' => $data['main']['humidity'], 'type' => $data['weather'][0]['main'], 'temperature' => $data['main']['temp'], 'description' => $data['weather'][0]['description'], 'date' => "En ce moment");
                $info = $prevision['city']['name'];
                $retour[1] = array('humidite' => $prevision['list'][8]['main']['humidity'], 'type' => $prevision['list'][8]['weather'][0]['main'], 'temperature' => $prevision['list'][8]['main']['temp'], 'description' => $prevision['list'][8]['weather'][0]['description'], 'date' => $prevision['list'][8]['dt_txt']);
                $retour[2] = array('humidite' => $prevision['list'][16]['main']['humidity'], 'type' => $prevision['list'][16]['weather'][0]['main'], 'temperature' => $prevision['list'][16]['main']['temp'], 'description' => $prevision['list'][16]['weather'][0]['description'], 'date' => $prevision['list'][16]['dt_txt']);
                $retour[3] = array('humidite' => $prevision['list'][24]['main']['humidity'], 'type' => $prevision['list'][24]['weather'][0]['main'], 'temperature' => $prevision['list'][24]['main']['temp'], 'description' => $prevision['list'][24]['weather'][0]['description'], 'date' => $prevision['list'][24]['dt_txt']);
                $retour[4] = array('humidite' => $prevision['list'][32]['main']['humidity'], 'type' => $prevision['list'][32]['weather'][0]['main'], 'temperature' => $prevision['list'][32]['main']['temp'], 'description' => $prevision['list'][32]['weather'][0]['description'], 'date' => $prevision['list'][32]['dt_txt']);
                if(in_array(40, $prevision['list'], true))
                {
                    $retour[5] = array('humidite' => $prevision['list'][38]['main']['humidity'], 'type' => $prevision['list'][38]['weather'][0]['main'], 'temperature' => $prevision['list'][38]['main']['temp'], 'description' => $prevision['list'][38]['weather'][0]['description'], 'date' => $prevision['list'][38]['dt_txt']);
                }
                else{
                    $retour[5] = array('humidite' => "Indisponible", 'type' => "Indisponible", 'temperature' => "Indisponible", 'description' => "Aucune prévision disponible", 'date' => "Indisponible");
                }
                $donnees_json = json_encode($retour);
                return $this->render('MeteoBundle:Meteo:render.html.twig', array('info' => $info, 'donnees' => $retour, 'donnees_j' => $donnees_json));
            }
            else
            {
                $sauvegarde = New Meteo();
                $json = file_get_contents('http://api.openweathermap.org/data/2.5/weather?q='.$ville.'&appid='.$apiId.'&units='.$units.'&lang='.$langs.'');
                $data = json_decode($json,true);
                $retour[0] = array('nom' => $data['name'], 'humidite' => $data['main']['humidity'], 'type' => $data['weather'][0]['main'], 'temperature' => $data['main']['temp'], 'description' => $data['weather'][0]['description'], 'date' => "En ce moment");
                $json_new = file_get_contents('http://api.openweathermap.org/data/2.5/forecast?q='.$ville.'&appid='.$apiId.'&units='.$units.'&lang='.$langs.'');
                $data_new = json_decode($json_new, true);
                $info = $data_new['city']['name'];
                $retour[1] = array('humidite' => $data_new['list'][8]['main']['humidity'], 'type' => $data_new['list'][8]['weather'][0]['main'], 'temperature' => $data_new['list'][8]['main']['temp'], 'description' => $data_new['list'][8]['weather'][0]['description'], 'date' => $data_new['list'][8]['dt_txt']);
                $retour[2] = array('humidite' => $data_new['list'][16]['main']['humidity'], 'type' => $data_new['list'][16]['weather'][0]['main'], 'temperature' => $data_new['list'][16]['main']['temp'], 'description' => $data_new['list'][16]['weather'][0]['description'], 'date' => $data_new['list'][16]['dt_txt']);
                $retour[3] = array('humidite' => $data_new['list'][24]['main']['humidity'], 'type' => $data_new['list'][24]['weather'][0]['main'], 'temperature' => $data_new['list'][24]['main']['temp'], 'description' => $data_new['list'][24]['weather'][0]['description'], 'date' => $data_new['list'][24]['dt_txt']);
                $retour[4] = array('humidite' => $data_new['list'][32]['main']['humidity'], 'type' => $data_new['list'][32]['weather'][0]['main'], 'temperature' => $data_new['list'][32]['main']['temp'], 'description' => $data_new['list'][32]['weather'][0]['description'], 'date' => $data_new['list'][32]['dt_txt']);
                if(in_array(40, $data_new['list'], true))
                {
                    $retour[5] = array('humidite' => $data_new['list'][38]['main']['humidity'], 'type' => $data_new['list'][38]['weather'][0]['main'], 'temperature' => $data_new['list'][38]['main']['temp'], 'description' => $data_new['list'][38]['weather'][0]['description'], 'date' => $data_new['list'][38]['dt_txt']);
                }
                else{
                    $retour[5] = array('humidite' => "Indisponible", 'type' => "Indisponible", 'temperature' => "Indisponible", 'description' => "Aucune prévision disponible", 'date' => "Indisponible");
                }
                $donnees_json = json_encode($retour);
                $sauvegarde->setData($json);
                $sauvegarde->setPrevision($json_new);
                $sauvegarde->setInput($ville);
                $em->persist($sauvegarde);
                $em->flush();
                return $this->render('MeteoBundle:Meteo:render.html.twig', array('info' => $info, 'donnees' => $retour, 'donnees_j' => $donnees_json));
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
            $previsionBack = $verif[0]->getPrevision();
            $data = json_decode($dataBack,true);
            $prevision = json_decode($previsionBack,true);
            $retour[0] = array('humidite' => $data['main']['humidity'], 'type' => $data['weather'][0]['main'], 'temperature' => $data['main']['temp'], 'description' => $data['weather'][0]['description'], 'date' => "En ce moment");
            $info = $prevision['city']['name'];
            $retour[1] = array('humidite' => $prevision['list'][8]['main']['humidity'], 'type' => $prevision['list'][8]['weather'][0]['main'], 'temperature' => $prevision['list'][8]['main']['temp'], 'description' => $prevision['list'][8]['weather'][0]['description'], 'date' => $prevision['list'][8]['dt_txt']);
            $retour[2] = array('humidite' => $prevision['list'][16]['main']['humidity'], 'type' => $prevision['list'][16]['weather'][0]['main'], 'temperature' => $prevision['list'][16]['main']['temp'], 'description' => $prevision['list'][16]['weather'][0]['description'], 'date' => $prevision['list'][16]['dt_txt']);
            $retour[3] = array('humidite' => $prevision['list'][24]['main']['humidity'], 'type' => $prevision['list'][24]['weather'][0]['main'], 'temperature' => $prevision['list'][24]['main']['temp'], 'description' => $prevision['list'][24]['weather'][0]['description'], 'date' => $prevision['list'][24]['dt_txt']);
            $retour[4] = array('humidite' => $prevision['list'][32]['main']['humidity'], 'type' => $prevision['list'][32]['weather'][0]['main'], 'temperature' => $prevision['list'][32]['main']['temp'], 'description' => $prevision['list'][32]['weather'][0]['description'], 'date' => $prevision['list'][32]['dt_txt']);
            if(in_array(40, $prevision['list'], true))
            {
                $retour[5] = array('humidite' => $prevision['list'][38]['main']['humidity'], 'type' => $prevision['list'][38]['weather'][0]['main'], 'temperature' => $prevision['list'][38]['main']['temp'], 'description' => $prevision['list'][38]['weather'][0]['description'], 'date' => $prevision['list'][38]['dt_txt']);
            }
            else{
                $retour[5] = array('humidite' => "Indisponible", 'type' => "Indisponible", 'temperature' => "Indisponible", 'description' => "Aucune prévision disponible", 'date' => "Indisponible");
            }
            $donnees_json = json_encode($retour);
            return $this->render('MeteoBundle:Meteo:render.html.twig', array('info' => $info, 'donnees' => $retour, 'donnees_j' => $donnees_json));
        }
        else
        {
            $sauvegarde = New Meteo();
            $json = file_get_contents('http://api.openweathermap.org/data/2.5/weather?id='.$id.'&appid='.$apiId.'&units='.$units.'&lang='.$langs.'');
            $data = json_decode($json, true);
            $retour[0] = array('humidite' => $data['main']['humidity'], 'type' => $data['weather'][0]['main'], 'temperature' => $data['main']['temp'], 'description' => $data['weather'][0]['description'], 'date' => "En ce moment");
            $json_new = file_get_contents('http://api.openweathermap.org/data/2.5/forecast?id='.$id.'&appid='.$apiId.'&units='.$units.'&lang='.$langs.'');
            $data_new = json_decode($json_new, true);
            $info = $data_new['city']['name'];
            $retour[1] = array('humidite' => $data_new['list'][8]['main']['humidity'], 'type' => $data_new['list'][8]['weather'][0]['main'], 'temperature' => $data_new['list'][8]['main']['temp'], 'description' => $data_new['list'][8]['weather'][0]['description'], 'date' => $data_new['list'][8]['dt_txt']);
            $retour[2] = array('humidite' => $data_new['list'][16]['main']['humidity'], 'type' => $data_new['list'][16]['weather'][0]['main'], 'temperature' => $data_new['list'][16]['main']['temp'], 'description' => $data_new['list'][16]['weather'][0]['description'], 'date' => $data_new['list'][16]['dt_txt']);
            $retour[3] = array('humidite' => $data_new['list'][24]['main']['humidity'], 'type' => $data_new['list'][24]['weather'][0]['main'], 'temperature' => $data_new['list'][24]['main']['temp'], 'description' => $data_new['list'][24]['weather'][0]['description'], 'date' => $data_new['list'][24]['dt_txt']);
            $retour[4] = array('humidite' => $data_new['list'][32]['main']['humidity'], 'type' => $data_new['list'][32]['weather'][0]['main'], 'temperature' => $data_new['list'][32]['main']['temp'], 'description' => $data_new['list'][32]['weather'][0]['description'], 'date' => $data_new['list'][32]['dt_txt']);
            if(in_array(40, $data_new['list'], true))
            {
                $retour[5] = array('humidite' => $data_new['list'][38]['main']['humidity'], 'type' => $data_new['list'][38]['weather'][0]['main'], 'temperature' => $data_new['list'][38]['main']['temp'], 'description' => $data_new['list'][38]['weather'][0]['description'], 'date' => $data_new['list'][38]['dt_txt']);
            }
            else{
                $retour[5] = array('humidite' => "Indisponible", 'type' => "Indisponible", 'temperature' => "Indisponible", 'description' => "Aucune prévision disponible", 'date' => "Indisponible");
            }
            $donnees_json = json_encode($retour);
            $sauvegarde->setData($json);
            $sauvegarde->setPrevision($json_new);
            $sauvegarde->setCountry($id);
            $em->persist($sauvegarde);
            $em->flush();
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
            $previsionBack = $verif[0]->getPrevision();
            $data = json_decode($dataBack,true);
            $prevision = json_decode($previsionBack,true);
            $retour[0] = array('nom' => $data['name'], 'humidite' => $data['main']['humidity'], 'type' => $data['weather'][0]['main'], 'temperature' => $data['main']['temp'], 'description' => $data['weather'][0]['description'], 'date' => "En ce moment");
            $info = $prevision['city']['name'];
            $retour[1] = array('humidite' => $prevision['list'][8]['main']['humidity'], 'type' => $prevision['list'][8]['weather'][0]['main'], 'temperature' => $prevision['list'][8]['main']['temp'], 'description' => $prevision['list'][8]['weather'][0]['description'], 'date' => $prevision['list'][8]['dt_txt']);
            $retour[2] = array('humidite' => $prevision['list'][16]['main']['humidity'], 'type' => $prevision['list'][16]['weather'][0]['main'], 'temperature' => $prevision['list'][16]['main']['temp'], 'description' => $prevision['list'][16]['weather'][0]['description'], 'date' => $prevision['list'][16]['dt_txt']);
            $retour[3] = array('humidite' => $prevision['list'][24]['main']['humidity'], 'type' => $prevision['list'][24]['weather'][0]['main'], 'temperature' => $prevision['list'][24]['main']['temp'], 'description' => $prevision['list'][24]['weather'][0]['description'], 'date' => $prevision['list'][24]['dt_txt']);
            $retour[4] = array('humidite' => $prevision['list'][32]['main']['humidity'], 'type' => $prevision['list'][32]['weather'][0]['main'], 'temperature' => $prevision['list'][32]['main']['temp'], 'description' => $prevision['list'][32]['weather'][0]['description'], 'date' => $prevision['list'][32]['dt_txt']);
            if(in_array(40, $prevision['list'], true))
            {
                $retour[5] = array('humidite' => $prevision['list'][38]['main']['humidity'], 'type' => $prevision['list'][38]['weather'][0]['main'], 'temperature' => $prevision['list'][38]['main']['temp'], 'description' => $prevision['list'][38]['weather'][0]['description'], 'date' => $prevision['list'][38]['dt_txt']);
            }
            else{
                $retour[5] = array('humidite' => "Indisponible", 'type' => "Indisponible", 'temperature' => "Indisponible", 'description' => "Aucune prévision disponible", 'date' => "Indisponible");
            }
            $donnees_json = json_encode($retour);
            return $this->render('MeteoBundle:Meteo:render.html.twig', array('info' => $info, 'donnees' => $retour, 'donnees_j' => $donnees_json));
        }
        else
        {
            $sauvegarde = New Meteo();
            $json = file_get_contents('http://api.openweathermap.org/data/2.5/weather?lat='.$latitude.'&lon='.$longitude.'&appid='.$apiId.'&units='.$units.'&lang='.$langs.'');
            $data = json_decode($json, true);
            $retour[0] = array('nom' => $data['name'], 'humidite' => $data['main']['humidity'], 'type' => $data['weather'][0]['main'], 'temperature' => $data['main']['temp'], 'description' => $data['weather'][0]['description'], 'date' => "En ce moment");
            $json_new = file_get_contents('http://api.openweathermap.org/data/2.5/forecast?lat='.$latitude.'&lon='.$longitude.'&appid='.$apiId.'&units='.$units.'&lang='.$langs.'');
            $data_new = json_decode($json_new, true);
            $info = $data_new['city']['name'];
            $retour[1] = array('humidite' => $data_new['list'][8]['main']['humidity'], 'type' => $data_new['list'][8]['weather'][0]['main'], 'temperature' => $data_new['list'][8]['main']['temp'], 'description' => $data_new['list'][8]['weather'][0]['description'], 'date' => $data_new['list'][8]['dt_txt']);
            $retour[2] = array('humidite' => $data_new['list'][16]['main']['humidity'], 'type' => $data_new['list'][16]['weather'][0]['main'], 'temperature' => $data_new['list'][16]['main']['temp'], 'description' => $data_new['list'][16]['weather'][0]['description'], 'date' => $data_new['list'][16]['dt_txt']);
            $retour[3] = array('humidite' => $data_new['list'][24]['main']['humidity'], 'type' => $data_new['list'][24]['weather'][0]['main'], 'temperature' => $data_new['list'][24]['main']['temp'], 'description' => $data_new['list'][24]['weather'][0]['description'], 'date' => $data_new['list'][24]['dt_txt']);
            $retour[4] = array('humidite' => $data_new['list'][32]['main']['humidity'], 'type' => $data_new['list'][32]['weather'][0]['main'], 'temperature' => $data_new['list'][32]['main']['temp'], 'description' => $data_new['list'][32]['weather'][0]['description'], 'date' => $data_new['list'][32]['dt_txt']);
            if(in_array(40, $data_new['list'], true))
            {
                $retour[5] = array('humidite' => $data_new['list'][38]['main']['humidity'], 'type' => $data_new['list'][38]['weather'][0]['main'], 'temperature' => $data_new['list'][38]['main']['temp'], 'description' => $data_new['list'][38]['weather'][0]['description'], 'date' => $data_new['list'][38]['dt_txt']);
            }
            else{
                $retour[5] = array('humidite' => "Indisponible", 'type' => "Indisponible", 'temperature' => "Indisponible", 'description' => "Aucune prévision disponible", 'date' => "Indisponible");
            }
            $donnees_json = json_encode($retour);
            $sauvegarde->setData($json);
            $sauvegarde->setPrevision($json_new);
            $sauvegarde->setLatitude($latitude_clean);
            $sauvegarde->setLongitude($longitude_clean);
            $em->persist($sauvegarde);
            $em->flush();
            return $this->render('MeteoBundle:Meteo:render.html.twig', array('info' => $info, 'donnees' => $retour, 'donnees_j' => $donnees_json));
        }
    }
}
