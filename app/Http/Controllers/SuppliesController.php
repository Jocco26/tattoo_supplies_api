<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product_Category;
use App\Models\Product;
use App\Http\Resources\Products as ProductResource;
use App\Http\Resources\Product_Category as CategoryResource;

class SuppliesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function apiIndex()
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(1);

        return ProductResource::collection($products);
    }

    public function apiCategories()
    {
        $category = Product_Category::all();

        return CategoryResource::collection($category);
    }

    public function index()
    {
        $category = Product_Category::all();

        return view('category', [
            'category' => $category,
        ]);
    }

    public function showProducts()
    {
        $products = Product::all();

        return view('products', [
            'products' => $products,
        ]);
    }


    public function newCategory()
    {
        return view('newcategory');
    }

    public function newProduct()
    {
        $category = Product_Category::all();

        return view('newproduct', [
            'category' => $category,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product_Category $category)
    {
        $data = [];

        //storing each html input value into $data array
        $data['name'] = $request->input('name');

        if( $request->isMethod('post'))//if the call is using the post it is a create client
        {
        $category->insert($data);

        return view('newcategory');
        }
    }

    public function storeProduct(Request $request, Product $product)
    {
        $data = [];

        if($request->hasFile('image'))
        {
            $destination_path = 'public/images/products';
            $image = $request->file('image');
            $image_name = $image->getClientOriginalName();
            $path = $request->file('image')->storeAs($destination_path,$image_name);

            $data['image'] = $image_name;
            $data['name'] = $request->input('name');
            $data['description'] = $request->input('description');
            $data['category_id'] = $request->input('category');
            
            $product->insert($data);
        }

        
    }

    public function storeProductApi(Request $request, Product $product)
    {

      
       $data = [];
            switch ($request->method()) {
                case 'POST':
                    try{
                        if($request->hasFile('image')){
                            
                            $file = $request->file('image');
                            $file_name = $file->getClientOriginalName();
                            $file->move(storage_path('app/public/images/products'), $file_name);
            
                            $data['image'] = $file_name;
                            $data['name'] = $request->input('name');
                            $data['description'] = $request->input('description');
                            $data['category_id'] = $request->input('category_id');
            
                      
                            $product->insert($data);
                       
                        }
                    }catch(\Exception $e){
                            return response()->json([
                                'message'=>$e->getMessage()
                            ]);
                        }
                    break;
        
                case 'PUT':
                    try{
                        
                        if($request->hasFile('image')){
                            
                            Product::findOrFail($request->input('product_id'));
                            $file = $request->file('image');
                            $file_name = $file->getClientOriginalName();
                            $file->move(storage_path('app/public/images/products'), $file_name);


                            $data['image'] = $file_name;
                            //$article->id = $request->input('article_id');
                            $data['id'] = $request->input('product_id');
                            $data['name'] = $request->input('name');
                            $data['description'] = $request->input('description');
                            $data['category_id'] = $request->input('category_id');
            
                      
                            $product->insert($data);
                       
                        }
                    }catch(\Exception $e){
                            return response()->json([
                                'message'=>$e->getMessage()
                            ]);
                        }
                    break;
        
                default:
                    // invalid request
                    break;
            }
        }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Get product
        $product = Product::findOrFail($id);

        if($product->delete()) {
            return new ProductResource($product);
        }   
    }
}
