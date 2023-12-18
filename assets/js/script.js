$(function () {
    $('#initialH').datetimepicker({
        format: 'LT'
    });
    $('#finalH').datetimepicker({
        format: 'LT'
    });
});


// Notificacion
function notification(style,text){
   $('#notification').remove();
   $('body').append('<div id="notification" class="'+style+'">'+text+'</div>').fadeIn(2000);
   setTimeout(function(){$('#notification').remove();},6000);
}

// Botones de la semana
$('#selectDays a').on('click', function(){
    var dom = $(this);
    var valor = '';
    var inpt = $('#firstData').val();
    if (dom.hasClass('btn-default')){
       dom.addClass('btn-success').removeClass('btn-default').append(' <i class="fa-thin fa-check"></i>');
       $('#firstData').val(inpt+dom.attr('data-id')+',');
    }else{
       dom.addClass('btn-default').removeClass('btn-success').find('i').remove();
       var vpre = dom.attr('data-id')+',';
       var rpl = inpt.replace(vpre, '');
       $('#firstData').val(rpl);

    }
});

$('.slctall').on('click', function(){
    var dom = $('#selectDays a').click();
});

// Contar los dias seleccionados
function firstStep(){
     var firstData = $('#firstData').val();
     var title = $('#horarioTitleName').val();
     if (firstData == ''){
           notification('danger','Debes de seleccionar al menos 1 dia de la semana para continuar.');
           return;
     }else if(title == ''){
           notification('danger','Debes de asignar un nombre para el horario.');
           return;
     }else{
           $('#diassemana').hide();
           $('#horainterval').show();
     }
}


function CreateTable(){

   var days = $('#firstData').val();
   var initial = $('#initialH').val();
   var final = $('#finalH').val();
   var minutos = $('#selectorH').val();
   var title = $('#horarioTitleName').val();
   var line = 'pro=table&days='+days+'&tiempo1='+initial+'&tiempo2='+final+'&minutos='+minutos+'&titulo='+title;
   $.ajax({
      url: 'ajax.php',
      type: 'POST',
      data: line,
      success: function(response){
        $('#horainterval').hide();
        $('#resulTable').html(response);
/*-------------------------------------------------------------------------------------*/

// Mostrar Boton Add
$(".td-line").hover(
  function() {
    $(this).find('button').show();
  },
   function() {
    $(this).find('button').hide();
  }
);

// Agregar Informacion
$('.addinfo').on('click', function(){
      var dum = $(this).attr('data-row');
      $('#DataEdit').modal('show');
      $('#tede').val(dum);
});


// Borrar la tarea
$('.delinfo').on('click', function(){
      var dum = $(this).attr('data-row');
      $('#'+dum).text('').removeClass('purple-label red-label blue-label pink-label').hide();
});

// Guardar Tarea
$('.savetask').on('click', function(){
      var tede = $('#tede').val();
      var tasker = $('#nametask').val();
      var color = $('#idcolortask option:selected').val();
      $('#DataEdit').modal('toggle');
      $('#'+tede).append('<label class="label-desc '+color+'">'+tasker+' <a class="deltasker"><i class="fa-thin fa-xmark"></i></a></label>');
      //$('#'+tede).text(tasker).addClass(color).show();
      $('#taskfrm')[0].reset();


      $('.deltasker').on('click', function(){
          var element = $(this).parent();
          element.addClass('animated bounceOut');
          setTimeout(function(){element.remove();},1000);
      });

});

$('.changethetime').on('click', function(){
     var theparent = $(this).attr('data-time');
     $('.hideedittime').hide();
     $('.timeblock').show();
     $('#parent'+theparent).hide();
     $('#edit'+theparent).show();
});

$('.savetime').on('click', function(){
     var savetime = $(this).attr('data-save');
     var datasavetime = $('#input'+savetime).val();
     $('#edit'+savetime).hide();
     $('#parent'+savetime).show();
     $('#data'+savetime).text(datasavetime);
     $('#data'+savetime).addClass('animated flash');
     setTimeout(function(){$('#data'+savetime).removeClass('flash');},1000);
});

$('.deleteblock').on('click', function(){
     var block = $(this).attr('data-block');
     $('#tr'+block).addClass('animated bounceOutLeft');
     setTimeout(function(){$('#tr'+block).remove();},1000);
});

$('.canceledit').on('click', function(){
     $('.hideedittime').hide();
     $('.timeblock').show();   
});

/*-------------------------------------------------------------------------------------*/
      },
      error: function(){

      }
   });
}

const download = (path, filename) => {
    // Create a new link
    const anchor = document.createElement('a');
    anchor.href = path;
    anchor.download = filename;

    // Append to the DOM
    document.body.appendChild(anchor);

    // Trigger `click` event
    anchor.click();

    // Remove element from DOM
    document.body.removeChild(anchor);
}; 


function SaveToPDF(){
   
   $('#loadWait').show();
   // HTML
   var html = $('#resulTable').html();
   $('#TransformTable').html(html);
   // Remover todo Lo que no sirve
   $('#TransformTable button').remove();
   $('#TransformTable .hideedittime').remove();
   $('#TransformTable .btn-group').remove();
   $('#TransformTable table').removeClass('table table-bordered');
   $('#TransformTable tr').attr('style', 'border:1px solid #000');
   $('#TransformTable th').attr('style', 'border:1px solid #000;font-size:9px;text-align:center;padding:2%;');
   $('#TransformTable strong').attr('style', 'font-size:5px;text-align:center;').parent().prepend('<br>');
   $('#TransformTable td').attr('style', 'border:1px solid #000;text-align:center;');
   $('#TransformTable label').attr('style', 'width: 100%;float: left;');
   var parser = $('#TransformTable').html();
   // Titulo del Horario
   var title = $('#horarioTitleName').val();
   // Datos
   var dataline = 'pro=pdf&html='+parser+'&title='+title;
   $.ajax({
      url: 'ajax.php',
      type: 'POST',
      data: dataline,
      success: function(response){
            download(response, title+'.pdf');
            setTimeout(function(){deletePDF();},5000);
            $('#loadWait').hide();
      }
   });

}

function Ragain(){
   location.reload();
}

function deletePDF(){
   $.ajax({
      url: 'ajax.php',
      type: 'POST',
      data: 'pro=delete',
      success: function(response){
      }
   }); 
}