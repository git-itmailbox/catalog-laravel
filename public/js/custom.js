jQuery(function() {

   console.log('alert');

   $('#createCategoryBtn').click(function() {
       var msgErr = $('#message-error')

       var name = $('#name').val()
       var csrf_token = document.head.querySelector('meta[name="csrf-token"]').content;

       msgErr.hide()
       msgErr.html("")
       $.ajax({
           url: '/admin/category',
           method: 'POST',
           dataType: 'json',
            data: {
                name: name,
                _token: csrf_token

            }
       })
       .done(function(data){
           if(data.status == 'ok')
           {
               location.reload()
           }
       })
           .fail(function(error, textStatus){
               var response = JSON.parse(error.responseText)
               var ul = $('<ul/>').append(error)

               _.forEach(response.errors, function(error) {
                   var li = $('<li/>').append(error)
                   ul.append(error)
               })

               msgErr.append(ul).show()
               console.log(response.errors)
           })
   });
});
