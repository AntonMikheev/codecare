<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends Controller
{
    public function indexAction(Request $request)
    {
        $products = $this->getDoctrine()->getRepository('AppBundle:Product')->findAll();
        return $this->render('default/index.html.twig', [
            'products' => $products,
        ]);
    }

    public function categoriesPageAction($categoryName = null)
    {
        if (!is_null($categoryName)) {
            $products = $this->getProductsByCategory($categoryName);
        } else {
            $products = $this->getDoctrine()->getRepository('AppBundle:Product')->findAll();
        }
        $categories = $this->getDoctrine()->getRepository('AppBundle:Category')->findAll();
        return $this->render('default/categories.html.twig', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    private function getProductsByCategory($categoryName)
    {
        $category = $this->getDoctrine()->getRepository('AppBundle:Category')->findOneByName($categoryName);
        $products = $category->getProducts();
        $productsArray = [];
        foreach ($products as $product) {
            $productsArray[] = $product;
        }

        return $productsArray;
    }
}
