//ejercicio 1
<?php
// Arreglo indexado con 5 lenguajes de programación
$lenguajes = ["PHP", "JavaScript", "Python", "Java", "C++"];

// Mostrando el segundo (índice 1), el quinto (índice 4) y el primer (índice 0) lenguaje
echo "Segundo lenguaje: " . $lenguajes[1] . "<br>";
echo "Quinto lenguaje: " . $lenguajes[4] . "<br>";
echo "Primer lenguaje: " . $lenguajes[0];
 
// ejercicio 2

// Arreglo indexado con 4 categorías
$categorias = ["Electrónica", "Ropa", "Hogar", "Deportes"];

// Mostrando la tercera categoría (índice 2)
echo "Tercera categoría: " . $categorias[2];

// ejercicio 3

// Arreglo asociativo con la información del aprendiz
$aprendiz = [
    "nombre" => "Erick Nicolas Aguirre Beltran",
    "ficha" => 3230905,
    "programa" => "Análisis y Desarrollo de Software (ADSO)",
    "edad" => 20
];

// Mostrando en pantalla el nombre y el programa de formación
echo "Nombre del aprendiz: " . $aprendiz["nombre"] . "<br>";
echo "Programa de formación: " . $aprendiz["programa"];

// ejercicio 4

// Arreglo asociativo con la información del proveedor
$proveedor = [
    "nombre" => "Distribuciones Globales S.A.S.",
    "ciudad" => "Bogotá D.C.",
    "telefono" => "3101234567",
    "correo" => "contacto@distribucionesglobales.com"
];

// Mostrando en pantalla el nombre del proveedor y su ciudad
echo "Nombre del proveedor: " . $proveedor["nombre"] . "<br>";
echo "Ciudad: " . $proveedor["ciudad"];

// ejercicio 5

// Creación del arreglo asociativo inicial
$producto = [
    "nombre" => "Televisor Smart TV",
    "precio" => 1200000,
    "cantidad" => 15
];

// Modificando el precio y actualizando la cantidad disponible
$producto["precio"] = 1050000;
$producto["cantidad"] = 10;

// Agregando una nueva clave para la categoría
$producto["categoria"] = "Electrodomésticos";

// Mostrando la información actualizada
echo "--- Información Actualizada del Producto ---<br>";
echo "Nombre: " . $producto["nombre"] . "<br>";
echo "Precio: $" . number_format($producto["precio"], 0, ',', '.') . "<br>";
echo "Cantidad disponible: " . $producto["cantidad"] . "<br>";
echo "Categoría: " . $producto["categoria"];


// ejercicio 6


// Arreglo indexado inicial con tres marcas
$marcas = ["HP", "Dell", "Lenovo"];

// Agregando dos marcas adicionales usando corchetes vacíos
$marcas[] = "Asus";
$marcas[] = "Acer";

// Mostrando las cinco marcas registradas
echo "--- Marcas de Computadores Registradas ---<br>";
echo "1. " . $marcas[0] . "<br>";
echo "2. " . $marcas[1] . "<br>";
echo "3. " . $marcas[2] . "<br>";
echo "4. " . $marcas[3] . "<br>";
echo "5. " . $marcas[4];
 

//ejercicio 7
// Arreglo anidado que almacena tres productos
$productos = [
    [
        "nombre" => "Televisor Smart TV",
        "precio" => 1200000,
        "cantidad" => 5
    ],
    [
        "nombre" => "Computador Portátil",
        "precio" => 2100000,
        "cantidad" => 8
    ],
    [
        "nombre" => "Impresora Multifuncional",
        "precio" => 450000,
        "cantidad" => 12
    ]
];


echo "Nombre del segundo producto: " . $productos[1]["nombre"] . "<br>";
echo "Precio del tercer producto: $" . number_format($productos[2]["precio"], 0, ',', '.') . "<br>";
echo "Cantidad disponible del primer producto: " . $productos[0]["cantidad"];
  
//ejercicio 8
$aprendices = [
    [
        "nombre" => "Erick Nicolas Aguirre Beltran",
        "ficha" => 3230905,
        "programa" => "Análisis y Desarrollo de Software (ADSO)"
    ],
    [
        "nombre" => "Laura Sofía Pérez",
        "ficha" => 3230905,
        "programa" => "Análisis y Desarrollo de Software (ADSO)"
    ],
    [
        "nombre" => "Carlos Andrés Gómez",
        "ficha" => 3230906,
        "programa" => "Gestión de Redes de Datos"
    ]
];

// Mostrando los datos solicitados
echo "Nombre del tercer aprendiz: " . $aprendices[2]["nombre"] . "<br>";
echo "Ficha del primer aprendiz: " . $aprendices[0]["ficha"];