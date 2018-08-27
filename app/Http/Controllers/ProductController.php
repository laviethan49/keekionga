<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    public function createProduct(Request $req)
    {
	    $product = new Product;
	    	$product->group = $req->group_input;
	    	$product->product = $req->product_input;
	    	$product->unit = $req->unit_input;
	    	$product->description = $req->description_input;
	    	$product->price = $req->price_input;
	    $product->save();

	    return back()->withErrors(['Product Successfully Added!']);
    }

    public function getGroupsList()
    {
    	$allProducts = Product::orderBy('created_at', 'desc')->get();
    	$groups = array();
    	foreach ($allProducts as $key => $product)
    	{
    		if(!in_array($product->group, $groups))
    		{
    			array_push($groups, $product->group);
    		}
    	}

    	return response()->json($groups);
    }

    public function getProducts()
    {
    	$allProducts = Product::orderBy('created_at', 'desc')->get();

    	$productsByGroup = array();

    	foreach ($allProducts as $key => $product)
    	{
    		if(array_key_exists($product->group, $productsByGroup))
    		{
    			array_push($productsByGroup[$product->group], $product);
    		}
    		else
    		{
    			$productsByGroup[$product->group] = [
    				$product
    			];
    		}
    	}

    	return response()->json($productsByGroup);
    }

    public function editProduct(Request $req)
    {
    	$product = Product::find($req->productID);
			$product->product = $req->product_title_input;
			$product->unit = $req->product_unit_input;
			$product->description = $req->product_description_input;
			$product->price = $req->product_price_input;
		$product->save();

		return back()->withErrors(['Product Successfully Updated!']);
    }

    public function deleteProduct(Request $req)
    {
    	$product = Product::find($req->productID)->delete();

    	return back()->withErrors(['Product Successfully Deleted!']);
    }
}
