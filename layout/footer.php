<!--===== MAIN JS =====-->
<script src="../../../assets/main.js"></script>
<script src="../../../assets/app.js"></script>
<script>
        $(document).ready( function () {
    $('#tabla_actual').DataTable({
    "language":{
    "decimal":        "",
    "emptyTable":     "No hay datos para mostrar",
    "info":           "Viendo _START_ de _END_ de _TOTAL_ entradas",
    "infoEmpty":      "Viendo 0 de 0 de 0 entradas",
    "infoFiltered":   "(filtered from _MAX_ total entries)",
    "infoPostFix":    "",
    "thousands":      ",",
    "lengthMenu":     "Ver _MENU_ entradas",
    "loadingRecords": "Cargando...",
    "processing":     "Procesando...",
    "search":         "Buscar:",
    "zeroRecords":    "No se encontraron resultados",
    "paginate": {
        "first":      "First",
        "last":       "Last",
        "next":       "Siguiente",
        "previous":   "Anterior"
    },
    "aria": {
        "sortAscending":  ": activate to sort column ascending",
        "sortDescending": ": activate to sort column descending"
    }
}
    });
} );
    </script>
    <script>
        $(document).ready( function () {
    $('#tabla_manana').DataTable({
    "language":{
    "decimal":        "",
    "emptyTable":     "No hay datos para mostrar",
    "info":           "Viendo _START_ de _END_ de _TOTAL_ entradas",
    "infoEmpty":      "Viendo 0 de 0 de 0 entradas",
    "infoFiltered":   "(filtered from _MAX_ total entries)",
    "infoPostFix":    "",
    "thousands":      ",",
    "lengthMenu":     "Ver _MENU_ entradas",
    "loadingRecords": "Cargando...",
    "processing":     "Procesando...",
    "search":         "Buscar:",
    "zeroRecords":    "No se encontraron resultados",
    "paginate": {
        "first":      "First",
        "last":       "Last",
        "next":       "Siguiente",
        "previous":   "Anterior"
    },
    "aria": {
        "sortAscending":  ": activate to sort column ascending",
        "sortDescending": ": activate to sort column descending"
    }
}
    });
} );
    </script>
    <script>
        $(document).ready( function () {
    $('#tabla_tarde').DataTable({
    "language":{
    "decimal":        "",
    "emptyTable":     "No hay datos para mostrar",
    "info":           "Viendo _START_ de _END_ de _TOTAL_ entradas",
    "infoEmpty":      "Viendo 0 de 0 de 0 entradas",
    "infoFiltered":   "(filtered from _MAX_ total entries)",
    "infoPostFix":    "",
    "thousands":      ",",
    "lengthMenu":     "Ver _MENU_ entradas",
    "loadingRecords": "Cargando...",
    "processing":     "Procesando...",
    "search":         "Buscar:",
    "zeroRecords":    "No se encontraron resultados",
    "paginate": {
        "first":      "First",
        "last":       "Last",
        "next":       "Anterior",
        "previous":   "Siguiente"
    },
    "aria": {
        "sortAscending":  ": activate to sort column ascending",
        "sortDescending": ": activate to sort column descending"
    }
}
    });
} );
    </script>
    <script>
        $(document).ready( function () {
    $('#tabla_noche').DataTable({
    "language":{
    "decimal":        "",
    "emptyTable":     "No hay datos para mostrar",
    "info":           "Viendo _START_ de _END_ de _TOTAL_ entradas",
    "infoEmpty":      "Viendo 0 de 0 de 0 entradas",
    "infoFiltered":   "(filtered from _MAX_ total entries)",
    "infoPostFix":    "",
    "thousands":      ",",
    "lengthMenu":     "Ver _MENU_ entradas",
    "loadingRecords": "Cargando...",
    "processing":     "Procesando...",
    "search":         "Buscar:",
    "zeroRecords":    "No se encontraron resultados",
    "paginate": {
        "first":      "First",
        "last":       "Last",
        "next":       "Seguiente",
        "previous":   "Anterior"
    },
    "aria": {
        "sortAscending":  ": activate to sort column ascending",
        "sortDescending": ": activate to sort column descending"
    }
}
    });
} );
    </script>
    <script>
        $(document).ready( function () {
    $('#tabla_clases').DataTable({
    "language":{
    "decimal":        "",
    "emptyTable":     "No hay datos para mostrar",
    "info":           "Viendo _START_ de _END_ de _TOTAL_ entradas",
    "infoEmpty":      "Viendo 0 de 0 de 0 entradas",
    "infoFiltered":   "(filtered from _MAX_ total entries)",
    "infoPostFix":    "",
    "thousands":      ",",
    "lengthMenu":     "Ver _MENU_ entradas",
    "loadingRecords": "Cargando...",
    "processing":     "Procesando...",
    "search":         "Buscar:",
    "zeroRecords":    "No se encontraron resultados",
    "paginate": {
        "first":      "First",
        "last":       "Last",
        "next":       "Siguiente",
        "previous":   "Anterior"
    },
    "aria": {
        "sortAscending":  ": activate to sort column ascending",
        "sortDescending": ": activate to sort column descending"
    }
}
    });
} );
    </script>



<script>
    let abrir=document.getElementById('abrirModal');
    let modal_container=document.getElementById('modal-container');
    let cerrar= document.getElementById(cerrarModal);
    let modal_success= document.getElementById('modal-container-success');
    
   function capturarIdMateria(e)
 {
    idRecurso = e; 
    //document.getElementById("valor").value=value;
    console.log(idRecurso)
    modal_container.classList.add('show');
 }
 $('#quitarRecurso').on('click', function(e){
     e.preventDefault();
        let ruta ="idClase="+idRecurso;
        $.ajax({
            url:'../../../includes/claseTerminada.php',
            type:'POST',
            data: ruta,
        })
        .done(function (res) {
            $('#respuesta').html(res);
            // $("#fila").load(" #fila");
            modal_container.classList.remove('show')
            modal_success.classList.add('show');
            setTimeout(function(){ 
                modal_success.classList.remove('show');
                // $("#modales").load(" #modales");
                window.location.reload();
            }, 1500);
        })
        .fail(function () {
            console.log("error");
        })
        .always(function () {
            console.log("complete")
        });
        
    });
//     cerrar.addEventListener('click',()=>{
//     modal_container.classList.remove('show');
// });
$('#cerrarModal').on('click', function(e){
        e.preventDefault();
        modal_container.classList.remove('show');
    })
$('#modalContainer').on('click',function(){
    modal_container.classList.remove('show');
})
modal_container.addEventListener('click', e=> {
        if (e.target === modal_container) modal_container.classList.remove('show');; 
    });
</script>

<script>
    let abrir1=document.getElementById('abrirModal1');
    let modal_container1=document.getElementById('modal-container1');
    let cerrar1= document.getElementById(cerrarModal1);
    let modal_success1= document.getElementById('modal-container-success1');
    
   function capturarIdMateriaxd(e)
 {
    id = e; 
    //document.getElementById("valor").value=value;
    console.log(id)
    modal_container1.classList.add('show');
 }
 $('#quitarRecurso1').on('click', function(e){
     e.preventDefault();
        let ruta ="idClase="+id;
        $.ajax({
            url:'../../../includes/claseIniciada.php',
            type:'POST',
            data: ruta,
        })
        .done(function (res1) {
            $('#respuesta1').html(res1);
            // $("#fila").load(" #fila");
            modal_container1.classList.remove('show')
            modal_success1.classList.add('show');
            setTimeout(function(){ 
                modal_success1.classList.remove('show');
                // $("#modales").load(" #modales");
                window.location.reload();
            }, 1500);
        })
        .fail(function () {
            console.log("error");
        })
        .always(function () {
            console.log("complete")
        });
        
    });
//     cerrar.addEventListener('click',()=>{
//     modal_container.classList.remove('show');
// });
$('#cerrarModal1').on('click', function(e){
        e.preventDefault();
        modal_container1.classList.remove('show');
    })
$('#modalContainer1').on('click',function(){
    modal_container1.classList.remove('show');
})
modal_container1.addEventListener('click', e=> {
        if (e.target === modal_container1) modal_container1.classList.remove('show');; 
    });
</script>


<script>
    let abrir2=document.getElementById('abrirModal2');
    let modal_container2=document.getElementById('modal-container2');
    let cerrar2= document.getElementById(cerrarModal2);
    let modal_success2= document.getElementById('modal-container-success2');
    
   function capturar_id_uso(e)
 {
    id2 = e; 
    //document.getElementById("valor").value=value;
    console.log(id2)
    modal_container2.classList.add('show');
 }
 $('#quitarRecurso2').on('click', function(e){
     e.preventDefault();
        let ruta ="id_uso="+id2;
        $.ajax({
            url:'../../../includes/salida_equipo.php',
            type:'POST',
            data: ruta,
        })
        .done(function (res) {
            $('#respuesta2').html(res);
            // $("#fila").load(" #fila");
            modal_container2.classList.remove('show')
            modal_success2.classList.add('show');
            setTimeout(function(){ 
                modal_success2.classList.remove('show');
                // $("#modales").load(" #modales");
                window.location.reload();
            }, 1500);
        })
        .fail(function () {
            console.log("error");
        })
        .always(function () {
            console.log("complete")
        });
        
    });
//     cerrar.addEventListener('click',()=>{
//     modal_container.classList.remove('show');
// });
$('#cerrarModal2').on('click', function(e){
        e.preventDefault();
        modal_container2.classList.remove('show');
    })
$('#modalContainer2').on('click',function(){
    modal_container2.classList.remove('show');
})
modal_container2.addEventListener('click', e=> {
        if (e.target === modal_container2) modal_container2.classList.remove('show');; 
    });
</script>

<!-- confirmar la devolucion de equipo -->
<script>
    let abrir3=document.getElementById('abrirModal3');
    let modal_container3=document.getElementById('modal-container3');
    let cerrar3= document.getElementById(cerrarModal3);
    let modal_success3= document.getElementById('modal-container-success3');
    
   function id_equipo_devolucion(e)
 {
    id_equipo3 = e; 
    //document.getElementById("valor").value=value;
    console.log(id_equipo3)
    modal_container3.classList.add('show');
 }
 $('#quitarRecurso3').on('click', function(e){
     e.preventDefault();
        let ruta ="id_uso="+id_equipo3;
        $.ajax({
            url:'../../../includes/entrada_equipo.php',
            type:'POST',
            data: ruta,
        })
        .done(function (res) {
            $('#respuesta3').html(res);
            // $("#fila").load(" #fila");
            modal_container3.classList.remove('show')
            modal_success3.classList.add('show');
            setTimeout(function(){ 
                modal_success3.classList.remove('show');
                // $("#modales").load(" #modales");
                window.location.reload();
            }, 1500);
        })
        .fail(function () {
            console.log("error");
        })
        .always(function () {
            console.log("complete")
        });
        
    });
//     cerrar.addEventListener('click',()=>{
//     modal_container.classList.remove('show');
// });
$('#cerrarModal3').on('click', function(e){
        e.preventDefault();
        modal_container3.classList.remove('show');
    })
$('#modalContainer3').on('click',function(){
    modal_container3.classList.remove('show');
})
modal_container3.addEventListener('click', e=> {
        if (e.target === modal_container3) modal_container3.classList.remove('show');; 
    });
</script>
</body>
</html>