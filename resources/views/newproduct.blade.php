<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>new product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <style>
        .form{
            margin-top: 50px;
        }

        .form button{
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div>    
        <nav class="navbar navbar-dark bg-dark">
            <div class="container">
            <a class="navbar-brand" href="#">New Product</a>
            </div>
        </nav>
    </div>

    <div class="container form">
        <form action={{route('add_product')}} method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label for="cat_name">Product Name</label>
              <input id="cat_name" type="text" name="name" class="form-control" >
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" class="form-control" name="description"  rows="3"></textarea>
            </div>

            <div class="form-group">
                <label for="product_category">Category</label>
                <select id="product_category" class="form-control" name="category">
                  @foreach ($category as $category)
                    <option value={{$category->id}}>{{ $category->name }}</option>
                  @endforeach
                </select>
              </div>

            <div class="form-group">
                <label for="img">Image</label>
                <input id="img" type="file" name="image" class="form-control-file" >
            </div>
              
            

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
</body>
</html>