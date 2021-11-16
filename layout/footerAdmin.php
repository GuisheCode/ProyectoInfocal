<!--===== MAIN JS =====-->
<script src="../../../assets/main.js"></script>
<script src="../../../assets/app.js"></script>
<script>
        $('#tabla').DataTable();
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
            $("#fila").load(" #fila");
            modal_container.classList.remove('show')
            modal_success.classList.add('show');
            setTimeout(function(){ 
                modal_success.classList.remove('show');
                // $("#modales").load(" #modales");
            }, 1800);
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
            $("#fila").load(" #fila");
            modal_container1.classList.remove('show')
            modal_success1.classList.add('show');
            setTimeout(function(){ 
                modal_success1.classList.remove('show');
                // $("#modales").load(" #modales");
            }, 1800);
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
    function capturar() 
    {  
        console.log("si captura");
    }
</script>
</body>
</html>