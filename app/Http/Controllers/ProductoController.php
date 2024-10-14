<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\Log;
use Exception;

class ProductoController extends Controller
{
    
    public function index()
    {
        $usuario = session('usuario'); //obtiene usuario de la sesion
        if ($usuario) {
            return view('productos.index', compact('usuario'));return view('productos.index', ['usuario' => e($usuario)]); //escapa la salida del usuario
        } else {
            return redirect('/login');
        }
    }

    public function obtenerProductos()
    {
        try {
            $productos = Producto::obtenerTodos();
            return response()->json($productos);
        } catch (Exception $e) {
            Log::error('Error al obtener productos', [
                'fecha' => now(),
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => 'Error al obtener productos'], 500);
        }
    }
    
    public function obtenerProducto($id)
    {
        try {
            //busca el producto por ID
            $producto = Producto::obtenerPorId($id);
            //si el producto no existe, devuelve un error
            if (!$producto) {
                Log::error('Producto no encontrado', [
                    'fecha' => now(),
                    'id' => $id
                ]);
                return response()->json(['error' => 'Producto no encontrado'], 404);
            }
            //devuelve la respuesta con los datos del producto
            Log::info('Producto obtenido', [
                'fecha' => now(),
                'id' => $id,
                'producto' => $producto
            ]);
            return response()->json($producto, 200);
        } catch (Exception $e) {
            Log::error('Error al obtener producto', [
                'fecha' => now(),
                'id' => $id,
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => 'Error al obtener producto'], 500);
        }
    }

    public function guardar(Request $request)
    {
        //validacion de los datos
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);
        try {
            //sanitizacipn de la entrada
            $tituloSanitizado = filter_var($request->input('title'), FILTER_SANITIZE_STRING);
            $precioSanitizado = filter_var($request->input('price'), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            //crea el producto
            $nuevoProducto = Producto::crear([
                'title' => $tituloSanitizado,
                'price' => $precioSanitizado,
            ]);
            if (!$nuevoProducto) {
                //registra el err en el log
                Log::error('Error al guardar el producto', [
                    'fecha' => now(),
                    'datos' => $request->all()
                ]);
                return response()->json(['error' => 'Error al guardar el producto'], 500);
            }
            //registra la accion en el log
            Log::info('Producto creado exitosamente', [
                'fecha' => now(),
                'producto' => $nuevoProducto,
                'id' => $nuevoProducto->id ?? 'ID no disponible'
            ]);
            return response()->json($nuevoProducto, 201);
        } catch (Exception $e) {
            Log::error('Error al guardar el producto', [
                'fecha' => now(),
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => 'Error al guardar el producto'], 500);
        }
    }    
    public function editar(Request $request, $id)
    {
        //valida los datos del producto
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);
        try {
             // sanitizacion de la entrada
             $tituloSanitizado = filter_var($request->input('title'), FILTER_SANITIZE_STRING);
             $precioSanitizado = filter_var($request->input('price'), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            // busca el producto por ID
            $producto = Producto::obtenerPorId($id);
            //si el producto no existe, devuelve un error
            if (!$producto) {
                //eegistra en el log el intento de editar un producto inexistente
                Log::error('Producto no encontrado para editar', [
                    'fecha' => now(),
                    'id' => $id
                ]);
                return response()->json(['error' => 'Producto no encontrado'], 404);
            }
            //actualiza el producto
            $productoActualizado = Producto::actualizar($id, [
                'title' => $tituloSanitizado,
                'price' => $precioSanitizado,
            ]);
            if (!$productoActualizado) {
                // registra el error en el log
                Log::error('Error al editar el producto', [
                    'fecha' => now(),
                    'producto' => $producto
                ]);
                return response()->json(['error' => 'Error al editar el producto'], 500);
            }
            //registra la accion exitosa en el log
            Log::info('Producto editado exitosamente', [
                'fecha' => now(),
                'producto' => $producto
            ]);
            //devuelve la respuesta con los datos actualizados del producto
            return response()->json($producto, 200);
        } catch (Exception $e) {
            Log::error('Error al editar el producto', [
                'fecha' => now(),
                'id' => $id,
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => 'Error al editar el producto'], 500);
        }
    }
    //elimina un producto
    public function eliminar($id)
    {
        try {
            $resultado = Producto::eliminar($id);
            if (!$resultado) {
                Log::error('Producto no encontrado para eliminar', [
                    'fecha' => now(),
                    'id' => $id
                ]);
                return response()->json(['error' => 'Producto no encontrado'], 404);
            }
            Log::info('Producto eliminado exitosamente', [
                'fecha' => now(),
                'id' => $id
            ]);
            return response()->json(['mensaje' => 'Producto eliminado'], 200);
        } catch (Exception $e) {
            Log::error('Error al eliminar el producto', [
                'fecha' => now(),
                'id' => $id,
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => 'Error al eliminar el producto'], 500);
        }
    }
}
