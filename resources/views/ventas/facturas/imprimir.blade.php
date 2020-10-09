<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $factura->numero.'.pdf' }}</title>

    <style>
        html, body { 
            height:100%; 
            margin:0; 
            padding:0;
            font-size: 12px;
            color:blue;
        }
        div { 
            position:fixed; 
            width:100%; 
            height:50% 
        }
        .norte { top:7%;}
        .sur { top:60%;}   

        table {
            border-collapse: collapse;
            width: 100%;
            
        }

        table td, th {
            border: 1px solid blue;
            padding-left: 2px;
            text-align: left;   
            padding-right: 2px;  
            border-style:dotted;     
        }
        a:link{
            color:blue;
        }
        .float-right{
            float: right;           
        }
        
        hr.new3 {
            border-top: 1px dotted black;
        }
        a{
            color: black;
            text-decoration: none;
        }
        .linea{
            display: inline-flex;
            border: none; 
            vertical-align: top;
        }
        
    </style>
</head>
<body>

    @for ($i = 0; $i < 2; $i++)
        <div class="{{ $i==0?'norte':'sur' }}">
            @include('ventas.facturas.detalle',['factura'=>$factura])
        </div>    
    @endfor

</body>
</html>