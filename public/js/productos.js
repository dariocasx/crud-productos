$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //limpiamos el formulario 
    $('#btnCrearProducto').on('click', function() {
        $('#crearTitulo').val('');  // Limpia el campo de título
        $('#crearPrecio').val('');  // Limpia el campo de precio
    });

    //carga lods productos en la tabla
    $('#tabla-productos').DataTable({
        ajax: {
            url: '/api/productos',
            dataSrc: ''
        },
        columns: [
            { data: 'id' },
            { data: 'title' },
            { data: 'price' },
            { data: 'created_at' },
            {
                data: null,
                render: function(data) {
                    let botones = '';
                    if (userRole === 'admin') {
                        botones = `
                            <button class="btn btn-primary" onclick="editarProducto(${data.id})">Editar</button>
                            <button class="btn btn-danger" onclick="eliminarProducto(${data.id})">Eliminar</button>
                        `;
                    } else {
                        botones = 'Solo lectura';
                    }
                    return botones;
                }
            }
        ],
        //agrega un margen al buscador
        dom: '<"top"f>rt<"bottom"lp><"clear">', // 'f' es el filtro/buscador
        language: {
            //para que el datatable este en español, no funcion con el CDN por problema de CORS
            url: "/js/spanish.json"
        },
        initComplete: function() {
            $('.dataTables_filter').css('margin-bottom', '20px');
        }
    });

    //crea el producto
    $('#crearProductoForm').on('submit', function(e) {
        e.preventDefault();
        const titulo = $('#crearTitulo').val();
        const precio = $('#crearPrecio').val();
        if (titulo && precio) {
            $.ajax({
                url: '/api/productos',
                method: 'POST',
                data: $(this).serialize(),
                success: function() {
                    alert('Producto creado');
                    $('#crearProductoModal').modal('hide');
                    $('#tabla-productos').DataTable().ajax.reload();
                },
                error: function(error) {
                    alert('Error al crear el producto.');
                }
            });
        }
    });

    //edita producto
    $('#editarProductoForm').on('submit', function(e) {
        e.preventDefault();
        const id = $('#editarProductoId').val();
        const titulo = $('#editarTitulo').val();
        const precio = $('#editarPrecio').val();
        if (titulo && precio) {
            $.ajax({
                url: '/api/productos/' + id,
                method: 'PUT',
                data: $(this).serialize(),
                success: function() {
                    alert('Producto editado con éxito.');
                    $('#editarProductoModal').modal('hide');
                    $('#tabla-productos').DataTable().ajax.reload();
                },
                error: function(error) {
                    alert('Error al editar el producto.');
                }
            });
        }
    });

    //carga detalles del producto en el modal de editar
    window.editarProducto = function(id) {
        $.ajax({
            url: '/api/productos/' + id,
            method: 'GET',
            success: function(producto) {
                $('#editarProductoId').val(producto.id);
                $('#editarTitulo').val(producto.title);
                $('#editarPrecio').val(producto.price);
                $('#editarProductoModal').modal('show');
            },
            error: function() {
                alert('Error al cargar los detalles del producto.');
            }
        });
    };
});

//elimina producto
function eliminarProducto(id) {
    $.ajax({
        url: '/api/productos/' + id,
        type: 'DELETE',
        success: function() {
            alert('Producto eliminado con exito.');
            $('#tabla-productos').DataTable().ajax.reload();
        },
        error: function() {
            alert('Error al eliminar el producto.');
        }
    });
}
