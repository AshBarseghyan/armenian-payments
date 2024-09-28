<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment Success</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
            background: #f1ebeb;
        }
        .container {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        h2 {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #00ba71;
        }
        p {
            font-size: 1.2rem;
            font-weight: 300;
            margin-bottom: 1rem;
            color: #6a767a;
        }
        img {
            width: 100%;
            max-width: 500px;
            margin-bottom: 1rem;
        }
        a {
            text-decoration: none;
            color: #fff;
            background: #bdd0d0;
            padding: 1rem 2rem;
            border-radius: 5px;
        }




        @media (max-width: 1200px){
            img {
                max-width: 440px;
            }
        }
        @media (max-width: 992px){
            img {
                max-width: 400px;
            }
        }

        @media (max-width: 768px){
            img {
                max-width: 300px;
            }
            h2 {
                font-size: 24px;
            }
        }


    </style>
</head>
<body>

<div class="container">
    <img src="{{asset('images/success.png')}}" alt="success">
    <h2 class="dsd">Thank you</h2>
    <p>Payment was successful</p>
    <a href="{{url('/')}}">Home</a>
</div>

</body>
</html>
