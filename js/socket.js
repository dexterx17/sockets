  $(document).ready(function() {
      console.log('Connecting...');
      Server = new FancyWebSocket('ws://192.168.0.71:9300');


      //Let the user know we're connected
      Server.bind('open', function() {
        console.log( "Connected." );
      });
      //OH NOES! Disconnection occurred.
      Server.bind('close', function( data ) {
        console.log( "Disconnected." );
      });
      //console.log any messages sent from server
      Server.bind('message', function( payload ) {
        var res = jQuery.parseJSON(payload);
        console.log( res );

/*
        var texto= $('.texto1').val();
        var origen= $('.origen').val();
        var destino= $('.destino').val();

        var mensaje = {'origen':origen, 'destino':destino, 'texto':texto};

        Server.send('message', JSON.stringify(mensaje) );
       // console.log('origen: '+res.origen+' mensaje: '+res.texto);
       */

        if(typeof res.destino==="undefined"){
          var $cliente = ('#cliente ').html();
          if ($cliente ===res.destino){
            $('#'+$cliente).append('origen: '+res.origen+' mensaje: '+res.texto);
          }
        }

        else
        {
        // console.log('origen: '+res.origen+' mensaje: '+res.texto);


        }

       
      });

      Server.connect();

////Cuando se selecciona un cliente
$('.seleccionar').click(function(){
        $('.destino').html('');
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
          
        }
        
        if(valor === "falcon"){
            
          $('.destino').append('<option value="silla">Silla</option>');
          $('.destino').append('<option value="brazo">Brazo</option>');
          $('.destino').append('<option value="admin">Administrador</option>');
            
        }
        
                 if(valor === "brazo"){
            
          $('.destino').append('<option value="silla">Silla</option>');
          $('.destino').append('<option value="falcon">Falcon</option>');
          $('.destino').append('<option value="admin">Administrador</option>');
            
        }
        
        if(valor === "admin"){
            
          $('.destino').append('<option value="silla">Silla</option>');
          $('.destino').append('<option value="falcon">Falcon</option>');
          $('.destino').append('<option value="brazo">Brazo</option>');
            
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

      



});
 