<?php

namespace App\Controller\Admin;

use App\Entity\Admin;
use App\Entity\VinylMix;
use App\Repository\VinylMixRepository;
use Couchbase\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class DashboardController extends AbstractDashboardController
{

    private ChartBuilderInterface $chartBuilder;

    public function __construct(ChartBuilderInterface $chartBuilder)
    {
        $this->chartBuilder = $chartBuilder;

    }


    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {

        return $this->render('admin/index.html.twig',[
            'chart' => $this->createChart(),
        ]);
        
    }

    public function configureDashboard(): Dashboard
    {

        return Dashboard::new()
            ->setTitle('Pocket Music Admin Panel');
    }

 


    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fas fa-dashboard');
        yield MenuItem::subMenu('VinylMix', 'fa fa-music')
            ->setSubItems([
                    MenuItem::linkToCrud('All', 'fa fa-list', VinylMix::class),
                    

            ]);
        yield MenuItem::linkToUrl('Homepage', 'fas fa-home', $this->generateUrl('app_homepage'));
        yield MenuItem::linkToCrud('Users', 'fas fa-user', Admin::class);
        yield MenuItem::linkToUrl('Symfony Help', 'fab fa-symfony', 'https://symfony.com/doc/current/index.html')
            ->setLinkTarget('_blank'); 




    }

    public function configureCrud(): Crud
    {
        return parent::configureCrud()
           ->setDefaultSort([
                 'id' => 'ASC',

           ]);
        
    }

    public function configureActions(): Actions
    {
        return parent::configureActions()
          ->add( Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureAssets(): Assets
    {
        return parent::configureAssets()
            ->addWebpackEncoreEntry('admin');
    }

   
    private function createChart(): Chart
    {
        $chart = $this->chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'datasets' => [
                [
                    'label' => 'My First dataset',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [0, 10, 5, 2, 20, 30, 45],
                ],
            ],
        ]);
        $chart->setOptions([
            'scales' => [
                'y' => [
                   'suggestedMin' => 0,
                   'suggestedMax' => 100,
                ],
            ],
        ]);
        return $chart;
    }


}
