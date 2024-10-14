<?php

namespace Tests\Unit;

use App\Models\Producto;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class ProductoTest extends TestCase
{
    //configuración inicial para simular un archivo JSON
    protected function setUp(): void
    {
        parent::setUp();
        File::put(storage_path('productos.json'), json_encode([])); //empieza con un array vacio
    }

    /** @test */
    public function puede_obtener_todos_los_productos()
    {
        $productos = Producto::obtenerTodos();
        $this->assertIsArray($productos); //comprueba que retorna un array
        $this->assertEmpty($productos);   //comprueba que este vacio 
    }

    /** @test */
    public function puede_crear_un_producto()
    {
        $producto = Producto::crear([
            'title' => 'Producto de prueba',
            'price' => 100.0,
        ]);
        $this->assertNotNull($producto);  //el producto no debe ser nulo
        $this->assertEquals('Producto de prueba', $producto['title']);  //comprueba el titulo
        $this->assertEquals(100.0, $producto['price']);  //comprueba el precio
    }

    /** @test */
    public function puede_eliminar_un_producto()
    {
        //crea un producto
        $producto = Producto::crear([
            'title' => 'Producto a eliminar',
            'price' => 50.0,
        ]);
        $resultado = Producto::eliminar($producto['id']);
        $this->assertTrue($resultado);  //comprueba la eliminacion
        $productoEliminado = Producto::obtenerPorId($producto['id']);
        $this->assertNull($productoEliminado);  //verifica que el producto ya no exista
    }

    //borra despues de cada prueba
    protected function tearDown(): void
    {
        File::delete(storage_path('productos.json')); //elimina el archivo de prueba
        parent::tearDown();
    }
}
