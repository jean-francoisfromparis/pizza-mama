$(document).ready(function () {
  console.log('test');
  $('#user_submit').on('click',function()
  {
      if( $('#user_pseudo').val().length === 0 ) {
          alert('Pour recevoir votre commande un pseudo est cependant nécessaire.');
      }
  })
    })