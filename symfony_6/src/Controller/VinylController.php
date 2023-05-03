<?php

namespace App\Controller;

// use Knp\Bundle\TimeBundle\DateTimeFormatter;

use App\Repository\VinylMixRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Config\BabdevPagerfantaConfig;

use function Symfony\Component\String\u;

class VinylController extends AbstractController
{
    // public function __construct(
    //     private bool $isDebug
    // )
    // {
        
    // }
    

    #[Route('/', name:'app_homepage')] 
    public function homepage(): Response
    {

        $tracks = [
            
                ['song' => 'Gangsta\'s Paradise', 'artist'=>'Coolio'],
                ['song' => 'Waterfalls', 'artist'=>'TLC'],
                ['song' => 'Creep', 'artist'=>'Radiohead'],  
                ['song' => 'Kiss From a Rose', 'artist'=>'Seal'],
                ['song' => 'On Bended Knee', 'artist'=>'Boys II Men'],
                ['song' => 'Fantasy', 'artist'=>'Mariah Carey'],           
           
            
           
        ];
        return $this->render('vinyl/homepage.html.twig',[
            'title' => 'Pocket Music',
            'tracks' => $tracks,
        ]);
    }


    #[Route('/browse/{slug}', name: 'app_browse')]
    public function browse(VinylMixRepository $mixRepository, Request $request, string $slug = null): Response
    {
        $genre = $slug ? u(str_replace('-', ' ', $slug))->title(true) : null;

        $queryBuilder = $mixRepository->createOrderedByVotesQueryBuilder($slug);
        $adapter = new QueryAdapter($queryBuilder);
        $pagerfanta = Pagerfanta::createForCurrentPageWithMaxPerPage(
            $adapter,
            $request->query->get('page',1),
            9
        );

    
        return $this->render('vinyl/browse.html.twig',[
            'genre' => $genre,
            'pager' => $pagerfanta,
        ]);
    }

    

    #[Route('/showpage', name:'show_page')] 
    public function showpage()
    {

        return $this->render('vinyl/showpage.html.twig',[
            'title' => 'Welcome Bose DK',
        ]);
    }
}
