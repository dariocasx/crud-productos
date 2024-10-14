<?php

namespace App\Models;

use Illuminate\Support\Facades\File;

class Producto
{
    private static $rutaArchivo = 'productos.json';

    //obtiene todos los productos
    public static function obtenerTodos()
    {
        // Verifica si el archivo existe antes de intentar leerlo
        if (!File::exists(storage_path(self::$rutaArchivo))) {
            //si no existe, crear el archivo con un array vacio
            File::put(storage_path(self::$rutaArchivo), json_encode([]));
        }    
        return json_decode(File::get(storage_path('productos.json')), true);
    }
    //obtiene un producto por ID
    public static function obtenerPorId($id)
    {
        $productos = self::obtenerTodos();
        foreach ($productos as $producto) {
            if ($producto['id'] == $id) {
                return $producto;
            }
        }
        return null;
    }
    // crea un nuevo producto
    public static function crear($datos)
    {
        $productos = self::obtenerTodos();
        $id = count($productos) > 0 ? max(array_column($productos, 'id')) + 1 : 1;        
        $nuevoProducto = [
            'id' => $id,
            'title' => $datos['title'],
            'price' => (float) $datos['price'], // Asegúrate de convertir a número
            'created_at' => now()->toDateTimeString()
        ];        
        $productos[] = $nuevoProducto;
        File::put(storage_path(self::$rutaArchivo), json_encode($productos, JSON_PRETTY_PRINT));
        return $nuevoProducto;
    }

    // actualiza un producto existente
    public static function actualizar($id, $datos)
    {
        $productos = self::obtenerTodos();
        foreach ($productos as &$producto) {
            if ($producto['id'] == $id) {
                $producto['title'] = $datos['title'];
                $producto['price'] = (float) $datos['price']; // Asegúrate de convertir a número
                File::put(storage_path(self::$rutaArchivo), json_encode($productos, JSON_PRETTY_PRINT));
                return $producto;
            }
        }
        return null;
    }

    //elimina un producto
    public static function eliminar($id)
    {
        $productos = self::obtenerTodos();
        $productosFiltrados = array_filter($productos, function($producto) use ($id) {
            return $producto['id'] != $id;
        });
        if (count($productos) === count($productosFiltrados)) {
            return false; //no encontro el producto
        }
        File::put(storage_path(self::$rutaArchivo), json_encode(array_values($productosFiltrados), JSON_PRETTY_PRINT));
        return true; //producto eliminado
    }
}
