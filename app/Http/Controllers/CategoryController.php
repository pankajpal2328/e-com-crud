<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;

class CategoryController extends Controller
{
    public function getSubcategories($id) {

        $subcategories = Subcategory::whereCategoryId($id)->get();

        return response()->json($subcategories);
    }
}
