  $(document).ready(function() {

  

      console.log('Connecting...');
      Server = new FancyWebSocket('ws://192.168.1.102:9300');

      //Let the user know we're connected
      Server.bind('open', function() {
        console.log( "Connected." );
    //  var mensaje = {'cliente':'php','ip':'192.168.1.106','datos':'05050','estado':'conexion','tiempo':'0.14'  };
      var mensaje = {'cliente':'php'};
        Server.send('message', JSON.stringify(mensaje) );

      });


      //OH NOES! Disconnection occurred.
      Server.bind('close', function( data ) {
     //   alert(data);

      
        console.log( "Disconnected." );
      });


      //console.log any messages sent from server
      Server.bind('message', function( payload ) {
        var res = jQuery.parseJSON(payload);
        

        //console.log(res.origen);
        if(typeof res!="null"){
        console.log( res );
       
 
          
    }
    

//ENVIO DATOS CLIENTE SERVIDOR CLIENTE
       if(typeof res.resultado!="undefined"){
              
       $("#txtconsola").append(res.resultado+'\n');
       }


           if(typeof res.val1!="undefined"){
              SendMessage('Q1','moverQ1',res.val1);
       
       }

        $('#interfaz1').val("");
        $('#resultado1').val("");
        $('#status1').val("");
        $('#interfaz2').val("");
        $('#resultado2').val("");
        $('#status2').val("");   
        $('#interfaz').val("");
        $('#resultado').val("");
        $('#status').val("");
        $('#interfaz3').val("");
        $('#resultado3').val("");
        $('#status3').val("");

       if (payload!="null"){

        $('#consola').parent().addClass('panel-success');
           $('#consola').append(' <BR />');
        $('#consola').append(payload);
      
        }
        

        $('#streaming').parent().addClass('panel-success');    
        $('#admin').parent().addClass('panel-success');    

      if( res.cliente==="controlador"){            
        $('#cliente').html('');    
        $('#cliente').parent().addClass('panel-success');
        $('#cliente').append(res.cliente );
       }



  if( res.origen ==="controlador"){    
        var fechaActual = new Date();
        var m = fechaActual.getMilliseconds();
        $('#tiempo').html('');
        $('#tiempo').parent().addClass('panel-success');
        $('#tiempo').append(m);  
     
        $('#datos').html('');
        $('#datos').parent().addClass('panel-success');
        $('#datos').append(res.val_silla);       
        $('#estado').html('');
        $('#estado').parent().addClass('panel-success');
        $('#estado').append("Conexion");
        $('#motor').html('');
        $('#motor').parent().addClass('panel-success');
        $('#motor').append("Motor1 = " + res.motor1)
        $('#motor').append(' <BR />');
        $('#motor').append("Motor2 = " + res.motor2);
        $('#motor').append(' <BR />');
        $('#motor').append("Motor3 = " + res.motor3);
        $('#motor').append(' <BR />');
        $('#motor').append("Motor4 = " + res.motor4);
        $('#motor').append(' <BR />');
        $('#motor').append("Motor5 = " + res.motor5);
        $('#motor').append(' <BR />');
        $('#motor').append("Motor6 = " + res.motor6);
        $('#motor').append(' <BR />');
        $('#motor').append("Motor7 = " + res.motor7);
        $('#motor').append(' <BR />');
        $('#motor').append("Motor8 = " + res.motor8);
        $('#motor').append(' <BR />');
        $('#motor').append("Motor9 = " + res.motor9);
      
}
     
      if( res.cliente==="plataforma"){            
        $('#cliente1').html('');    
        $('#cliente1').parent().addClass('panel-success');
        $('#cliente1').append(res.cliente );
        var endTime = new Date();
        }


    
      if( res.origen ==="plataforma"){    

  
        $('#datos1').html('');        
        $('#estado1').html('');
        $('#estado1').parent().addClass('panel-success');
        $('#estado1').append(res.estado);
        $('#ip1').html('');
        $('#ip1').parent().addClass('panel-success');
        $('#ip1').append(res.ip);
        $('#estado1').html('');
        $('#estado1').parent().addClass('panel-success');
        $('#estado1').append("Conexion");
        $('#motor1').html('');
        $('#motor1').parent().addClass('panel-success');
        $('#motor1').append("Motor1 = " + res.mot1)
        $('#motor1').append(' <BR />');
        $('#motor1').append("Motor2 = " + res.mot2);
        $('#motor1').append(' <BR />');
        $('#motor1').append("Motor3 = " + res.mot3);
        $('#motor1').append(' <BR />');
        $('#motor1').append("Motor4 = " + res.mot4);
        $('#motor1').append(' <BR />');
        $('#motor1').append("Motor5 = " + res.mot5);
        $('#motor1').append(' <BR />');
        $('#motor1').append("Motor6 = " + res.mot6);
        $('#motor1').append(' <BR />');
        $('#motor1').append("Motor7 = " + res.mot7);
        $('#motor1').append(' <BR />');
        $('#motor1').append("Motor8 = " + res.mot8);
        $('#motor1').append(' <BR />');
        $('#motor1').append("Motor9 = " + res.mot9);
            
        SendMessage('Q1','moverQ1',res.val1);
    }

 
//ESTADO DE DISPOSITIVOS

     if(typeof res.monitor!="undefined"){
        $('#dispositivos').parent().addClass('panel-success');


            $('#interfaz1').val(res.monitor[0].interfaz);
              $('#resultado1').val(res.monitor[0].resultado);
              $('#status1').val(res.monitor[0].commandstatus);


            $('#interfaz2').val(res.monitor[1].interfaz);
              $('#resultado2').val(res.monitor[1].resultado);
              $('#status2').val(res.monitor[1].commandstatus);

            $('#interfaz').val(res.monitor[2].interfaz);
              $('#resultado').val(res.monitor[2].resultado);
              $('#status').val(res.monitor[2].commandstatus);
   
              $('#interfaz3').val(res.monitor[3].interfaz);
              $('#resultado3').val(res.monitor[3].resultado);
              $('#status3').val(res.monitor[3].commandstatus);


    }

  $('.moverQ1').click(function(e){

    //e.preventDefault();
      var mensaje = {'origen':'php', 'destino':'php','val1':100, 'val2':'100'};
     Server.send('message', JSON.stringify(mensaje) );
   // SendMessage('Q1','moverQ1',100);


 });




       
 });


//CONSOLA DE ADMINISTRACION
       
        $("#btnConectar").click(function(){
   //      if( res.cliente==="consola"){  
    

        var mensaje = {'origen':'php', 'destino':'consola','accion':'conectar', 'ventana':'uno'};
        Server.send('message', JSON.stringify(mensaje) );
          $('#tiempo').html('');
        $('#tiempo').parent().addClass('panel-success');
        $('#tiempo').append(i);  

  
     });

        $("#btnejecutar").click(function(){
  
            $('#txtconsola').html('');   
       var texto= $('#txtenvio').val();
        var mensaje = {'origen':'php', 'destino':'consola','ventana':'uno', 'comando':texto};
        Server.send('message', JSON.stringify(mensaje) );

         
     });

//GRAFICA 3D


  // $('.moverQ1').click(function(e){

   // e.preventDefault();
    //  var mensaje = {'origen':'php', 'destino':'php','val1':'100', 'val2':'100'};
    // Server.send('message', JSON.stringify(mensaje) );
    //SendMessage('Q1','moverQ1',100);


 // });



  $('.moverQ2').click(function(e){
    e.preventDefault();
    SendMessage('Q2','moverQ2',100);
  });




      Server.connect();
});
