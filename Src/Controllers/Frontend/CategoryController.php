<?php

namespace MvcCore\Rental\Controllers\Frontend;

use MvcCore\Rental\Models\Category;
use MvcCore\Rental\Support\Http\Request;
use JTL\Shop;


class CategoryController
{

    public function index()
    {
        $categories = Category::get();
        foreach ($categories as $category) {
            $categoryName = json_decode($category->name);
            $category->categoryNameEN = $categoryName->en;
            $category->categoryNameDE = $categoryName->de;
        }
        $smarty = Shop::Smarty();
        $smarty->assign('categories' , $categories);
    }
}