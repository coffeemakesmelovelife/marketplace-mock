$(document).ready(function() {

    var restful = {
        init: function(elem) {
            elem.on('click', function(e) {
                self=$(this);
                e.preventDefault();
    
                if(confirm('Are you sure?')) {
                    alert(self.data('id'));
                  $.ajax({
                    url: "/admin/listings/"+self.data('id'),
                    method: 'DELETE',
                    success: function(data) {
                      self.parent().parent().html('Deleted.');
                      console.log(data);
                    },
                    error: function(data) {
                        alert("Error while deleting.");
                        console.log(data);
                    }
                  });
                };
            })
        },
    }
    
    restful.init($('.delete-listing'));
    });