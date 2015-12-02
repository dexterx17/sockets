  $(document).ready(function() {
      console.log('Connecting...');
      Server = new FancyWebSocket('ws://190.15.141.99:8180');


      //Let the user know we're connected
      Server.bind('open', function() {
        console.log( "Connected." );
      });
      //OH NOES! Disconnection occurred.
      Server.bind('close', function( data ) {
     //   alert(data);
        console.log( "Disconnected." );
      });
      //console.log any messages sent from server
      Server.bind('message', function( payload ) {
        var res = jQuery.parseJSON(payload);
        console.log( res );

         if(typeof res.destino==="undefined"){
           switch(res.cliente){
              case "silla":{
               $('#silla').addClass('active');
              // $('#silla').height('200px');
                
              }break;
              case "falcon":{
               
                
              }break;
              case "brazo":{
               
              }break;
            case "admin":{
               
              }break;
              
            }
        }else
        {
        switch(res.destino){
          case "silla":{
           $('#silla').append('origen: '+res.origen+' mensaje: '+res.texto);
           //$('#falcon').hide();
           //$('#brazo').hide();
           //$('#admin').hide();
          }break;
          case "falcon":{
           $('#falcon').append('origen: '+res.origen+' mensaje: '+res.texto);
            //$('#silla').hide();
           //$('#brazo').hide();
           //$('#admin').hide();
            
          }break;
          case "brazo":{
            
           $('#brazo').append('origen: '+res.origen+' mensaje: '+res.texto);
            //$('#falcon').hide();
           //$('#silla').hide();
           //$('#admin').hide();
          }break;
        case "admin":{
           $('#admin').append('origen: '+res.origen+' mensaje: '+res.texto);
            //$('#falcon').hide();
           //$('#brazo').hide();
           //$('#silla').hide();
          }break;
          
        }

      }

         if(typeof res.tipo==="desconexion"){
          //
        }

       
      });

      Server.connect();

////Cuando se selecciona un cliente
$('.seleccionar').click(function(){
        $('.destino').html('');
        $('#cliente').html('');
      var lista =document.getElementById('seleccion');

      var indice = lista.selectedIndex;
      var opcion = lista.options[indice];

      var texto= opcion.text;
      var valor=opcion.value;
      //alert(valor);


        if(valor === "silla"){
            
          $('.destino').append('<option value="falcon">Falcon</option>');
          $('.destino').append('<option value="brazo">Brazo</option>');
          $('.destino').append('<option value="admin">Administrador</option>');
          $('#cliente').append(valor);
        }
        
        if(valor === "falcon"){
            
          $('.destino').append('<option value="silla">Silla</option>');
          $('.destino').append('<option value="brazo">Brazo</option>');
          $('.destino').append('<option value="admin">Administrador</option>');
          $('#cliente').append(valor);
            
        }
        
                 if(valor === "brazo"){
            
          $('.destino').append('<option value="silla">Silla</option>');
          $('.destino').append('<option value="falcon">Falcon</option>');
          $('.destino').append('<option value="admin">Administrador</option>');
          $('#cliente').append(valor);
            
        }
        
        if(valor === "admin"){
            
          $('.destino').append('<option value="silla">Silla</option>');
          $('.destino').append('<option value="falcon">Falcon</option>');
          $('.destino').append('<option value="brazo">Brazo</option>');
          $('#cliente').append(valor);
            
        }

        //Envio CLiente

        var mensaje = {'cliente':valor};
        Server.send('message', JSON.stringify(mensaje) );

      });

//Cuando se envia el mensaje


      $('.button').click(function(){
      //Datos de origen
      var lista =document.getElementById('seleccion');
      var indice = lista.selectedIndex;
      var opcion = lista.options[indice];
      var origen=opcion.value;


      ///Datos de destino

      var lista =document.getElementById('destino');
      var indice = lista.selectedIndex;
      var opcion = lista.options[indice];
      var destino=opcion.value;

      //texto enviado 
      var texto= $('.texto1').val();

        var mensaje = {'origen':origen, 'destino':destino, 'texto':texto};

        Server.send('message', JSON.stringify(mensaje) );

      });


      function enviar_mensaje(array){

        Server.send('message', JSON.stringify(array) );

      }

      //almacenamiento Clientes conectados




});