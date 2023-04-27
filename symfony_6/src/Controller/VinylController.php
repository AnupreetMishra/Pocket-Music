<?php

namespace App\Controller;

// use Knp\Bundle\TimeBundle\DateTimeFormatter;

use App\Repository\VinylMixRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
        // dd($tracks);
        return $this->render('vinyl/homepage.html.twig',[
            'title' => 'Pocket Music',
            'tracks' => $tracks,
        ]);
    }

    // #[Route('/browse/{slug}', name: 'app_browse')]
    // public function browse(string $slug=null): Response
    // {
    //     $genre = $slug ?  u(str_replace('-', ' ', $slug))->title(true): null;
    //     return $this->render('viny/browse.html.twig',[
    //         'genre' => $genre,

    //     ]);
    // }


    #[Route('/browse/{slug}', name: 'app_browse')]
    public function browse(VinylMixRepository $mixRepository, string $slug = null): Response
    {
        $genre = $slug ? u(str_replace('-', ' ', $slug))->title(true) : null;
        // $mixes = $this->getMixes();
        // $mixes = $cache->get('mixes_data', function(CacheItemInterface $cacheItem) use ($httpClient) {
        //     $cacheItem->expiresAfter(5);
        //     $response =$httpClient->request('GET', 'https://raw.githubusercontent.com/symfonyCasts/vinyl-mixes/main/mixes.json');
        //     return $response->toArray();
        // });

        // $mixRepository = $entityManager->getRepository(VinylMix::class); 
        $mixes = $mixRepository->findAllOrderedByVotes($slug);


        
        
        return $this->render('vinyl/browse.html.twig',[
            'genre' => $genre,
            'mixes' => $mixes,
        ]);
    }

    // private function getMixes(): array{
    //     return [
    //         [
    //             'title' => 'Pocket Music',
    //             'trackCount' => 14,
    //             'genre' => 'Rock',
    //             'createdAt' => new \DateTime('2021-10-02'),
    //         ],
    //         [
    //             'title' => 'Put a Hex on your Ex',
    //             'trackCount' => 8,
    //             'genre' => 'Heavey Metal',
    //             'createdAt' => new \DateTime('2019-06-20'),
                 
    //         ],
    //     ]; 
    // }
    


    #[Route('/showpage', name:'show_page')] 
    public function showpage()
    {

        return $this->render('vinyl/showpage.html.twig',[
            'title' => 'Welcome to Mishra Travels',
        ]);
    }
}
