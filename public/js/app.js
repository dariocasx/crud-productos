$(document).ready(function() {
    loadProducts();

    // Cargar productos
    function loadProducts() {
        $.ajax({
            url: '/productos/list',
            method: 'GET',
            success: function(data) {
                renderProducts(data);
            },
            error: function() {
                alert('Error al cargar los productos. Intenta nuevamente.');
            }
        });
    }

    function renderProducts(products) {
        let table = $('#productTable tbody');
        table.empty();
      
        if (products.length === 0) {
          // Si el arreglo de productos está vacío, mostramos un mensaje
          table.append('<tr><td colspan="5">No hay productos disponibles.</td></tr>');
        } else {
          // Si hay productos, iteramos y renderizamos la tabla
          products.forEach(product => {
            let row = `<tr data-id="${product.id}">
              <td>${product.id}</td>
              <td>${product.title}</td>
              <td>${product.price}</td>
              <td>${product.created_at}</td>
              <td>
                <button class="edit">Editar</button>
                <button class="delete">Eliminar</button>
              </td>
            </tr>`;
            table.append(row);
          });
        }
      }

    // Evento para agregar un producto
    $('#add-product').on('click', function () {
        const title = prompt("Ingrese el título del producto:");
        const price = prompt("Ingrese el precio del producto:");

        if (title && price) {
            $.ajax({
                url: '/productos',
                method: 'POST',
                data: { title, price, _token: $('input[name="_token"]').val() },
                success: function (data) {
                    alert('Producto agregado con éxito.');
                    loadProducts(); // Recargar la lista de productos
                },
                error: function (error) {
                    alert('Error al agregar el producto: ' + error.responseJSON.error);
                }
            });
        } else {
            alert('El título y el precio son obligatorios.');
        }
    });

    // Evento para editar un producto
    $('#productTable').on('click', '.edit', function () {
        const row = $(this).closest('tr');
        const id = row.data('id');
        const title = prompt("Ingrese el nuevo título del producto:", row.find('td:eq(1)').text());
        const price = prompt("Ingrese el nuevo precio del producto:", row.find('td:eq(2)').text());

        if (title && price) {
            $.ajax({
                url: '/productos/' + id,
                method: 'PUT',
                data: { title, price, _token: $('input[name="_token"]').val() },
                success: function () {
                    alert('Producto editado con éxito.');
                    loadProducts(); // Recargar la lista de productos
                },
                error: function (error) {
                    alert('Error al editar el producto: ' + error.responseJSON.error);
                }
            });
        } else {
            alert('El título y el precio son obligatorios.');
        }
    });

    // Evento para eliminar un producto
    $('#productTable').on('click', '.delete', function () {
        const row = $(this).closest('tr');
        const id = row.data('id');
        
        if (confirm("¿Estás seguro de que deseas eliminar este producto?")) {
            $.ajax({
                url: '/productos/' + id,
                method: 'DELETE',
                data: { _token: $('input[name="_token"]').val() },
                success: function () {
                    alert('Producto eliminado con éxito.');
                    loadProducts(); // Recargar la lista de productos
                },
                error: function (error) {
                    alert('Error al eliminar el producto: ' + error.responseJSON.error);
                }
            });
        }
    });
});
