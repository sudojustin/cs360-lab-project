<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Card</title>
    <style>
        .card {
            max-width: 300px;
            margin: auto;
            text-align: center;
            font-family: Arial, sans-serif;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 10px;
            box-shadow: 2px 2px 10px rgba(0,0,0,0.1);
        }
        .card img {
            width: 100%;
            border-radius: 10px;
        }
        .price {
            color: grey;
            font-size: 22px;
        }
        .card button {
            border: none;
            outline: 0;
            padding: 10px;
            color: white;
            background-color: #ff523b;
            text-align: center;
            cursor: pointer;
            width: 100%;
            font-size: 18px;
            border-radius: 5px;
        }
        .card button:hover {
            background-color: #ff2200;
        }
    </style>
</head>
<body>

    <div class="card">
        <img src="{{ asset('images/jeans3.jpg') }}" alt="Denim Jeans">
        <h1>Tailored Jeans</h1>
        <p class="price">$19.99</p>
        <p>Some text about the jeans..</p>
        <p><button>Add to Cart</button></p>
    </div>

</body>
</html>
