<?php

return [
    'GET' => [
        '/api/productos' => ['JsonController', 'productos'],
        '/api/clientes' => ['JsonController', 'clientes'],
        '/api/proveedores' => ['JsonController', 'proveedores'],
        '/api/ciudades' => ['JsonController', 'ciudades'],
        '/api/categorias' => ['JsonController', 'categorias'],
        '/api/compras' => ['JsonController', 'compras'],
        '/api/tipos-producto' => ['JsonController', 'tiposProducto'],
        '/api' => ['JsonController', 'mostrarVista'],
        '/json' => ['JsonController', 'mostrar'],
        '/' => ['TiendaController', 'index'],

        '/productos' => ['ProductoController', 'index'],
        '/productos/editar' => ['ProductoController', 'editar'],

        '/clientes' => ['ClientesController', 'index'],
        '/clientes/editar' => ['ClientesController', 'editar'],

        '/proveedores' => ['ProveedorController', 'index'],
        '/proveedores/editar' => ['ProveedorController', 'editar'],

        '/ciudades' => ['CiudadController', 'index'],
        '/ciudades/editar' => ['CiudadController', 'editar'],

        '/categorias' => ['CategoriaController', 'index'],
        '/categorias/editar' => ['CategoriaController', 'editar'],

        '/compras' => ['CompraController', 'index'],
        '/compras/editar' => ['CompraController', 'editar']
    ],
    'POST' => [
        '/' => ['TiendaController', 'procesarCarrito'],

        '/api/productos/crear' => ['ProductoController', 'crear'],
        '/api/productos/actualizar' => ['ProductoController', 'actualizar'],
        '/api/productos/eliminar' => ['ProductoController', 'eliminar'],
        '/api/clientes/crear' => ['ClientesController', 'crear'],
        '/api/clientes/actualizar' => ['ClientesController', 'actualizar'],
        '/api/clientes/eliminar' => ['ClientesController', 'eliminar'],
        '/api/proveedores/crear' => ['ProveedorController', 'crear'],
        '/api/proveedores/actualizar' => ['ProveedorController', 'actualizar'],
        '/api/proveedores/eliminar' => ['ProveedorController', 'eliminar'],
        '/api/ciudades/crear' => ['CiudadController', 'crear'],
        '/api/ciudades/actualizar' => ['CiudadController', 'actualizar'],
        '/api/ciudades/eliminar' => ['CiudadController', 'eliminar'],
        '/api/categorias/crear' => ['CategoriaController', 'crear'],
        '/api/categorias/actualizar' => ['CategoriaController', 'actualizar'],
        '/api/categorias/eliminar' => ['CategoriaController', 'eliminar'],
        '/api/compras/crear' => ['CompraController', 'crear'],
        '/api/compras/actualizar' => ['CompraController', 'actualizar'],
        '/api/compras/eliminar' => ['CompraController', 'eliminar'],

        '/productos/crear' => ['ProductoController', 'crear'],
        '/productos/actualizar' => ['ProductoController', 'actualizar'],
        '/productos/eliminar' => ['ProductoController', 'eliminar'],

        '/clientes/crear' => ['ClientesController', 'crear'],
        '/clientes/actualizar' => ['ClientesController', 'actualizar'],
        '/clientes/eliminar' => ['ClientesController', 'eliminar'],

        '/proveedores/crear' => ['ProveedorController', 'crear'],
        '/proveedores/actualizar' => ['ProveedorController', 'actualizar'],
        '/proveedores/eliminar' => ['ProveedorController', 'eliminar'],

        '/ciudades/crear' => ['CiudadController', 'crear'],
        '/ciudades/actualizar' => ['CiudadController', 'actualizar'],
        '/ciudades/eliminar' => ['CiudadController', 'eliminar'],

        '/categorias/crear' => ['CategoriaController', 'crear'],
        '/categorias/actualizar' => ['CategoriaController', 'actualizar'],
        '/categorias/eliminar' => ['CategoriaController', 'eliminar'],

        '/compras/crear' => ['CompraController', 'crear'],
        '/compras/actualizar' => ['CompraController', 'actualizar'],
        '/compras/eliminar' => ['CompraController', 'eliminar']
    ]
];
