<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lista de Productos</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        const userRole = "{{ session('usuario.role', 'guest') }}"; // 'guest' si no hay usuario autenticado
    </script>
    <script src="{{ asset('js/productos.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container">
        <div  style="margin-top: 30px; position: absolute">
            <h1>Lista de Productos</h1>
            <button type="button" class="btn btn-primary" id="btnCrearProducto" data-bs-toggle="modal" data-bs-target="#crearProductoModal">
                Crear Producto
            </button>
        </div>
        <div style="text-align: right; margin-top: 10px;">
            <form action="{{ route('logout') }}" method="POST" id="logoutForm" class="d-inline">
            @csrf
                <button type="submit" class="btn btn-info">
                    <i class="bi bi-box-arrow-right" style="margin-right: 5px;"></i>
                </button>
            </form>
        </div>
        <div class="text-end espacio-table">
            <div class="usuario">
                <p>Hola, <strong>{{ session('usuario.username') }}</strong>!</p>
                <p>Rol: <strong>{{ session('usuario.role') }}</strong></p>
            </div>
        </div>
        </br>
        <table id="tabla-productos" class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Precio</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- los productos se cargaran aca mediante ajax -->
            </tbody>
        </table>
        <!-- modal para crear producto -->
        <div class="modal fade" id="crearProductoModal" tabindex="-1" aria-labelledby="crearProductoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="crearProductoModalLabel">Crear Producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="crearProductoForm">
                        @csrf
                            <div class="mb-3">
                                <label for="crearTitulo" class="form-label">Título del producto</label>
                                <input type="text" id="crearTitulo" name="title" class="form-control" placeholder="Título del producto" required>
                            </div>
                            <div class="mb-3">
                                <label for="crearPrecio" class="form-label">Precio del producto</label>
                                <input type="number" id="crearPrecio" name="price" class="form-control" placeholder="Precio del producto" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" id="crearGuardarBtn" form="crearProductoForm">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal para editar producto -->
        <div class="modal fade" id="editarProductoModal" tabindex="-1" aria-labelledby="editarProductoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editarProductoModalLabel">Editar Producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editarProductoForm">
                        @csrf
                            <input type="hidden" id="editarProductoId" name="id"> <!-- Campo oculto para el ID del producto -->
                            <div class="mb-3">
                                <label for="editarTitulo" class="form-label">Título del producto</label>
                                <input type="text" id="editarTitulo" name="title" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="editarPrecio" class="form-label">Precio del producto</label>
                                <input type="number" id="editarPrecio" name="price" class="form-control" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" id="editarGuardarBtn" form="editarProductoForm">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
