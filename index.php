<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Creador de Horarios de Clases</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://cdn.jsdelivr.net/npm/html5shiv@3.7.3/dist/html5shiv.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/respond.js@1.4.2/dest/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
      

     <!-- Dias de la semana -->
     <div id="diassemana" class="panel panel-default">
        <input type="text" id="firstData">
       <div class="panel-body text-center">
          <label class="titleLabel">Titulo para el Horario</label>
          <input id="horarioTitleName" type="text" name="titulo" class="form-control text-center">
          <p></p>
          <label class="titleLabel">Selecciona los Dias de la Semana</label>
          <p></p>
          <div id="selectDays" class="btn-group" role="group">
            <a id="dayweek1" data-id="1" class="btn btn-default">Lunes</a>
            <a id="dayweek2" data-id="2" class="btn btn-default">Martes</a>
            <a id="dayweek3" data-id="3" class="btn btn-default">Miercoles</a>
            <a id="dayweek4" data-id="4" class="btn btn-default">Jueves</a>
            <a id="dayweek5" data-id="5" class="btn btn-default">Viernes</a>
            <a id="dayweek6" data-id="6" class="btn btn-default">Sabado</a>
            <a id="dayweek7" data-id="7" class="btn btn-default">Domingo</a>
          </div>
          <p></p>
          <p><a class="slctall">Seleccionar todos los dias.</a></p>
          <button class="btn btn-lg btn-primary" onclick="firstStep();">Continuar</button>

       </div>
     </div>
     <!-- /Dias de la semana -->

      <!-- Eleccion de Horario -->
     <div id="horainterval" class="panel panel-default">
       <div class="panel-body text-center">
          <label class="titleLabel">Seleccionar Horas e Intervalos</label>

          <p></p>
          <div class="borderhours col-md-6 text-center">
            <div class="border-inset">
              <span>Hora Inicio</span>
              <input type="text" id="initialH" class="form-control text-center">
              <p></p>
            </div>
          </div>

          <div class="borderhours col-md-6 text-center">
            <div class="border-inset">
              <span>Hora Final</span>
              <input type="text" id="finalH" class="form-control text-center">
              <p></p>
            </div>
          </div>

          <div class="borderhours col-md-6 text-center">
            <div class="border-inset">
              <span>Intervalos de tiempo</span>
              <select id="selectorH" class="form-control">
                  <option value="15">15 Minutos</option>
                  <option value="30">30 Minutos</option>
                  <option value="45">45 Minutos</option>
                  <option value="60">1 Hora</option>
                  <option value="120">2 Horas</option>
              </select>
              <p></p>
            </div>
          </div>

          <div class="borderhours col-md-6 text-center">
              <br>
              <button onclick="CreateTable();" class="btn btn-block btn-lg btn-warning">Continuar</button>
              <p></p>
          </div>
       </div>
     </div>
      <!-- /Eleccion de Horario -->

      <!-- Tabla Creada -->
      <div id="resulTable" class="container"></div>
      <!-- /Tabla Creada -->

      <div id="TransformTable"></div>



<!-- append modal set data -->
<div class="modal fade" id="DataEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div id="minidialog" class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close canceltask" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">
          <i class="fa-thin fa-xmark"></i>
        </span></button>
        <h4 class="modal-title text-center" id="myModalLabel"> Agregar Tarea</h4>
      </div>
      <div class="modal-body">
        
        <form id="taskfrm">
           <label>Tarea</label>
           <input class="form-control" type="text" id="nametask" >
           <p></p>
           <label>Color:</label>
           <select class="form-control" id="idcolortask">
              <option value="purple-label">Purpura</option>
              <option value="red-label">Rojo</option>
              <option value="blue-label">Azul</option>
              <option value="pink-label">Rosa</option>
              <option value="green-label">Verde</option>
           </select> 
          <input id="tede" type="hidden" name="tede" >
        </form>

      </div>
      <div id="taskfootermodal" class="modal-footer">
          <div class="btn-group" role="group" aria-label="...">
              <button type="button" class="savetask btn btn-success"><i class="fa fa-floppy-o"></i> Guardar</button>
              <button type="button" class="canceltask btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
          </div>
      </div>
    </div>
  </div>
</div>
<!-- append modal set data -->

    </div>
    <div id="loadWait">
      <p><h2>Creando Archivo PDF</h2>
       <div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
      </p>
    </div>
    <div id="footer">By @alejandroceo / Derechos Reservados</div>
    <script src="assets/js/jquery-1.12.4.min.js"></script>
    <script src="assets/js/bootstrap.min.js" ></script>
    <script src="assets/js/moment-with-locales.min.js"></script>
    <script src="assets/js/bootstrap-datetimepicker.min.js"></script>
    <script src="assets/js/script.js" ></script>
  </body>
</html>