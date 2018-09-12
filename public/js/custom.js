jQuery(function() {

   console.log('alert');

   $('#createCategoryBtn').click(function() {
       var name = $('#name').val()

       $.ajax({
           url: '/admin/category',
           method: 'POST',
           dataType: 'json',

       });
   });
});
