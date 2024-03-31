<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Product Catalog</title>
</head>
<body>
    <div class='container'>
    <h1>Product Catalog</h1>
        <a href="/mvc/login/logout" >Logout</a></br>
        <a href="/mvc/product/create" class='btn btn-success'>Add an item</a>
        <table class='table table-striped'>
            <tr><td>Name</td><td>Price</td><td>Action</td></tr>
            <?php
                foreach($data['items'] as $item){
                    echo "<tr><td>$item->name</td>
                    <td>$item->price</td>
                    <td>
                    <a href='/mvc/product/detail/$item->product_id' class='btn btn-primary'>Detail</a>
                    <a href='/mvc/product/edit/$item->product_id' class='btn btn-success'>Edit</a>
                    <a href='/mvc/product/delete/$item->product_id' class='btn btn-danger'>Delete</a>
                    <a href='/mvc/product/addPicture/$item->product_id' class='btn btn-primary'>Add a picture</a>
                    </td>
                    </tr>";
                }
            ?>
        </table>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>

