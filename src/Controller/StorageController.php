<?php

namespace App\Controller;

use App\Repository\BundleRepository;
use App\Repository\GoodsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StorageController extends AbstractController
{

    #[Route('/storage', name: 'app_storage')]
    public function index(GoodsRepository $goodsRepository, BundleRepository $bundleRepository)
    {

        return $this->render('storage/index.html.twig',[
            'goods' => $goodsRepository->findAll(),
            'bundles' => $bundleRepository->findAll(),

        ]);
    }
}