<?php

namespace App\Controller;

use App\Form\MapType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Map;

class WelcomeController extends AbstractController
{
    /**
     * @Route("/", name="welcome")
     * @param Filesystem $fs
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|Response
     */
    public function welcomeAction(Filesystem $fs, Request $request)
    {
        $generate = FALSE;
        define('WARSAW_ID', 756135);
        $city_id = WARSAW_ID;
        $form = $this->createForm(MapType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $formData = $form->getData();
            if(is_object($miasto = $formData['miast']))
            {
                $city_id = $miasto->getOpenWeatherId();
            }
        }

        if ($fs->exists(__DIR__ . '/../../private/json/' . $city_id . '.json'))
        {
            $content = json_decode(file_get_contents(__DIR__ . '/../../private/json/' . $city_id . '.json'), TRUE);
            if ((microtime(TRUE) - $content['date']) > 218000)
            {
                $generate = TRUE;
            }
            if(isset($content['cod']) && $content['cod']=='404')
            {
                $city_id = WARSAW_ID;
                $generate = TRUE;
            }
        }
        else
        {
            $generate = TRUE;
            $content = '';
        }
        if ($generate)
        {
            do{
                $url = 'http://api.openweathermap.org/data/2.5/weather?id=' . $city_id . '&APPID=2014119e185ee1a02178ae69b6bf7bbe&units=metric&lang=pl';
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
                $content = curl_exec($ch);
                curl_close($ch);
                $content = json_decode($content, TRUE);
                $content['date'] = microtime(TRUE);
                if ($content)
                {
                    try
                    {
                        $fs->dumpFile(__DIR__ . '/../../private/json/' . $city_id . '.json', json_encode($content));
                    }
                    catch (IOException $e)
                    {
                    }
                }
            } while(!isset($content['name']) && $city_id != WARSAW_ID && $city_id = WARSAW_ID);
        }
        if(!isset($content['name']))
        {
            return new Response('Error');
        }
        else
        {
            return $this->render('welcome/index.html.twig', [
                'weather' => $content,
                'map_form' => $form->createView(),
            ]);
        }
    }

    /**
     * @Route("/generate_map", name="generate")
     * set this as public if u need an import
     */
    private function generateMapAction()
    {
        $cities=array(
            [756135, 'Warszawa'],
            [3094802, 'Kraków'],
            [3093133, 'Łódź'],
            [7531002, 'Gdańsk'],
            [858789, 'Białystok'],
            [3096472, 'Katowice'],
            [7530819, 'Rzeszów'],
            [3081368, 'Wrocław'],
            [3083829, 'Szczecin'],
            [7530858, 'Poznań'],
            [763166, 'Olsztyn'],
            [765876, 'Lublin'],
            [769250, 'Kielce'],
            [3102014, 'Bydgoszcz'],
            [7530991, 'Zielona Góra'],
        );
        foreach($cities as $city)
        {
            $map = new Map();
            $map->setOpenWeatherId($city[0]);
            $map->setCityName($city[1]);

            $em = $this->getDoctrine()->getManager();
            // save User
            $em->persist($map);

            // execute query
            $em->flush();
        }
        return new Response('Map has been generated');
    }
}
