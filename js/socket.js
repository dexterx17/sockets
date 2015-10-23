  $(document).ready(function() {
      console.log('Connecting...');
      Server = new FancyWebSocket('ws://192.168.1.8:9300');


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
        if(typeof res.destino==="undefined"){

        }else
        {
        switch(res.destino){
          case "silla":{
           $('#silla').append('origen: '+res.origen+' mensaje: '+res.texto);
          }break;
          case "falcon":{
           $('#falcon').append('origen: '+res.origen+' mensaje: '+res.texto);
            
          }break;
          case "brazo":{
            
           $('#brazo').append('origen: '+res.origen+' mensaje: '+res.texto);
   |       }break;
          
        }

        }
      });

      Server.connect();

      $('.button').click(function(){
        var texto= $('.texto1').val();
        var origen= $('.origen').val();
        var destino= $('.destino').val();

        var mensaje = {'origen':origen, 'destino':destino, 'texto':texto};

        Server.send('message', JSON.stringify(mensaje) );

      });

});
 