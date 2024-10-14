<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Producto;

class ProductoControllerTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        //desactiva la verificación CSRF para las pruebas
        $this->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
    }
    //simular un usuario admin
    protected function loginAsAdmin()
    {
        session(['usuario' => ['username' => 'admin', 'role' => 'admin']]);
    }
    //simular un usuario regular
    protected function loginAsUser()
    {
        session(['usuario' => ['username' => 'user1', 'role' => 'user']]);
    }
    /** @test */
    public function puede_obtener_todos_los_productos_por_endpoint()
    {
        $this->loginAsAdmin(); //inicia sesion como admin

        //simular 2 productos
        Producto::crear(['title' => 'Producto 1', 'price' => 100]);
        Producto::crear(['title' => 'Producto 2', 'price' => 200]);
        $response = $this->getJson('/api/productos');
        $response->assertStatus(200)
                 ->assertJsonCount(2); //verifica si hay 2 productos
    }

    /** @test */
    public function puede_guardar_un_nuevo_producto_por_endpoint()
    {
        $this->loginAsAdmin(); //inicia sesion como admin
        $datosProducto = [
            'title' => 'Producto 3',
            'price' => 300,
        ];
        $response = $this->postJson('/api/productos', $datosProducto);
        $response->assertStatus(201) //cdigo de respuesta al crear
                 ->assertJsonFragment($datosProducto); //asegura que el producto fue creado
    }
    /** @test */
    public function puede_eliminar_un_producto_por_endpoint()
    {
        $this->loginAsAdmin(); //inicia sesion como admin
        //crea un producto para luego eliminarlo
        $producto = Producto::crear(['title' => 'Producto a eliminar', 'price' => 100]);
        $this->assertNotNull($producto['id']);
        $response = $this->deleteJson("/api/productos/{$producto['id']}");
        $response->assertStatus(200); //aseguramos que la respuesta sea exitosa
        $productoEliminado = Producto::obtenerPorId($producto['id']);
        $this->assertNull($productoEliminado); //el producto debería estar eliminado
    }

    /** @test */
    public function un_usuario_normal_no_puede_guardar_un_producto()
    {
        $this->loginAsUser(); //inicia sesion como usuario normal
        $datosProducto = [
            'title' => 'Producto 4',
            'price' => 400,
        ];
        $response = $this->postJson('/api/productos', $datosProducto);
        $response->assertStatus(403); //acceso denegado para usuarios sin permiso
    }

    /** @test */
    public function un_usuario_normal_no_puede_eliminar_un_producto()
    {
        $this->loginAsUser(); //inicia sesion como usuario normal
        //se crea un producto
        $producto = Producto::crear(['title' => 'Producto a eliminar', 'price' => 100]);
        $response = $this->deleteJson("/api/productos/{$producto['id']}");
        $response->assertStatus(403); //acceso denegado para usuarios sin permiso
    }
}
