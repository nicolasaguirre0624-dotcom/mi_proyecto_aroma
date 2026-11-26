<?php
$productos = [
  [
    "id" => 1,
    "nombre" => "Mouse inalámbrico",
    "precio" => 35000,
    "stock" => 12,
    "disponible" => true,
    "categoria" => "Accesorios"
  ],
  [
    "id" => 2,
    "nombre" => "Teclado mecánico",
    "precio" => 165000,
    "stock" => 8,
    "disponible" => true,
    "categoria" => "Periféricos"
  ],
  [
    "id" => 3,
    "nombre" => "Monitor de 24 pulgadas",
    "precio" => 780000,
    "stock" => 6,
    "disponible" => true,
    "categoria" => "Monitores"
  ],
  [
    "id" => 4,
    "nombre" => "Cable USB-C",
    "precio" => 25000,
    "stock" => 30,
    "disponible" => true,
    "categoria" => "Accesorios"
  ],
  [
    "id" => 5,
    "nombre" => "Disco sólido SSD de 1 TB",
    "precio" => 295000,
    "stock" => 0,
    "disponible" => false,
    "categoria" => "Almacenamiento"
  ],
  [
    "id" => 6,
    "nombre" => "Memoria RAM de 16 GB",
    "precio" => 190000,
    "stock" => 5,
    "disponible" => true,
    "categoria" => "Componentes"
  ],
  [
    "id" => 7,
    "nombre" => "Base refrigerante para portátil",
    "precio" => 89000,
    "stock" => 10,
    "disponible" => true,
    "categoria" => "Accesorios"
  ],
  [
    "id" => 8,
    "nombre" => "Audífonos Bluetooth",
    "precio" => 120000,
    "stock" => 0,
    "disponible" => false,
    "categoria" => "Audio"
  ]
];


header('Content-Type: application/json; charset=utf-8');
foreach ($productos as $producto) {
    echo json_encode($producto, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR) . PHP_EOL;
}

// actividad 2


header("Content-Type: application/json; charset=utf-8");


$producto = [
    "id" => 1,
    "nombre" => "Mouse",
    "precio" => 35000
];

$idBuscado = 1; 


if ($idBuscado === $producto["id"]) {
    
    http_response_code(200);
    echo json_encode($producto);
} else {
    
    http_response_code(404);
    echo json_encode([
        "mensaje" => "Producto no encontrado"
    ]);
}

//actividad 3 


header("Content-Type: application/json; charset=utf-8");


$producto = [
    "id" => 3,
    "nombre" => "Monitor",
    "precio" => 780000,
    "stock" => 6
];

$idBuscado = 3;


if ($idBuscado === $producto["id"]) {
    
    http_response_code(200);
    echo json_encode($producto);
} else {
  
    http_response_code(404);
    echo json_encode([
        "mensaje" => "El producto solicitado no existe"
    ]);
}

