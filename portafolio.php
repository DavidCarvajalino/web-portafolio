<?php include("cabecera.php");?>
<?php include("conexion.php");?>

<?php

if($_POST){

    //print_r($_POST);
    
    $nombre= $_POST ['nombre'];
    $descripcion= $_POST ['descripcion'];
    $fecha= new DateTime();
    $imagen=$fecha->getTimestamp()."_". $_FILES ['archivo']['name'];
    $imagenTemp=$_FILES ['archivo']['tmp_name'];
    move_uploaded_file($imagenTemp,"imagenes/".$imagen);

    $objConexion= new conexion();
    $sql="INSERT INTO `proyectos` (`id`, `nombre`, `imagen`, `descripcion`) VALUES (NULL, '$nombre', '$imagen', '$descripcion');";
    $objConexion->ejecutar($sql);
    header("location:portafolio.php");
    
}
if($_GET){
    
    $id=($_GET)['borrar']; 
    $objConexion= new conexion();
    $imagen=$objConexion->consultar("SELECT imagen FROM `proyectos` WHERE  id=".$id);
    unlink("imagenes/".$imagen[0]['imagen']);
    $sql="DELETE FROM proyectos WHERE `proyectos`.`id` = ".$id;
    $objConexion->ejecutar($sql);
    header("location:portafolio.php");
}

$objConexion= new conexion();
$proyectos= $objConexion->consultar("SELECT * FROM `proyectos`");

?>

<br>

<div class="container">
<div class="row">
    <div class="col-4">
            
        <div class="card">
            <div class="card-header">Datos del proyecto</div>
            <div class="card-body">
                   
                <form action="portafolio.php" method="post" enctype="multipart/form-data">
                    
                    <strong>Nombre del Proyecto:</strong>  <input required class="form-control" type="text" name="nombre" id="">
                     <br>
                    <strong>Imagen del Proyecto:</strong>  <input required class="form-control" type="file" name="archivo" id="">
                    <br>
                    <strong>Descripción:</strong> 
                    <textarea required class="form-control" name="descripcion" id="" rows="3"></textarea>
                    <br>
                    <button class="btn btn-success" type="submit">Enviar información</button>
                    
                </form>
            
            </div>
        </div>
        </div>
            <div class="col-8">
            
            <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Imagen</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach($proyectos as $proyecto){?>
                                <tr>
                                    <td><?php  echo ($proyecto['id'] ) ?></td>
                                    <td><?php  echo ($proyecto['nombre'] ) ?></td>
                                    <td>
                                       <img width="100" src="imagenes/<?php  echo ($proyecto['imagen'] ) ?>" alt="" srcset=""> 
                                    </td>
                                    <td><?php  echo ($proyecto['descripcion'] ) ?></td>
                                    <td><a class="btn btn-primary" href="?borrar= <?php echo $proyecto['id'];?>">Eliminar</a
                                    >
                                    </td>
                                </tr>
                            <?php  }?>
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
</div>


<?php include("pie.php");?>
