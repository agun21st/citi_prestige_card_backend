<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Marketing Agency | dMarkcy</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif
        }

        body {
            background: #ecf0f3 !important;
            display: flex;
            justify-content: center
        }

        .card {
            padding: 20px;
            max-width: 800px;
	    margin-top: 100px;
        }

        .boxShadow10 {
            border-radius: 10px;
            box-shadow: -3px -3px 7px #ffffff, 3px 3px 5px #ceced1
        }

        .price {
            color: grey;
            font-size: 40px
        }

        .card button {
            border: none;
            outline: 0;
            padding: 12px;
            color: gray;
            background: #ecf0f3 !important;
            text-align: center;
            cursor: pointer;
            width: 100%;
            font-size: 18px
        }

        .socialLink a {
            font-size: medium;
            font-weight: 500;
            color: blue;
            margin-top: 10px
        }

        #getAQuoteRequest {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #getAQuoteRequest td,
        #getAQuoteRequest th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #getAQuoteRequest tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #getAQuoteRequest tr:hover {
            background-color: #ddd;
        }

        #getAQuoteRequest th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #2b92d0;
            color: white;
        }
    </style>
</head>

<body>
    <div class="card boxShadow10">
        <div style="text-align: center;"> <a href="https://app.cit.tools/logo.png" alt="cit.tools | Creative IT Institute"> </a></div>
        <hr />
        <h1 style="text-align: center">Welcome to cit.tools</h1>
        <h3 style="color: gray; font-weight: 400;">Dear <strong>{{$name}}</strong>,<br>we are happy to give you cit.tools vast tools download for free.</h3>
        <table id="getAQuoteRequest">
            <tr>
                <th>Login ID</th>
                <th>Password</th>
                <th>Login Page Link</th>
            </tr>
            <tr>
                <td>{{$login_id}}</td>
                <td>{{$password}}</td>
                <td><a href="https://app.cit.tools/login" target="_blank">https://app.cit.tools/login</a></td>
            </tr>
        </table>
        <h2>Thank you</h2>
    </div>
</body>

</html>